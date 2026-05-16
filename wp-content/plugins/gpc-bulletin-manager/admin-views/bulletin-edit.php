<?php
/**
 * 관리자 뷰: 순서지 상세 보기 / 수정 페이지
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$db   = new GPC_Bulletin_DB();
$id   = isset( $_GET['id'] ) ? (int) $_GET['id'] : 0;
$item = $db->get_by_id( $id );

if ( ! $item ) {
    echo '<div class="wrap"><p>순서지를 찾을 수 없습니다.</p></div>';
    return;
}

$labels         = GPC_Bulletin_DB::get_column_labels();
$text_columns   = GPC_Bulletin_DB::get_text_columns();
$notice_post_id = (int) ( $item->notice_post_id ?? 0 );
$kboard_id      = (int) get_option( 'gpc_bulletin_kboard_id', 0 );
?>
<div class="wrap gpc-bulletin-wrap">
    <h1 class="gpc-bulletin-title">
        ✏️ 순서지 수정
        <span class="gpc-title-date"><?php echo esc_html( $item->publish_date ); ?></span>
    </h1>

    <a href="<?php echo admin_url( 'admin.php?page=gpc-bulletin' ); ?>" class="gpc-btn gpc-btn-secondary gpc-btn-sm">
        ← 목록으로
    </a>

    <?php if ( ! empty( $item->image_url ) ) : ?>
    <div class="gpc-edit-image">
        <img src="<?php echo esc_url( $item->image_url ); ?>" alt="순서지 원본 이미지" class="gpc-edit-thumbnail">
    </div>
    <?php endif; ?>

    <div id="gpc-data-form" class="gpc-data-form" style="display:block">
        <input type="hidden" id="gpc-bulletin-id" value="<?php echo $item->id; ?>">

        <!-- 기본 정보 -->
        <div class="gpc-form-section">
            <h3 class="gpc-form-section-title">📅 기본 정보</h3>
            <div class="gpc-form-grid">
                <div class="gpc-field-group">
                    <label for="gpc-field-publish_date"><?php echo esc_html( $labels['publish_date'] ); ?></label>
                    <input type="date" id="gpc-field-publish_date" name="publish_date" class="gpc-input"
                           value="<?php echo esc_attr( $item->publish_date ); ?>" required>
                </div>
                <div class="gpc-field-group">
                    <label for="gpc-field-sabbath_type"><?php echo esc_html( $labels['sabbath_type'] ); ?></label>
                    <input type="text" id="gpc-field-sabbath_type" name="sabbath_type" class="gpc-input"
                           value="<?php echo esc_attr( $item->sabbath_type ); ?>">
                </div>
                <div class="gpc-field-group">
                    <label for="gpc-field-sunset_time"><?php echo esc_html( $labels['sunset_time'] ); ?></label>
                    <input type="text" id="gpc-field-sunset_time" name="sunset_time" class="gpc-input"
                           value="<?php echo esc_attr( $item->sunset_time ); ?>">
                </div>
            </div>
        </div>

        <!-- 안식일 학교 -->
        <div class="gpc-form-section gpc-section-ss">
            <h3 class="gpc-form-section-title">🏫 안식일 학교</h3>
            <div class="gpc-form-grid">
                <?php
                $ss_fields = array( 'ss_host', 'ss_hymn', 'ss_prayer', 'ss_welcome', 'ss_special_song', 'ss_special_order', 'ss_lesson_title' );
                foreach ( $ss_fields as $field ) :
                ?>
                <div class="gpc-field-group">
                    <label for="gpc-field-<?php echo $field; ?>"><?php echo esc_html( $labels[ $field ] ); ?></label>
                    <input type="text" id="gpc-field-<?php echo $field; ?>" name="<?php echo $field; ?>" class="gpc-input"
                           value="<?php echo esc_attr( $item->$field ); ?>">
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 안식일 예배 -->
        <div class="gpc-form-section gpc-section-ws">
            <h3 class="gpc-form-section-title">⛪ 안식일 예배</h3>
            <div class="gpc-form-grid">
                <?php
                $ws_fields = array( 'ws_host', 'ws_doxology', 'ws_invocation', 'ws_responsive_reading', 'ws_hymn', 'ws_prayer', 'ws_offering_leader', 'ws_offering_hymn', 'ws_offering_benediction', 'ws_special_song', 'ws_sermon_title', 'ws_preacher', 'ws_bible_text', 'ws_closing_hymn', 'ws_benediction' );
                foreach ( $ws_fields as $field ) :
                ?>
                <div class="gpc-field-group<?php echo in_array( $field, array( 'ws_sermon_title', 'ws_bible_text' ) ) ? ' gpc-field-wide' : ''; ?>">
                    <label for="gpc-field-<?php echo $field; ?>"><?php echo esc_html( $labels[ $field ] ); ?></label>
                    <input type="text" id="gpc-field-<?php echo $field; ?>" name="<?php echo $field; ?>" class="gpc-input"
                           value="<?php echo esc_attr( $item->$field ); ?>">
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 교회 소식 / 봉사 -->
        <div class="gpc-form-section gpc-section-info">
            <div class="gpc-form-section-header">
                <h3 class="gpc-form-section-title">📢 교회 소식 및 봉사</h3>
                <div class="gpc-publish-actions">
                    <?php if ( $notice_post_id > 0 ) : ?>
                        <span class="gpc-published-badge">✅ 발행됨</span>
                    <?php endif; ?>
                    <button type="button" id="gpc-publish-notice-btn"
                            class="gpc-btn <?php echo $notice_post_id > 0 ? 'gpc-btn-secondary' : 'gpc-btn-success'; ?>"
                            data-bulletin-id="<?php echo $item->id; ?>"
                            data-notice-post-id="<?php echo $notice_post_id; ?>"
                            <?php echo $kboard_id <= 0 ? 'title="설정 페이지에서 KBoard 게시판 ID를 먼저 설정해주세요."' : ''; ?>>
                        <?php echo $notice_post_id > 0 ? '🔄 공지사항 업데이트' : '📢 공지사항에 발행'; ?>
                    </button>
                </div>
            </div>
            <div class="gpc-form-grid gpc-form-grid-full">
                <?php foreach ( $text_columns as $field ) : ?>
                <div class="gpc-field-group gpc-field-full">
                    <label for="gpc-field-<?php echo $field; ?>"><?php echo esc_html( $labels[ $field ] ); ?></label>
                    <textarea id="gpc-field-<?php echo $field; ?>" name="<?php echo $field; ?>"
                              class="gpc-input gpc-textarea" rows="4"><?php echo esc_textarea( $item->$field ); ?></textarea>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <input type="hidden" id="gpc-field-image_url" name="image_url"
               value="<?php echo esc_attr( $item->image_url ); ?>">

        <!-- 저장 버튼 -->
        <div class="gpc-form-actions">
            <button type="button" id="gpc-save-btn" class="gpc-btn gpc-btn-primary gpc-btn-lg">
                💾 수정 저장
            </button>
            <a href="<?php echo admin_url( 'admin.php?page=gpc-bulletin' ); ?>" class="gpc-btn gpc-btn-secondary">
                취소
            </a>
            <button type="button" class="gpc-btn gpc-btn-danger gpc-delete-btn" data-id="<?php echo $item->id; ?>">
                🗑 삭제
            </button>
        </div>

        <div id="gpc-save-notice" class="gpc-notice" style="display:none"></div>
    </div>
</div>

<!-- 공지사항 발행 모달 -->
<div id="gpc-publish-modal" class="gpc-modal" style="display:none"
     data-publish-date="<?php echo esc_attr( $item->publish_date ); ?>"
     data-sermon-title="<?php echo esc_attr( $item->ws_sermon_title ); ?>"
     data-preacher="<?php echo esc_attr( $item->ws_preacher ); ?>"
     data-bible-text="<?php echo esc_attr( $item->ws_bible_text ); ?>"
     data-sunset-time="<?php echo esc_attr( $item->sunset_time ); ?>"
     data-church-news="<?php echo esc_attr( $item->church_news ); ?>"
     data-prayer-requests="<?php echo esc_attr( $item->prayer_requests ); ?>"
     data-service-this-week="<?php echo esc_attr( $item->service_this_week ); ?>"
     data-service-next-week="<?php echo esc_attr( $item->service_next_week ); ?>"
     data-memory-verse="<?php echo esc_attr( $item->memory_verse ); ?>"
     data-announcements="<?php echo esc_attr( $item->announcements ); ?>"
     data-offering-list="<?php echo esc_attr( $item->offering_list ); ?>">
    <div class="gpc-modal-overlay" id="gpc-modal-overlay"></div>
    <div class="gpc-modal-box">
        <div class="gpc-modal-header">
            <h2 class="gpc-modal-title">📢 공지사항 발행 미리보기</h2>
            <button type="button" class="gpc-modal-close" id="gpc-modal-close">✕</button>
        </div>
        <div class="gpc-modal-body">
            <p class="gpc-modal-desc">내용을 확인하고 필요하면 수정 후 발행하세요.</p>
            <div class="gpc-field-group">
                <label for="gpc-publish-title">제목</label>
                <input type="text" id="gpc-publish-title" class="gpc-input">
            </div>
            <div class="gpc-field-group" style="margin-top:12px">
                <label for="gpc-publish-content">내용</label>
                <textarea id="gpc-publish-content" class="gpc-input gpc-textarea" rows="18"></textarea>
            </div>
        </div>
        <div class="gpc-modal-footer">
            <button type="button" id="gpc-publish-confirm" class="gpc-btn gpc-btn-primary gpc-btn-lg">
                ✅ 발행
            </button>
            <button type="button" id="gpc-publish-cancel" class="gpc-btn gpc-btn-secondary">
                취소
            </button>
            <div id="gpc-publish-result" class="gpc-notice" style="display:none;margin-top:12px"></div>
        </div>
    </div>
</div>
