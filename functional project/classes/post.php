<?php

class Post {

    private $error = ""; // Declare $error as a class property

    //upload post data to the database
    public function createPost($userid, $data, $files) {

        if(empty($data['botserial'])) {
            $data['botserial'] = "none";
        }

        if(!empty($data['post'])) {

            $myimage = "";

            $folder= "uploads/" . $userid . "/";

            if(!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            
            $image = new Image();

            $myimage = $folder.$image->generate_filename(15).".jpg"; // Added a period before "jpg" to concatenate the extension properly
            move_uploaded_file($_FILES['file']['tmp_name'], $myimage);


            $post = addslashes($data['post']);
            $postid = $this->create_postid(); // Corrected arrow operator
            $botserial = addslashes($data['botserial']);

            if($this->checkImg($myimage)) { // Added "$" before "this"
                $query = "INSERT INTO posts (postid, userid, post, bot_serial, image) VALUES ('$postid','$userid','$post','$botserial','$myimage')";

                $DB = new Connect();
                $DB->write($query);
            }
            else {
                unlink($myimage);
                $this->error .= "Image was not found to contain a robot<br>"; //
            }
             
        } else {
            $this->error .= "There was no text<br>"; // Added ".$this->" before "error"
        }

        return $this->error;
    }

    //gets all of the posts from the database
    public function getPosts($id) {

        $query = "select * from posts where userid = '$id' order by id desc limit 10";

        $DB = new Connect();
        $result = $DB->read($query);

        if($result) {
            return $result;
        } else {
            return false;
        }
    }


    private function checkImg($path) { // Added "private" keyword
        
        $output = exec(command: "python classes/testing.py " . escapeshellarg($path));

        if($output == "bot"){
            return true;
        }
        else{
            return false;
        }
    }

    //gets all of the posts from the database
    public function getPostsByDate() {

        $query = "SELECT * FROM posts ORDER BY id DESC LIMIT 100";

        $DB = new Connect();
        $result = $DB->read($query);

        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    //gets all of the posts from the database
    public function getPostsByLikes() {

        $query = "select * from posts order by likes desc limit 100";

        $DB = new Connect();
        $result = $DB->read($query);

        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function like_post($id,$mybook_userid){

            $DB = new Connect();
            
            //save likes details
            $sql = "select likes from likes where postid = '$id' limit 1";
            $result = $DB->read($sql);
            if(is_array($result)){

                $likes = json_decode($result[0]['likes'],true);

                $user_ids = array_column($likes, "userid");
 
                if(!in_array($mybook_userid, $user_ids)){

                    $arr["userid"] = $mybook_userid;
                    $arr["date"] = date("Y-m-d H:i:s");

                    $likes[] = $arr;

                    $likes_string = json_encode($likes);
                    $sql = "update likes set likes = '$likes_string' where postid = '$id' limit 1";
                    $DB->write($sql);

                    //increment the right table
                    $sql = "update posts set likes = likes + 1 where postid = '$id' limit 1";
                    $DB->write($sql);


                }else{

                    $key = array_search($mybook_userid, $user_ids);
                    unset($likes[$key]);

                    $likes_string = json_encode($likes);
                    $sql = "update likes set likes = '$likes_string' where postid = '$id' limit 1";
                    $DB->write($sql);

                    //increment the right table
                    $sql = "update posts set likes = likes - 1 where postid = '$id' limit 1";
                    $DB->write($sql);

                }
                

            }else{

                $arr["userid"] = $mybook_userid;
                $arr["date"] = date("Y-m-d H:i:s");

                $arr2[] = $arr;

                $likes = json_encode($arr2);
                $sql = "insert into likes (postid,likes) values ('$id','$likes')"; // Added single quotes around $id
                $DB->write($sql);

                //increment the right table
                $sql = "update posts set likes = likes + 1 where postid = '$id' limit 1";
                $DB->write($sql);
 
            }

    }    

    

    public function get_likes($id){

        $DB = new Connect();

        if(is_numeric($id)){
 
            //get like details
            $sql = "select likes from posts where postid = '$id' limit 1";
            $result = $DB->read($sql);
            if(is_array($result)){

                $likes = json_decode($result[0]['likes'],true);
                return $likes;
            }
        }


        return false;
    }

    //create a random postid
    private function create_postid()
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
