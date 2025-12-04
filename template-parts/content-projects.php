<?php
/**
 * Template part for displaying project content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Whatever
 */

$post_type = get_post_type();
$post_type_layout = get_field($post_type . '-layout', 'option');
$custom_features = get_field('post-options');
$attachments = get_field('post-attachments');
$images = wtvr_get_featured_images(get_the_ID());
$video = get_field('featured_video');

if (isset($custom_features['layout'])) {
    if ('landscape' !== $custom_features['layout']) {
        $layout = $custom_features['layout'];
    } elseif ($post_type_layout) {
        $layout = $post_type_layout;
    } else {
        $layout = 'landscape';
    }
} elseif ($post_type_layout) {
    $layout = $post_type_layout;
} else {
    $layout = 'landscape';
}
?>
<article class="project-item"> 
    <div class=" grid grid-3 grid-article">
        <?php if ($images): ?>
            <section class="feature">
                    <?php get_template_part('template-parts/snippet', 'thumbnail', [
                        'class'    => 'narrow fade',
                        'images'   => $images,
                        'cropping' => (isset($custom_features['cropping'])) ? $custom_features['cropping'] : 'cover'
                    ]); ?>
            </section>
        <?php endif; ?>
        <section class="meta landscape-meta">
        <?php   
            $links = get_field('project_links');
            if ($links) : ?>
                <div class="links-block">
                    <?php
                    echo '<h2>Links</h2>';
                    echo $links; 
                    ?>
                </div>
            <?php endif; ?>
        </section>
        <article class="project-info">
            <header class="entry-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            </header>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
    </div>
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


</article> 