<?php
/**
 * Template part for displaying book content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Whatever
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="grid grid-2 book-top">
		<section class="cover-block grid-item">
			<?php
				$translations = get_field('translations');
				if ($translations) {
					// Сортировка переводов по языку
					usort($translations, function($a, $b) {
						return strcmp($a['language'][0]->name, $b['language'][0]->name);
					});
					// Вывод слайдера с переводами
					?>
					<div class="cover-slider">
						<?php
						foreach ($translations as $translation):
							if ($translation['cover']):
								wtvr_output_cover($translation);
							endif;
						endforeach;
						?>
					</div>
					<div class="appenddots"></div>

					<div class="cover-nav">
						<?php
						foreach ($translations as $translation):
							if ($translation['cover']):
								wtvr_output_cover($translation);
							endif;
						endforeach;
						?>
					</div>
					<?php
				} else {
					// Если переводов нет, выводим featured image
					if (has_post_thumbnail()) {
						?>
						<div class="featured-image-container">
							<?php the_post_thumbnail('large', array('class' => 'featured-image')); ?>
						</div>
						<?php
					}
				}
			?>
		</section>
		<section class="content-block grid-item">
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header><!-- .entry-header -->
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</section>
		<section class="grid-item meta-block">
			
			<?php
				$earliest_year = get_earliest_publication_date();
				if ($earliest_year) :
				?>
					<span><b>First published</b> <?php echo esc_html($earliest_year); ?></span>
            <?php endif; ?>


			<?php
				$unique_languages = get_unique_languages();
				if (!empty($unique_languages)):
			?>
				<div class="translations">
					<h3>Translations</h3>
					<ul class="translation-list">
						<?php
						foreach ($unique_languages as $language_name) {
							echo '<li class="language-item" data-language="' . esc_attr($language_name) . '">' . $language_name . "</li>";
						}       
						?>
					</ul>
				</div>
			<?php endif; ?>
			<div class="call-to-action">
				<?php the_field('book_call', 'option'); ?>
			</div>
		</section>
	</div>
	<section class="book-tabs">
		<input type="radio" name="tab" id="abstract" checked>
		<label for="abstract">Abstract</label>
		<div class="tab-content" id="content1">
			<?php the_field('abstract');?>
		</div>

		<!-- Tab 2 -->
		<input type="radio" name="tab" id="toc">
		<label for="toc">Table of Content</label>
		<div class="tab-content" id="content2">
			<?php the_field('toc');?>
		</div>

		<!-- Tab 3 -->
		<input type="radio" name="tab" id="translations">
		<label for="translations">Translations</label>
		<div class="tab-content" id="content3">
			
			<?php
				if( $translations): 
			?>		
					<div class="translations-grid ">

						<?php
						function sort_by_language($a, $b): int {
							$langA = $a['language'][0]->name; 
							$langB = $b['language'][0]->name;

							return strcmp($langA, $langB);
						}
					
						// Сортировка массива
						usort($translations, 'sort_by_language');
						
						// Вывод массива
						$lastLanguage = null; // Инициализация переменной перед начлом цикла

						foreach ($translations as $translation):
							$currentLanguage = $translation['language'][0]->name; 
						
							
							if ($lastLanguage !== $currentLanguage) {
								echo '<h3>' . $currentLanguage . '</h3>'; 
								$lastLanguage = $currentLanguage; 
							}
							
							?>
							<div class="translation-item">
								<div class="translation-cover-container">
								<?php if ($translation['cover']): 
									$cover = $translation['cover'];
									if (is_array($cover) && isset($cover['sizes'])): ?>
										<img src="<?php echo esc_url($cover['sizes']['medium']); ?>"
											srcset="<?php echo esc_attr(wp_get_attachment_image_srcset($cover['ID'], 'medium')); ?>"
											sizes="(max-width: 768px) 100vw, 300px"
											alt="<?php echo esc_attr($translation['title']); ?>"
											class="translation-cover"
											width="<?php echo esc_attr($cover['sizes']['medium-width']); ?>"
											height="<?php echo esc_attr($cover['sizes']['medium-height']); ?>"
										>
									<?php else: ?>
										<img src="<?php echo esc_url($cover); ?>" alt="<?php echo esc_attr($translation['title']); ?>" class="translation-cover">
									<?php endif; ?>
								<?php endif; ?>
								</div>
								<div class="translation-info">
									<?php if (!empty($translation['title'])): ?>
										<span><strong>Title:</strong> <?php echo $translation['title']; ?></span>
									<?php endif; ?>
									
									<?php if (!empty($translation['first_published'])): ?>
										<span><strong>First Published:</strong> <?php echo $translation['first_published']; ?></span>
									<?php endif; ?>
									
									<?php if (!empty($translation['isbn'])): ?>
										<span><strong>ISBN:</strong> <?php echo $translation['isbn']; ?></span>
									<?php endif; ?>
									
									<?php if (!empty($translation['publisher'])): ?>
										<span><strong>Publisher:</strong> <?php echo $translation['publisher']; ?></span>
									<?php endif; ?>
									
									<?php if (!empty($translation['translators'])): ?>
										<span><strong>Translators:</strong> 
											<?php 
											$translator_names = array();
											foreach ($translation['translators'] as $translator) {
												if (get_post_status($translator->ID) === 'publish') {
													$translator_names[] = sprintf(
														'<p><a href="%s">%s</a></p>',
														esc_url(get_permalink($translator->ID)),
														esc_html($translator->post_title)
													);
												} else {
													$translator_names[] = '<p>' . esc_html($translator->post_title) . '</p>';
												}
											}
											echo implode(', ', $translator_names);
											?>
										</span>
									<?php endif; ?>
									
									<?php if (!empty($translation['pages'])): ?>
										<span><strong>Pages:</strong> <?php echo $translation['pages']; ?></span>
									<?php endif; ?>
								</div>

							</div>
						
						<?php endforeach;?>
					</div>
				<?php
				endif;
			?>
		</div>

		<!-- Tab 4 -->
		<input type="radio" name="tab" id="reviews">
		<label for="reviews">Book Reviews</label>
		<div class="tab-content" id="content4">
		<?php
			$related = get_field('related_content');
				
			if ($related): 
				$review_posts = array_filter($related, function($post_id) {
					$post_status = get_post_status($post_id);
					return get_post_type($post_id) === 'reviews' && $post_status === 'publish';
				});
				if (!empty($review_posts)): ?>
					<div class="reviews-container">
						<?php foreach ($review_posts as $post_id):
							$post = get_post($post_id);
							setup_postdata($post);
						?>
							<article class="imageless">
								<div class="wrapper">
									<a class="card-link"  href="<?php echo ( get_permalink() ); ?>" rel="bookmark">
										<div class="caption-icon-wrap">
											<!-- <div class="caption-icon caption-icon-right-arrow"></div> -->
											<?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/DGO-arrow.svg') ?>
										</div>

										<div class="card-content inner">
		
									
										<header class="entry-header">
											<h3 class="entry-title">
												<span><?php the_title(); ?></span>
											</h3>
											<?php if ( $subtitle = get_field( 'subtitle' ) ) : ?>
												<h4 class="entry-subtitle">
													<span><?php echo $subtitle; ?></span>
												</h4>
											<?php endif; ?>
										</header><!-- .entry-header -->
										<div class="entry-content">
											<?php if ( $summary = get_field( 'summary' ) ) : ?>
												<div class="summary">
													<?php echo wpautop( $summary ); ?>
												</div>
											<?php endif; ?>
										</div><!-- .entry-content -->

									</a>
								</div>
							</article>
						<?php 
							endforeach;
							wp_reset_postdata();
						?>
					<?php endif; ?>
			<?php endif; ?>
		</div>
		
	</section>

	<?php
	// Получаем связанный контент
	$related = get_field('related_content');

	// Проверяем наличие связанного контента перед выводом всей секции
	if ($related): ?>
		<section class="related">
			<div class="related-header">
				<h3>Related materials</h3>
				<?php
				// Фильтруем reviews в отдельный массив
				$related_posts = array_filter($related, function($post_id) {
					$post_status = get_post_status($post_id);
					return get_post_type($post_id) !== 'reviews' && $post_status === 'publish';
				});

				if (!empty($related_posts)):
					$post_types = array();
					foreach ($related_posts as $post_id) {
						$post_type = get_post_type($post_id);
						$post_types[$post_type] = get_post_type_object($post_type)->labels->singular_name;
					}
					if (!empty($post_types)):
				?>
						<ul class="content-type-filter">
							<?php foreach ($post_types as $type => $label): ?>
								<li data-type="<?php echo esc_attr($type); ?>"><?php echo esc_html($label); ?></li>
							<?php endforeach; ?>
						</ul>
				<?php
					endif;
				endif;
				?>
			</div>

			<?php if (!empty($related_posts)): ?>
				<div class="grid grid-3">
					<?php foreach ($related_posts as $post_id):
						$post = get_post($post_id);
						setup_postdata($post);
						$post_type = get_post_type();
					?>
						<article class="card related-post <?php echo esc_attr($post_type); ?>">
							<a href="<?php echo get_permalink(); ?>" rel="bookmark">
								<?php if (has_post_thumbnail()): ?>
									<div class="related-post-thumbnail">
										<?php the_post_thumbnail('thumbnail'); ?>
									</div>
								<?php endif; ?>
								<div class="inner">
									<div class="caption-icon-wrap">
										<?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/DGO-arrow.svg') ?>
									</div>
									<div class="related-post-content">
										<?php if (get_post_type() !== 'page'): ?>
											<div class="related-post-meta">
												<span class="related-post-type"><?php echo get_post_type_object(get_post_type())->labels->singular_name; ?></span>
											</div>
										<?php endif; ?>
										<h3 class="related-post-title"><?php the_title(); ?></h3>
										
										<?php if (!has_post_thumbnail()): ?>
											<div class="related-post-excerpt">
												<?php echo wp_trim_words(get_the_excerpt(), 20); ?>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</a>
						</article>
					<?php 
						endforeach;
						wp_reset_postdata();
					?>
				</div>
			<?php endif; ?>
		</section>
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
