<?php

$config = simplexml_load_file("../inc/conf.xml");

$yesno[] = array("val"=>"Y","desc"=>"Yes");
$yesno[] = array("val"=>"N","desc"=>"No");

foreach ($yesno as $v) {
	$selected = ($config->testing==$v['val']) ? ' SELECTED':'';
	$testingOpts .= '<option value="' . $v['val'] . '"'.$selected.'>' . $v['desc'] . '</option>';
}

require("form.config.html");