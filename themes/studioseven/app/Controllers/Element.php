<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Element extends Controller {
  /* Get the image url, srcset, sizes & alt attributes for WP image  */
  public static function image($imageId, $maxWidth, $class = null, $noLazy = null) {
    $alt = get_post_meta($imageId, '_wp_attachment_image_alt', TRUE);

    return [
      'url' => wp_get_attachment_image_url($imageId, 'hd'),
      'url-low-quality' => wp_get_attachment_image_url($imageId, 'thumbnail'),
      'srcset' => [
        '240w' => wp_get_attachment_image_url($imageId, 'xs'),
        '480w' => wp_get_attachment_image_url($imageId, 'sm'),
        '768w' => wp_get_attachment_image_url($imageId, 'md'),
        '1024w' => wp_get_attachment_image_url($imageId, 'lg'),
        '1200w' => wp_get_attachment_image_url($imageId, 'xl'),
        '1400w' => wp_get_attachment_image_url($imageId, 'xxl'),
        '1600w' => wp_get_attachment_image_url($imageId, 'xxxl')
      ],
      'alt' => $alt ? $alt : 'image',
      'max-width' => $maxWidth,
      'class' => $class,
      'no-lazy' => $noLazy
    ];
  }

  /* Get the title and headings  */
  public static function title($data) {
    return [
      'suptitle' => $data['suptitle'],
      'title' => $data['title'],
      'hn' => $data['hn']
    ];
  }
}
