<?php
/**
 * Template Name: 부서 - 목회부
 *
 * 가평교회 테마 - 목회부 부서 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '목회부');
    set_query_var('subpage_slogan', '성령의 권능으로 증인이 되고 새 생명을 잉태하도록 이끕니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
        array('label' => '목회부', 'href' => ''),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept/ministry');
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
    <div class="dept-leader-card">
        <div class="dept-leader-icon"><i data-lucide="cross"></i></div>
        <div class="dept-leader-role">담임목사</div>
        <div class="dept-leader-name">위수민</div>
    </div>
    <div class="dept-members-box">
        <h3 class="dept-section-title">2026 부서 사명</h3>
        <p style="font-size: 1.1rem; color: #1e293b; font-weight: 500; margin-bottom: 20px;">
            "성령의 권능으로 증인이 되고 새 생명을 잉태하도록 이끄는 것"
        </p>
        <div class="plan-box">
            <h4 class="plan-title">주요 활동 계획</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>영적 분위기 조성:</strong> 말씀 365 묵상, 기도생활 강조, &lt;시대의 소망&gt; 필독</li>
                <li><strong>행복 누리기:</strong> 친교 소그룹 활성화 및 외부 활동을 통한 단합 도모</li>
                <li><strong>제자 훈련:</strong> 소그룹 리더 강화 및 목양장로 육성 프로그램 운영</li>
                <li><strong>전도:</strong> 1인 1 구도자 확보 운동 및 TMI(전교인) 활동 주력</li>
            </ul>

        </div>
    </div>
</div>

<?php get_footer(); ?>
