<?php
/**
 * Template Name: 소그룹 페이지
 *
 * 가평교회 테마 - 소그룹 서브페이지 템플릿
 * 기존 program/smallgroup.html 의 <body> 콘텐츠를 WordPress PHP로 변환
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
    set_query_var('subpage_title', '소그룹');
    set_query_var('subpage_slogan', '가정에서 나누는 따뜻한 말씀과 교제');
    set_query_var('breadcrumb_items', array(
        array('label' => '프로그램', 'href' => '/program'),
        array('label' => '소그룹', 'href' => ''),
    ));
    set_query_var('submenu_group', 'program');
    set_query_var('submenu_active', '/program/smallgroup');
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

            <!-- 1. 운영 목표 -->
            <div class="sg-section">
                <h2 class="sg-section-title">운영 목표 및 방향</h2>
                <div class="sg-goal-box">
                    <div class="sg-goal-list">
                        <div class="sg-goal-item">
                            <div class="sg-goal-icon"><i data-lucide="heart-handshake"></i></div>
                            <div>
                                <h4 style="font-weight:700;">핵심 목표</h4>
                                <p style="color:#64748b;">마음과 마음을 이어주는 관계 회복에 집중하며, 삶과 신앙을 나누는 공동체를 지향합니다.</p>
                            </div>
                        </div>
                        <div class="sg-goal-item">
                            <div class="sg-goal-icon"><i data-lucide="flag"></i></div>
                            <div>
                                <h4 style="font-weight:700;">전도 전략</h4>
                                <p style="color:#64748b;">'관계 중심 생활 전도'와 '적극적인 소그룹 활동'으로 행복한 교회를 만듭니다.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. 소그룹 편성 -->
            <div class="sg-section">
                <h2 class="sg-section-title">2026 친교 소그룹 편성</h2>
                <div class="sg-group-grid">
                    <div class="sg-card">
                        <h3>믿음반</h3>
                        <div class="sg-leader-row">그룹장: 정봉길</div>
                        <p class="sg-slogan">"믿음으로 하나 되어 주님의 사랑을 나눕니다"</p>
                        <p class="sg-verse">"믿음은 바라는 것들의 실상이요 보이지 않는 것들의 증거니" (히브리서 11:1)</p>
                    </div>

                    <div class="sg-card">
                        <h3>소망반</h3>
                        <div class="sg-leader-row">그룹장: 김재신</div>
                        <p class="sg-slogan">"소망 중에 즐거워하며 함께 기도합니다"</p>
                        <p class="sg-verse">"소망의 하나님이 모든 기쁨과 평강을 믿음 안에서 너희에게 충만케 하사" (로마서 15:13)</p>
                    </div>

                    <div class="sg-card">
                        <h3>사랑반</h3>
                        <div class="sg-leader-row">그룹장: 담임목사</div>
                        <p class="sg-slogan">"그리스도의 사랑으로 서로를 섬깁니다"</p>
                        <p class="sg-verse">"사랑은 오래 참고 사랑은 온유하며... 모든 것을 믿으며 모든 것을 바라며" (고린도전서 13:4-7)</p>
                    </div>

                    <div class="sg-card">
                        <h3>행복반</h3>
                        <div class="sg-leader-row">그룹장: 심재영</div>
                        <p class="sg-slogan">"주 안에서 항상 기뻐하는 공동체"</p>
                        <p class="sg-verse">"주 안에서 항상 기뻐하라 내가 다시 말하노니 기뻐하라" (빌립보서 4:4)</p>
                    </div>
                </div>
            </div>

            <!-- 3. 주요 활동 -->
            <div class="sg-section">
                <h2 class="sg-section-title">주요 활동 계획</h2>

                <div style="background:#fff; padding:20px; border-radius:12px; border:1px solid #e2e8f0;">
                    <h3 style="font-size:1.1rem; font-weight:700; color:#db2777; margin-bottom:10px;">전도회 연계 5단계 사이클</h3>
                    <div class="cycle-container">
                        <div class="cycle-step">
                            <span class="cycle-num">1</span>
                            <span class="cycle-title">헌신</span>
                            <span class="cycle-desc">임원 교육<br>동기 부여</span>
                        </div>
                        <div class="cycle-step">
                            <span class="cycle-num">2</span>
                            <span class="cycle-title">접촉</span>
                            <span class="cycle-desc">이웃 사랑<br>야외 예배</span>
                        </div>
                        <div class="cycle-step">
                            <span class="cycle-num">3</span>
                            <span class="cycle-title">연결</span>
                            <span class="cycle-desc">기도 모임<br>양육 프로그램</span>
                        </div>
                        <div class="cycle-step">
                            <span class="cycle-num">4</span>
                            <span class="cycle-title">전도회</span>
                            <span class="cycle-desc">이웃 초청<br>말씀 전도</span>
                        </div>
                        <div class="cycle-step">
                            <span class="cycle-num">5</span>
                            <span class="cycle-title">정착</span>
                            <span class="cycle-desc">1:1 후견인<br>멘토링 양육</span>
                        </div>
                    </div>
                </div>

                <div style="margin-top:20px;">
                    <ul style="list-style:disc; padding-left:20px; color:#475569; line-height:1.6;">
                        <li><strong>안식일 오후:</strong> 말씀을 나누고 삶을 공유하는 '소통 데이' 등으로 탄력적 운영</li>
                        <li><strong>멘토링:</strong> 2인 1조, 3인 1조로 영적 관계 맺기 (말씀의 향기, 찬양의 꽃 캠페인)</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
