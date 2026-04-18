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


/**
 * 로그인 페이지 전용: 커스텀 템플릿 자동 적용
 * 슬러그가 '로그인-화면'인 페이지에 카드 레이아웃 템플릿을 사용
 */
function gpc_is_login_page() {
    return is_page( '로그인-화면' )
        || is_page( '%eb%a1%9c%ea%b7%b8%ec%9d%b8-%ed%99%94%eb%a9%b4' )
        || is_page( 35 );
}

/**
 * 로그인 페이지 전용: 커스텀 템플릿 자동 적용
 */
function gpc_login_page_template( $template ) {
    if ( gpc_is_login_page() ) {
        $login_tpl = get_stylesheet_directory() . '/page-templates/page-login.php';
        if ( file_exists( $login_tpl ) ) {
            return $login_tpl;
        }
    }
    return $template;
}
add_filter( 'template_include', 'gpc_login_page_template' );

/**
 * 로그인 페이지 전용: CSS 조건부 로드
 */
function gpc_login_page_assets() {
    if ( ! gpc_is_login_page() ) {
        return;
    }
    wp_enqueue_style(
        'gpc-login-css',
        get_stylesheet_directory_uri() . '/wpmem-login.css',
        array( 'gapyeong-child-style', 'wp-members-css' ),
        wp_get_theme()->get( 'Version' ) . '.login2'
    );
}
add_action( 'wp_enqueue_scripts', 'gpc_login_page_assets' );

/**
 * WP-Members 로그인 폼 한글화 (필터로 변경 가능한 항목)
 */
function gpc_wpmem_login_defaults( $defaults ) {
    $defaults['heading']     = '';
    $defaults['button_text'] = '로그인 →';
    $defaults['txt']         = '로그인 상태 유지';
    $defaults['forgot']      = ' ';
    $defaults['forgot_link'] = '비밀번호 찾기';

    if ( isset( $defaults['inputs'] ) && is_array( $defaults['inputs'] ) ) {
        foreach ( $defaults['inputs'] as &$input ) {
            if ( 'log' === $input['tag'] ) {
                $input['name'] = '이메일 주소';
            } elseif ( 'pwd' === $input['tag'] ) {
                $input['name'] = '비밀번호';
            }
        }
        unset( $input );
    }

    return $defaults;
}
add_filter( 'wpmem_login_form_defaults', 'gpc_wpmem_login_defaults' );

/**
 * WP-Members 번역 보완 (gettext 도메인으로 출력되는 문자열)
 */
function gpc_wpmem_translate( $translated, $text, $domain ) {
    if ( 'wp-members' !== $domain ) {
        return $translated;
    }
    $map = array(
        'Remember Me'        => '로그인 상태 유지',
        'Forgot password?'   => '',
        'Click here to reset' => '비밀번호 찾기',
        'Existing Users Log In' => '',
        'Username or Email'  => '이메일 주소',
        'Password'           => '비밀번호',
        'Log In'             => '로그인 →',
    );
    return isset( $map[ $text ] ) ? $map[ $text ] : $translated;
}
add_filter( 'gettext', 'gpc_wpmem_translate', 10, 3 );
