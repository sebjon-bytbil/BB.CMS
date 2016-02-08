/** 
 * We developed this code with our hearts and passion.
 * @package wp-media-folder
 * @copyright Copyright (C) 2014 JoomUnited (http://www.joomunited.com). All rights reserved.
 * @license GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

(function($){
    
    $(document).ready(function(){
        if(typeof(wp.media)!=='undefined'){
            wp.media.view.AttachmentsBrowser.prototype.on('ready',function(){
                $.ajax({
                    type: 'POST',
                    url : ajaxurl,
                    data: {
                        'action': 'noreplace_image',
                        'wpmf_replace' : 0,
                        'att_selected' : true
                    }
                });
            });

            if(wpmf_pagenow == 'upload.php' && $('.media-frame').hasClass('mode-grid')){
            
                mMediaViewModal = wp.media.view.Modal;  
                wp.media.view.Modal = wp.media.view.Modal.extend({
                    close : function(){
                        mMediaViewModal.prototype.close.apply(this, arguments);
                        if($('body.wpmf-replace').length === 0){
                            $.ajax({
                                type: 'POST',
                                url : ajaxurl,
                                data: {
                                    'action': 'noreplace_image',
                                    'wpmf_replace' : 0,
                                    'att_selected' : true
                                }
                            });
                        }
                    },
                });
            
            }
        }
        
        bindselectchange = function(){
            $(document).on('click', '.add-new-h2,#plupload-browse-button', function(event) {
                $.ajax({
                    type: 'POST',
                    url : ajaxurl,
                    data: {
                        'action': 'noreplace_image',
                        'wpmf_replace' : 0,
                        'att_selected' : true
                    }
                });
            });
            
            $(document).on('click', '#wpmf_upload', function(event) {
                if(wpmf_pagenow == 'upload.php' && $('.media-frame').hasClass('mode-grid')){
                    $('body').addClass('wpmf-replace');
                    $('.media-modal-close').click();
                }
                
                $('.moxie-shim.moxie-shim-html5 input[type="file"]').click();   
            });
            
            $(document).on('click', '#wpmfreplace', function(event) {
                var att_selected = $('[id^="__wp-uploader-id-"]:visible .attachments-browser .attachments .attachment.selected.details').data('id');
                if(att_selected == undefined) {
                    att_selected = $('[id^="__wp-uploader-id-"]:visible .attachment-details').data('id');
                }
                var wpmf_caption = $('.attachment-details .setting[data-setting="caption"] textarea').val();
                var wpmf_desc = $('.attachment-details .setting[data-setting="description"] textarea').val();
                var wpmf_alt = $('.attachment-details .setting[data-setting="alt"] input[type="text"]').val();
                var wpmf_title = $('.attachment-details .setting[data-setting="title"] input[type="text"]').val();
                
                if($(this).hasClass('button-wpmfreplace')){
                    $(this).removeClass('button-wpmfreplace noreplace').addClass('replace button-wpmfcancel').data('replace',1).text('Cancel');
                    $('.replace_drag').show();
                    var wpmf_replace = 1;
                    var wpmf_action = 'replace_image';
                }else{
                    $(this).removeClass('replace button-wpmfcancel').addClass('button-wpmfreplace noreplace').data('replace',0).text('Replace');
                    $('.replace_drag').hide();
                    var wpmf_replace = 0;
                    var wpmf_action = 'noreplace_image';
                }

                $.ajax({
                    type: 'POST',
                    url : ajaxurl,
                    data: {
                        'action': wpmf_action,
                        'wpmf_replace' : wpmf_replace,
                        'att_selected' : att_selected,
                        'wpmf_caption' : wpmf_caption,
                        'wpmf_desc' : wpmf_desc,
                        'wpmf_alt' : wpmf_alt,
                        'wpmf_title' : wpmf_title
                    }
                });
            });
        }
        
        bindselectchange();
    });
}(jQuery));