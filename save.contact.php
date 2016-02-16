<?php

if (empty($_POST)) {
    $return['error_message'] = 'nothing posted';
    $return['success'] = false;
    print json_encode($return);
    exit();
}

require_once('inc/bootstrap.php');

$contact = civicrm_api('Contact', 'Create', array(
  'version' => 3,
  'contact_type' => 'Individual',
  'first_name' => $_POST['first_name'],
  'last_name' => $_POST['last_name'],
  "api.phone.create" => array (
    "location_type_id" => 1,
    "phone" => $_POST['phone']),
  'custom_1' => $_POST['school_university'],
  'custom_2' => $_POST['grade_year'],
  'custom_3' => $_POST['moola']
));

if ($contact['is_error']>0) {
    $return = $contact['values'][$contact['id']];
    $return['success'] = true;
    print json_encode($return);
} else {
    $contact['success'] = false;
    print json_encode($contact);
}