# 🏠 가평교회 홈페이지 개발 프로젝트

> **사이트:** [gpchurch.mycafe24.com](https://gpchurch.mycafe24.com)  
> **저장소:** [github.com/touchxe/gpchurch](https://github.com/touchxe/gpchurch)  
> **호스팅:** Cafe24 웹호스팅 (WordPress)

---

## 📁 프로젝트 구조

```
gpchurch/
├── .github/
│   └── workflows/
│       └── deploy.yml          # 자동 배포 설정
├── docs/
│   ├── 팀_협업_가이드.md        # 협업 방법 상세 안내
│   ├── 브랜치_전략.md           # Git 브랜치 전략
│   └── 배포_프로세스.md         # 배포 흐름 설명
├── wp-content/
│   └── themes/
│       ├── gapyeong-church/         # 메인 테마
│       └── gapyeong-church-child/   # 자식 테마 (주요 작업 공간)
├── scripts/                    # 유틸리티 스크립트
└── README.md                   # 이 파일
```

---

## 👥 팀 구성

| 역할 | 이름 | GitHub | 담당 |
|------|------|--------|------|
| 총괄 · 디자인 | YoungBin | [@touchxe](https://github.com/touchxe) | 프로젝트 총괄, UI/UX 디자인, 코드 리뷰, 배포 관리 |
| 기획 · 콘텐츠 | HyunChan | - | 사이트 기획, 콘텐츠 작성 및 관리 |
| 백엔드 · 플러그인 · 프로그래밍 | JunSeok | - | 백엔드 개발, WordPress 플러그인, 기능 구현 |

---

## 🚀 빠른 시작

```bash
# 1. 저장소 클론
git clone https://github.com/touchxe/gpchurch.git
cd gpchurch

# 2. 내 브랜치 생성 (이름은 본인 이름으로)
git checkout -b HyunChan

# 3. 작업 후 커밋 & 푸시
git add .
git commit -m "작업 내용 설명"
git push origin HyunChan
```

---

## 📖 상세 문서

- **[팀 협업 가이드](docs/팀_협업_가이드.md)** — 처음 시작하는 분 필독!
- **[배포 프로세스](docs/배포_프로세스.md)** — 자동 배포 흐름 설명
- **[브랜치 전략](docs/브랜치_전략.md)** — Git 브랜치 규칙

---

## ⚡ 자동 배포

`main` 브랜치에 코드가 병합되면 **GitHub Actions가 자동으로 Cafe24 서버에 배포**합니다.  
배포 현황: [Actions 탭](https://github.com/touchxe/gpchurch/actions)
