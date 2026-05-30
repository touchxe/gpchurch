import ftplib
import urllib.request
import os
import time

FTP_HOST = "gpchurch.mycafe24.com"
FTP_USER = "gpchurch"
FTP_PASS = "rkvudryghl!A!"
REMOTE_ROOT = "/www"

PHP_SCRIPT = """<?php
$output = shell_exec("mysqldump -h localhost -u gpchurch -prkvudryghl\!A\! gpchurch > db_backup.sql 2>&1");
echo "DONE";
?>"""

def main():
    print("🔌 FTP 접속...")
    ftp = ftplib.FTP()
    ftp.connect(FTP_HOST, 21, timeout=60)
    ftp.login(FTP_USER, FTP_PASS)
    ftp.set_pasv(True)
    
    print("📝 덤프 스크립트 업로드 중...")
    with open("temp_dump.php", "w") as f:
        f.write(PHP_SCRIPT)
    
    with open("temp_dump.php", "rb") as f:
        ftp.storbinary(f"STOR {REMOTE_ROOT}/temp_dump.php", f)
        
    print("🚀 DB 백업 실행 중 (서버에서 실행)...")
    try:
        urllib.request.urlopen("https://sdagp.kr/temp_dump.php", timeout=30).read()
    except Exception as e:
        print(f"HTTP 호출 경고 (진행 계속함): {e}")
        
    time.sleep(3) # Wait just in case
    
    print("⬇️ 백업된 SQL 파일 다운로드 중...")
    local_sql = "gpchurch_live_db.sql"
    try:
        with open(local_sql, "wb") as f:
            ftp.retrbinary(f"RETR {REMOTE_ROOT}/db_backup.sql", f.write)
        print(f"✅ DB 다운로드 성공: {local_sql}")
    except Exception as e:
        print(f"❌ SQL 다운로드 실패: {e}")
        
    print("🧹 임시 파일 정리 중...")
    try:
        ftp.delete(f"{REMOTE_ROOT}/temp_dump.php")
        ftp.delete(f"{REMOTE_ROOT}/db_backup.sql")
    except:
        pass
        
    ftp.quit()
    if os.path.exists("temp_dump.php"):
        os.remove("temp_dump.php")
    
    print("🎉 DB 동기화 준비 완료!")

if __name__ == "__main__":
    main()
