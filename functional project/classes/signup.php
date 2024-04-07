<?php

class SignUp
{
    private $error = "";

    public function evaluate($data)
    {
        // go through each key with an associated value
        foreach ($data as $key => $value) {

            if($key == "username") {
                if (strlen($value) > 15 || strlen($value) < 4 || strstr($value, " ")) {
                    $this->error .= $key . " must be betweeen four and fifteen and no spaces<br>";
                }
            }

            if($key == "password") {
                if (strlen($value) > 15 || strlen($value) < 4 || strstr($value, " ")) {
                    $this->error .= $key . " must be betweeen four and fifteen and no spaces<br>";
                }
            }


        }

        if ($data['password'] != $data['confirm_password']) {
            $this->error .= "passwords do not match<br>"; //adds to end of strin
        }

        if ($this->error == "") {
            return $this->createUser($data);
        } else {
            return $this->error;
        }
    }

    public function createUser($data)
    {
        $username = addslashes($data['username']);
        $password = addslashes($data['password']);

        //needs to be created
        $userid = $this->create_userid();

        $query = "insert into users (userid,username,password) values ('$userid','$username','$password')";

        $DB = new Connect();
        $DB->write($query);
    }

    private function create_userid()
    {
        $length = rand(4, 19);
        $number = "";

        for ($i = 0; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number = $number . $new_rand;
        }
        return $number;
    }
}
?>
