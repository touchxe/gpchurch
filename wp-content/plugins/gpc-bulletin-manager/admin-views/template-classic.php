<?php
/**
 * 주보 템플릿 - A4 가로 3단
 * 
 * 미리보기 및 PDF 출력을 위한 HTML 템플릿입니다.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div id="gpc-bulletin-template" class="gpc-bulletin-a4">
    <!-- 폰트 로드 -->
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Myeongjo:wght@400;700;800&family=Noto+Serif+KR:wght@400;600;700;900&display=swap" rel="stylesheet">
    
    <style>
        /* A4 가로 사이즈 기준 CSS */
        .gpc-bulletin-a4 {
            width: 297mm;
            height: 210mm;
            background: #fff;
            padding: 10mm;
            box-sizing: border-box;
            font-family: 'Nanum Myeongjo', 'Noto Serif KR', serif;
            display: flex;
            justify-content: space-between;
            gap: 10mm;
            color: #000;
            overflow: hidden;
            position: relative;
        }

        .gpc-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            width: calc((100% - 20mm) / 3);
            border: 1px dashed #eee; /* 재단선 가이드 (실제 인쇄시 숨김 가능) */
            padding: 5px;
        }

        .gpc-col-title {
            text-align: center;
            font-size: 20pt;
            font-weight: 800;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 5px 0;
            margin-bottom: 10px;
            letter-spacing: 5px;
        }

        .gpc-section {
            margin-bottom: 15px;
        }

        /* 표 스타일 */
        .gpc-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }
        
        .gpc-table th, .gpc-table td {
            padding: 2px 5px;
            vertical-align: middle;
        }

        .gpc-order-table td.order-name {
            width: 40%;
            text-align: left;
            position: relative;
        }
        .gpc-order-table td.order-name::after {
            content: ".....................................";
            position: absolute;
            left: 0;
            width: 250%;
            overflow: hidden;
            color: #999;
            z-index: 0;
            letter-spacing: 2px;
        }
        .gpc-order-table td.order-name span {
            background: #fff;
            position: relative;
            z-index: 1;
            padding-right: 5px;
        }
        .gpc-order-table td.order-person {
            width: 60%;
            text-align: right;
            background: #fff;
            position: relative;
            z-index: 1;
            padding-left: 5px;
        }

        /* 하단 박스 타이틀 */
        .gpc-box-title {
            text-align: center;
            font-weight: 700;
            border: 2px solid #000;
            padding: 3px;
            margin: 10px 0 5px 0;
            font-size: 11pt;
            background: #f9f9f9;
        }

        /* 가운데 단 날짜 헤더 */
        .gpc-date-header {
            text-align: center;
            font-size: 14pt;
            font-weight: 700;
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            padding: 5px 0;
            margin-bottom: 2px;
        }
        .gpc-sunset {
            text-align: right;
            font-size: 9pt;
            color: #555;
            margin-bottom: 10px;
        }

        /* 텍스트 내용 */
        .gpc-text-content {
            font-size: 10pt;
            line-height: 1.5;
            white-space: pre-wrap;
        }
        
        .gpc-news-title {
            font-weight: 700;
            font-size: 11pt;
            margin-bottom: 5px;
        }

        /* 헌금 표 */
        .gpc-offering-table {
            border: 1px solid #000;
            width: 100%;
            font-size: 9pt;
        }
        .gpc-offering-table td {
            border: 1px solid #000;
            padding: 3px;
        }
        .gpc-offering-table td:first-child {
            font-weight: 700;
            text-align: center;
            width: 25%;
        }

        /* 강조 색상 */
        .text-blue { color: #0000ff; }
        .text-red { color: #ff0000; }
        
        /* 설교 부분 강조 */
        .sermon-highlight {
            text-align: center;
            font-weight: 700;
            color: #0000ff;
            margin: 5px 0;
            font-size: 11pt;
        }
    </style>

    <!-- Column 1: 안식일 학교 -->
    <div class="gpc-column">
        <div class="gpc-col-title">안 식 일 학 교</div>
        
        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 10pt; margin-bottom: 5px;">
            <span>오전 9:30</span>
            <span>진행: <span data-bind="ss_host"></span></span>
        </div>

        <table class="gpc-table gpc-order-table">
            <tr><td class="order-name"><span>경배와 찬양</span></td><td class="order-person">일 동</td></tr>
            <tr><td class="order-name"><span>찬 미</span></td><td class="order-person"><span data-bind="ss_hymn"></span> 일 동</td></tr>
            <tr><td class="order-name"><span>기 도</span></td><td class="order-person"><span data-bind="ss_prayer"></span></td></tr>
            <tr><td class="order-name"><span>환영사</span></td><td class="order-person"><span data-bind="ss_welcome"></span></td></tr>
            <tr><td class="order-name"><span>특 창</span></td><td class="order-person"><span data-bind="ss_special_song"></span></td></tr>
            <tr><td class="order-name"><span>특 순</span></td><td class="order-person"><span data-bind="ss_special_order"></span></td></tr>
            <tr><td class="order-name"><span>선교지 소식</span></td><td class="order-person">진 행 자</td></tr>
            <tr><td class="order-name"><span>기억절 암송</span></td><td class="order-person">다 같 이</td></tr>
            <tr><td class="order-name"><span>교 과</span></td><td class="order-person">각 반</td></tr>
        </table>
        
        <div class="sermon-highlight" style="margin-top: 10px;">
            <span data-bind="ss_lesson_title"></span>
        </div>

        <div class="gpc-box-title">이번 주 시무 및 봉사 안내</div>
        <div class="gpc-text-content" data-bind="service_this_week" style="min-height: 40px; font-size: 9pt;"></div>

        <div class="gpc-box-title">다음 주 시무 및 봉사 안내</div>
        <div class="gpc-text-content" data-bind="service_next_week" style="min-height: 40px; font-size: 9pt;"></div>

        <div class="gpc-box-title" style="margin-top:auto;">** 기 억 절 **</div>
        <div class="gpc-text-content" data-bind="memory_verse" style="text-align:center; font-weight:bold; font-size: 10pt;"></div>
    </div>

    <!-- Column 2: 교회 소식 -->
    <div class="gpc-column">
        <div class="gpc-date-header">
            <span data-bind="publish_date"></span>
            <span data-bind="sabbath_type" style="font-size: 12pt; margin-left: 10px;"></span>
        </div>
        <div class="gpc-sunset">*일몰: <span data-bind="sunset_time"></span>*</div>

        <div class="gpc-section" style="flex-grow: 1;">
            <div class="gpc-news-title">1. 환영합니다!</div>
            <p style="margin:0 0 10px 0; font-size: 10pt;">가평교회를 찾아주시고, 예배에 동참해 주신 분들을 환영합니다.</p>
            
            <div class="gpc-news-title">2. 교회소식 및 안내</div>
            <div class="gpc-text-content" data-bind="church_news"></div>
            
            <div class="gpc-text-content" data-bind="announcements" style="margin-top: 10px;"></div>
        </div>

        <table class="gpc-offering-table">
            <tr><td>십 일 금</td><td data-bind="offering_list"></td></tr>
            <tr><td>월정헌금</td><td>-</td></tr>
            <tr><td>감사헌금</td><td>-</td></tr>
            <tr><td>도르가헌금</td><td>-</td></tr>
            <tr><td>해외선교</td><td>-</td></tr>
        </table>
    </div>

    <!-- Column 3: 안식일 예배 -->
    <div class="gpc-column">
        <div class="gpc-col-title">안 식 일 예 배</div>
        
        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 10pt; margin-bottom: 5px;">
            <span>오전 11:00</span>
            <span>인도: <span data-bind="ws_host"></span></span>
        </div>

        <table class="gpc-table gpc-order-table">
            <tr><td class="order-name"><span>등단묵상</span></td><td class="order-person">일 동</td></tr>
            <tr><td class="order-name"><span>* 송 영</span></td><td class="order-person"><span data-bind="ws_doxology"></span> 일 동</td></tr>
            <tr><td class="order-name"><span>* 기 원</span></td><td class="order-person">말씀선포자</td></tr>
            <tr><td class="order-name"><span>* 교 독 문</span></td><td class="order-person"><span data-bind="ws_responsive_reading"></span> 일 동</td></tr>
            <tr><td class="order-name"><span>* 찬 미</span></td><td class="order-person"><span data-bind="ws_hymn"></span> 일 동</td></tr>
            <tr><td class="order-name"><span>* 기 도</span></td><td class="order-person"><span data-bind="ws_prayer"></span></td></tr>
            <tr><td class="order-name"><span>헌 금</span></td><td class="order-person">일 동</td></tr>
            <tr><td class="order-name"><span>* 헌금찬미</span></td><td class="order-person"><span data-bind="ws_offering_hymn"></span> 일 동</td></tr>
            <tr><td class="order-name"><span>* 헌금축도</span></td><td class="order-person"><span data-bind="ws_offering_benediction"></span></td></tr>
            <tr><td class="order-name"><span>특 창</span></td><td class="order-person"><span data-bind="ws_special_song"></span></td></tr>
        </table>

        <div class="sermon-highlight">
            <div data-bind="ws_sermon_title"></div>
            <div style="font-size: 9pt; color:#000;"><span data-bind="ws_bible_text"></span></div>
            <div style="text-align: right; margin-top:5px; color:#000;"><span data-bind="ws_preacher"></span></div>
        </div>

        <table class="gpc-table gpc-order-table">
            <tr><td class="order-name"><span>* 찬 미</span></td><td class="order-person"><span data-bind="ws_closing_hymn"></span> 일 동</td></tr>
            <tr><td class="order-name"><span>* 축 도</span></td><td class="order-person"><span data-bind="ws_benediction"></span></td></tr>
        </table>

        <div class="gpc-box-title" style="margin-top:auto;">기 도 요 청</div>
        <div class="gpc-text-content" data-bind="prayer_requests" style="font-size: 9pt; min-height: 80px;"></div>
    </div>
</div>
