<?php

if (empty($_POST)) {
    $return['error_message'] = 'nothing posted';
    $return['success'] = false;
    print json_encode($return);
    exit();
}

require_once('inc/bootstrap.php');

$contact = civicrm_api('Contact', 'Getsingle', array(
  'version' => 3,
  'id' => $_POST['id'],
  'return' => array('first_name','last_name','phone','birthday','custom_1','custom_2','custom_3')
));

$contact['success'] = true;
print json_encode($contact);