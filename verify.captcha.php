<?php

require_once('inc/bootstrap.php');

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$result['verified'] = false;
if (!empty($_POST['g-recaptcha-response'])) {
	
	$captcha = $_POST['g-recaptcha-response'];
	$privatekey = $GLOBALS['captcha.privatekey'];
	$url = "https://www.google.com/recaptcha/api/siteverify?secret=$privatekey";
	$response=file_get_contents("$url&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
	$r = json_decode($response);
	$result['verified'] = $r->success;
	
}
echo json_encode($result);