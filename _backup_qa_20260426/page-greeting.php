<?php
/**
 * Template Name: 인사말 페이지
 *
 * 가평교회 테마 - 인사말 서브페이지 템플릿
 * 기존 intro/greeting.html 의 <body> 콘텐츠를 WordPress PHP로 변환
 *
 * WordPress 관리자 > 페이지 > 인사말 페이지 생성 후 
 * "페이지 속성 > 템플릿 > 인사말 페이지" 선택 필요
 */

// ── 서브페이지 컨텍스트 자동 감지 (fallback 포함) ──
$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    // Fallback: 부모 페이지가 설정되지 않은 경우
    set_query_var('subpage_title', '인사말');
    set_query_var('subpage_slogan', '하나님의 사랑 안에서 함께하는 가평교회');
    set_query_var('breadcrumb_items', array(
        array('label' => '교회소개', 'href' => '/intro/greeting'),
        array('label' => '인사말', 'href' => ''),
    ));
    set_query_var('submenu_group', 'intro');
    set_query_var('submenu_active', '/intro/greeting');
}

get_header();

$theme_uri = get_template_directory_uri();
?>


<!-- Global Parallax Background Orbs -->
<div class="global-orbs">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="orb orb-4"></div>
    <div class="orb orb-5"></div>
</div>

<!-- Scroll Progress Indicator -->
<div class="scroll-indicator">
    <span class="scroll-text">scroll</span>
    <div class="scroll-track">
        <div class="scroll-progress"></div>
        <div class="scroll-dot"></div>
    </div>
</div>

<?php
// Subpage Hero (빵조각 포함)
get_template_part('template-parts/subpage-hero');

// Submenu Navigation
get_template_part('template-parts/submenu-nav');
?>

<!-- Content Section -->
<section class="subpage-content">
    <div class="container">
        <div class="content-box">
            <!-- CEO/Pastor Message Section -->
            <div class="ceo-message-wrapper">
                <!-- Two Column Layout: Text Left, Image Right -->
                <div class="ceo-content-grid">
                    <!-- Left: Text Content -->
                    <div class="ceo-text-content">
                        <!-- Main Title -->
                        <h2 class="ceo-main-title">안녕하십니까?</h2>
                        <h2 class="ceo-subtitle">가평교회 담임목사 위수민입니다.</h2>
                        <p class="ceo-intro">저희 교회 홈페이지를 방문해 주신 여러분을 진심으로 환영합니다.</p>

                        <p class="ceo-paragraph">
                            가평교회는 하나님의 말씀을 중심으로 세워진 교회로서, 예수 그리스도의 사랑을 실천하며 이웃과 함께 성장하는
                            공동체입니다. 우리는 안식일을 거룩히 지키며, 재림의 소망 가운데 하나님 나라를 준비하는 성도들의 모임입니다.
                        </p>

                        <p class="ceo-paragraph">
                            최근 급변하는 세상 속에서도 변함없는 진리의 말씀으로 성도들을 양육하고 있습니다.
                            예배와 말씀, 그리고 성도 간의 교제를 통해 영적으로 성장하며, 지역사회를 섬기는 교회가 되기 위해 노력하고 있습니다.
                        </p>

                        <p class="ceo-paragraph">
                            자연이 아름다운 가평 땅에서 하나님의 창조 세계를 바라보며 예배드릴 수 있음에 늘 감사드립니다.
                            이곳에서 하나님의 임재를 경험하고, 서로를 사랑하며 섬기는 아름다운 믿음의 공동체가 되기를 소망합니다.
                        </p>

                        <p class="ceo-paragraph">
                            가평교회의 문은 언제나 열려 있습니다. 지치고 힘든 삶 속에서 쉼을 찾으시는 분, 진정한 인생의 의미를 찾으시는 분,
                            함께 신앙의 여정을 걸어가고 싶은 분 모두를 환영합니다.
                        </p>

                        <p class="ceo-paragraph">
                            "수고하고 무거운 짐 진 자들아 다 내게로 오라 내가 너희를 쉬게 하리라"는 주님의 말씀처럼,
                            가평교회는 모든 이들에게 쉼과 회복의 장소가 되기를 소망하며, 하나님의 사랑을 전하는 데 최선을 다하겠습니다.
                        </p>

                        <p class="ceo-closing">감사합니다.</p>

                        <!-- Signature -->
                        <div class="ceo-signature">
                            <p class="signature-position">가평교회 담임목사</p>
                            <p class="signature-name">위수민</p>
                        </div>
                    </div>

                    <!-- Right: Pastor/CEO Photo Card -->
                    <div class="ceo-photo-wrapper">
                        <div class="ceo-photo-card">
                            <img src="<?php echo esc_url($theme_uri); ?>/assets/images/pastor.jpg" alt="담임목사님"
                                class="ceo-photo">
                            <div class="ceo-photo-label">
                                <span class="label-org">가평교회 담임목사</span>
                                <span class="label-name">위수민</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>