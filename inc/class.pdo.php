<?php

class pdo_functions {
	
	var $host;
	var $user;
	var $password;
	var $database;
	var $connection;
	
	function connect() {
		try {
		    $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->user, $this->password);
			return true;
		} catch (PDOException $pe) {
		    $this->connection = "Could not connect to the database {$this->database} :" . $pe->getMessage();
			return false;
		}
		
	}
	
	function select($sql) {
		
		$result = array();
		$q = $this->connection->prepare($sql); 
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$q->execute();
		
		while ($row = $q->fetch()) $result[] = $row;
		return $result;
		
	}
	
	function execute($sql) {
		return $this->connection->exec($sql);
	}
	
}