<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
  } else{
//Code for Update the Content

if(isset($_POST['submit']))
  {
   
     $pagetitle=$_POST['pagetitle'];
$pagedes=$_POST['pagedes'];
$email=$_POST['email'];
 $mobnum=$_POST['mobnum'];
     $query=mysqli_query($con,"update tblpage set PageTitle='$pagetitle',PageDescription='$pagedes',Email='$email',MobileNumber='$mobnum' where  PageType='contactus'");
    if ($query) {
 
    echo '<script>alert("Contact Us has been updated.")</script>';
  }
  else
    {
      echo '<script>alert("Something Went Wrong. Please try again.")</script>';
    }
  
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Contact Us</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
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
		
		<!-- Rich Text Editor -->
		<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
		<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
		
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
				max-width: 800px;
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
			
			/* Textarea specific */
			textarea.form-control-modern {
				padding: 12px 14px;
				min-height: 150px;
				resize: vertical;
			}
			
			/* NicEdit overrides */
			.nicEdit-main {
				background: #f8fafc !important;
				border: 2px solid #e2e8f0 !important;
				border-radius: 10px !important;
				padding: 12px 14px !important;
				font-family: 'Poppins', sans-serif !important;
			}
			
			.nicEdit-main:focus {
				border-color: #667eea !important;
				background: #ffffff !important;
			}
			
			.nicEdit-panel {
				background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
				border: 2px solid #e2e8f0 !important;
				border-radius: 10px 10px 0 0 !important;
				padding: 8px !important;
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
			
			/* Info Box */
			.info-box {
				background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
				border-left: 4px solid #3b82f6;
				border-radius: 12px;
				padding: 18px;
				margin-bottom: 24px;
			}
			
			.info-box-title {
				display: flex;
				align-items: center;
				gap: 8px;
				font-size: 14px;
				font-weight: 700;
				color: #1e40af;
				margin-bottom: 8px;
			}
			
			.info-box-title i {
				font-size: 16px;
			}
			
			.info-box-text {
				font-size: 13px;
				color: #1e3a8a;
				margin: 0;
				font-weight: 500;
			}
			
			/* Responsive */
			@media (max-width: 768px) {
				.main-content {
					padding: 20px 16px;
				}
				
				.page-header-modern {
					padding: 24px;
					border-radius: 16px;
				}
				
				.page-header-modern h1 {
					font-size: 24px;
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
				max-width: 850px;
				margin: 0 auto;
				padding-bottom: 40px;
			}
			
			/* Remove old styles */
			#page-title {
				display: none;
			}
		</style>
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
								<i class="fas fa-address-book"></i>
								Contact Us Settings
							</h1>
							<p>Update contact information displayed to users</p>
						</div>
						
						<!-- Form Card -->
						<div class="form-card-modern">
							<div class="form-header">
								<div class="form-icon-badge">
									<i class="fas fa-edit"></i>
								</div>
								<div>
									<h2 class="form-title">Update Contact Information</h2>
									<p class="form-subtitle">Manage your contact page details</p>
								</div>
							</div>
							
							<!-- Info Box -->
							<div class="info-box">
								<div class="info-box-title">
									<i class="fas fa-info-circle"></i>
									Important Information
								</div>
								<p class="info-box-text">
									This information will be displayed on the public Contact Us page. Make sure all details are accurate and up-to-date.
								</p>
							</div>
							
							<!-- Form -->
							<form class="forms-sample" method="post">
								<?php
								$ret=mysqli_query($con,"select * from  tblpage where PageType='contactus'");
								$cnt=1;
								while ($row=mysqli_fetch_array($ret)) {
								?>
								
								<!-- Page Title -->
								<div class="form-group-modern">
									<label class="form-label-modern">
										<i class="fas fa-heading"></i>
										Page Title
									</label>
									<div class="input-wrapper">
										<input type="text" 
											   id="pagetitle" 
											   name="pagetitle" 
											   class="form-control-modern" 
											   required="true" 
											   value="<?php echo htmlentities($row['PageTitle']);?>"
											   placeholder="Enter page title">
										<i class="fas fa-heading input-icon"></i>
									</div>
								</div>
								
								<!-- Page Description -->
								<div class="form-group-modern">
									<label class="form-label-modern">
										<i class="fas fa-align-left"></i>
										Page Description
									</label>
									<textarea class="form-control-modern" 
											  name="pagedes" 
											  id="pagedes" 
											  rows="5"
											  placeholder="Enter page description"><?php echo htmlentities($row['PageDescription']);?></textarea>
								</div>
								
								<!-- Email Address -->
								<div class="form-group-modern">
									<label class="form-label-modern">
										<i class="fas fa-envelope"></i>
										Email Address
									</label>
									<div class="input-wrapper">
										<input type="email" 
											   class="form-control-modern" 
											   name="email" 
											   value="<?php echo htmlentities($row['Email']);?>" 
											   required='true'
											   placeholder="contact@example.com">
										<i class="fas fa-envelope input-icon"></i>
									</div>
								</div>
								
								<!-- Mobile Number -->
								<div class="form-group-modern">
									<label class="form-label-modern">
										<i class="fas fa-phone"></i>
										Mobile Number
									</label>
									<div class="input-wrapper">
										<input type="text" 
											   class="form-control-modern" 
											   name="mobnum" 
											   value="<?php echo htmlentities($row['MobileNumber']);?>" 
											   required='true' 
											   maxlength="10" 
											   pattern='[0-9]+'
											   placeholder="Enter 10-digit mobile number">
										<i class="fas fa-phone input-icon"></i>
									</div>
								</div>
								
								<?php } ?>
								
								<!-- Submit Button -->
								<button type="submit" class="btn-submit-modern" name="submit">
									<i class="fas fa-save"></i>
									Update Contact Information
								</button>
							</form>
							
						</div>
						
					</div>
				</div>
			</div>
			
		</div>
			
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