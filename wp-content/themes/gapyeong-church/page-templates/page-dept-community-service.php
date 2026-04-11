<?php
/**
 * Template Name: 부서 - 지역사회봉사회
 *
 * 가평교회 테마 - 지역사회봉사회 부서 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '지역사회봉사회 (도르가회)');
    set_query_var('subpage_slogan', '예수님의 사랑으로 이웃을 섬기며 나눔을 실천합니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
        array('label' => '지역사회봉사회', 'href' => ''),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept/community-service');
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
    .plan-title { font-size: 1.1rem; font-weight: 700; color: #334155; margin-bottom: 15px; border-left: 4px solid #d946ef; padding-left: 10px; }
    .plan-list li { margin-bottom: 8px; position: relative; padding-left: 15px; }
    .plan-list li::before { content: '•'; position: absolute; left: 0; color: #94a3b8; }

</style>

<div class="container dept-page-section">
    <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap; margin-bottom:40px;">
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:300px;">
            <div class="dept-leader-icon" style="color:#d946ef; background:#fae8ff;"><i data-lucide="heart-handshake"></i></div>
            <div class="dept-leader-role">회장</div>
            <div class="dept-leader-name">장은영</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:300px;">
            <div class="dept-leader-icon" style="color:#d946ef; background:#fae8ff;"><i data-lucide="heart-handshake"></i></div>
            <div class="dept-leader-role">부회장</div>
            <div class="dept-leader-name">최경숙 / 이은화</div>
        </div>
    </div>
    <div class="dept-members-box">
        <h3 class="dept-section-title">2026 주요 사업 계획</h3>
        <div class="plan-box">
            <h4 class="plan-title">나눔과 봉사</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>도르가 바자회:</strong> 바자회 운영을 통한 수익금 기부</li>
                <li><strong>지원 사업:</strong> 청년 격려금 및 지역 인재 장학금 지원</li>
                <li><strong>구호 활동:</strong> 드림스타트(아동 지원), 반찬 봉사, 긴급 구호</li>
            </ul>

        </div>
    </div>
</div>

<?php get_footer(); ?>
