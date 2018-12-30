<?php

// start the session with output buffer
ob_start();
session_start();

// include configuration
include 'config/config.php';

// select all posts
$query = $dbh->prepare("select image2 from posts WHERE id = 10");
$query->execute();
$numrows = $query->rowCount();
$data = $query->fetch();

echo '<img src="data:image/jpeg;base64,'.base64_encode( $data->image2 ).'"/>';