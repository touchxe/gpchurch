<?php
/**
 * Template Name: 예배 시간 페이지
 *
 * 가평교회 테마 - 예배 및 프로그램 서브페이지 템플릿
 * 기존 program/worship.html 의 <body> 콘텐츠를 WordPress PHP로 변환
 */

// ── 서브페이지 컨텍스트 자동 감지 ──
$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '예배 시간');
    set_query_var('subpage_slogan', '거룩한 안식일, 하나님과 함께하는 시간');
    set_query_var('breadcrumb_items', array(
        array('label' => '프로그램', 'href' => '/program'),
        array('label' => '예배 시간', 'href' => ''),
    ));
    set_query_var('submenu_group', 'program');
    set_query_var('submenu_active', '/program/worship');
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
<section class="subpage-content">
    <div class="container">
        <div class="content-box">

            <!-- 1. 예배 및 기도회 -->
            <div class="program-section">
                <h2 class="program-section-title">예배 및 기도회</h2>
                <div class="worship-schedule-list">
                    <div class="worship-item">
                        <span class="worship-badge badge-sabbath">안식일 예배</span>
                        <div class="worship-info">
                            <h3 class="worship-name">매주 안식일 (토요일)</h3>
                            <p class="worship-time">오전 11:00 / 본당</p>
                        </div>
                    </div>
                    <div class="worship-item">
                        <span class="worship-badge badge-friday">금요일 예배</span>
                        <div class="worship-info">
                            <h3 class="worship-name">매주 금요일</h3>
                            <p class="worship-time">오후 7:30 / 본당</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. 안식일 오후 활동 -->
            <div class="program-section">
                <h2 class="program-section-title">안식일 오후 활동</h2>
                <div class="activity-grid">
                    <div class="activity-card">
                        <div class="activity-icon"><i data-lucide="compass"></i></div>
                        <h3>패스파인더</h3>
                        <span class="activity-time">매주 안식일 13:30 ~ 15:00</span>
                        <p class="activity-desc">탄력적 운영 (청소년 및 어린이)</p>
                    </div>
                    <div class="activity-card">
                        <div class="activity-icon"><i data-lucide="users"></i></div>
                        <h3>청년반</h3>
                        <span class="activity-time">매주 안식일 13:30 ~ 16:00</span>
                        <p class="activity-desc">청년 교제 및 신앙 활동</p>
                    </div>
                    <div class="activity-card">
                        <div class="activity-icon"><i data-lucide="book-heart"></i></div>
                        <h3>말씀 교제</h3>
                        <span class="activity-time">매주 안식일 13:30 ~ 15:00</span>
                        <p class="activity-desc">선교부 주관 (예언의 신 연구)</p>
                    </div>
                    <div class="activity-card">
                        <div class="activity-icon"><i data-lucide="footprints"></i></div>
                        <h3>체력 증진</h3>
                        <span class="activity-time">매주 안식일 15:00</span>
                        <p class="activity-desc">맨발 걷기 및 자연 교감 활동</p>
                    </div>
                    <div class="activity-card">
                        <div class="activity-icon"><i data-lucide="home"></i></div>
                        <h3>대심방</h3>
                        <span class="activity-time">4~5월 대심방 기간</span>
                        <p class="activity-desc">선교회 주관 대심방</p>
                    </div>
                </div>
            </div>

            <!-- 3. 예배 준비 수칙 -->
            <div class="program-section" style="margin-bottom: 0;">
                <div class="rules-box">
                    <h2 class="rules-title"><i data-lucide="check-circle-2" style="margin-right: 10px;"></i> 예배 준비 수칙</h2>
                    <div class="rules-list">
                        <div class="rule-item">
                            <span class="rule-role">모든 성도</span>
                            <p class="rule-action">예배 시간 <strong>10분 전</strong>에 참석하여 기도로 준비합니다.</p>
                        </div>
                        <div class="rule-item">
                            <span class="rule-role">시무 장로</span>
                            <p class="rule-action">예배 <strong>20분 전</strong> 도착하여 강단 및 순서를 점검합니다.</p>
                        </div>
                        <div class="rule-item">
                            <span class="rule-role">시무 집사 / 인도자</span>
                            <p class="rule-action">예배 <strong>15분 전</strong> 도착하여 안내 및 순서를 준비합니다.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
