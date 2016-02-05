(function() {
    // Add TinyMCE plugin
    tinymce.PluginManager.add('extra-buttons', function(editor, url) {
        // Add command
        editor.addCommand('something', function() {
            alert('something');
        });

        // Add button
        editor.addButton('icon-button', {
            icon: 'hr',
            tooltip: 'Ikon',
            cmd: 'something'
        });

        // Add menu item
        editor.addMenuItem('icon-button', {
            icon: 'hr',
            text:' Ikon',
            cmd: 'something',
            context: 'insert'
        });
    });
})();
