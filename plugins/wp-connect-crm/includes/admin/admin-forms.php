<?php

function check_form_not_empty() {
  if (!empty($_POST)) {
    global $wpdb;

    $id = $_POST["form"];
    $query = "SELECT * FROM wp_ctcrm_meta WHERE form_id = '$id'";
    $query_results = $wpdb->get_results($query);

    if (empty($query_results)) {
      create_form($_POST);
    } else {
      update_form($_POST);
    }

  }
}

function update_form($entry) {
  global $wpdb;

  foreach ($entry as $key => $value) {
    $wpdb->update('wp_ctcrm_metadata', [
      'ctcrm_id' => $entry['form'],
      'meta_key' => unaccent($key),
      'meta_value' => $value,
    ], [ 
      'ctcrm_id' => $entry['form'],
      'meta_key' => unaccent($key),
    ]);
  }
}

function create_form($entry) {
  global $wpdb; 

  $wpdb->insert('wp_ctcrm_meta', ['form_id' => $entry['form']]);

  foreach ($entry as $key => $value) {
    $wpdb->insert('wp_ctcrm_metadata', [
      'ctcrm_id' => $entry['form'],
      'meta_key' => unaccent($key),
      'meta_value' => $value,
    ]);
  }
}

function get_fields_form($entry, $id) {
  $fields = [
    "", "email", "phone", "firstName", "lastName", "name", "dateOfBirth", "address1", "city", "state", "country", "postalCode", "companyName", "website", "tags", "source", "customField"
  ];

  $custom_fields = ctcrm_get_custom_fields_from_crm();
  foreach ($custom_fields as $key => $cf) {
    array_push($fields, str_replace('contact.', '', $cf->fieldKey));
  }

  foreach ($entry as $key => $value) {
    global $wpdb;
    $query = "SELECT * FROM wp_ctcrm_meta WHERE form_id = '$id'";
    $query_results = $wpdb->get_results($query);

    if (!empty($query_results)) {
      $key_meta = unaccent(strtolower($value['label']));
      $query = "SELECT meta_value FROM wp_ctcrm_metadata WHERE meta_key = '$key_meta' AND ctcrm_id = '$id'";
      $meta_value = $wpdb->get_results($query);
    }

    $option = "";
    foreach ($fields as $key => $field) {
      if (!empty($meta_value) && $meta_value[0]->meta_value === unaccent($field)) {
        $mv = "selected='".$meta_value[0]->meta_value."'";
      } else {
        $mv = "";
      }
      $option .= '<option value="'.unaccent($field).'" '.$mv.'>'.$field.'</option>';
    }

    $name = unaccent(strtolower($value->label));
    $html .= <<<DATA
      <div>
        <label for="$id">$value->label: </label>
        <select name="$name" id="$id">
          $option
        </select>
      </div>
    DATA;
  }
  echo $html;
}

function display_forms() {
  $forms = GFAPI::get_forms();

  echo "<h1>Vos Formulaires</h1>";
  echo "<p>Veuillez sélectionner le champ GHL en fonction de votre champ Gravity Forms afin de lier ces 2 éléments.</p>";
  echo '<div class="ctcrm__content">';

  foreach ($forms as $key => $form) {
    $html = "";
    $name = $form["title"];
    $id = $form["id"];
    ?>
    <div class="ctcrm__body">
      <form action="?page=connect-to-crm-forms" method="POST" id="send_value_form_<?php echo $id ?>">
        <h2>Formulaire: <?php echo $name ?></h2>
        <div class="ctcrm__form-id">
          <label for="form">ID: </label>
          <input type="text" name="form" id="form" value="<?php echo $id ?>">
        </div>

        <?php get_fields_form($form['fields'], $id); ?>

        <?php submit_button(); ?>

      </form>
    </div>
    <?php
  }
  echo '</div>';
}