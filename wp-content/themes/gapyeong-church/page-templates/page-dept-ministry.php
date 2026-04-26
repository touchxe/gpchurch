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

<!-- Content Section -->
<div class="container dept-page-section">

    <!-- 부서 프로필 카드 (좌우 분할) -->
    <div class="dept-profile-card">

        <!-- 왼쪽: 아이콘 + 부서명 + 담당자 -->
        <div class="dept-profile-left">
            <div class="dept-profile-icon">
                <i data-lucide="book-open"></i>
            </div>
            <h2 class="dept-profile-name">목회부</h2>
            <p class="dept-profile-sub">2026년도 부서</p>

            <div class="dept-profile-divider"></div>

            <div class="dept-profile-members">
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">담임목사</span>
                    <span class="dept-profile-member-name">위수민</span>
                </div>
            </div>

            <div class="dept-profile-tags">
                <span class="dept-tag">영적 성장</span>
                <span class="dept-tag">전도</span>
                <span class="dept-tag">제자훈련</span>
            </div>
        </div>

        <!-- 오른쪽: 사명 + 활동 계획 -->
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label">
                    <i data-lucide="target"></i>
                    <span>2026 부서 사명</span>
                </div>
                <p class="dept-mission-text">
                    "성령의 권능으로 증인이 되고 새 생명을 잉태하도록 이끄는 것"
                </p>
            </div>

            <div class="dept-right-section">
                <div class="dept-right-label">
                    <i data-lucide="list-checks"></i>
                    <span>주요 활동 계획</span>
                </div>
                <ul class="dept-plan-list">
                    <li>
                        <span class="dept-plan-keyword">영적 분위기 조성</span>
                        말씀 365 묵상, 기도생활 강조, &lt;시대의 소망&gt; 필독
                    </li>
                    <li>
                        <span class="dept-plan-keyword">행복 누리기</span>
                        친교 소그룹 활성화 및 외부 활동을 통한 단합 도모
                    </li>
                    <li>
                        <span class="dept-plan-keyword">제자 훈련</span>
                        소그룹 리더 강화 및 목양장로 육성 프로그램 운영
                    </li>
                    <li>
                        <span class="dept-plan-keyword">전도</span>
                        1인 1 구도자 확보 운동 및 TMI(전교인) 활동 주력
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>

<?php get_footer(); ?>
