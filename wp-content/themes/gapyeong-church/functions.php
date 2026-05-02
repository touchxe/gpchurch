<?php
/**
 * 가평교회 테마 functions.php
 * 스크립트/스타일 등록, 테마 지원 기능 설정
 */

// ── Walker 클래스 로드 ──
require_once get_template_directory() . '/inc/class-desktop-nav-walker.php';
require_once get_template_directory() . '/inc/class-mobile-nav-walker.php';
require_once get_template_directory() . '/inc/class-footer-nav-walker.php';

// 테마 기본 지원 기능 설정
function gapyeong_setup()
{
    // 타이틀 태그 자동 생성
    add_theme_support('title-tag');
    // 포스트 썸네일(대표 이미지) 지원
    add_theme_support('post-thumbnails');
    // HTML5 시맨틱 마크업 지원
    add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption'));

    // 내비게이션 메뉴 등록
    register_nav_menus(array(
        'main-menu' => '메인 내비게이션 (헤더 + 모바일)',
        'footer-intro' => '푸터 - 교회소개',
        'footer-program' => '푸터 - 프로그램',
        'footer-community' => '푸터 - 커뮤니티',
    ));
}
add_action('after_setup_theme', 'gapyeong_setup');


/**
 * SEO: 페이지별 Meta Description 자동 생성
 *
 * Lighthouse SEO 검사에서 모든 페이지에 meta description 부재 지적(L-03).
 * 이 함수는 wp_head 훅으로 각 페이지에 맞는 description을 출력합니다.
 * Yoast SEO 또는 All in One SEO 플러그인이 활성화된 경우에는 출력하지 않습니다.
 */
function gapyeong_meta_description()
{
    // SEO 플러그인이 이미 meta description을 관리하면 중복 출력 방지
    if (defined('WPSEO_VERSION') || defined('AIOSEOP_VERSION') || class_exists('AIOSEOP_Core')) {
        return;
    }

    // 페이지별 설명 정의
    $description_map = array(
        // 교회소개
        'greeting'     => '가평 제칠일 안식일 예수재림교회 담임목사 위수민의 인사말입니다. 하나님의 사랑 안에서 함께하는 가평교회에 오신 것을 환영합니다.',
        'vision'       => '가평교회의 2026년 비전과 4대 공동체, 5대 중점 목표를 소개합니다. 말씀을 사랑으로 실천하는 성령의 교회.',
        'history'      => '가평 제칠일 안식일 예수재림교회의 역사와 연혁을 소개합니다.',
        'organization' => '가평교회의 담임목사, 장로, 각 부서 조직도를 안내합니다.',
        'location'     => '가평교회 오시는 길 안내입니다. 경기도 가평군 가평읍 석봉로 153번길 2에 위치합니다.',
        // 프로그램
        'worship'      => '가평교회 예배 시간 안내입니다. 안식일(토) 11시 예배, 금요일 저녁 7시 30분 예비 예배.',
        'sabbath'      => '가평교회 안식일학교 안내입니다. 매주 안식일 오전 9시 30분, 연령별 성경 공부와 교과 토의.',
        'pathfinder'   => '가평교회 패스파인더 클럽 소개입니다. 어린이·청소년을 위한 야외 활동과 봉사 프로그램.',
        'youth'        => '가평교회 청년반 소개입니다. 청년들이 함께 신앙을 나누며 성장하는 공동체.',
        'smallgroup'   => '가평교회 소그룹 모임 안내입니다. 이웃을 섬기며 사랑을 실천하는 소그룹 활동.',
        // 커뮤니티
        'notices'      => '가평교회 공지사항입니다. 교회의 최신 소식과 주요 안내사항을 확인하세요.',
        'gallery'      => '가평교회 사진 갤러리입니다. 교회 활동과 행사 사진을 감상하세요.',
        'contact'      => '가평교회에 문의하세요. 예배 참석, 교회 활동 참여, 기타 문의 사항을 남겨주세요.',
        'prayer'       => '가평교회 기도요청 게시판입니다. 기도 제목을 나누고 함께 기도합니다.',
    );

    $description = '';

    if (is_front_page() || is_home()) {
        $description = '가평 제칠일 안식일 예수재림교회(Gapyeong SDA Church)입니다. 매주 토요일 안식일 예배로 여러분을 초대합니다. 경기도 가평군 가평읍 석봉로 153번길 2.';
    } elseif (is_singular('page')) {
        $post = get_post();
        if ($post) {
            // 현재 페이지 슬러그로 설명 찾기
            $slug = $post->post_name;
            if (isset($description_map[$slug])) {
                $description = $description_map[$slug];
            } else {
                // 부모 페이지 슬러그로 찾기
                $parent = get_post($post->post_parent);
                if ($parent) {
                    $parent_slug = $parent->post_name;
                    $description_map_parent = array(
                        'dept' => '가평교회 ' . get_the_title() . ' 부서 소개입니다.',
                    );
                    $description = isset($description_map_parent[$parent_slug])
                        ? $description_map_parent[$parent_slug]
                        : get_the_title() . ' — 가평 제칠일 안식일 예수재림교회.';
                } else {
                    $description = get_the_title() . ' — 가평 제칠일 안식일 예수재림교회.';
                }
            }
        }
    }

    // 필터로 외부에서 description 오버라이드 가능
    $description = apply_filters('gapyeong_meta_description', $description);

    if (!empty($description)) {
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    }
}
add_action('wp_head', 'gapyeong_meta_description', 1);


function gapyeong_enqueue_scripts()
{
    $uri = get_template_directory_uri();
    $version = '20260502-live-air-test-10m-v1';

    // === Fonts ===
    wp_enqueue_style(
        'pretendard',
        'https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/static/pretendard.min.css',
        array(),
        null
    );

    // === External Libraries (CSS) ===
    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        array(),
        '11'
    );

    // === Theme CSS (로드 순서 중요) ===

    // 1. 메인 스타일시트 (CSS 변수, 리셋, 기본 컴포넌트)
    wp_enqueue_style(
        'gapyeong-main-css',
        $uri . '/assets/css/style.css',
        array('pretendard', 'swiper-css'),
        $version
    );

    // 2. 레이아웃 (헤더, 드롭다운 메뉴 숨김 처리, 푸터, 히어로)
    wp_enqueue_style(
        'gapyeong-layout-css',
        $uri . '/assets/css/layout.css',
        array('gapyeong-main-css'),
        $version
    );

    // 2-1. 모바일 메뉴 (독립 스타일)
    wp_enqueue_style(
        'gapyeong-mobile-menu-css',
        $uri . '/assets/css/mobile-menu.css',
        array('gapyeong-layout-css'),
        $version
    );

    // 3. 공통 컴포넌트
    wp_enqueue_style(
        'gapyeong-common-css',
        $uri . '/assets/css/common.css',
        array('gapyeong-layout-css'),
        $version
    );

    // 4. UI 컴포넌트
    wp_enqueue_style(
        'gapyeong-components-css',
        $uri . '/assets/css/components.css',
        array('gapyeong-common-css'),
        $version
    );

    // 5. 모바일 메뉴
    wp_enqueue_style(
        'gapyeong-mobile-menu-css',
        $uri . '/assets/css/mobile-menu.css',
        array('gapyeong-layout-css'),
        $version
    );

    // mobile-menu-enhanced.css — REMOVED (conflicts with mobile-menu.css white design)



    // 6. 서브메뉴 탭 스타일
    wp_enqueue_style(
        'gapyeong-submenu-pills-css',
        $uri . '/assets/css/submenu-pills.css',
        array('gapyeong-common-css'),
        $version
    );

    // === External Libraries (JS) ===
    wp_enqueue_script(
        'lucide',
        'https://unpkg.com/lucide@latest/dist/umd/lucide.min.js',
        array(),
        null,
        false // <head>에서 로드 (아이콘 초기화 필요)
    );

    wp_enqueue_script(
        'swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        array(),
        '11',
        false
    );

    wp_enqueue_script(
        'gsap',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js',
        array(),
        '3.12.5',
        false
    );

    wp_enqueue_script(
        'gsap-scrolltrigger',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js',
        array('gsap'),
        '3.12.5',
        false
    );

    // === Theme JS ===
    wp_enqueue_script(
        'gapyeong-common-js',
        $uri . '/assets/js/common.js',
        array('lucide', 'gsap', 'gsap-scrolltrigger'),
        $version,
        true // </body> 직전
    );

    wp_enqueue_script(
        'gapyeong-main-js',
        $uri . '/assets/js/main.js',
        array('gapyeong-common-js', 'swiper-js'),
        $version,
        true
    );

    // === 페이지 템플릿별 조건부 CSS ===
    if (is_page_template('page-templates/page-vision.php')) {
        wp_enqueue_style(
            'gapyeong-vision-css',
            $uri . '/assets/css/vision-premium.css',
            array('gapyeong-main-css'),
            $version
        );
    }

    if (is_page_template('page-templates/page-history.php')) {
        wp_enqueue_style(
            'gapyeong-history-chevrons-css',
            $uri . '/assets/css/history-chevrons.css',
            array('gapyeong-main-css'),
            $version
        );
        wp_enqueue_style(
            'gapyeong-history-design-css',
            $uri . '/assets/css/history-design.css',
            array('gapyeong-history-chevrons-css'),
            $version
        );
    }

    if (is_page_template('page-templates/page-worship.php')) {
        wp_enqueue_style(
            'gapyeong-worship-css',
            $uri . '/assets/css/worship-design.css',
            array('gapyeong-main-css'),
            $version
        );
    }

    if (is_page_template('page-templates/page-sabbath.php')) {
        wp_enqueue_style(
            'gapyeong-sabbath-css',
            $uri . '/assets/css/sabbath-design.css',
            array('gapyeong-main-css'),
            $version
        );
    }

    if (is_page_template('page-templates/page-pathfinder.php')) {
        wp_enqueue_style(
            'gapyeong-pathfinder-css',
            $uri . '/assets/css/pathfinder-design.css',
            array('gapyeong-main-css'),
            $version
        );
    }

    if (is_page_template('page-templates/page-youth.php')) {
        wp_enqueue_style(
            'gapyeong-youth-css',
            $uri . '/assets/css/youth-design.css',
            array('gapyeong-main-css'),
            $version
        );
    }

    if (is_page_template('page-templates/page-smallgroup.php')) {
        wp_enqueue_style(
            'gapyeong-smallgroup-css',
            $uri . '/assets/css/smallgroup-design.css',
            array('gapyeong-main-css'),
            $version
        );
    }

    // === 부서(dept) 페이지 공용 CSS ===
    $dept_templates = array(
        'page-templates/page-dept.php',           // 통합 부서 페이지
        'page-templates/page-dept-ministry.php',
        'page-templates/page-dept-clerk.php',
        'page-templates/page-dept-treasury.php',
        'page-templates/page-dept-elders.php',
        'page-templates/page-dept-deacons.php',
        'page-templates/page-dept-mission.php',
        'page-templates/page-dept-sabbath-school.php',
        'page-templates/page-dept-community-service.php',
        'page-templates/page-dept-children.php',
        'page-templates/page-dept-youth-student.php',
        'page-templates/page-dept-pathfinder.php',
        'page-templates/page-dept-choir.php',
        'page-templates/page-dept-health-welfare.php',
        'page-templates/page-dept-digital-media.php',
    );
    foreach ($dept_templates as $dept_tpl) {
        if (is_page_template($dept_tpl)) {
            wp_enqueue_style(
                'gapyeong-department-css',
                $uri . '/assets/css/department-design.css',
                array('gapyeong-main-css'),
                $version
            );
            break;
        }
    }

    // === KBoard notice-skin CSS 강제 로드 ===
    wp_enqueue_style(
        'kboard-notice-skin',
        WP_CONTENT_URL . '/plugins/kboard/skin/notice-skin/style.css',
        array('gapyeong-main-css'),
        '20260228'
    );

    // === KBoard calendar-skin CSS 강제 로드 ===
    wp_enqueue_style(
        'kboard-calendar-skin',
        WP_CONTENT_URL . '/plugins/kboard/skin/calendar-skin/style.css',
        array('gapyeong-main-css'),
        '20260228'
    );
}
add_action('wp_enqueue_scripts', 'gapyeong_enqueue_scripts');


/**
 * REST API: 교회 일정 조회 엔드포인트
 * GET /wp-json/gapyeong/v1/schedule?board_id=5&year=2026&month=02
 * KBoard calendar-skin 게시판의 event_date 옵션 기준으로 필터링
 */
function gapyeong_register_schedule_api()
{
    register_rest_route('gapyeong/v1', '/schedule', array(
        'methods' => 'GET',
        'callback' => 'gapyeong_get_schedule',
        'permission_callback' => '__return_true',
        'args' => array(
            'board_id' => array('required' => true, 'sanitize_callback' => 'absint'),
            'year' => array('required' => true, 'sanitize_callback' => 'absint'),
            'month' => array('required' => true, 'sanitize_callback' => 'absint'),
        ),
    ));
}
add_action('rest_api_init', 'gapyeong_register_schedule_api');

function gapyeong_get_schedule(WP_REST_Request $request)
{
    global $wpdb;

    $board_id = (int) $request->get_param('board_id');
    $year     = (int) $request->get_param('year');
    $month    = (int) $request->get_param('month');

    // 해당 월의 첫날 / 마지막날
    $month_first = sprintf('%04d-%02d-01', $year, $month);
    $month_last  = date('Y-m-t', strtotime($month_first)); // e.g. 2026-03-31

    $content_table = $wpdb->prefix . 'kboard_board_content';
    $options_table = $wpdb->prefix . 'kboard_board_option';

    // 테이블 존재 확인
    if (!$wpdb->get_var("SHOW TABLES LIKE '{$options_table}'")) {
        return new WP_REST_Response(
            array('error' => 'table_not_found', 'table' => $options_table), 200
        );
    }

    // 시작일(event_date) + 종료일(event_end_date) 동시 조회
    // 해당 월과 겹치는 조건: 시작일 <= 월말  AND  (종료일 >= 월초 OR 종료일 없음)
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT
             c.uid,
             c.title,
             o_start.option_value            AS event_date,
             COALESCE(o_end.option_value, '') AS event_end_date
         FROM {$content_table} c
         INNER JOIN {$options_table} o_start
             ON c.uid = o_start.content_uid AND o_start.option_key = 'event_date'
         LEFT JOIN {$options_table} o_end
             ON c.uid = o_end.content_uid   AND o_end.option_key   = 'event_end_date'
         WHERE c.board_id = %d
           AND c.status  != 'trash'
           AND o_start.option_value <= %s
           AND (o_end.option_value >= %s OR o_end.option_value IS NULL OR o_end.option_value = '')
           AND o_start.option_value >= %s
         ORDER BY o_start.option_value ASC
         LIMIT 4",
        $board_id,
        $month_last,   // 시작일 <= 월말
        $month_first,  // 종료일 >= 월초 (또는 없음 → 시작일만 검사)
        $month_first   // 시작일 >= 월초 (종료일 없는 단건도 해당 월만 표시)
    ));

    $data = array();
    foreach ($results as $row) {
        $ts_start = strtotime($row->event_date);
        if (!$ts_start) continue;

        $end_date = $row->event_end_date ?: $row->event_date; // 종료일 없으면 시작일과 동일
        $ts_end   = strtotime($end_date);
        if (!$ts_end || $ts_end < $ts_start) $ts_end = $ts_start;

        // 해당 월에 해당하는 날짜의 day 배열 생성 (달력 초록 점 표시용)
        $days        = array();
        $month_days  = (int) date('t', $ts_start > strtotime($month_first) ? $ts_start : strtotime($month_first));
        $loop_start  = max($ts_start, strtotime($month_first));
        $loop_end    = min($ts_end,   strtotime($month_last));
        for ($t = $loop_start; $t <= $loop_end; $t = strtotime('+1 day', $t)) {
            $days[] = (int) date('j', $t);
        }

        // 표시용 날짜 문자열
        if ($end_date && $end_date !== $row->event_date) {
            $display_date = date('m.d', $ts_start) . '~' . date('m.d', $ts_end);
        } else {
            $display_date = date('m.d', $ts_start);
        }

        // KBoard 내장 바로가기 URL
        $doc_url = site_url('?kboard_content_redirect=' . intval($row->uid));

        $data[] = array(
            'uid'            => (int) $row->uid,
            'title'          => $row->title,
            'event_date'     => $row->event_date,
            'event_end_date' => $end_date !== $row->event_date ? $end_date : '',
            'day'            => (int) date('j', $ts_start),
            'days'           => $days,
            'display_date'   => $display_date,
            'url'            => $doc_url,
        );
    }

    return new WP_REST_Response($data, 200);
}

/**
 * KBoard 게시판 ID로 해당 게시판이 표시된 WordPress 페이지 ID 조회
 * 방법 1: postmeta kboard_id
 * 방법 2: 페이지 본문 내 [kboard id="{id}"] shortcode 검색
 */
function gapyeong_get_kboard_page_id($board_id)
{
    global $wpdb;

    // 방법 1: postmeta
    $page_id = $wpdb->get_var($wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta}
         WHERE meta_key = 'kboard_id' AND meta_value = %d
         LIMIT 1",
        $board_id
    ));
    if ($page_id)
        return (int) $page_id;

    // 방법 2: shortcode [kboard id="3"] 또는 [kboard_latestview id="3"] 패턴 검색
    $like1 = '%[kboard id="' . (int) $board_id . '"%';
    $like2 = '%[kboard id=\'' . (int) $board_id . '\'' . '%';

    $page_id = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts}
         WHERE post_status = 'publish'
           AND post_type IN ('page','post')
           AND (post_content LIKE %s OR post_content LIKE %s)
         LIMIT 1",
        $like1,
        $like2
    ));

    return $page_id ? (int) $page_id : 0;
}


/**
 * page-templates/ 서브 폴더 내의 페이지 템플릿 등록
 *
 * WordPress는 기본적으로 테마 루트만 스캔하므로,
 * 서브 폴더의 템플릿을 인식시키기 위해 필터를 사용합니다.
 */
function gapyeong_register_page_templates($templates)
{
    $template_dir = get_template_directory() . '/page-templates/';

    if (!is_dir($template_dir)) {
        return $templates;
    }

    $files = glob($template_dir . '*.php');
    foreach ($files as $file) {
        $basename = basename($file);
        $relative = 'page-templates/' . $basename;

        // 파일에서 Template Name 추출
        $data = get_file_data($file, array('Template Name' => 'Template Name'));
        if (!empty($data['Template Name'])) {
            $templates[$relative] = $data['Template Name'];
        }
    }

    return $templates;
}
add_filter('theme_page_templates', 'gapyeong_register_page_templates');


/**
 * WP 메인 메뉴에서 특정 그룹의 서브메뉴 아이템을 추출
 *
 * 메인 메뉴의 최상위 아이템 중 $group_slug와 일치하는 항목의
 * 자식 메뉴 아이템들을 반환합니다.
 *
 * @param  string $group_slug  그룹 슬러그 (예: 'intro')
 * @return array|false         서브 아이템 배열 또는 실패 시 false
 */
function gapyeong_get_submenu_from_wp_menu($group_slug)
{
    if (!has_nav_menu('main-menu')) {
        return false;
    }

    $locations = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object($locations['main-menu']);

    if (!$menu) {
        return false;
    }

    $items = wp_get_nav_menu_items($menu->term_id);
    if (!$items) {
        return false;
    }

    // 최상위 아이템 중 그룹에 해당하는 것 찾기
    $parent_id = 0;
    foreach ($items as $item) {
        if ($item->menu_item_parent == 0) {
            // URL에서 슬러그 추출 또는 연결된 페이지의 슬러그와 비교
            $url_path = wp_parse_url($item->url, PHP_URL_PATH) ?? '';
            $url_path = trim($url_path, '/');

            // 페이지 연결형인 경우
            if ($item->object === 'page' && $item->object_id) {
                $page = get_post($item->object_id);
                if ($page && $page->post_name === $group_slug) {
                    $parent_id = $item->ID;
                    break;
                }
            }

            // URL 경로가 그룹 슬러그와 일치하는 경우
            if ($url_path === $group_slug) {
                $parent_id = $item->ID;
                break;
            }
        }
    }

    if (!$parent_id) {
        return false;
    }

    // 자식 아이템 수집
    $submenu = array();
    foreach ($items as $item) {
        if ($item->menu_item_parent == $parent_id) {
            $submenu[] = array(
                'label' => $item->title,
                'href' => wp_parse_url($item->url, PHP_URL_PATH) ?? $item->url,
            );
        }
    }

    return !empty($submenu) ? $submenu : false;
}


/**

 * 서브메뉴 그룹 데이터 레지스트리
 *
 * 사이트의 모든 서브메뉴 목록을 한 곳에서 관리합니다.
 * 새 섹션 추가 시 이 배열에만 추가하면 됩니다.
 *
 * @param  string $group  그룹 키 (예: 'intro', 'program', 'community', 'dept')
 * @return array          해당 그룹의 서브메뉴 아이템 배열
 */
function gapyeong_get_submenu($group)
{
    $menus = array(

        // 교회소개
        'intro' => array(
            array('label' => '인사말', 'href' => '/intro/greeting'),
            array('label' => '비전', 'href' => '/intro/vision'),
            array('label' => '연혁', 'href' => '/intro/history'),
            array('label' => '조직도', 'href' => '/intro/organization'),
            array('label' => '오시는 길', 'href' => '/intro/location'),
        ),

        // 프로그램
        'program' => array(
            array('label' => '예배 시간', 'href' => '/program/worship'),
            array('label' => '안식일학교', 'href' => '/program/sabbath'),
            array('label' => '패스파인더', 'href' => '/program/pathfinder'),
            array('label' => '청년반', 'href' => '/program/youth'),
            array('label' => '소그룹', 'href' => '/program/smallgroup'),
        ),

        // 커뮤니티
        'community' => array(
            array('label' => '공지사항', 'href' => '/community/notices'),
            array('label' => '갤러리', 'href' => '/community/gallery'),
            array('label' => '문의하기', 'href' => '/community/contact'),
            array('label' => '기도요청', 'href' => '/community/prayer'),
        ),

        // 부서
        'dept' => array(
            array('label' => '목회부', 'href' => '/dept/#ministry'),
            array('label' => '교회서기', 'href' => '/dept/#clerk'),
            array('label' => '교회재무', 'href' => '/dept/#treasury'),
            array('label' => '장로회', 'href' => '/dept/#elders'),
            array('label' => '집사회', 'href' => '/dept/#deacons'),
            array('label' => '선교회', 'href' => '/dept/#mission'),
            array('label' => '안식일학교', 'href' => '/dept/#sabbath-school'),
            array('label' => '지역사회봉사회', 'href' => '/dept/#community-service'),
            array('label' => '어린이부', 'href' => '/dept/#children'),
            array('label' => '청년·학생 선교회', 'href' => '/dept/#youth-student'),
            array('label' => '패스파인더', 'href' => '/dept/#pathfinder'),
            array('label' => '찬양대', 'href' => '/dept/#choir'),
            array('label' => '보건복지부', 'href' => '/dept/#health-welfare'),
            array('label' => '디지털 홍보부', 'href' => '/dept/#digital-media'),
        ),

    );

    $result = isset($menus[$group]) ? $menus[$group] : array();
    // 자식 테마에서 서브메뉴를 그룹별로 오버라이드할 수 있도록 필터 적용
    return apply_filters('gapyeong_submenu_' . $group, $result);
}


/**
 * 현재 페이지의 서브페이지 컨텍스트를 자동 감지
 *
 * URL 구조(부모 slug)를 기반으로 submenu 그룹, 활성 메뉴,
 * 빵조각, 슬로건 정보를 한 번에 반환합니다.
 *
 * @return array|false  컨텍스트 배열 또는 서브페이지가 아닐 경우 false
 */
function gapyeong_get_page_context()
{
    // 그룹별 한글 레이블 & 기본 슬로건
    $group_labels = array(
        'intro' => array('label' => '교회소개', 'slogan' => '하나님의 사랑 안에서 함께하는 가평교회'),
        'program' => array('label' => '프로그램', 'slogan' => '은혜와 성장을 위한 다양한 프로그램'),
        'community' => array('label' => '커뮤니티', 'slogan' => '함께 나누고 소통하는 교회 공동체'),
        'dept' => array('label' => '부서', 'slogan' => '각 부서가 하나 되어 섬기는 교회'),
    );

    // 현재 페이지의 부모 slug 감지
    $post = get_post();
    if (!$post || $post->post_parent === 0) {
        return false; // 최상위 페이지이면 서브페이지 구조 없음
    }

    $parent = get_post($post->post_parent);
    if (!$parent) {
        return false;
    }

    $group = $parent->post_name; // 예: 'intro', 'program' 등

    // 그룹 정보 결정: 등록된 그룹 또는 미등록 그룹(범용 fallback)
    if (isset($group_labels[$group])) {
        $info = $group_labels[$group];
    } else {
        // 어느 그룹에도 속하지 않는 서브페이지 → 부모 페이지 제목 사용
        $info = array(
            'label' => get_the_title($parent),
            'slogan' => '',
        );
    }

    // submenu 데이터: WP 메뉴 우선, 하드코딩 fallback
    $items = false;
    if (function_exists('gapyeong_get_submenu_from_wp_menu')) {
        $items = gapyeong_get_submenu_from_wp_menu($group);
    }
    if (!$items) {
        $items = gapyeong_get_submenu($group);
    }

    // WP 메뉴·하드코딩 모두 없으면 부모의 자식 페이지에서 자동 생성
    if (empty($items)) {
        $siblings = get_pages(array(
            'parent' => $parent->ID,
            'sort_column' => 'menu_order,post_title',
        ));
        foreach ($siblings as $sibling) {
            $items[] = array(
                'label' => get_the_title($sibling),
                'href' => '/' . $group . '/' . $sibling->post_name,
            );
        }
    }

    // post_name이 URL인코딩된 경우(한글 슬러그 등) 디코딩하여 비교
    $current_path = '/' . $group . '/' . urldecode($post->post_name); // 예: /community/교회일정
    $page_label = get_the_title();

    foreach ($items as $item) {
        // href도 urldecode 후 비교하여 인코딩 불일치 방지
        if (urldecode($item['href']) === $current_path) {
            $page_label = $item['label'];
            break;
        }
    }

    return array(
        'group' => $group,
        'active_href' => $current_path,
        'title' => $page_label,
        'slogan' => $info['slogan'],
        'breadcrumb' => array(
            array('label' => $info['label'], 'href' => '/' . $group),
            array('label' => $page_label, 'href' => ''),
        ),
    );
}


/**
 * ACF 필드 그룹 등록: 히어로 슬라이더 이미지
 *
 * ACF 무료 버전 호환 — 슬라이드 이미지 최대 5개를 개별 필드로 등록합니다.
 * 워드프레스 관리자 → 홈페이지(Front Page) 편집 화면에서 이미지를 교체하세요.
 */
function gapyeong_register_acf_hero_slider()
{
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // 슬라이드 이미지 필드 5개 생성
    $sub_fields = array();
    for ($i = 1; $i <= 5; $i++) {
        $sub_fields[] = array(
            'key' => 'field_hero_slide_' . $i,
            'label' => '슬라이드 ' . $i . ' 이미지',
            'name' => 'hero_slide_' . $i,
            'type' => 'image',
            'instructions' => $i === 1 ? '필수. 첫 번째 슬라이드 이미지를 선택하세요.' : '선택. 비워두면 이 슬라이드는 표시되지 않습니다.',
            'required' => ($i === 1) ? 0 : 0,
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        );
    }

    acf_add_local_field_group(array(
        'key' => 'group_hero_slider',
        'title' => '히어로 슬라이더 이미지',
        'fields' => $sub_fields,
        'location' => array(
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));
}
add_action('acf/init', 'gapyeong_register_acf_hero_slider');


/**
 * ACF 필드 그룹 등록: 히어로 텍스트 & 버튼
 *
 * 관리자 → 홈페이지 편집 화면에서 히어로 왼쪽 영역
 * (라벨, 제목, 부제목, 버튼)을 수정할 수 있습니다.
 */
function gapyeong_register_acf_hero_text()
{
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_hero_text',
        'title' => '히어로 텍스트 & 버튼',
        'fields' => array(

            // ── 라벨 ──────────────────────────────────────────
            array(
                'key' => 'field_hero_label_1',
                'label' => '라벨 1 (한글 교회명)',
                'name' => 'hero_label_1',
                'type' => 'text',
                'placeholder' => '제칠일안식일예수재림교회',
                'default_value' => '제칠일안식일예수재림교회',
            ),
            array(
                'key' => 'field_hero_label_2',
                'label' => '라벨 2 (영문 교회명)',
                'name' => 'hero_label_2',
                'type' => 'text',
                'placeholder' => 'Gapyeong SDA Church',
                'default_value' => 'Gapyeong SDA Church',
            ),

            // ── 제목 ──────────────────────────────────────────
            array(
                'key' => 'field_hero_title_1',
                'label' => '제목 1행 (흰색)',
                'name' => 'hero_title_1',
                'type' => 'text',
                'placeholder' => '하나님의 사랑 안에서',
                'default_value' => '하나님의 사랑 안에서',
            ),
            array(
                'key' => 'field_hero_title_2',
                'label' => '제목 2행 (보라색 강조)',
                'name' => 'hero_title_2',
                'type' => 'text',
                'placeholder' => '함께하는 가평교회',
                'default_value' => '함께하는 가평교회',
            ),

            // ── 부제목 ────────────────────────────────────────
            array(
                'key' => 'field_hero_subtitle',
                'label' => '부제목',
                'name' => 'hero_subtitle',
                'type' => 'textarea',
                'rows' => 3,
                'instructions' => '줄바꿈은 Enter로 입력하세요.',
                'placeholder' => "매주 토요일 안식일 예배로 여러분을 초대합니다.\n말씀과 찬양으로 하나님께 영광을 돌리는 공동체입니다.",
                'default_value' => "매주 토요일 안식일 예배로 여러분을 초대합니다.\n말씀과 찬양으로 하나님께 영광을 돌리는 공동체입니다.",
            ),

            // ── 버튼 1 ────────────────────────────────────────
            array(
                'key' => 'field_hero_btn1_text',
                'label' => '버튼 1 텍스트',
                'name' => 'hero_btn1_text',
                'type' => 'text',
                'placeholder' => '예배 시간 안내',
                'default_value' => '예배 시간 안내',
            ),
            array(
                'key' => 'field_hero_btn1_url',
                'label' => '버튼 1 링크 URL',
                'name' => 'hero_btn1_url',
                'type' => 'url',
                'placeholder' => '/program/worship',
                'default_value' => '/program/worship',
            ),

            // ── 버튼 2 (신규) ─────────────────────────────────
            array(
                'key' => 'field_hero_btn2_text',
                'label' => '버튼 2 텍스트',
                'name' => 'hero_btn2_text',
                'type' => 'text',
                'instructions' => '비워두면 버튼이 표시되지 않습니다.',
                'placeholder' => '예: 교회 소개',
            ),
            array(
                'key' => 'field_hero_btn2_url',
                'label' => '버튼 2 링크 URL',
                'name' => 'hero_btn2_url',
                'type' => 'url',
                'placeholder' => '/intro/greeting',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));
}
add_action('acf/init', 'gapyeong_register_acf_hero_text');

