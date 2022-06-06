<?php

add_action( 'gform_after_submission', 'ctcrm_send_contact', 10, 2 );
function ctcrm_send_contact($entry, $form) {
  global $wpdb;

  $data = [];
  $id = $form['id'];
  $url = "https://rest.gohighlevel.com/v1/contacts/";
  $custom_values = ctcrm_get_custom_fields_from_crm();
  $array_cv = [];

  foreach ($custom_values as $key => $cv) {
    array_push($array_cv, str_replace('contact.', '', $cv->fieldKey));
  }

  foreach ($form['fields'] as $key => $value) {
    if ($entry[$value->id]) {
      $label = unaccent(strtolower($value->label));
      $query = "SELECT meta_value FROM wp_ctcrm_metadata WHERE ctcrm_id='$id' AND meta_key='$label'";
      $query_results = $wpdb->get_results($query);

      if (in_array($query_results[0]->meta_value, $array_cv)) {
        $data['customField'][$query_results[0]->meta_value] = $entry[$value->id];
      } else {
        $data[$query_results[0]->meta_value] = $entry[$value->id];
      }
    }
  }

  $data = json_encode($data);

  $curl = curl_init();
  $api_key = get_api_key();

  curl_setopt_array($curl, [
    CURLOPT_URL => "https://rest.gohighlevel.com/v1/contacts/",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "$data",
    CURLOPT_HTTPHEADER => [
      "Authorization: Bearer $api_key",
      "Content-Type: application/json",
      "Version: 1"
    ],
  ]);

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);
}