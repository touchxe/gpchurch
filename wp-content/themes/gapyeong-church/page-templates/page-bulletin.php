<?php
/**
 * Template Name: 주보 아카이브 (Bulletin Archive)
 *
 * 이 페이지는 최신 주보를 상단에 크게 보여주고,
 * 하단에 과거 주보 리스트를 KBoard에서 불러와 출력합니다.
 */

// 서브페이지 컨텍스트 감지 (community 그룹 하위로 설정)
$ctx = gapyeong_get_page_context();
if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
}

get_header(); ?>

<!-- Global Parallax Background Orbs -->
<div class="global-orbs">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="orb orb-4"></div>
    <div class="orb orb-5"></div>
</div>

<?php
// Subpage Hero & Submenu Nav
get_template_part('template-parts/subpage-hero');
get_template_part('template-parts/submenu-nav');
?>

<section class="subpage-content bulletin-archive-page">
    <div class="container">
        
        <!-- 📅 최신 주보 섹션 -->
        <?php
        $b_img   = get_option('gpc_bulletin_image');
        $b_title = get_option('gpc_bulletin_title', '등록된 주보가 없습니다.');
        $b_date  = get_option('gpc_bulletin_date');
        ?>
        
        <div class="latest-bulletin-section" data-aos="fade-up">
            <h2 class="sub-title">이번 주 주보</h2>
            <?php if ($b_img): ?>
                <div class="latest-bulletin-container">
                    <div class="bulletin-main-image">
                        <img src="<?php echo esc_url($b_img); ?>" alt="이번 주 주보">
                        <div class="bulletin-zoom-overlay">
                            <a href="<?php echo esc_url($b_img); ?>" target="_blank" class="zoom-btn">
                                <i data-lucide="maximize-2"></i> 크게 보기
                            </a>
                        </div>
                    </div>
                    <div class="bulletin-main-info">
                        <span class="badge">이번 주</span>
                        <h3><?php echo esc_html($b_title); ?></h3>
                        <?php if ($b_date): ?>
                            <p class="date"><i data-lucide="calendar"></i> <?php echo esc_html($b_date); ?></p>
                        <?php endif; ?>
                        
                        <div class="bulletin-actions">
                            <a href="<?php echo esc_url($b_img); ?>" download class="btn btn-primary">
                                <i data-lucide="download"></i> 주보 다운로드
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="no-bulletin">
                    <p>현재 등록된 최신 주보가 없습니다.</p>
                </div>
            <?php endif; ?>
        </div>

        <hr class="section-divider">

        <!-- 📚 과거 주보 아카이브 섹션 -->
        <div class="archive-section" data-aos="fade-up">
            <h2 class="sub-title">지난 주보 모아보기</h2>
            <div class="kboard-bulletin-list">
                <?php 
                // KBoard 갤러리(ID 4 - 주보 전용) 전체 리스트 출력
                echo do_shortcode('[kboard id="4"]'); 
                ?>
            </div>
        </div>

    </div>
</section>

<style>
.bulletin-archive-page {
    padding-bottom: 5rem;
}
.latest-bulletin-section {
    margin-bottom: 3rem;
    background: white;
    padding: 2.5rem;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
}
.sub-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-600);
}
.latest-bulletin-container {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 2.5rem;
    align-items: start;
}
.bulletin-main-image {
    position: relative;
    border-radius: var(--radius-md);
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-md);
}
.bulletin-main-image img {
    width: 100%;
    display: block;
    transition: transform 0.3s ease;
}
.bulletin-zoom-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.bulletin-main-image:hover img {
    transform: scale(1.05);
}
.bulletin-main-image:hover .bulletin-zoom-overlay {
    opacity: 1;
}
.zoom-btn {
    background: white;
    color: var(--primary-600);
    padding: 0.75rem 1.25rem;
    border-radius: var(--radius-sm);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}
.bulletin-main-info .badge {
    background: var(--primary-100);
    color: var(--primary-700);
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
    font-size: 0.875rem;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 1rem;
}
.bulletin-main-info h3 {
    font-size: 2rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1rem;
    color: var(--slate-900);
}
.bulletin-main-info .date {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--slate-500);
    font-size: 1.125rem;
    margin-bottom: 2rem;
}
.bulletin-actions .btn {
    padding: 1rem 2rem;
    font-size: 1.125rem;
}
.section-divider {
    margin: 4rem 0;
    border: 0;
    border-top: 1px dashed var(--border-color);
}
.archive-section .sub-title {
    margin-bottom: 2rem;
}

/* KBoard 리스트 커스텀 (갤러리 디자인 모방) */
#kboard-gallery-list {
    display: grid !important;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)) !important;
    gap: 20px !important;
}
.kboard-gallery-item {
    float: none !important;
    width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
    background: #ffffff !important;
    border-radius: 12px !important;
    border: 1px solid var(--border-color) !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;
    overflow: hidden !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease !important;
}
.kboard-gallery-item:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
}
.kboard-gallery-link {
    display: flex !important;
    padding: 12px !important;
    gap: 15px !important;
    align-items: center !important;
}
.kboard-gallery-thumbnail {
    width: 120px !important;
    height: 85px !important;
    border-radius: 8px !important;
    overflow: hidden !important;
    flex-shrink: 0 !important;
    margin: 0 !important;
}
.kboard-gallery-thumbnail img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}
.kboard-gallery-foreground {
    display: none !important;
}
.kboard-gallery-title {
    font-size: 15px !important;
    font-weight: 700 !important;
    color: #333333 !important;
    margin: 0 0 5px 0 !important;
    padding: 0 !important;
}
.kboard-gallery-user, .kboard-gallery-date {
    font-size: 12px !important;
    color: #999999 !important;
}

@media (max-width: 768px) {
    .latest-bulletin-container {
        grid-template-columns: 1fr;
    }
    .bulletin-main-info h3 {
        font-size: 1.5rem;
    }
}
</style>

<?php get_footer(); ?>
