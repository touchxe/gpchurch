<?php
/**
 * 가평교회 차일드 테마 functions.php
 *
 * 부모 테마의 스타일시트를 상속받고,
 * 차일드 테마 전용 스타일/스크립트를 추가합니다.
 */

// 부모 테마 + 차일드 테마 스타일 등록
function gapyeong_child_enqueue_styles()
{
    // 부모 테마 style.css (테마 선언용, 실제 CSS는 assets/css/ 에서 로드됨)
    wp_enqueue_style(
        'gapyeong-parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme()->parent()->get('Version')
    );

    // 차일드 테마 style.css
    wp_enqueue_style(
        'gapyeong-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('gapyeong-parent-style'),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'gapyeong_child_enqueue_styles');


/**
 * 주보 페이지에서만 라이트박스 CSS/JS 조건부 로드
 * 전역 오염 방지: bulletin 템플릿에서만 로드됨
 */
function gapyeong_child_enqueue_bulletin_lightbox()
{
    if (!is_page_template('page-templates/page-bulletin.php')) {
        return;
    }

    $child_uri = get_stylesheet_directory_uri();
    $version   = wp_get_theme()->get('Version') . '.1';

    wp_enqueue_style(
        'gpc-bulletin-lightbox-css',
        $child_uri . '/bulletin-lightbox.css',
        array(),
        $version
    );

    wp_enqueue_script(
        'gpc-bulletin-lightbox-js',
        $child_uri . '/bulletin-lightbox.js',
        array(),
        $version,
        true
    );
}
add_action('wp_enqueue_scripts', 'gapyeong_child_enqueue_bulletin_lightbox');


/**
 * 커뮤니티 서브메뉴 오버라이드
 * 부모 테마의 gapyeong_get_submenu() 함수를 필터로 확장
 * 주보, 교회일정 메뉴 항목 추가
 */
function gapyeong_child_filter_community_submenu($items)
{
    return array(
        array('label' => '공지사항',  'href' => '/community/notices'),
        array('label' => '갤러리',    'href' => '/community/gallery'),
        array('label' => '주보',      'href' => '/community/bulletin'),
        array('label' => '교회일정',  'href' => '/community/교회일정'),
        array('label' => '문의하기',  'href' => '/community/contact'),
        array('label' => '기도요청',  'href' => '/community/prayer'),
    );
}
add_filter('gapyeong_submenu_community', 'gapyeong_child_filter_community_submenu');
