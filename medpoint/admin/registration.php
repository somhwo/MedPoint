<?php
include_once('include/config.php');
if(isset($_POST['submit']))
{
$fname=$_POST['full_name'];
$address=$_POST['address'];
$city=$_POST['city'];
$gender=$_POST['gender'];
$email=$_POST['email'];
$password=md5($_POST['password']);
$query=mysql_query("insert into users(fullname,address,city,gender,email,password) values('$fname','$address','$city','$gender','$email','$password')");
if($query)
{
	echo "<script>alert('Successfully Registered. You can login now');</script>";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User Registration - MedPoint</title>
	
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
	
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
			background: linear-gradient(135deg, #4F67E5 0%, #5B7EF8 100%);
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px;
		}

		.registration-container {
			width: 100%;
			max-width: 480px;
			background: #ffffff;
			border-radius: 16px;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
			overflow: hidden;
			animation: slideUp 0.5s ease-out;
		}

		@keyframes slideUp {
			from {
				opacity: 0;
				transform: translateY(30px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.header-section {
			background: linear-gradient(135deg, #4F67E5 0%, #5B7EF8 100%);
			padding: 40px 30px;
			text-align: center;
			color: white;
		}

		.logo {
			margin-bottom: 20px;
		}

		.logo-text {
			font-size: 32px;
			font-weight: 700;
			letter-spacing: -0.5px;
		}

		.header-section h2 {
			font-size: 24px;
			font-weight: 600;
			margin-bottom: 8px;
		}

		.header-section p {
			font-size: 14px;
			opacity: 0.9;
		}

		.form-section {
			padding: 40px 30px;
		}

		.section-title {
			font-size: 13px;
			font-weight: 600;
			color: #6B7280;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			margin-bottom: 16px;
		}

		.form-group {
			margin-bottom: 20px;
		}

		.form-group label {
			display: block;
			font-size: 14px;
			font-weight: 500;
			color: #374151;
			margin-bottom: 8px;
		}

		.input-wrapper {
			position: relative;
		}

		.form-control {
			width: 100%;
			padding: 12px 16px;
			padding-left: 44px;
			font-size: 14px;
			border: 2px solid #E5E7EB;
			border-radius: 8px;
			transition: all 0.3s ease;
			font-family: inherit;
		}

		.form-control:focus {
			outline: none;
			border-color: #4F67E5;
			box-shadow: 0 0 0 3px rgba(79, 103, 229, 0.1);
		}

		.input-icon {
			position: absolute;
			left: 16px;
			top: 50%;
			transform: translateY(-50%);
			color: #9CA3AF;
			font-size: 16px;
		}

		.gender-options {
			display: flex;
			gap: 12px;
			margin-top: 8px;
		}

		.radio-option {
			flex: 1;
			position: relative;
		}

		.radio-option input[type="radio"] {
			position: absolute;
			opacity: 0;
			cursor: pointer;
		}

		.radio-label {
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 12px 16px;
			border: 2px solid #E5E7EB;
			border-radius: 8px;
			cursor: pointer;
			transition: all 0.3s ease;
			font-size: 14px;
			font-weight: 500;
			color: #6B7280;
		}

		.radio-option input[type="radio"]:checked + .radio-label {
			border-color: #4F67E5;
			background-color: #EEF2FF;
			color: #4F67E5;
		}

		.checkbox-wrapper {
			display: flex;
			align-items: center;
			gap: 8px;
		}

		.checkbox-wrapper input[type="checkbox"] {
			width: 18px;
			height: 18px;
			cursor: pointer;
			accent-color: #4F67E5;
		}

		.checkbox-wrapper label {
			margin: 0;
			font-size: 14px;
			color: #6B7280;
			cursor: pointer;
		}

		.availability-status {
			font-size: 12px;
			margin-top: 6px;
			display: block;
		}

		.btn-primary {
			width: 100%;
			padding: 14px;
			background: linear-gradient(135deg, #4F67E5 0%, #5B7EF8 100%);
			color: white;
			border: none;
			border-radius: 8px;
			font-size: 15px;
			font-weight: 600;
			cursor: pointer;
			transition: all 0.3s ease;
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
		}

		.btn-primary:hover {
			transform: translateY(-2px);
			box-shadow: 0 10px 25px rgba(79, 103, 229, 0.3);
		}

		.btn-primary:active {
			transform: translateY(0);
		}

		.login-link {
			text-align: center;
			margin-top: 20px;
			font-size: 14px;
			color: #6B7280;
		}

		.login-link a {
			color: #4F67E5;
			text-decoration: none;
			font-weight: 600;
		}

		.login-link a:hover {
			text-decoration: underline;
		}

		.footer {
			text-align: center;
			padding: 20px;
			border-top: 1px solid #E5E7EB;
			font-size: 13px;
			color: #9CA3AF;
		}

		.divider {
			height: 1px;
			background: #E5E7EB;
			margin: 30px 0;
		}

		@media (max-width: 576px) {
			.registration-container {
				margin: 10px;
			}
			
			.header-section {
				padding: 30px 20px;
			}
			
			.form-section {
				padding: 30px 20px;
			}
		}
	</style>
</head>

<body>
	<div class="registration-container">
		<div class="header-section">
			<div class="logo">
				<div class="logo-text">MedPoint</div>
			</div>
			<h2>Create Your Account</h2>
			<p>Join us to access healthcare services</p>
		</div>

		<div class="form-section">
			<form name="registration" id="registration" method="post">
				<div class="section-title">Personal Information</div>
				
				<div class="form-group">
					<label for="full_name">Full Name</label>
					<div class="input-wrapper">
						<i class="fa fa-user input-icon"></i>
						<input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter your full name" required>
					</div>
				</div>

				<div class="form-group">
					<label for="address">Address</label>
					<div class="input-wrapper">
						<i class="fa fa-home input-icon"></i>
						<input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required>
					</div>
				</div>

				<div class="form-group">
					<label for="city">City</label>
					<div class="input-wrapper">
						<i class="fa fa-map-marker input-icon"></i>
						<input type="text" class="form-control" id="city" name="city" placeholder="Enter your city" required>
					</div>
				</div>

				<div class="form-group">
					<label>Gender</label>
					<div class="gender-options">
						<div class="radio-option">
							<input type="radio" id="rg-female" name="gender" value="female">
							<label for="rg-female" class="radio-label">
								<i class="fa fa-venus" style="margin-right: 6px;"></i> Female
							</label>
						</div>
						<div class="radio-option">
							<input type="radio" id="rg-male" name="gender" value="male">
							<label for="rg-male" class="radio-label">
								<i class="fa fa-mars" style="margin-right: 6px;"></i> Male
							</label>
						</div>
					</div>
				</div>

				<div class="divider"></div>
				
				<div class="section-title">Account Details</div>

				<div class="form-group">
					<label for="email">Email Address</label>
					<div class="input-wrapper">
						<i class="fa fa-envelope input-icon"></i>
						<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" onBlur="userAvailability()" required>
					</div>
					<span id="user-availability-status1" class="availability-status"></span>
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<div class="input-wrapper">
						<i class="fa fa-lock input-icon"></i>
						<input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
					</div>
				</div>

				<div class="form-group">
					<label for="password_again">Confirm Password</label>
					<div class="input-wrapper">
						<i class="fa fa-lock input-icon"></i>
						<input type="password" class="form-control" id="password_again" name="password_again" placeholder="Confirm your password" required>
					</div>
				</div>

				<div class="form-group">
					<div class="checkbox-wrapper">
						<input type="checkbox" id="agree" value="agree" required>
						<label for="agree">I agree to the Terms and Conditions</label>
					</div>
				</div>

				<button type="submit" class="btn-primary" id="submit" name="submit">
					<span>Create Account</span>
					<i class="fa fa-arrow-right"></i>
				</button>

				<div class="login-link">
					Already have an account? <a href="user-login.php">Sign In</a>
				</div>
			</form>
		</div>

		<div class="footer">
			&copy; <span class="current-year"></span> MedPoint. All rights reserved.
		</div>
	</div>

	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script>
		// Set current year
		document.querySelector('.current-year').textContent = new Date().getFullYear();

		// User availability check
		function userAvailability() {
			jQuery.ajax({
				url: "check_availability.php",
				data: 'email=' + $("#email").val(),
				type: "POST",
				success: function(data) {
					$("#user-availability-status1").html(data);
				},
				error: function() {}
			});
		}

		// Form validation
		document.getElementById('registration').addEventListener('submit', function(e) {
			const password = document.getElementById('password').value;
			const passwordAgain = document.getElementById('password_again').value;
			
			if (password !== passwordAgain) {
				e.preventDefault();
				alert('Passwords do not match!');
				return false;
			}
			
			const gender = document.querySelector('input[name="gender"]:checked');
			if (!gender) {
				e.preventDefault();
				alert('Please select your gender');
				return false;
			}
		});
	</script>
</body>
</html>