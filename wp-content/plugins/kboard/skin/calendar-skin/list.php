<?php
/**
 * KBoard Calendar Skin - list.php
 * 교회일정 게시판 목록 (행사 날짜 기준 정렬 표시)
 */
?>
<div id="kboard-calendar-list">

    <!-- 게시판 헤더 -->
    <div class="kboard-list-header">
        <?php if (!$board->isPrivate()): ?>
            <div class="kboard-total-count">
                <?php echo __('Total', 'kboard') ?>     <?php echo number_format($board->getListTotal()) ?>
            </div>
        <?php endif ?>
    </div>

    <!-- 카테고리 -->
    <?php
    if ($board->use_category == 'yes') {
        $category_type = $board->isTreeCategoryActive() ? 'tree-select' : 'default';
        $category_type = apply_filters('kboard_skin_category_type', $category_type, $board, $boardBuilder);
        echo $skin->load($board->skin, "list-category-{$category_type}.php", $vars);
    }
    ?>

    <!-- 일정 목록 -->
    <ul class="kboard-calendar-schedule-list">
        <?php
        $list_index = 0;
        while ($content = $list->hasNext()):
            $list_index++;
            $event_date     = $content->option->event_date     ?? '';
            $event_end_date = $content->option->event_end_date ?? '';
            $display_date   = '';
            if ($event_date) {
                $ts_s = strtotime($event_date);
                if ($ts_s) {
                    if ($event_end_date && $event_end_date !== $event_date) {
                        $ts_e = strtotime($event_end_date);
                        $display_date = $ts_e
                            ? date('m.d', $ts_s) . '~' . date('m.d', $ts_e)
                            : date('m.d', $ts_s);
                    } else {
                        $display_date = date('m.d', $ts_s);
                    }
                } else {
                    $display_date = $event_date;
                }
            }
            ?>
            <li class="kboard-calendar-item">
                <a href="<?php echo esc_url($url->getDocumentURLWithUID($content->uid)) ?>" class="kboard-calendar-link">
                    <div class="kboard-calendar-date-col">
                        <span class="kboard-calendar-date"><?php echo esc_html($display_date ?: '--') ?></span>
                    </div>
                    <div class="kboard-calendar-info-col">
                        <span class="kboard-calendar-title"><?php echo esc_html($content->title) ?></span>
                        <?php if ($content->isNew()): ?>
                            <span class="kboard-calendar-new">NEW</span>
                        <?php endif; ?>
                    </div>
                </a>
            </li>
        <?php endwhile; ?>
        <?php if ($list_index == 0): ?>
            <li class="kboard-calendar-empty">등록된 일정이 없습니다.</li>
        <?php endif; ?>
    </ul>

    <!-- 페이징 -->
    <div class="kboard-pagination">
        <ul class="kboard-pagination-pages">
            <?php echo kboard_pagination($list->page, $list->total, $list->rpp) ?>
        </ul>
    </div>

    <!-- 검색 -->
    <div class="kboard-search">
        <form id="kboard-search-form-<?php echo $board->id ?>" method="get"
            action="<?php echo esc_url($url->toString()) ?>">
            <?php echo $url->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput() ?>
            <select name="target">
                <option value=""><?php echo __('All', 'kboard') ?></option>
                <option value="title" <?php if (kboard_target() == 'title'): ?>selected<?php endif ?>>
                    <?php echo __('Title', 'kboard') ?>
                </option>
            </select>
            <input type="text" name="keyword" value="<?php echo esc_attr(kboard_keyword()) ?>">
            <button type="submit" class="kboard-thumbnail-button-small"><?php echo __('Search', 'kboard') ?></button>
        </form>
    </div>

    <!-- 쓰기 버튼 -->
    <?php if ($board->isWriter()): ?>
        <div class="kboard-control">
            <a href="<?php echo esc_url($url->getContentEditor()) ?>" class="kboard-thumbnail-button-small">
                <?php echo __('New', 'kboard') ?>
            </a>
        </div>
    <?php endif ?>

    <?php if ($board->contribution()): ?>
        <div class="kboard-thumbnail-poweredby">
            <a href="https://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href);return false;"
                title="KBoard">Powered by KBoard</a>
        </div>
    <?php endif ?>
</div>