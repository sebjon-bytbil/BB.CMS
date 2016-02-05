(function($) {
    'use strict';
    $(function() {
        $('body').on('vcPanel.shown', '#vc_properties-panel', function() {
            $('body').trigger('init.tinymce');
        });

        $('body').on('click', '.vc_param_group-add_content', function() {
            $('body').trigger('init.tinymce');
        });
    });

    function refresh_values(id, content) {
        $('#' + id).siblings('input.' + id).val(content);
    }

    $('body').on('init.tinymce', function() {
        var textareas = $('.wysiwyg');

        if (undefined !== textareas && textareas.length > 0) {
            textareas.each(function(i) {
                var $this = $(this);
                if ($this.hasClass('has-tinymce')) {
                    return;
                }

                var id = 'tinymce' + i;
                $this.attr('id', id).addClass('has-tinymce');
                $this.siblings('.wysiwyg-input').addClass(id);

                if (tinymce.editors.length > 0) {
                    for (var j = 0; j < tinymce.editors.length; j++) {
                        if (tinymce.editors[j].id === id) {
                            tinymce.editors[j].remove();
                        }
                    }
                }

                tinymce.init({
                    allow_html_in_named_anchor: true,
                    cleanup: 'false',
                    content_css: bb_wysiwyg_css.urls,
                    entity_encoding: 'raw',
                    theme: "modern",
                    plugins: 'textcolor colorpicker hr media wplink wordpress',
                    toolbar: 'bold,italic,strikethrough,bullist,numlist,hr,blockquote,alignleft,aligncenter,alignright,addimage,icon-button,link,unlink,forecolor,backcolor,formatselect',
                    menubar: false,
                    selector: '#' + id,
                    setup: function(editor, url) {
                        editor.on('change', function() {
                            refresh_values(id, editor.getContent());
                        });
                        editor.addButton('addimage', {
                            icon: 'wp-media-library',
                            tooltip: 'Bild',
                            cmd: 'addimage-command'
                        });
                        editor.addCommand('addimage-command', function() {
                            if (this.window === undefined) {
                                this.window = wp.media({
                                    title: 'Lägg till bild',
                                    library: {type: 'image'},
                                    multiple: false,
                                    button: {text: 'Lägg till'}
                                });

                                var self = this;
                                this.window.on('select', function() {
                                    var first = self.window.state().get('selection').first().toJSON();
                                    var img = '<img src="' + first.url + '" alt="' + first.alt + '" title="' + first.title + '">';
                                    editor.insertContent(img);
                                });
                            }

                            this.window.open();
                            return false;
                        });
                        editor.addButton('icon-button', {
                            icon: 'charmap',
                            tooltip: 'Ikon',
                            cmd: 'add-button'
                        });
                        editor.addCommand('add-button', function() {
                            editor.windowManager.open({
                                id: 'bb-add-button',
                                title: 'Lägg till knapp',
                                body: [
                                    {
                                        id: 'buttonText',
                                        type: 'textbox',
                                        name: 'title',
                                        label: 'Knapptext'
                                    },
                                    {
                                        type: 'listbox',
                                        name: 'color',
                                        label: 'Färg',
                                        'values': JSON.parse(bb_wysiwyg_buttons.buttons)
                                    },
                                    {
                                        type: 'listbox',
                                        name: 'icon',
                                        label: 'Ikon',
                                        'values': JSON.parse(bb_wysiwyg_icons.icons)
                                    },
                                    {
                                        type: 'button',
                                        text: 'Lägg till länk',
                                        onclick: function() {
                                            $('body').addClass('tinymce-wp-link');
                                            wpActiveEditor = true;
                                            wpLink.open('wpLinkInput');
                                            return false;
                                        }
                                    },
                                    {
                                        id: 'wpLinkInput',
                                        type: 'textbox',
                                        name: 'link',
                                        style: 'display:none'
                                    },
                                    {
                                        type: 'checkbox',
                                        name: 'open_link',
                                        label: 'Öppna länken i ett nytt fönster/flik'
                                    },
                                ],
                                onsubmit: function(e) {
                                    $('body').removeClass('tinymce-wp-link');
                                    var a = e.data.link;

                                    var target = '';
                                    if (e.data.open_link === true) {
                                        target = ' target="_blank"';
                                    }

                                    var link = '';
                                    var link_match = a.match(/^.*href\=['|"](.*)?\".*$/);
                                    if (link_match !== null)  {
                                        var link = link_match[1];
                                    }
                                    var button_icon = '';
                                    if (e.data.icon != 'none') {
                                        button_icon = '<i class="' + e.data.icon + '"></i> ';
                                    }
                                    var btn = 'btn btn-' + String(e.data.color);
                                    var button = '<a href="' + link + '"' + target + ' class="' + btn + '">' + button_icon + e.data.title + '</a>';
                                    editor.insertContent(button);
                                }
                            });
                        });
                    }
                });
            });
        }
    });
})(jQuery);
