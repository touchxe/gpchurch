<?php
/**
 * Empty state for archive-like views.
 */
?>

<section class="gpc-list-empty">
    <h2><?php esc_html_e( '표시할 글이 없습니다.', 'gapyeong-church-child' ); ?></h2>
    <p><?php esc_html_e( '다른 검색어를 입력하거나, 홈으로 돌아가 최신 소식을 확인해 주세요.', 'gapyeong-church-child' ); ?></p>
    <div class="gpc-list-empty__actions">
        <a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php esc_html_e( '홈으로', 'gapyeong-church-child' ); ?>
        </a>
        <?php get_search_form(); ?>
    </div>
</section>
