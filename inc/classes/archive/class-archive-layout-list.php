<?php

namespace Whatever;

class Archive_Layout_List extends Archive_Layout {

	public static function variants() :array{

		return [
			'imageless' => 'List with no images',
			'full' => 'List with full content',
		];

	}

	public function content(){
		?>

		<div class="grid grid-3 grid-<?php echo $this->vars['layout'] ?>">


			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'card', [
                    'archive' => $this->vars['layout']
				] );

			endwhile;
			?>
		</div>

		<?php


	}

}
