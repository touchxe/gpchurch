<?php
/**
 * 관리자 뷰: 새 순서지 업로드 & AI 추출 페이지
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$labels       = GPC_Bulletin_DB::get_column_labels();
$text_columns = GPC_Bulletin_DB::get_text_columns();
$columns      = GPC_Bulletin_DB::get_data_columns();
?>
<div class="wrap gpc-bulletin-wrap">
    <h1 class="gpc-bulletin-title">📸 새 순서지 업로드</h1>
    <p class="gpc-bulletin-desc">순서지 이미지를 업로드하면 AI가 자동으로 데이터를 추출합니다.</p>

    <!-- 이미지 업로드 영역 -->
    <div class="gpc-upload-card">
        <div id="gpc-dropzone" class="gpc-dropzone">
            <div class="gpc-dropzone-content">
                <div class="gpc-dropzone-icon">📷</div>
                <p class="gpc-dropzone-text">클릭하여 이미지 선택, 드래그앤드롭, 또는 Ctrl+V로 붙여넣기</p>
                <p class="gpc-dropzone-hint">JPG, PNG 파일 지원</p>
            </div>
            <input type="file" id="gpc-file-input" accept="image/*" style="display:none">
        </div>

        <div id="gpc-preview" class="gpc-preview" style="display:none">
            <img id="gpc-preview-img" src="" alt="순서지 미리보기">
            <button type="button" id="gpc-remove-image" class="gpc-btn-icon" title="이미지 제거">✕</button>
        </div>

        <div class="gpc-upload-actions">
            <button type="button" id="gpc-extract-btn" class="gpc-btn gpc-btn-primary gpc-btn-lg" disabled>
                🤖 AI로 데이터 추출하기
            </button>
        </div>

        <div id="gpc-extract-progress" class="gpc-progress" style="display:none">
            <div class="gpc-progress-bar"></div>
            <span class="gpc-progress-text">AI가 순서지를 분석 중입니다...</span>
        </div>

        <div id="gpc-extract-error" class="gpc-notice gpc-notice-error" style="display:none"></div>
    </div>

    <!-- 추출된 데이터 편집 폼 -->
    <div id="gpc-data-form" class="gpc-data-form" style="display:none">
        <h2 class="gpc-section-title">📝 추출된 데이터 확인 및 수정</h2>

        <input type="hidden" id="gpc-bulletin-id" value="0">

        <!-- 기본 정보 -->
        <div class="gpc-form-section">
            <h3 class="gpc-form-section-title">📅 기본 정보</h3>
            <div class="gpc-form-grid">
                <div class="gpc-field-group">
                    <label for="gpc-field-publish_date"><?php echo esc_html( $labels['publish_date'] ); ?></label>
                    <input type="date" id="gpc-field-publish_date" name="publish_date" class="gpc-input" required>
                </div>
                <div class="gpc-field-group">
                    <label for="gpc-field-sabbath_type"><?php echo esc_html( $labels['sabbath_type'] ); ?></label>
                    <input type="text" id="gpc-field-sabbath_type" name="sabbath_type" class="gpc-input">
                </div>
                <div class="gpc-field-group">
                    <label for="gpc-field-sunset_time"><?php echo esc_html( $labels['sunset_time'] ); ?></label>
                    <input type="text" id="gpc-field-sunset_time" name="sunset_time" class="gpc-input">
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
                    <input type="text" id="gpc-field-<?php echo $field; ?>" name="<?php echo $field; ?>" class="gpc-input">
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
                    <input type="text" id="gpc-field-<?php echo $field; ?>" name="<?php echo $field; ?>" class="gpc-input">
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 교회 소식 / 봉사 -->
        <div class="gpc-form-section gpc-section-info">
            <h3 class="gpc-form-section-title">📢 교회 소식 및 봉사</h3>
            <div class="gpc-form-grid gpc-form-grid-full">
                <?php foreach ( $text_columns as $field ) : ?>
                <div class="gpc-field-group gpc-field-full">
                    <label for="gpc-field-<?php echo $field; ?>"><?php echo esc_html( $labels[ $field ] ); ?></label>
                    <textarea id="gpc-field-<?php echo $field; ?>" name="<?php echo $field; ?>"
                              class="gpc-input gpc-textarea" rows="4"></textarea>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 이미지 URL (숨김) -->
        <input type="hidden" id="gpc-field-image_url" name="image_url" value="">

        <!-- 저장 버튼 -->
        <div class="gpc-form-actions">
            <button type="button" id="gpc-save-btn" class="gpc-btn gpc-btn-primary gpc-btn-lg">
                💾 저장
            </button>
            <a href="<?php echo admin_url( 'admin.php?page=gpc-bulletin' ); ?>" class="gpc-btn gpc-btn-secondary">
                취소
            </a>
        </div>

        <div id="gpc-save-notice" class="gpc-notice" style="display:none"></div>
    </div>
</div>
