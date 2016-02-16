<?php
    
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

require_once("class.db.php");
require_once("class.dbclass.php");
$dbClass = new dbclass($_POST);