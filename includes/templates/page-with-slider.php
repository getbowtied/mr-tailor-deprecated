<?php
/*
Template Name: Page with Slider
*/
?>

<?php get_header(); ?>

<div class="page_with_slider">
	<div class="row">
		<div class="large-12 columns">

			<?php
	        global $slider_metabox;
	        $slider_metabox->the_meta();

			$slider_style = $slider_metabox->get_the_value('slider_template');
			switch ($slider_style) {
				case "style_1":
					include_once( dirname(__FILE__) . '/slider/style_1.php' );
					break;
				case "style_3":
					include_once( dirname(__FILE__) . '/slider/style_3.php' );
					break;
				case "style_4":
					include_once( dirname(__FILE__) . '/slider/style_4.php' );
					break;
				case "style_6":
					include_once( dirname(__FILE__) . '/slider/style_6.php' );
					break;
				default:
					include_once( dirname(__FILE__) . '/slider/style_1.php' );
			}

			if ($post->post_content != "") : ?>

			    <div id="primary" class="content-area">

			        <div id="content" class="site-content" role="main">

			            <?php while ( have_posts() ) : the_post(); ?>

			            	<?php get_template_part( 'content', 'page' ); ?>

			            <?php endwhile; // end of the loop. ?>

			        </div><!-- #content -->

			    </div><!-- #primary -->

		    <?php endif; ?>

		</div>
	</div>
</div>

<?php get_footer(); ?>
