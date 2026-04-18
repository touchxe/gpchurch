# 핵심 구현 규칙 (Critical Implementation Rules)

## 기술 스택 및 환경
- **플랫폼:** 워드프레스 (WordPress)
- **테마:** `gapyeong-church` (부모), `gapyeong-church-child` (자식 - 실제 작업 공간)
- **게시판:** KBoard (전용 스킨 활용)
- **로컬 디렉토리:** `/Users/hyunchan09/gapyeong/gpchurch`
- **로컬 테스트 URL:** `http://gpchurch-localwp.local`

## 워크플로우 및 브랜치 전략
- **브랜치:** `hyunchan` 브랜치에서 작업 (main 직배포 금지)
- **리뷰:** 코드 수정 후 `touchxe`에게 PR 리뷰 필수 요청
- **배포:** `main` 브랜치 병합 시 GitHub Actions를 통한 Cafe24 FTP 자동 배포

## 개발 원칙 (Anti-Patterns & Rules)
- **자식 테마 우선:** 모든 수정 사항은 부모 테마가 아닌 `gapyeong-church-child` 테마 내에서 이루어져야 함.
- **CSS Scope:** 게시판 디자인 수정 시 다른 페이지에 영향을 주지 않도록 `#kboard-...` 또는 특정 클래스로 스코프를 제한할 것.
- **보안:** `.env`, API 키, FTP 비밀번호 등 민감 정보는 절대로 깃허브에 커밋하지 말 것.
- **로컬 테스트 필수:** 실 서버 반영 전 반드시 LocalWP 환경에서 유효성 검증 완료 후 푸시할 것.
