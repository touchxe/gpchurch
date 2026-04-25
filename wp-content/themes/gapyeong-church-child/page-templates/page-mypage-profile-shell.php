<?php
/**
 * WP-Members 프로필(마이페이지) 카드 레이아웃
 *
 * template_include 전용. 프로필 페이지 슬러그가 바뀌어도 wpmem_profile_url() 과 일치할 때 적용됩니다.
 */
get_header();

$a = isset( $_GET['a'] ) ? sanitize_key( wp_unslash( $_GET['a'] ) ) : '';
if ( 'edit' === $a ) {
    $gpc_shell_title    = '회원 정보 수정';
    $gpc_shell_subtitle = '등록된 정보를 확인·수정할 수 있습니다.';
} elseif ( 'getusername' === $a ) {
    $gpc_shell_title    = '아이디 찾기';
    $gpc_shell_subtitle = '';
} else {
    $gpc_shell_title    = '프로필';
    $gpc_shell_subtitle = '내 정보와 비밀번호를 이 페이지에서 관리할 수 있습니다.';
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

        <div class="gpc-login-form-wrap gpc-profile-form-wrap gpc-register-form-wrap">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>

        <p class="gpc-login-back">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">홈으로</a>
        </p>
    </div>
</main>

<?php
get_footer();
