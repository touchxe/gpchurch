/**
 * 가평교회 - Main JavaScript (Fixed + New Features)
 * Handles animations, interactions, and UI components
 * Direct HTML Injection to prevent 404s
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. CRITICAL: Load components (Header/Footer) first
    // Using .then() to ensure dependent logic runs after header exists
    loadComponents().then(() => {
        // Initialize Mobile Menu (depends on header)
        safeRun(initMobileMenu, 'Mobile Menu');
    });

    // 2. Initialize Features (Independent)
    safeRun(initScrollSpy, 'Scroll Spy');
    safeRun(checkLiveStatus, 'Live Status');

    // 3. Visuals & Animations
    // Initialize Lucide Icons
    if (typeof lucide !== 'undefined') lucide.createIcons();

    safeRun(initParallaxOrbs, 'Parallax Orbs');
    safeRun(initHeroSwiper, 'Hero Swiper');
    safeRun(initScrollAnimations, 'Scroll Animations (AOS)');
    safeRun(initShapeRotations, 'Shape Rotations');

    safeRun(initMiniCalendar, 'Mini Calendar');
    safeRun(initScheduleModal, 'Schedule Modal');
    safeRun(initScrollIndicator, 'Scroll Indicator');
    safeRun(initScrollToTop, 'Scroll To Top');
    safeRun(initFooterReveal, 'Footer Reveal');
});

// Helper wrapper to prevent one error from stopping everything
function safeRun(fn, name) {
    try {
        if (typeof fn === 'function') fn();
    } catch (e) {
        console.error(`${name} Init Error:`, e);
    }
}

/**
 * Load Shared Components (Header, Footer) - Direct Injection
 */
async function loadComponents() {
    // Header HTML
    const headerHTML = `
    <header class="header">
    <div class="header-container">
        <a href="/index.html" class="logo">
            <img src="/logo.png" alt="가평교회 로고" class="logo-img">
            <span class="logo-text">가평교회</span>
        </a>

        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="/index.html" class="nav-link">홈</a>
                </li>
                <li class="nav-item has-dropdown">
                    <a href="#" class="nav-link">교회소개</a>
                    <ul class="dropdown">
                        <li><a href="/intro/greeting.html">인사말</a></li>
                        <li><a href="/intro/vision.html">비전</a></li>
                        <li><a href="/intro/history.html">연혁</a></li>
                        <li><a href="/intro/organization.html">조직도</a></li>
                        <li><a href="/intro/location.html">오시는 길</a></li>
                    </ul>
                </li>
                <li class="nav-item has-dropdown">
                    <a href="#" class="nav-link">프로그램</a>
                    <ul class="dropdown">
                        <li><a href="/program/worship.html">예배 시간</a></li>
                        <li><a href="/program/sabbath.html">안식일학교</a></li>
                        <li><a href="/program/pathfinder.html">패스파인더</a></li>
                        <li><a href="/program/youth.html">청년반</a></li>
                        <li><a href="/program/smallgroup.html">소그룹</a></li>
                    </ul>
                </li>
                <li class="nav-item has-dropdown">
                    <a href="#" class="nav-link">부서</a>
                    <ul class="dropdown" style="min-width: 200px;">
                        <li><a href="/dept/ministry.html">목회부</a></li>
                        <li><a href="/dept/clerk.html">교회서기</a></li>
                        <li><a href="/dept/treasury.html">교회재무</a></li>
                        <li><a href="/dept/elders.html">장로회</a></li>
                        <li><a href="/dept/deacons.html">집사회</a></li>
                        <li><a href="/dept/mission.html">선교회</a></li>
                        <li><a href="/dept/sabbath-school.html">안식일학교</a></li>
                        <li><a href="/dept/community-service.html">지역사회봉사회</a></li>
                        <li><a href="/dept/children.html">어린이부</a></li>
                        <li><a href="/dept/youth-student.html">청년·학생 선교회</a></li>
                        <li><a href="/dept/pathfinder.html">패스파인더</a></li>
                        <li><a href="/dept/choir.html">찬양대</a></li>
                        <li><a href="/dept/health-welfare.html">보건복지부</a></li>
                        <li><a href="/dept/digital-media.html">디지털 홍보부</a></li>
                    </ul>
                </li>
                <li class="nav-item has-dropdown">
                    <a href="#" class="nav-link">커뮤니티</a>
                    <ul class="dropdown">
                        <li><a href="/community/notices.html">공지사항</a></li>
                        <li><a href="/community/gallery.html">갤러리</a></li>
                        <li><a href="/community/contact.html">문의하기</a></li>
                        <li><a href="/community/prayer.html">기도요청</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="header-actions">
            <a href="https://gpchurch.mycafe24.com/로그인-화면/" class="btn-text desktop-only">로그인</a>
            <span class="header-separator desktop-only"></span>
            <a href="/pages/auth/signup.html" class="btn-text desktop-only">회원가입</a>
            <a href="https://gpchurch.mycafe24.com/로그인-화면/" class="btn-icon mobile-only" aria-label="로그인">
                <i data-lucide="user"></i>
            </a>
            <a href="/live.html" class="btn-live desktop-only"><span class="live-dot"></span>LIVE</a>
            <a href="/live.html" class="btn-icon mobile-only" aria-label="라이브 예배">
                <i data-lucide="youtube"></i>
            </a>
        </div>

        <button class="mobile-menu-toggle" aria-label="메뉴 열기">
            <i data-lucide="menu"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <div class="mobile-menu-header">
            <a href="/index.html" class="mobile-logo">가평교회</a>
            <button class="mobile-menu-close" aria-label="메뉴 닫기">
                <i data-lucide="x"></i>
            </button>
        </div>
        <nav class="mobile-nav">
            <a href="/index.html" class="mobile-nav-link">홈</a>

            <div class="mobile-nav-group">
                <button class="mobile-nav-toggle">교회소개 <i data-lucide="chevron-down"></i></button>
                <div class="mobile-nav-dropdown">
                    <a href="/intro/greeting.html">인사말</a>
                    <a href="/intro/vision.html">비전</a>
                    <a href="/intro/history.html">연혁</a>
                    <a href="/intro/organization.html">조직도</a>
                    <a href="/intro/location.html">오시는 길</a>
                </div>
            </div>

            <div class="mobile-nav-group">
                <button class="mobile-nav-toggle">프로그램 <i data-lucide="chevron-down"></i></button>
                <div class="mobile-nav-dropdown">
                    <a href="/program/worship.html">예배 시간</a>
                    <a href="/program/sabbath.html">안식일학교</a>
                    <a href="/program/pathfinder.html">패스파인더</a>
                    <a href="/program/youth.html">청년반</a>
                    <a href="/program/smallgroup.html">소그룹</a>
                </div>
            </div>

            <div class="mobile-nav-group">
                <button class="mobile-nav-toggle">부서 <i data-lucide="chevron-down"></i></button>
                <div class="mobile-nav-dropdown">
                    <a href="/dept/ministry.html">목회부</a>
                    <a href="/dept/sabbath-school.html">안식일학교</a>
                    <a href="/dept/youth-student.html">청년·학생 선교회</a>
                    <a href="/dept/pathfinder.html">패스파인더</a>
                    <a href="/dept/children.html">어린이부</a>
                    <a href="/dept/choir.html">찬양대</a>
                    <a href="/dept/mission.html">선교회</a>
                    <a href="/dept/community-service.html">지역사회봉사회</a>
                </div>
            </div>

            <div class="mobile-nav-group">
                <button class="mobile-nav-toggle">커뮤니티 <i data-lucide="chevron-down"></i></button>
                <div class="mobile-nav-dropdown">
                    <a href="/community/notices.html">공지사항</a>
                    <a href="/community/gallery.html">갤러리</a>
                    <a href="/community/contact.html">문의하기</a>
                    <a href="/community/prayer.html">기도요청</a>
                </div>
            </div>
        </nav>
    </div>
    <div class="mobile-menu-overlay"></div>
    </header>
    `;

    const footerHTML = `
    <footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <img src="/logo.png" alt="가평교회" class="footer-logo">
                <p>제칠일안식일예수재림교회<br>가평교회</p>
                <div class="footer-social">
                    <a href="#" aria-label="YouTube"><i data-lucide="youtube"></i></a>
                    <a href="#" aria-label="Facebook"><i data-lucide="facebook"></i></a>
                    <a href="#" aria-label="Instagram"><i data-lucide="instagram"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <h4>교회소개</h4>
                <ul>
                    <li><a href="/intro/greeting.html">인사말</a></li>
                    <li><a href="/intro/vision.html">비전</a></li>
                    <li><a href="/intro/history.html">연혁</a></li>
                    <li><a href="/intro/location.html">오시는 길</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>프로그램</h4>
                <ul>
                    <li><a href="/program/worship.html">예배 안내</a></li>
                    <li><a href="/program/sabbath.html">안식일학교</a></li>
                    <li><a href="/program/pathfinder.html">패스파인더</a></li>
                    <li><a href="/program/youth.html">청년반</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>커뮤니티</h4>
                <ul>
                    <li><a href="/community/notices.html">공지사항</a></li>
                    <li><a href="/community/gallery.html">갤러리</a></li>
                    <li><a href="/community/contact.html">문의하기</a></li>
                    <li><a href="/community/prayer.html">기도요청</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 가평교회 (Gapyeong SDA Church). All rights reserved.</p>
        </div>
    </div>
    </footer>
    `;

    // Inject Header
    const headerPlaceholder = document.getElementById('header-placeholder');
    if (headerPlaceholder) headerPlaceholder.innerHTML = headerHTML;

    // Inject Footer
    const footerPlaceholder = document.getElementById('footer-placeholder');
    if (footerPlaceholder) footerPlaceholder.innerHTML = footerHTML;

    // Highlight Active Link
    const currentPath = window.location.pathname;
    setTimeout(() => {
        document.querySelectorAll('.nav-link, .mobile-nav-link').forEach(link => {
            const href = link.getAttribute('href');
            if (href && (href === currentPath || (href !== '/' && currentPath.includes(href)))) {
                link.classList.add('active');
            }
        });

        // Init header scroll effect here
        initHeaderScroll();
    }, 100);
}

/**
 * Parallax Background Orbs
 */
function initParallaxOrbs() {
    const orbs = document.querySelectorAll('.global-orbs .orb');
    if (orbs.length === 0) return;

    let ticking = false;

    function updateOrbsPosition(scrollY) {
        orbs.forEach((orb, index) => {
            const speeds = [0.15, -0.1, 0.2, -0.15, 0.12];
            const speed = speeds[index] || 0.1;
            const yPos = scrollY * speed;
            orb.style.transform = `translateY(${yPos}px)`;
        });
    }

    function onScroll() {
        const scrollY = window.scrollY;
        if (!ticking) {
            window.requestAnimationFrame(() => {
                updateOrbsPosition(scrollY);
                ticking = false;
            });
            ticking = true;
        }
    }
    window.addEventListener('scroll', onScroll, { passive: true });
}

/**
 * Hero Section Swiper Slider
 */
function initHeroSwiper() {
    const heroSwiperEl = document.querySelector('.hero-swiper');
    if (!heroSwiperEl || typeof Swiper === 'undefined') return;

    try {
        new Swiper(heroSwiperEl, {
            loop: true,
            autoplay: { delay: 6000, disableOnInteraction: false },
            effect: 'fade',
            fadeEffect: { crossFade: true },
            speed: 800,
            pagination: { el: '.hero-pagination', clickable: true },
        });
    } catch (e) { console.warn('Swiper init failed', e); }
}

/**
 * Decorative Shape Rotations on Scroll
 */
function initShapeRotations() {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

    gsap.registerPlugin(ScrollTrigger);

    const triangles = document.querySelectorAll('.deco-triangle-1, .deco-triangle-2, .deco-triangle-3, .deco-triangle-4');
    const diamonds = document.querySelectorAll('.deco-diamond-1, .deco-diamond-2, .deco-diamond-3');
    const circles = document.querySelectorAll('.deco-circle-1, .deco-circle-2, .deco-circle-3');

    triangles.forEach((triangle, index) => {
        gsap.to(triangle, {
            scrollTrigger: {
                trigger: triangle,
                start: 'top bottom',
                end: 'bottom top',
                scrub: index + 1,
            },
            rotation: index % 2 === 0 ? 360 : -360,
            ease: 'none'
        });
    });

    diamonds.forEach((diamond, index) => {
        gsap.to(diamond, {
            scrollTrigger: {
                trigger: diamond,
                start: 'top bottom',
                end: 'bottom top',
                scrub: (index + 1) * 1.5,
            },
            rotation: index % 2 === 0 ? -360 : 360,
            ease: 'none'
        });
    });

    circles.forEach((circle, index) => {
        gsap.to(circle, {
            scrollTrigger: {
                trigger: circle,
                start: 'top bottom',
                end: 'bottom top',
                scrub: (index + 1) * 2,
            },
            rotation: index % 2 === 0 ? 360 : -360,
            ease: 'none'
        });
    });
}

/**
 * Scroll Progress Indicator
 */
function initScrollIndicator() {
    const indicator = document.querySelector('.scroll-indicator');
    const progressBar = document.querySelector('.scroll-progress');
    const scrollDot = document.querySelector('.scroll-dot');

    if (!indicator || !progressBar || !scrollDot) return;

    window.addEventListener('scroll', () => {
        const winHeight = window.innerHeight;
        const docHeight = document.documentElement.scrollHeight;
        const scrollTop = window.scrollY;
        const pct = (scrollTop / (docHeight - winHeight)) * 100;

        progressBar.style.height = `${pct}%`;
        scrollDot.style.top = `${pct}%`;

        if (scrollTop > 200) indicator.classList.add('visible');
        else indicator.classList.remove('visible');
    }, { passive: true });
}

/**
 * Scroll Animations (AOS)
 */
function initScrollAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.getAttribute('data-aos-delay') || 0;
                setTimeout(() => {
                    entry.target.classList.add('aos-animate');
                }, delay);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('[data-aos]').forEach(el => observer.observe(el));

    // Fallback: Force visible if GSAP/AOS fails
    setTimeout(() => {
        document.querySelectorAll('[data-aos]:not(.aos-animate)').forEach(el => {
            el.style.opacity = '1';
            el.style.visibility = 'visible';
            el.style.transform = 'none';
        });
    }, 2000);

    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        const aurora = document.querySelector('.aurora-background');
        if (aurora) {
            gsap.to('.aurora-background', {
                scrollTrigger: {
                    trigger: '.hero-section',
                    start: 'top top',
                    end: 'bottom top',
                    scrub: true
                },
                y: 150,
                ease: 'none'
            });
        }
    }
}

/**
 * Header Scroll Effect
 */
function initHeaderScroll() {
    const header = document.querySelector('.header');
    if (!header) return;
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) header.classList.add('scrolled');
        else header.classList.remove('scrolled');
    }, { passive: true });
}

/**
 * Mobile Menu Toggle
 */
function initMobileMenu() {
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const menuClose = document.querySelector('.mobile-menu-close');
    const mobileMenu = document.querySelector('.mobile-menu');
    const overlay = document.querySelector('.mobile-menu-overlay');
    const dropdownToggles = document.querySelectorAll('.mobile-nav-toggle');

    if (!menuToggle || !mobileMenu) return;

    // Open
    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.add('active');
        if (overlay) overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });

    // Close
    const closeMenu = () => {
        mobileMenu.classList.remove('active');
        if (overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
    };

    if (menuClose) menuClose.addEventListener('click', closeMenu);
    if (overlay) overlay.addEventListener('click', closeMenu);

    // Dropdowns
    dropdownToggles.forEach(toggle => {
        // Remove old listeners to be safe (by cloning replacer)
        const newToggle = toggle.cloneNode(true);
        toggle.parentNode.replaceChild(newToggle, toggle);

        newToggle.addEventListener('click', (e) => {
            e.preventDefault();
            const dropdown = newToggle.nextElementSibling;
            newToggle.classList.toggle('active');
            if (dropdown) dropdown.classList.toggle('active');
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    });
}

/**
 * Mini Calendar for Church Schedule
 * REST API(/wp-json/gapyeong/v1/schedule)로 KBoard 일정 데이터를 로드하여
 * 달력 날짜에 초록 점(has-event) 표시 + 월별 일정 목록 동적 렌더링
 */
function initMiniCalendar() {
    const calendarDays = document.getElementById('calendarDays');
    const calMonth = document.querySelector('.cal-month');
    const prevBtn = document.querySelector('.cal-prev');
    const nextBtn = document.querySelector('.cal-next');
    const scheduleTitle = document.getElementById('scheduleMonthTitle');
    const scheduleList = document.getElementById('scheduleList');

    if (!calendarDays) return;

    // 게시판 ID 및 게시판 페이지 URL: front-page.php에서 data 속성으로 전달
    const wrapper = document.querySelector('.calendar-schedule-wrapper');
    const boardId = wrapper ? (wrapper.dataset.boardId || '3') : '3';
    const boardUrl = wrapper ? (wrapper.dataset.boardUrl || '') : '';

    // KBoard 문서 URL 생성 헬퍼
    function buildDocUrl(uid) {
        if (!uid) return '';
        if (boardUrl) {
            const sep = boardUrl.includes('?') ? '&' : '?';
            return `${boardUrl}${sep}uid=${uid}&mod=document`;
        }
        // boardUrl 없으면 현재 도메인 기준 fallback
        return `/?uid=${uid}&mod=document&kboard_id=${boardId}`;
    }

    let currentDate = new Date();
    let currentScheduleData = []; // 현재 월 일정 캐시

    const monthNames = ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'];

    /**
     * REST API에서 해당 년/월 일정 로드
     */
    async function fetchSchedule(year, month) {
        try {
            const res = await fetch(
                `/wp-json/gapyeong/v1/schedule?board_id=${boardId}&year=${year}&month=${month + 1}`
            );
            if (!res.ok) return [];
            return await res.json();
        } catch (e) {
            console.warn('일정 로드 실패:', e);
            return [];
        }
    }

    /**
     * 달력 그리드 렌더링 (eventDays: 이벤트가 있는 날짜 배열 [1,11,25,...])
     */
    function renderCalendarGrid(date, eventDays) {
        const year = date.getFullYear();
        const month = date.getMonth();

        // 헤더 텍스트 업데이트
        if (calMonth) calMonth.textContent = `${year}년 ${monthNames[month]}`;

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();

        const today = new Date();
        const isCurrentMonth = today.getMonth() === month && today.getFullYear() === year;

        let html = '';

        // 이전 달 여백
        for (let i = firstDay - 1; i >= 0; i--) {
            html += `<div class="cal-day other-month">${daysInPrevMonth - i}</div>`;
        }

        // 현재 달 날짜
        for (let day = 1; day <= daysInMonth; day++) {
            const dow = new Date(year, month, day).getDay();
            let cls = 'cal-day';
            if (isCurrentMonth && day === today.getDate()) cls += ' today';
            if (dow === 0) cls += ' sunday';
            if (dow === 6) cls += ' saturday';
            if (eventDays.includes(day)) cls += ' has-event';

            html += `<div class="${cls}" data-day="${day}">${day}</div>`;
        }

        // 다음 달 여백
        const totalCells = firstDay + daysInMonth;
        const nextDays = totalCells > 35 ? 42 - totalCells : 35 - totalCells;
        for (let i = 1; i <= nextDays; i++) {
            html += `<div class="cal-day other-month">${i}</div>`;
        }

        calendarDays.innerHTML = html;
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    /**
     * 월 일정 목록 렌더링 (scheduleData: REST API 응답 배열)
     */
    function renderScheduleList(scheduleData, year, month) {
        if (scheduleTitle) {
            scheduleTitle.textContent = `${monthNames[month]} 일정`;
        }
        if (!scheduleList) return;

        if (!scheduleData || scheduleData.length === 0) {
            scheduleList.innerHTML = `
                <li class="schedule-item schedule-empty">
                    <span class="schedule-title" style="color:#94a3b8;font-size:0.85rem;">이번 달 등록된 일정이 없습니다.</span>
                </li>`;
            return;
        }

        let html = '';
        scheduleData.forEach(item => {
            // REST API url 필드 우선, 없으면 JS에서 직접 생성
            const docUrl = item.url || buildDocUrl(item.uid);
            const linkStart = docUrl
                ? `<a href="${docUrl}" class="schedule-link">`
                : `<span class="schedule-link">`;
            const linkEnd = docUrl ? `</a>` : `</span>`;

            html += `<li class="schedule-item">
                ${linkStart}
                    <span class="schedule-date">${item.display_date}</span>
                    <span class="schedule-title">${item.title}</span>
                ${linkEnd}
            </li>`;
        });
        scheduleList.innerHTML = html;

        // 2개 초과 시 슬라이딩 ticker 적용
        if (scheduleData.length > 2) {
            _initScheduleTicker(scheduleList);
        }
    }

    /**
     * 달력 + 일정 전체 갱신 (async)
     */
    async function updateCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();

        // 로딩 표시
        if (scheduleTitle) scheduleTitle.textContent = `${monthNames[month]} 일정 로딩 중...`;
        if (scheduleList) scheduleList.innerHTML = '';

        const scheduleData = await fetchSchedule(year, month);
        currentScheduleData = scheduleData;

        // days 배열을 합쳐서 위집 날짜 세트 생성
        const eventDaySet = new Set();
        scheduleData.forEach(item => {
            if (item.days && item.days.length) {
                item.days.forEach(d => eventDaySet.add(d));
            } else {
                eventDaySet.add(item.day); // fallback: days 없으면 단일 day
            }
        });
        const eventDays = Array.from(eventDaySet);
        renderCalendarGrid(date, eventDays);
        renderScheduleList(scheduleData, year, month);
    }

    // 초기 로드
    updateCalendar(currentDate);

    // 이전 달 버튼
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
            updateCalendar(currentDate);
        });
    }

    // 다음 달 버튼
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
            updateCalendar(currentDate);
        });
    }
}

/**
 * Schedule Ticker: 2개 높이로 클리핑, 3개 이상이면 위로 슬라이드
 * listEl: <ul class="schedule-list"> 엘리먼트
 */
function _initScheduleTicker(listEl) {
    if (!listEl) return;

    const items = Array.from(listEl.querySelectorAll('.schedule-item'));
    if (items.length <= 2) return;

    // --- 구조 구성 ---
    // 1) 클리핑 wrapper div 생성 → listEl의 자리에 삽입
    const clipper = document.createElement('div');
    clipper.className = 'schedule-ticker-clip';
    clipper.style.cssText = [
        'overflow: hidden',
        'position: relative',
        'width: 100%',
    ].join(';');

    // 2) listEl을 clipper 안으로 이동
    listEl.parentNode.insertBefore(clipper, listEl);
    clipper.appendChild(listEl);

    // 3) listEl 자체 스타일 초기화 (transform 대상은 listEl)
    listEl.style.cssText += ';transition:none;transform:translateY(0);margin:0;padding:0;';

    // --- 높이 측정은 렌더 후 ---
    requestAnimationFrame(() => {
        const gap = parseInt(getComputedStyle(listEl).gap) || 8;
        const firstItem = items[0];
        const itemH = firstItem.getBoundingClientRect().height || 52;
        const visibleH = itemH * 2 + gap;

        // 클리퍼 높이 고정
        clipper.style.height = visibleH + 'px';

        let current = 0;
        let timer = null;

        function slideTo(idx) {
            const offset = idx * (itemH + gap);
            listEl.style.transition = 'transform 0.55s cubic-bezier(0.4,0,0.2,1)';
            listEl.style.transform = `translateY(-${offset}px)`;
            current = idx;
        }

        function next() {
            const maxIdx = items.length - 2;
            if (current >= maxIdx) {
                // 처음으로 순간이동 후 애니메이션 재개
                listEl.style.transition = 'none';
                listEl.style.transform = 'translateY(0)';
                current = 0;
                // 강제 리플로우 → 다음 프레임에 애니메이션 시작
                listEl.getBoundingClientRect();
            } else {
                slideTo(current + 1);
            }
        }

        timer = setInterval(next, 3000);

        clipper.addEventListener('mouseenter', () => clearInterval(timer));
        clipper.addEventListener('mouseleave', () => {
            timer = setInterval(next, 3000);
        });
    });
}

/**
 * Schedule Modal
 */
function initScheduleModal() {
    const modal = document.getElementById('scheduleModal');
    if (!modal) return;

    const closeBtn = modal.querySelector('.schedule-modal-close');
    const overlay = modal.querySelector('.schedule-modal-overlay');

    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (overlay) overlay.addEventListener('click', closeModal);

    document.querySelectorAll('.schedule-item').forEach(item => {
        item.addEventListener('click', () => {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });
}

/**
 * Scroll to Top
 */
function initScrollToTop() {
    const btn = document.querySelector('.scroll-to-top');
    if (!btn) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) btn.classList.add('visible');
        else btn.classList.remove('visible');
    }, { passive: true });

    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

/**
 * Minimal TOC (Left Center) + Scroll Floating Widget (Left Bottom)
 */
function initScrollSpy() {
    // Duplicate Check
    if (document.getElementById('pageToc')) return;

    // Define Targets (icons from lucide)
    const targets = [
        { selector: '.hero-section', label: '홈', icon: 'home' },
        { selector: '.quick-menu-section', label: '바로가기', icon: 'grid-2x2' },
        { selector: '.gallery-section', label: '프로그램', icon: 'calendar' },
        { selector: '.activities-blog-section', label: '활동', icon: 'image' },
        { selector: '.church-info-section', label: '교회 알림', icon: 'bell' },
        { selector: '.departments-section', label: '부서 소개', icon: 'users' },
    ];

    const validTargets = targets.filter(t => document.querySelector(t.selector));
    if (validTargets.length === 0) {
        setTimeout(initScrollSpy, 500);
        return;
    }

    // --- 1. TOC (Left Center, Always Visible, Minimal) ---
    const toc = document.createElement('nav');
    toc.id = 'pageToc';
    toc.className = 'page-toc';
    toc.setAttribute('aria-label', 'Page navigation');

    let tocHTML = '';
    validTargets.forEach((item, i) => {
        const section = document.querySelector(item.selector);
        const id = section.id || `toc-sec-${i}`;
        section.id = id;
        tocHTML += `<a href="#${id}" class="toc-item" data-target="${id}" title="${item.label}">
            <span class="toc-icon-wrap"><i data-lucide="${item.icon}"></i></span>
            <span class="toc-label">${item.label}</span>
        </a>`;
    });
    toc.innerHTML = tocHTML;
    document.body.appendChild(toc);

    // --- 2. Scroll Floating Widget (Left Bottom, Fade-in on scroll) ---
    const widget = document.createElement('div');
    widget.id = 'scrollFloatingWidget';
    widget.className = 'scroll-floating-widget bottom-left';
    widget.innerHTML = `
        <span class="widget-scroll-text">SCROLL</span>
        <div class="widget-track">
            <div class="widget-bar"></div>
            <div class="widget-dot"></div>
        </div>
    `;
    document.body.appendChild(widget);

    // Init lucide icons
    if (typeof lucide !== 'undefined') lucide.createIcons();

    // --- 3. Scroll Spy (IntersectionObserver) ---
    const tocLinks = toc.querySelectorAll('.toc-item');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.id;
                tocLinks.forEach(link => {
                    link.classList.toggle('active', link.dataset.target === id);
                });
            }
        });
    }, { rootMargin: '-20% 0px -60% 0px', threshold: 0 });

    validTargets.forEach(t => observer.observe(document.querySelector(t.selector)));

    // --- 4. Progress + Widget Visibility ---
    const dot = widget.querySelector('.widget-dot');
    const bar = widget.querySelector('.widget-bar');

    window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;
        const docH = document.documentElement.scrollHeight - window.innerHeight;
        const pct = Math.min(Math.max((scrollY / docH) * 100, 0), 100);

        if (dot) dot.style.top = `${pct}%`;
        if (bar) bar.style.height = `${pct}%`;

        // Fade in widget + toc after scroll starts
        if (scrollY > 100) {
            widget.classList.add('visible');
            toc.classList.add('visible');
        } else {
            widget.classList.remove('visible');
            toc.classList.remove('visible');
        }
    }, { passive: true });

    // --- 5. Click Scrolling ---
    tocLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const el = document.getElementById(link.dataset.target);
            if (el) {
                window.scrollTo({ top: el.getBoundingClientRect().top + window.scrollY - 80, behavior: 'smooth' });
            }
        });
    });
}


/**
 * Live Button Logic (API Driven)
 */
async function checkLiveStatus() {
    const liveBtn = document.querySelector('.btn-live');
    if (!liveBtn) return;

    let isLive = false;
    let liveUrl = 'https://www.youtube.com/@gapyeongsdachurch/streams';

    try {
        const response = await fetch('/api/youtube_status.php');
        const data = await response.json();

        if (data && data.isLive) {
            isLive = true;
            if (data.data && data.data.videoId) {
                liveUrl = `https://www.youtube.com/watch?v=${data.data.videoId}`;
            }
        }
    } catch (e) { }

    if (isLive) {
        liveBtn.classList.add('on-air');
        liveBtn.classList.remove('off-air');
        liveBtn.innerHTML = '🔴 LIVE';
        liveBtn.onclick = (e) => {
            e.preventDefault();
            window.open(liveUrl, '_blank');
        };
    } else {
        liveBtn.classList.remove('on-air');
        liveBtn.classList.add('off-air');
        liveBtn.innerHTML = '<span class="live-dot"></span>OFF AIR';
        liveBtn.onclick = (e) => {
            e.preventDefault();
            alert('현재는 실시간 방송 중이 아닙니다.\n[정규 방송 시간]\n금요일: 오후 7시 30분\n안식일: 오전 9시 30분 / 11시');
        };
    }
}

/**
 * Footer Parallax Reveal
 * 스크롤 시 푸터가 아래에서 위로 올라오며 나타나는 효과
 */
function initFooterReveal() {
    const footer = document.querySelector('.footer');
    if (!footer) return;

    if (!('IntersectionObserver' in window)) {
        footer.classList.add('footer-revealed');
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    requestAnimationFrame(() => {
                        footer.classList.add('footer-revealed');
                    });
                    observer.unobserve(footer);
                }
            });
        },
        {
            root: null,
            threshold: 0.05,
            rootMargin: '0px 0px -20px 0px',
        }
    );

    observer.observe(footer);
}
