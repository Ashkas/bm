export default {
  init() {
    (function() {

     tinymce.PluginManager.add('mce_buttons',function(editor,url) {
        //Adds smallcaps button to the toolbar
        editor.addButton('smallcaps', {
            title: 'Smallcaps',
            icon: 'forecolor',
            onclick: function (evt) {
                ed.focus();
                ed.undoManager.beforeChange();//Preserve highlighted area for undo
                ed.formatter.toggle('smallcaps');
                ed.undoManager.add();//Add an undo point
            },
            onPostRender: function() {
                var ctrl = this;
                ed.on('NodeChange', function(e) {
                    //Set the state of the smallcaps button to match the state of the selected text.
                    ctrl.active(ed.formatter.match('smallcaps'));
                });
            },
            formats: {
            smallcaps: {
              inline: 'span',
              styles: {
                'font-variant': 'small-caps',
              },
              attributes: {
                title: 'smallcaps',
              },
            },
          },
          toolbar: 'smallcaps_button',
        });
      });
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
