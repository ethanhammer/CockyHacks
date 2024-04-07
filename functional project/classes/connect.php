<?php


class Connect {

	private $host= "localhost"; //will change to make go online
	private $username="root"; 
	private $password= "";
	private $db="cockbots_db";

	function connectToDb() {
		$connection = mysqli_connect($this->host,$this->username,$this->password,$this->db);
		return $connection;
	}

	function read($query) {
		$connection = $this->connectToDb();
		$result = mysqli_query($connection, $query);

		if($result == false) {
			return false;
		} 
		$data = false;
		while ($row = mysqli_fetch_assoc($result)) {
			 $data[] = $row; // adds to t=end of data row
		}
		return $data;
	}

	function write($query) {

		$connection = $this->connectToDb();
		$result = mysqli_query($connection, $query);

		if($result == false) {
			return false;
		} else {
			return true;
		}

	}

}


