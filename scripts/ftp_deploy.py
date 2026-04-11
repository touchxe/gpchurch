import ftplib
import os
import sys

FTP_HOST = os.environ['FTP_HOST']
FTP_USER = os.environ['FTP_USER']
FTP_PASS = os.environ['FTP_PASS']

LOCAL_THEMES = './wp-content/themes'
REMOTE_THEMES = 'wp-content/themes'

def ensure_remote_dir(ftp, path):
    """원격 디렉토리가 없으면 생성 (재귀)"""
    dirs = path.split('/')
    current = ''
    for d in dirs:
        current = f"{current}/{d}" if current else d
        try:
            ftp.mkd(current)
        except ftplib.error_perm:
            pass  # 이미 존재

def upload_dir(ftp, local_dir, remote_dir):
    """로컬 디렉토리를 FTP 서버에 재귀적으로 업로드"""
    ensure_remote_dir(ftp, remote_dir)

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
                    print(f"  OK {remote_path}")
                except Exception as e:
                    print(f"  FAIL {remote_path}: {e}")
                    sys.exit(1)

def main():
    print("FTP connecting...")
    ftp = ftplib.FTP()
    ftp.connect(FTP_HOST, 21, timeout=30)
    resp = ftp.login(FTP_USER, FTP_PASS)
    print(f"  Login: {resp}")

    themes = ['gapyeong-church', 'gapyeong-church-child']
    
    for theme in themes:
        local_dir = os.path.join(LOCAL_THEMES, theme)
        remote_dir = f"{REMOTE_THEMES}/{theme}"

        if not os.path.isdir(local_dir):
            print(f"SKIP {theme} (not found locally)")
            continue

        file_count = sum(len(files) for _, _, files in os.walk(local_dir))
        print(f"\nDeploy: {theme} ({file_count} files)")
        upload_dir(ftp, local_dir, remote_dir)
        print(f"  Done: {theme}")

    ftp.quit()
    print("\nAll done!")

if __name__ == '__main__':
    main()
