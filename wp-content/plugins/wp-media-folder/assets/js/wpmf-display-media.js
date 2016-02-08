(function($){
    $(document).ready(function(){
        if(typeof wp != "undefined"){
            if ( wp.media && $('body.upload-php table.media').length===0 ) {
                if(wp.media.view.AttachmentFilters == undefined || wp.media.view.AttachmentsBrowser == undefined) return ;
                wpmffilterDisplayMedia = function(){
                    //=========================================================================
                    wp.media.view.AttachmentFilters['wpmf_filter_display_media'] = wp.media.view.AttachmentFilters.extend({
                            className: 'wpmf-filter-display-media attachment-filters',
                            id: 'wpmf-display-media-filters',
                            createFilters: function() {
                                var filters = {};
                                _.each( wpmf_display_media || [], function( text, key ) {
                                    filters[ key ] = {
                                        text: text,
                                        props : {
                                            wpmf_display_media: key,
                                        },
                                    };                                        
                                });
                                
                                filters.all = {
                                        text:  'No',
                                        props: {
                                            wpmf_display_media: 'no'
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
                                    this.toolbar.set('displaymediatags', new wp.media.view.AttachmentFilters['wpmf_filter_display_media']({
                                            controller: this.controller,
                                            model:      this.collection.props,
                                            // controls the position, left align if < 0, right align otherwise
                                            priority:   -80
                                    }).render() );
                            },
                    });
                    
                    //=========================================================================
                };
                if(wpmf_role == 'administrator'){
                    wpmffilterDisplayMedia();
                }
                
            }else{
                if(typeof no_media_label == "undefined") no_media_label = 'No';
                if(typeof yes_media_label == "undefined") yes_media_label = 'Yes';
                var filter_displaymedia = '<select name="wpmf-display-media-filters" id="wpmf-display-media-filters" class="wpmf-filter-display-media attachment-filters">';
                filter_displaymedia += '<option value="all" selected>'+ no_media_label +'</option>';
                filter_displaymedia += '<option value="yes" selected>'+ yes_media_label +'</option>';
                filter_displaymedia += '</select>';
                $('.wpmf-categories').after(filter_displaymedia);
            }
        }
    });
}(jQuery));