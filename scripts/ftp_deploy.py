"""
Cafe24 SFTP 배포 스크립트
- SSH Key 인증 + SFTP 서브시스템 사용
- 디렉토리 재귀 업로드
"""
import paramiko
import os
import sys
import stat

SSH_HOST = os.environ['FTP_HOST']
SSH_USER = os.environ['FTP_USER']
SSH_KEY_PATH = os.path.expanduser('~/.ssh/deploy_key')

LOCAL_THEMES = './wp-content/themes'
REMOTE_BASE = 'www/wp-content/themes'

def upload_dir(sftp, local_dir, remote_dir):
    """디렉토리 재귀 업로드"""
    # 원격 디렉토리 생성
    try:
        sftp.stat(remote_dir)
    except FileNotFoundError:
        print(f"  📁 mkdir: {remote_dir}")
        sftp.mkdir(remote_dir)

    for item in sorted(os.listdir(local_dir)):
        if item in ['.git', '.DS_Store', 'node_modules', '.gitignore']:
            continue

        local_path = os.path.join(local_dir, item)
        remote_path = f"{remote_dir}/{item}"

        if os.path.isdir(local_path):
            upload_dir(sftp, local_path, remote_path)
        else:
            sftp.put(local_path, remote_path)
            print(f"  ✅ {remote_path}")

def main():
    print("🔌 SFTP 접속 중...")
    
    # SSH 키 로드
    key = paramiko.RSAKey.from_private_key_file(SSH_KEY_PATH)
    print(f"  키 로드 완료: {SSH_KEY_PATH}")
    
    # SSH 연결
    transport = paramiko.Transport((SSH_HOST, 22))
    transport.connect(username=SSH_USER, pkey=key)
    sftp = paramiko.SFTPClient.from_transport(transport)
    print(f"  SFTP 연결 성공!")
    print(f"  PWD: {sftp.normalize('.')}")

    themes = ['gapyeong-church', 'gapyeong-church-child']
    
    for theme in themes:
        local_dir = os.path.join(LOCAL_THEMES, theme)
        remote_dir = f"{REMOTE_BASE}/{theme}"

        if not os.path.isdir(local_dir):
            print(f"⏭️  SKIP: {theme} (로컬에 없음)")
            continue

        file_count = sum(len(files) for _, _, files in os.walk(local_dir))
        print(f"\n🚀 배포: {theme} ({file_count} files)")
        upload_dir(sftp, local_dir, remote_dir)
        print(f"  ✅ 완료: {theme}")

    sftp.close()
    transport.close()
    print("\n🎉 전체 배포 완료!")

if __name__ == '__main__':
    main()
