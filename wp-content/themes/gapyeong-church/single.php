<?php
/**
 * WordPress 기본 글 상세 템플릿.
 */
get_header();

$fallback_image = get_template_directory_uri() . '/assets/images/activity-1.png';
?>

<main class="post-detail-main">
    <?php while (have_posts()): the_post(); ?>
        <?php $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: $fallback_image; ?>
        <article <?php post_class('post-detail-article'); ?>>
            <header class="post-detail-header">
                <div class="container post-detail-header-inner">
                    <a class="post-detail-back" href="<?php echo esc_url(gapyeong_church_activity_url()); ?>">← 교회 활동 목록</a>
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
                    <h1><?php the_title(); ?></h1>
                </div>
            </header>
            <div class="container post-detail-content">
                <figure class="post-detail-thumbnail">
                    <img class="post-image-zoomable" src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" tabindex="0" role="button" aria-label="대표 이미지 크게 보기">
                </figure>
                <div class="post-detail-body">
                    <?php the_content(); ?>
                </div>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<div class="post-image-lightbox" id="postImageLightbox" aria-hidden="true" role="dialog" aria-modal="true" aria-label="이미지 크게 보기">
    <button class="post-image-lightbox-close" type="button" aria-label="이미지 크게 보기 닫기">&times;</button>
    <img class="post-image-lightbox-image" src="" alt="">
</div>

<?php get_footer();
