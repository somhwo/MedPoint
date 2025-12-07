<?php
session_start();
//error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
  } else{

date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );
if(isset($_POST['submit']))
{
$cpass=$_POST['cpass'];	
$uname=$_SESSION['login'];
$sql=mysqli_query($con,"SELECT password FROM  admin where password='$cpass' && username='$uname'");
$num=mysqli_fetch_array($sql);
if($num>0)
{
$npass=$_POST['npass'];
 $con=mysqli_query($con,"update admin set password='$npass', updationDate='$currentTime' where username='$uname'");
$_SESSION['msg1']="Password Changed Successfully !!";
}
else
{
$_SESSION['msg1']="Old Password not match !!";
}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Change Password</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		
		<!-- Fonts & Icons -->
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		
		<!-- Vendor CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
		
		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
		
		<style>
			* {
				font-family: 'Poppins', sans-serif !important;
			}
			
			body {
				background: #f0f4f8;
				color: #1e293b;
			}
			
			.main-content {
				background: #f0f4f8;
				padding: 35px 40px;
			}
			
			/* Modern Page Header - Compact */
			.page-header-modern {
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				border-radius: 20px;
				padding: 30px 40px;
				margin-bottom: 35px;
				color: #ffffff;
				box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
				position: relative;
				overflow: hidden;
			}
			
			.page-header-modern::before {
				content: '';
				position: absolute;
				top: -50%;
				right: -20%;
				width: 350px;
				height: 350px;
				background: rgba(255, 255, 255, 0.06);
				border-radius: 50%;
				pointer-events: none;
			}
			
			.page-header-modern h1 {
				font-size: 28px;
				font-weight: 700;
				margin-bottom: 6px;
				display: flex;
				align-items: center;
				gap: 12px;
				position: relative;
				z-index: 1;
				letter-spacing: -0.5px;
				color: #ffffff !important;
				text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
			}
			
			.page-header-modern h1 i {
				color: #ffffff !important;
				filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
				font-size: 24px;
			}
			
			.page-header-modern p {
				font-size: 14px;
				opacity: 1;
				color: rgba(255, 255, 255, 0.95);
				margin: 0;
				position: relative;
				z-index: 1;
				font-weight: 500;
			}
			
			/* Form Card - Compact and Centered */
			.form-card-modern {
				background: #ffffff;
				border-radius: 20px;
				padding: 32px;
				box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
				border: 1px solid #e2e8f0;
				transition: all 0.4s ease;
				max-width: 600px;
				margin: 0 auto;
			}
			
			.form-card-modern:hover {
				box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
			}
			
			.form-header {
				display: flex;
				align-items: center;
				gap: 14px;
				margin-bottom: 24px;
				padding-bottom: 20px;
				border-bottom: 2px solid #e2e8f0;
			}
			
			.form-icon-badge {
				width: 48px;
				height: 48px;
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				border-radius: 14px;
				display: flex;
				align-items: center;
				justify-content: center;
				box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
			}
			
			.form-icon-badge i {
				color: #ffffff;
				font-size: 20px;
			}
			
			.form-title {
				font-size: 20px;
				font-weight: 700;
				color: #0f172a;
				margin: 0;
				letter-spacing: -0.5px;
			}
			
			.form-subtitle {
				font-size: 13px;
				color: #64748b;
				margin: 4px 0 0 0;
				font-weight: 500;
			}
			
			/* Alert Messages - Compact */
			.alert-modern {
				border-radius: 12px;
				padding: 14px 18px;
				margin-bottom: 20px;
				border: none;
				display: flex;
				align-items: center;
				gap: 10px;
				font-weight: 500;
				font-size: 14px;
				animation: slideDown 0.3s ease;
			}
			
			@keyframes slideDown {
				from {
					opacity: 0;
					transform: translateY(-10px);
				}
				to {
					opacity: 1;
					transform: translateY(0);
				}
			}
			
			.alert-success {
				background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
				color: #065f46;
				border-left: 4px solid #10b981;
			}
			
			.alert-error {
				background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
				color: #991b1b;
				border-left: 4px solid #ef4444;
			}
			
			.alert-modern i {
				font-size: 18px;
			}
			
			/* Form Groups - Compact */
			.form-group-modern {
				margin-bottom: 20px;
			}
			
			.form-label-modern {
				font-size: 13px;
				font-weight: 600;
				color: #334155;
				margin-bottom: 8px;
				display: flex;
				align-items: center;
				gap: 6px;
			}
			
			.form-label-modern i {
				color: #667eea;
				font-size: 14px;
			}
			
			.input-wrapper {
				position: relative;
			}
			
			.input-icon {
				position: absolute;
				left: 14px;
				top: 50%;
				transform: translateY(-50%);
				color: #94a3b8;
				font-size: 16px;
				pointer-events: none;
				transition: color 0.3s ease;
			}
			
			.form-control-modern {
				width: 100%;
				padding: 12px 14px 12px 44px;
				border: 2px solid #e2e8f0;
				border-radius: 10px;
				font-size: 14px;
				color: #1e293b;
				transition: all 0.3s ease;
				background: #f8fafc;
			}
			
			.form-control-modern:focus {
				outline: none;
				border-color: #667eea;
				background: #ffffff;
				box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
			}
			
			.form-control-modern:focus + .input-icon {
				color: #667eea;
			}
			
			.form-control-modern::placeholder {
				color: #94a3b8;
			}
			
			/* Toggle Password Visibility */
			.toggle-password {
				position: absolute;
				right: 14px;
				top: 50%;
				transform: translateY(-50%);
				color: #94a3b8;
				cursor: pointer;
				font-size: 16px;
				transition: color 0.3s ease;
				z-index: 10;
			}
			
			.toggle-password:hover {
				color: #667eea;
			}
			
			/* Buttons - Compact */
			.btn-submit-modern {
				display: inline-flex;
				align-items: center;
				justify-content: center;
				gap: 8px;
				padding: 14px 32px;
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				color: #ffffff;
				border: none;
				border-radius: 10px;
				font-size: 15px;
				font-weight: 700;
				cursor: pointer;
				transition: all 0.3s ease;
				box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
				width: 100%;
			}
			
			.btn-submit-modern:hover {
				transform: translateY(-2px);
				box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
			}
			
			.btn-submit-modern:active {
				transform: translateY(0);
			}
			
			.btn-submit-modern i {
				font-size: 16px;
			}
			
			/* Security Tips - Compact */
			.security-tips {
				background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
				border-left: 4px solid #f59e0b;
				border-radius: 12px;
				padding: 18px;
				margin-top: 24px;
			}
			
			.security-tips-title {
				display: flex;
				align-items: center;
				gap: 8px;
				font-size: 14px;
				font-weight: 700;
				color: #92400e;
				margin-bottom: 10px;
			}
			
			.security-tips-title i {
				font-size: 16px;
			}
			
			.security-tips ul {
				margin: 0;
				padding-left: 20px;
				color: #78350f;
			}
			
			.security-tips li {
				margin-bottom: 5px;
				font-size: 13px;
				font-weight: 500;
			}
			
			/* Responsive */
			@media (max-width: 768px) {
				.main-content {
					padding: 20px 16px;
				}
				
				.page-header-modern {
					padding: 30px 24px;
					border-radius: 16px;
				}
				
				.page-header-modern h1 {
					font-size: 28px;
				}
				
				.form-card-modern {
					padding: 24px;
					border-radius: 16px;
				}
			}
			
			/* Container Overrides */
			.container-fluid.container-fullw {
				background: transparent;
				padding: 0;
			}
			
			.wrap-content {
				max-width: 650px;
				margin: 0 auto;
				padding-bottom: 40px;
			}
			
			/* Footer spacing fix */
			.main-content {
				min-height: calc(100vh - 200px);
			}
			
			/* Remove old styles */
			#page-title {
				display: none;
			}
		</style>

<script type="text/javascript">
function valid()
{
if(document.chngpwd.cpass.value=="")
{
alert("Current Password Field is Empty !!");
document.chngpwd.cpass.focus();
return false;
}
else if(document.chngpwd.npass.value=="")
{
alert("New Password Field is Empty !!");
document.chngpwd.npass.focus();
return false;
}
else if(document.chngpwd.cfpass.value=="")
{
alert("Confirm Password Field is Empty !!");
document.chngpwd.cfpass.focus();
return false;
}
else if(document.chngpwd.npass.value!= document.chngpwd.cfpass.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.chngpwd.cfpass.focus();
return false;
}
return true;
}

// Toggle password visibility
function togglePassword(inputId, iconElement) {
	const input = document.getElementById(inputId);
	if (input.type === "password") {
		input.type = "text";
		iconElement.classList.remove("fa-eye");
		iconElement.classList.add("fa-eye-slash");
	} else {
		input.type = "password";
		iconElement.classList.remove("fa-eye-slash");
		iconElement.classList.add("fa-eye");
	}
}
</script>

	</head>
	<body>
		<div id="app">		
<?php include('include/sidebar.php');?>
			<div class="app-content">
				
				<?php include('include/header.php');?>
				
				<div class="main-content">
					<div class="wrap-content container" id="container">
						
						<!-- Modern Page Header -->
						<div class="page-header-modern">
							<h1>
								<i class="fas fa-shield-alt"></i>
								Change Password
							</h1>
							<p>Update your account password to keep your account secure</p>
						</div>
						
						<!-- Form Card -->
						<div class="form-card-modern">
										<div class="form-header">
											<div class="form-icon-badge">
												<i class="fas fa-key"></i>
											</div>
											<div>
												<h2 class="form-title">Update Password</h2>
												<p class="form-subtitle">Enter your current password and choose a new one</p>
											</div>
										</div>
										
										<!-- Alert Messages -->
										<?php if(!empty($_SESSION['msg1'])): ?>
											<?php 
											$isSuccess = strpos($_SESSION['msg1'], 'Successfully') !== false;
											$alertClass = $isSuccess ? 'alert-success' : 'alert-error';
											$iconClass = $isSuccess ? 'fa-check-circle' : 'fa-exclamation-circle';
											?>
											<div class="alert-modern <?php echo $alertClass; ?>">
												<i class="fas <?php echo $iconClass; ?>"></i>
												<span><?php echo htmlentities($_SESSION['msg1']); ?></span>
											</div>
											<?php $_SESSION['msg1']=""; ?>
										<?php endif; ?>
										
										<form role="form" name="chngpwd" method="post" onSubmit="return valid();">
											
											<!-- Current Password -->
											<div class="form-group-modern">
												<label class="form-label-modern">
													<i class="fas fa-lock"></i>
													Current Password
												</label>
												<div class="input-wrapper">
													<input type="password" 
														   id="currentPassword"
														   name="cpass" 
														   class="form-control-modern" 
														   placeholder="Enter your current password">
													<i class="fas fa-lock input-icon"></i>
													<i class="fas fa-eye toggle-password" 
													   onclick="togglePassword('currentPassword', this)"></i>
												</div>
											</div>
											
											<!-- New Password -->
											<div class="form-group-modern">
												<label class="form-label-modern">
													<i class="fas fa-key"></i>
													New Password
												</label>
												<div class="input-wrapper">
													<input type="password" 
														   id="newPassword"
														   name="npass" 
														   class="form-control-modern" 
														   placeholder="Enter your new password">
													<i class="fas fa-key input-icon"></i>
													<i class="fas fa-eye toggle-password" 
													   onclick="togglePassword('newPassword', this)"></i>
												</div>
											</div>
											
											<!-- Confirm Password -->
											<div class="form-group-modern">
												<label class="form-label-modern">
													<i class="fas fa-check-circle"></i>
													Confirm New Password
												</label>
												<div class="input-wrapper">
													<input type="password" 
														   id="confirmPassword"
														   name="cfpass" 
														   class="form-control-modern" 
														   placeholder="Re-enter your new password">
													<i class="fas fa-check-circle input-icon"></i>
													<i class="fas fa-eye toggle-password" 
													   onclick="togglePassword('confirmPassword', this)"></i>
												</div>
											</div>
											
											<!-- Submit Button -->
											<button type="submit" name="submit" class="btn-submit-modern">
												<i class="fas fa-shield-alt"></i>
												Update Password
											</button>
											
										</form>
										
										<!-- Security Tips -->
										<div class="security-tips">
											<div class="security-tips-title">
												<i class="fas fa-lightbulb"></i>
												Password Security Tips
											</div>
											<ul>
												<li>Use at least 8 characters with a mix of letters, numbers, and symbols</li>
												<li>Don't use personal information or common words</li>
												<li>Change your password regularly for better security</li>
												<li>Never share your password with anyone</li>
											</ul>
										</div>
										
									</div>
									<!-- End Form Card -->
									
								</div>
							</div>
						</div>
				</div>
			</div>
			
			<!-- Footer -->
			<?php include('include/footer.php');?>
			
			<!-- Settings -->
			<?php include('include/setting.php');?>
		</div>
		
		<!-- Main JavaScripts -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		
		<!-- Page Specific JavaScripts -->
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		
		<!-- Theme JavaScripts -->
		<script src="assets/js/main.js"></script>
		<script src="assets/js/form-elements.js"></script>
		
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>
	</body>
</html>
<?php } ?>