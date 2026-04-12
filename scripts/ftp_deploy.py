"""
Cafe24 SFTP 배포 스크립트
- OpenSSH sftp 명령어 사용 (paramiko 대신)
- 배치 파일 생성 후 실행
"""
import os
import subprocess
import sys

SSH_KEY = os.path.expanduser('~/.ssh/deploy_key')
SSH_HOST = os.environ['FTP_HOST']
SSH_USER = os.environ['FTP_USER']

LOCAL_THEMES = './wp-content/themes'
REMOTE_BASE = 'www/wp-content/themes'

def generate_batch(local_dir, remote_dir):
    """sftp 배치 명령어 생성"""
    commands = []
    
    for root, dirs, files in os.walk(local_dir):
        # 제외
        dirs[:] = [d for d in dirs if d not in ['.git', 'node_modules']]
        
        # 상대경로 계산
        rel = os.path.relpath(root, local_dir)
        if rel == '.':
            remote_path = remote_dir
        else:
            remote_path = f"{remote_dir}/{rel}"
        
        # 디렉토리 생성 (실패해도 계속 - 이미 존재할 수 있음)
        commands.append(f"-mkdir {remote_path}")
        
        # 파일 업로드
        for fname in sorted(files):
            if fname in ['.DS_Store', '.gitignore']:
                continue
            local_file = os.path.join(root, fname)
            commands.append(f"put {local_file} {remote_path}/{fname}")
    
    return commands

def main():
    themes = ['gapyeong-church', 'gapyeong-church-child']
    all_commands = []
    
    for theme in themes:
        local_dir = os.path.join(LOCAL_THEMES, theme)
        remote_dir = f"{REMOTE_BASE}/{theme}"
        
        if not os.path.isdir(local_dir):
            print(f"SKIP: {theme}")
            continue
        
        file_count = sum(len(f) for _, _, f in os.walk(local_dir))
        print(f"Deploy: {theme} ({file_count} files)")
        all_commands.extend(generate_batch(local_dir, remote_dir))
    
    all_commands.append("bye")
    
    # 배치 파일 생성
    batch_file = '/tmp/sftp_batch.txt'
    with open(batch_file, 'w') as f:
        f.write('\n'.join(all_commands))
    
    print(f"\n총 {len(all_commands)-1}개 명령어")
    print("--- 배치 내용 (처음 20줄) ---")
    for cmd in all_commands[:20]:
        print(f"  {cmd}")
    if len(all_commands) > 20:
        print(f"  ... ({len(all_commands)-20}개 더)")
    
    # sftp 실행
    print("\nSFTP 실행 중...")
    result = subprocess.run([
        'sftp',
        '-b', batch_file,
        '-i', SSH_KEY,
        '-o', 'StrictHostKeyChecking=no',
        f'{SSH_USER}@{SSH_HOST}'
    ], capture_output=True, text=True)
    
    print("STDOUT:", result.stdout[-2000:] if len(result.stdout) > 2000 else result.stdout)
    if result.stderr:
        print("STDERR:", result.stderr[-1000:] if len(result.stderr) > 1000 else result.stderr)
    
    if result.returncode != 0:
        print(f"\n❌ 실패 (exit code: {result.returncode})")
        sys.exit(1)
    else:
        print("\n✅ 배포 완료!")

if __name__ == '__main__':
    main()
