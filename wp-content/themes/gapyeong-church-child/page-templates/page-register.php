<?php
/**
 * Template Name: 회원가입 페이지
 *
 * 회원가입(교적 등록) 전용 카드 레이아웃.
 * WP-Members [wpmem_form register] 출력을 signup.html 스타일에 맞춤.
 */
get_header(); ?>

<main class="site-main gpc-register-page">
    <div class="gpc-register-card">
        <div class="gpc-register-header">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.png' ); ?>"
                 alt="<?php esc_attr_e( '가평교회', 'gapyeong-church-child' ); ?>"
                 class="gpc-register-logo"
                 width="48"
                 height="48">
            <div class="gpc-register-heading-text">
                <h1 class="gpc-register-title"><?php esc_html_e( '회원가입', 'gapyeong-church-child' ); ?></h1>
                <p class="gpc-register-subtitle"><?php esc_html_e( '가평교회 교적 등록을 위한 정보를 입력해주세요.', 'gapyeong-church-child' ); ?></p>
            </div>
        </div>

        <div class="gpc-register-form-wrap">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>

        <p class="gpc-register-login-link">
            <?php esc_html_e( '이미 아이디가 있으신가요?', 'gapyeong-church-child' ); ?>
            <a href="<?php echo esc_url( home_url( '/로그인-화면/' ) ); ?>"><?php esc_html_e( '로그인하기', 'gapyeong-church-child' ); ?></a>
        </p>
    </div>
</main>

<script>
(function () {
    var form = document.getElementById('wpmem_register_form');
    if (!form) return;

    var map = [
        ['username', 'example@email.com'],
        ['log', 'example@email.com'],
        ['user_login', 'example@email.com'],
        ['password', ''],
        ['confirm_password', ''],
        ['password_confirm', ''],
        ['user_email', 'example@email.com'],
        ['first_name', '실명을 입력하세요'],
        ['last_name', ''],
        ['user_url', '']
    ];
    map.forEach(function (pair) {
        var el = form.querySelector('#' + pair[0] + ', [name="' + pair[0] + '"]');
        if (el && el.tagName === 'INPUT' && !el.placeholder && pair[1]) {
            el.placeholder = pair[1];
        }
    });

    var phone = form.querySelector('[id*="phone" i], [name*="phone" i], [id*="tel" i], [name*="tel" i]');
    if (phone && phone.tagName === 'INPUT' && !phone.placeholder) {
        phone.placeholder = '010-1234-5678';
    }
    var addr = form.querySelector('[id*="address" i], [name*="address" i], [id*="addr" i]');
    if (addr && addr.tagName === 'INPUT' && !addr.placeholder) {
        addr.placeholder = '도로명 주소를 입력하세요';
    }
    var family = form.querySelector('[id*="family" i], [name*="family" i]');
    if (family && family.tagName === 'INPUT' && !family.placeholder) {
        family.placeholder = '교회 출석 중인 가족 성명을 입력하세요 (예: 배우자 김영희, 자녀 이철수)';
    }
})();
</script>

<?php
get_footer();
