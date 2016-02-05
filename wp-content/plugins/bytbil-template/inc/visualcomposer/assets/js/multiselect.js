var selected = [];

(function($, document) {

    $(document).ready(function() {

        $(document).on('mousedown', '.multiselect', function(e) {

            e.stopPropagation();
            e.preventDefault();
            e.stopImmediatePropagation();

            selected = [];
            selected = $(this).val();
        });

        $(document).on('mousedown', '.multiselect option', function(e) {

            e.stopPropagation();
            e.preventDefault();
            e.stopImmediatePropagation();

            $(this).parents("select").focus();
        });

        $(document).on('mouseup', '.multiselect option', function(e) {

            if(selected.indexOf($(this).val()) == -1) {
                selected.push($(this).val());
            } else {
                selected.splice( selected.indexOf($(this).val()), 1 );
            }

            $(this).parents("select").val(selected);
        });
    });
})(jQuery, document);
