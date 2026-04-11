// ========================================
// 부서 페이지 공통 JavaScript (dept.js)
// ========================================

document.addEventListener('DOMContentLoaded', function () {
    // 부서 서브메뉴 로드
    loadDeptSubmenu();
});

/**
 * 부서 서브메뉴를 동적으로 로드
 */
function loadDeptSubmenu() {
    const placeholder = document.getElementById('dept-submenu-placeholder');
    if (!placeholder) return;

    // 현재 페이지 경로 가져오기
    const currentPath = window.location.pathname.replace(/\.html$/, '').replace(/\/$/, '');

    // 부서 목록 정의
    const deptItems = [
        { href: '/dept/ministry', label: '목회부' },
        { href: '/dept/clerk', label: '서기부' },
        { href: '/dept/treasury', label: '재무부' },
        { href: '/dept/elders', label: '장로회' },
        { href: '/dept/deacons', label: '집사회' },
        { href: '/dept/mission', label: '선교회' },
        { href: '/dept/sabbath-school', label: '안식일학교' },
        { href: '/dept/community-service', label: '지역사회봉사회' },
        { href: '/dept/children', label: '어린이부' },
        { href: '/dept/youth-student', label: '청년학생부' },
        { href: '/dept/pathfinder', label: '패스파인더' },
        { href: '/dept/choir', label: '찬양대' },
        { href: '/dept/health-welfare', label: '보건복지부' },
        { href: '/dept/digital-media', label: '디지털홍보부' }
    ];

    // 서브메뉴 HTML 생성
    const navItems = deptItems.map(item => {
        const isActive = currentPath === item.href || currentPath === item.href + '/index';
        return `<a href="${item.href}" class="submenu-nav-item${isActive ? ' active' : ''}">${item.label}</a>`;
    }).join('\n                ');

    const submenuHTML = `
    <section class="submenu-nav-section">
        <div class="container">
            <nav class="submenu-nav">
                ${navItems}
            </nav>
        </div>
    </section>`;

    placeholder.innerHTML = submenuHTML;
}
