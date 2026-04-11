<?php
/**
 * Template Name: 부서 - 집사회
 *
 * 가평교회 테마 - 집사회 부서 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '집사회');
    set_query_var('subpage_slogan', '교회 살림을 맡아 봉사하며 성도들의 단합을 도모합니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
        array('label' => '집사회', 'href' => ''),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept/deacons');
}

get_header();
?>

<!-- Global Parallax Background Orbs -->
<div class="global-orbs">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="orb orb-4"></div>
    <div class="orb orb-5"></div>
</div>

<?php
get_template_part('template-parts/subpage-hero');
get_template_part('template-parts/submenu-nav');
?>

<style>
    .plan-box { background: #f8fafc; border-radius: 12px; padding: 25px; margin-top: 30px; }
    .plan-title { font-size: 1.1rem; font-weight: 700; color: #334155; margin-bottom: 15px; border-left: 4px solid #0284c7; padding-left: 10px; }
    .plan-list li { margin-bottom: 8px; position: relative; padding-left: 15px; }
    .plan-list li::before { content: '•'; position: absolute; left: 0; color: #94a3b8; }
</style>

<div class="container dept-page-section">
    <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap; margin-bottom:40px;">
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:300px;">
            <div class="dept-leader-icon" style="color:#0284c7; background:#e0f2fe;"><i data-lucide="user"></i></div>
            <div class="dept-leader-role">남수석 집사</div>
            <div class="dept-leader-name">박해욱</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:300px;">
            <div class="dept-leader-icon" style="color:#e11d48; background:#ffe4e6;"><i data-lucide="user"></i></div>
            <div class="dept-leader-role">여수석 집사</div>
            <div class="dept-leader-name">손옥분</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:300px;">
            <div class="dept-leader-icon" style="color:#64748b; background:#f1f5f9;"><i data-lucide="file-edit"></i></div>
            <div class="dept-leader-role">집사회 서기</div>
            <div class="dept-leader-name">허주현</div>
        </div>
    </div>
    <div class="dept-members-box">
        <h3 class="dept-section-title">2026 주요 활동 계획</h3>
        <div class="plan-box">
            <h4 class="plan-title">봉사 및 관리</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>예배 지원:</strong> 안내 위원 활동 및 교회 청결 관리</li>
                <li><strong>시설 관리:</strong> 비품 및 교회 시설 유지 보수</li>
                <li><strong>경조사:</strong> 성도 애경사 지원 및 애찬 봉사</li>
            </ul>
        </div>
        <div class="plan-box" style="margin-top:20px;">
            <h4 class="plan-title">친교 행사</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>단합 대회:</strong> 전교인 소풍 및 체육대회 (연 2회 예정)</li>
            </ul>
        </div>
    </div>
</div>

<?php get_footer(); ?>
