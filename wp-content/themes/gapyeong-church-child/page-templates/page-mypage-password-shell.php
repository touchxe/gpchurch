<?php
/**
 * 마이페이지 비밀번호·계정 복구 구간 전용 레이아웃
 *
 * template_include 로만 로드됩니다. (페이지 속성 템플릿 목록에 나오지 않음)
 * URL 예: /마이페이지/?a=pwdreset
 */
get_header();

$a = isset( $_GET['a'] ) ? sanitize_key( wp_unslash( $_GET['a'] ) ) : '';
if ( 'pwdreset' === $a ) {
    $gpc_shell_title    = '비밀번호 찾기';
    $gpc_shell_subtitle = '가입하신 이메일로 비밀번호 재설정 안내를 보내드립니다.';
} elseif ( 'pwdchange' === $a ) {
    $gpc_shell_title    = '새 비밀번호 설정';
    $gpc_shell_subtitle = '기존 비밀번호 확인 후 새 비밀번호를 입력해 주세요.';
} elseif ( 'set_password_from_key' === $a ) {
    $gpc_shell_title    = '새 비밀번호 설정';
    $gpc_shell_subtitle = '새 비밀번호를 입력한 뒤 저장해 주세요.';
} else {
    $gpc_shell_title    = '계정 찾기';
    $gpc_shell_subtitle = '';
}
?>

<main class="site-main gpc-login-page">
    <div class="gpc-login-card">
        <div class="gpc-login-header">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo.png"
                 alt="가평교회" class="gpc-login-logo">
            <h1 class="gpc-login-title"><?php echo esc_html( $gpc_shell_title ); ?></h1>
            <?php if ( '' !== $gpc_shell_subtitle ) : ?>
                <p class="gpc-login-subtitle"><?php echo esc_html( $gpc_shell_subtitle ); ?></p>
            <?php endif; ?>
        </div>

        <div class="gpc-login-form-wrap">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>

        <p class="gpc-login-back">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">홈으로 돌아가기</a>
        </p>
    </div>
</main>

<script>
(function() {
    var u = document.getElementById('user');
    if (u) {
        u.placeholder = '이메일 주소를 입력하세요';
    }
    var p0 = document.getElementById('pass0');
    if (p0) {
        p0.placeholder = '현재 비밀번호를 입력하세요';
    }
    var p1 = document.getElementById('pass1');
    var p2 = document.getElementById('pass2');
    if (p1) {
        p1.placeholder = '새 비밀번호를 입력하세요';
    }
    if (p2) {
        p2.placeholder = '새 비밀번호를 한 번 더 입력하세요';
    }
})();
</script>

<?php
get_footer();
