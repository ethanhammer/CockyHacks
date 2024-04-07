<?php
include("classes/connect.php");
include("classes/post.php");

session_start();

if(!isset($_SERVER['HTTP_REFERER'])) {
	$return_to = "profile.php";
} else {
	$return_to = $_SERVER['HTTP_REFERER'];
}

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
	$post = new Post();
	$post->like_post($_GET['id'], $_SESSION['userid']);
}

header("Location: ". $return_to);
die;
?>