<?php
/**
 * Template Name: 조직도 페이지
 *
 * 가평교회 테마 - 조직도 서브페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '조직도');
    set_query_var('subpage_slogan', '말씀을 사랑으로 실천하는 성령의 교회');
    set_query_var('breadcrumb_items', array(
        array('label' => '교회소개', 'href' => '/intro/greeting'),
        array('label' => '조직도', 'href' => ''),
    ));
    set_query_var('submenu_group', 'intro');
    set_query_var('submenu_active', '/intro/organization');
}

get_header();
?>

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

            <!-- 1. Leadership Section -->
            <div class="org-leadership-section">
                <h2 class="org-section-title">교회 리더십</h2>

                <div class="org-pastor-card">
                    <div class="org-pastor-icon"><i data-lucide="user"></i></div>
                    <h3 class="org-pastor-name">위수민 목사</h3>
                    <p class="org-pastor-role">담임목사</p>
                </div>

                <div class="org-connector"></div>

                <div class="org-elders-grid">
                    <div class="org-elder-card">
                        <div class="org-elder-icon"><i data-lucide="user"></i></div>
                        <h4 class="org-elder-name">김재신 장로</h4>
                        <p class="org-elder-role">수석장로</p>
                    </div>
                    <div class="org-elder-card">
                        <div class="org-elder-icon"><i data-lucide="user"></i></div>
                        <h4 class="org-elder-name">정봉길 장로</h4>
                        <p class="org-elder-role">장로</p>
                    </div>
                    <div class="org-elder-card">
                        <div class="org-elder-icon"><i data-lucide="user"></i></div>
                        <h4 class="org-elder-name">심재영 장로</h4>
                        <p class="org-elder-role">신임장로</p>
                    </div>
                    <div class="org-elder-card">
                        <div class="org-elder-icon"><i data-lucide="user"></i></div>
                        <h4 class="org-elder-name">신영빈 장로</h4>
                        <p class="org-elder-role">신임장로</p>
                    </div>
                </div>
            </div>

            <!-- 2. Administration Section -->
            <div class="org-admin-section">
                <h2 class="org-section-title">행정 및 재무</h2>
                <div class="org-admin-grid">
                    <div class="org-admin-card">
                        <div class="org-admin-header"><i data-lucide="file-text"></i><h3>교회서기</h3></div>
                        <div class="org-admin-members">
                            <div class="org-admin-member"><span class="admin-name">심재영</span><span class="admin-role">서기</span></div>
                            <div class="org-admin-member"><span class="admin-name">김원창</span><span class="admin-role">부서기</span></div>
                        </div>
                    </div>
                    <div class="org-admin-card">
                        <div class="org-admin-header"><i data-lucide="coins"></i><h3>교회재무</h3></div>
                        <div class="org-admin-members">
                            <div class="org-admin-member"><span class="admin-name">김한나</span><span class="admin-role">재무</span></div>
                            <div class="org-admin-member"><span class="admin-name">김선경</span><span class="admin-role">부재무</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Ministry Departments Section -->
            <div class="org-ministry-section">
                <h2 class="org-section-title">사역 부서</h2>
                <div class="org-ministry-grid">

                    <div class="org-ministry-card">
                        <div class="org-ministry-icon"><i data-lucide="globe"></i></div>
                        <h3 class="org-ministry-name">선교회</h3>
                        <p class="org-ministry-motto">"말씀으로 양육 받아 한마음 한뜻으로 복음을 전하자"</p>
                        <div class="org-ministry-leader"><span class="leader-role">회장</span><span class="leader-name">김지혜</span></div>
                    </div>

                    <div class="org-ministry-card">
                        <div class="org-ministry-icon"><i data-lucide="book-open"></i></div>
                        <h3 class="org-ministry-name">안식일학교</h3>
                        <p class="org-ministry-motto">"배우고 나누고 성장하는 안식일학교"</p>
                        <div class="org-ministry-leader"><span class="leader-role">교장</span><span class="leader-name">최원태</span></div>
                    </div>

                    <div class="org-ministry-card">
                        <div class="org-ministry-icon"><i data-lucide="heart-handshake"></i></div>
                        <h3 class="org-ministry-name">도르가회(봉사회)</h3>
                        <p class="org-ministry-motto">"착한 행실과 구제로 가득한 공동체"</p>
                        <div class="org-ministry-leader"><span class="leader-role">회장</span><span class="leader-name">장은영</span></div>
                    </div>

                    <div class="org-ministry-card">
                        <div class="org-ministry-icon"><i data-lucide="baby"></i></div>
                        <h3 class="org-ministry-name">어린이부</h3>
                        <p class="org-ministry-motto">"예수의 참된 제자된 부모와 교사여 소중한 우리 아이들을 예수의 제자로 양육하자"</p>
                        <div class="org-ministry-leader"><span class="leader-role">부장</span><span class="leader-name">김이슬</span></div>
                    </div>

                    <div class="org-ministry-card">
                        <div class="org-ministry-icon"><i data-lucide="users"></i></div>
                        <h3 class="org-ministry-name">청년·학생선교회</h3>
                        <p class="org-ministry-motto">"하나님이 이같이 우리를 사랑하셨은즉 우리도 서로 사랑하자"</p>
                        <div class="org-ministry-leaders">
                            <div class="org-ministry-leader"><span class="leader-role">회장</span><span class="leader-name">윤준석</span></div>
                            <div class="org-ministry-leader"><span class="leader-role">지도</span><span class="leader-name">신영빈</span></div>
                        </div>
                    </div>

                    <div class="org-ministry-card">
                        <div class="org-ministry-icon"><i data-lucide="compass"></i></div>
                        <h3 class="org-ministry-name">패스파인더</h3>
                        <p class="org-ministry-motto">"재림기별을 이 시대 안으로 온 세상에 전파하자"</p>
                        <div class="org-ministry-leader"><span class="leader-role">대장</span><span class="leader-name">신영빈</span></div>
                    </div>

                    <div class="org-ministry-card">
                        <div class="org-ministry-icon"><i data-lucide="music"></i></div>
                        <h3 class="org-ministry-name">찬양대</h3>
                        <p class="org-ministry-motto">"음악과 찬양으로 하나님께 영광을! 감사와 기쁨으로 충만한 예배를!!"</p>
                        <div class="org-ministry-leader"><span class="leader-role">대장</span><span class="leader-name">김지혜</span></div>
                    </div>

                    <div class="org-ministry-card">
                        <div class="org-ministry-icon"><i data-lucide="monitor-smartphone"></i></div>
                        <h3 class="org-ministry-name">디지털홍보부</h3>
                        <p class="org-ministry-motto">"미디어로 신앙의 성장과 선교의 장을 연결하자"</p>
                        <div class="org-ministry-leader"><span class="leader-role">부장</span><span class="leader-name">허주현</span></div>
                    </div>

                    <div class="org-ministry-card">
                        <div class="org-ministry-icon"><i data-lucide="heart-pulse"></i></div>
                        <h3 class="org-ministry-name">보건복지부</h3>
                        <p class="org-ministry-motto">"그런즉 너희 몸으로 하나님께 영광을 돌리라"</p>
                        <div class="org-ministry-leader"><span class="leader-role">부장</span><span class="leader-name">최경숙</span></div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
