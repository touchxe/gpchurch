<?php
/**
 * Template Name: 부서 - 어린이부
 *
 * 가평교회 테마 - 어린이부 부서 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '어린이부');
    set_query_var('subpage_slogan', '예수님의 성품을 닮은 어린이로 자라나도록 양육합니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
        array('label' => '어린이부', 'href' => ''),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept/children');
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
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:300px;">
            <div class="dept-leader-icon" style="color:#f59e0b; background:#fff7ed;"><i data-lucide="baby"></i></div>
            <div class="dept-leader-role">부장</div>
            <div class="dept-leader-name">김이슬</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:300px;">
            <div class="dept-leader-icon" style="color:#f59e0b; background:#fff7ed;"><i data-lucide="baby"></i></div>
            <div class="dept-leader-role">부부장</div>
            <div class="dept-leader-name">최소영</div>
        </div>
    </div>
    <div class="dept-members-box">
        <h3 class="dept-section-title">2026 양육 및 전도 계획</h3>
        <div class="plan-box">
            <h4 class="plan-title">주요 프로그램</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>영성 훈련:</strong> 사무엘 캠프 참가, 설교 노트 쓰기 지도</li>
                <li><strong>전도 활동:</strong> 방학 중 '만나데이', 친구 초청 안식일 행사</li>
                <li><strong>특별 행사:</strong> 여름/겨울 성경학교, 어린이 펀데이(Fun Day), 뮤지컬 관람</li>
                <li><strong>야외 활동:</strong> 천연계 탐사 및 소풍</li>
            </ul>

        </div>
    </div>
</div>

<?php get_footer(); ?>
