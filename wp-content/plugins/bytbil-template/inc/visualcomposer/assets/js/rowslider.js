(function($){

    //this is Sparta!

    var $sliders = $('[data-rowslider]');
    var responsiveObject = {};
    responsiveObject[rowSlider.xs] = {
        items:1,
        center: true,
    };
    responsiveObject[rowSlider.sm] = {
        items:2,
        center: true,
    };
    responsiveObject[rowSlider.md] = {
         items:4,
        loop: false,
        center: false,
        mouseDrag: false,
        touchDrag: false,
        pullDrag: false,
        freeDrag: false,
    };
    responsiveObject[rowSlider.lg] = {
        items:4,
        loop: false,
        center: false,
        mouseDrag: false,
        touchDrag: false,
        pullDrag: false,
        freeDrag: false,
    };




    $sliders.each(function(){
        setSliderWidths($(this));
        $(this).owlCarousel({
            loop:true,
            nav:false,
            autoWidth: false,
            itemElement: 'div',
            responsiveClass: true,
            merge:true,
            //itemClass: "owl-carousel row-slider-item",
            responsive: responsiveObject,
            });
        $(this).on('resize.owl.carousel', function(){
            setSliderWidths($(this));
        });
    });



    function setSliderWidths(slider){
        var columns = slider.find('.wpb_column');
        //remove values
        columns.css("width", "");

        columns.each(function(){
            var width = $(this).innerWidth();
            $(this).css("width", width + "px");
        });
    }
})(jQuery);