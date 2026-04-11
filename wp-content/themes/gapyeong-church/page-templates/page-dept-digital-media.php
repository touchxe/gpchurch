<?php
/**
 * Template Name: 부서 - 디지털홍보부
 *
 * 가평교회 테마 - 디지털홍보부 부서 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '디지털홍보부');
    set_query_var('subpage_slogan', '현장 예배의 감동을 온라인으로 생동감 있게 전달합니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
        array('label' => '디지털홍보부', 'href' => ''),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept/digital-media');
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
    .plan-title { font-size: 1.1rem; font-weight: 700; color: #334155; margin-bottom: 15px; border-left: 4px solid #6366f1; padding-left: 10px; }
    .plan-list li { margin-bottom: 8px; position: relative; padding-left: 15px; }
    .plan-list li::before { content: '•'; position: absolute; left: 0; color: #94a3b8; }

</style>

<div class="container dept-page-section">
    <div class="dept-leader-card">
        <div class="dept-leader-icon" style="color:#6366f1; background:#eef2ff;"><i data-lucide="video"></i></div>
        <div class="dept-leader-role">부장</div>
        <div class="dept-leader-name">허주현</div>
    </div>
    <div class="dept-members-box">
        <h3 class="dept-section-title">2026 운영 목표 및 계획</h3>
        <div class="plan-box">
            <h4 class="plan-title">미디어 선교 강화</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>라이브 송출:</strong> 예배 온라인 중계 시스템 안정화 및 생동감 구현</li>
                <li><strong>시스템 관리:</strong> 방송 장비 및 시스템 운영 매뉴얼화</li>
                <li><strong>인재 양성:</strong> 방송실 운영 요원 교육 및 육성</li>
            </ul>

        </div>
    </div>
</div>

<?php get_footer(); ?>
