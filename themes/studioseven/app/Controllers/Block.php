<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Block extends Controller {
  // public static function example($data) {
  //     return [
  //         'title' => Element::title($data),
  //         'image' => Element::image($data['image'], '1920px')
  //     ];
  // }

  public static function flexibleContent($data) {
    $fields = get_field($data['_blocks']);
    $index = 0;
    $components = [];

    foreach($fields as $block) {
      $component_function = toCamelCase($block['acf_fc_layout']);
      $components[$block['acf_fc_layout'] . '_' . $index] = Component::$component_function($block);
      $components[$block['acf_fc_layout'] . '_' . $index]['name'] = $block['acf_fc_layout'];
      $index++;
    }

    return [
      'components' => $components
    ];
  }

  // generated function here
}
