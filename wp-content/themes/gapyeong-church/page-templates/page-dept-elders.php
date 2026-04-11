<?php
/**
 * Template Name: 부서 - 장로회
 *
 * 가평교회 테마 - 장로회 부서 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '장로회');
    set_query_var('subpage_slogan', '영적 모범이 되며 성만찬과 성도 돌봄을 수행합니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
        array('label' => '장로회', 'href' => ''),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept/elders');
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
    .plan-title { font-size: 1.1rem; font-weight: 700; color: #334155; margin-bottom: 15px; border-left: 4px solid #6366f1; padding-left: 10px; }
    .communion-table { width: 100%; border-collapse: collapse; margin-top: 10px; background: white; }
    .communion-table th, .communion-table td { padding: 12px; border: 1px solid #e2e8f0; text-align: center; }
    .communion-table th { background: #eef2ff; color: #4338ca; }
</style>

<div class="container dept-page-section">
    <div class="dept-leader-card">
        <div class="dept-leader-icon"><i data-lucide="users"></i></div>
        <div class="dept-leader-role">수석장로</div>
        <div class="dept-leader-name">김재신</div>
    </div>
    <div class="dept-members-box">
        <h3 class="dept-section-title">2026 주요 역할</h3>
        <div class="plan-box">
            <h4 class="plan-title">핵심 직무</h4>
            <ul style="list-style:disc; padding-left:20px; color:#475569; line-height:1.8;">
                <li><strong>영적 지도:</strong> 교회의 영적 분위기 주도 및 모범</li>
                <li><strong>예배 인도:</strong> 설교 및 예배 순서 담당</li>
                <li><strong>성도 돌봄:</strong> 교인 심방 및 영적 필요 충족</li>
            </ul>
        </div>
        <div class="plan-box">
            <h4 class="plan-title">성만찬 예식 담당</h4>
            <table class="communion-table">
                <tr>
                    <th width="30%">구분</th>
                    <th>담당 장로</th>
                </tr>
                <tr>
                    <td>전반기</td>
                    <td>김재신, 심재영</td>
                </tr>
                <tr>
                    <td>후반기</td>
                    <td>신영빈, 김재신</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php get_footer(); ?>
