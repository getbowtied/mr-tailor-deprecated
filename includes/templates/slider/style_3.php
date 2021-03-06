<style>

/* min-width 641px, medium screens */
@media only screen and (min-width: 40.063em) {
	.fixed-height .swiper-container .main-slider-content {
		<?php if ($slider_metabox->get_the_value('slider_height') == "") : ?>
			height:400px;
		<?php else : ?>
			height:<?php echo esc_attr($slider_metabox->get_the_value('slider_height')); ?>px;
		<?php endif; ?>
	}
}

</style>

<div class="main-slider-fullscreen fixed-height">

    <div class="main-slider">
        <div class="swiper-container" data-settings="">

            <div class="swiper-wrapper">

                <?php
				$slide_counter = 0;
				while($slider_metabox->have_fields('items'))
				{
					$slide_counter++;
				?>

                    <div class="swiper-slide slide_<?php echo esc_attr($slide_counter); ?>">

                        <div class="main-slider-content">
                            <div class="row">
                                <div class="large-8 large-centered medium-10 medium-centered columns">
                                    <div class="main-slider-elements">
                                        <?php if ($slider_metabox->get_the_value('title') != "") { ?>
                                            <h1><?php echo ($slider_metabox->get_the_value('title')) . "<br />"; ?></h1>
                                        <?php } ?>
                                        <?php if ($slider_metabox->get_the_value('description') != "") { ?>
                                            <h2><?php echo ($slider_metabox->get_the_value('description')) . "<br />"; ?></h2>
                                        <?php } ?>
                                        <?php if ($slider_metabox->get_the_value('button_label') != "") { ?>
                                            <a class="slider_button" href="<?php echo esc_url($slider_metabox->get_the_value('link')); ?>"><?php echo ($slider_metabox->get_the_value('button_label')); ?></a>
                                        <?php } ?>
                                    </div><!-- .main-slider-elements -->
                                </div><!-- .columns -->
                            </div><!-- .row -->
                        </div>

                        <a class="arrow-left" href="#"></a>
            			<a class="arrow-right" href="#"></a>

                    </div>

                <?php
                }
                ?>

            </div>

            <div class="pagination"></div>

        </div>
    </div>

</div>

<script>
jQuery( function($) {

	var slider_2 = new Swiper('.main-slider .swiper-container', {
		loop: true,
		pagination: { el: '.main-slider .swiper-container .pagination', clickable: true, },
		autoHeight: true,
		resistance: true,
		resistanceRatio: 1,
		navigation: {
			nextEl: '.main-slider .swiper-container .arrow-right',
			prevEl: '.main-slider .swiper-container .arrow-left',
		},
		<?php if ($slider_metabox->get_the_value('slider_autoplay') == 1) { ?>
		autoplay: { delay: <?php echo esc_attr($slider_metabox->get_the_value('slider_autoplay_delay')) == "" ? 5000 : $slider_metabox->get_the_value('slider_autoplay_delay'); ?> },
		<?php } ?>
		on: {
		    init: function () {
				$('.main-slider .swiper-container').css('visibility', 'visible');
				$('.swiper-slide-active .main-slider-elements').addClass('animated');
		    },
		    slideChangeTransitionStart: function() {
				$('.main-slider .arrow-left, .main-slider .arrow-right').addClass('hidden');
				$('.main-slider-elements').removeClass('animated');
			},
			slideChangeTransitionEnd: function() {
				$('.main-slider .arrow-left, .main-slider .arrow-right').removeClass('hidden');
				$('.swiper-slide-active .main-slider-elements').addClass('animated');
			}
	  	},
	});

	$('.arrow-left').on('click', function(e){
		e.preventDefault();
		slider_2.slidePrev();
	});

	$('.arrow-right').on('click', function(e){
		e.preventDefault();
		slider_2.slideNext();
	});

});
</script>
