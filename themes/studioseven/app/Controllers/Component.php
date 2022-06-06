<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Component extends Controller {
  public static function classicContent($data) {
    return [
      'titles' => Element::title($data),
      'content' => $data['content'],
      'button' => $data['button']
    ];
  }

  public static function flexibleClassicContent($data) {
    return [
      'data' => [
        'classic-content' => Component::classicContent($data),
      ]
    ];
  }

  public static function flexibleMedia($data) {
    return [
      'data' => [
        'media' => $data['media'],
        'image' => isset($data['image']) && !empty($data['image']) ? Element::image($data['image'], '50vw', NULL, true) : NULL,
        'video' => [
          'type' => isset($data['video']) && !empty($data['video']) ? get_post_mime_type($data['video']) : NULL,
          'video' => isset($data['video']) && !empty($data['video']) ? wp_get_attachment_url($data['video']) : NULL,
          'poster' => isset($data['image']) && !empty($data['image']) ? Element::image($data['image'], '50vw') : NULL
        ]
      ]
    ];
  }
}
