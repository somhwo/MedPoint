<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
  } else{

if(isset($_POST['submit']))
{	$docspecialization=$_POST['Doctorspecialization'];
$docname=$_POST['docname'];
$docaddress=$_POST['clinicaddress'];
$docfees=$_POST['docfees'];
$doccontactno=$_POST['doccontact'];
$docemail=$_POST['docemail'];
$password=md5($_POST['npass']);
$sql=mysqli_query($con,"insert into doctors(specilization,doctorName,address,docFees,contactno,docEmail,password) values('$docspecialization','$docname','$docaddress','$docfees','$doccontactno','$docemail','$password')");
if($sql)
{
echo "<script>alert('Doctor info added Successfully');</script>";
echo "<script>window.location.href ='manage-doctors.php'</script>";

}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Add Doctor</title>
		
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
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
	}
	
	.wrap-content {
		padding: 40px 30px;
	}
	
	/* Simple Page Title - Like Dashboard */
	#page-title {
		background: transparent;
		padding: 0 0 40px 0;
		border: none;
	}
	
	#page-title .mainTitle {
		font-size: 36px;
		font-weight: 800;
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		-webkit-background-clip: text;
		-webkit-text-fill-color: transparent;
		background-clip: text;
		margin: 0;
		letter-spacing: -1px;
	}
	
	#page-title .breadcrumb {
		background: transparent;
		padding: 12px 0;
		margin: 12px 0 0 0;
		font-size: 14px;
	}
	
	#page-title .breadcrumb li {
		color: #64748b;
		font-weight: 400;
	}
	
	#page-title .breadcrumb li.active {
		color: #334155;
		font-weight: 600;
	}
	
	/* Info Alert Box */
	.info-alert {
		background: #fef3c7;
		border-left: 4px solid #f59e0b;
		border-radius: 12px;
		padding: 16px 20px;
		margin-bottom: 30px;
		display: flex;
		align-items: center;
		gap: 12px;
	}
	
	.info-alert i {
		color: #f59e0b;
		font-size: 20px;
		flex-shrink: 0;
	}
	
	.info-alert-text {
		color: #92400e;
		font-size: 14px;
		font-weight: 500;
		margin: 0;
	}
	
	/* Simple White Form Card */
	.form-card {
		background: #ffffff;
		border-radius: 16px;
		padding: 35px;
		box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
	}
	
	.form-header {
		display: flex;
		align-items: center;
		gap: 12px;
		margin-bottom: 30px;
		padding-bottom: 20px;
		border-bottom: 2px solid #e2e8f0;
	}
	
	.form-icon {
		width: 48px;
		height: 48px;
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
	}
	
	.form-icon i {
		color: #ffffff;
		font-size: 20px;
	}
	
	.form-title {
		font-size: 20px;
		font-weight: 700;
		color: #0f172a;
		margin: 0;
	}
	
	/* Form Groups */
	.form-group-modern {
		margin-bottom: 24px;
	}
	
	.form-label-modern {
		font-weight: 600;
		color: #334155;
		margin-bottom: 10px;
		font-size: 14px;
		display: flex;
		align-items: center;
		gap: 8px;
	}
	
	.form-label-modern i {
		color: #667eea;
		font-size: 14px;
	}
	
	.form-label-modern .required {
		color: #ef4444;
		font-size: 14px;
	}
	
	.input-modern,
	.select-modern,
	.textarea-modern {
		width: 100%;
		padding: 14px 18px;
		border: 2px solid #e2e8f0;
		border-radius: 12px;
		font-size: 14px;
		transition: all 0.3s ease;
		background: #ffffff;
		color: #1e293b;
	}
	
	.input-modern:focus,
	.select-modern:focus,
	.textarea-modern:focus {
		outline: none;
		border-color: #667eea;
		box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
	}
	
	.textarea-modern {
		min-height: 100px;
		resize: vertical;
	}
	
	.select-modern {
		appearance: none;
		background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23667eea' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
		background-repeat: no-repeat;
		background-position: right 18px center;
		padding-right: 45px;
	}
	
	/* Input with Icon */
	.input-group-modern {
		position: relative;
	}
	
	.input-icon {
		position: absolute;
		left: 18px;
		top: 50%;
		transform: translateY(-50%);
		color: #94a3b8;
		font-size: 16px;
	}
	
	.input-with-icon {
		padding-left: 48px;
	}
	
	/* Helper Text */
	.helper-text {
		font-size: 12px;
		color: #64748b;
		margin-top: 6px;
	}
	
	/* Availability Status */
	#email-availability-status {
		display: block;
		margin-top: 6px;
		font-size: 13px;
		font-weight: 600;
	}
	
	/* Loading Spinner */
	#loaderIcon {
		display: inline-block;
		width: 14px;
		height: 14px;
		border: 2px solid #667eea;
		border-top-color: transparent;
		border-radius: 50%;
		animation: spin 0.6s linear infinite;
		margin-left: 8px;
	}
	
	@keyframes spin {
		to { transform: rotate(360deg); }
	}
	
	/* Action Buttons */
	.action-buttons {
		display: flex;
		gap: 12px;
		margin-top: 30px;
		padding-top: 25px;
		border-top: 2px solid #e2e8f0;
	}
	
	.btn-modern {
		padding: 14px 32px;
		border-radius: 12px;
		font-weight: 600;
		font-size: 15px;
		cursor: pointer;
		transition: all 0.3s ease;
		display: inline-flex;
		align-items: center;
		gap: 10px;
		border: none;
	}
	
	.btn-submit {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		color: #ffffff;
		box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
	}
	
	.btn-submit:hover {
		transform: translateY(-2px);
		box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
	}
	
	.btn-reset {
		background: #ffffff;
		color: #475569;
		border: 2px solid #e2e8f0;
	}
	
	.btn-reset:hover {
		background: #f8fafc;
		border-color: #cbd5e1;
	}
	
	/* Container Overrides */
	.container-fluid.container-fullw {
		background: transparent;
		padding: 0;
	}
	
	.panel {
		border: none;
		box-shadow: none;
		background: transparent;
		margin-bottom: 0;
	}
	
	.panel-body {
		padding: 0;
	}
	
	/* Responsive */
	@media (max-width: 768px) {
		.wrap-content {
			padding: 24px 16px;
		}
		
		#page-title .mainTitle {
			font-size: 28px;
		}
		
		.form-card {
			padding: 24px 20px;
		}
		
		.action-buttons {
			flex-direction: column;
		}
		
		.btn-modern {
			width: 100%;
			justify-content: center;
		}
	}
</style>

<script type="text/javascript">
function valid()
{
 if(document.adddoc.npass.value!= document.adddoc.cfpass.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.adddoc.cfpass.focus();
return false;
}
return true;
}
</script>

<script>
function checkemailAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#docemail").val(),
type: "POST",
success:function(data){
$("#email-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
	</head>
	<body>
		<div id="app">		
<?php include('include/sidebar.php');?>
			<div class="app-content">
				
						<?php include('include/header.php');?>
						
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						
						<!-- Simple Page Title - Like Dashboard -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Add Doctor</h1>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>Admin</span>
									</li>
									<li>
										<span>Doctors</span>
									</li>
									<li class="active">
										<span>Add Doctor</span>
									</li>
								</ol>
							</div>
						</section>
						
						<!-- Form Section -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-lg-10 col-md-12 mx-auto">
											<div class="panel panel-white">
												<div class="panel-body">
													
													<div class="info-alert">
														<i class="fas fa-info-circle"></i>
														<p class="info-alert-text">
															Please fill in all required fields marked with <span style="color: #ef4444;">*</span>. The doctor will receive login credentials via email.
														</p>
													</div>
													
													<div class="form-card">
														<div class="form-header">
															<div class="form-icon">
																<i class="fas fa-user-doctor"></i>
															</div>
															<h2 class="form-title">Doctor Information</h2>
														</div>
													
														<form role="form" name="adddoc" method="post" onSubmit="return valid();">
															
															<!-- Specialization -->
															<div class="form-group-modern">
																<label class="form-label-modern">
																	<i class="fas fa-stethoscope"></i>
																	Doctor Specialization
																	<span class="required">*</span>
																</label>
																<select name="Doctorspecialization" class="select-modern" required="true">
																	<option value="">Select Specialization</option>
																	<?php $ret=mysqli_query($con,"select * from doctorspecilization");
																	while($row=mysqli_fetch_array($ret))
																	{
																	?>
																	<option value="<?php echo htmlentities($row['specilization']);?>">
																		<?php echo htmlentities($row['specilization']);?>
																	</option>
																	<?php } ?>
																</select>
															</div>

															<!-- Doctor Name -->
															<div class="form-group-modern">
																<label class="form-label-modern">
																	<i class="fas fa-user"></i>
																	Doctor Name
																	<span class="required">*</span>
																</label>
																<div class="input-group-modern">
																	<i class="fas fa-user input-icon"></i>
																	<input type="text" name="docname" class="input-modern input-with-icon" placeholder="Enter Doctor Full Name" required="true">
																</div>
															</div>

															<!-- Clinic Address -->
															<div class="form-group-modern">
																<label class="form-label-modern">
																	<i class="fas fa-location-dot"></i>
																	Clinic Address
																	<span class="required">*</span>
																</label>
																<textarea name="clinicaddress" class="textarea-modern" placeholder="Enter Complete Clinic Address" required="true"></textarea>
															</div>

															<!-- Consultancy Fees -->
															<div class="form-group-modern">
																<label class="form-label-modern">
																	<i class="fas fa-dollar-sign"></i>
																	Consultancy Fees
																	<span class="required">*</span>
																</label>
																<div class="input-group-modern">
																	<i class="fas fa-money-bill-wave input-icon"></i>
																	<input type="text" name="docfees" class="input-modern input-with-icon" placeholder="Enter Fee Amount" required="true">
																</div>
															</div>
															
															<!-- Contact Number -->
															<div class="form-group-modern">
																<label class="form-label-modern">
																	<i class="fas fa-phone"></i>
																	Contact Number
																	<span class="required">*</span>
																</label>
																<div class="input-group-modern">
																	<i class="fas fa-mobile-screen input-icon"></i>
																	<input type="text" name="doccontact" class="input-modern input-with-icon" placeholder="Enter Contact Number" required="true">
																</div>
															</div>

															<!-- Email -->
															<div class="form-group-modern">
																<label class="form-label-modern">
																	<i class="fas fa-envelope"></i>
																	Email Address
																	<span class="required">*</span>
																</label>
																<div class="input-group-modern">
																	<i class="fas fa-at input-icon"></i>
																	<input type="email" id="docemail" name="docemail" class="input-modern input-with-icon" placeholder="Enter Email Address" required="true" onBlur="checkemailAvailability()">
																</div>
																<span id="email-availability-status"></span>
																<span id="loaderIcon" style="display:none;"></span>
															</div>

															<!-- Password -->
															<div class="form-group-modern">
																<label class="form-label-modern">
																	<i class="fas fa-lock"></i>
																	Password
																	<span class="required">*</span>
																</label>
																<div class="input-group-modern">
																	<i class="fas fa-key input-icon"></i>
																	<input type="password" name="npass" class="input-modern input-with-icon" placeholder="Create Strong Password" required="required">
																</div>
																<p class="helper-text">Minimum 8 characters with letters and numbers</p>
															</div>
															
															<!-- Confirm Password -->
															<div class="form-group-modern">
																<label class="form-label-modern">
																	<i class="fas fa-lock"></i>
																	Confirm Password
																	<span class="required">*</span>
																</label>
																<div class="input-group-modern">
																	<i class="fas fa-check-double input-icon"></i>
																	<input type="password" name="cfpass" class="input-modern input-with-icon" placeholder="Re-enter Password" required="required">
																</div>
															</div>
															
															<!-- Action Buttons -->
															<div class="action-buttons">
																<button type="submit" name="submit" id="submit" class="btn-modern btn-submit">
																	<i class="fas fa-check-circle"></i>
																	Add Doctor
																</button>
																<button type="reset" class="btn-modern btn-reset">
																	<i class="fas fa-rotate-left"></i>
																	Reset Form
																</button>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>		
			<!-- start: SETTINGS -->
	<?php include('include/setting.php');?>
			
			<!-- end: SETTINGS -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="assets/js/form-elements.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
<?php } ?>