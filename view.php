<?php

// start the session with output buffer
ob_start();
session_start();

// include configuration
include 'config/config.php';

// select all posts
$query = $dbh->prepare("select * from posts");
$query->execute();
$numrows = $query->rowCount();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>File Upload</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/dropzone.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	
	<!-- Navigation Menu -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-info">
	  <a class="navbar-brand" href="#">Navbar</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item active">
	        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="#">Link</a>
	      </li>
	      <li class="nav-item dropdown">
	        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          Dropdown
	        </a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	          <a class="dropdown-item" href="#">Action</a>
	          <a class="dropdown-item" href="#">Another action</a>
	          <div class="dropdown-divider"></div>
	          <a class="dropdown-item" href="#">Something else here</a>
	        </div>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link disabled" href="#">Disabled</a>
	      </li>
	    </ul>
	    <form class="form-inline my-2 my-lg-0">
	      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
	      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
	    </form>
	  </div>
	</nav>

	<div class="main mt-4">
        <div class="posts">
            <div class="container">
                <div class="row">
<?php
while ($row = $query->fetch())
{ ?>
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header"><strong>Posted by: </strong> <?php echo $row->name; ?></div>
            <div class="card-body">
                <p><strong>Email: </strong> <?php echo $row->email; ?></p>
                <p><strong>Mobile: </strong> <?php echo $row->mobile; ?></p>
                <p><strong>Description: </strong> <?php echo $row->description; ?></p>
            </div>
            <div class="card-footer">
                <p><a href="view.php?post_id=<?php echo $row->post_id; ?>" class="btn btn-info btn-block btn-sm">View</a></p>
            </div>
        </div>
    </div>
<?php }
?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/dropzone.js"></script>
	<script>

	</script>
</body>
</html>