<?php 

include_once('admin-forms.php');
include_once('admin-options.php');

add_action('admin_menu', 'test_plugin_setup_menu');
function test_plugin_setup_menu(){
  add_menu_page( 'Connect To CRM', 'CTCRM', 'manage_options', 'connect-to-crm', 'ctcrm_options' );
  add_submenu_page('connect-to-crm', 'Connect To CRM Formulaires', 'Formulaires', 'manage_options', 'connect-to-crm-forms', 'ctcrm_forms');
}

function ctcrm_options() {  
  check_api_key_not_empty();
  display_options();
}

function ctcrm_forms() {  
  check_form_not_empty();
  display_forms();
}