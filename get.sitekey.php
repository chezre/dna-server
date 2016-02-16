<?php 

require_once('inc/bootstrap.php');
$return['key'] = (string)$GLOBALS['captcha.publickey'];
echo json_encode($return);