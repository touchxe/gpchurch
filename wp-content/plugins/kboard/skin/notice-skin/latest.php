<?php
/**
 * KBoard Notice Skin - latest.php
 * 교회알림 > 공지사항 칸에 사용되는 최신글 모아보기 스킨
 *   - 왼쪽: 날짜 (큰 숫자 일 + 년-월)
 *   - 오른쪽: 제목 + NEW 뱃지 (카테고리 없음)
 */
?>
<div id="kboard-notice-latest">
    <ul class="kboard-notice-list">
        <?php
        $list_index = 0;
        while ($content = $list->hasNext()):
            $list_index++;

            // $content->date = DB 원본값 "2026-02-28 13:45:00"
            // getDate()는 오늘 글이면 "13:45"(H:i) 반환 → date_create 실패 → 빈 값
            // 반드시 $content->date 원본으로 파싱
            $ts = strtotime($content->date);
            $day = $ts ? date('d', $ts) : '';
            $yearmon = $ts ? date('Y-m', $ts) : '';
            ?>
            <li class="kboard-notice-item">
                <a href="<?php echo esc_url($url->getDocumentURLWithUID($content->uid)) ?>" class="kboard-notice-link">
                    <div class="kboard-notice-date">
                        <span class="kboard-notice-day"><?php echo esc_html($day) ?></span>
                        <span class="kboard-notice-month"><?php echo esc_html($yearmon) ?></span>
                    </div>
                    <div class="kboard-notice-content">
                        <span class="kboard-notice-title"><?php echo esc_html($content->title) ?></span>
                        <?php if ($content->isNew()): ?>
                            <span class="kboard-notice-new">NEW</span>
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