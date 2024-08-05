<?php

	session_start();
	include('global/model.php');
    include('students/conn.php');


	$model = new Model();
    $rows = $model->website_details();
    
    $user_id = $_SESSION['u_sess'];
    unset($_SESSION['u_sess']);

    if (!empty($rows)) {
        foreach ($rows as $row) {
        	$web_name = $row['web_name'];
        	$web_code = strtoupper($row['web_code']);
            $primary_color = $row['primary_color'];
            $secondary_color = $row['secondary_color'];
            $web_icon = $row['web_icon'];
       	}
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
	
	$getRequest = "SELECT suspension_text FROM labtech WHERE tech_id = '$user_id'";
	$productResult = mysqli_query($con, $getRequest);
	
	if (mysqli_num_rows($productResult) > 0) {
		// Loop through the product names and quantities and store them in an array
		while ($productRow = mysqli_fetch_assoc($productResult)) {
			$text = $productRow['suspension_text'];
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
						
								<center><h3>YOUR ACCOUNT IS <span style="color: red">Temporarily Deactivated</span><br>PLEASE CONTACT SYSTEM ADMINISTRATOR FOR MORE INFORMATION.</h3>
								<?php echo '<p>Reason for Suspension:<br> <span style="color: red">' . $text . '</span></p>'; ?>
								<a href="labtech-login.php" class="ml-auto">Back to Login</a>
								
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
