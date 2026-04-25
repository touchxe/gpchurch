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
 * 슬러그 기준 마이페이지 (비밀번호 재설정 URL 등)
 */
function gpc_is_mypage() {
    if ( ! is_page() ) {
        return false;
    }
    return is_page( '마이페이지' )
        || is_page( '%eb%a7%88%ec%9d%b4%ed%8e%98%ec%9d%b4%ec%a7%80' );
}

/**
 * WP-Members `a` 쿼리 (마이페이지 등)
 */
function gpc_mypage_action() {
    return isset( $_GET['a'] ) ? sanitize_key( wp_unslash( $_GET['a'] ) ) : '';
}

/**
 * 마이페이지에서 비밀번호·키 기반 재설정 폼 (로그아웃 상태 포함)
 */
function gpc_is_mypage_password_shell() {
    if ( ! gpc_is_mypage() ) {
        return false;
    }
    return in_array(
        gpc_mypage_action(),
        array( 'pwdreset', 'pwdchange', 'set_password_from_key' ),
        true
    );
}

/**
 * WP-Members에 설정된 프로필 페이지인지 (슬러그 변경에도 대응)
 */
function gpc_is_wp_members_profile_page() {
    if ( ! is_page() || ! function_exists( 'wpmem_profile_url' ) ) {
        return false;
    }
    $current = trailingslashit( get_permalink( get_queried_object_id() ) );
    $profile = trailingslashit( wpmem_profile_url() );
    return $current === $profile;
}

/**
 * 로그인한 사용자 프로필(대시보드·정보 수정 등) 카드 셸 — 비밀번호 재설정 전용 셸과 제외 관계
 */
function gpc_is_mypage_profile_shell() {
    if ( ! is_user_logged_in() || ! is_page() ) {
        return false;
    }
    if ( gpc_is_mypage_password_shell() ) {
        return false;
    }
    return gpc_is_wp_members_profile_page();
}

/**
 * 비밀번호 재설정 등: 마이페이지 + a= 쿼리
 */
function gpc_mypage_password_shell_template( $template ) {
    if ( ! gpc_is_mypage_password_shell() ) {
        return $template;
    }
    $shell = get_stylesheet_directory() . '/page-templates/page-mypage-password-shell.php';
    return file_exists( $shell ) ? $shell : $template;
}
add_filter( 'template_include', 'gpc_mypage_password_shell_template', 13 );

/**
 * 프로필 페이지: 로그인·비밀번호 찾기와 동일 카드 셸
 */
function gpc_mypage_profile_shell_template( $template ) {
    if ( ! gpc_is_mypage_profile_shell() ) {
        return $template;
    }
    $shell = get_stylesheet_directory() . '/page-templates/page-mypage-profile-shell.php';
    return file_exists( $shell ) ? $shell : $template;
}
add_filter( 'template_include', 'gpc_mypage_profile_shell_template', 14 );

/**
 * 로그인·마이페이지 비밀번호·프로필: WP-Members 카드 폼 스타일
 */
function gpc_login_page_assets() {
    if ( ! gpc_is_login_page() && ! gpc_is_mypage_password_shell() && ! gpc_is_mypage_profile_shell() ) {
        return;
    }
    wp_enqueue_style(
        'gpc-login-css',
        get_stylesheet_directory_uri() . '/wpmem-login.css',
        array( 'gapyeong-child-style' ),
        wp_get_theme()->get( 'Version' ) . '.login7'
    );

    if ( gpc_is_mypage_profile_shell() && 'edit' === gpc_mypage_action() ) {
        wp_enqueue_style(
            'gpc-register-css',
            get_stylesheet_directory_uri() . '/wpmem-register.css',
            array( 'gapyeong-child-style' ),
            wp_get_theme()->get( 'Version' ) . '.reg5'
        );
    }
}
add_action( 'wp_enqueue_scripts', 'gpc_login_page_assets', 99 );

/**
 * 프로필 허브 링크에 로그아웃 추가 + 카드형 목록 마크업
 */
function gpc_wpmem_member_links_args( $arr ) {
    if ( ! is_user_logged_in() || ! gpc_is_wp_members_profile_page() ) {
        return $arr;
    }
    if ( gpc_is_mypage_password_shell() ) {
        return $arr;
    }

    $arr['wrapper_before'] = '<ul class="gpc-profile-menu">';
    $arr['wrapper_after']  = '</ul>';

    if ( ! empty( $arr['rows'] ) && is_array( $arr['rows'] ) ) {
        foreach ( $arr['rows'] as $i => $row ) {
            if ( ! is_string( $row ) || '' === trim( $row ) ) {
                continue;
            }
            if ( false !== strpos( $row, 'gpc-profile-menu__item' ) ) {
                continue;
            }
            $arr['rows'][ $i ] = preg_replace( '/<li>/', '<li class="gpc-profile-menu__item">', $row, 1 );
        }
    }

    if ( function_exists( 'wpmem_logout_link' ) ) {
        $logout_href = wpmem_logout_link();
    } else {
        $logout_href = wp_logout_url( home_url( '/' ) );
    }
    $arr['rows'][] = '<li class="gpc-profile-menu__item gpc-profile-menu__item--logout"><a href="'
        . esc_url( $logout_href ) . '">' . esc_html__( '로그아웃', 'gapyeong-church-child' ) . '</a></li>';

    return $arr;
}
add_filter( 'wpmem_member_links_args', 'gpc_wpmem_member_links_args', 10, 1 );

/**
 * 마이페이지 비밀번호 재설정 요청 폼 문구
 */
function gpc_wpmem_resetpassword_form_defaults( $arr, $form ) {
    if ( 'resetpassword' !== $form || ! gpc_is_mypage_password_shell() ) {
        return $arr;
    }
    $arr['heading']     = '';
    $arr['button_text'] = '재설정 메일 보내기';
    if ( ! empty( $arr['inputs'] ) && is_array( $arr['inputs'] ) ) {
        foreach ( $arr['inputs'] as &$input ) {
            if ( isset( $input['tag'] ) && 'user' === $input['tag'] ) {
                $input['name'] = '이메일 주소';
            }
        }
        unset( $input );
    }
    return $arr;
}
add_filter( 'wpmem_resetpassword_form_defaults', 'gpc_wpmem_resetpassword_form_defaults', 10, 2 );

/**
 * 메일 링크 이후 새 비밀번호 입력 폼 (같은 마이페이지에서 a=pwdchange 등)
 */
function gpc_wpmem_changepassword_form_defaults( $arr, $form ) {
    if ( 'changepassword' !== $form || ! gpc_is_mypage_password_shell() ) {
        return $arr;
    }
    $arr['heading']     = '';
    $arr['button_text'] = '새 비밀번호 저장';

    $a_req = function_exists( 'wpmem_get' ) ? wpmem_get( 'a', '', 'request' ) : '';
    if ( 'set_password_from_key' === $a_req ) {
        if ( ! empty( $arr['inputs'] ) && is_array( $arr['inputs'] ) ) {
            foreach ( $arr['inputs'] as &$input ) {
                if ( ! isset( $input['tag'] ) ) {
                    continue;
                }
                if ( 'pass1' === $input['tag'] ) {
                    $input['name'] = '새 비밀번호';
                } elseif ( 'pass2' === $input['tag'] ) {
                    $input['name'] = '새 비밀번호 확인';
                }
            }
            unset( $input );
        }
        return $arr;
    }

    $pass0 = array(
        'name'  => '기존 비밀번호',
        'type'  => 'password',
        'tag'   => 'pass0',
        'class' => 'password',
        'div'   => 'div_text',
    );

    $inputs = ( ! empty( $arr['inputs'] ) && is_array( $arr['inputs'] ) ) ? $arr['inputs'] : array();
    $filtered = array();
    foreach ( $inputs as $input ) {
        if ( isset( $input['tag'] ) && 'pass0' === $input['tag'] ) {
            continue;
        }
        $filtered[] = $input;
    }
    foreach ( $filtered as &$input ) {
        if ( ! isset( $input['tag'] ) ) {
            continue;
        }
        if ( 'pass1' === $input['tag'] ) {
            $input['name'] = '새 비밀번호';
        } elseif ( 'pass2' === $input['tag'] ) {
            $input['name'] = '새 비밀번호 확인';
        }
    }
    unset( $input );

    $arr['inputs'] = array_merge( array( $pass0 ), $filtered );
    return $arr;
}
add_filter( 'wpmem_changepassword_form_defaults', 'gpc_wpmem_changepassword_form_defaults', 10, 2 );

/**
 * 비밀번호 변경 시 기존 비밀번호 확인 (메일 키 재설정 제외)
 */
function gpc_wpmem_pwd_change_error( $is_error, $user_id, $pass1 ) {
    if ( $is_error ) {
        return $is_error;
    }
    $a_req = function_exists( 'wpmem_get' ) ? wpmem_get( 'a', '', 'request' ) : '';
    if ( 'set_password_from_key' === $a_req ) {
        return $is_error;
    }
    if ( ! is_user_logged_in() ) {
        return $is_error;
    }
    if ( ! gpc_is_mypage_password_shell() || 'pwdchange' !== gpc_mypage_action() ) {
        return $is_error;
    }

    $cur = isset( $_POST['pass0'] ) ? (string) wp_unslash( $_POST['pass0'] ) : '';
    if ( '' === trim( $cur ) ) {
        return 'gpc_curpwd_empty';
    }
    $user = get_userdata( $user_id );
    if ( ! $user || ! wp_check_password( $cur, $user->user_pass, $user_id ) ) {
        return 'gpc_curpwd_bad';
    }
    return $is_error;
}
add_filter( 'wpmem_pwd_change_error', 'gpc_wpmem_pwd_change_error', 5, 3 );

/**
 * 기존 비밀번호 검증 실패 메시지
 */
function gpc_wpmem_msg_defaults_curpwd( $defaults, $tag, $dialogs ) {
    if ( 'gpc_curpwd_empty' === $tag ) {
        $defaults['msg'] = '기존 비밀번호를 입력해 주세요.';
    } elseif ( 'gpc_curpwd_bad' === $tag ) {
        $defaults['msg'] = '기존 비밀번호가 일치하지 않습니다.';
    }
    return $defaults;
}
add_filter( 'wpmem_msg_defaults', 'gpc_wpmem_msg_defaults_curpwd', 10, 3 );

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
 * WP-Members 로그인 성공 시 홈으로 이동 (redirect_to 가 있으면 그대로 사용)
 */
function gpc_wpmem_login_redirect( $redirect_to, $user_id ) {
    $req = '';
    if ( ! empty( $_POST['redirect_to'] ) ) {
        $req = wp_unslash( $_POST['redirect_to'] );
    } elseif ( ! empty( $_GET['redirect_to'] ) ) {
        $req = wp_unslash( $_GET['redirect_to'] );
    }
    if ( $req ) {
        $safe = wp_validate_redirect( $req, false );
        if ( $safe ) {
            return $safe;
        }
    }
    return home_url( '/' );
}
add_filter( 'wpmem_login_redirect', 'gpc_wpmem_login_redirect', 10, 2 );

/**
 * 로그인 페이지에 이미 로그인된 경우 카드 대신 홈으로 보냄
 */
function gpc_redirect_logged_in_from_login_page() {
    if ( is_customize_preview() ) {
        return;
    }
    if ( ! is_page() || ! gpc_is_login_page() || ! is_user_logged_in() ) {
        return;
    }
    wp_safe_redirect( home_url( '/' ) );
    exit;
}
add_action( 'template_redirect', 'gpc_redirect_logged_in_from_login_page', 5 );

/**
 * WP-Members 회원정보 수정(?a=edit) 폼만 레이아웃 보정 대상
 */
function gpc_is_profile_edit_shell_context() {
    if ( ! is_user_logged_in() || ! is_page() || ! function_exists( 'wpmem_profile_url' ) ) {
        return false;
    }
    $here = trailingslashit( get_permalink( get_queried_object_id() ) );
    $prof = trailingslashit( wpmem_profile_url() );
    if ( $here !== $prof ) {
        return false;
    }
    return 'edit' === gpc_mypage_action();
}

/**
 * 회원정보 수정: 각 행을 .gpc-reg-field 로 감싸 fieldset flex 가 라벨·입력을 갈라 놓는 문제 방지
 *
 * @param array $rows
 * @return array
 */
function gpc_wrap_wpmem_profile_edit_rows( $rows ) {
    foreach ( $rows as $key => &$row ) {
        if ( ! is_array( $row ) ) {
            continue;
        }
        $slug = sanitize_title( (string) $key );
        if ( '' === $slug ) {
            $slug = 'f' . substr( md5( (string) $key ), 0, 8 );
        }
        $classes = array(
            'gpc-reg-field',
            'gpc-reg-field--full',
            'gpc-reg-field--edit',
            'gpc-reg-field--' . $slug,
        );
        $open  = '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
        $close = '</div>';
        $row['row_before'] = $open . ( isset( $row['row_before'] ) ? $row['row_before'] : '' );
        $row['row_after']  = ( isset( $row['row_after'] ) ? $row['row_after'] : '' ) . $close;
    }
    unset( $row );
    return $rows;
}

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
        'New User Registration' => '',
        'Register'           => '가입하기',
        'Required field'     => '',
        'Choose a Username'  => '이메일 (아이디)',
        'Username'           => '아이디',
        'Confirm Password'   => '비밀번호 확인',
        'Email'              => '이메일',
        'New password'       => '새 비밀번호',
        'Confirm new password' => '새 비밀번호 확인',
        'Update Password'    => '새 비밀번호 저장',
        'Reset Password'     => '재설정 메일 보내기',
        'Change Password'    => '비밀번호 변경',
        'Password successfully changed.' => '비밀번호가 변경되었습니다.',
        'Password successfully changed!' => '비밀번호가 변경되었습니다.',
        'Invalid username or email address.' => '이메일 주소를 확인할 수 없습니다.',
        'Reset Forgotten Password' => '',
        'Forgot username?' => '아이디를 잊으셨나요?',
        'Edit My Information' => '회원 정보 수정',
        'Update Profile'     => '저장하기',
    );
    return isset( $map[ $text ] ) ? $map[ $text ] : $translated;
}
add_filter( 'gettext', 'gpc_wpmem_translate', 10, 3 );

/**
 * 회원가입 페이지 (WP-Members 등록 폼)
 * 슬러그: 회원가입 — signup.html과 유사한 카드·2열·구역 구분 UI
 */
function gpc_is_register_page() {
    if ( ! is_page() ) {
        return false;
    }
    if ( is_page( '회원가입' ) ) {
        return true;
    }
    // 일부 환경에서 인코딩된 슬러그로 매칭될 때
    if ( is_page( '%ed%9a%8c%ec%9b%90%ea%b0%80%ec%9e%85' ) ) {
        return true;
    }
    return false;
}

/**
 * 회원가입 전용 페이지 템플릿
 */
function gpc_register_page_template( $template ) {
    if ( gpc_is_register_page() ) {
        $register_tpl = get_stylesheet_directory() . '/page-templates/page-register.php';
        if ( file_exists( $register_tpl ) ) {
            return $register_tpl;
        }
    }
    return $template;
}
add_filter( 'template_include', 'gpc_register_page_template', 11 );

/**
 * 회원가입 페이지 전용 CSS
 */
function gpc_register_page_assets() {
    if ( ! gpc_is_register_page() ) {
        return;
    }
    wp_enqueue_style(
        'gpc-register-css',
        get_stylesheet_directory_uri() . '/wpmem-register.css',
        array( 'gapyeong-child-style' ),
        wp_get_theme()->get( 'Version' ) . '.reg5'
    );
}
add_action( 'wp_enqueue_scripts', 'gpc_register_page_assets', 99 );

/**
 * 회원가입 페이지 본문: 에디터에 넣은 거대 제목(h1)·중복 부제 문단 제거
 * (템플릿 헤더와 겹치는 "가평 제칠일…" 블록 등)
 */
function gpc_register_page_the_content( $content ) {
    if ( ! is_page() || ! gpc_is_register_page() ) {
        return $content;
    }
    $content = preg_replace(
        '/<h1\b[^>]*>[\s\S]*?(?:제칠일|예수재림교회)[\s\S]*?<\/h1>/iu',
        '',
        $content,
        4
    );
    $subtitle = '가평교회 교적 등록을 위한 정보를 입력해주세요.';
    $content    = preg_replace(
        '/<p[^>]*>\s*' . preg_quote( $subtitle, '/' ) . '\s*<\/p>/iu',
        '',
        $content,
        3
    );
    return $content;
}
add_filter( 'the_content', 'gpc_register_page_the_content', 18 );

/**
 * 등록 폼 기본값 (버튼 문구, 하단 필수 안내 숨김)
 *
 * @param array  $args 필터 인자 (WP-Members 3.x는 전체 defaults 배열).
 * @param string $tag  new|edit
 */
function gpc_wpmem_register_form_args( $args, $tag, $id = '' ) {
    $out = is_array( $args ) ? $args : array();
    if ( 'new' === $tag && gpc_is_register_page() ) {
        $out['submit_register']  = '가입하기';
        $out['req_label']        = '';
        $out['req_label_before'] = '';
        $out['req_label_after']  = '';
        return $out;
    }
    if ( 'edit' === $tag && gpc_is_profile_edit_shell_context() ) {
        $out['submit_update'] = '저장하기';
        return $out;
    }
    return $args;
}
add_filter( 'wpmem_register_form_args', 'gpc_wpmem_register_form_args', 10, 3 );

/**
 * 등록 폼 상단 "New User Registration" 제거 (카드 헤더에서 제목 표시)
 */
function gpc_wpmem_register_heading( $heading, $tag ) {
    if ( 'new' === $tag && gpc_is_register_page() ) {
        return '';
    }
    if ( 'edit' === $tag && gpc_is_profile_edit_shell_context() ) {
        return '';
    }
    return $heading;
}
add_filter( 'wpmem_register_heading', 'gpc_wpmem_register_heading', 10, 2 );

/**
 * 섹션 구분선 HTML
 */
function gpc_reg_divider_html( $label ) {
    return '<div class="gpc-reg-divider" role="presentation"><span>' . esc_html( $label ) . '</span></div>';
}

/**
 * 생년월일 옆 양력/음력 (교적용, user meta 저장)
 */
function gpc_reg_calendar_toggle_field() {
    $posted = '';
    if ( isset( $_POST['gpc_calendar_type'] ) ) {
        $posted = sanitize_text_field( wp_unslash( $_POST['gpc_calendar_type'] ) );
    }
    $solar_checked  = ( '' === $posted || 'solar' === $posted ) ? ' checked' : '';
    $lunar_checked  = ( 'lunar' === $posted ) ? ' checked' : '';
    $legend         = esc_attr__( '생년월일 달력 구분', 'gapyeong-church-child' );

    return '<fieldset class="gpc-calendar-toggle" aria-label="' . $legend . '">'
        . '<label><input type="radio" name="gpc_calendar_type" value="solar"' . $solar_checked . '> '
        . esc_html__( '양력', 'gapyeong-church-child' ) . '</label>'
        . '<label><input type="radio" name="gpc_calendar_type" value="lunar"' . $lunar_checked . '> '
        . esc_html__( '음력', 'gapyeong-church-child' ) . '</label>'
        . '</fieldset>';
}

/**
 * 필드 행에 래퍼·구역 구분·전체 너비 클래스 부여
 *
 * @param array  $rows
 * @param string $tag new|edit
 */
function gpc_wpmem_register_form_rows( $rows, $tag ) {
    if ( ! is_array( $rows ) ) {
        return $rows;
    }
    if ( 'edit' === $tag && gpc_is_profile_edit_shell_context() ) {
        return gpc_wrap_wpmem_profile_edit_rows( $rows );
    }
    if ( 'new' !== $tag || ! gpc_is_register_page() ) {
        return $rows;
    }

    /* 계정 블록: 1행 아이디|이메일, 2행 비밀번호|비밀번호 확인 */
    $account_keys = array( 'username', 'user_email', 'password', 'confirm_password', 'password_confirm' );

    $preferred = array(
        'username',
        'user_email',
        'password',
        'confirm_password',
        'password_confirm',
    );

    $reordered = array();
    foreach ( $preferred as $key ) {
        if ( isset( $rows[ $key ] ) ) {
            $reordered[ $key ] = $rows[ $key ];
            unset( $rows[ $key ] );
        }
    }
    foreach ( $rows as $key => $row ) {
        $reordered[ $key ] = $row;
    }
    $rows = $reordered;

    $church_first = null;
    foreach ( $rows as $key => $row ) {
        $lt = isset( $row['label_text'] ) ? $row['label_text'] : '';
        if ( $lt && false !== strpos( $lt, '교회' ) && false !== strpos( $lt, '직분' ) ) {
            $church_first = $key;
            break;
        }
    }
    if ( ! $church_first ) {
        foreach ( $rows as $key => $row ) {
            $lt = isset( $row['label_text'] ) ? $row['label_text'] : '';
            if ( $lt && false !== strpos( $lt, '직분' ) ) {
                $church_first = $key;
                break;
            }
        }
    }

    $personal_started = false;

    foreach ( $rows as $key => &$row ) {
        $lt = isset( $row['label_text'] ) ? $row['label_text'] : '';

        $slug = sanitize_title( (string) $key );
        if ( '' === $slug ) {
            $slug = 'f' . substr( md5( (string) $key ), 0, 8 );
        }

        $classes   = array( 'gpc-reg-field', 'gpc-reg-field--' . $slug );
        $type      = isset( $row['type'] ) ? $row['type'] : '';
        $is_tos    = ( 'tos' === $key );
        $is_captcha = ( 'captcha' === $key );

        $full = in_array( $key, array( 'tos', 'captcha' ), true )
            || 'textarea' === $type
            || ( $lt && false !== strpos( $lt, '가족' ) )
            || ( $lt && false !== strpos( $lt, '교적' ) );

        if ( $full ) {
            $classes[] = 'gpc-reg-field--full';
        }

        $divider = '';
        if ( ! $personal_started && ! in_array( $key, $account_keys, true ) && ! $is_tos && ! $is_captcha ) {
            $divider           = gpc_reg_divider_html( __( '개인 신상 정보', 'gapyeong-church-child' ) );
            $personal_started = true;
        }
        if ( $church_first && $key === $church_first ) {
            $divider = gpc_reg_divider_html( __( '교회 활동 정보', 'gapyeong-church-child' ) );
        }

        $extra_after = '';
        if ( $lt && false !== strpos( $lt, '생년월일' ) ) {
            $classes[]    = 'gpc-reg-field--dob';
            $extra_after .= gpc_reg_calendar_toggle_field();
        }

        $open  = '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
        $close = $extra_after . '</div>';

        $row['row_before'] = $divider . $open . ( isset( $row['row_before'] ) ? $row['row_before'] : '' );
        $row['row_after']  = ( isset( $row['row_after'] ) ? $row['row_after'] : '' ) . $close;
    }
    unset( $row );

    return $rows;
}
add_filter( 'wpmem_register_form_rows', 'gpc_wpmem_register_form_rows', 10, 2 );

/**
 * 제출 버튼 영역 래퍼 (그리드 full span)
 */
function gpc_wpmem_register_form_buttons( $buttons, $tag, $button_html = null ) {
    if ( 'new' === $tag && gpc_is_register_page() ) {
        return '<div class="gpc-reg-submit-wrap">' . $buttons . '</div>';
    }
    if ( 'edit' === $tag && gpc_is_profile_edit_shell_context() ) {
        return '<div class="gpc-reg-submit-wrap">' . $buttons . '</div>';
    }
    return $buttons;
}
add_filter( 'wpmem_register_form_buttons', 'gpc_wpmem_register_form_buttons', 10, 3 );

/**
 * 양력/음력 선택 저장 (WP-Members 등록 완료 시)
 */
function gpc_save_calendar_type_on_register( $user_id ) {
    if ( empty( $_POST['gpc_calendar_type'] ) ) {
        return;
    }
    if ( empty( $_POST['_wpmem_register_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpmem_register_nonce'] ) ), 'wpmem_longform_nonce' ) ) {
        return;
    }
    $val = sanitize_text_field( wp_unslash( $_POST['gpc_calendar_type'] ) );
    if ( ! in_array( $val, array( 'solar', 'lunar' ), true ) ) {
        return;
    }
    update_user_meta( (int) $user_id, 'gpc_calendar_type', $val );
}
add_action( 'user_register', 'gpc_save_calendar_type_on_register', 15, 1 );
