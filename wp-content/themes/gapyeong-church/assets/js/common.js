// ========================================
// 가평교회 웹사이트 - 공통 JavaScript
// ========================================

// 다국어 지원
const translations = {
    ko: {
        // Navigation
        'nav.home': '홈',
        'nav.intro': '교회소개',
        'nav.program': '프로그램',
        'nav.dept': '부서',
        'nav.community': '커뮤니티',
        'nav.login': '로그인',

        // Intro submenu
        'nav.intro.greeting': '인사말',
        'nav.intro.vision': '비전',
        'nav.intro.history': '연혁',
        'nav.intro.org': '조직도',
        'nav.intro.map': '오시는 길',

        // Program submenu
        'nav.program.worship': '예배 시간',
        'nav.program.sabbath': '안식일학교',
        'nav.program.pathfinder': '패스파인더',
        'nav.program.youth': '청년반',
        'nav.program.smallgroup': '소그룹',

        // Footer
        'footer.contact': '연락처',
        'footer.address': '주소',
        'footer.copyright': '© 2026 가평교회. All rights reserved.',
    },
    en: {
        // Navigation
        'nav.home': 'Home',
        'nav.intro': 'About',
        'nav.program': 'Programs',
        'nav.dept': 'Departments',
        'nav.community': 'Community',
        'nav.login': 'Login',

        // Intro submenu
        'nav.intro.greeting': 'Greeting',
        'nav.intro.vision': 'Vision',
        'nav.intro.history': 'History',
        'nav.intro.org': 'Organization',
        'nav.intro.map': 'Location',

        // Program submenu
        'nav.program.worship': 'Worship',
        'nav.program.sabbath': 'Sabbath School',
        'nav.program.pathfinder': 'Pathfinder',
        'nav.program.youth': 'Youth',
        'nav.program.smallgroup': 'Small Group',

        // Footer
        'footer.contact': 'Contact',
        'footer.address': 'Address',
        'footer.copyright': '© 2026 Gapyeong Church. All rights reserved.',
    }
};

// 현재 언어 (기본값: 한국어)
let currentLang = localStorage.getItem('language') || 'ko';

// 언어 변경 함수
function changeLanguage(lang) {
    currentLang = lang;
    localStorage.setItem('language', lang);
    updatePageLanguage();

    // 언어 선택 버튼 업데이트
    document.querySelectorAll('.lang-option').forEach(option => {
        option.classList.toggle('active', option.dataset.lang === lang);
    });
}

// 페이지 텍스트 업데이트
function updatePageLanguage() {
    document.querySelectorAll('[data-i18n]').forEach(element => {
        const key = element.dataset.i18n;
        const translation = translations[currentLang][key];
        if (translation) {
            element.textContent = translation;
        }
    });
}

// 모바일 메뉴 토글
function toggleMobileMenu() {
    const navMenu = document.querySelector('.nav-menu');
    const menuToggle = document.querySelector('.mobile-menu-toggle');

    navMenu.classList.toggle('active');
    menuToggle.classList.toggle('active');
}

// 드롭다운 메뉴 토글 (모바일)
function toggleDropdown(event) {
    if (window.innerWidth <= 768) {
        event.preventDefault();
        const navItem = event.target.closest('.nav-item');
        navItem.classList.toggle('active');
    }
}

// 스크롤 시 헤더 스타일 변경
function handleScroll() {
    const header = document.querySelector('.header');
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
}

// 모달 열기
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

// 모달 닫기
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// 탭 전환
function switchTab(tabId) {
    // 모든 탭 비활성화
    document.querySelectorAll('.tab-item').forEach(tab => {
        tab.classList.remove('active');
    });
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });

    // 선택된 탭 활성화
    const selectedTab = document.querySelector(`[data-tab="${tabId}"]`);
    const selectedContent = document.getElementById(tabId);

    if (selectedTab && selectedContent) {
        selectedTab.classList.add('active');
        selectedContent.classList.add('active');
    }
}

// 아코디언 토글
function toggleAccordion(element) {
    const accordionItem = element.closest('.accordion-item');
    const isActive = accordionItem.classList.contains('active');

    // 다른 아코디언 닫기 (선택사항)
    document.querySelectorAll('.accordion-item').forEach(item => {
        item.classList.remove('active');
    });

    // 현재 아코디언 토글
    if (!isActive) {
        accordionItem.classList.add('active');
    }
}

// 부드러운 스크롤
function smoothScroll(targetId) {
    const target = document.getElementById(targetId);
    if (target) {
        const headerHeight = document.querySelector('.header').offsetHeight;
        const targetPosition = target.offsetTop - headerHeight;

        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
    }
}

// 이미지 레이지 로딩
function lazyLoadImages() {
    const images = document.querySelectorAll('img[data-src]');

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));
}

// 폼 유효성 검사
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;

    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');

    requiredFields.forEach(field => {
        const errorElement = field.parentElement.querySelector('.form-error');

        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('error');
            if (errorElement) {
                errorElement.textContent = '필수 입력 항목입니다.';
            }
        } else {
            field.classList.remove('error');
            if (errorElement) {
                errorElement.textContent = '';
            }
        }
    });

    return isValid;
}

// 날짜 포맷팅
function formatDate(dateString, format = 'YYYY-MM-DD') {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');

    return format
        .replace('YYYY', year)
        .replace('MM', month)
        .replace('DD', day);
}

// 페이지 로드 시 초기화
document.addEventListener('DOMContentLoaded', function () {
    // 언어 초기화
    updatePageLanguage();

    // 언어 선택 버튼 이벤트
    document.querySelectorAll('.lang-option').forEach(option => {
        option.addEventListener('click', function () {
            changeLanguage(this.dataset.lang);
        });
    });

    // 모바일 메뉴 토글
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleMobileMenu);
    }

    // 드롭다운 메뉴
    document.querySelectorAll('.nav-item.has-dropdown > .nav-link').forEach(link => {
        link.addEventListener('click', toggleDropdown);
    });

    // 스크롤 이벤트
    window.addEventListener('scroll', handleScroll);

    // 모달 백드롭 클릭 시 닫기
    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
        backdrop.addEventListener('click', function () {
            const modal = this.closest('.modal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // 모달 닫기 버튼
    document.querySelectorAll('.modal-close').forEach(closeBtn => {
        closeBtn.addEventListener('click', function () {
            const modal = this.closest('.modal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // 레이지 로딩 초기화
    lazyLoadImages();

    // 현재 페이지 네비게이션 활성화
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });
});

// ESC 키로 모달 닫기
document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        document.querySelectorAll('.modal.active').forEach(modal => {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
});
