<?php
/**
 * 가평교회 테마 - 기본 페이지 템플릿
 *
 * 서브페이지(부모가 있는 페이지)는 자동으로
 * Subpage Hero + Submenu Nav를 표시합니다.
 * 개별 페이지 템플릿(page-*.php)이 있으면 그쪽이 우선합니다.
 */

// 서브페이지 컨텍스트 자동 감지
$ctx = gapyeong_get_page_context();

if ($ctx) {
    // ── Subpage Hero 설정 ──
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);

    // ── Submenu 설정 ──
    set_query_var('submenu_group',  $ctx['group']);
    set_query_var('submenu_active', $ctx['active_href']);
}

get_header(); ?>

<?php if ($ctx): ?>
    <!-- Global Parallax Background Orbs -->
    <div class="global-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="orb orb-4"></div>
        <div class="orb orb-5"></div>
    </div>

    <!-- Scroll Progress Indicator -->
    <div class="scroll-indicator">
        <span class="scroll-text">scroll</span>
        <div class="scroll-track">
            <div class="scroll-progress"></div>
            <div class="scroll-dot"></div>
        </div>
    </div>

    <?php
    // Subpage Hero (빵조각 포함)
    get_template_part('template-parts/subpage-hero');

    // Submenu Navigation
    get_template_part('template-parts/submenu-nav');
    ?>

    <!-- Content Section -->
    <section class="subpage-content">
        <div class="container">
            <div class="content-box">
                <?php
                if (have_posts()):
                    while (have_posts()):
                        the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </section>

<?php else: ?>
    <!-- 일반 페이지 (서브페이지 구조 없음) -->
    <main class="site-main">
        <div class="container">
            <?php
            if (have_posts()):
                while (have_posts()):
                    the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>
    </main>
<?php endif; ?>

<?php get_footer(); ?>