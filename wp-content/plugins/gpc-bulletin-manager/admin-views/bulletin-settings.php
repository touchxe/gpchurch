<?php
/**
 * 관리자 뷰: API 설정 페이지
 *
 * API URL, API Key, 모델명 입력 및 연결 테스트 UI
 * 공지사항 발행용 KBoard 게시판 ID 설정
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$settings      = GPC_Bulletin_AI_Extractor::get_settings();
$kboard_id     = (int) get_option( 'gpc_bulletin_kboard_id', 0 );
?>
<div class="wrap gpc-bulletin-wrap">
    <h1 class="gpc-bulletin-title">⚙️ 설정</h1>
    <p class="gpc-bulletin-desc">순서지 AI 추출 API 및 공지사항 발행 설정을 관리합니다.</p>

    <!-- AI API 설정 -->
    <div class="gpc-settings-card">
        <h2 class="gpc-settings-card-title">🤖 AI API 설정</h2>
        <p class="gpc-settings-card-desc">순서지 이미지에서 데이터를 추출할 AI API를 설정합니다.</p>
        <div class="gpc-settings-form">
            <div class="gpc-field-group">
                <label for="gpc-api-url">API URL</label>
                <input type="url" id="gpc-api-url" class="gpc-input"
                       value="<?php echo esc_attr( $settings['api_url'] ); ?>"
                       placeholder="https://generativelanguage.googleapis.com/v1beta/openai/chat/completions">
                <span class="gpc-field-hint">OpenAI 호환 API 엔드포인트를 입력하세요.</span>
            </div>

            <div class="gpc-field-group">
                <label for="gpc-api-key">API Key</label>
                <div class="gpc-key-input-wrap">
                    <input type="password" id="gpc-api-key" class="gpc-input"
                           value="<?php echo esc_attr( $settings['api_key'] ); ?>"
                           placeholder="sk-xxxxxxxxxxxxxxxx">
                    <button type="button" id="gpc-toggle-key" class="gpc-btn-icon" title="키 보기/숨기기">👁</button>
                </div>
            </div>

            <div class="gpc-field-group">
                <label for="gpc-model">모델명</label>
                <input type="text" id="gpc-model" class="gpc-input"
                       value="<?php echo esc_attr( $settings['model'] ); ?>"
                       placeholder="gemini-2.5-pro">
                <span class="gpc-field-hint">사용할 AI 모델명을 입력하세요. (예: gemini-2.5-pro, gemini-2.5-flash)</span>
            </div>

            <div class="gpc-settings-actions">
                <button type="button" id="gpc-save-settings" class="gpc-btn gpc-btn-primary">
                    💾 저장
                </button>
                <button type="button" id="gpc-test-connection" class="gpc-btn gpc-btn-secondary">
                    🔌 연결 테스트
                </button>
            </div>

            <div id="gpc-connection-status" class="gpc-connection-status" style="display:none;">
                <div class="gpc-status-badge">
                    <span class="gpc-status-icon"></span>
                    <span class="gpc-status-text"></span>
                </div>
                <span class="gpc-status-time"></span>
            </div>
        </div>
    </div>

    <!-- 공지사항 발행 설정 -->
    <div class="gpc-settings-card" style="margin-top: 24px;">
        <h2 class="gpc-settings-card-title">📢 공지사항 발행 설정</h2>
        <p class="gpc-settings-card-desc">
            순서지에서 공지사항을 발행할 KBoard 게시판 ID를 설정합니다.<br>
            게시판 ID는 <strong>KBoard → 게시판 목록</strong>에서 확인할 수 있습니다.
        </p>
        <div class="gpc-settings-form">
            <div class="gpc-field-group">
                <label for="gpc-kboard-id">공지사항 게시판 ID</label>
                <input type="number" id="gpc-kboard-id" class="gpc-input" style="max-width:200px"
                       value="<?php echo esc_attr( $kboard_id ?: '' ); ?>"
                       placeholder="예: 3" min="1">
                <span class="gpc-field-hint">KBoard 관리자 → 게시판 목록에서 확인한 게시판 ID (숫자)를 입력하세요.</span>
            </div>

            <div class="gpc-settings-actions">
                <button type="button" id="gpc-save-kboard-id" class="gpc-btn gpc-btn-primary">
                    💾 저장
                </button>
            </div>

            <div id="gpc-kboard-save-status" class="gpc-connection-status" style="display:none;">
                <div class="gpc-status-badge">
                    <span class="gpc-status-text"></span>
                </div>
            </div>
        </div>
    </div>
</div>
