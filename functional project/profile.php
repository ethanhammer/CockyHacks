
<?php

//contains userid
session_start();
include("classes/connect.php");
include("classes/login.php");
include("classes/user.php");
include("classes/post.php");
include("classes/image.php");

//for posting
$login = new Login();
$user_data = $login->checkUserId($_SESSION['userid']);

if($_SERVER['REQUEST_METHOD'] == "POST") {

    

    if(isset($_POST['changepfp'])) {
        $user = new User();
        $user->upload_img($_SESSION['userid'], $_FILES);
    } else {

    $id = $_SESSION['userid'];
    $post = new Post();
    $result = $post->createPost($id, $_POST, $_FILES);


    if($result == "") {
        //header("Location: profile.php");
        //die;
    } else {
        echo "<div style='text-align:center;font-size:12px;color:red';background-color:white>";
        echo "The following error occured:<br>";
        echo $result;
        echo "</div>";
        }
    }
  }


//collecting posts

$post = new Post();
$id = $_SESSION['userid'];
$posts = $post->getPosts($id);

?>



<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | CockBots</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: lightgrey;
            margin: 0;
            padding: 0;
        }

        #bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: darkred;
            height: 100px;
            border-radius: 4px;
            padding: 0 20px;
        }

        #title {
            font-size: 24px;
            color: white;
        }

        #tabs {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .tab {
            padding: 10px 20px;
            background-color: darkred;
            color: white;
            border-radius: 4px 4px 0 0;
            cursor: pointer;
            margin: 0 10px;
        }

        .tab:hover {
            background-color: black;
        }

        #content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            margin: auto;
            margin-top: 50px;
        }

        #previous_posts {
            display: none;
        }

        .active {
            display: block;
        }

        #settings {
            display: none;
        }

        .top-bar-buttons {
            display: flex;
            align-items: center;
        }

        .top-bar-button {
            background-color: white;
            padding: 10px 20px;
            border-radius: 4px;
            color: darkred;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        .top-bar-button:hover {
            background-color: #f0f0f0;
        }

        form {
            margin-top: 20px;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
            margin-bottom: 10px;
            font-family: Arial, sans-serif;
        }

        #serialnumber {
            width: 100%;
            height: 50px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
            margin-bottom: 10px;
            font-family: Arial, sans-serif;
        }

        #post_button {
            background-color: darkred;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #post_button:hover {
            background-color: #800000;
        }

        #user-info {
            display: flex;
            align-items: center;
        }

        #user-info img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .post {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .profile-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .post-content {
            margin-bottom: 10px;
        }

        .like-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .like-button:hover {
            background-color: #0056b3;
        }

        .comments {
            margin-top: 20px;
        }

        .comment {
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .comment-author {
            font-weight: bold;
        }

        .comment-text {
            margin-top: 5px;
        }

        .change-image-section {
            margin-bottom: 20px;
        }

        .change-image-section label {
            display: block;
            margin-bottom: 10px;
        }

        .change-image-section input[type="file"] {
            display: none;
        }

        .change-image-section input[type="file"] + label {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .change-image-section input[type="file"] + label:hover {
            background-color: #0056b3;
        }
    </style>

    <script>
        function openTab(tabName) {
            var i, tabContent;
            tabContent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }
            document.getElementById(tabName).style.display = "block";
        }
    </script>
</head>

<body>
    <div id="bar">
        <div id="user-info">
            <?php
            $user = new User();
        $post_image = $user->get_img($_SESSION['userid']);
        $post_image = $post_image[0];
        $post_image = $post_image['userimg'];
        echo "<img src='$post_image' alt='Profile Image' class='profile-image'>";
        ?>
            <h1 id="title"><?php echo $user_data['username'] ?></h1>
        </div>
        <div>
            <div style="background-color:darkred">
                <button onclick="window.location.href = 'feed.php';" class="top-bar-button" style="background-color: white; color:black">Go to Feed</button>
            </div>
        </div>
    </div>
    <div id="tabs">
        <div class="tab" onclick="openTab('create_post')">Create Post</div>
        <div class="tab" onclick="openTab('previous_posts')">Previous Posts</div>
        <div class="tab" onclick="openTab('settings')">Settings</div>
    </div>
    <div id="content">
        <div id="previous_posts" class="tabcontent">
            <?php

            if ($posts) {
                foreach ($posts as $row) {
                    $user = new User();
                    $row_user = $user->get_data($row['userid']);
                    include("post.php");
                }
            }

            ?>
        </div>
        <div id="settings" class="tabcontent">
            <h2>Settings</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="changepfp" value="pfp">
                <div class="change-image-section" enctype="multipart/form-data">
                    <label for="image-upload">Change Profile Image:</label>
                    <input type="file" id="image-upload" name="image-upload">
                    <label for="image-upload">Choose File</label>
                    <input id="post_button" type="submit" value="Post" required>
                </div>
            </form>
        </div>

        <div id="create_post" class="tabcontent" style="min-height: 400px; flex:2.5;padding:20px;padding-right:0px;">
            <h2>Create Post:</h2>
            <!-- Create Post Content Goes Here -->
            <form method="post" enctype="multipart/form-data">
                <textarea name="post" placeholder="How do you feel about a bot you saw?"></textarea>
                <input type="file" name="file" required>
                <textarea id="serialnumber" name="botserial" placeholder="what is the bot's serial number? (optional)"></textarea>
                <input id="post_button" type="submit" value="Post" required>
            </form>
        </div>
    </div>
    <button onclick="logout()" id="logout-button" class="top-bar-button" style="position: fixed; bottom: 20px; right: 20px;">Logout</button>
    <script>
        function logout() {
            window.location.href = "logout.php";
        }
        // Open default tab
        openTab('create_post');
    </script>
</body>

</html>
