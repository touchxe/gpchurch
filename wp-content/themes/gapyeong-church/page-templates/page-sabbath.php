<?php
/**
 * Template Name: 안식일학교 페이지
 *
 * 가평교회 테마 - 안식일학교 서브페이지 템플릿
 * 기존 program/sabbath.html 의 <body> 콘텐츠를 WordPress PHP로 변환
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
    set_query_var('subpage_title', '안식일학교');
    set_query_var('subpage_slogan', '배우고 나누고 성장하는 신앙 공동체');
    set_query_var('breadcrumb_items', array(
        array('label' => '프로그램', 'href' => '/program'),
        array('label' => '안식일학교', 'href' => ''),
    ));
    set_query_var('submenu_group', 'program');
    set_query_var('submenu_active', '/program/sabbath');
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

            <!-- 1. 임원 및 조직 -->
            <div class="ss-section">
                <h2 class="ss-section-title">임원 및 조직</h2>
                <div class="officer-container">
                    <div class="officer-row">
                        <span class="officer-role">교장</span>
                        <span class="officer-names">최원태</span>
                    </div>
                    <div class="officer-row">
                        <span class="officer-role">부교장</span>
                        <span class="officer-names">김원창, 이진희, 조광현</span>
                    </div>
                    <div class="officer-row">
                        <span class="officer-role">서기</span>
                        <span class="officer-names">김한나</span>
                    </div>
                </div>
            </div>

            <!-- 2. 표어 및 성구 -->
            <div class="ss-section">
                <h2 class="ss-section-title">표어 및 성구</h2>
                <div class="motto-banner">
                    <div class="motto-main">"배우고 나누고 성장하는 안식일학교"</div>
                    <div class="motto-verse">
                        "너희는 내게 배우고 받고 듣고 본 바를 행하라 그리하면 평강의 하나님이 너희와 함께 계시리라" (빌립보서 4:9)
                    </div>
                </div>
            </div>

            <!-- 3. 사명 및 목표 -->
            <div class="ss-section">
                <h2 class="ss-section-title">사명 및 사업 목표</h2>
                <div class="mission-grid">
                    <div class="mission-card">
                        <div class="mission-title"><i data-lucide="book-open"></i> 영적 성장</div>
                        <p class="mission-desc">토의식 교과 교수법 정착, 교사 양성, 기억절 암송 및 퀴즈 대회 등</p>
                    </div>
                    <div class="mission-card">
                        <div class="mission-title"><i data-lucide="users"></i> 소그룹 중심</div>
                        <p class="mission-desc">교사 교육 활성화, 안교 소그룹별 말씀 나눔 및 선교활동 실시</p>
                    </div>
                    <div class="mission-card">
                        <div class="mission-title"><i data-lucide="globe"></i> 선교 동참</div>
                        <p class="mission-desc">선교 자료 보급, 선교 영상 공유, 지역사회 선교 허브 구축</p>
                    </div>
                    <div class="mission-card">
                        <div class="mission-title"><i data-lucide="smile"></i> 활기찬 안교</div>
                        <p class="mission-desc">정각 출석 캠페인 (선물 증정), 아멘 운동 전개, 활기 넘치는 분위기</p>
                    </div>
                </div>
            </div>

            <!-- 4. 반 편성 -->
            <div class="ss-section">
                <h2 class="ss-section-title">반 편성 현황</h2>
                <div class="class-groups-container">
                    <!-- 어린이 / 학생 / 청년 -->
                    <div class="class-group">
                        <div class="class-group-header">
                            <i data-lucide="graduation-cap" style="color:#f59e0b"></i> 어린이 / 학생 / 청년
                        </div>
                        <div class="class-list">
                            <div class="class-item">
                                <h4 class="class-name">청년반</h4>
                                <p class="class-detail">교사: 이진희</p>
                            </div>
                            <div class="class-item">
                                <h4 class="class-name">학생반</h4>
                                <p class="class-detail">교사: 담임목사 (부: 조광현)</p>
                            </div>
                            <div class="class-item">
                                <h4 class="class-name">소년반</h4>
                                <p class="class-detail">교사: 김한나 (부: 허주현)</p>
                            </div>
                            <div class="class-item">
                                <h4 class="class-name">유년반</h4>
                                <p class="class-detail">교사: 장은영 (부: 최원태)</p>
                            </div>
                            <div class="class-item">
                                <h4 class="class-name">유치반</h4>
                                <p class="class-detail">교사: 김이슬</p>
                            </div>
                        </div>
                    </div>

                    <!-- 장년반 -->
                    <div class="class-group">
                        <div class="class-group-header">
                            <i data-lucide="users" style="color:#3b82f6"></i> 장년반
                        </div>
                        <div class="class-list">
                            <div class="class-item">
                                <h4 class="class-name">믿음반</h4>
                                <p class="class-detail">교사: 엄보석 (부: 정봉길)</p>
                                <div class="class-location"><i data-lucide="map-pin" size="14"></i> 1층 소예배실</div>
                            </div>
                            <div class="class-item">
                                <h4 class="class-name">다니엘반</h4>
                                <p class="class-detail">교사: 신영빈 (부: 김원창)</p>
                                <div class="class-location"><i data-lucide="map-pin" size="14"></i> 2층 세미나실</div>
                            </div>
                            <div class="class-item">
                                <h4 class="class-name">요한반</h4>
                                <p class="class-detail">교사: 최수동 (부: 심재영)</p>
                                <div class="class-location"><i data-lucide="map-pin" size="14"></i> 본당</div>
                            </div>
                            <div class="class-item">
                                <h4 class="class-name">새신자반</h4>
                                <p class="class-detail">교사: 김재신 (부: 담임목사)</p>
                                <div class="class-location"><i data-lucide="map-pin" size="14"></i> 본당</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
