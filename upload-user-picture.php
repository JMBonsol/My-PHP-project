<?php

	session_start();
	include('global/model.php');
    include('students/conn.php');


	$model = new Model();
    $rows = $model->website_details();

    if (!empty($rows)) {
        foreach ($rows as $row) {
        	$web_name = $row['web_name'];
        	$web_code = strtoupper($row['web_code']);
            $primary_color = $row['primary_color'];
            $secondary_color = $row['secondary_color'];
            $web_icon = $row['web_icon'];
       	}
    }

    // Function to check if the file type is valid (PNG or JPEG)
    function isValidFileType($fileType) {
    return in_array($fileType, ["image/png", "image/jpeg", "image/jpg"]);
    }
    
    // Function to check if the file size is below the specified limit (2MB)
    function isFileSizeValid($fileSize, $maxFileSize) {
    return $fileSize <= $maxFileSize;
    }
    
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define the upload directory
    $uploadDir = "assets/images/profile-pictures/";
    
    // Get the uploaded file details
    $fileName = $_FILES["profilePic"]["name"];
    $fileTmpName = $_FILES["profilePic"]["tmp_name"];
    $fileSize = $_FILES["profilePic"]["size"];
    $fileType = $_FILES["profilePic"]["type"];
    $fileError = $_FILES["profilePic"]["error"];
    
    // Allowed file types
    $allowedFileTypes = ["image/png", "image/jpeg", "image/jpg"];
    
    // Maximum file size (2MB)
    $maxFileSize = 2 * 1024 * 1024;
    
    // Check if the file type is valid and within the size limit
    if (isValidFileType($fileType) && isFileSizeValid($fileSize, $maxFileSize)) {
        // Generate a unique name for the file to avoid overwriting
        $uniqueFileName = uniqid('profile_') . "_" . $fileName;
    
        // Move the uploaded file to the specified directory
        $uploadPath = $uploadDir . $uniqueFileName;
        move_uploaded_file($fileTmpName, $uploadPath);
    
        // Update the database with the file name using a prepared statement
        $userId = $_SESSION['s_sess']; // Replace with your actual user ID
        $updateQuery = "UPDATE users SET picture_link = ? WHERE user_id = ?";
        $statement = mysqli_prepare($con, $updateQuery);
    
        // Bind parameters
        mysqli_stmt_bind_param($statement, "ss", $uniqueFileName, $userId);
    
        // Execute the statement
        if (mysqli_stmt_execute($statement)) {
            // Display a pop-up alert upon success
            echo "<script>
                    alert('File uploaded successfully!'); 
                    window.location.replace('students/index.php');
                    setTimeout(function(){ history.replaceState({}, '', 'students/index.php'); }, 500);
                  </script>";
        } else {
            echo "<script>
                    alert('Error updating database');
                    window.location.replace('upload-user-picture.php');
                  </script>";
        }
    
        // Close the statement
        mysqli_stmt_close($statement);
    } else {
        // Display an error alert if the file is not a valid type or exceeds the size limit
        echo "<script>
                alert('Error: Invalid file. Please upload a PNG or JPEG image (2MB or below).');
                window.location.replace('upload-user-picture.php');
              </script>";
    }
    
    // Close the database connection
    mysqli_close($con);
    }


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<meta name="format-detection" content="telephone=no">
		
		<link rel="icon" href="assets/images/<?php echo $web_icon; ?>.png" type="image/x-icon" />
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/<?php echo $web_icon; ?>.png" />
		<title><?php echo $web_name; ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" type="text/css" href="styles/assets/css/assets.css">
		<link rel="stylesheet" type="text/css" href="styles/assets/css/typography.css">
		<link rel="stylesheet" type="text/css" href="styles/assets/css/shortcodes/shortcodes.css">
		<link rel="stylesheet" type="text/css" href="styles/assets/css/style.css">
		<style type="text/css">
			.red-hover:hover {
				background-color: <?php echo $secondary_color?>!important
			}

			.account-heads {
				position: sticky;
				left:0;
				top:0;
				z-index: 1;
				width: 500px;
				min-width: 500px;
				height: 100vh;
				background-position: center;
				text-align: center;
				align-items: center;
				display: flex;
				vertical-align: middle;
			}
			.account-heads a{
				display:block;
				width:100%;
			}
			.account-heads:after{
				opacity:0.9;
				content:"";
				position:absolute;
				left:0;
				top:0;
				z-index:-1;
				width:100%;
				height:100%;
				background: transparent;
			}

			#profile-form {
				display:flex;
				align-items:center;
				justify-content:center;
			}

			#profilePic {
				margin:10px;
				border:2px solid #8fbc8f;
				border-radius:15px;
				padding:10px;
			}

			#upload-button {
				margin:10px;
				padding:10px 55px;
				border:none;
				border-radius:10px;
				background-color:#8fbc8f;
				color:White;
			}

			@media only screen and (max-width: 1200px) {
				.account-heads{
					width: 350px;
					min-width: 350px;
				}

			}

			@media only screen and (max-width: 991px) {
				.account-heads {
					width: 100%;
					min-width: 100%;
					height: 200px;
				}
			}
		</style>
	</head>
	<?php include 'assets/css/color/color-1.php';  ?>
	<?php 
	$userId = $_SESSION['s_sess'];
	$getRequest = "SELECT picture_link FROM users WHERE user_id = '$userId'";
	$productResult = mysqli_query($con, $getRequest);
	
	if (mysqli_num_rows($productResult) > 0) {
		// Loop through the product names and quantities and store them in an array
		while ($productRow = mysqli_fetch_assoc($productResult)) {
			$uploaded = $productRow['picture_link'];

			if($uploaded != 'none'){
				echo "<script>
				alert('Picture already uploaded!'); 
				window.location.replace('students/index.php');
				</script>";
			}
		}
	}

	
	?>
	<body id="bg">
		<div class="page-wraper">
			<div id="loading-icon-bx"></div>
			<div class="account-form">
			<div class="account-heads" style="background-image:url(assets/images/bg.png);" style="background-color: transparent; background: transparent!important;"></div>
				<div class="account-form-inner">
					<div class="account-container">
				
						<div class="col-lg-12">
						
								<center><h3>Upload a Profile Picture before proceeding.</h3>
								<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="profile-form">

									<center>
									<label for="profilePic">Choose a PNG image (2MB or below):</label>
									<input type="file" name="profilePic" id="profilePic" accept=".png" required>
									<br>
									<input type="submit" value="Upload" id="upload-button">
									</center>
								</form>

								<p style="color:#710c04;margin-top:15px;"><b>WARNING: </b> Uploading wrong picture will lead to account suspension </p>
								
						</div>
								
					</div>
				</div>
			</div>
		</div>
		<script src="styles/assets/js/jquery.min.js"></script>
		<script src="styles/assets/vendors/bootstrap/js/popper.min.js"></script>
		<script src="styles/assets/vendors/bootstrap/js/bootstrap.min.js"></script>
		<script src="styles/assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
		<script src="styles/assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
		<script src="styles/assets/vendors/magnific-popup/magnific-popup.js"></script>
		<script src="styles/assets/vendors/counter/waypoints-min.js"></script>
		<script src="styles/assets/vendors/counter/counterup.min.js"></script>
		<script src="styles/assets/vendors/imagesloaded/imagesloaded.js"></script>
		<script src="styles/assets/vendors/masonry/masonry.js"></script>
		<script src="styles/assets/vendors/masonry/filter.js"></script>
		<script src="styles/assets/vendors/owl-carousel/owl.carousel.js"></script>
		<script src="styles/assets/js/functions.js"></script>
		<script src="styles/assets/js/contact.js"></script>
	</body>
</html>
