<?php
add_action( 'after_setup_theme', 'custom_tinymce_theme_setup' );
if ( ! function_exists( 'custom_tinymce_theme_setup' ) ) {
  function custom_tinymce_theme_setup(){
    /********* TinyMCE Buttons ***********/
    add_action( 'init', 'custom_tinymce_buttons' );
  }
}
/********* TinyMCE Buttons ***********/
if ( ! function_exists( 'custom_tinymce_buttons' ) ) {
  function custom_tinymce_buttons() {
    if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
          return;
      }
      if ( get_user_option( 'rich_editing' ) !== 'true' ) {
          return;
      }
      add_filter( 'mce_external_plugins', 'custom_tinymce_add_buttons' );
      add_filter( 'mce_buttons', 'custom_tinymce_register_buttons' );
  }
}
if ( ! function_exists( 'custom_tinymce_add_buttons' ) ) {
  function custom_tinymce_add_buttons( $plugin_array ) {
      $plugin_array['swpquote'] = get_stylesheet_directory_uri().'/admin/tinymce-insert-li/insert-lorem-ipsum.js';
      return $plugin_array;
  }
}
if ( ! function_exists( 'custom_tinymce_register_buttons' ) ) {
  function custom_tinymce_register_buttons( $buttons ) {
      array_push( $buttons, 'swpquote' );
      return $buttons;
  }
}
