<?php
/**
 * Blog posts index template.
 */

get_header();

$posts_page_id = (int) get_option( 'page_for_posts' );
$title = $posts_page_id ? get_the_title( $posts_page_id ) : esc_html__( '교회 소식', 'gapyeong-church-child' );
$description = $posts_page_id ? get_post_field( 'post_excerpt', $posts_page_id ) : '';
?>

<main class="gpc-list-page gpc-home-page">
    <section class="gpc-list-hero">
        <div class="container">
            <span class="gpc-list-eyebrow"><?php esc_html_e( '글 목록', 'gapyeong-church-child' ); ?></span>
            <h1 class="gpc-list-title"><?php echo esc_html( $title ); ?></h1>
            <p class="gpc-list-lead">
                <?php
                echo esc_html(
                    $description
                        ? $description
                        : __( '가평교회의 소식과 이야기를 차분하게 모아 전합니다.', 'gapyeong-church-child' )
                );
                ?>
            </p>
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
