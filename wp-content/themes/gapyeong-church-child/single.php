<?php
/**
 * Single post template for readable Korean articles.
 *
 * Keeps the article surface calm and narrow while preserving basic
 * WordPress post navigation and metadata.
 */

get_header();
?>

<main id="primary" class="gpc-single-post">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php
            $categories = get_the_category();
            $primary_category = ! empty( $categories ) ? $categories[0] : null;
            $list_url = $primary_category ? get_category_link( $primary_category ) : home_url( '/' );
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'gpc-single-article' ); ?>>
                <header class="gpc-single-header">
                    <?php if ( $primary_category ) : ?>
                        <a class="gpc-single-category" href="<?php echo esc_url( get_category_link( $primary_category ) ); ?>">
                            <?php echo esc_html( $primary_category->name ); ?>
                        </a>
                    <?php endif; ?>

                    <h1 class="gpc-single-title"><?php the_title(); ?></h1>

                    <div class="gpc-single-meta" aria-label="<?php esc_attr_e( 'Post information', 'gapyeong-church-child' ); ?>">
                        <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
                            <?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
                        </time>
                        <span aria-hidden="true">/</span>
                        <span><?php echo esc_html( get_the_author() ); ?></span>
                    </div>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <figure class="gpc-single-featured">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </figure>
                <?php endif; ?>

                <div class="gpc-single-content">
                    <?php
                    the_content();

                    wp_link_pages(
                        array(
                            'before' => '<nav class="gpc-single-page-links" aria-label="' . esc_attr__( 'Post pages', 'gapyeong-church-child' ) . '">',
                            'after'  => '</nav>',
                        )
                    );
                    ?>
                </div>

                <?php if ( get_the_tags() ) : ?>
                    <footer class="gpc-single-tags">
                        <?php foreach ( get_the_tags() as $tag ) : ?>
                            <a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>">
                                <?php echo esc_html( $tag->name ); ?>
                            </a>
                        <?php endforeach; ?>
                    </footer>
                <?php endif; ?>
            </article>

            <nav class="gpc-single-nav" aria-label="<?php esc_attr_e( 'Post navigation', 'gapyeong-church-child' ); ?>">
                <div class="gpc-single-nav-row">
                    <div class="gpc-single-nav-item gpc-single-nav-prev">
                        <?php previous_post_link( '%link', '<span>이전 글</span><strong>%title</strong>' ); ?>
                    </div>
                    <div class="gpc-single-nav-item gpc-single-nav-next">
                        <?php next_post_link( '%link', '<span>다음 글</span><strong>%title</strong>' ); ?>
                    </div>
                </div>

                <a class="gpc-single-list-link" href="<?php echo esc_url( $list_url ); ?>">목록으로</a>
            </nav>

            <?php if ( comments_open() || get_comments_number() ) : ?>
                <section class="gpc-single-comments">
                    <?php comments_template(); ?>
                </section>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
