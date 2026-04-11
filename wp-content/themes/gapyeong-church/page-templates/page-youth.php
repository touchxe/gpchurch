<?php
/**
 * Template Name: 청년학생 페이지
 *
 * 가평교회 테마 - 청년학생 선교회 서브페이지 템플릿
 * 기존 program/youth.html 의 <body> 콘텐츠를 WordPress PHP로 변환
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
    set_query_var('subpage_title', '청년학생');
    set_query_var('subpage_slogan', '하나님의 사랑으로 세상을 섬기는 청년');
    set_query_var('breadcrumb_items', array(
        array('label' => '프로그램', 'href' => '/program'),
        array('label' => '청년학생', 'href' => ''),
    ));
    set_query_var('submenu_group', 'program');
    set_query_var('submenu_active', '/program/youth');
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

            <!-- 1. 개요 및 임원 -->
            <div class="youth-section">
                <div class="youth-intro-box">
                    <h2 class="youth-motto">"하나님이 이같이 우리를 사랑하셨은즉<br>우리도 서로 사랑하자"</h2>
                    <p class="youth-verse">(요한일서 4장 10~11절)</p>

                    <div class="youth-officer-grid">
                        <div class="youth-officer-item">
                            <span class="yo-role">담당 교사</span>
                            <span class="yo-name">신영빈</span>
                        </div>
                        <div class="youth-officer-item">
                            <span class="yo-role">청년회장</span>
                            <span class="yo-name">윤준석</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. 안식일학교 반 편성 -->
            <div class="youth-section">
                <h2 class="youth-section-title">안식일학교 청년반</h2>
                <div class="youth-class-box">
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
                        <i data-lucide="map-pin" style="color:#ef4444"></i>
                        <span style="font-weight:700; font-size:1.1rem; color:#334155;">3층 청년관</span>
                        <span style="color:#64748b; margin-left:10px;">교사: 이진희</span>
                    </div>
                    <div style="border-top:1px dashed #e2e8f0; padding-top:15px;">
                        <span style="display:block; font-size:0.9rem; color:#64748b; margin-bottom:10px;">반원 명단</span>
                        <div class="youth-member-list">
                            <span class="youth-member-badge">김어진</span>
                            <span class="youth-member-badge">김유진</span>
                            <span class="youth-member-badge">문요섭</span>
                            <span class="youth-member-badge">박상은</span>
                            <span class="youth-member-badge">윤준석</span>
                            <span class="youth-member-badge">윤민석</span>
                            <span class="youth-member-badge">윤현석</span>
                            <span class="youth-member-badge">위현찬</span>
                            <span class="youth-member-badge">조영은</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. 주요 사업 목표 -->
            <div class="youth-section">
                <h2 class="youth-section-title">주요 사업 및 활동</h2>
                <div class="youth-project-grid">
                    <div class="youth-card">
                        <div class="youth-card-icon"><i data-lucide="book-heart"></i></div>
                        <h4 class="yc-title">말씀과 영성</h4>
                        <ul class="yc-list">
                            <li>매주 정기 성경 공부 및 토론</li>
                            <li>매일 기도 모임 (중보기도)</li>
                            <li>신앙 회복과 영적 성장 추구</li>
                        </ul>
                    </div>

                    <div class="youth-card">
                        <div class="youth-card-icon"><i data-lucide="hand-helping"></i></div>
                        <h4 class="yc-title">봉사 활동</h4>
                        <ul class="yc-list">
                            <li>교회 봉사 (반주, 방송 등)</li>
                            <li>국내: 지역아동센터, 독거노인 지원</li>
                            <li>해외: 필리핀 단기선교 예정</li>
                        </ul>
                    </div>

                    <div class="youth-card special">
                        <div class="youth-card-icon"><i data-lucide="laptop"></i></div>
                        <h4 class="yc-title">홈페이지 구축 프로젝트</h4>
                        <p style="font-size:0.9rem; color:#134e4a; margin-bottom:10px; font-weight:600;">(특화 사업: 재능 기부)</p>
                        <ul class="yc-list" style="color:#115e59;">
                            <li>청년반 주도 기획·디자인·개발</li>
                            <li>AI 활용 및 노코드(No-code) 교육</li>
                            <li>미자립 교회 웹사이트 무상 지원</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 4. 실천 사항 -->
            <div class="youth-section">
                <h2 class="youth-section-title">실천 사항</h2>
                <div class="youth-action-grid">
                    <div class="action-item">
                        <div class="action-title">💙 바자회</div>
                        <p class="action-desc">봉사 재정 마련을 위한 바자회 운영</p>
                    </div>
                    <div class="action-item">
                        <div class="action-title">🤝 연합 활동</div>
                        <p class="action-desc">학생반과 협력하여 스포츠 및 수련회 기획</p>
                    </div>
                    <div class="action-item">
                        <div class="action-title">🎁 관심과 사랑</div>
                        <p class="action-desc">생일 축하, 고민 경청 및 정서적 지지</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
