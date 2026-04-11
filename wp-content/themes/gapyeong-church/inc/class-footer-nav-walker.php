<?php
/**
 * 가평교회 테마 - Footer Nav Walker
 *
 * 푸터 메뉴용 커스텀 Walker.
 * 메인 메뉴의 최상위 아이템을 h4 제목으로, 자식들을 ul>li>a 목록으로 출력.
 *
 * 출력 예시:
 *   <div class="footer-links">
 *       <h4>교회소개</h4>
 *       <ul>
 *           <li><a href="/intro/greeting">인사말</a></li>
 *       </ul>
 *   </div>
 *
 * 사용법: wp_nav_menu에서 이 Walker를 지정하고, items_wrap을'%3$s'로 설정.
 */

class Gapyeong_Footer_Nav_Walker extends Walker_Nav_Menu
{
    /**
     * 서브메뉴(ul) 시작
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= "    <ul>\n";
        }
    }

    /**
     * 서브메뉴(ul) 끝 + footer-links div 닫기
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= "    </ul>\n";
            $output .= "</div>\n";
        }
    }

    /**
     * 메뉴 아이템 시작
     */
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        $item = $data_object;

        if ($depth === 0) {
            // 최상위 아이템 = 카테고리 제목 (h4)
            $output .= "<div class=\"footer-links\">\n";
            $output .= "    <h4>" . esc_html($item->title) . "</h4>\n";
            // start_lvl이 ul을 열어줌
        } else {
            // 자식 아이템 = 링크
            $output .= "        <li><a href=\"" . esc_url($item->url) . "\">" . esc_html($item->title) . "</a></li>\n";
        }
    }

    /**
     * 메뉴 아이템 끝
     */
    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        // 최상위 아이템: end_lvl에서 div 닫힘
        // 자식 아이템: li는 start_el에서 이미 완결
    }
}
