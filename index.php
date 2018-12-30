<?php

// start the session with output buffer
ob_start();
session_start();

// include configuration
include 'config/config.php';

//check the id from the post
$query = $dbh->prepare('SELECT MAX(id) as seshno FROM posts');
$query->execute();
$result= $query->fetch();
$gid = $result->seshno;
$gid++;
$maxid = $gid;

/*Add Post
--------------------------------------*/
if ( !empty( $_POST['addPost'] ) )
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $description = $_POST['description'];
    $post_id = $_POST['post_id'];

    // now check by id if any post is present
    $query = $dbh->prepare("select id from posts where post_id = :id");
    $query->bindParam(":id", $post_id);
    $query->execute();
    $numrows = $query->rowCount();
    if ($numrows > 0)
    {
        $query = $dbh->prepare("update posts set name = :a, email = :b, mobile = :c, description = :d where post_id = :e");
        $query->bindParam(":a", $name);
        $query->bindParam(":b", $email);
        $query->bindParam(":c", $mobile);
        $query->bindParam(":d", $description);
        $query->bindParam(":e", $post_id);
        if ($query->execute())
        {
            header('Location: index.php');
        }
        else
        {
            $msg = "There is an error.";
        }
    }
    else
    {
        $query = $dbh->prepare("insert into posts set name = :a, email = :b, mobile = :c, description = :d, post_id = :e");
        $query->bindParam(":a", $name);
        $query->bindParam(":b", $email);
        $query->bindParam(":c", $mobile);
        $query->bindParam(":d", $description);
        $query->bindParam(":e", $post_id);
        if ($query->execute())
        {
            header('Location: index.php');
        }
        else
        {
            $msg = "There is an error.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>File Upload</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
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
	
	<div class="container">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal">
			<div class="row">
				<div class="col-md-8 offset-2">
                    <br>
					<h3>Post your details here</h3>
                    <hr>
                    <br>
                    <?php
                    if (isset($msg))
                    {
                        echo '<div class="msg">'.$msg.'</div>';
                    }
                    ?>
					<div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" autocomplete="off" autofocus required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">Phone Number</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label">Purpose of post</label>
                            <textarea name="description" id="description" class="form-control" required></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div id="mdz" class="dpz">
                                <span class="text-center">Upload or drag photo here</span>
                            </div>

                            <br>

                            <button class="btn btn-info btn-block d-none" type="button" id="submitImages">Upload</button>
                        </div>
                    </div>

                    <div class="form-group row mt-5">
                        <input type="hidden" name="post_id" id="post_id" value="<?php echo $maxid; ?>">
                        <input type="submit" name="addPost" value="Add post" class="btn btn-primary">
                    </div>
				</div>
			</div>
		</form>
	</div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/dropzone.js"></script>
	<script>
        Dropzone.autoDiscover = false;
		var dpz = new Dropzone("div#mdz", {
            // Prevents Dropzone from uploading dropped files immediately
            autoProcessQueue: false,
            // Show add remove links
			addRemoveLinks: true,
            parallelUploads: 6,
			url: 'upload.php',
			params: {
				post_id: $('#post_id').val()
			},
			uploadMultiple: true,
			init: function() {
		    	this.on("addedfile", function(file) {
		    	    $('#mdz').find('span').text('');
		    	    $('#submitImages').removeClass('d-none');
                });
			}
		});
		$('#submitImages').on('click', function () {
            dpz.processQueue();
        })
	</script>
</body>
</html>