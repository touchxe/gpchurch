#!/usr/bin/env python3
"""
가평교회 서버 전체 파일 다운로드 스크립트
FTP → ~/gpchurch_server/
"""

import ftplib
import os
import stat

FTP_HOST = "gpchurch.mycafe24.com"
FTP_USER = "gpchurch"
FTP_PASS = "rkvudryghl!A!"
REMOTE_ROOT = "/www"
LOCAL_ROOT = os.path.expanduser("~/gpchurch_server")

SKIP_PATHS = [
    "wp-content/cache",
    "wp-content/wflogs",
    "wp-content/upgrade",
]

downloaded = 0
failed = 0

def is_dir(ftp, name):
    """디렉토리인지 확인"""
    try:
        ftp.cwd(name)
        ftp.cwd("..")
        return True
    except:
        return False

def list_dir(ftp, remote_path):
    """디렉토리 목록 반환 (이름, 타입)"""
    entries = []
    raw = []
    
    try:
        ftp.dir(remote_path, raw.append)
    except Exception as e:
        print(f"  ⚠️ 목록 실패: {remote_path} - {e}")
        return entries
    
    for line in raw:
        parts = line.split(None, 8)
        if len(parts) < 9:
            continue
        name = parts[8]
        if name in ('.', '..'):
            continue
        kind = 'dir' if line.startswith('d') else 'file'
        entries.append((name, kind))
    
    return entries

def download_dir(ftp, remote_path, local_path):
    global downloaded, failed
    os.makedirs(local_path, exist_ok=True)
    
    entries = list_dir(ftp, remote_path)
    
    for name, kind in entries:
        remote_item = f"{remote_path}/{name}"
        local_item = os.path.join(local_path, name)
        rel_path = remote_item.replace(f"{REMOTE_ROOT}/", "")
        
        if any(rel_path.startswith(skip) for skip in SKIP_PATHS):
            print(f"  ⏭️  스킵: {rel_path}")
            continue
        
        if kind == 'dir':
            print(f"📁 {rel_path}/")
            download_dir(ftp, remote_item, local_item)
        else:
            if os.path.exists(local_item):
                downloaded += 1
                continue
            try:
                print(f"  ⬇️  {name}", end=" ", flush=True)
                with open(local_item, 'wb') as f:
                    ftp.retrbinary(f"RETR {remote_item}", f.write)
                size = os.path.getsize(local_item)
                print(f"({size//1024}KB) ✓")
                downloaded += 1
            except Exception as e:
                print(f"❌ {e}")
                failed += 1

def main():
    print(f"🔌 FTP 접속 중: {FTP_HOST}")
    print(f"📂 저장 위치: {LOCAL_ROOT}")
    print()
    
    ftp = ftplib.FTP()
    ftp.connect(FTP_HOST, 21, timeout=60)
    ftp.login(FTP_USER, FTP_PASS)
    ftp.set_pasv(True)
    # 인코딩 설정
    ftp.encoding = 'latin-1'
    print(f"✅ 접속 성공!\n")
    
    download_dir(ftp, REMOTE_ROOT, LOCAL_ROOT)
    
    ftp.quit()
    print(f"\n✅ 완료! 다운로드: {downloaded}개 / 실패: {failed}개")
    print(f"📂 위치: {LOCAL_ROOT}")

if __name__ == "__main__":
    main()
