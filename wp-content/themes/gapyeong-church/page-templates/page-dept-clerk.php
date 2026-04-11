<?php
/**
 * Template Name: 부서 - 교회서기
 *
 * 가평교회 테마 - 교회서기 부서 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '교회서기');
    set_query_var('subpage_slogan', '교회의 모든 행정 기록과 교적을 체계적으로 관리합니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
        array('label' => '교회서기', 'href' => ''),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept/clerk');
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
    .plan-title { font-size: 1.1rem; font-weight: 700; color: #334155; margin-bottom: 15px; border-left: 4px solid #64748b; padding-left: 10px; }
    .plan-list li { margin-bottom: 8px; position: relative; padding-left: 15px; }
    .plan-list li::before { content: '•'; position: absolute; left: 0; color: #94a3b8; }
</style>

<div class="container dept-page-section">
    <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap; margin-bottom:40px;">
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:350px;">
            <div class="dept-leader-icon"><i data-lucide="file-text"></i></div>
            <div class="dept-leader-role">서기</div>
            <div class="dept-leader-name">심재영</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:350px;">
            <div class="dept-leader-icon"><i data-lucide="file-text"></i></div>
            <div class="dept-leader-role">부서기</div>
            <div class="dept-leader-name">김원창</div>
        </div>
    </div>
    <div class="dept-members-box">
        <h3 class="dept-section-title">2026 주요 업무</h3>
        <div class="plan-box">
            <h4 class="plan-title">행정 및 관리 계획</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>문서 보관:</strong> 직원회 회의록, 교회 일지 등 중요 행정 문서의 체계적 보관</li>
                <li><strong>교적 관리:</strong> 전입/전출, 침례, 사망 보고 및 교적부 최신화</li>
                <li><strong>자산 점검:</strong> 교회 재산 및 비품에 대한 연 1회 정기 점검 실시</li>
            </ul>
        </div>
    </div>
</div>

<?php get_footer(); ?>
