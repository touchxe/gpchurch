<?php
/**
 * Template Name: 부서 - 찬양대
 *
 * 가평교회 테마 - 찬양대 부서 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '찬양대');
    set_query_var('subpage_slogan', '정성 어린 찬양으로 하나님께 영광을 돌립니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
        array('label' => '찬양대', 'href' => ''),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept/choir');
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
    .plan-title { font-size: 1.1rem; font-weight: 700; color: #334155; margin-bottom: 15px; border-left: 4px solid #db2777; padding-left: 10px; }
    .plan-list li { margin-bottom: 8px; position: relative; padding-left: 15px; }
    .plan-list li::before { content: '•'; position: absolute; left: 0; color: #94a3b8; }

</style>

<div class="container dept-page-section">
    <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap; margin-bottom:40px;">
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:280px;">
            <div class="dept-leader-role">대장</div>
            <div class="dept-leader-name">김지혜</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:280px;">
            <div class="dept-leader-role">부대장</div>
            <div class="dept-leader-name">장은영 / 조광현</div>
        </div>
    </div>
    <div class="dept-members-box">
        <h3 class="dept-section-title">구성 및 활동 계획</h3>
        <div class="plan-box">
            <h4 class="plan-title">조직 구성</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>반주자:</strong> 윤준석, 위현찬</li>
                <li><strong>오케스트라:</strong> 바이올린, 플롯, 클라리넷 등 기악팀 운영</li>
            </ul>
        </div>
        <div class="plan-box" style="margin-top:20px;">
            <h4 class="plan-title">2026 주요 활동</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li>매주 안식일 예배 특별 찬양</li>
                <li>연말 찬양 발표회 개최</li>
                <li>찬양 대원 영성 수련을 위한 음악 캠프 (1박 2일)</li>
            </ul>

        </div>
    </div>
</div>

<?php get_footer(); ?>
