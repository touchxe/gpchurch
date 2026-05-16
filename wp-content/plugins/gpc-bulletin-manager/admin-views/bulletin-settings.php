<?php
/**
 * 관리자 뷰: API 설정 페이지
 *
 * API URL, API Key, 모델명 입력 및 연결 테스트 UI
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$settings = GPC_Bulletin_AI_Extractor::get_settings();
?>
<div class="wrap gpc-bulletin-wrap">
    <h1 class="gpc-bulletin-title">⚙️ AI API 설정</h1>
    <p class="gpc-bulletin-desc">순서지 이미지에서 데이터를 추출할 AI API를 설정합니다.</p>

    <div class="gpc-settings-card">
        <div class="gpc-settings-form">
            <div class="gpc-field-group">
                <label for="gpc-api-url">API URL</label>
                <input type="url" id="gpc-api-url" class="gpc-input"
                       value="<?php echo esc_attr( $settings['api_url'] ); ?>"
                       placeholder="https://api.minimax.io/v1/chat/completions">
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
                       placeholder="MiniMax-M2.5">
                <span class="gpc-field-hint">사용할 AI 모델명을 입력하세요.</span>
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
</div>
