<?php

	session_start();
	include('global/model.php');

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

	if (isset($_SESSION['sess'])) {
		echo "<script>window.open('admin/index.php','_self');</script>";
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
	<body id="bg">
		<div class="page-wraper">
			<div id="loading-icon-bx"></div>
			<div class="account-form">
				<div class="account-heads" style="background-image:url(assets/images/bg.png);" style="background-color: transparent;"></div>
				<div class="account-form-inner">
					<div class="account-container">
						<div class="heading-bx left">
							<h2 class="title-head">PLP-HM Admin<span> Access</span></h2>
							<i>Online Culinary Requisition and Inventory Management System </i>
						</div>	
						<form class="contact-bx" method="POST">
							<div class="row placeani">
								<div class="col-lg-12">
									<div class="form-group">
										<div class="input-group">
											<label>Your Email</label>
											<input name="username" type="email" id="email" class="form-control" required>
										</div>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<div class="input-group"> 
											<label>Your Password</label>
											<input name="password" type="password" class="form-control" minlength="5" maxlength="20" required>
										</div>
									</div>
								</div>
								<div class="col-lg-12">
									<?php

										if (isset($_POST['submit'])) {
											if (!isset($_COOKIE['rlimited'])) {
												$uname = $_POST['username'];
												$pword = $_POST['password'];

												$model = new Model();
												$model->signIn($uname, $pword);	
											}

											else {
												echo "<script>alert('Wait before trying again!')</script>";
											}
										}

									?>
									<div class="form-group form-forget">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="customControlAutosizing">
											<label class="custom-control-label" for="customControlAutosizing">Remember me</label>
										
								</div>
								<div class="col-lg-12 m-b30">
									<?php
										if (isset($_COOKIE['rlimited'])) {
											echo '<button name="submit" type="submit" value="Submit" class="red-hover btn button-md" style="background-color: #'.$primary_color.'!important;" disabled>Login</button>';
										}

										else {
											echo '<button name="submit" type="submit" value="Submit" class="red-hover btn button-md" style="background-color: #'.$primary_color.'!important;">Login</button>';
										}



									?>
								</div>
							</div>
						</form>
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
		<script type="text/javascript">
			var accept = ["@plpasig.edu.ph"];

			function validateEmailField() {
				var email = document.getElementById("email");
				var emailVal = $('#email').val();
				var split = emailVal.split('@');

				var last = emailVal.slice(-15);

				if(accept.indexOf(last) >= 0) {
					email.setCustomValidity('');
				}

				else {
					email.setCustomValidity("Please use an '@plpasig.edu.ph' email address.");
				}
			}

			email.onchange = validateEmailField;
			email.onkeyup = validateEmailField;
		</script>
	</body>
</html>
