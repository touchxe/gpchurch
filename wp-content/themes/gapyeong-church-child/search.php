<?php
/**
 * Search results template.
 */

get_header();

$search_query = get_search_query();
?>

<main class="gpc-list-page gpc-search-page">
    <section class="gpc-list-hero">
        <div class="container">
            <span class="gpc-list-eyebrow"><?php esc_html_e( '검색', 'gapyeong-church-child' ); ?></span>
            <h1 class="gpc-list-title">
                <?php
                printf(
                    esc_html__( '"%s" 검색 결과', 'gapyeong-church-child' ),
                    esc_html( $search_query )
                );
                ?>
            </h1>
            <div class="gpc-list-search">
                <?php get_search_form(); ?>
            </div>
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

                <nav class="gpc-list-pagination" aria-label="<?php esc_attr_e( '검색 결과 페이지', 'gapyeong-church-child' ); ?>">
                    <?php
                    the_posts_pagination(
                        array(
                            'mid_size'           => 1,
                            'prev_text'          => esc_html__( '이전', 'gapyeong-church-child' ),
                            'next_text'          => esc_html__( '다음', 'gapyeong-church-child' ),
                            'screen_reader_text' => esc_html__( '검색 결과 페이지 탐색', 'gapyeong-church-child' ),
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
