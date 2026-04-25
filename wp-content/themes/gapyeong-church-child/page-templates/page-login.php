<?php
/**
 * Template Name: 로그인 페이지
 *
 * 로그인-화면 전용 카드 레이아웃.
 * WP-Members 폼을 감싸는 카드 UI + 소셜 로그인 영역.
 */
get_header(); ?>

<main class="site-main gpc-login-page">
    <div class="gpc-login-card">
        <div class="gpc-login-header">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo.png"
                 alt="가평교회" class="gpc-login-logo">
            <h1 class="gpc-login-title">로그인</h1>
            <p class="gpc-login-subtitle">가평교회 홈페이지에 오신 것을 환영합니다.</p>
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

        <div class="gpc-login-divider">
            <span>또는 소셜 계정으로 로그인</span>
        </div>

        <div class="gpc-social-login">
            <a href="#" class="gpc-social-btn gpc-kakao" aria-label="카카오 로그인">
                <svg width="22" height="22" viewBox="0 0 24 24">
                    <path fill="#3C1E1E" d="M12 3C6.48 3 2 6.58 2 10.96c0 2.81 1.87 5.28 4.69 6.68l-1.17 4.33c-.06.22.2.4.38.27l5.05-3.32c.34.04.69.05 1.05.05 5.52 0 10-3.58 10-7.97C22 6.58 17.52 3 12 3z"/>
                </svg>
            </a>
            <a href="#" class="gpc-social-btn gpc-naver" aria-label="네이버 로그인">
                <svg width="18" height="18" viewBox="0 0 20 20">
                    <path fill="#03C75A" d="M13.56 10.7 6.17 0H0v20h6.44V9.3L13.83 20H20V0h-6.44v10.7z"/>
                </svg>
            </a>
            <a href="#" class="gpc-social-btn gpc-google" aria-label="구글 로그인">
                <svg width="20" height="20" viewBox="0 0 48 48">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                    <path fill="#FBBC05" d="M10.53 28.59a14.5 14.5 0 0 1 0-9.18l-7.98-6.19a24.06 24.06 0 0 0 0 21.56l7.98-6.19z"/>
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                </svg>
            </a>
        </div>

        <p class="gpc-login-signup">
            아직 회원이 아니신가요?
            <a href="<?php echo esc_url( home_url( '/회원가입/' ) ); ?>">회원가입</a>
        </p>
    </div>
</main>

<script>
(function() {
    var form = document.getElementById('wpmem_login_form');
    if (!form) return;

    var bd  = form.querySelector('.button_div');
    var lt  = form.querySelector('.link-text');
    var cb  = bd ? bd.querySelector('#rememberme') : null;
    var lbl = bd ? bd.querySelector('label[for="rememberme"]') : null;

    if (bd && cb && lbl) {
        var row = document.createElement('div');
        row.className = 'gpc-remember-row';
        row.appendChild(cb);
        row.appendChild(lbl);
        if (lt) row.appendChild(lt);
        bd.parentNode.insertBefore(row, bd);
    }

    var log = document.getElementById('log');
    var pwd = document.getElementById('pwd');
    if (log) log.placeholder = '이메일을 입력하세요';
    if (pwd) pwd.placeholder = '비밀번호를 입력하세요';
})();
</script>

<?php get_footer(); ?>
