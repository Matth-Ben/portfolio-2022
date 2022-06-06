<?php

// add_filter('allowed_block_types', 'misha_allowed_block_types');

// function misha_allowed_block_types($allowed_blocks)
// {
//     return array(
//         'core/image',
//         'core/paragraph',
//         'core/heading',
//         'core/list'
//     );
// }

function my_acf_block_render_callback($block, $content = '', $is_preview = false)
{
  /**
   * Back-end preview
   */
  $slug = str_replace('acf/', '', $block['name']);

  if ($is_preview && array_key_exists('preview_image', $block['data'])) {
    echo '<img src="'. get_template_directory_uri() . "/assets/images/acf-block/${slug}.png" .'">';
    return;
  } else {
    echo \App\template("blocks/${slug}", ['block' => $block]);
    return;
  }
}

add_action('acf/init', function () {
  if (function_exists('acf_register_block')) {
    $dir = new DirectoryIterator(locate_template("views/blocks/"));
    foreach ($dir as $fileinfo) {
      if (!$fileinfo->isDot()) {
        $slug = str_replace('.blade.php', '', $fileinfo->getFilename());
        $file_path = locate_template("views/blocks/${slug}.blade.php");
        $file_headers = get_file_data($file_path, [
          'title' => 'Title',
          'description' => 'Description',
          'category' => 'Category',
          'icon' => 'Icon',
          'post-type' => 'Post-type',
          'keywords' => 'Keywords'
        ]);
        if (empty($file_headers['title'])) {
          die(_e('This block needs a title: ' . $file_path));
        }
        if (empty($file_headers['category'])) {
          die(_e('This block needs a category: ' . $file_path));
        }

        $datas = [
          'name' => $slug,
          'title' => $file_headers['title'],
          'description' => $file_headers['description'],
          'category' => $file_headers['category'],
          'icon' => array(
            'background' => '#000',
            'foreground' => '#bda67f',
            'src' => $file_headers['icon'],
            ),
          'keywords' => explode(' ', $file_headers['keywords']),
          'post_types' => explode(' ', $file_headers['post-type']),
          'mode' => 'edit',
          'supports' => array(
              'align' => false,
              'mode' => true,
              'jsx' => false
          ),
          'render_callback'  => 'my_acf_block_render_callback',
          'example' => array(
            'attributes' => array(
              'mode' => 'preview',
              'data' => array(
                  'preview_image' => '<img src="'. get_template_directory_uri() . "/assets/images/acf-block/${slug}.png" .'">',
              )
            ),
          ),
        ];

        acf_register_block($datas);
      }
    }
  }
});

function template_block_category($categories, $post) {
  return array_merge($categories, array(array('slug' => 'template-blocks','title' => __('Template Blocks', 'template-blocks'))));
}

add_filter('block_categories', 'template_block_category', 10, 2);
