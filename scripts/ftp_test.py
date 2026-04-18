"""
Cafe24 FTP 기능 테스트 - GitHub Actions에서 실행
어떤 명령이 되고 안 되는지 전부 확인
"""
import ftplib
import os
import io

FTP_HOST = os.environ['FTP_HOST']
FTP_USER = os.environ['FTP_USER']
FTP_PASS = os.environ['FTP_PASS']

def test(name, func):
    try:
        result = func()
        print(f"  PASS {name}: {result}")
        return True
    except Exception as e:
        print(f"  FAIL {name}: {e}")
        return False

def main():
    ftp = ftplib.FTP()
    ftp.set_debuglevel(0)

    print("=== 1. 연결 테스트 ===")
    test("connect", lambda: ftp.connect(FTP_HOST, 21, timeout=30))
    test("login", lambda: ftp.login(FTP_USER, FTP_PASS))

    print("\n=== 2. 기본 명령 테스트 ===")
    test("PWD", lambda: ftp.pwd())
    test("SYST", lambda: ftp.sendcmd('SYST'))
    test("FEAT", lambda: ftp.sendcmd('FEAT'))
    test("TYPE I", lambda: ftp.sendcmd('TYPE I'))
    test("PASV", lambda: ftp.sendcmd('PASV'))
    test("NOOP", lambda: ftp.voidcmd('NOOP'))

    print("\n=== 3. 디렉토리 탐색 테스트 ===")
    # NLST (파일목록) 테스트
    for path in ['', '.', '/', '~', 'wp-content', '/www', '/www/wp-content']:
        test(f"NLST '{path}'", lambda p=path: ftp.nlst(p) if p else ftp.nlst())

    # CWD 테스트
    for path in ['/', '/www', '.', 'wp-content', '/www/wp-content', 
                  '/www/wp-content/themes', '/www/wp-content/themes/gapyeong-church',
                  'wp-content/themes', 'wp-content/themes/gapyeong-church']:
        test(f"CWD '{path}'", lambda p=path: ftp.cwd(p))

    print("\n=== 4. 파일 쓰기 테스트 ===")
    test_content = io.BytesIO(b"github-actions-test")
    
    # 다양한 경로로 파일 쓰기 시도
    for path in ['test_deploy.txt',
                 'wp-content/themes/gapyeong-church/test_deploy.txt',
                 '/www/wp-content/themes/gapyeong-church/test_deploy.txt',
                 './test_deploy.txt']:
        test_content.seek(0)
        ok = test(f"STOR '{path}'", lambda p=path: ftp.storbinary(f'STOR {p}', test_content))
        if ok:
            # 성공하면 정리
            try:
                ftp.delete(path)
                print(f"    (정리 완료: {path})")
            except:
                pass

    print("\n=== 5. CWD 후 STOR 테스트 ===")
    # CWD로 먼저 이동 후 파일명만으로 STOR
    for cwd_path in ['wp-content/themes/gapyeong-church',
                     '/www/wp-content/themes/gapyeong-church']:
        print(f"  --- CWD '{cwd_path}' 시도 ---")
        try:
            ftp.cwd(cwd_path)
            print(f"    CWD 성공")
            test_content.seek(0)
            ok = test(f"  STOR 'test_deploy.txt' (in {cwd_path})", 
                     lambda: ftp.storbinary('STOR test_deploy.txt', test_content))
            if ok:
                try: ftp.delete('test_deploy.txt')
                except: pass
        except Exception as e:
            print(f"    CWD 실패: {e}")

    print("\n=== 6. SFTP 포트 테스트 ===")
    import socket
    for port in [22, 2222, 990]:
        try:
            s = socket.create_connection((FTP_HOST, port), timeout=5)
            s.close()
            print(f"  PASS Port {port}: 열려있음")
        except Exception as e:
            print(f"  FAIL Port {port}: {e}")

    ftp.quit()
    print("\n=== 테스트 완료 ===")

if __name__ == '__main__':
    main()
