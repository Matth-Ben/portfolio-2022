<?php

function ctcrm_get_custom_fields_from_crm() {
  $url = "https://rest.gohighlevel.com/v1/custom-fields/";
  $api_key = get_api_key();

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

  $headers = array(
  "Accept: application/json",
  "Authorization: Bearer $api_key",
  );
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  //for debug only!
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  $resp = curl_exec($curl);
  curl_close($curl);

  $json = json_decode($resp);
  $custom_fields = $json->customFields;

  return $custom_fields;
}