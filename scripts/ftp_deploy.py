import ftplib
import os
import sys

FTP_HOST = os.environ['FTP_HOST']
FTP_USER = os.environ['FTP_USER']
FTP_PASS = os.environ['FTP_PASS']

LOCAL_THEMES = './wp-content/themes'
REMOTE_THEMES = 'wp-content/themes'

def ensure_and_cd(ftp, path):
    """경로의 각 디렉토리로 순차적으로 cwd, 없으면 생성"""
    parts = path.split('/')
    for part in parts:
        try:
            ftp.cwd(part)
        except ftplib.error_perm:
            try:
                ftp.mkd(part)
                ftp.cwd(part)
            except ftplib.error_perm as e:
                print(f"  FAIL mkdir/cwd {part}: {e}")
                sys.exit(1)

def upload_dir(ftp, local_dir, start_dir):
    """cwd로 이동 후 파일명만으로 업로드"""
    for root, dirs, files in os.walk(local_dir):
        # .git, node_modules 등 제외
        dirs[:] = [d for d in dirs if d not in ['.git', 'node_modules']]
        
        # 로컬 상대경로 계산
        rel_path = os.path.relpath(root, local_dir)
        
        # FTP 홈(~)으로 돌아가기
        ftp.cwd('~')
        
        # 대상 디렉토리로 이동
        if rel_path == '.':
            target = f"{REMOTE_THEMES}/{start_dir}"
        else:
            target = f"{REMOTE_THEMES}/{start_dir}/{rel_path}"
        
        ensure_and_cd(ftp, target)
        
        # 파일 업로드 (파일명만 사용)
        for fname in sorted(files):
            if fname in ['.DS_Store', '.gitignore']:
                continue
            local_file = os.path.join(root, fname)
            with open(local_file, 'rb') as f:
                try:
                    ftp.storbinary(f'STOR {fname}', f)
                    print(f"  OK {target}/{fname}")
                except Exception as e:
                    print(f"  FAIL {target}/{fname}: {e}")
                    sys.exit(1)

def main():
    print("FTP connecting...")
    ftp = ftplib.FTP()
    ftp.connect(FTP_HOST, 21, timeout=30)
    resp = ftp.login(FTP_USER, FTP_PASS)
    print(f"  Login OK")

    themes = ['gapyeong-church', 'gapyeong-church-child']
    
    for theme in themes:
        local_dir = os.path.join(LOCAL_THEMES, theme)

        if not os.path.isdir(local_dir):
            print(f"SKIP {theme}")
            continue

        file_count = sum(len(files) for _, _, files in os.walk(local_dir))
        print(f"\nDeploy: {theme} ({file_count} files)")
        upload_dir(ftp, local_dir, theme)
        print(f"  Done: {theme}")

    ftp.quit()
    print("\nAll done!")

if __name__ == '__main__':
    main()
