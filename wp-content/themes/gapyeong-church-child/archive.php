<?php
/**
 * Archive template for posts.
 */

get_header();

$eyebrow = esc_html__( '글 모아보기', 'gapyeong-church-child' );
$title = get_the_archive_title();
$description = get_the_archive_description();

if ( is_category() ) {
    $eyebrow = esc_html__( '카테고리', 'gapyeong-church-child' );
    $title = single_cat_title( '', false );
} elseif ( is_tag() ) {
    $eyebrow = esc_html__( '태그', 'gapyeong-church-child' );
    $title = single_tag_title( '', false );
} elseif ( is_author() ) {
    $author = get_queried_object();
    $eyebrow = esc_html__( '작성자', 'gapyeong-church-child' );
    $title = $author && ! empty( $author->display_name ) ? $author->display_name : get_the_author();
} elseif ( is_day() || is_month() || is_year() ) {
    $eyebrow = esc_html__( '날짜별 글', 'gapyeong-church-child' );
}
?>

<main class="gpc-list-page gpc-archive-page">
    <section class="gpc-list-hero">
        <div class="container">
            <span class="gpc-list-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <h1 class="gpc-list-title"><?php echo esc_html( $title ); ?></h1>
            <?php if ( $description ) : ?>
                <div class="gpc-list-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
            <?php endif; ?>
        </div>
    </section>

    <section class="gpc-list-content">
        <div class="container">
            <?php if ( have_posts() ) : ?>
                <div class="gpc-post-list">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/content', 'post-card' );
                    endwhile;
                    ?>
                </div>

                <nav class="gpc-list-pagination" aria-label="<?php esc_attr_e( '글 페이지', 'gapyeong-church-child' ); ?>">
                    <?php
                    the_posts_pagination(
                        array(
                            'mid_size'           => 1,
                            'prev_text'          => esc_html__( '이전', 'gapyeong-church-child' ),
                            'next_text'          => esc_html__( '다음', 'gapyeong-church-child' ),
                            'screen_reader_text' => esc_html__( '글 페이지 탐색', 'gapyeong-church-child' ),
                        )
                    );
                    ?>
                </nav>
            <?php else : ?>
                <?php get_template_part( 'template-parts/content', 'none' ); ?>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
