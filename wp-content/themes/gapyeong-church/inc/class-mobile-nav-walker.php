<?php
/**
 * 가평교회 테마 - Mobile Nav Walker
 *
 * 모바일 아코디언 내비게이션용 커스텀 Walker.
 * wp_nav_menu의 표준 ul/li 구조 대신 div/button/a 구조를 출력합니다.
 *
 * 출력 예시:
 *   <a href="/" class="mobile-nav-link">홈</a>
 *   <div class="mobile-nav-group">
 *       <button class="mobile-nav-toggle">
 *           교회소개 <i data-lucide="chevron-down"></i>
 *       </button>
 *       <div class="mobile-nav-dropdown">
 *           <a href="/intro/greeting">인사말</a>
 *       </div>
 *   </div>
 *
 * 주의: 이 Walker는 표준 ul/li 출력 대신 완전히 커스텀된 구조를 사용합니다.
 *      wp_nav_menu의 items_wrap을 '%3$s'로 설정하여 감싸는 ul을 제거해야 합니다.
 */

class Gapyeong_Mobile_Nav_Walker extends Walker_Nav_Menu
{
    /**
     * 현재 최상위 아이템이 자식을 가지고 있는지 추적
     */
    private $current_parent_has_children = false;

    /**
     * 서브메뉴 시작 (드롭다운 열기)
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= "    <div class=\"mobile-nav-dropdown\">\n";
        }
    }

    /**
     * 서브메뉴 끝 (드롭다운 + 그룹 닫기)
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= "    </div>\n";
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
            $has_children = $args->walker->has_children;
            $this->current_parent_has_children = $has_children;

            if ($has_children) {
                // 드롭다운 그룹 시작 + 토글 버튼
                $output .= "<div class=\"mobile-nav-group\">\n";
                $output .= "    <button class=\"mobile-nav-toggle\">\n";
                $output .= "        " . esc_html($item->title) . "\n";
                $output .= "        <i data-lucide=\"chevron-down\"></i>\n";
                $output .= "    </button>\n";
                // start_lvl이 드롭다운을 열어줌
            } else {
                // 단순 링크 (예: 홈)
                $output .= "<a href=\"" . esc_url($item->url) . "\" class=\"mobile-nav-link\">" . esc_html($item->title) . "</a>\n";
            }
        } else {
            // 드롭다운 내부 링크
            $output .= "        <a href=\"" . esc_url($item->url) . "\">" . esc_html($item->title) . "</a>\n";
        }
    }

    /**
     * 메뉴 아이템 끝 (최상위 비-드롭다운은 이미 닫혀있음)
     */
    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        // 드롭다운이 있는 최상위 아이템은 end_lvl에서 닫힘
        // 드롭다운이 없는 최상위 아이템은 start_el에서 이미 완결됨
        // 서브 아이템은 별도 닫기 불필요 (a 태그만 사용)
    }
}
