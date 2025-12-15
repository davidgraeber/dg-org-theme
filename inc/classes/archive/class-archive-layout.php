<?php

namespace Whatever;

abstract class Archive_Layout {

	public static array $choices = [];

	public array $vars = [];

	public function __construct($vars){

		$this->vars = $vars;

	}

	public function header(){
		$cpt_array = ['reviews', 'articles', 'papers', 'interviews', 'videos', 'audios', 'press', 'memorials', 'projects', 'unpublished'];
		$post_type = $this->vars['post-type'];
		$post_type_menu = [];
		if ( in_array($post_type, $cpt_array, true) ){
			$current_language = !empty($_GET['book_language']) ? intval($_GET['book_language']) : '';
			$post_type_menu = ( $current_language ) ? post_type_menu_filtered_by_language($post_type, $current_language) : '';
		};
		?>

			<div>
				<h1 class="page-title archive-title"><?php echo get_the_archive_title(); ?></h1>
				<?php if ( !empty($post_type_menu) ) { echo $post_type_menu; } ?>
				<div class="page-description">
					<?php if ( is_post_type_archive() ) {
						the_field( $this->vars['post-type'] . '-description', 'option' );
					} else {
						echo get_the_archive_description();
					}?>
				</div>
			</div>

			<?php if ( in_array($post_type, $cpt_array, true)) { ?>
				<div class="books-filter">
					<?php get_template_part( 'template-parts/snippet', 'language-select', [
						'lang'  => $current_language,
						'post_type' =>  $post_type
					] ) ?>
				</div>
			<?php } ?>


		<?php
	}

    public function controls(){
        ?>

        <div class="control control-sort">
            Sort by
            <select name="archive-sort" id="archive-sort">
                <option value="title">Title</option>
                <option value="title">Publish date</option>
            </select>
        </div>
        <div class="control control-sort">
            <a href="#">&downarrow;</a>
            <a href="#" class="inactive">&uparrow;</a>
        </div>
        <div class="control control-sort">Filter</div>
        <div class="control control-sort">Search</div>
        <?php
    }

	abstract public function content();

	protected static function variants(): array {
		return [];
	}

	/**
	 *
	 * Get list of layouts with classnames
	 *
	 * @param $return
	 *
	 * @return array 'list' => 'archive-layout-list'
	 */

	public static function list($return = 'slugs') : array{

		$dirs = scandir(__DIR__);

		// filter layouts
		$dirs = array_filter(
			$dirs,
			function ($dir) {
				return ( substr($dir,0,21) === 'class-archive-layout-' );
			}
		);

		$list = []; // 'list' => 'archive-layout-list'

		foreach ($dirs as $dir) {

			// prepare class hyphenated
			// cut 'class-'
			$dir = substr( $dir, 6 );
			// cut '.php'
			$classname = substr( $dir, 0, -4);

			// prepare slug
			// cut 'archive-layout-'
			$slug = substr( $classname, 15 );

			// push pair
			$list[$slug] = $classname;
		}

		// return full list
		if ( 'full' === $return ) return $list;

		// return slug list by default
		return array_keys($list);

	}


	/**
	 *
	 * Output the resulting archive
	 *
	 * @return void
	 */

	public function render() {
        echo sprintf(
            '<header class="page-header archive-header archive-layout-%s">',

            $this->vars['layout']
        );

		$this->header();

        echo sprintf(
            '<div class="archive-controls archive-controls-%s">',

            $this->vars['layout']
        );

        //$this->controls();

        echo '</div>';

        echo '</header>';

		echo sprintf(
			'<section class="archive archive-layout-%s">',

			$this->vars['layout']
		);

		$this->content();

		the_posts_pagination();

		echo '</section>';
	}

	/**
	 * Prepare static choices for ACF
	 *
	 * @return array
	 */

	public static function choices(): array {

		$files = self::list('full');

		$choices = [];

		foreach ($files as $slug => $filename) {

			$classname = __NAMESPACE__ . '\\' . wtvr_class_name_from_filename($filename);

			$variants = array_merge(
				[$slug => ucfirst($slug)],
				$classname::variants()
			);

			foreach ($variants as $variant_slug => $variant){
				self::$choices[ $variant_slug] = $slug;
			}

			$choices = array_merge(
				$choices,
				$variants
			);

		}

		return $choices;

	}



}