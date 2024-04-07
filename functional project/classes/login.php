<?php


class Login {

	private $error = "";

	public function check($data) {

        $username = addslashes($data['username']);
        $password = addslashes($data['password']);

        $query = "select * from users where username = '$username' limit 1";

        $DB = new Connect();
        $result = $DB->read($query);

        if($result) {
        	$row = $result[0];

        	if($password != $row['password']) {
        		$this->error .= "Incorrect Credentials";
        	} else {
        		$_SESSION['userid'] = $row['userid'];
        	}
        } else {
        	$this->error .= "Incorrect Credentials";
        }

        echo($this->error);
        return $this->error; 
	}

    //ensure that the user id exists and is numeric
	public function checkUserId($id) {

        if(is_numeric($id)) {

		$query = "select * from users where userid = '$id' limit 1";

        $DB = new Connect();
        $result = $DB->read($query);

        if($result) {
            $user_data = $result[0];
        	return $user_data;
        } else {
            header("Location: login.php");
            die;
        }
        
        print_r($user_data);

	}else {
        header("Location: login.php");
        die;
     }
}
}