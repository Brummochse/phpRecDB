<?php

class DbConfig {
    
	public $_CONFIG = array (
		"host" => "", //fill in here the hostname of your database server . for example "host" => "localhost",
		"user" => "", //fill in here the username for example "user" => "username",
		"pass" => "", //fill in here the password for example "pass" => "password",
		"db"   => "" //fill in here the database name for example "db" => "database"
	);

	public function getHost() {
		return $this->_CONFIG["host"];
	}
	public function getUser() {
		return $this->_CONFIG["user"];
	}
	public function getPass() {
		return $this->_CONFIG["pass"];
	}
	public function getDb() {
		return $this->_CONFIG["db"];
	}
}
?>
