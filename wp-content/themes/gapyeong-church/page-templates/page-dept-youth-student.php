<?php
/**
 * Template Name: 부서 - 청년·학생선교회
 *
 * 가평교회 테마 - 청년·학생선교회 부서 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '청년·학생선교회');
    set_query_var('subpage_slogan', '젊음의 열정으로 복음을 전하고 교회를 섬깁니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
        array('label' => '청년·학생선교회', 'href' => ''),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept/youth-student');
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
    .plan-title { font-size: 1.1rem; font-weight: 700; color: #334155; margin-bottom: 15px; border-left: 4px solid #06b6d4; padding-left: 10px; }
    .plan-list li { margin-bottom: 8px; position: relative; padding-left: 15px; }
    .plan-list li::before { content: '•'; position: absolute; left: 0; color: #94a3b8; }

</style>

<div class="container dept-page-section">
    <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap; margin-bottom:40px;">
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:300px;">
            <div class="dept-leader-icon" style="color:#06b6d4; background:#cffafe;"><i data-lucide="user"></i></div>
            <div class="dept-leader-role">지도교사</div>
            <div class="dept-leader-name">신영빈</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:300px;">
            <div class="dept-leader-icon" style="color:#06b6d4; background:#cffafe;"><i data-lucide="user"></i></div>
            <div class="dept-leader-role">회장</div>
            <div class="dept-leader-name">윤준석</div>
        </div>
    </div>
    <div class="dept-members-box">
        <h3 class="dept-section-title">2026 핵심 사업</h3>
        <div class="plan-box">
            <h4 class="plan-title">특화 프로젝트</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>홈페이지 구축:</strong> 교회 맞춤형 홈페이지 구축 및 보급 프로젝트 진행</li>
                <li><strong>봉사 동아리:</strong> 지역사회 봉사 및 재능 기부 활동</li>
            </ul>
        </div>
        <div class="plan-box" style="margin-top:20px;">
            <h4 class="plan-title">영성 및 선교</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>해외 봉사:</strong> 필리핀 등 해외 선교지 봉사 활동 지원</li>
                <li><strong>신앙 훈련:</strong> 정기 성경 공부 및 기도 모임 운영</li>
            </ul>

        </div>
    </div>
</div>

<?php get_footer(); ?>
