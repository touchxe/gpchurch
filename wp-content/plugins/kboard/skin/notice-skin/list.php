<?php
/**
 * KBoard Notice Skin - list.php
 * 공지사항 게시판 목록 뷰 (게시판 페이지에서 전체 목록 표시 시 사용)
 * gallary-skin의 list.php 기반으로 단순화
 */
?>
<div id="kboard-thumbnail-list">

    <!-- 게시판 정보 시작 -->
    <div class="kboard-list-header">
        <?php if (!$board->isPrivate()): ?>
            <div class="kboard-total-count">
                <?php echo __('Total', 'kboard') ?>
                <?php echo number_format($board->getListTotal()) ?>
            </div>
        <?php endif ?>

        <div class="kboard-sort">
            <form id="kboard-sort-form-<?php echo $board->id ?>" method="get"
                action="<?php echo esc_url($url->toString()) ?>">
                <?php echo $url->set('pageid', '1')->set('category1', '')->set('category2', '')->set('target', '')->set('keyword', '')->set('mod', 'list')->set('kboard_list_sort_remember', $board->id)->toInput() ?>
                <select name="kboard_list_sort"
                    onchange="jQuery('#kboard-sort-form-<?php echo $board->id ?>').submit();">
                    <option value="newest" <?php if ($list->getSorting() == 'newest'): ?>selected
                        <?php endif ?>>
                        <?php echo __('Newest', 'kboard') ?>
                    </option>
                    <option value="best" <?php if ($list->getSorting() == 'best'): ?>selected
                        <?php endif ?>>
                        <?php echo __('Best', 'kboard') ?>
                    </option>
                </select>
            </form>
        </div>
    </div>
    <!-- 게시판 정보 끝 -->

    <!-- 카테고리 시작 -->
    <?php
    if ($board->use_category == 'yes') {
        if ($board->isTreeCategoryActive()) {
            $category_type = 'tree-select';
        } else {
            $category_type = 'default';
        }
        $category_type = apply_filters('kboard_skin_category_type', $category_type, $board, $boardBuilder);
        echo $skin->load($board->skin, "list-category-{$category_type}.php", $vars);
    }
    ?>
    <!-- 카테고리 끝 -->

    <!-- 리스트 시작 -->
    <div id="kboard-notice-latest" style="margin: 0; padding: 0;">
        <ul class="kboard-notice-list">
            <?php
            $list_index = 0;
            while ($content = $list->hasNext()):
                $list_index++;
                $raw_date = $content->getDate();
                $date_obj = date_create($raw_date);
                $day = $date_obj ? date_format($date_obj, 'd') : '';
                $yearmon = $date_obj ? date_format($date_obj, 'Y-m') : $raw_date;
                ?>
                <li class="kboard-notice-item">
                    <a href="<?php echo esc_url($url->getDocumentURLWithUID($content->uid)) ?>" class="kboard-notice-link">
                        <div class="kboard-notice-date">
                            <span class="kboard-notice-day">
                                <?php echo esc_html($day) ?>
                            </span>
                            <span class="kboard-notice-month">
                                <?php echo esc_html($yearmon) ?>
                            </span>
                        </div>
                        <div class="kboard-notice-content">
                            <?php if ($content->category1): ?>
                                <span class="kboard-notice-tag">
                                    <?php echo esc_html($content->category1) ?>
                                </span>
                            <?php endif; ?>
                            <span class="kboard-notice-title">
                                <?php echo esc_html($content->title) ?>
                            </span>
                            <?php if ($content->isNew()): ?><span class="kboard-notice-new">NEW</span>
                            <?php endif; ?>
                        </div>
                    </a>
                </li>
            <?php endwhile; ?>
            <?php if ($list_index == 0): ?>
                <li class="kboard-notice-empty">
                    <?php echo __('등록된 공지사항이 없습니다.', 'kboard') ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <!-- 리스트 끝 -->

    <!-- 페이징 시작 -->
    <div class="kboard-pagination">
        <ul class="kboard-pagination-pages">
            <?php echo kboard_pagination($list->page, $list->total, $list->rpp) ?>
        </ul>
    </div>
    <!-- 페이징 끝 -->

    <!-- 검색폼 시작 -->
    <div class="kboard-search">
        <form id="kboard-search-form-<?php echo $board->id ?>" method="get"
            action="<?php echo esc_url($url->toString()) ?>">
            <?php echo $url->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput() ?>
            <select name="target">
                <option value="">
                    <?php echo __('All', 'kboard') ?>
                </option>
                <option value="title" <?php if (kboard_target() == 'title'): ?>selected
                    <?php endif ?>>
                    <?php echo __('Title', 'kboard') ?>
                </option>
                <option value="content" <?php if (kboard_target() == 'content'): ?>selected
                    <?php endif ?>>
                    <?php echo __('Content', 'kboard') ?>
                </option>
                <option value="member_display" <?php if (kboard_target() == 'member_display'): ?>selected
                    <?php endif ?>>
                    <?php echo __('Author', 'kboard') ?>
                </option>
            </select>
            <input type="text" name="keyword" value="<?php echo esc_attr(kboard_keyword()) ?>">
            <button type="submit" class="kboard-thumbnail-button-small">
                <?php echo __('Search', 'kboard') ?>
            </button>
        </form>
    </div>
    <!-- 검색폼 끝 -->

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
                title="<?php echo __('KBoard is the best community software available for WordPress', 'kboard') ?>">Powered
                by KBoard</a>
        </div>
    <?php endif ?>
</div>