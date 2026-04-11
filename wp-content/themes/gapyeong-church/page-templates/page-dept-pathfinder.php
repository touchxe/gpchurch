<?php
/**
 * Template Name: 부서 - 패스파인더
 *
 * 가평교회 테마 - 패스파인더 부서 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '패스파인더');
    set_query_var('subpage_slogan', '지육, 덕육, 체육을 고루 갖춘 청소년 지도자를 양성합니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
        array('label' => '패스파인더', 'href' => ''),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept/pathfinder');
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
    .plan-title { font-size: 1.1rem; font-weight: 700; color: #334155; margin-bottom: 15px; border-left: 4px solid #8b5cf6; padding-left: 10px; }
    .plan-list li { margin-bottom: 8px; position: relative; padding-left: 15px; }
    .plan-list li::before { content: '•'; position: absolute; left: 0; color: #94a3b8; }

</style>

<div class="container dept-page-section">
    <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap; margin-bottom:40px;">
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:300px;">
            <div class="dept-leader-icon" style="color:#8b5cf6; background:#f3e8ff;"><i data-lucide="compass"></i></div>
            <div class="dept-leader-role">대장</div>
            <div class="dept-leader-name">신영빈</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:300px;">
            <div class="dept-leader-icon" style="color:#8b5cf6; background:#f3e8ff;"><i data-lucide="compass"></i></div>
            <div class="dept-leader-role">부대장</div>
            <div class="dept-leader-name">권용복</div>
        </div>
    </div>
    <div class="dept-members-box">
        <h3 class="dept-section-title">2026 활동 목표 및 계획</h3>
        <div class="plan-box">
            <h4 class="plan-title">주요 목표</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>대원 확보:</strong> 정회원 15명 확보 및 등록 목표</li>
                <li><strong>지도자 양성:</strong> 마스터 가이드(MG) 및 BSTC 지도자 교육 이수</li>
                <li><strong>가족 참여:</strong> 부모님과 함께하는 가족 캠프 운영</li>
            </ul>
        </div>
        <div class="plan-box" style="margin-top:20px;">
            <h4 class="plan-title">기능 활동</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li>야영 기술 및 매듭법 훈련</li>
                <li>제식 훈련 및 기초 체력 단련</li>
                <li>천연계 탐사 및 환경 보호 활동</li>
            </ul>

        </div>
    </div>
</div>

<?php get_footer(); ?>
