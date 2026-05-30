<?php
/**
 * 가평교회 테마 - Template Part: Subpage Hero
 *
 * 서브페이지 상단 히어로 영역 (배경 데코 + 타이틀 + 슬로건 + 빵조각)
 *
 * 사용법:
 *   set_query_var( 'subpage_title',  '인사말' );
 *   set_query_var( 'subpage_slogan', '하나님의 사랑 안에서 함께하는 가평교회' );
 *   set_query_var( 'breadcrumb_items', array(
 *       array( 'label' => '교회소개', 'href' => '/intro/greeting' ),
 *       array( 'label' => '인사말',   'href' => '' ),
 *   ));
 *   get_template_part( 'template-parts/subpage-hero' );
 */

$title = get_query_var('subpage_title', get_the_title());
$slogan = get_query_var('subpage_slogan', '');
?>

<!-- Subpage Hero Section -->
<section class="subpage-hero">
    <!-- Decorative Geometric Shapes -->
    <div class="deco-shapes">
        <svg class="deco-shape deco-triangle-1" viewBox="0 0 100 100" fill="none">
            <polygon points="50,10 90,80 10,80" fill="#6366f1" opacity="0.6" />
        </svg>
        <svg class="deco-shape deco-diamond-1" viewBox="0 0 60 60" fill="none">
            <path d="M30 5 L55 30 L30 55 L5 30 Z" fill="#06b6d4" opacity="0.5" />
        </svg>
        <svg class="deco-shape deco-circle-1" viewBox="0 0 90 90" fill="none">
            <circle cx="45" cy="45" r="35" fill="#f59e0b" opacity="0.4" />
        </svg>
        <svg class="deco-shape deco-triangle-3" viewBox="0 0 120 120" fill="none">
            <polygon points="60,15 100,95 20,95" fill="#3b82f6" opacity="0.5" />
        </svg>
    </div>

    <div class="container">
        <div class="subpage-hero-content">
            <h1 class="subpage-title"><?php echo esc_html($title); ?></h1>
            <?php if ($slogan): ?>
                <p class="subpage-slogan"><?php echo esc_html($slogan); ?></p>
            <?php endif; ?>

            <!-- Breadcrumb (자동 포함) -->
            <?php get_template_part('template-parts/breadcrumb'); ?>
        </div>
    </div>
</section>