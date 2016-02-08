var id_folder;
(function ($) {
    "use strict";
    if ('undefined' == typeof (wp.media)) {
        return;
    }

    var media = wp.media;
    var setTime;
    media.view.Settings.Gallery = media.view.Settings.Gallery.extend({
        render: function () {
            var $el = this.$el;
            media.view.Settings.prototype.render.apply(this, arguments);
            $el.find('[data-setting="size"]').parent('label').remove();
            $el.find('[data-setting="link"]').parent('label').remove();
            $el.find('[data-setting="columns"]').parent('label').remove();
            $el.find('[data-setting="_orderbyRandom"]').parent('label').before(media.template('wpmf-gallery-settings'));
            $el.find('[data-setting="_orderbyRandom"]').parent('label').css({'width':'117px'});
            $el.find('[data-setting="_orderbyRandom"]').parent('label').find('span').css({'float':'right'});
            
//            media.gallery.defaults.link = 'post';
//            media.gallery.defaults.columns = '3';
//            media.gallery.defaults.size = 'thumbnail';
            media.gallery.defaults.display = 'default'; 
            media.gallery.defaults.targetsize = 'large';
            media.gallery.defaults.wpmf_folder_id = '';
            media.gallery.defaults.wpmf_autoinsert = '0';
            
            this.update.apply(this, ['link']);
            this.update.apply(this, ['columns']);
            this.update.apply(this, ['size']);
            this.update.apply(this, ['display']);
            this.update.apply( this, ['targetsize'] );
            this.update.apply( this, ['wpmf_folder_id'] );
            
            if(id_folder != undefined){
                var oldfIds =  $el.find('.wpmf_folder_id').val();
                var oldfIds_array = oldfIds.split(",").map(Number);
                
                    if(oldfIds != ''){
                        if(oldfIds_array.indexOf(id_folder) < 0){
                            $el.find('.wpmf_folder_id').val(oldfIds+','+id_folder).change();
                        }
                    }else{
                        $el.find('.wpmf_folder_id').val(id_folder).change();
                    }
            }
            
            this.update.apply( this, ['wpmf_autoinsert'] );
            return this;
        }
    });
    
    var selectallGallery;
    selectallGallery = function(){
        $('.media-menu-item:nth-child(2)').click();
        $('li.attachment').find('.thumbnail').click();
        if($('.button.media-button.button-primary.button-large.media-button-gallery').attr('disabled') == undefined){
            $('.button.media-button.button-primary.button-large.media-button-gallery').click();
        }
        
  
        if($('li.attachment').find('.thumbnail').length == 0){
            setTime = setTimeout(function(){
                selectallGallery();
            },100);
        }
    }
    
    $(document).on('change', '.wpmf-categories', function(event) {
        clearTimeout(setTime);
    });
    
    $(document).on('click', 'a.btn-selectall,a.btn-selectall1', function(event) {
        //id_folder = $('.directory.selected.expanded').data('id');
        id_folder = $('.select_folder_id').val();
        if(id_folder == undefined || id_folder == ''){
            id_folder = 0;
        }
        selectallGallery();       
        
    });
            
    $(document).on('click', '.link-btn', function(event) {
        if ( window.wpLink ) {
            $('#wp-content-editor-container .mce-ico.mce-i-link').click();
            window.wpLink.open();
            $('#url-field,#wp-link-url').closest('div').find('span').html('Link To');
            $('#link-title-field').closest('div').hide();
            $('.wp-link-text-field').hide();

            $('#url-field,#wp-link-url').val($('.compat-field-wpmf_gallery_custom_image_link input.text').val());
            //$('#link-title-field').val($('.setting[data-setting="title"] input').val());
            if($('.compat-field-gallery_link_target select').val() == '_blank'){
                $('#link-target-checkbox,#wp-link-target').prop('checked',true);
            }else{
                $('#link-target-checkbox,#wp-link-target').prop('checked',false);
            }
        }
    });

    $(document).on('click','#wp-link-submit',function(event){
        var attachment_id = $('.attachment-details').data('id');
        if(attachment_id == undefined) attachment_id = $('#post_ID').val();
        var link = $('#url-field').val();
        if(link == undefined) { link = $('#wp-link-url').val(); }  // version 4.2+
        //var title = $('#link-title-field').val();
        var link_target = $('#link-target-checkbox:checked').val();
        if(link_target == undefined) { link_target = $('#wp-link-target:checked').val(); } // version 4.2+

        if(link_target == 'on'){
            link_target = '_blank'
        }else{
            link_target= '';
        }

        $.ajax({
            type : "POST",
            url : ajaxurl,
            data :  {
                action : "update_link",
                id     : attachment_id,
                link   : link,
                //title  : title,
                link_target : link_target
            },
            success: function(response){
                $('.compat-field-wpmf_gallery_custom_image_link input.text').val(response.link);
                //$('.setting[data-setting="title"] input').val(response.title);
                $('.compat-field-gallery_link_target select option[value="'+ response.target +'"]').prop('selected',true).change();
            }
        });
    });
    
})(jQuery);