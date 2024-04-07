<?php


class User {
	public function get_data($id) {

		$query = "select * from users where userid = '$id' limit 1";
		$DB = new Connect();
		$result = $DB->read($query);

		if($result) {
			$row = $result[0];
			return $row;
		} else {
			return false;
		}
	}

	public function get_img($id) {

		$query = "select userimg from users where userid = '$id' limit 1";
		$DB = new Connect();
		$result = $DB->read($query);

		if($result) {
			return $result;
		} else {
			return false;
		}
	}


public function upload_img($id, $files) {

            $myimage = "";

            $folder= "uploads/" . $id . "/";

            if(!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            
            $image = new Image();

            $myimage = $folder.$image->generate_filename(15).".jpg"; // Added a period before "jpg" to concatenate the extension properly
            move_uploaded_file($_FILES['image-upload']['tmp_name'], $myimage);

            $query = "UPDATE users SET userimg = '$myimage' WHERE userid = '$id'";

            $DB = new Connect();
			$result = $DB->write($query);

	}


}