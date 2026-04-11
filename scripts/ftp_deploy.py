import ftplib
import os
import sys

HOST = os.environ['FTP_HOST']
USER = os.environ['FTP_USER']
PASS = os.environ['FTP_PASS']

LOCAL_DIR = './wp-content/themes/'
REMOTE_DIR = 'wp-content/themes/'

SKIP = {'.git', '.DS_Store', 'node_modules', '__pycache__'}

def ensure_remote_dir(ftp, path):
    parts = path.strip('/').split('/')
    current = ''
    for part in parts:
        current = current + '/' + part if current else part
        try:
            ftp.mkd(current)
        except ftplib.error_perm:
            pass

def upload_dir(ftp, local_path, remote_path):
    ensure_remote_dir(ftp, remote_path)
    for item in sorted(os.listdir(local_path)):
        if item in SKIP:
            continue
        local_item = os.path.join(local_path, item)
        remote_item = remote_path + '/' + item
        if os.path.isdir(local_item):
            upload_dir(ftp, local_item, remote_item)
        else:
            with open(local_item, 'rb') as f:
                ftp.storbinary(f'STOR {remote_item}', f)
            print(f'  ✅ {remote_item}')

print(f'🔌 FTP 연결 중...')
ftp = ftplib.FTP()
ftp.connect(HOST, 21, timeout=30)
ftp.login(USER, PASS)
ftp.set_pasv(True)
print('✅ 로그인 성공')

upload_dir(ftp, LOCAL_DIR, REMOTE_DIR)

ftp.quit()
print('🎉 배포 완료!')
