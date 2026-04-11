<?php
/**
 * 가평교회 테마 - Desktop Nav Walker
 *
 * 데스크톱 헤더 내비게이션용 커스텀 Walker.
 * 기존 HTML 클래스 구조를 정확하게 유지합니다.
 *
 * 출력 예시:
 *   <li class="nav-item has-dropdown">
 *       <a href="#" class="nav-link">교회소개</a>
 *       <ul class="dropdown-menu">
 *           <li><a href="/intro/greeting" class="dropdown-item">인사말</a></li>
 *       </ul>
 *   </li>
 */

class Gapyeong_Desktop_Nav_Walker extends Walker_Nav_Menu
{
    /**
     * 서브메뉴(ul) 시작
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth + 1);
        $output .= "\n{$indent}<ul class=\"dropdown-menu\">\n";
    }

    /**
     * 서브메뉴(ul) 끝
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth + 1);
        $output .= "{$indent}</ul>\n";
    }

    /**
     * 메뉴 아이템(li) 시작
     */
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        $item = $data_object;
        $indent = str_repeat("\t", $depth + 1);

        // depth 0 = 최상위 메뉴 아이템
        if ($depth === 0) {
            $has_children = $args->walker->has_children;
            $classes = 'nav-item';
            if ($has_children) {
                $classes .= ' has-dropdown';
            }

            // current 클래스
            if (in_array('current-menu-item', $item->classes) || in_array('current-menu-ancestor', $item->classes)) {
                $classes .= ' active';
            }

            $output .= "{$indent}<li class=\"{$classes}\">\n";

            // 자식이 있으면 href="#" (드롭다운 토글)
            $href = $has_children ? '#' : esc_url($item->url);
            $output .= "{$indent}\t<a href=\"{$href}\" class=\"nav-link\">" . esc_html($item->title) . "</a>\n";
        } else {
            // depth 1+ = 드롭다운 내부 아이템
            $output .= "{$indent}<li>";
            $output .= "<a href=\"" . esc_url($item->url) . "\" class=\"dropdown-item\">" . esc_html($item->title) . "</a>";
        }
    }

    /**
     * 메뉴 아이템(li) 끝
     */
    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        $output .= "</li>\n";
    }
}
