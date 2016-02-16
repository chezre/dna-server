<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$cfgFile = "../inc/conf.xml";
$config = simplexml_load_file($cfgFile);
if (empty($config->registration->registrationKey)) {
	
	$url = 'http://www.netninja.co.za/site.register.php';
	$site = $_SERVER['SERVER_NAME'];

	$date = date("Y-m-d H:i:s");
	$key = sha1($date.$site);
	$fields_string = "url=".urlencode($site)."&url_datetime=".urlencode($date)."&url_key=".$key;
	
	$ch = curl_init();
	
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, 3);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
	
	$output = curl_exec($ch);
	
	if(curl_errno($ch))
	{
	    echo 'Curl error: ' . curl_error($ch);
	} else {
		curl_close($ch);
		$json = json_decode($output,true);
		$config->registration->registrationKey = $json['registration']['license_key'];
		$config->registration->registrationDate = $json['registration']['license_datetime'];
		file_put_contents($cfgFile, $config->asXml());
	}
}

echo $config->registration->registrationKey;