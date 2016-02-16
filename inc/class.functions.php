<?php

class functions {
	function testDbConnection() {
	 	$sql = "SHOW TABLES;";
		$result = $GLOBALS['db']->select($sql);
		if (!$result) {
	    	return false;
	    } else {
		 	return $result;
		}
	}

}