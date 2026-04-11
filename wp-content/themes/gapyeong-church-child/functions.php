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
