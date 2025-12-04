<?php

namespace Whatever;

class Archive_Layout_Table extends Archive_Layout {


	public function content(){

		$layout = $this->vars['layout'];

		$columns = get_field( $this->vars['post-type'] . '-columns', 'option' );


		$col_fractions = array_map( function ( $column ) {
			return $column['width'];
		}, $columns );

		$fr_sum = array_sum( $col_fractions );

		$col_percents = array_map( function ( $fr ) use ( $fr_sum ) {
			return round( $fr / $fr_sum, 4 ) * 100 . '%';
		}, $col_fractions );

		$grid_template_columns = join( ' ', $col_percents );
		$grid_style            = 'grid-template-columns:' . $grid_template_columns;


		?>


	    <div class="grid grid-3 grid-<?php echo $layout ?>"
	         style="<?php echo $grid_style ?>">
            <?php if ( 'table' === $layout ) : ?>
                <?php foreach ( $columns as $column ) : ?>
                    <div class="grid-th">
                        <strong class="grid-th <?php echo $column['field'] ?>">
                            <?php echo $column['title'] ?>
                        </strong>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>


            <?php
            while ( have_posts() ) :
                the_post();

                get_template_part( 'template-parts/content', 'grid-row', [
                    'columns' => $columns,
                ] );

            endwhile;
            ?>
        </div>
        <?php


	}

}
