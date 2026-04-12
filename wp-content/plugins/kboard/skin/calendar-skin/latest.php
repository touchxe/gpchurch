<?php
/**
 * KBoard Calendar Skin - latest.php
 * 홈 교회일정 최신글 모아보기 (front-page.php에서 직접 사용하지 않지만 호환용)
 */
?>
<div id="kboard-calendar-latest">
    <ul class="kboard-calendar-schedule-list">
        <?php
        $list_index = 0;
        while ($content = $list->hasNext()):
            $list_index++;
            $event_date = $content->option->event_date ?? '';
            $display_date = '';
            if ($event_date) {
                $ts = strtotime($event_date);
                $display_date = $ts ? date('m.d', $ts) : $event_date;
            }
            ?>
            <li class="kboard-calendar-item">
                <a href="<?php echo esc_url($url->getDocumentURLWithUID($content->uid)) ?>" class="kboard-calendar-link">
                    <span class="kboard-calendar-date"><?php echo esc_html($display_date ?: '--') ?></span>
                    <span class="kboard-calendar-title"><?php echo esc_html($content->title) ?></span>
                </a>
            </li>
        <?php endwhile; ?>
        <?php if ($list_index == 0): ?>
            <li class="kboard-calendar-empty">등록된 일정이 없습니다.</li>
        <?php endif; ?>
    </ul>
</div>