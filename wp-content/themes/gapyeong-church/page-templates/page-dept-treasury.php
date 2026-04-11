<?php
/**
 * Template Name: 부서 - 교회재무
 *
 * 가평교회 테마 - 교회재무 부서 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '교회재무');
    set_query_var('subpage_slogan', '정직과 투명함으로 하나님의 청지기 사명을 감당합니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
        array('label' => '교회재무', 'href' => ''),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept/treasury');
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
    .plan-title { font-size: 1.1rem; font-weight: 700; color: #334155; margin-bottom: 15px; border-left: 4px solid #f59e0b; padding-left: 10px; }
    .plan-list li { margin-bottom: 8px; position: relative; padding-left: 15px; }
    .plan-list li::before { content: '•'; position: absolute; left: 0; color: #94a3b8; }
</style>

<div class="container dept-page-section">
    <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap; margin-bottom:40px;">
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:350px;">
            <div class="dept-leader-icon"><i data-lucide="calculator"></i></div>
            <div class="dept-leader-role">재무</div>
            <div class="dept-leader-name">김한나</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:350px;">
            <div class="dept-leader-icon"><i data-lucide="calculator"></i></div>
            <div class="dept-leader-role">부재무</div>
            <div class="dept-leader-name">김선경</div>
        </div>
    </div>
    <div class="dept-members-box">
        <h3 class="dept-section-title">2026 운영 목표 및 원칙</h3>
        <div class="plan-box">
            <h4 class="plan-title">목표 (Goals)</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>정직한 십일금:</strong> 성도들의 온전한 십일조 생활 정착</li>
                <li><strong>헌금 장려:</strong> 월정 헌금 및 도르가 헌금의 적극적 참여 권장</li>
                <li><strong>투명성:</strong> 정확하고 투명한 재정 관리 및 정기 보고</li>
            </ul>
        </div>
        <div class="plan-box" style="margin-top:20px; background:#fff7ed;">
            <h4 class="plan-title" style="border-color:#ea580c;">운영 원칙 (Principles)</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>지출 결의:</strong> 10만 원 이상 지출 시 반드시 직원회 결의 필요 (고정 지출 제외)</li>
                <li><strong>증빙 원칙:</strong> 모든 지출은 결의서 작성 및 영수증 첨부 필수</li>
            </ul>
        </div>
    </div>
</div>

<?php get_footer(); ?>
