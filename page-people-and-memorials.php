<?php
/**
 * Template Name: People and memorials
 *
 * This is the template that displays people and memorials
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Whatever
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php

		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content');

		endwhile; // End of the loop.

        $sections = [
            'people'          => [
                'title' => false,
                'class' => 'Card_Person',
                'wrapper'=>'grid',
                'count' => 6,
            ],
            'memorial-videos' => [
                'title' => 'Videos',
                'class' => 'Card_Video',
                'wrapper'=>'grid',
                'count' => 3,
            ],
            'memorials'       => [
                'title' => 'Memorials',
                'class' => 'Card_Memorial',
                'wrapper'=>'list',
                'count' => 6,
            ],
        ];

        foreach ($sections as $post_type => $section){

            $q_args  = [
                'post_type'      => $post_type,
                'post_status'    => 'publish',
                'posts_per_page' => $section['count'],
                'orderby'        => 'rand',
                'order'          => 'ASC'
            ];
            $q = new WP_Query( $q_args );

            echo '<section class="'.$post_type.'">';

            if ($section['title']) {

                echo sprintf(
                    '<h2>%s</h2>',
                    $section['title'],
                );

            }

            echo '<div class="wrapper-'.$section['wrapper'].'">';


            while ($q->have_posts()){
                $q->the_post();

                $classname = 'Whatever\\'.$section['class'];

                $card = new $classname;
                $card->render();
            }

            echo '</div>';

            echo sprintf(
                '<a class="button view-all" href="%s">view all</a>',
                '/' . $post_type . '/'
            );

            echo '</section>';

        }

		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
