<?php
/**
 * Template Name: 연혁 페이지
 *
 * 가평교회 테마 - 연혁 서브페이지 템플릿
 */

$ctx = gapyeong_get_page_context();

if ($ctx) {
    set_query_var('subpage_title', $ctx['title']);
    set_query_var('subpage_slogan', $ctx['slogan']);
    set_query_var('breadcrumb_items', $ctx['breadcrumb']);
    set_query_var('submenu_group', $ctx['group']);
    set_query_var('submenu_active', $ctx['active_href']);
} else {
    set_query_var('subpage_title', '연혁');
    set_query_var('subpage_slogan', '하나님과 함께한 56년의 발자취 (1969-2025)');
    set_query_var('breadcrumb_items', array(
        array('label' => '교회소개', 'href' => '/intro/greeting'),
        array('label' => '연혁', 'href' => ''),
    ));
    set_query_var('submenu_group', 'intro');
    set_query_var('submenu_active', '/intro/history');
}

get_header();

// 연혁 데이터 정의
$history_data = array(
    'period-1' => array(
        'label' => '창립기',
        'years' => '1969-1989',
        'events' => array(
            array('year' => '1969', 'items' => array(array('date' => '03.', 'desc' => '김종회 집사 댁에서 집회를 시작하다. (초대 예배소장: 김종회)'))),
            array(
                'year' => '1973',
                'items' => array(
                    array('date' => '03.', 'desc' => '초대 목회교역자 조규술 전도사 부임. 2대 목회자로 한상오 전도사 부임'),
                    array('date' => '10.', 'desc' => '손분선 집사 댁에서 집회 시작'),
                )
            ),
            array('year' => '1975', 'items' => array(array('date' => '03.', 'desc' => '3대 목회자로 김상환 전도사 부임'))),
            array('year' => '1978', 'items' => array(array('date' => '08.', 'desc' => '4대 목회자로 차치현 전도사 부임'))),
            array('year' => '1980', 'items' => array(array('date' => '년대', 'desc' => '가평군 읍내리 556-1번지 소재 집회소 매입 (칠백만원)'))),
            array('year' => '1982', 'items' => array(array('date' => '03.', 'desc' => '5대 목회자로 이제욱 전도사 부임'))),
            array(
                'year' => '1984',
                'items' => array(
                    array('date' => '03.', 'desc' => '6대 목회자로 권혁우 전도사 부임'),
                    array('date' => '05.', 'desc' => '읍내리 534-6번지 대지 198평 매입 (일천만원)'),
                    array('date' => '06.', 'desc' => '교회 건축헌금 작정'),
                )
            ),
            array('year' => '1985', 'items' => array(array('date' => '05.', 'desc' => '교회 건축을 위한 기공식 거행'))),
            array('year' => '1987', 'items' => array(array('date' => '03. 01.', 'desc' => '7대 목회자로 신철호 전도사 부임'))),
        ),
    ),
    'period-2' => array(
        'label' => '성장기',
        'years' => '1990-1999',
        'events' => array(
            array('year' => '1990', 'items' => array(array('date' => '03. 20.', 'desc' => '8대 목회자로 박문철 전도사 부임'))),
            array('year' => '1992', 'items' => array(array('date' => '03.', 'desc' => '9대 목회자로 심정섭 전도사 부임'))),
            array('year' => '1993', 'items' => array(array('date' => '09. 18.', 'desc' => '교회 헌당예배를 드리다'))),
            array(
                'year' => '1995',
                'items' => array(
                    array('date' => '03.', 'desc' => '10대 목회자로 양동호 목사 부임'),
                    array('date' => '04. ~ 12.', 'desc' => '사택 수리, 화장실 보수, 전기시설 수리, 최보영 집사 사택 대문 설치'),
                )
            ),
            array('year' => '1996', 'items' => array(array('date' => '04. 13.', 'desc' => '교회 선교차량(12인승 베스타) 구입'))),
            array(
                'year' => '1997',
                'items' => array(
                    array('date' => '01.', 'desc' => '교회 조직(동중한합회 134번째)'),
                    array('date' => '02. 18.', 'desc' => '정기호 집사가 선교용 FAX, 복사기, 컴퓨터(480만원 상당) 기증'),
                    array('date' => '06. 29.', 'desc' => '본당바닥 전기 온돌공사, 전기 승압공사(15KW), 내부 도색(500만원)'),
                    array('date' => '07. 05.', 'desc' => '김재신, 최보영, 마성철 집사 협력하여 우물 파기'),
                )
            ),
            array(
                'year' => '1998',
                'items' => array(
                    array('date' => '08.', 'desc' => '초대 장로로 김재신 집사 안수. 교회 2층 식당 겸 다목적 관 증축(12평, 1,000만원)'),
                    array('date' => '09.', 'desc' => '2층 식당 누수로 인한 지붕공사 (500만원)'),
                    array('date' => '10.', 'desc' => '교회 탁구대(53만원 상당) 구입'),
                )
            ),
            array(
                'year' => '1999',
                'items' => array(
                    array('date' => '03.', 'desc' => '노인·어린이·장애인용 휠체어로드 설치'),
                    array('date' => '09.', 'desc' => '"하얀울타리"를 통한 화장실 신축 및 간판 설치 (1,100만원)'),
                    array('date' => '11.', 'desc' => '노인대학에 앰프, 스피커, 마사지 전기의자 기증'),
                )
            ),
        ),
    ),
    'period-3' => array(
        'label' => '발전기',
        'years' => '2000-2009',
        'events' => array(
            array(
                'year' => '2000',
                'items' => array(
                    array('date' => '01. 01.', 'desc' => '2대 장로로 최창규 집사 안수'),
                    array('date' => '02. ~ 11.', 'desc' => '가평 노인대학 강사 초빙 및 기타 지원 활동'),
                )
            ),
            array(
                'year' => '2001',
                'items' => array(
                    array('date' => '03.', 'desc' => '10개 전도팀 발족'),
                    array('date' => '05.', 'desc' => '11대 목회자로 김진원 목사 부임'),
                )
            ),
            array('year' => '2003', 'items' => array(array('date' => '', 'desc' => '영어 성서원 개원'))),
            array('year' => '2004', 'items' => array(array('date' => '12.', 'desc' => '교회 신축 및 입당식'))),
            array(
                'year' => '2005',
                'items' => array(
                    array('date' => '03.', 'desc' => '김진원 목사 미국 앤드류스(Andrews) 대학원 유학'),
                    array('date' => '04.', 'desc' => '12대 목회자로 방한규 목사 부임'),
                    array('date' => '05.', 'desc' => '사택 난방을 심야전기 보일러로 교체'),
                    array('date' => '07.', 'desc' => '문화원 리모델링 공사 (홍범기 집사 봉사)'),
                    array('date' => '10.', 'desc' => '교회 외벽 방수공사'),
                    array('date' => '12.', 'desc' => 'Hazel 선교사 귀국, Maybel 선교사 부임. 북한 금강산 지역 우물파주기(1회)'),
                )
            ),
            array(
                'year' => '2006',
                'items' => array(
                    array('date' => '01.', 'desc' => '신임 여집사 임명 (김남숙, 손분자, 신미선)'),
                    array('date' => '02.', 'desc' => '교회 자모반 설치 공사'),
                    array('date' => '03.', 'desc' => '교회 찬양대 조직 (1대 지휘자: 장은영)'),
                    array('date' => '04.', 'desc' => '"사랑의 반찬 나누기" 봉사 시작. Novellia 선교사 귀국, Anabella 선교사 부임'),
                    array('date' => '05.', 'desc' => '한 교회 봉사 후 부임. 선교차량(스타렉스) 구입. 필리핀 올랑고 섬 해외봉사(7명)'),
                    array('date' => '09.', 'desc' => '액정 프로젝터(엡슨 4200) 및 전동스크린 설치'),
                    array('date' => '10.', 'desc' => 'Maybel 선교사 귀국, Edna 선교사 부임'),
                    array('date' => '11.', 'desc' => '건강전도회 개최, 7명 침례'),
                )
            ),
            array(
                'year' => '2007',
                'items' => array(
                    array('date' => '01.', 'desc' => '복사실을 치료봉사실로 개조, 물리치료 서비스 시작'),
                    array('date' => '03.', 'desc' => '1대 학생전도사 권재범 파송'),
                    array('date' => '04.', 'desc' => '교회 종탑 방수 보수공사'),
                    array('date' => '06. ~ 07.', 'desc' => '바닥재·벽면 공사, 에어컨 설치(본당 및 사택)'),
                    array('date' => '08.', 'desc' => '북한 금강산 지역 우물파주기(2회). 복사기 교체(캐논 IR427NS)'),
                    array('date' => '10.', 'desc' => 'Edna 선교사 1년 연장 봉사 결의'),
                )
            ),
            array(
                'year' => '2008',
                'items' => array(
                    array('date' => '01.', 'desc' => '신임 집사 안수 (노석화, 임석엽, 장은영, 양해경)'),
                    array('date' => '03.', 'desc' => '13대 목회자로 김홍일 목사 부임. 2대 학생전도사 박성욱 파송'),
                    array('date' => '', 'desc' => '교회 리모델링 공사 및 헌당 예배'),
                )
            ),
        ),
    ),
    'period-4' => array(
        'label' => '확장기',
        'years' => '2010-2019',
        'events' => array(
            array('year' => '2012', 'items' => array(array('date' => '03.', 'desc' => '14대 목회자로 조학진 목사 부임'))),
            array('year' => '2013', 'items' => array(array('date' => '08.', 'desc' => '도시가스 공사 완료'))),
            array(
                'year' => '2014',
                'items' => array(
                    array('date' => '08.', 'desc' => '의자 봉헌, 현관 대리석 및 마이크 교체 (헌금: 김재신 외 5명)'),
                    array('date' => '12. 31.', 'desc' => '영어문화원 폐원'),
                )
            ),
            array(
                'year' => '2015',
                'items' => array(
                    array('date' => '03. 01.', 'desc' => '15대 목회자로 허옥 목사 부임'),
                    array('date' => '07. 07.', 'desc' => '사택 지붕 단열 공사. 삼육보건대 피부과 봉사대 학생전도회'),
                )
            ),
            array(
                'year' => '2016',
                'items' => array(
                    array('date' => '01. 02.', 'desc' => '서호용 집사 장로 안수, 오은미 신임집사 안수'),
                    array('date' => '02. 03.', 'desc' => '교회 입구 간판 기둥 공사'),
                    array('date' => '08.', 'desc' => '대만 용캉 교회 해외봉사'),
                )
            ),
            array(
                'year' => '2017',
                'items' => array(
                    array('date' => '01. 07.', 'desc' => '김선경 신임집사 안수'),
                    array('date' => '03. 01.', 'desc' => '16대 목회자로 임길수 목사 부임'),
                )
            ),
            array('year' => '2018', 'items' => array(array('date' => '08. 25.', 'desc' => '변시섭 외 5명 침례'))),
            array(
                'year' => '2019',
                'items' => array(
                    array('date' => '01. 05.', 'desc' => '김진수·박서영 부부 신임집사 안수'),
                    array('date' => '03. 01.', 'desc' => '17대 목회자로 이종식 목사 부임'),
                    array('date' => '03. 27.', 'desc' => '교회 앞마당 및 도로 아스콘 포장 공사 (400만원)'),
                    array('date' => '04. 10.', 'desc' => '칼갈이 봉사단 초청 전반기 전도회 개최'),
                    array('date' => '05. 29.', 'desc' => '현관 바닥 공사 (정봉길 집사 봉사)'),
                    array('date' => '07. 05.', 'desc' => '교회 마당 입구 네온간판 설치 (210만원)'),
                    array('date' => '08. 08.', 'desc' => '교회 선교차량(스타렉스) 구입 (약 1,600만원)'),
                    array('date' => '09. 14.', 'desc' => '정창호 성도 침례'),
                    array('date' => '09. 25.', 'desc' => '박완정 목사 초청 후반기 전도회 및 아로마 테라피 강습'),
                    array('date' => '09. 28.', 'desc' => '이명순, 김덕순 성도 침례'),
                    array('date' => '10. 13.', 'desc' => '집사회 주최 제1회 우정의 날 행사 (칼봉산 휴양림)'),
                    array('date' => '10. 04. / 11. 16.', 'desc' => '외부 2층 길 핸드레일 및 문 설치 공사 (유재흥 집사 봉사)'),
                    array('date' => '10. 20. ~ 21.', 'desc' => '홍명관 목사 초청 청지기 부흥회'),
                    array('date' => '11. 22.', 'desc' => '식기세척기 기증 (문금순 집사, 200만원 상당)'),
                    array('date' => '11. 26. ~ 30.', 'desc' => '오원배 목사 초청 연말기도주일'),
                    array('date' => '11. 30.', 'desc' => '가평 패스파인더, 동중한합회 \'골드 클럽\' 선정'),
                )
            ),
        ),
    ),
    'period-5' => array(
        'label' => '도약기',
        'years' => '2020-2025',
        'events' => array(
            array(
                'year' => '2020',
                'items' => array(
                    array('date' => '01. 29. ~ 21.', 'desc' => '고성표 목사 초청 사경회'),
                    array('date' => '02. 29. ~', 'desc' => '코로나19로 인한 온라인 방송 예배 대체'),
                    array('date' => '03. 17. ~ 18.', 'desc' => '본당 천장 매립형 냉난방기 설치 (약 700만원)'),
                    array('date' => '03. 26. / 04. 11. 18.', 'desc' => '손 청결제 지역 나눔 봉사 (700개 제작)'),
                    array('date' => '06. 27.', 'desc' => '김어진, 김서진 자매 적목리 침례 터에서 침례'),
                    array('date' => '08. 12.', 'desc' => '제습기 및 컬러 레이저 복합기 구입'),
                    array('date' => '08. 18. ~ 12. 19.', 'desc' => '마라나타 기도회 개최 (5회)'),
                    array('date' => '08. 28. ~ 29.', 'desc' => '정성철 목사 초청 장막부흥회'),
                    array('date' => '09. 15. ~ 20.', 'desc' => '북편 지붕 방수시트 공사 (유재흥 집사 봉사)'),
                    array('date' => '09. 05. ~ 26.', 'desc' => '온라인 어린이 여름 성경학교 개최 (23명 수료)'),
                    array('date' => '10. 10.', 'desc' => '교회 밴드라이브 예배 방송 시작'),
                    array('date' => '10. 24.', 'desc' => '박순자 성도 침례'),
                    array('date' => '11. 06. ~ 14.', 'desc' => '김형석 목사 초청 주말 전도회'),
                    array('date' => '12. 05.', 'desc' => '박소영 자매 침례'),
                    array('date' => '12. 10. ~ 13.', 'desc' => '십자가 3단 탑 및 지붕 강판 전체 교체 공사 (1,170만원)'),
                    array('date' => '12. 18. ~ 20.', 'desc' => '본당 전기 배선 및 LED 전구 교체 공사 (유재흥 집사 봉사)'),
                )
            ),
            array(
                'year' => '2021',
                'items' => array(
                    array('date' => '01. 29. ~ 30.', 'desc' => '윤경식 목사 초청 사경회'),
                    array('date' => '03. 01.', 'desc' => '18대 목회자로 정선화 목사 부임'),
                    array('date' => '03. 12.', 'desc' => '3대 교육 전도사 형성민 부임'),
                    array('date' => '03. 20.', 'desc' => '온라인 예배용 방송 장비 구입 및 설치'),
                    array('date' => '03. 20. ~ 04. 17.', 'desc' => '사택 입구 천장 및 화장실 수리, 사택 도어 교체'),
                    array('date' => '05. 07.', 'desc' => '강단 중앙 십자가 및본당 헌금함 설치'),
                    array('date' => '07. 09. ~ 10.', 'desc' => '이강옥 박사·사랑의 듀엣 초청 주말부흥회'),
                    array('date' => '09. 16. ~ 25.', 'desc' => '영상 및 음향 장비 고도화 공사 (300만원)'),
                    array('date' => '09. 18.', 'desc' => '단상 86인치 TV 및 기자재 설치 (210만원)'),
                    array('date' => '09. 24. ~ 10. 02.', 'desc' => '장사열 목사 초청 가을전도회'),
                    array('date' => '11. 23. ~ 27.', 'desc' => '김명호 목사 초청 연말기도주일'),
                    array('date' => '12. 20.', 'desc' => '아크릴 안교단상 기증 (소망성구사)'),
                )
            ),
            array(
                'year' => '2022',
                'items' => array(
                    array('date' => '01. 08.', 'desc' => '김이슬 성도 신임집사 안수'),
                    array('date' => '01. 11. ~ 15.', 'desc' => '류태희 목사 초청 사경회'),
                    array('date' => '02. 19.', 'desc' => '서광수 목사 초청 주말부흥회'),
                    array('date' => '04. 08.', 'desc' => '대면예배 재개'),
                    array('date' => '06. 12.', 'desc' => '1층 세미나실 소예배실로 리모델링'),
                    array('date' => '06. 15.', 'desc' => '새신자반 성도 교회기관 견학'),
                    array('date' => '06. 17. ~ 25.', 'desc' => '위재헌 목사 외 초청 건강 주제 춘계전도회'),
                    array('date' => '07. 01. ~ 02.', 'desc' => '오범석 목사 초청 북한선교 주말부흥회'),
                    array('date' => '07. 05. ~ 13.', 'desc' => '김재신 장로, 손옥분 집사 몽골전도회 참석'),
                    array('date' => '07. 24. ~ 26.', 'desc' => '동중한합회 연합장막부흥회(사슴의 동산) 참석'),
                    array('date' => '08. 19. ~ 21.', 'desc' => '어린이 여름 성경학교 개최 (15명 수료)'),
                    array('date' => '09. 24.', 'desc' => '강종수 외 성도 침례 및 공유찬·최영숙 성도 입교'),
                    array('date' => '10. 23.', 'desc' => '집사회 주최 남이섬 야유회'),
                    array('date' => '10. 27.', 'desc' => '동중한합회 주관 교회 감사 수검'),
                    array('date' => '10. 28. ~ 11. 05.', 'desc' => '윤영한 목사 초청 가을전도회'),
                    array('date' => '11. 21. ~ 23.', 'desc' => '새신자반 교회기관 및 삼육식품 공장 탐방'),
                    array('date' => '12. 31.', 'desc' => '박은종 성도 신임집사 안수'),
                )
            ),
            array(
                'year' => '2023',
                'items' => array(
                    array('date' => '01. 28.', 'desc' => '천세원 목사 초청'),
                    array('date' => '04. 05. ~ 08.', 'desc' => '박성원 목사 초청 춘계기도주일'),
                    array('date' => '05. 18.', 'desc' => '새신자 학교 기관탐방'),
                    array('date' => '06. 24.', 'desc' => '인도 유학생 푸니아 초청'),
                    array('date' => '07. 14. ~ 15.', 'desc' => '조경남 교수 초청 건강세미나'),
                    array('date' => '07. 25. ~ 31.', 'desc' => '미국 오클라호마 청년 봉사대 초청 성경학교'),
                    array('date' => '09. 02.', 'desc' => '김건희 외 학생 5명 침례'),
                    array('date' => '10. 07.', 'desc' => '우희찬, 김희자 성도 침례'),
                    array('date' => '10. 13. ~ 21.', 'desc' => '이경원 목사 초청 가을전도회'),
                    array('date' => '11.', 'desc' => '방송장비 고도화 (카메라 3대, 무선마이크 등 600만원)'),
                    array('date' => '12. 29.', 'desc' => '제4회 패스파인더의 밤 ("돌아온 탕자" 성극)'),
                    array('date' => '12. 30.', 'desc' => '공유찬, 최영숙 성도 집사 안수'),
                )
            ),
            array(
                'year' => '2024',
                'items' => array(
                    array('date' => '02. 01.', 'desc' => '19대 목회자로 위수민 목사 부임. 사택 수리'),
                    array('date' => '02. 24.', 'desc' => '교회 1층 도배 작업 (1,390여만원)'),
                    array('date' => '03. 01. ~ 03.', 'desc' => '춘계대심방 시작 및 영성훈련 캠프 참여'),
                    array('date' => '03. 16.', 'desc' => '종교자유부 세미나 및 새출발 장학금 수여'),
                    array('date' => '03. 22. ~ 23.', 'desc' => '류대균 목사 초청 춘계기도주일'),
                    array('date' => '03. 26. ~ 30.', 'desc' => '북면소그룹 재개 및 새신자 발대식'),
                    array('date' => '04. 06. ~ 07.', 'desc' => '어린이/부부가정 기도캠프 (사슴의 동산, 42명)'),
                    array('date' => '04. 16. / 20.', 'desc' => '장마당 소그룹 시작 및 손분선 집사 팔순 축하'),
                    array('date' => '05. 05. ~ 22.', 'desc' => '명품인생학교 강습 및 새신자반 필리핀 기관 방문'),
                    array('date' => '05. 11.', 'desc' => '칼봉산 야외예배 및 가평 패스파인더 요리대회 우승'),
                    array('date' => '05. 22. ~ 27.', 'desc' => '소그룹 전도회 및 윤준석 청년 군 입대'),
                    array('date' => '06. 04. ~ 22.', 'desc' => '소그룹 투어, 여성강조안식일, 성만찬 예식'),
                    array('date' => '07. 19. ~ 29.', 'desc' => '거점 성경학교 개최 및 조영수 청년 군 입대'),
                    array('date' => '08. 02. ~ 14.', 'desc' => '홍명관 목사 부흥회 및 필리핀 세부 시키호르 해외봉사'),
                    array('date' => '08. 24. ~ 31.', 'desc' => '바이블가이드 부흥회 및 경춘지구 연합 장막부흥회'),
                    array('date' => '09. 07.', 'desc' => '원로목사 조광림 목사 방문 설교'),
                    array('date' => '10. 12. / 29.', 'desc' => '장년 관계회복 프로그램 및 교회 외부 간판 교체 완료'),
                    array('date' => '10. 30. ~ 11. 02.', 'desc' => '성시영 목사 초청 가을대전도회 (2명 침례)'),
                    array('date' => '11. 08. ~ 17.', 'desc' => '선교 120주년 기념예배 영상 시청 및 청년회 캠프'),
                    array('date' => '12. 11. ~ 28.', 'desc' => '연말기도주일, 찬양의 밤, 패스파인더의 밤 등 행사'),
                )
            ),
            array(
                'year' => '2025',
                'items' => array(
                    array('date' => '01. 04.', 'desc' => '신임집사 안수식 (박해욱, 이은화, 김원창)'),
                    array('date' => '01. 06. ~ 18.', 'desc' => '군입대·단기선교 파송식, 안교교사 헌신서약 및 세미나'),
                    array('date' => '01. 23. ~ 25.', 'desc' => '김호경 목사 초청 신년사경회'),
                    array('date' => '03. 14. ~ 22.', 'desc' => '김창현 목사 초청 부흥회 및 명품인생학교 교사모임'),
                    array('date' => '04. 12. / 14.', 'desc' => '강병진 목사 설교 및 지구목사 방문'),
                    array('date' => '05. 09. ~ 22.', 'desc' => '가정의 달 부흥회 및 새신자 대만 기관방문'),
                    array('date' => '05. 31.', 'desc' => '적목리 신앙유적지 사전교육 및 현장탐사'),
                    array('date' => '06. 12. / 14.', 'desc' => '박지만 장로 하관예배 및 세계여성사역강조안식일'),
                    array('date' => '06. 27. ~ 28.', 'desc' => '박진용 목사 초청 주말부흥회'),
                    array('date' => '07. 26. ~ 31.', 'desc' => '여름성경학교 및 가평 폭우지역 구호물품 지원'),
                    array('date' => '08. 14.', 'desc' => '목회실 냉난방기 설치 및 교회 제습기 2대 구매'),
                    array('date' => '08. 30. ~ 09. 06.', 'desc' => '집사 수련회 및 연합 지구 장막부흥회 개최'),
                    array('date' => '09. 14. ~ 17.', 'desc' => '여수오양병원 체험 참여(8명)'),
                    array('date' => '10. 18. ~ 19.', 'desc' => '전교인 소통 활동 및 희망나눔바자회 개최'),
                    array('date' => '10. 27. ~ 11. 01.', 'desc' => '유창종 목사 초청 가을대전도회 (3명 침례)'),
                    array('date' => '11. 18.', 'desc' => '가평 청년 자립키트 지원 및 교회 보일러 교체'),
                    array('date' => '11. 27.', 'desc' => '26년도 재직 총회 결의 (신임장로: 심재영, 신영빈)'),
                )
            ),
        ),
    ),
);

// 스테퍼 탭 순서 (최신순: 도약기 → 창립기)
$stepper_order = array('period-5', 'period-4', 'period-3', 'period-2', 'period-1');
?>

<!-- Global Parallax Background Orbs -->
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
        <div class="history-stepper-container">
            <div class="history-stepper">
                <?php foreach ($stepper_order as $idx => $period_id):
                    $period = $history_data[$period_id];
                    $active = ($idx === 0) ? ' active' : '';
                    ?>
                    <div class="step-item<?php echo $active; ?>"
                        onclick="switchHistoryTab('<?php echo $period_id; ?>', this)">
                        <span class="step-title"><?php echo esc_html($period['label']); ?></span>
                        <span class="step-desc"><?php echo esc_html($period['years']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="content-box">
            <?php foreach ($stepper_order as $idx => $period_id):
                $period = $history_data[$period_id];
                $active = ($idx === 0) ? ' active' : '';
                ?>
                <div id="<?php echo $period_id; ?>" class="history-panel<?php echo $active; ?>">
                    <?php
                    // 연도 역순(최신 연도부터) 정렬
                    $reversed_events = array_reverse($period['events']);
                    foreach ($reversed_events as $year_data):
                        ?>
                        <div class="timeline-item">
                            <div class="timeline-year"><?php echo esc_html($year_data['year']); ?></div>
                            <div class="timeline-content">
                                <div class="events-list">
                                    <?php
                                    // 월별/일자별 항목 역순(최신 날짜부터) 정렬
                                    $reversed_items = array_reverse($year_data['items']);
                                    foreach ($reversed_items as $item):
                                        ?>
                                        <div class="event-row">
                                            <div class="event-date"><?php echo esc_html($item['date']); ?></div>
                                            <p class="event-desc"><?php echo esc_html($item['desc']); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
    function switchHistoryTab(periodId, element) {
        document.querySelectorAll('.step-item').forEach(step => step.classList.remove('active'));
        element.classList.add('active');
        document.querySelectorAll('.history-panel').forEach(panel => {
            panel.classList.remove('active');
            setTimeout(() => { if (!panel.classList.contains('active')) { panel.style.opacity = 0; panel.style.transform = 'translateY(10px)'; } }, 10);
        });
        const activePanel = document.getElementById(periodId);
        if (activePanel) {
            activePanel.classList.add('active');
            void activePanel.offsetWidth;
            activePanel.style.opacity = 1;
            activePanel.style.transform = 'translateY(0)';
            if (typeof ScrollTrigger !== 'undefined') ScrollTrigger.refresh();
        }
    }
</script>

<?php get_footer(); ?>