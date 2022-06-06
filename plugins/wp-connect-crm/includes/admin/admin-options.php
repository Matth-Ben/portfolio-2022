<?php

function display_options() {
  $forms = GFAPI::get_forms();
  $key = get_api_key();
 
  ?>
    <div class="ctcrm__body">
      <h1 class="ctcrm__title">Connecteur Gravity Forms à GHL</h1>
      <p>Veuillez entrer votre clé API de votre compte GHL afin de lié vos formulaire Gravity Forms à votre espace GHL.</p>
      <form action="?page=connect-to-crm" method="POST" id="send_value_form_<?php echo $key ?>">
        <div>
          <label for="api_key">Key Api: </label>
          <input type="text" name="api_key" id="api_key" value="<?php echo $key ?>">
        </div>
        <?php submit_button(); ?>
      </form>
    </div>
  <?php
}

function check_api_key_not_empty() {
  if (!empty($_POST)) {
    global $wpdb;

    $key = $_POST['api_key'];
    $query = "SELECT * FROM wp_ctcrm_options WHERE meta_key = 'api_key'";
    $query_results = $wpdb->get_results($query);

    if (empty($query_results)) {
      create_data($_POST);
    } else {
      update_data($_POST);
    }

  }
}

function update_data($entry) {
  global $wpdb;

  $wpdb->update('wp_ctcrm_options', [
    'meta_key' => 'api_key',
    'meta_value' => $entry['api_key']
  ], [ 
    'meta_key' => 'api_key',
    'meta_value' => $entry['api_key']
  ]);
}

function create_data($entry) {
  global $wpdb; 

  $wpdb->insert('wp_ctcrm_options', [
    'meta_key' => 'api_key',
    'meta_value' => $entry['api_key'],
  ]);
}