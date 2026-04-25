<div id="kboard-thumbnail-list">

	<!-- 게시판 정보 시작 -->
	<div class="kboard-list-header">
		<?php if (!$board->isPrivate()): ?>
			<div class="kboard-total-count">
				<?php echo __('Total', 'kboard') ?> 	<?php echo number_format($board->getListTotal()) ?>
			</div>
		<?php endif ?>

		<div class="kboard-sort">
			<form id="kboard-sort-form-<?php echo $board->id ?>" method="get"
				action="<?php echo esc_url($url->toString()) ?>">
				<?php echo $url->set('pageid', '1')->set('category1', '')->set('category2', '')->set('target', '')->set('keyword', '')->set('mod', 'list')->set('kboard_list_sort_remember', $board->id)->toInput() ?>

				<select name="kboard_list_sort"
					onchange="jQuery('#kboard-sort-form-<?php echo $board->id ?>').submit();">
					<option value="newest" <?php if ($list->getSorting() == 'newest'): ?> selected<?php endif ?>>
						<?php echo __('Newest', 'kboard') ?></option>
					<option value="best" <?php if ($list->getSorting() == 'best'): ?> selected<?php endif ?>>
						<?php echo __('Best', 'kboard') ?></option>
					<option value="viewed" <?php if ($list->getSorting() == 'viewed'): ?> selected<?php endif ?>>
						<?php echo __('Viewed', 'kboard') ?></option>
					<option value="updated" <?php if ($list->getSorting() == 'updated'): ?> selected<?php endif ?>>
						<?php echo __('Updated', 'kboard') ?></option>
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
	<div class="kboard-gallery-container">
		<div class="kboard-gallery-side-list" style="width: 100%;">
			<?php
			$list_index = 0;
			while ($content = $list->hasNext()):
				$list_index++;
			?>
				<div class="side-list-item">
					<a href="<?php echo esc_url($url->getDocumentURLWithUID($content->uid)) ?>" class="side-link">
						<div class="side-thumbnail">
							<?php if ($content->getThumbnail(150, 100)): ?>
								<img src="<?php echo $content->getThumbnail(150, 100) ?>"
									alt="<?php echo esc_attr($content->title) ?>">
							<?php else: ?>
								<div class="no-image"><i class="icon-picture"></i></div>
							<?php endif ?>
						</div>
						<div class="side-content">
							<div class="side-category"><?php echo $content->category1 ?></div>
							<h3 class="side-title"><?php echo $content->title ?></h3>
							<div class="side-meta">
								<?php echo $content->getDate() ?> · <?php echo $content->getUserDisplay() ?>
							</div>
						</div>
					</a>
				</div>
			<?php endwhile; ?>
		</div> <!-- Close .kboard-gallery-side-list -->

		<?php if ($list_index == 0): ?>
			<div class="kboard-no-data">
				<?php echo __('No data.', 'kboard') ?>
			</div>
		<?php endif; ?>
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
				<option value=""><?php echo __('All', 'kboard') ?></option>
				<option value="title" <?php if (kboard_target() == 'title'): ?> selected<?php endif ?>>
					<?php echo __('Title', 'kboard') ?></option>
				<option value="content" <?php if (kboard_target() == 'content'): ?> selected<?php endif ?>>
					<?php echo __('Content', 'kboard') ?></option>
				<option value="member_display" <?php if (kboard_target() == 'member_display'): ?> selected<?php endif ?>>
					<?php echo __('Author', 'kboard') ?></option>
			</select>
			<input type="text" name="keyword" value="<?php echo esc_attr(kboard_keyword()) ?>">
			<button type="submit" class="kboard-thumbnail-button-small"><?php echo __('Search', 'kboard') ?></button>
		</form>
	</div>
	<!-- 검색폼 끝 -->

	<?php if ($board->isWriter()): ?>
		<!-- 버튼 시작 -->
		<div class="kboard-control">
			<a href="<?php echo esc_url($url->getContentEditor()) ?>"
				class="kboard-thumbnail-button-small"><?php echo __('New', 'kboard') ?></a>
		</div>
		<!-- 버튼 끝 -->
	<?php endif ?>

	<?php if ($board->contribution()): ?>
		<div class="kboard-thumbnail-poweredby">
			<a href="https://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href);return false;"
				title="<?php echo __('KBoard is the best community software available for WordPress', 'kboard') ?>">Powered
				by KBoard</a>
		</div>
	<?php endif ?>
</div>