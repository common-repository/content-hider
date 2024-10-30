(function() {
    tinymce.create('tinymce.plugins.Wpch', {
        init : function(ed, url) {
            ed.addButton('wpch_lock_content', {
                title : 'Hide Content',
                cmd : 'wpch_lock_content',
                image : url + '/lock.png'
            });
            ed.addCommand('wpch_lock_content', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '[lock_content]' + selected_text + '[/lock_content]';
                ed.execCommand('mceInsertContent', 0, return_text);
            });
        },
        // ... Hidden code
    });
    // Register plugin
    tinymce.PluginManager.add( 'wpch_plugin', tinymce.plugins.Wpch );
})();