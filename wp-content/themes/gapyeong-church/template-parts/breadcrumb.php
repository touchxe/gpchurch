<?php
/**
 * 가평교회 테마 - Template Part: Breadcrumb
 *
 * 빵조각(Breadcrumb) 내비게이션
 * subpage-hero.php 내부에서 자동으로 호출됩니다.
 *
 * 사용법 (subpage-hero 호출 전에 설정):
 *   set_query_var( 'breadcrumb_items', array(
 *       array( 'label' => '교회소개', 'href' => '/intro/greeting' ),
 *       array( 'label' => '인사말',   'href' => '' ), // href 비우면 현재 위치(span) 처리
 *   ));
 */

$items = get_query_var('breadcrumb_items', array());
?>

<!-- Breadcrumb -->
<nav class="breadcrumb">
    <a href="<?php echo esc_url(home_url('/')); ?>">홈</a>
    <?php foreach ($items as $item): ?>
        <i data-lucide="chevron-right"></i>
        <?php if (!empty($item['href'])): ?>
            <a href="<?php echo esc_url($item['href']); ?>"><?php echo esc_html($item['label']); ?></a>
        <?php else: ?>
            <span><?php echo esc_html($item['label']); ?></span>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>