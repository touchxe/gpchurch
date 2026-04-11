<?php
/**
 * Template Name: 부서 - 안식일학교
 *
 * 가평교회 테마 - 안식일학교 부서 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '안식일학교');
    set_query_var('subpage_slogan', '말씀 연구와 교제를 통해 성도들의 영적 성장을 도모합니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
        array('label' => '안식일학교', 'href' => ''),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept/sabbath-school');
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
    .plan-title { font-size: 1.1rem; font-weight: 700; color: #334155; margin-bottom: 15px; border-left: 4px solid #3b82f6; padding-left: 10px; }
    .plan-list li { margin-bottom: 8px; position: relative; padding-left: 15px; }
    .plan-list li::before { content: '•'; position: absolute; left: 0; color: #94a3b8; }

</style>

<div class="container dept-page-section">
    <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap; margin-bottom:40px;">
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:280px;">
            <div class="dept-leader-role">교장</div>
            <div class="dept-leader-name">최원태</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:280px;">
            <div class="dept-leader-role">부교장</div>
            <div class="dept-leader-name">김원창</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:280px;">
            <div class="dept-leader-role">부교장</div>
            <div class="dept-leader-name">이진희 / 조광현</div>
        </div>
    </div>
    <div class="dept-members-box">
        <h3 class="dept-section-title">2026 운영 계획</h3>
        <div class="plan-box">
            <h4 class="plan-title">주요 활동</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>토의식 교과:</strong> 주입식이 아닌 성도들이 참여하는 토의식 교과 운영</li>
                <li><strong>말씀 생활:</strong> 기억절 암송 및 퀴즈 대회 개최</li>
                <li><strong>출석 캠페인:</strong> 정각 출석 장려 및 결석자 챙기기</li>
                <li><strong>소그룹 강화:</strong> 반별 소그룹 활동 및 친교 활성화</li>
            </ul>

        </div>
    </div>
</div>

<?php get_footer(); ?>
