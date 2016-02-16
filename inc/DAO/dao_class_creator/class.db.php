<?php

Class db {

	var $username;
	var $password;
	var $host = "localhost";
	var $database;
	var $connection;

	function connect() {
		$this->connection = mysql_connect($this->host,$this->username,$this->password);
		mysql_select_db($this->database);
		return $this->connection;
	}

	function select($sql) {
		$rows = mysql_query($sql,$this->connection);
		if (!$rows) {
			return mysql_error();
		}
		$result = array();
		while ($row = mysql_fetch_assoc($rows)) {
			$result[] = $row;
		}
		return $result;
	}

    function execute($sql) {
		$result = mysql_query($sql,$this->connection);
		if (!$result) {
			return mysql_error();
		} else {
			return true;
		}
    }
    
	function close() {
		$close = mysql_close($this->connection);
		return $close;
	}
}

?>