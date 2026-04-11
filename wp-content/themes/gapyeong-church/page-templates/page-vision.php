<?php
/**
 * Template Name: 비전 페이지
 *
 * 가평교회 테마 - 비전 서브페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '비전');
    set_query_var('subpage_slogan', '하나님 나라를 향한 우리의 꿈');
    set_query_var('breadcrumb_items', array(
        array('label' => '교회소개', 'href' => '/intro/greeting'),
        array('label' => '비전', 'href' => ''),
    ));
    set_query_var('submenu_group', 'intro');
    set_query_var('submenu_active', '/intro/vision');
}

get_header();
?>

<!-- Global Parallax Background Orbs -->
<div class="global-orbs">
    <div class="orb orb-1"></div><div class="orb orb-2"></div><div class="orb orb-3"></div><div class="orb orb-4"></div><div class="orb orb-5"></div>
</div>
<div class="scroll-indicator">
    <span class="scroll-text">scroll</span>
    <div class="scroll-track"><div class="scroll-progress"></div><div class="scroll-dot"></div></div>
</div>

<?php get_template_part('template-parts/subpage-hero'); ?>
<?php get_template_part('template-parts/submenu-nav'); ?>

<section class="subpage-content">
    <div class="container">
        <div class="content-box">

            <div class="vision-motto-section">
                <span class="motto-year">2026 VISION</span>
                <h2 class="motto-title">"말씀을 사랑으로 실천하는<br>성령의 교회"</h2>
                <p class="motto-subtitle">"Love God, Love People, Save the World"<br>하나님을 사랑하고, 이웃을 사랑하고, 세상을 구하는 성도</p>
                <div class="motto-english">Be Disciples! Make Disciples!</div>
            </div>

            <div class="vision-section-header">
                <h3 class="vision-section-title">4대 공동체 비전</h3>
                <p class="community-desc" style="margin-top: 10px;">가평교회는 다음의 네 가지 공동체를 지향합니다.</p>
            </div>

            <div class="communities-grid">
                <div class="community-card">
                    <div class="community-icon"><i data-lucide="book-open"></i></div>
                    <h4 class="community-title">말씀으로 세우는 공동체</h4>
                    <p class="community-desc">말씀(통독/성경연구)을 생활화하고<br>확신의 삶을 위해 노력합니다.</p>
                </div>
                <div class="community-card">
                    <div class="community-icon"><i data-lucide="heart-handshake"></i></div>
                    <h4 class="community-title">교제공동체</h4>
                    <p class="community-desc">가정과 사회를 변화시키며<br>마음과 마음을 이어주는 소그룹 회복에 집중합니다.</p>
                </div>
                <div class="community-card">
                    <div class="community-icon"><i data-lucide="globe"></i></div>
                    <h4 class="community-title">선교공동체</h4>
                    <p class="community-desc">주님의 선교 명령에 순종하며<br>유익한 훈련들로 생활화에 집중합니다.</p>
                </div>
                <div class="community-card">
                    <div class="community-icon"><i data-lucide="graduation-cap"></i></div>
                    <h4 class="community-title">비전공동체</h4>
                    <p class="community-desc">미래의 지도자가 될<br>젊은이와 어린이 선교에 적극 집중합니다.</p>
                </div>
            </div>

            <div class="vision-section-header">
                <h3 class="vision-section-title">5대 중점 목표</h3>
            </div>

            <div class="goals-grid">
                <div class="goal-card"><div class="goal-header"><span class="goal-num">01</span><h4 class="goal-title">예배</h4></div><div class="goal-body"><p class="goal-desc">찬양과 예배로 하나님 앞에 서도록 인도합니다.</p></div></div>
                <div class="goal-card"><div class="goal-header"><span class="goal-num">02</span><h4 class="goal-title">소그룹</h4></div><div class="goal-body"><p class="goal-desc">소그룹 모임에 참여하여 삶과 신앙을 나눕니다.</p></div></div>
                <div class="goal-card"><div class="goal-header"><span class="goal-num">03</span><h4 class="goal-title">봉사</h4></div><div class="goal-body"><p class="goal-desc">성령의 은사를 발견하고 개발하여 봉사하는 기회를 제공합니다.</p></div></div>
                <div class="goal-card"><div class="goal-header"><span class="goal-num">04</span><h4 class="goal-title">전도</h4></div><div class="goal-body"><p class="goal-desc">지역사회에 선한 영향력을 끼쳐 새로운 영혼을 인도합니다.</p></div></div>
                <div class="goal-card"><div class="goal-header"><span class="goal-num">05</span><h4 class="goal-title">양육</h4></div><div class="goal-body"><p class="goal-desc">다음 세대를 양육하고 다양한 방법으로 복음 일꾼 양성을 지원합니다.</p></div></div>
            </div>

        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    gsap.registerPlugin(ScrollTrigger);
    gsap.from(".vision-motto-section", { scrollTrigger: { trigger: ".vision-motto-section", start: "top 80%" }, y: 30, opacity: 0, duration: 1 });
    gsap.utils.toArray('.community-card').forEach((card, i) => { gsap.from(card, { scrollTrigger: { trigger: card, start: "top 90%" }, y: 40, opacity: 0, duration: 0.8, delay: i * 0.1 }); });
    gsap.utils.toArray('.goal-card').forEach((card, i) => { gsap.from(card, { scrollTrigger: { trigger: card, start: "top 95%" }, y: 20, opacity: 0, duration: 0.6, ease: "power2.out", delay: i * 0.1 }); });
});
</script>

<?php get_footer(); ?>
