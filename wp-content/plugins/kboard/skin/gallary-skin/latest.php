<div id="kboard-thumbnail-latest">
	<div class="kboard-gallery-container">
		<?php
		$list_index = 0;
		while ($content = $list->hasNext()):
			$list_index++;
			if ($list_index == 1):
				?>
				<div class="kboard-gallery-featured">
					<a href="<?php echo $url->getDocumentURLWithUID($content->uid) ?>">
						<div class="featured-thumbnail">
							<?php if ($content->getThumbnail(700, 400)): ?>
								<img src="<?php echo $content->getThumbnail(700, 400) ?>"
									alt="<?php echo esc_attr($content->title) ?>">
							<?php else: ?>
								<div class="no-image"><i class="icon-picture"></i></div>
							<?php endif ?>
						</div>
						<div class="featured-content">
							<?php if ($content->category1): ?>
							<div class="featured-category"><?php echo $content->category1 ?></div>
							<?php endif ?>
							<h2 class="featured-title"><?php echo $content->title ?></h2>
							<div class="featured-summary">
								<?php echo mb_strimwidth(strip_tags($content->content), 0, 100, '...', 'utf-8') ?>
							</div>
							<div class="featured-meta">
								<?php echo $content->getDate() ?>
								<span class="kboard-comments-count"><?php echo $content->getCommentsCount() ?></span>
							</div>
						</div>
					</a>
				</div>

				<div class="kboard-gallery-side-list">
				<?php else: ?>
					<div class="side-list-item">
						<a href="<?php echo $url->getDocumentURLWithUID($content->uid) ?>" class="side-link">
							<div class="side-thumbnail">
								<?php if ($content->getThumbnail(150, 100)): ?>
									<img src="<?php echo $content->getThumbnail(150, 100) ?>"
										alt="<?php echo esc_attr($content->title) ?>">
								<?php else: ?>
									<div class="no-image"><i class="icon-picture"></i></div>
								<?php endif ?>
							</div>
							<div class="side-content">
								<?php if ($content->category1): ?>
									<div class="side-category"><?php echo $content->category1 ?></div><?php endif ?>
								<h3 class="side-title">
									<?php if ($content->isNew()): ?><span
											class="kboard-thumbnail-new-notify">N</span><?php endif ?>
									<?php if ($content->secret): ?><img src="<?php echo $skin_path ?>/images/icon-lock.png"
											alt="<?php echo __('Secret', 'kboard') ?>"><?php endif ?>
									<?php echo $content->title ?>
									<span class="kboard-comments-count"><?php echo $content->getCommentsCount() ?></span>
								</h3>
								<div class="side-summary">
									<?php echo mb_strimwidth(strip_tags($content->content), 0, 60, '...', 'utf-8') ?>
								</div>
								<div class="side-meta">
									<?php echo $content->getDate() ?>
								</div>
							</div>
						</a>
					</div>
				<?php endif; endwhile; ?>

			<?php if ($list_index > 0): ?>
			</div> <!-- Close .kboard-gallery-side-list -->
		<?php else: ?>
			<div class="kboard-no-data">
				<?php echo __('No data.', 'kboard') ?>
			</div>
		<?php endif; ?>
	</div>
</div>