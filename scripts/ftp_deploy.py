import ftplib
import os
import sys

FTP_HOST = os.environ['FTP_HOST']
FTP_USER = os.environ['FTP_USER']
FTP_PASS = os.environ['FTP_PASS']

LOCAL_THEMES = './wp-content/themes'
REMOTE_THEMES = 'wp-content/themes'

def upload_dir(ftp, local_dir, remote_dir):
    """로컬 디렉토리를 FTP 서버에 재귀적으로 업로드"""
    # 원격 디렉토리 생성 시도
    try:
        ftp.mkd(remote_dir)
        print(f"  📁 생성: {remote_dir}")
    except ftplib.error_perm:
        pass  # 이미 존재

    for item in sorted(os.listdir(local_dir)):
        local_path = os.path.join(local_dir, item)
        remote_path = f"{remote_dir}/{item}"

        # 제외 항목
        if item in ['.git', '.DS_Store', 'node_modules', '.gitignore']:
            continue

        if os.path.isdir(local_path):
            upload_dir(ftp, local_path, remote_path)
        else:
            with open(local_path, 'rb') as f:
                try:
                    ftp.storbinary(f'STOR {remote_path}', f)
                    print(f"  ✅ {remote_path}")
                except Exception as e:
                    print(f"  ❌ {remote_path}: {e}")

def main():
    print("🔌 FTP 접속 중...")
    ftp = ftplib.FTP()
    ftp.connect(FTP_HOST, 21, timeout=30)
    ftp.login(FTP_USER, FTP_PASS)
    ftp.encoding = 'utf-8'
    print(f"  PWD: {ftp.pwd()}")

    themes = ['gapyeong-church', 'gapyeong-church-child']
    
    for theme in themes:
        local_dir = os.path.join(LOCAL_THEMES, theme)
        remote_dir = f"{REMOTE_THEMES}/{theme}"

        if not os.path.isdir(local_dir):
            print(f"⏭️  {theme} 로컬에 없음, 스킵")
            continue

        print(f"\n🚀 배포 중: {theme}")
        upload_dir(ftp, local_dir, remote_dir)

    ftp.quit()
    print("\n✅ 배포 완료!")

if __name__ == '__main__':
    main()
