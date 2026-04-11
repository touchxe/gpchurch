<?php
/**
 * Template Name: 패스파인더 페이지
 *
 * 가평교회 테마 - 패스파인더 서브페이지 템플릿
 * 기존 program/pathfinder.html 의 <body> 콘텐츠를 WordPress PHP로 변환
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
    set_query_var('subpage_title', '패스파인더');
    set_query_var('subpage_slogan', '이 시대의 믿음직한 청소년 탐험가');
    set_query_var('breadcrumb_items', array(
        array('label' => '프로그램', 'href' => '/program'),
        array('label' => '패스파인더', 'href' => ''),
    ));
    set_query_var('submenu_group', 'program');
    set_query_var('submenu_active', '/program/pathfinder');
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

            <!-- 1. 임원 및 교사 -->
            <div class="pf-section">
                <h2 class="pf-section-title">임원 및 교사 조직</h2>
                <div class="pf-officer-box">
                    <div class="pf-officer-grid">
                        <div class="pf-officer-item">
                            <span class="pf-role">대장</span>
                            <span class="pf-name">신영빈</span>
                        </div>
                        <div class="pf-officer-item">
                            <span class="pf-role">부대장</span>
                            <span class="pf-name">권용복</span>
                        </div>
                        <div class="pf-officer-item">
                            <span class="pf-role">총무</span>
                            <span class="pf-name">허주현</span>
                        </div>
                        <div class="pf-officer-item">
                            <span class="pf-role">간식 담당</span>
                            <span class="pf-name">김한나, 김이슬</span>
                        </div>
                    </div>
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px dashed #e2e8f0;">
                        <span class="pf-role">교사 (7명)</span>
                        <p class="pf-name" style="margin-top: 5px;">최원태, 허주현, 심재영, 김지혜, 김원창, 권용복, 최소영</p>
                    </div>
                </div>
            </div>

            <!-- 2. 주요 목표 -->
            <div class="pf-section">
                <h2 class="pf-section-title">2026 주요 목표</h2>
                <div class="pf-goal-grid">
                    <div class="pf-goal-card">
                        <div class="pf-goal-icon"><i data-lucide="globe"></i></div>
                        <h4 class="pf-goal-title">사명 확인</h4>
                        <p class="pf-goal-desc">재림기별을 이 시대 안으로 온 세상에 전파합니다.</p>
                    </div>
                    <div class="pf-goal-card">
                        <div class="pf-goal-icon"><i data-lucide="user-plus"></i></div>
                        <h4 class="pf-goal-title">등록 목표</h4>
                        <p class="pf-goal-desc">정회원 15명 등록을 목표로 힘차게 나아갑니다.</p>
                    </div>
                    <div class="pf-goal-card">
                        <div class="pf-goal-icon"><i data-lucide="award"></i></div>
                        <h4 class="pf-goal-title">지도자 육성</h4>
                        <p class="pf-goal-desc">교사의 영적 성숙과 자격 취득(MG)을 장려합니다.</p>
                    </div>
                </div>
            </div>

            <!-- 3. 반 편성 -->
            <div class="pf-section">
                <h2 class="pf-section-title">반 편성 현황</h2>
                <div class="pf-table-container">
                    <table class="pf-table">
                        <thead>
                            <tr>
                                <th>구분 (과정)</th>
                                <th>대원 (학생)</th>
                                <th>담당 교사</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="pf-level-badge level-adv">리틀램 (AD)</span></td>
                                <td>김예온</td>
                                <td>김이슬</td>
                            </tr>
                            <tr>
                                <td><span class="pf-level-badge level-adv">건축가 (AD)</span><br><span style="font-size:0.8rem; color:#64748b">10세</span></td>
                                <td>김하온, 신세현, 최하엘</td>
                                <td>허주현, 김지혜</td>
                            </tr>
                            <tr>
                                <td><span class="pf-level-badge level-pf">친구 (PF)</span><br><span style="font-size:0.8rem; color:#64748b">12세</span></td>
                                <td>권민준, 권여준, 최민선</td>
                                <td>김이슬</td>
                            </tr>
                            <tr>
                                <td><span class="pf-level-badge level-pf">동행자 (PF)</span><br><span style="font-size:0.8rem; color:#64748b">13세</span></td>
                                <td>신세은, 심태현</td>
                                <td>김원창, 권용복</td>
                            </tr>
                            <tr>
                                <td><span class="pf-level-badge level-pf">항해자 (PF)</span><br><span style="font-size:0.8rem; color:#64748b">16세</span></td>
                                <td>신이한, 심서희, 최하성</td>
                                <td>최원태, 최소영</td>
                            </tr>
                            <tr>
                                <td><span class="pf-level-badge level-senior">인도자 (Senior)</span><br><span style="font-size:0.8rem; color:#64748b">17세</span></td>
                                <td>심서연</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 4. 활동 및 운영 -->
            <div class="pf-section">
                <h2 class="pf-section-title">활동 및 운영 계획</h2>
                <div class="pf-info-grid">
                    <div class="pf-info-box">
                        <h3 style="font-size:1.2rem; font-weight:700; margin-bottom:15px; color:#1e293b;">운영 및 활동</h3>
                        <ul class="pf-info-list">
                            <li><strong>운영 시간:</strong> 매주 안식일 오후 13:30 ~ 15:00 (탄력 운영)</li>
                            <li><strong>홍보:</strong> 네이버 밴드, 홈페이지, 당근마켓, 현수막 활용</li>
                            <li><strong>지도자 훈련:</strong> 합회 BSTC 및 Master Guide 참여, 정기 교사 회의</li>
                            <li><strong>캠프:</strong> 연 2회 가족 참여 캠프 및 단합 캠프</li>
                        </ul>
                    </div>
                    <div class="pf-info-box">
                        <h3 style="font-size:1.2rem; font-weight:700; margin-bottom:15px; color:#1e293b;">회비 및 제복</h3>
                        <ul class="pf-info-list">
                            <li><strong>회비:</strong> 월 7,000원 (1년 일납 시 월 5,000원 적용)</li>
                            <li><strong>제복:</strong> 개인 구매 원칙 (교회 1인당 10,000원 지원)</li>
                            <li><strong>기타:</strong> 진급 핀, 마크, 삼각건 등은 교회 제공</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
