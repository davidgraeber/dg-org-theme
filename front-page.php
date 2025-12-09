<?php
/**
 * The template for displaying front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Whatever
 */


get_header(); ?>

    <main id="primary" class="site-main">

        <section class="feature">
			<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail('post-thumbnail', ['class' => 'img-responsive responsive--full front-page-img', 'title' => 'Feature image']);
				}
				
			?>
			<div class="lead">
				<?php 
					the_field('lead');
				?>
			</div>
        </section>

		<?php do_action( 'wtvr_translations_section_display' ); ?>
		
		<section class="featured-books">
			
				<?php $featured_books = get_field('featured_books');?>
					<?php if( $featured_books ): ?>
						<div class="grid grid-4">
							<?php foreach( $featured_books as $post ): 
						
								// Setup this post for WP functions (variable must be named $post).
								setup_postdata($post); ?>

								<?php  get_post_type(); 
									$post_type = get_post_type();
									$layout = get_field( $post_type . '-layout', 'option' );
									$images = wtvr_get_featured_images( get_the_ID() );
								?>

								<article class="card  featured-book">
									<a class="card-link image-link" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">

										<?php get_template_part( 'template-parts/snippet', 'thumbnail', [
										'class'    => $layout,
										'images'   => $images,
										'cropping' => ( isset( $custom_feature['cropping'] ) ) ? $custom_feature['cropping'] : 'cover'
										] ); ?>
									</a>
									<a class="card-link header-link" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
										<h3 class="entry-title">
											<span><?php echo get_the_title(); ?></span>
										</h3>
									</a>
								</article>
							<?php endforeach; ?>
							</div>
							<?php 
							// Reset the global post object so that the rest of the page works correctly.
							wp_reset_postdata(); ?>
					<?php endif; ?>
			
				<a class="bw-button" href="<?php echo get_post_type_archive_link( 'books' ); ?>">
					All books
					<span class="arrow">
						<?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/DGO-arrow.svg') ?>
					</span>
				</a>
		</section>


		<?php if ( $links = get_field( 'front-page-links' ) ) : ?>

            <section id="section-links" class="grid grid-3 nav card-nav">

				<?php foreach ( $links as $link ) :

					

					$path = str_replace( 'https://davidgraeber.org' . '/', '', $link ) ?>

                    <div class="card">
                        <a href="<?php echo $link; ?>" class="">

							

							<?php
							$gallery = false; // case of no images
							if ( $page = get_page_by_path( $path ) ) {
								// if is a singular page
								$title       = $page->post_title;
								$gallery     = get_field( 'featured_gallery', $page->ID );
								$description = $page->post_excerpt;
							} else {
								// if is a post type
								$slug = sanitize_title( $path );

								// print_r($slug); 

								if ( post_type_exists( $slug ) ) {

									$title       = ucfirst( $slug );
									$gallery     = get_field( $slug . '-gallery', 'option' );
									$description = get_field( $slug . '-description', 'option' );
								} else {

									$description = false;
								}
							} ?>

							<?php get_template_part( 'template-parts/snippet', 'thumbnail', [
							  'images' => $gallery,
							  'class'  => 'fade'
							] ) ?>
							
							<div class="inner">
								<div class="caption-icon-wrap">
									<!-- <div class="caption-icon caption-icon-right-arrow"></div> -->
									<?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/DGO-arrow.svg') ?>
								</div>
								
	                            <h3><?php echo $title; ?></h3>

								<?php if ( $description ) : ?>
	                                <div class="card-description">
										<?php echo $description; ?>
	                                </div>
								<?php endif; ?>


							</div>

                        </a>
                    </div>

				<?php endforeach; ?>

			</section>

		<?php endif; ?>
			
		<?php if( have_rows('sub_domain_links') ):?>
			
			<section id="sub-domain-section">
				<?php while( have_rows('sub_domain_links') ) : the_row(); ?>
					<?php while( have_rows('sub_group') ) : the_row(); ?>
						<div class="sub-group">
							<?php $image = get_sub_field('sub_image');
								  $limk = get_sub_field('sub_link')
							?>
							<a href="<?php echo esc_url($limk); ?>">
								<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
								
								<div> 
									<div class="inner">
										<div class="caption-icon-wrap">
											<!-- <div class="caption-icon caption-icon-right-arrow"></div> -->
											<?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/DGO-arrow.svg') ?>
										</div>
										<?php the_sub_field('sub_description'); ?>
									</div>							
								</div>
								
							</a>
						</div>
					<?php endwhile; ?>
				<?php endwhile; ?>
			</section>
		<?php endif; ?>	

		<a id="subcribe-list" class="bw-button" target="_blank" href="http://eepurl.com/iqDjQk">
			Subscribe to our newsletter
			<span class="arrow">
				<?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/DGO-arrow.svg') ?>
			</span>
		</a>


	    

    </main><!-- #main -->

<?php
get_sidebar();
get_footer();

