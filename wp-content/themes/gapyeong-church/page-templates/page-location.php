<?php
/**
 * Template Name: 오시는 길 페이지
 *
 * 가평교회 테마 - 오시는 길 서브페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title', $ctx['title']);
    set_query_var('subpage_slogan', $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group', $ctx['group']);
    set_query_var('submenu_active', $ctx['active_href']);
} else {
    set_query_var('subpage_title', '오시는 길');
    set_query_var('subpage_slogan', '가평교회에서 여러분을 기다립니다');
    set_query_var('breadcrumb_items', array(
        array('label' => '교회소개', 'href' => '/intro/greeting'),
        array('label' => '오시는 길', 'href' => ''),
    ));
    set_query_var('submenu_group', 'intro');
    set_query_var('submenu_active', '/intro/location');
}

get_header();
?>

<style>
    .location-section {
        margin-bottom: 4rem;
    }

    .map-container {
        overflow: hidden;
        border-radius: 1.5rem;
        margin-bottom: 3rem;
    }

    .map-container iframe {
        width: 100%;
        height: 400px;
        border: 0;
    }

    .location-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 4rem;
    }

    .location-card {
        background: white;
        padding: 2rem;
        border-radius: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s;
        position: relative;
    }

    .location-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .location-icon {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border-radius: 1rem;
        margin-bottom: 1.5rem;
    }

    .location-icon svg {
        stroke: white !important;
    }

    .location-card h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1rem;
    }

    .location-card p {
        font-size: 1rem;
        color: #666;
        line-height: 1.7;
        margin-bottom: 0.5rem;
    }

    .location-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
        color: #3b82f6;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.3s;
    }

    .location-link:hover {
        gap: 0.75rem;
    }

    .location-link i {
        width: 16px;
        height: 16px;
    }

    .transport-section {
        margin-bottom: 4rem;
    }

    .section-heading {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 2rem;
        text-align: center;
    }

    .transport-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .transport-card {
        background: white;
        padding: 2rem;
        border-radius: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .transport-icon {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #10b981, #06b6d4);
        border-radius: 1rem;
        margin-bottom: 1.5rem;
    }

    .transport-icon i {
        width: 28px;
        height: 28px;
        color: white;
    }

    .transport-card h4 {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1rem;
    }

    .transport-card ul {
        list-style: none;
        padding: 0;
    }

    .transport-card li {
        padding: 0.5rem 0;
        padding-left: 1.5rem;
        color: #666;
        position: relative;
    }

    .transport-card li::before {
        content: "•";
        position: absolute;
        left: 0;
        color: #3b82f6;
        font-weight: bold;
    }

    .location-cta {
        text-align: center;
        padding: 3rem;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.08), rgba(139, 92, 246, 0.05));
        border-radius: 1.5rem;
    }

    .location-cta p {
        font-size: 1.125rem;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {

        .location-info-grid,
        .transport-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="global-orbs">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="orb orb-4"></div>
    <div class="orb orb-5"></div>
</div>
<div class="scroll-indicator">
    <span class="scroll-text">scroll</span>
    <div class="scroll-track">
        <div class="scroll-progress"></div>
        <div class="scroll-dot"></div>
    </div>
</div>

<?php get_template_part('template-parts/subpage-hero'); ?>
<?php get_template_part('template-parts/submenu-nav'); ?>

<section class="subpage-content">
    <div class="container">
        <div class="content-box">
            <!-- Map Section -->
            <div class="location-section">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps?q=경기도+가평군+가평읍+석봉로+153번길+2&output=embed" width="100%"
                        height="400" style="border:0; border-radius: 1.5rem;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="location-info-grid">
                <div class="location-card">
                    <div class="location-icon"><i data-lucide="map-pin"></i></div>
                    <h3>주소</h3>
                    <p>경기도 가평군 가평읍<br>석봉로 153번길 2</p>
                    <a href="https://maps.google.com/?q=경기도+가평군+석봉로+153번길+2" target="_blank" class="location-link">
                        <i data-lucide="external-link"></i> 지도에서 보기
                    </a>
                </div>
                <div class="location-card">
                    <div class="location-icon"><i data-lucide="phone"></i></div>
                    <h3>연락처</h3>
                    <p>전화: 031-581-2765</p>
                    <p>담임목사: 010-XXXX-XXXX</p>
                </div>
                <div class="location-card">
                    <div class="location-icon"><i data-lucide="clock"></i></div>
                    <h3>예배 시간</h3>
                    <p>안식일(토) 예배: 오전 11시</p>
                    <p>안식일학교: 오전 9시 30분</p>
                    <p>금요 저녁예배: 저녁 7시 30분</p>
                </div>
            </div>

            <!-- Transportation -->
            <div class="transport-section">
                <h3 class="section-heading">교통편 안내</h3>
                <div class="transport-grid">
                    <div class="transport-card">
                        <div class="transport-icon"><i data-lucide="car"></i></div>
                        <h4>자가용 이용 시</h4>
                        <ul>
                            <li>경춘고속도로 가평IC → 우회전 → 석봉로 방면 약 5분</li>
                            <li>주차장 이용 가능 (약 20대)</li>
                        </ul>
                    </div>
                    <div class="transport-card">
                        <div class="transport-icon"><i data-lucide="bus"></i></div>
                        <h4>대중교통 이용 시</h4>
                        <ul>
                            <li>ITX-청춘: 상봉역 → 가평역 (약 50분)</li>
                            <li>가평역에서 버스 또는 택시 이용 (약 10분)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="location-cta">
                <p>방문 전 문의사항이 있으시면 연락 주세요!</p>
                <a href="/community/qna" class="btn btn-primary">
                    <i data-lucide="mail"></i> 문의하기
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>