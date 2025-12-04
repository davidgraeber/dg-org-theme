<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Whatever
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="wtvr-site">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?php echo get_home_url() . '/wp-content/themes/wtvr/lib/img/og-image.jpg'?>" />

    <link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-NJGGBZ31K1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-NJGGBZ31K1', { 'anonymize_ip': true });
</script>

<body <?php body_class(); ?>>
    <div id="triangles">
        <div class="fixed">
            <img src="<?php echo get_template_directory_uri() . '/img/triangles-yellow.svg' ?>">
            
        </div>
    </div>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'wtvr' ); ?></a>

    <div id="overlay">
        <div id="overlay-closer">
            <a class="icon-cross"></a>
        </div>
        <div class="m--w">

            <div class="overlay" id="search-overlay">
                <div class="overlay-content">
	                <?php get_search_form();?>
                </div>
            </div>

        </div>
    </div>

    

    <header id="masthead" class="site-header">

        <div class="m--w ">

            <div class="bar">
                <?php

                $sub_site = !is_main_site();

                if ($sub_site){

                    $sub_title = get_bloginfo( 'name' );

                    switch_to_blog( 1 );

                    $site_title = get_bloginfo( 'name' );
                    $site_url = get_bloginfo( 'url' );

                    restore_current_blog();

                } else {

                    $site_title = get_bloginfo( 'name' );
                    $site_url = '/';

                }


                ?>


                <div class="site-identity">
                    <a href="<?php echo $site_url;?>" class="main-identity">

                        <h1 class="site-title <?php if ($sub_site) echo 'main-site-title'?>">
                            <?php echo $site_title; ?>
                        </h1>
                    </a>
                    <?php if ($sub_site): ?>
                        <span class="hide-at-768">/</span>
                        <a href="/" rel="home">
                            <h2 class="site-title sub-site-title">
                                <?php echo $sub_title ?>
                            </h2>
                        </a>
                    <?php endif;?>
                </div>


                <div id="dgi">
                    <span>in association with</span>
                    <a class="dgi-logo group" href="https://davidgraeber.institute/" target="_blank">
                        <?php echo file_get_contents( __DIR__ . '/img/DGI-logo.svg' ) ?>
                    </a>
                </div>

                <!-- Hamburger menu icon -->
                <a id="hamburger">
                    <div></div>
                    <div></div>
                    <div></div>
                </a>

            </div><!-- .bar -->

            <div id="hideable">

                <nav id="site-navigation" class="main-navigation nav">

                    <!-- Menu -->

                    <?php
                    wp_nav_menu( [ // Main menu
                        'theme_location' => 'main-menu',
                        'menu_id'        => 'primary-menu',
                        'container_id'   => 'menu-wrap',
                    ] );
                    ?>

                </nav><!-- #site-navigation -->

                <div id="buttons-menu">
                    <ul>
                        <li>
                            <a href="#" id="search-toggle" class="font-icon icon-search"></a>
                        </li>
                        <li class="youtube"><a href="https://www.youtube.com/channel/UCHvS_UKwCssqptcgOyuX5yw" target="_blank">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                x="0px" y="0px" viewBox="0 0 40 40" style="enable-background:new 0 0 40 40;"
                                xml:space="preserve" aria-labelledby="title-youtube" role="img"><title
                                id="title-youtube">Link to youtube</title>
                                <rect class="st0" width="40" height="40"/>
                                <g>
                                    <path class="st1" d="M17.5,23.7v-7.5L24,20L17.5,23.7z M32,14c-0.3-1.1-1.1-1.9-2.2-2.2c-1.9-0.5-9.8-0.5-9.8-0.5s-7.8,0-9.8,0.5
                                        C9.2,12.1,8.3,12.9,8,14c-0.5,2-0.5,6-0.5,6s0,4.1,0.5,6c0.3,1.1,1.1,1.9,2.2,2.2c2,0.5,9.8,0.5,9.8,0.5s7.8,0,9.8-0.5
                                        c1.1-0.3,1.9-1.1,2.2-2.2c0.5-1.9,0.5-6,0.5-6S32.5,15.9,32,14"/>
                                    </g>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>


        </div>


    </header><!-- #masthead -->