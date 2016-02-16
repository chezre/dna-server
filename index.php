<?php

require_once('inc/bootstrap.php');

$contact = civicrm_api('Contact', 'Get', array(
  'version' => 3,
));

echo "<pre />";
print_r($contact);
exit();