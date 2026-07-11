<?php
/**
 * 순서지 만들기 (Split View)
 *
 * @package GPC_Bulletin_Manager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 기존 데이터 컬럼 로드
$columns = GPC_Bulletin_DB::get_data_columns();
$labels  = GPC_Bulletin_DB::get_column_labels();
$text_cols = GPC_Bulletin_DB::get_text_columns();
?>
<div class="wrap gpc-bulletin-wrap">
    <h1><span class="dashicons dashicons-welcome-write-blog" style="font-size: 28px; width: 30px; height: 30px; margin-right: 5px;"></span> 순서지 만들기</h1>
    <p>날짜를 선택하면 사업계획서의 내용이 자동으로 채워집니다. 빈칸을 수정하고 우측 미리보기를 확인하세요.</p>

    <div class="gpc-split-view">
        <!-- 좌측 폼 영역 -->
        <div class="gpc-form-panel">
            <form id="gpc-bulletin-create-form">
                <input type="hidden" name="action" value="gpc_bulletin_save_created">
                <?php wp_nonce_field( 'gpc_bulletin_nonce', 'nonce' ); ?>
                
                <table class="form-table gpc-form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="publish_date">발행 날짜 (안식일)</label></th>
                            <td>
                                <input type="date" name="publish_date" id="publish_date" class="regular-text" required>
                                <button type="button" id="btn-load-plan" class="button button-secondary">사업계획서 불러오기</button>
                                <span class="description">날짜를 선택하고 불러오기를 누르세요.</span>
                            </td>
                        </tr>
                        <?php foreach ( $columns as $col ) :
                            if ( $col === 'publish_date' || $col === 'image_url' || $col === 'notice_post_id' || $col === 'bulletin_post_id' ) {
                                continue;
                            }
                            $label = isset( $labels[ $col ] ) ? $labels[ $col ] : $col;
                            $is_text = in_array( $col, $text_cols, true );
                        ?>
                        <tr>
                            <th scope="row"><label for="<?php echo esc_attr( $col ); ?>"><?php echo esc_html( $label ); ?></label></th>
                            <td>
                                <?php if ( $is_text ) : ?>
                                    <textarea name="<?php echo esc_attr( $col ); ?>" id="<?php echo esc_attr( $col ); ?>" rows="4" class="large-text gpc-preview-trigger"></textarea>
                                <?php else : ?>
                                    <input type="text" name="<?php echo esc_attr( $col ); ?>" id="<?php echo esc_attr( $col ); ?>" class="regular-text gpc-preview-trigger">
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="submit">
                    <button type="button" id="btn-save-bulletin" class="button button-primary button-large">저장 및 웹 발행</button>
                    <button type="button" id="btn-download-pdf" class="button button-secondary button-large">PDF 인쇄본 다운로드</button>
                </p>
            </form>
        </div>

        <!-- 우측 미리보기 영역 -->
        <div class="gpc-preview-panel">
            <div class="gpc-preview-header">
                <h3>실시간 미리보기</h3>
                <span class="description">A4 가로 3단 접지 템플릿</span>
            </div>
            <div class="gpc-preview-container" id="gpc-preview-container">
                <?php include GPC_BULLETIN_DIR . 'admin-views/template-classic.php'; ?>
            </div>
        </div>
    </div>
</div>
