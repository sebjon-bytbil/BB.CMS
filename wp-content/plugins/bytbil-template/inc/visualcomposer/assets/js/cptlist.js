window.addEventListener('getCptList', function(e) {
    var postType = e.detail;

    if (postType !== '') {
        var $i = jQuery('#cptlist-input');
        var $cl = jQuery('.cptlist ul');
        var $cla = jQuery('.cptlist-added ul');
        var added = [];

        var data = {
            'action': 'getcptlist',
            'method': 'post',
            'post_type': postType
        };

        jQuery.post('/wp-admin/admin-ajax.php', data, function(response) {
            var json = JSON.parse(response);

            $cl.removeSpinner();
            $cla.removeSpinner();

            for (var i = 0; i < json.length; i++) {
                if ($i.val().indexOf(json[i].id) > -1) {
                    var obj = {
                        'index': $i.val().indexOf(json[i].id),
                        'id': json[i].id,
                        'title': json[i].title
                    };
                    added.push(obj);
                } else {
                    appendToList($cl, json[i].id, json[i].title);
                }
            }

            added.sort(keysrt('index'));

            for (var i = 0; i < added.length; i++) {
                appendToList($cla, added[i].id, added[i].title);
            }

            $cla.setSortable();
        });
    } else {
        console.log('No post type selected.');
    }

    var initSearch = new Event('initSearch');
    window.dispatchEvent(initSearch);
});

window.addEventListener('initSearch', function() {
    var value = null,
        get = null;

    var delay = (function() {
        var timer = 0;
        return function(callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

    (function($) {
        var $cl = $('.cptlist ul');
        var $cla = $('.cptlist-added ul');
        var input = $('.cptlist-search input[type=search]');
        var postType = input.data('posttype');
        input.on('keyup', function() {
            delay(function() {
                $cl.empty();
                $cl.addSpinner();

                value = input.val();
                if (get !== null) {
                    get.abort();
                }

                get = $.get(
                    '/wp-admin/admin-ajax.php',
                    {
                        action: 'searchcptlist',
                        post_type: postType,
                        value: value
                    }, function(response) {
                        var json = JSON.parse(response);

                        $cl.removeSpinner();

                        for (var i = 0; i < json.length; i++) {
                            if ($cla.find('li[data-id=' + json[i].id + ']').length == 0) {
                                appendToList($cl, json[i].id, json[i].title);
                            }
                        }
                    }
                );
            }, 500);
        });
    })(jQuery);
});

jQuery.fn.extend({
    removeSpinner: function() {
        return this.find('.cptlist-loading').remove();
    },
    addSpinner: function() {
        return this.append('<li class="cptlist-loading"><img src="/wp-content/plugins/bb-admin/inc/visualcomposer/assets/images/wpspin_light.gif"></li>');
    },
    setSortable: function() {
        return Sortable.create(this[0], {
            onEnd: function (e) {
                updateCptlist(e.oldIndex, e.newIndex);
            }
        });
    }
});

function keysrt(key,desc) {
    return function(a,b) {
        return desc ? ~~(a[key] < b[key]) : ~~(a[key] > b[key]);
    }
}

function appendToList($l, id, text) {
    $l.append('<li class="noselect" data-id="' + id + '">' + text + '</li>');
}

function updateCptlist(oldIndex, newIndex) {
    var v = jQuery('#cptlist-input');
    var $cla = jQuery('.cptlist-added ul');

    var newvalue = '';

    $cla.children('li').each(function(i, e) {
        if (i !== 0) {
            newvalue += ',';
        }
        newvalue += String(jQuery(this).data('id'));
    });

    v.val(newvalue);
}

(function($, document) {
    $(document).ready(function() {
        $(document).on('click', '.cptlist li', function() {
            var $i = $('#cptlist-input');
            var $cla = $('.cptlist-added ul');
            var id = $(this).data('id');

            if ($i.val().indexOf(',') < 0 && $i.val() == '') {
                $i.val(id);
            } else {
                $i.val($i.val() + ',' + id);
            }

            appendToList($cla, id, $(this).text());
            $(this).remove();
        });

        $(document).on('click', '.cptlist-added li', function() {
            var s = $('.cptlist-search input[type=search]');
            var $i = $('#cptlist-input');
            var $cl = $('.cptlist ul');
            var id = $(this).data('id');

            var split = $i.val().split(',');
            var index = split.indexOf(String(id));
            if (index > -1) {
                split.splice(index, 1);
            }

            var value = split.join();

            $i.val(value);

            if (s.val() !== '') {
                var text = $(this).text();
                if (text.toLowerCase().indexOf(s.val().toLowerCase()) > -1) {
                    appendToList($cl, $(this).data('id'), text);
                }
            } else {
                appendToList($cl, $(this).data('id'), $(this).text());
            }
            $(this).remove();
        });
    });
})(jQuery, document);
