<?php
/**
 * 가평교회 테마 - Template Part: Submenu Navigation
 *
 * 서브페이지 수평 탭 내비게이션
 *
 * 사용법:
 *   set_query_var( 'submenu_group',  'intro' );
 *   set_query_var( 'submenu_active', '/intro/greeting' );
 *   get_template_part( 'template-parts/submenu-nav' );
 */

$group  = get_query_var('submenu_group', '');
$active = get_query_var('submenu_active', '');

// 1순위: WP 메인 메뉴에서 서브 아이템 추출
// 2순위: functions.php의 하드코딩 레지스트리
$items = false;
if ($group && function_exists('gapyeong_get_submenu_from_wp_menu')) {
    $items = gapyeong_get_submenu_from_wp_menu($group);
}

if (!$items && $group && function_exists('gapyeong_get_submenu')) {
    $items = gapyeong_get_submenu($group);
}

// 직접 아이템 배열이 전달된 경우
if (!$items) {
    $items = get_query_var('submenu_items', array());
}

if (empty($items)) {
    return;
}
?>

<!-- Submenu Navigation Section -->
<section class="submenu-nav-section<?php echo ($group === 'dept') ? ' submenu-no-sticky' : ''; ?>">
    <div class="container">
        <nav class="submenu-nav">
            <?php foreach ($items as $item): ?>
                <a href="<?php echo esc_url($item['href']); ?>"
                    class="submenu-nav-item<?php echo ($active === $item['href']) ? ' active' : ''; ?>">
                    <?php echo esc_html($item['label']); ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>
</section>