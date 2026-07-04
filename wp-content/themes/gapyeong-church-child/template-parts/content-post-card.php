<?php
/**
 * Reusable post card for archive-like views.
 */

$categories = get_the_category();
$primary_category = ! empty( $categories ) ? $categories[0] : null;
$card_classes = has_post_thumbnail()
    ? 'gpc-post-card card gpc-post-card--has-media'
    : 'gpc-post-card card gpc-post-card--no-media';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $card_classes ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <a class="gpc-post-card__media" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
            <?php the_post_thumbnail( 'medium_large' ); ?>
        </a>
    <?php endif; ?>

    <div class="gpc-post-card__body card-body">
        <div class="gpc-post-card__meta">
            <?php if ( $primary_category ) : ?>
                <a class="gpc-post-card__category badge badge-light" href="<?php echo esc_url( get_category_link( $primary_category ) ); ?>">
                    <?php echo esc_html( $primary_category->name ); ?>
                </a>
            <?php endif; ?>
            <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
                <?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
            </time>
        </div>

        <h2 class="gpc-post-card__title card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <div class="gpc-post-card__excerpt card-text">
            <?php echo esc_html( wp_trim_words( get_the_excerpt(), 34, '...' ) ); ?>
        </div>

        <a class="gpc-post-card__link btn btn-ghost btn-sm" href="<?php the_permalink(); ?>">
            <?php esc_html_e( '읽기', 'gapyeong-church-child' ); ?>
        </a>
    </div>
</article>
