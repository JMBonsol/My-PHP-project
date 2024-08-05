<?php

	session_start();

	include('global/model.php');
	include_once('conn.php');


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

	if (isset($_POST['submit'])) {

		$query = "SELECT user_id, uname FROM users";
		$result = mysqli_query($con, $query);

		$errorCheck = 0;

		$name = "{$_POST['first-name']} {$_POST['last-name']} {$_POST['suffix-name']}";
		$capName = ucwords($name);

		// Check if any results were found for the request_id
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {

				if($row['user_id'] == $_POST['employee-id'] || $row['uname'] == $_POST['email']){
					$errorCheck = 1;
				}
			}
		}


		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$date_added = date("Y-m-d H:i:s");
		$status = 1;

		$type = 'Students';
		$department = 'CIHM';

		if($errorCheck == 0) {
			$model = new Model();
			$model->addUser($_POST['employee-id'], $capName, $_POST['contact'], $_POST['email'], $password, $date_added, $status, $type, $department);	
	
			echo "<script> alert('Successfully Registered')</script>";
			echo "<script>window.open('index.php','_self');</script>";
		}
		
		else {
			echo "<script> alert('Registration Denied. This ID/Email has already been registered.')</script>";
			echo "<script>window.open('registration-student.php','_self');</script>";
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
				width: 600px;
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

			.second-div{
				display:flex;
				padding:75px 250px;
				width:100%;
				flex-direction:column;
				justify-content:center;
				align-items:center;
			}

			.reg-input p {
				margin:0;
				font-weight:500;
				color: rgb(0, 110, 80);
			}

			.reg-input select {
				border:1px solid black;
				border-radius:20px;
				margin:0;
				width:100%;
			}

			.reg-form {
				width:100%;
				display:grid;
				grid-template-columns: repeat(12, 1fr);
				gap:20px;
			}

			.reg-input {
				grid-column:span 12;
			}

			.reg-input-6 {
				grid-column:span 6;
			}

			.reg-input input {
				width:100%;
				padding:6px;
				border-radius:5px;
				border:1px solid #a6a6a6;
			}


			.reg-input .disabled{
				padding:10px;
				margin-top:10px;
				background-color: rgb(0, 185, 111);
				border:none;
				color:white;
				cursor:pointer;
				transition:.2s ease-in;
			}

			.reg-input .disabled:disabled{
				background-color: gray;
			}


			.reg-input .disabled:enabled:hover {
				background-color:#00b32d;
			}

			.password-error {
				font-weight:500;
				color:red;
				font-size:14px;
			}

			input[type=number]::-webkit-inner-spin-button,
			input[type=number]::-webkit-outer-spin-button {
				-webkit-appearance: none;
				margin: 0;
			}
			
			input[type=number] {
				-moz-appearance: textfield; /* Firefox */
			}

			@media only screen and (max-width: 1400px) {
				.account-heads{
					width: 350px;
					min-width: 350px;
				}

				.second-div {
					padding:50px 150px;
				}

			}

			@media only screen and (max-width: 991px) {
				.account-heads {
					width: 100%;
					min-width: 100%;
					height: 200px;
				}
			}

			@media only screen and (max-width: 800px) {
				.second-div{
					padding:50px;
				}
			}


		</style>
	</head>
	<?php include 'assets/css/color/color-1.php';  ?>
	<body id="bg">
		<div class="page-wraper">
			<div id="loading-icon-bx"></div>
			<div class="account-form">
					<div class="account-heads" style="background-image:url(assets/images/bgg.png);" style="background-color: transparent; background: transparent!important;"></div>
				
					<div class="second-div">

						<div class="heading-bx left">
							<h2 class="title-head">Registration (Students) </h2>
						</div>	
						

						<form class="reg-form" method="POST" id="registrationForm">
							
							<div class="reg-input reg-input-6"> 
								<p> First Name </p>
								<input type="text" name="first-name" required> 
							</div>

							<div class="reg-input reg-input-6"> 
								<p> Last Name </p>
								<input type="text" name="last-name" required> 
							</div>

							<div class="reg-input reg-input-6"> 
								<p> Suffix </p>
								<input type="text" name="suffix-name"> 
							</div>


							<div class="reg-input reg-input-6"> 
								<p> Student ID: (xx-xxxxx) </p>
								<input name="employee-id" type="text" id="employee" required placeholder="(xx-xxxxx)">
							</div>
								
							<div class="reg-input"> 
								<p> Contact: </p>
								<input name="contact" type="number" id="contact" required>
							</div>

							<div class="reg-input"> 
								<p> Email </p>
								<input name="email" type="email" id="email" required>
							</div>

							<div class="reg-input"> 
								<p> Password </p>
								<input name="password" id="password" type="password"  minlength="5" maxlength="20" required>
							</div>
						
							<div class="reg-input"> 
								<p> Confirm Password </p>
								<input name="confirm-password" id="confirm-password" type="password" minlength="5" maxlength="20" required>
								<p class="password-error"> </p> 
							</div>
				
							<div class="reg-input"> 
								<input class="disabled submit-button"name="submit" value="Sign Up" type="submit" disabled>
							</div>
						</form>

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



    // Function to validate passwords
	function validatePasswords() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        const passwordError = document.querySelector('.password-error');
        const submitButton = document.querySelector('input[name="submit"]');

        if (password !== confirmPassword) {
            passwordError.textContent = "Passwords do not match. Please re-enter.";
            submitButton.disabled = true; // Disable the submit button
        } else {
            passwordError.textContent = ""; // Clear the error message
            submitButton.disabled = false; // Enable the submit button
        }
    }

    document.getElementById('confirm-password').addEventListener('input', validatePasswords);

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
