<?php
/**
 * Template Name: 부서
 *
 * 가평교회 테마 - 전체 부서 통합 페이지 템플릿
 */

$ctx = gapyeong_get_page_context();
if ($ctx) {
    set_query_var('subpage_title',    $ctx['title']);
    set_query_var('subpage_slogan',   $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group',    $ctx['group']);
    set_query_var('submenu_active',   $ctx['active_href']);
} else {
    set_query_var('subpage_title', '부서');
    set_query_var('subpage_slogan', '각 부서가 유기적으로 연합하여 교회를 섬기고 제자 삼는 사명을 감당합니다.');
    set_query_var('breadcrumb_items', array(
        array('label' => '부서', 'href' => '/dept'),
    ));
    set_query_var('submenu_group', 'dept');
    set_query_var('submenu_active', '/dept');
}

get_header();
?>

<div class="global-orbs">
    <div class="orb orb-1"></div><div class="orb orb-2"></div>
    <div class="orb orb-3"></div><div class="orb orb-4"></div>
    <div class="orb orb-5"></div>
</div>

<?php
get_template_part('template-parts/subpage-hero');
// submenu-nav 미사용: 통합 부서 페이지는 아래 dept-index-nav로 대체
?>


<style>
/* 부서 빠른 이동 네비게이션 */
.dept-index-nav {
    background: transparent;
    padding: 14px 0;
}
.dept-index-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: flex-start;
}
.dept-index-item {
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--color-primary, #6366f1);
    background: rgba(99,102,241,0.08);
    border: 1px solid rgba(99,102,241,0.18);
    border-radius: 20px;
    padding: 5px 14px;
    text-decoration: none;
    transition: background 0.2s, color 0.2s, transform 0.15s;
    white-space: nowrap;
}
.dept-index-item:hover {
    background: var(--color-primary, #6366f1);
    color: #fff;
    transform: translateY(-1px);
}
/* 부서 섹션 구분 */
.dept-page-section + .dept-page-section {
    border-top: 1px solid rgba(99,102,241,0.1);
    padding-top: 48px;
}
/* 부서명 줄바꿈(도르가회 등) small 태그 */
.dept-profile-name small {
    font-size: 0.65em;
    opacity: 0.7;
    display: block;
    margin-top: 2px;
}
</style>

<!-- 부서 빠른 이동 네비게이션 -->
<div class="dept-index-nav">
    <div class="container">
        <div class="dept-index-list">
            <a href="#ministry" class="dept-index-item">목회부</a>
            <a href="#clerk" class="dept-index-item">교회서기</a>
            <a href="#treasury" class="dept-index-item">교회재무</a>
            <a href="#elders" class="dept-index-item">장로회</a>
            <a href="#deacons" class="dept-index-item">집사회</a>
            <a href="#mission" class="dept-index-item">선교회</a>
            <a href="#sabbath-school" class="dept-index-item">안식일학교</a>
            <a href="#community-service" class="dept-index-item">지역사회봉사회</a>
            <a href="#children" class="dept-index-item">어린이부</a>
            <a href="#youth-student" class="dept-index-item">청년·학생선교회</a>
            <a href="#pathfinder" class="dept-index-item">패스파인더</a>
            <a href="#choir" class="dept-index-item">찬양대</a>
            <a href="#health-welfare" class="dept-index-item">보건복지부</a>
            <a href="#digital-media" class="dept-index-item">디지털홍보부</a>
        </div>
    </div>
</div>


<!-- ===== 목회부 ===== -->
<div class="container dept-page-section" id="ministry">
    <div class="dept-profile-card" data-color>
        <div class="dept-profile-left">
            <div class="dept-profile-icon"><i data-lucide="book-open"></i></div>
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
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="target"></i><span>2026 부서 사명</span></div>
                <p class="dept-mission-text">"성령의 권능으로 증인이 되고 새 생명을 잉태하도록 이끄는 것"</p>
            </div>
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="list-checks"></i><span>주요 활동 계획</span></div>
                <ul class="dept-plan-list">
                    <li><span class="dept-plan-keyword">영적 분위기 조성</span> 말씀 365 묵상, 기도생활 강조, &lt;시대의 소망&gt; 필독</li>
                    <li><span class="dept-plan-keyword">행복 누리기</span> 친교 소그룹 활성화 및 외부 활동을 통한 단합 도모</li>
                    <li><span class="dept-plan-keyword">제자 훈련</span> 소그룹 리더 강화 및 목양장로 육성 프로그램 운영</li>
                    <li><span class="dept-plan-keyword">전도</span> 1인 1 구도자 확보 운동 및 TMI(전교인) 활동 주력</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ===== 교회서기 ===== -->
<div class="container dept-page-section" id="clerk">
    <div class="dept-profile-card" data-color>
        <div class="dept-profile-left">
            <div class="dept-profile-icon"><i data-lucide="file-text"></i></div>
            <h2 class="dept-profile-name">교회서기</h2>
            <p class="dept-profile-sub">2026년도 부서</p>
            <div class="dept-profile-divider"></div>
            <div class="dept-profile-members">
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">서기</span>
                    <span class="dept-profile-member-name">심재영</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">부서기</span>
                    <span class="dept-profile-member-name">김원창</span>
                </div>
            </div>
            <div class="dept-profile-tags">
                <span class="dept-tag">교적 관리</span>
                <span class="dept-tag">문서 보관</span>
                <span class="dept-tag">자산 관리</span>
            </div>
        </div>
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="target"></i><span>2026 부서 사명</span></div>
                <p class="dept-mission-text">"교회의 모든 행정 기록과 교적을 체계적으로 관리합니다."</p>
            </div>
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="list-checks"></i><span>주요 활동 계획</span></div>
                <ul class="dept-plan-list">
                    <li><span class="dept-plan-keyword">문서 보관</span> 직원회 회의록, 교회 일지 등 중요 행정 문서의 체계적 보관</li>
                    <li><span class="dept-plan-keyword">교적 관리</span> 전입/전출, 침례, 사망 보고 및 교적부 최신화</li>
                    <li><span class="dept-plan-keyword">자산 점검</span> 교회 재산 및 비품에 대한 연 1회 정기 점검 실시</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ===== 교회재무 ===== -->
<div class="container dept-page-section" id="treasury">
    <div class="dept-profile-card" data-color>
        <div class="dept-profile-left">
            <div class="dept-profile-icon"><i data-lucide="coins"></i></div>
            <h2 class="dept-profile-name">교회재무</h2>
            <p class="dept-profile-sub">2026년도 부서</p>
            <div class="dept-profile-divider"></div>
            <div class="dept-profile-members">
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">재무</span>
                    <span class="dept-profile-member-name">김한나</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">부재무</span>
                    <span class="dept-profile-member-name">김선경</span>
                </div>
            </div>
            <div class="dept-profile-tags">
                <span class="dept-tag">십일조</span>
                <span class="dept-tag">재정 관리</span>
                <span class="dept-tag">투명성</span>
            </div>
        </div>
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="target"></i><span>2026 부서 사명</span></div>
                <p class="dept-mission-text">"정직과 투명함으로 하나님의 청지기 사명을 감당합니다."</p>
            </div>
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="list-checks"></i><span>주요 활동 계획</span></div>
                <ul class="dept-plan-list">
                    <li><span class="dept-plan-keyword">정직한 십일금</span> 성도들의 온전한 십일조 생활 정착</li>
                    <li><span class="dept-plan-keyword">헌금 장려</span> 월정 헌금 및 도르가 헌금의 적극적 참여 권장</li>
                    <li><span class="dept-plan-keyword">투명성</span> 정확하고 투명한 재정 관리 및 정기 보고</li>
                    <li><span class="dept-plan-keyword">지출 결의</span> 10만 원 이상 지출 시 직원회 결의 필요 (고정 지출 제외)</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ===== 장로회 ===== -->
<div class="container dept-page-section" id="elders">
    <div class="dept-profile-card" data-color>
        <div class="dept-profile-left">
            <div class="dept-profile-icon"><i data-lucide="users"></i></div>
            <h2 class="dept-profile-name">장로회</h2>
            <p class="dept-profile-sub">2026년도 부서</p>
            <div class="dept-profile-divider"></div>
            <div class="dept-profile-members">
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">수석장로</span>
                    <span class="dept-profile-member-name">김재신</span>
                </div>
            </div>
            <div class="dept-profile-tags">
                <span class="dept-tag">영적 지도</span>
                <span class="dept-tag">예배 인도</span>
                <span class="dept-tag">성도 돌봄</span>
            </div>
        </div>
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="target"></i><span>2026 부서 사명</span></div>
                <p class="dept-mission-text">"영적 모범이 되며 성만찬과 성도 돌봄을 수행합니다."</p>
            </div>
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="list-checks"></i><span>주요 활동 계획</span></div>
                <ul class="dept-plan-list">
                    <li><span class="dept-plan-keyword">영적 지도</span> 교회의 영적 분위기 주도 및 모범</li>
                    <li><span class="dept-plan-keyword">예배 인도</span> 설교 및 예배 순서 담당</li>
                    <li><span class="dept-plan-keyword">성도 돌봄</span> 교인 심방 및 영적 필요 충족</li>
                    <li><span class="dept-plan-keyword">성만찬 예식</span> 전반기: 김재신·심재영 / 후반기: 신영빈·김재신</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ===== 집사회 ===== -->
<div class="container dept-page-section" id="deacons">
    <div class="dept-profile-card" data-color>
        <div class="dept-profile-left">
            <div class="dept-profile-icon"><i data-lucide="hand-heart"></i></div>
            <h2 class="dept-profile-name">집사회</h2>
            <p class="dept-profile-sub">2026년도 부서</p>
            <div class="dept-profile-divider"></div>
            <div class="dept-profile-members">
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">남수석 집사</span>
                    <span class="dept-profile-member-name">박해욱</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">여수석 집사</span>
                    <span class="dept-profile-member-name">손옥분</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">집사회 서기</span>
                    <span class="dept-profile-member-name">허주현</span>
                </div>
            </div>
            <div class="dept-profile-tags">
                <span class="dept-tag">예배 지원</span>
                <span class="dept-tag">시설 관리</span>
                <span class="dept-tag">친교</span>
            </div>
        </div>
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="target"></i><span>2026 부서 사명</span></div>
                <p class="dept-mission-text">"교회 살림을 맡아 봉사하며 성도들의 단합을 도모합니다."</p>
            </div>
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="list-checks"></i><span>주요 활동 계획</span></div>
                <ul class="dept-plan-list">
                    <li><span class="dept-plan-keyword">예배 지원</span> 안내 위원 활동 및 교회 청결 관리</li>
                    <li><span class="dept-plan-keyword">시설 관리</span> 비품 및 교회 시설 유지 보수</li>
                    <li><span class="dept-plan-keyword">경조사</span> 성도 애경사 지원 및 애찬 봉사</li>
                    <li><span class="dept-plan-keyword">단합 대회</span> 전교인 소풍 및 체육대회 (연 2회 예정)</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<!-- ===== 선교회 ===== -->
<div class="container dept-page-section" id="mission">
    <div class="dept-profile-card" data-color>
        <div class="dept-profile-left">
            <div class="dept-profile-icon"><i data-lucide="globe"></i></div>
            <h2 class="dept-profile-name">선교회</h2>
            <p class="dept-profile-sub">2026년도 부서</p>
            <div class="dept-profile-divider"></div>
            <div class="dept-profile-members">
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">회장</span>
                    <span class="dept-profile-member-name">김지혜</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">남선교부장/서기</span>
                    <span class="dept-profile-member-name">심재영</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">여선교부장</span>
                    <span class="dept-profile-member-name">최경숙</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">문서선교부장</span>
                    <span class="dept-profile-member-name">이은화</span>
                </div>
            </div>
            <div class="dept-profile-tags">
                <span class="dept-tag">TMI</span>
                <span class="dept-tag">전도</span>
                <span class="dept-tag">문서 선교</span>
            </div>
        </div>
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="target"></i><span>2026 부서 사명</span></div>
                <p class="dept-mission-text">"TMI(전교인 참여) 운동을 통해 복음을 전합니다."</p>
            </div>
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="list-checks"></i><span>주요 활동 계획</span></div>
                <ul class="dept-plan-list">
                    <li><span class="dept-plan-keyword">TMI 활동</span> 전교인이 참여하는 생활 속 선교 (헌신→접촉→연결→초청→정착)</li>
                    <li><span class="dept-plan-keyword">전도 지원</span> 소그룹 전도회 및 구도자 초청 행사 지원</li>
                    <li><span class="dept-plan-keyword">문서 선교</span> 선교 서적 및 전도지 보급</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ===== 안식일학교 ===== -->
<div class="container dept-page-section" id="sabbath-school">
    <div class="dept-profile-card" data-color>
        <div class="dept-profile-left">
            <div class="dept-profile-icon"><i data-lucide="book-open-check"></i></div>
            <h2 class="dept-profile-name">안식일학교</h2>
            <p class="dept-profile-sub">2026년도 부서</p>
            <div class="dept-profile-divider"></div>
            <div class="dept-profile-members">
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">교장</span>
                    <span class="dept-profile-member-name">최원태</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">부교장</span>
                    <span class="dept-profile-member-name">김원창</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">부교장</span>
                    <span class="dept-profile-member-name">이진희 / 조광현</span>
                </div>
            </div>
            <div class="dept-profile-tags">
                <span class="dept-tag">성경 연구</span>
                <span class="dept-tag">교제</span>
                <span class="dept-tag">출석</span>
            </div>
        </div>
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="target"></i><span>2026 부서 사명</span></div>
                <p class="dept-mission-text">"말씀 연구와 교제를 통해 성도들의 영적 성장을 도모합니다."</p>
            </div>
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="list-checks"></i><span>주요 활동 계획</span></div>
                <ul class="dept-plan-list">
                    <li><span class="dept-plan-keyword">토의식 교과</span> 주입식이 아닌 성도들이 참여하는 토의식 교과 운영</li>
                    <li><span class="dept-plan-keyword">말씀 생활</span> 기억절 암송 및 퀴즈 대회 개최</li>
                    <li><span class="dept-plan-keyword">출석 캠페인</span> 정각 출석 장려 및 결석자 챙기기</li>
                    <li><span class="dept-plan-keyword">소그룹 강화</span> 반별 소그룹 활동 및 친교 활성화</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ===== 지역사회봉사회 ===== -->
<div class="container dept-page-section" id="community-service">
    <div class="dept-profile-card" data-color>
        <div class="dept-profile-left">
            <div class="dept-profile-icon"><i data-lucide="gift"></i></div>
            <h2 class="dept-profile-name">지역사회봉사회<br><small>(도르가회)</small></h2>
            <p class="dept-profile-sub">2026년도 부서</p>
            <div class="dept-profile-divider"></div>
            <div class="dept-profile-members">
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">회장</span>
                    <span class="dept-profile-member-name">장은영</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">부회장</span>
                    <span class="dept-profile-member-name">최경숙 / 이은화</span>
                </div>
            </div>
            <div class="dept-profile-tags">
                <span class="dept-tag">구제</span>
                <span class="dept-tag">봉사</span>
                <span class="dept-tag">나눔</span>
            </div>
        </div>
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="target"></i><span>2026 부서 사명</span></div>
                <p class="dept-mission-text">"예수님의 사랑으로 이웃을 섬기며 나눔을 실천합니다."</p>
            </div>
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="list-checks"></i><span>주요 활동 계획</span></div>
                <ul class="dept-plan-list">
                    <li><span class="dept-plan-keyword">도르가 바자회</span> 바자회 운영을 통한 수익금 기부</li>
                    <li><span class="dept-plan-keyword">지원 사업</span> 청년 격려금 및 지역 인재 장학금 지원</li>
                    <li><span class="dept-plan-keyword">구호 활동</span> 드림스타트(아동 지원), 반찬 봉사, 긴급 구호</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ===== 어린이부 ===== -->
<div class="container dept-page-section" id="children">
    <div class="dept-profile-card" data-color>
        <div class="dept-profile-left">
            <div class="dept-profile-icon"><i data-lucide="smile"></i></div>
            <h2 class="dept-profile-name">어린이부</h2>
            <p class="dept-profile-sub">2026년도 부서</p>
            <div class="dept-profile-divider"></div>
            <div class="dept-profile-members">
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">부장</span>
                    <span class="dept-profile-member-name">김이슬</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">부부장</span>
                    <span class="dept-profile-member-name">최소영</span>
                </div>
            </div>
            <div class="dept-profile-tags">
                <span class="dept-tag">신앙 교육</span>
                <span class="dept-tag">성경학교</span>
                <span class="dept-tag">전도</span>
            </div>
        </div>
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="target"></i><span>2026 부서 사명</span></div>
                <p class="dept-mission-text">"예수님의 성품을 닮은 어린이로 자라나도록 양육합니다."</p>
            </div>
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="list-checks"></i><span>주요 활동 계획</span></div>
                <ul class="dept-plan-list">
                    <li><span class="dept-plan-keyword">영성 훈련</span> 사무엘 캠프 참가, 설교 노트 쓰기 지도</li>
                    <li><span class="dept-plan-keyword">전도 활동</span> 방학 중 '만나데이', 친구 초청 안식일 행사</li>
                    <li><span class="dept-plan-keyword">특별 행사</span> 여름/겨울 성경학교, 어린이 펀데이(Fun Day), 뮤지컬 관람</li>
                    <li><span class="dept-plan-keyword">야외 활동</span> 천연계 탐사 및 소풍</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<!-- ===== 청년·학생선교회 ===== -->
<div class="container dept-page-section" id="youth-student">
    <div class="dept-profile-card" data-color>
        <div class="dept-profile-left">
            <div class="dept-profile-icon"><i data-lucide="graduation-cap"></i></div>
            <h2 class="dept-profile-name">청년·학생선교회</h2>
            <p class="dept-profile-sub">2026년도 부서</p>
            <div class="dept-profile-divider"></div>
            <div class="dept-profile-members">
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">지도교사</span>
                    <span class="dept-profile-member-name">신영빈</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">회장</span>
                    <span class="dept-profile-member-name">윤준석</span>
                </div>
            </div>
            <div class="dept-profile-tags">
                <span class="dept-tag">봉사</span>
                <span class="dept-tag">선교</span>
                <span class="dept-tag">신앙 훈련</span>
            </div>
        </div>
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="target"></i><span>2026 부서 사명</span></div>
                <p class="dept-mission-text">"젊음의 열정으로 복음을 전하고 교회를 섬깁니다."</p>
            </div>
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="list-checks"></i><span>주요 활동 계획</span></div>
                <ul class="dept-plan-list">
                    <li><span class="dept-plan-keyword">홈페이지 구축</span> 교회 맞춤형 홈페이지 구축 및 보급 프로젝트 진행</li>
                    <li><span class="dept-plan-keyword">봉사 동아리</span> 지역사회 봉사 및 재능 기부 활동</li>
                    <li><span class="dept-plan-keyword">해외 봉사</span> 필리핀 등 해외 선교지 봉사 활동 지원</li>
                    <li><span class="dept-plan-keyword">신앙 훈련</span> 정기 성경 공부 및 기도 모임 운영</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ===== 패스파인더 ===== -->
<div class="container dept-page-section" id="pathfinder">
    <div class="dept-profile-card" data-color>
        <div class="dept-profile-left">
            <div class="dept-profile-icon"><i data-lucide="compass"></i></div>
            <h2 class="dept-profile-name">패스파인더</h2>
            <p class="dept-profile-sub">2026년도 부서</p>
            <div class="dept-profile-divider"></div>
            <div class="dept-profile-members">
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">대장</span>
                    <span class="dept-profile-member-name">신영빈</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">부대장</span>
                    <span class="dept-profile-member-name">권용복</span>
                </div>
            </div>
            <div class="dept-profile-tags">
                <span class="dept-tag">지육</span>
                <span class="dept-tag">덕육</span>
                <span class="dept-tag">체육</span>
            </div>
        </div>
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="target"></i><span>2026 부서 사명</span></div>
                <p class="dept-mission-text">"지육, 덕육, 체육을 고루 갖춘 청소년 지도자를 양성합니다."</p>
            </div>
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="list-checks"></i><span>주요 활동 계획</span></div>
                <ul class="dept-plan-list">
                    <li><span class="dept-plan-keyword">대원 확보</span> 정회원 15명 확보 및 등록 목표</li>
                    <li><span class="dept-plan-keyword">지도자 양성</span> 마스터 가이드(MG) 및 BSTC 지도자 교육 이수</li>
                    <li><span class="dept-plan-keyword">가족 참여</span> 부모님과 함께하는 가족 캠프 운영</li>
                    <li><span class="dept-plan-keyword">기능 활동</span> 야영 기술, 매듭법 훈련, 천연계 탐사</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ===== 찬양대 ===== -->
<div class="container dept-page-section" id="choir">
    <div class="dept-profile-card" data-color>
        <div class="dept-profile-left">
            <div class="dept-profile-icon"><i data-lucide="music"></i></div>
            <h2 class="dept-profile-name">찬양대</h2>
            <p class="dept-profile-sub">2026년도 부서</p>
            <div class="dept-profile-divider"></div>
            <div class="dept-profile-members">
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">대장</span>
                    <span class="dept-profile-member-name">김지혜</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">부대장</span>
                    <span class="dept-profile-member-name">장은영 / 조광현</span>
                </div>
            </div>
            <div class="dept-profile-tags">
                <span class="dept-tag">찬양</span>
                <span class="dept-tag">오케스트라</span>
                <span class="dept-tag">예배</span>
            </div>
        </div>
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="target"></i><span>2026 부서 사명</span></div>
                <p class="dept-mission-text">"정성 어린 찬양으로 하나님께 영광을 돌립니다."</p>
            </div>
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="list-checks"></i><span>주요 활동 계획</span></div>
                <ul class="dept-plan-list">
                    <li><span class="dept-plan-keyword">반주자</span> 윤준석, 위현찬</li>
                    <li><span class="dept-plan-keyword">오케스트라</span> 바이올린, 플롯, 클라리넷 등 기악팀 운영</li>
                    <li><span class="dept-plan-keyword">주간 찬양</span> 매주 안식일 예배 특별 찬양</li>
                    <li><span class="dept-plan-keyword">연말 발표회</span> 연말 찬양 발표회 및 음악 캠프 개최</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ===== 보건복지부 ===== -->
<div class="container dept-page-section" id="health-welfare">
    <div class="dept-profile-card" data-color>
        <div class="dept-profile-left">
            <div class="dept-profile-icon"><i data-lucide="heart-pulse"></i></div>
            <h2 class="dept-profile-name">보건복지부</h2>
            <p class="dept-profile-sub">2026년도 부서</p>
            <div class="dept-profile-divider"></div>
            <div class="dept-profile-members">
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">부장</span>
                    <span class="dept-profile-member-name">최경숙</span>
                </div>
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">부부장</span>
                    <span class="dept-profile-member-name">최영숙</span>
                </div>
            </div>
            <div class="dept-profile-tags">
                <span class="dept-tag">건강</span>
                <span class="dept-tag">Newstart</span>
                <span class="dept-tag">절제</span>
            </div>
        </div>
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="target"></i><span>2026 부서 사명</span></div>
                <p class="dept-mission-text">"성도들과 이웃의 건강한 삶(Newstart)을 지원합니다."</p>
            </div>
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="list-checks"></i><span>주요 활동 계획</span></div>
                <ul class="dept-plan-list">
                    <li><span class="dept-plan-keyword">맨발 걷기 (어싱)</span> 매주 안식일 오후 3시 체력 증진 프로그램 운영</li>
                    <li><span class="dept-plan-keyword">건강 강습회</span> 뉴스타트(Newstart) 건강 강습회 및 절제 주간 운영</li>
                    <li><span class="dept-plan-keyword">말씀 교제</span> 매주 안식일 오후 예언의 신 말씀 나눔</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ===== 디지털홍보부 ===== -->
<div class="container dept-page-section" id="digital-media">
    <div class="dept-profile-card" data-color>
        <div class="dept-profile-left">
            <div class="dept-profile-icon"><i data-lucide="monitor-play"></i></div>
            <h2 class="dept-profile-name">디지털홍보부</h2>
            <p class="dept-profile-sub">2026년도 부서</p>
            <div class="dept-profile-divider"></div>
            <div class="dept-profile-members">
                <div class="dept-profile-member">
                    <span class="dept-profile-badge">부장</span>
                    <span class="dept-profile-member-name">허주현</span>
                </div>
            </div>
            <div class="dept-profile-tags">
                <span class="dept-tag">미디어</span>
                <span class="dept-tag">온라인 예배</span>
                <span class="dept-tag">방송</span>
            </div>
        </div>
        <div class="dept-profile-right">
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="target"></i><span>2026 부서 사명</span></div>
                <p class="dept-mission-text">"현장 예배의 감동을 온라인으로 생동감 있게 전달합니다."</p>
            </div>
            <div class="dept-right-section">
                <div class="dept-right-label"><i data-lucide="list-checks"></i><span>주요 활동 계획</span></div>
                <ul class="dept-plan-list">
                    <li><span class="dept-plan-keyword">라이브 송출</span> 예배 온라인 중계 시스템 안정화 및 생동감 구현</li>
                    <li><span class="dept-plan-keyword">시스템 관리</span> 방송 장비 및 시스템 운영 매뉴얼화</li>
                    <li><span class="dept-plan-keyword">인재 양성</span> 방송실 운영 요원 교육 및 육성</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
