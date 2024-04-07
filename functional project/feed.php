<?php
session_start();
include("classes/connect.php");
include("classes/login.php");
include("classes/user.php");
include("classes/post.php");

$login = new Login();
$user_data = $login->checkUserId($_SESSION['userid']);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Get the selected sorting criteria from the form
    $sortBy = isset($_POST['sort-by']) ? $_POST['sort-by'] : null;

    // Call the appropriate method to retrieve posts based on the sorting criteria
    $post = new Post();
    if ($sortBy === 'likes') {
        $posts = $post->getPostsByLikes();
    } else {
        $posts = $post->getPostsByDate();
    }
} else {
    // If the form is not submitted, default to sorting by date
    $post = new Post();
    $posts = $post->getPostsByDate();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Feed | CockBots</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: lightgrey;
            margin: 0;
            padding: 0;
        }

        #main-container {
            display: flex;
            flex-direction: column;
            background-color: lightgrey;
            min-height: 100vh;
            box-sizing: border-box;
        }

        #header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: darkred;
            color: white;
            padding: 20px;
            text-align: center;
        }

        #profile-button {
            background-color: white;
            color: darkred;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        #content {
            flex: 1;
            background-color: white;
            padding: 20px;
            max-width: 900px; /* Adjust the max-width as per your preference */
            margin: 0 auto; /* This centers the posts container horizontally */
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

        .sort-dropdown {
            margin-bottom: 20px;
            margin-left: 50px;
        }
    </style>
</head>
<body>
    <div id="main-container">
        <div id="header">
            <h1>CockBots</h1>
            <button id="profile-button" onclick="window.location.href = 'profile.php';">Profile</button>
        </div>
        <div id="content">
            <form action="feed.php" method="post"> 
                    <label for="sort-by">Sort By:</label>
                    <select id="sort-by" name="sort-by"> 
                        <option value="date">Date</option>
                        <option value="likes">Likes</option>
                    </select>
                    <button type="submit">Sort</button> 
            </form>
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
    </div>
    <!-- JavaScript section remains unchanged -->
</body>
</html>
