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
$notice_prompt = get_option( 'gpc_bulletin_notice_prompt', '' );
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
            순서지에서 공지사항을 발행할 KBoard 게시판 ID와<br>
            AI가 공지 글을 작성할 때 사용할 프롬프트를 설정합니다.
        </p>
        <div class="gpc-settings-form">

            <!-- 게시판 ID -->
            <div class="gpc-field-group">
                <label for="gpc-kboard-id">공지사항 게시판 ID</label>
                <input type="number" id="gpc-kboard-id" class="gpc-input" style="max-width:200px"
                       value="<?php echo esc_attr( $kboard_id ?: '' ); ?>"
                       placeholder="예: 1" min="1">
                <span class="gpc-field-hint">KBoard 관리자 → 게시판 목록에서 확인한 게시판 ID (숫자)를 입력하세요.</span>
            </div>

            <div class="gpc-settings-actions">
                <button type="button" id="gpc-save-kboard-id" class="gpc-btn gpc-btn-primary">
                    💾 게시판 ID 저장
                </button>
            </div>

            <div id="gpc-kboard-save-status" class="gpc-connection-status" style="display:none;">
                <div class="gpc-status-badge">
                    <span class="gpc-status-text"></span>
                </div>
            </div>

            <hr style="margin: 24px 0; border: none; border-top: 1px solid #e2e8f0;">

            <!-- AI 글 작성 프롬프트 -->
            <div class="gpc-field-group">
                <label for="gpc-notice-prompt">📝 AI 공지 작성 프롬프트</label>
                <textarea id="gpc-notice-prompt" class="gpc-input gpc-textarea" rows="6"
                          placeholder="예: 아래 데이터를 바탕으로 교회 성도들에게 전달하는 주간 소식을 따뜻하고 친근한 문체로 작성해줘. 제목은 넣지 말고, 섹션별로 이모지를 사용해서 정리해줘."><?php echo esc_textarea( $notice_prompt ); ?></textarea>
                <span class="gpc-field-hint">
                    AI가 공지사항 내용을 생성할 때 사용할 지시문입니다. 비워두면 기본 프롬프트를 사용합니다.<br>
                    순서지 데이터(설교 제목, 교회 소식, 봉사 일정 등)는 자동으로 첨부됩니다.
                </span>
            </div>

            <div class="gpc-settings-actions">
                <button type="button" id="gpc-save-notice-prompt" class="gpc-btn gpc-btn-primary">
                    💾 프롬프트 저장
                </button>
            </div>

            <div id="gpc-prompt-save-status" class="gpc-connection-status" style="display:none;">
                <div class="gpc-status-badge">
                    <span class="gpc-status-text"></span>
                </div>
            </div>

        </div>
    </div>
</div>
