import ftplib
import os

FTP_HOST = "gpchurch.mycafe24.com"
FTP_USER = "gpchurch"
FTP_PASS = "rkvudryghl!A!"

TARGET_DIRS = [
    "wp-content/themes/gapyeong-church",
    "wp-content/themes/gapyeong-church-child",
    "wp-content/plugins/kboard"
]

def download_ftp_dir(ftp, remote_dir, local_dir):
    os.makedirs(local_dir, exist_ok=True)
    try:
        items = ftp.nlst(remote_dir)
    except ftplib.error_perm:
        return

    for item in items:
        # cafe24 nlst returns full paths or just names depending on the server
        # handle both cases safely
        item_name = os.path.basename(item)
        if item_name in ['.', '..']: continue
        
        remote_path = f"{remote_dir}/{item_name}"
        local_path = os.path.join(local_dir, item_name)
        
        try:
            # Try cwd to check if it's a directory
            ftp.cwd(remote_path)
            ftp.cwd("/")
            print(f"📁 디렉토리 탐색 중: {remote_path}")
            download_ftp_dir(ftp, remote_path, local_path)
        except ftplib.error_perm:
            # It's a file
            print(f"⬇️ 다운로드 중: {remote_path} -> {local_path}")
            try:
                with open(local_path, 'wb') as f:
                    ftp.retrbinary(f"RETR {remote_path}", f.write)
            except Exception as e:
                print(f"❌ 다운로드 실패: {remote_path} ({e})")

def main():
    print("🔌 FTP 서버 연결 중...")
    ftp = ftplib.FTP()
    ftp.connect(FTP_HOST, 21, timeout=60)
    ftp.login(FTP_USER, FTP_PASS)
    ftp.set_pasv(True)
    ftp.encoding = 'utf-8' # or latin-1 if fails
    print("✅ FTP 서버 연결 성공!")

    for target in TARGET_DIRS:
        remote_path = f"/www/{target}"
        local_path = os.path.join(os.getcwd(), target)
        print(f"\n🔄 동기화 시작: {remote_path}")
        download_ftp_dir(ftp, remote_path, local_path)
    
    ftp.quit()
    print("\n🎉 모든 다운로드가 완료되었습니다. 로컬 파일이 최신화되었습니다!")

if __name__ == "__main__":
    main()
