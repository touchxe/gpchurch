<?php
/**
 * Template Name: 부서 - 보건복지부
 *
 * 가평교회 테마 - 보건복지부 부서 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '보건복지부');
    set_query_var('subpage_slogan', '성도들과 이웃의 건강한 삶(Newstart)을 지원합니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
        array('label' => '보건복지부', 'href' => ''),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept/health-welfare');
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
    .plan-title { font-size: 1.1rem; font-weight: 700; color: #334155; margin-bottom: 15px; border-left: 4px solid #10b981; padding-left: 10px; }
    .plan-list li { margin-bottom: 8px; position: relative; padding-left: 15px; }
    .plan-list li::before { content: '•'; position: absolute; left: 0; color: #94a3b8; }

</style>

<div class="container dept-page-section">
    <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap; margin-bottom:40px;">
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:300px;">
            <div class="dept-leader-icon" style="color:#10b981; background:#dcfce7;"><i data-lucide="activity"></i></div>
            <div class="dept-leader-role">부장</div>
            <div class="dept-leader-name">최경숙</div>
        </div>
        <div class="dept-leader-card" style="margin:0; width:100%; max-width:300px;">
            <div class="dept-leader-icon" style="color:#10b981; background:#dcfce7;"><i data-lucide="activity"></i></div>
            <div class="dept-leader-role">부부장</div>
            <div class="dept-leader-name">최영숙</div>
        </div>
    </div>
    <div class="dept-members-box">
        <h3 class="dept-section-title">2026 건강 증진 계획</h3>
        <div class="plan-box">
            <h4 class="plan-title">주요 활동</h4>
            <ul class="plan-list" style="color:#475569; line-height:1.6;">
                <li><strong>맨발 걷기 (어싱):</strong> 매주 안식일 오후 3시 체력 증진 프로그램 운영</li>
                <li><strong>건강 강습회:</strong> 뉴스타트(Newstart) 건강 강습회 및 절제 주간 운영</li>
                <li><strong>말씀 교제:</strong> 매주 안식일 오후 예언의 신 말씀 나눔</li>
            </ul>

        </div>
    </div>
</div>

<?php get_footer(); ?>
