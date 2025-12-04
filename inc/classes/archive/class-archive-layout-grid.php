<?php

namespace Whatever;

class Archive_Layout_Grid extends Archive_Layout {


	public function content(){

		?>

		<div class="grid grid-3 grid-<?php echo $this->vars['layout'] ?>">


			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'card', [
					$this->vars['layout']
				] );

			endwhile;
			?>
        </div>

		<?php


	}

}
