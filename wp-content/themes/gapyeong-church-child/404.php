<?php
/**
 * 404 template.
 */

get_header();
?>

<main class="gpc-list-page gpc-not-found-page">
    <section class="gpc-list-hero gpc-not-found-hero">
        <div class="container">
            <span class="gpc-list-eyebrow"><?php esc_html_e( '404', 'gapyeong-church-child' ); ?></span>
            <h1 class="gpc-list-title"><?php esc_html_e( '페이지를 찾을 수 없습니다.', 'gapyeong-church-child' ); ?></h1>
            <p class="gpc-list-lead">
                <?php esc_html_e( '주소가 바뀌었거나 삭제된 페이지일 수 있습니다. 필요한 내용을 검색하거나 홈으로 이동해 주세요.', 'gapyeong-church-child' ); ?>
            </p>
            <div class="gpc-not-found-actions">
                <a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php esc_html_e( '홈으로', 'gapyeong-church-child' ); ?>
                </a>
                <?php get_search_form(); ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
