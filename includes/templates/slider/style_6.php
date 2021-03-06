<?php
	global $slider_metabox;
	$slider_metabox->the_meta();
?>

<style>
.main-slider {
	height:100%;
	visibility:hidden;
}
</style>

<ul class="main-slider">

        <?php
        $slide_counter = 0;
        while($slider_metabox->have_fields('items'))
        {
            $slide_counter++;
        ?>

            <li class="swiper-slide slide_<?php echo esc_attr($slide_counter); ?>">

                <div class="main-slider-content">
                    <div class="row">
                        <div class="large-8 large-centered columns">
                            <div class="main-slider-elements">
                                <h1><?php echo ($slider_metabox->get_the_value('title')) . "<br />"; ?></h1>
                                <h2><?php echo ($slider_metabox->get_the_value('description')) . "<br />"; ?></h2>
                                <?php if ($slider_metabox->get_the_value('button_label') != "") { ?>
                                	<a class="slider_button" href="<?php echo esc_url($slider_metabox->get_the_value('link')); ?>"><?php echo ($slider_metabox->get_the_value('button_label')); ?></a>
                            	<?php } ?>
                            </div><!-- .main-slider-elements -->
                        </div><!-- .columns -->
                    </div><!-- .row -->
                </div>

            </li>

        <?php
        }
        ?>

</ul>

<script>
jQuery( function($) {

	function resize_slider_content() {
		$('.main-slider .main-slider-content').css('height', $(window).innerHeight());
		$('.main-slider').css('visibility', 'visible');
	}

	resize_slider_content();
});
</script>
