/** 
 * We developed this code with our hearts and passion.
 * @package wp-media-folder
 * @copyright Copyright (C) 2014 JoomUnited (http://www.joomunited.com). All rights reserved.
 * @license GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

(function($){
    
   
    $(document).ready(function(){
        bindselectchange = function(){
            
            $(document).on('click', '.manage-column', function(event) {
                var $this = $(this);
                var id = $this.attr('id');
                if(id == 'wpmf_size'){
                    var orderby = 'size';
                }else if(id == 'wpmf_filetype'){
                    var orderby = 'filetype';
                }else{
                    var orderby = id;
                }
                if($this.hasClass('asc')){
                    var order  = 'desc';
                }else{
                    var order = 'asc';
                }
                
                if($('body').hasClass('upload-php')){
                    $.ajax({
                        type : "POST",
                        url : ajaxurl,
                        data :  {
                            action : "wpmf_media_order",
                            value : orderby + '|' + order
                        }
                    });
                }
            });
            
            $(document).on('change', '.wpmf-order-media', function(event) {
                var $this = $(this);
                $.ajax({
                    type : "POST",
                    url : ajaxurl,
                    data :  {
                        action : "wpmf_media_order",
                        value : $this.val()
                    }
                });
            });
           
            $(document).on('change', '.wpmf-order-folder.wpmf-order', function(event) {
                var $this = $(this);
                $.ajax({
                    type : "POST",
                    url : ajaxurl,
                    data :  {
                        action : "wpmf_folder_order",
                        wpmf_folder_order : $('#media-order-folder').val()
                    },
                    success:function(res){
                        order_f = $this.val();
                        if(res != 'all'){
                            var selectID = $('.wpmf-categories option:selected').data('id');
                            
                            if(page != 'table'){
                                $('[id^="__wp-uploader-id-"]:visible .wpmf-categories option[data-id="'+ selectID +'"]').prop('selected',true).change();
                                var dir = $('.directory.expanded.selected').find('>a').data('file');
                                if(page != 'table'){
                                    closedir('/');
                                    if(term_root_id && wpmf_active_media == 1 && wpmf_role !='administrator'){
                                        var root_id = parseInt(term_root_id);
                                    }else{
                                        var root_id = 0;
                                    }
                                    
                                    bcat = wpmf_categories[currentCategory];  
                                    var dirs = [];
                                    dirs.push( bcat.id);
                                    if(wpmf_active_media == 1 && wpmf_role !='administrator'){
                                        $('.jaofiletree li').removeClass('selected');
                                        $('.directory').find('.md').removeClass('md-folder-open').addClass('md-folder');
                                        $('.jaofiletree li[data-id="'+ selectedId +'"]').addClass('selected');
                                    }else{
                                        while(bcat.parent_id !=0){   
                                            bcat = wpmf_categories[wpmf_categories[bcat.id].parent_id];
                                            if(bcat.id != 0){
                                                dirs.unshift(bcat.id);
                                            }
                                        }   
                                    }
                                    dirs.unshift("0");
                                    opensortfolders(dirs, currentCategory);
                                }
                            }else{
                                $('.wpmf-categories option[data-id="'+ selectID +'"]').prop('selected',true).change();
                            }
                        }
                    }
                });
            });
        }
        
        opensortfolders = function(dirs , selectedId) {  
            if(dirs.length==1 && dirs[0]==0) { 
                setSelectedFolder(0);
                return true;
            }
            parent_id = dirs.shift(); 
            var cdir = $('#jao a[data-id="' + parent_id + '"]').data('file');  
            if(dirs.length===0) {
                openfolder(cdir, function(){setSelectedFolder(selectedId)} );
                return true;
            }          
          
            openfolder( cdir, function(){openfolders(dirs,selectedId);} );          
            return true;
        };
        
        bindselectchange();
        if(typeof wp != "undefined"){
            if ( wp.media && $('body.upload-php table.media').length===0 ) {
                if(wp.media.view.AttachmentFilters == undefined || wp.media.view.AttachmentsBrowser == undefined) return ;
                FilterSizeWeight = function(){
                    //=========================================================================
                    
                    wp.media.view.AttachmentFilters['wpmf_attachment_mimetype'] = wp.media.view.AttachmentFilters.extend({
                            className: 'attachment-filters attachment-mimetype',
                            id: 'media-attachment-size-mimetype',
                            createFilters: function() {
                                var filters = {};
                                _.each( wpmf_post_mime_type || [], function( text, key ) {
                                    filters[ key ] = {
                                        text: text[0],
                                        props : {
                                            status:  null,
                                            type:    key,
                                            uploadedTo: null,
                                            orderby: false
                                        },
                                    };                                        
                                });
                                
                                filters['unattached'] = {
                                    text: 'Unattached',
                                    props : {
                                        status:  null,
                                        type:    '',
                                        uploadedTo: null,
                                        orderby: false
                                    },
                                };   
                                
                                
                                filters.all = {
                                        text:  wpmflang.mimetype,
                                        props: {
                                            status:  null,
                                            type:    null,
                                            uploadedTo: null,
                                            orderby: false
                                        },
                                        priority: 10
                                };
                                
                                this.filters = filters;
                            }
                    });
                    
                    
                    
                    wp.media.view.AttachmentFilters['wpmf_attachment_size'] = wp.media.view.AttachmentFilters.extend({
                            className: 'wpmf-attachment-size attachment-filters',
                            id: 'media-attachment-size-filters',
                            createFilters: function() {
                                var filters = {};
                                _.each( wpmf_size || [], function( text, key ) {
                                    filters[ text ] = {
                                        text: text,
                                        props : {
                                            wpmf_size: text
                                        },
                                    };                                        
                                });
                                
                                filters.all = {
                                        text:  wpmflang.all_size_label,
                                        props: {
                                            wpmf_size: 'all',
                                        },
                                        priority: 10
                                };
                                
                                this.filters = filters;
                            }
                    });
                    
                    wp.media.view.AttachmentFilters['wpmf_attachment_weight'] = wp.media.view.AttachmentFilters.extend({
                            className: 'wpmf-attachment-weight attachment-filters',
                            id: 'media-attachment-weight-filters',
                            createFilters: function() {
                                var filters = {};
                                _.each( wpmf_weight || [], function( text, key ) {
                                    var labels = text[0].split('-');
                                    if(text[1] == 'kB'){
                                        var label = (labels[0]/1024)+' kB-'+(labels[1]/1024)+' kB';
                                    }else{
                                        var label = (labels[0]/(1024*1024))+' MB-'+(labels[1]/(1024*1024))+' MB';
                                    }
                                    filters[ text[0] ] = {
                                        text: label,
                                        props : {
                                            wpmf_weight: text[0]
                                        },
                                    };                                        
                                });
                            
                                filters.all = {
                                        text:  wpmflang.all_weight_label,
                                        props: {
                                            wpmf_weight: 'all',
                                        },
                                        priority: 10
                                };
                                
                                this.filters = filters;
                            }
                    });
                    
                    
                    wp.media.view.AttachmentFilters['wpmf_order_folder'] = wp.media.view.AttachmentFilters.extend({
                            className: 'wpmf-order-folder attachment-filters',
                            id: 'media-order-folder',
                            createFilters: function() {
                                var filters = {};
                                _.each( order_folder || [], function( text, key ) {
                                    filters[ key ] = {
                                        text: text,
                                        props : {
                                            wpmf_order_folder: key
                                        },
                                    };                                        
                                });
                            
                                filters.all = {
                                        text:  wpmflang.order_folder_label,
                                        props: {
                                            wpmf_order_folder: 'name-asc',
                                        },
                                        priority: 10
                                };
                                
                                this.filters = filters;
                            }
                    });
                    
                    wp.media.view.AttachmentFilters['wpmf_order_media'] = wp.media.view.AttachmentFilters.extend({
                            className: 'wpmf-order-media attachment-filters',
                            id: 'media-order-media',
                            createFilters: function() {
                                var filters = {};
                                _.each( order_media || [], function( text, key ) {
                                    switch (key){
                                        case 'date|asc':
                                            filters[ key ] = {
                                                text: text,
                                                props : {
                                                    orderby: false,
                                                    wpmf_orderby: 'date',
                                                    order: 'ASC',
                                                },
                                            };
                                            break;
                                            
                                        case 'date|desc':
                                            filters[ key ] = {
                                                text: text,
                                                props : {
                                                    orderby: false,
                                                    wpmf_orderby: 'date',
                                                    order: 'DESC',
                                                },
                                            };
                                            break;
                                            
                                        case 'title|asc':
                                            filters[ key ] = {
                                                text: text,
                                                props : {
                                                    orderby: false,
                                                    wpmf_orderby: 'title',
                                                    order: 'ASC',
                                                },
                                            };
                                            break;
                                            
                                        case 'title|desc':
                                            filters[ key ] = {
                                                text: text,
                                                props : {
                                                    orderby: false,
                                                    wpmf_orderby: 'title',
                                                    order: 'DESC',
                                                },
                                            };
                                            break;
                                        
                                        case 'size|asc':
                                            filters[ key ] = {
                                                text: text,
                                                props : {
                                                    meta_key: 'wpmf_size',
                                                    orderby: false,
                                                    wpmf_orderby: 'meta_value_num',
                                                    order: 'ASC',
                                                },
                                            };
                                            break;
                                            
                                        case 'size|desc':
                                            filters[ key ] = {
                                                text: text,
                                                props : {
                                                    meta_key: 'wpmf_size',
                                                    orderby: false,
                                                    wpmf_orderby: 'meta_value_num',
                                                    order: 'DESC',
                                                },
                                            };
                                            break;    
                                            
                                        case 'filetype|asc':
                                            filters[ key ] = {
                                                text: text,
                                                props : {
                                                    meta_key: 'wpmf_filetype',
                                                    orderby: false,
                                                    wpmf_orderby: 'meta_value',
                                                    order: 'ASC',
                                                },
                                            };
                                            break;
                                        
                                        case 'filetype|desc':
                                            filters[ key ] = {
                                                text: text,
                                                props : {
                                                    meta_key: 'wpmf_filetype',
                                                    orderby: false,
                                                    wpmf_orderby: 'meta_value',
                                                    order: 'DESC',
                                                },
                                            };
                                            break;
                                            
                                    }
                                });
                            
                                filters.all = {
                                        text:  wpmflang.order_img_label,
                                        props: {
                                            orderby: 'title',
                                            order: 'ASC',
                                        },
                                        priority: 10
                                };
                                
                                this.filters = filters;
                            }
                    });
                    
                    // backup the method
                    var orig = wp.media.view.AttachmentsBrowser;

                    wp.media.view.AttachmentsBrowser = wp.media.view.AttachmentsBrowser.extend({
                            createToolbar: function() {
                                    // call the original method
                                    orig.prototype.createToolbar.apply(this,arguments);
                                    
                                    this.toolbar.set('mimetypetags', new wp.media.view.AttachmentFilters['wpmf_attachment_mimetype']({
                                            controller: this.controller,
                                            model:      this.collection.props,
                                            priority:   -90
                                    }).render() );
                                    
                                    // add our custom filter
                                    this.toolbar.set('sizetags', new wp.media.view.AttachmentFilters['wpmf_attachment_size']({
                                            controller: this.controller,
                                            model:      this.collection.props,
                                            priority:   -74
                                    }).render() );
                                    
                                    this.toolbar.set('weighttags', new wp.media.view.AttachmentFilters['wpmf_attachment_weight']({
                                            controller: this.controller,
                                            model:      this.collection.props,
                                            priority:   -74
                                    }).render() );
                                    
                                    this.toolbar.set('orderfoldertags', new wp.media.view.AttachmentFilters['wpmf_order_folder']({
                                            controller: this.controller,
                                            model:      this.collection.props,
                                            priority:   -74
                                    }).render() );
                                    
                                    this.toolbar.set('ordermediatags', new wp.media.view.AttachmentFilters['wpmf_order_media']({
                                            controller: this.controller,
                                            model:      this.collection.props,
                                            priority:   -74
                                    }).render() );
                            },
                    });
                    
                    //=========================================================================
                };
                FilterSizeWeight();
                
                wp.media.view.AttachmentsBrowser.prototype.on('ready',function(){
                    if(typeof wp.media.model.Query != "undefined"){
                        var defaultProps = wp.media.model.Query.defaultProps;
                        defaultProps['orderby'] = false;
                        
                        var Attachments = wp.media.model.Attachments
                        Attachments.all = new Attachments();
                        wp.media.query = function( props ) {
                            return new Attachments( null, {
                                    props: _.extend( _.defaults( props || {}, { orderby: false } ), { query: true } )
                            });
                        };
                    }
                        
                    if(wpmf_order_media && wpmf_order_media != ''){
                        $('.wpmf-order-media option[value="'+ wpmf_order_media +'"]').prop('selected',true).change();
                    }
                    
                    if(wpmf_order_f && wpmf_order_f != '' && $('[id^="__wp-uploader-id-"]:visible .wpmf-order-folder').val() == 'all'){
                        $('[id^="__wp-uploader-id-"]:visible .wpmf-order-folder option[value="'+ wpmf_order_f +'"]').prop('selected',true).change();
                    }
                    $('[id^="__wp-uploader-id-"]:visible .wpmf-order-folder').addClass('wpmf-order');
                });
                
            }else{
                if( typeof wpmf_size == "undefined" || typeof wpmf_weight == "undefined") return;

                var filter_size = '<select name="attachment_size" class="wpmf-attachment-size">';
                filter_size += '<option value="all" selected>'+ wpmflang.all_size_label +'</option>';
                $.each(wpmf_size,function(key){
                    if(this == size){
                        filter_size += '<option value="'+ this +'" selected>'+ this +'</option>';
                    }else{
                        filter_size += '<option value="'+ this +'">'+ this +'</option>';
                    }
                })

                filter_size += '</select>';
                
                var filter_weight = '<select name="attachment_weight" class="wpmf-attachment-weight">';
                filter_weight += '<option value="all" selected>'+ wpmflang.all_weight_label +'</option>';
                $.each(wpmf_weight,function(key,text){
                    var labels = text[0].split('-');
                    if(text[1] == 'kB'){
                        var label = (labels[0]/1024)+' kB-'+(labels[1]/1024)+' kB';
                    }else{
                        var label = (labels[0]/(1024*1024))+' MB-'+(labels[1]/(1024*1024))+' MB';
                    }
                    if(text[0] == weight){
                        filter_weight += '<option value="'+ text[0] +'" selected>'+ label +'</option>';
                    }else{
                        filter_weight += '<option value="'+ text[0] +'">'+ label +'</option>';
                    }
                })

                filter_weight += '</select>';
                
                var filter_order = '<select name="folder_order" id="media-order-folder" class="wpmf-order-folder wpmf-order">';
                filter_order += '<option value="name-asc" selected>'+ wpmflang.order_folder_label +'</option>';
                $.each(order_folder,function(key,text){
                    if(key == order_f){
                        filter_order += '<option value="'+ key +'" selected>'+ text +'</option>';
                    }else{
                        filter_order += '<option value="'+ key +'">'+ text +'</option>';
                    }
                })

                filter_order += '</select>';
                
                $('.wpmf-categories').after(filter_size);
                $('.wpmf-attachment-size').after(filter_weight);
                $('.wpmf-attachment-weight').after(filter_order);
                
                if(wpmf_order_f && wpmf_order_f != ''){
                    $('.wpmf-order-folder option[value="'+ wpmf_order_f +'"]').prop('selected',true);
                }
            }
        }
    });
}(jQuery));