<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Index extends Controller {
  function content() {
    $post = get_post($GLOBALS['page-for-posts']);
    $content = apply_filters('the_content', $post->post_content);

    return $content;
  }
}
