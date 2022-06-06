(function() {
  tinymce.PluginManager.add( 'swpquote', function( editor, url ) {
      // Add Button to Visual Editor Toolbar
      editor.addButton('swpquote', {
          title: 'Insert Lorem Ipsum',
          cmd: 'swpquote',
          image: url + '/insert-lorem-ipsum.svg',
      });
      editor.addCommand('swpquote', function() {
          var return_text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent mollis neque id est ornare interdum. Vestibulum metus diam, eleifend nec enim ac, blandit dictum sem. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In hac habitasse platea dictumst. Vivamus risus sapien, tincidunt ac semper at, hendrerit nec mi. Aliquam tincidunt risus non turpis tincidunt, et mattis magna sodales.';
          editor.execCommand('mceReplaceContent', false, return_text);
          return;
      });
  });
})();
