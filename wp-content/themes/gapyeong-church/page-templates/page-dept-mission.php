<?php
/**
 * Template Name: 부서 - 선교회
 *
 * 가평교회 테마 - 선교회 부서 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '선교회');
    set_query_var('subpage_slogan', 'TMI(전교인 참여) 운동을 통해 복음을 전합니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
        array('label' => '선교회', 'href' => ''),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept/mission');
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
    .plan-title { font-size: 1.1rem; font-weight: 700; color: #334155; margin-bottom: 15px; border-left: 4px solid #ef4444; padding-left: 10px; }
    .plan-list li { margin-bottom: 8px; position: relative; padding-left: 15px; }
    .plan-list li::before { content: '•'; position: absolute; left: 0; color: #94a3b8; }

    .cycle-step { display: inline-flex; align-items: center; gap: 5px; font-weight: 700; color: #334155; margin-right: 15px; font-size: 0.95rem; }
    .cycle-step i { color: #ef4444; }
</style>

<div class="container dept-page-section">
    <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap; margin-bottom:40px;">
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:250px;">
            <div class="dept-leader-role" style="font-size:0.8rem;">회장</div>
            <div class="dept-leader-name" style="font-size:1.2rem;">김지혜</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:250px;">
            <div class="dept-leader-role" style="font-size:0.8rem;">남선교부장/서기</div>
            <div class="dept-leader-name" style="font-size:1.2rem;">심재영</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:250px;">
            <div class="dept-leader-role" style="font-size:0.8rem;">여선교부장</div>
            <div class="dept-leader-name" style="font-size:1.2rem;">최경숙</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:250px;">
            <div class="dept-leader-role" style="font-size:0.8rem;">문서선교부장</div>
            <div class="dept-leader-name" style="font-size:1.2rem;">이은화</div>
        </div>
    </div>
    <div class="dept-members-box">
        <h3 class="dept-section-title">2026 선교 전략 및 계획</h3>
        <div class="plan-box">
            <h4 class="plan-title">5단계 전도 사이클</h4>
            <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:15px;">
                <div class="cycle-step"><i data-lucide="check-circle-2"></i> 헌신</div>
                <div class="cycle-step"><i data-lucide="arrow-right"></i> 접촉(소그룹)</div>
                <div class="cycle-step"><i data-lucide="arrow-right"></i> 연결(기도)</div>
                <div class="cycle-step"><i data-lucide="arrow-right"></i> 초청(전도회)</div>
                <div class="cycle-step"><i data-lucide="arrow-right"></i> 정착(양육)</div>
            </div>
            <p style="color:#64748b; font-size:0.95rem;">관계 중심의 생활 전도와 소그룹 활동을 통해 영혼을 구원합니다.</p>
        </div>
        <div class="plan-box">
            <h4 class="plan-title">주요 활동</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>TMI 활동:</strong> 전교인이 참여하는 생활 속 선교</li>
                <li><strong>전도 지원:</strong> 소그룹 전도회 및 구도자 초청 행사 지원</li>
                <li><strong>문서 선교:</strong> 선교 서적 및 전도지 보급</li>
            </ul>

        </div>
    </div>
</div>

<?php get_footer(); ?>
