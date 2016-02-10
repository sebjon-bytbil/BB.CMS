var imageslider = {
    refresh_imageslider: function() {
        var self = this,
            slider = '[data-slideshow="slider"]';

        jQuery(slider).ready(function() {
            if (undefined !== $(slider) && $(slider).length > 0) {
                self.init_sliders();
            }
        });
    },

    animate_slideshow: function(slider, when, animationspeed) {
        var current_caption = jQuery(slider).find('.flex-active-slide .caption-contents');
        var animation = jQuery(current_caption).data('animation');

        if (when === 'start' || when === 'after') {

            if (animation === 'fade') {
                jQuery(current_caption).delay(200).css({
                    "transition": "opacity ease-in " + (animationspeed + 200) + "ms",
                    "opacity": 1,
                });
            } else if (animation === 'left' || animation === 'right') {
                jQuery(current_caption).delay(200).css({
                    "transition": "left ease-out " + (animationspeed + 200) + "ms",
                    "left": "0",
                });
            }
        } else if (when === 'before') {
            if (animation === 'fade') {
                jQuery(current_caption).delay(200).css({
                    "opacity": 0,
                });
            } else if (animation === 'left' || animation === 'right') {
                if (animation === 'left') {
                    jQuery(current_caption).delay(200).css({
                        "transition": "left ease-in " + (animationspeed + 200) + "ms",
                        "left": "-100%",
                    });
                }
                if (animation === 'right') {
                    jQuery(current_caption).delay(200).css({
                        "transition": "left ease-in " + (animationspeed + 200) + "ms",
                        "left": "200%",
                    });
                }
            }
        }
    },

    init_sliders: function() {
        var self = this,
            sliders = jQuery('[data-slideshow="slider"]');

        sliders.each(function() {
            var slideshow   = jQuery(this),
            id              = slideshow.data('id'),
            animationspeed  = slideshow.data('animationspeed'),
            animation       = slideshow.data('animation'),
            speed           = slideshow.data('speed'),
            arrows          = slideshow.data('arrows'),
            controls        = slideshow.data('controls'),
            thumbnailsize   = slideshow.data('thumbnailsize');

            if (controls === 'thumbs') {
                //jQuery('#carousel-' + id).flexslider({
                    //animation: 'slide',
                    //controlNav: false,
                    //animationLoop: true,
                    //keyboard: true,
                    //slideshow: true,
                    //itemWidth: thumbnailsize,
                    //itemMargin: 0,
                    //asNavFor: '#slideshow-' + id
                //});
            }

            var sliderData = {
                animation: animation,
                direction: 'horizontal',
                slideshowSpeed: speed,
                animationSpeed: animationspeed,
                pauseOnHover: true,
                directionNav: arrows,
                touch: true,
                useCSS: true,
                smoothHeight: false,
                slideshow: true,
                keyboard: true,
                start: function(slider) {
                    self.animate_slideshow(slider, 'start', animationspeed);
                },
                after: function(slider) {
                    self.animate_slideshow(slider, 'after', animationspeed);
                },
                before: function(slider) {
                    self.animate_slideshow(slider, 'before', animationspeed);
                }
            };

            if (controls == true)
                sliderData.controlNav = true;
            else
                sliderData.controlNav = false;
            sliderData.animationLoop = true;

            slideshow.flexslider(sliderData);
        });
    },
};
