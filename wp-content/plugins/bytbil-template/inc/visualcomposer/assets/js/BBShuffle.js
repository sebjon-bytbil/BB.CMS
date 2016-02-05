// Namespace
var BBShuffle = {};

BBShuffle.Shuffle = (function($, undefined) {
    var $grid,
        $filter,
        select,

    init = function(grid, filter, selector, selectpicker) {
        // Set vars
        $grid = $(grid);
        if (selectpicker)
            $filter = filter;
        else
            $filter = $(filter);
        select = selector;

        // Filters
        filters();

        // Init shuffle
        initShuffle();
    },

    filters = function() {
        $filter.on('change', function() {
            $grid.shuffle('shuffle', $(this).val());
        });
    },

    initShuffle = function() {
        $grid.shuffle({
            speed: 250,
            easing: 'cubic-bezier(0.165, 0.840, 0.440, 1.000)',
            itemSelector: select
        });
    };

    return {
        init: init
    };
}(jQuery));
