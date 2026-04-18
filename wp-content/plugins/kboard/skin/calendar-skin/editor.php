<?php
/**
 * KBoard Calendar Skin - editor.php
 * 교회일정 게시판 글쓰기 에디터
 *
 * ── 날짜 필드 설정 방법 ──────────────────────────────────────
 * KBoard 관리자 → 게시판(ID 3) → 수정 → 글쓰기 필드 탭에서
 * "날짜 선택(Date Select)" 필드를 추가하고
 * 옵션키(meta_key)를 "event_date" 로 설정하면
 * REST API(/wp-json/gapyeong/v1/schedule)와 자동 연동됩니다.
 * ─────────────────────────────────────────────────────────────
 */

// jQuery UI Datepicker 강제 로드 (KBoard date 필드 타입에 필요)
wp_enqueue_style('kboard-jquery-flick-style');
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_script('kboard-field-date');
?>
<div id="kboard-thumbnail-editor">
	<form class="kboard-form" method="post" action="<?php echo esc_url($url->getContentEditorExecute()) ?>"
		enctype="multipart/form-data" onsubmit="return kboard_editor_execute(this);">
		<?php $skin->editorHeader($content, $board) ?>

		<?php foreach ($board->fields()->getSkinFields() as $key => $field): ?>
			<?php echo $board->fields()->getTemplate($field, $content, $boardBuilder) ?>
		<?php endforeach ?>

		<div class="kboard-control">
			<div class="left">
				<?php if ($content->uid): ?>
					<a href="<?php echo esc_url($url->getDocumentURLWithUID($content->uid)) ?>"
						class="kboard-thumbnail-button-small"><?php echo __('Back', 'kboard') ?></a>
					<a href="<?php echo esc_url($url->getBoardList()) ?>"
						class="kboard-thumbnail-button-small"><?php echo __('List', 'kboard') ?></a>
				<?php else: ?>
					<a href="<?php echo esc_url($url->getBoardList()) ?>"
						class="kboard-thumbnail-button-small"><?php echo __('Back', 'kboard') ?></a>
				<?php endif ?>
			</div>
			<div class="right">
				<?php if ($board->isWriter()): ?>
					<button type="submit" class="kboard-thumbnail-button-small"><?php echo __('Save', 'kboard') ?></button>
				<?php endif ?>
			</div>
		</div>
	</form>
</div>

<?php wp_enqueue_script('kboard-thumbnail-script', "{$skin_path}/script.js", array(), KBOARD_VERSION, true) ?>