<?php
/**
 * 가평교회 테마 - Header Template
 * 기존 components/header.html 을 WordPress PHP로 변환
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
    wp_body_open();
    $gapyeong_login_url = esc_url( home_url( '/로그인-화면/' ) );
    $gapyeong_mypage_url = esc_url( home_url( '/마이페이지/' ) );

    if ( is_user_logged_in() ) {
        if ( function_exists( 'wpmem_profile_url' ) ) {
            $gapyeong_header_auth_url = esc_url( wpmem_profile_url() );
        } else {
            $gapyeong_header_auth_url = $gapyeong_mypage_url;
        }
        $gapyeong_header_auth_label = '프로필';
    } else {
        $gapyeong_header_auth_url   = $gapyeong_login_url;
        $gapyeong_header_auth_label = '로그인';
    }
    ?>

    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt=""
                    class="logo-img" aria-hidden="true">
                <span class="logo-text">가평교회</span>
            </a>

            <nav class="main-nav" aria-label="주요 메뉴">
                <?php
                if (has_nav_menu('main-menu')) {
                    wp_nav_menu(array(
                        'theme_location' => 'main-menu',
                        'container'      => false,
                        'menu_class'     => 'nav-list',
                        'walker'         => new Gapyeong_Desktop_Nav_Walker(),
                        'depth'          => 2,
                    ));
                } else {
                    // Fallback: WP 메뉴 미설정 시 하드코딩
                ?>
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link">홈</a>
                    </li>
                    <li class="nav-item has-dropdown">
                        <a href="#" class="nav-link">교회소개</a>
                        <ul class="dropdown-menu">
                            <li><a href="/intro/greeting" class="dropdown-item">인사말</a></li>
                            <li><a href="/intro/vision" class="dropdown-item">비전</a></li>
                            <li><a href="/intro/history" class="dropdown-item">연혁</a></li>
                            <li><a href="/intro/organization" class="dropdown-item">조직도</a></li>
                            <li><a href="/intro/location" class="dropdown-item">오시는 길</a></li>
                        </ul>
                    </li>
                    <li class="nav-item has-dropdown">
                        <a href="#" class="nav-link">프로그램</a>
                        <ul class="dropdown-menu">
                            <li><a href="/program/worship" class="dropdown-item">예배 시간</a></li>
                            <li><a href="/program/sabbath" class="dropdown-item">안식일학교</a></li>
                            <li><a href="/program/pathfinder" class="dropdown-item">패스파인더</a></li>
                            <li><a href="/program/youth" class="dropdown-item">청년반</a></li>
                            <li><a href="/program/smallgroup" class="dropdown-item">소그룹</a></li>
                        </ul>
                    </li>
                    <li class="nav-item has-dropdown">
                        <a href="#" class="nav-link">부서</a>
                        <ul class="dropdown-menu" style="min-width: 200px;">
                            <li><a href="/dept/#ministry" class="dropdown-item">목회부</a></li>
                            <li><a href="/dept/#clerk" class="dropdown-item">교회서기</a></li>
                            <li><a href="/dept/#treasury" class="dropdown-item">교회재무</a></li>
                            <li><a href="/dept/#elders" class="dropdown-item">장로회</a></li>
                            <li><a href="/dept/#deacons" class="dropdown-item">집사회</a></li>
                            <li><a href="/dept/#mission" class="dropdown-item">선교회</a></li>
                            <li><a href="/dept/#sabbath-school" class="dropdown-item">안식일학교</a></li>
                            <li><a href="/dept/#community-service" class="dropdown-item">지역사회봉사회</a></li>
                            <li><a href="/dept/#children" class="dropdown-item">어린이부</a></li>
                            <li><a href="/dept/#youth-student" class="dropdown-item">청년·학생 선교회</a></li>
                            <li><a href="/dept/#pathfinder" class="dropdown-item">패스파인더</a></li>
                            <li><a href="/dept/#choir" class="dropdown-item">찬양대</a></li>
                            <li><a href="/dept/#health-welfare" class="dropdown-item">보건복지부</a></li>
                            <li><a href="/dept/#digital-media" class="dropdown-item">디지털 홍보부</a></li>
                        </ul>
                    </li>
                    <li class="nav-item has-dropdown">
                        <a href="#" class="nav-link">커뮤니티</a>
                        <ul class="dropdown-menu">
                            <li><a href="/community/notices" class="dropdown-item">공지사항</a></li>
                            <li><a href="/community/gallery" class="dropdown-item">갤러리</a></li>
                            <li><a href="/community/contact" class="dropdown-item">문의하기</a></li>
                            <li><a href="/community/prayer" class="dropdown-item">기도요청</a></li>
                        </ul>
                    </li>
                </ul>
                <?php } ?>
            </nav>

            <div class="header-actions">
                <a href="<?php echo esc_url( $gapyeong_header_auth_url ); ?>" class="btn-text desktop-only"><?php echo esc_html( $gapyeong_header_auth_label ); ?></a>
                <a href="<?php echo esc_url( $gapyeong_header_auth_url ); ?>" class="btn-icon mobile-only" aria-label="<?php echo esc_attr( $gapyeong_header_auth_label ); ?>">
                    <i data-lucide="user"></i>
                </a>
                <a href="/live" class="btn-live off-air desktop-only"><span class="live-dot"></span>OFF AIR</a>
                <a href="/live" class="btn-icon mobile-only" aria-label="라이브 예배">
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
                <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-logo">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="" class="mobile-logo-img" aria-hidden="true">
                    <span>가평교회</span>
                </a>
                <button class="mobile-menu-close" aria-label="메뉴 닫기">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <nav class="mobile-nav" aria-label="모바일 메뉴">
                <?php
                if (has_nav_menu('main-menu')) {
                    wp_nav_menu(array(
                        'theme_location' => 'main-menu',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'walker'         => new Gapyeong_Mobile_Nav_Walker(),
                        'depth'          => 2,
                    ));
                } else {
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-nav-link">홈</a>

                <div class="mobile-nav-group">
                    <button class="mobile-nav-toggle">교회소개 <i data-lucide="chevron-down"></i></button>
                    <div class="mobile-nav-dropdown">
                        <a href="/intro/greeting">인사말</a>
                        <a href="/intro/vision">비전</a>
                        <a href="/intro/history">연혁</a>
                        <a href="/intro/organization">조직도</a>
                        <a href="/intro/location">오시는 길</a>
                    </div>
                </div>

                <div class="mobile-nav-group">
                    <button class="mobile-nav-toggle">프로그램 <i data-lucide="chevron-down"></i></button>
                    <div class="mobile-nav-dropdown">
                        <a href="/program/worship">예배 시간</a>
                        <a href="/program/sabbath">안식일학교</a>
                        <a href="/program/pathfinder">패스파인더</a>
                        <a href="/program/youth">청년반</a>
                        <a href="/program/smallgroup">소그룹</a>
                    </div>
                </div>

                <div class="mobile-nav-group">
                    <button class="mobile-nav-toggle">부서 <i data-lucide="chevron-down"></i></button>
                    <div class="mobile-nav-dropdown">
                        <a href="/dept/#ministry">목회부</a>
                        <a href="/dept/#clerk">교회서기</a>
                        <a href="/dept/#treasury">교회재무</a>
                        <a href="/dept/#elders">장로회</a>
                        <a href="/dept/#deacons">집사회</a>
                        <a href="/dept/#mission">선교회</a>
                        <a href="/dept/#sabbath-school">안식일학교</a>
                        <a href="/dept/#community-service">지역사회봉사회</a>
                        <a href="/dept/#children">어린이부</a>
                        <a href="/dept/#youth-student">청년·학생 선교회</a>
                        <a href="/dept/#pathfinder">패스파인더</a>
                        <a href="/dept/#choir">찬양대</a>
                        <a href="/dept/#health-welfare">보건복지부</a>
                        <a href="/dept/#digital-media">디지털 홍보부</a>
                    </div>
                </div>

                <div class="mobile-nav-group">
                    <button class="mobile-nav-toggle">커뮤니티 <i data-lucide="chevron-down"></i></button>
                    <div class="mobile-nav-dropdown">
                        <a href="/community/notices">공지사항</a>
                        <a href="/community/gallery">갤러리</a>
                        <a href="/community/contact">문의하기</a>
                        <a href="/community/prayer">기도요청</a>
                    </div>
                </div>
                <?php } ?>
            </nav>
            <div class="mobile-menu-bottom">
                <div class="mobile-shortcuts">
                    <a href="<?php echo esc_url( $gapyeong_header_auth_url ); ?>" class="mobile-shortcut-item">
                        <i data-lucide="user"></i>
                        <span><?php echo esc_html( $gapyeong_header_auth_label ); ?></span>
                    </a>
                    <a href="/community/notices" class="mobile-shortcut-item">
                        <i data-lucide="bell"></i>
                        <span>공지사항</span>
                    </a>
                    <a href="/community/prayer" class="mobile-shortcut-item">
                        <i data-lucide="heart"></i>
                        <span>기도요청</span>
                    </a>
                    <a href="/live" class="mobile-shortcut-item highlight">
                        <i data-lucide="radio"></i>
                        <span>LIVE</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="mobile-menu-overlay"></div>

    </header>