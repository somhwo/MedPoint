<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
  } else{

if(isset($_POST['submit']))
{	
	$eid=$_GET['editid'];
	$patname=$_POST['patname'];
$patcontact=$_POST['patcontact'];
$patemail=$_POST['patemail'];
$gender=$_POST['gender'];
$pataddress=$_POST['pataddress'];
$patage=$_POST['patage'];
$medhis=$_POST['medhis'];
$sql=mysqli_query($con,"update tblpatient set PatientName='$patname',PatientContno='$patcontact',PatientEmail='$patemail',PatientGender='$gender',PatientAdd='$pataddress',PatientAge='$patage',PatientMedhis='$medhis' where ID='$eid'");
if($sql)
{
echo "<script>alert('Patient info updated Successfully');</script>";
header('location:manage-patient.php');

}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Patient | Edit Patient</title>
		
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
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
			:root {
				--primary-blue: #2563eb;
				--primary-dark: #1e40af;
				--primary-light: #3b82f6;
				--secondary-blue: #60a5fa;
				--accent-blue: #0ea5e9;
				--light-blue-bg: #eff6ff;
				--card-bg: #ffffff;
				--text-primary: #1e293b;
				--text-secondary: #475569;
				--text-light: #64748b;
				--border-color: #e2e8f0;
				--success: #10b981;
				--warning: #f59e0b;
				--danger: #ef4444;
				--shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06);
				--shadow-md: 0 4px 12px rgba(37, 99, 235, 0.1);
				--shadow-lg: 0 10px 30px rgba(37, 99, 235, 0.15);
			}

			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			}

			body {
				font-family: 'Poppins', sans-serif !important;
				background: var(--light-blue-bg);
				color: var(--text-primary);
				line-height: 1.6;
			}

			.main-content {
				background: var(--light-blue-bg);
				min-height: 100vh;
			}

			.wrap-content {
				padding: 30px 25px;
			}

			/* Page Header */
			#page-title {
				background: transparent;
				padding: 0;
				margin-bottom: 30px;
				border: none;
			}

			#page-title .mainTitle {
				color: var(--primary-blue);
				font-size: 36px;
				font-weight: 800;
				margin: 0 0 15px 0;
				letter-spacing: -0.5px;
				text-transform: uppercase;
			}

			.breadcrumb {
				background: transparent;
				padding: 0;
				margin: 0;
				display: flex;
				align-items: center;
				gap: 8px;
				list-style: none;
			}

			.breadcrumb li {
				color: var(--text-secondary);
				font-size: 14px;
				font-weight: 400;
			}

			.breadcrumb li.active {
				font-weight: 600;
				color: var(--primary-blue);
			}

			.breadcrumb li a {
				color: var(--text-light);
				text-decoration: none;
				transition: all 0.3s;
			}

			.breadcrumb li a:hover {
				color: var(--primary-blue);
			}

			.breadcrumb li + li:before {
				content: "/";
				margin: 0 8px;
				color: var(--text-light);
			}

			/* Main Card */
			.container-fluid.container-fullw.bg-white {
				background: transparent;
				padding: 0;
			}

			.panel {
				background: white;
				border-radius: 16px;
				box-shadow: var(--shadow-md);
				border: 1px solid var(--border-color);
				overflow: hidden;
			}

			.panel-heading {
				background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
				padding: 25px 30px;
				border-bottom: none;
			}

			.panel-title {
				color: white !important;
				font-size: 22px;
				font-weight: 700;
				margin: 0;
				letter-spacing: -0.3px;
			}

			.panel-body {
				padding: 35px 30px;
			}

			/* Form Styling */
			.form-group {
				margin-bottom: 25px;
			}

			.form-group label {
				color: var(--text-primary);
				font-weight: 600;
				font-size: 14px;
				margin-bottom: 10px;
				display: block;
			}

			.form-control {
				height: 48px;
				border: 2px solid var(--border-color);
				border-radius: 10px;
				padding: 12px 18px;
				font-size: 14px;
				font-weight: 500;
				color: var(--text-primary);
				transition: all 0.3s ease;
				background: white;
			}

			.form-control:focus {
				border-color: var(--primary-blue);
				box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
				outline: none;
			}

			.form-control:disabled,
			.form-control[readonly] {
				background: #f8fafc;
				color: var(--text-light);
				cursor: not-allowed;
			}

			textarea.form-control {
				height: auto;
				min-height: 120px;
				resize: vertical;
			}

			/* Radio Buttons */
			.control-label {
				color: var(--text-primary);
				font-weight: 600;
				font-size: 14px;
				margin-bottom: 12px;
				display: block;
			}

			.radio-group {
				display: flex;
				gap: 25px;
				margin-top: 10px;
			}

			.radio-option {
				display: flex;
				align-items: center;
				gap: 8px;
				cursor: pointer;
			}

			.radio-option input[type="radio"] {
				width: 20px;
				height: 20px;
				cursor: pointer;
				accent-color: var(--primary-blue);
			}

			.radio-option label {
				margin: 0;
				cursor: pointer;
				font-weight: 500;
				color: var(--text-secondary);
			}

			/* Buttons */
			.btn {
				padding: 12px 32px;
				border-radius: 10px;
				font-weight: 600;
				font-size: 14px;
				transition: all 0.3s ease;
				border: none;
				cursor: pointer;
				display: inline-flex;
				align-items: center;
				gap: 8px;
			}

			.btn-primary {
				background: var(--primary-blue);
				color: white;
				box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
			}

			.btn-primary:hover {
				background: var(--primary-dark);
				transform: translateY(-2px);
				box-shadow: 0 6px 18px rgba(37, 99, 235, 0.4);
			}

			.btn-secondary {
				background: #6b7280;
				color: white;
				box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
			}

			.btn-secondary:hover {
				background: #4b5563;
				transform: translateY(-2px);
				box-shadow: 0 6px 18px rgba(107, 114, 128, 0.4);
			}

			.button-group {
				display: flex;
				gap: 15px;
				margin-top: 30px;
				padding-top: 20px;
				border-top: 2px solid var(--border-color);
			}

			/* Form Layout */
			.form-row {
				display: grid;
				grid-template-columns: repeat(2, 1fr);
				gap: 20px;
			}

			/* Alert Styling */
			.alert {
				padding: 16px 20px;
				border-radius: 12px;
				margin-bottom: 25px;
				display: flex;
				align-items: center;
				gap: 12px;
				animation: slideDown 0.4s ease;
			}

			.alert-success {
				background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
				color: white;
				border: none;
			}

			.alert-danger {
				background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
				color: white;
				border: none;
			}

			@keyframes slideDown {
				from {
					opacity: 0;
					transform: translateY(-20px);
				}
				to {
					opacity: 1;
					transform: translateY(0);
				}
			}

			/* Input Icons */
			.input-group {
				position: relative;
			}

			.input-group .fa {
				position: absolute;
				left: 18px;
				top: 50%;
				transform: translateY(-50%);
				color: var(--text-light);
				font-size: 16px;
				z-index: 1;
			}

			.input-group .form-control {
				padding-left: 48px;
			}

			/* Required Field Indicator */
			.form-group label::after {
				content: '*';
				color: var(--danger);
				margin-left: 4px;
				font-weight: 700;
			}

			.form-group.optional label::after {
				content: '';
			}

			/* Responsive Design */
			@media (max-width: 768px) {
				.wrap-content {
					padding: 20px 15px;
				}

				#page-title .mainTitle {
					font-size: 28px;
				}

				.panel-heading {
					padding: 20px;
				}

				.panel-title {
					font-size: 18px;
				}

				.panel-body {
					padding: 25px 20px;
				}

				.form-row {
					grid-template-columns: 1fr;
					gap: 0;
				}

				.button-group {
					flex-direction: column;
				}

				.btn {
					width: 100%;
					justify-content: center;
				}

				.radio-group {
					flex-direction: column;
					gap: 12px;
				}
			}

			@media (max-width: 576px) {
				#page-title .mainTitle {
					font-size: 24px;
				}

				.breadcrumb {
					font-size: 12px;
				}

				.panel {
					border-radius: 12px;
				}

				.form-control {
					height: 44px;
					font-size: 13px;
				}
			}

			/* Loading Animation */
			@keyframes fadeIn {
				from {
					opacity: 0;
					transform: translateY(20px);
				}
				to {
					opacity: 1;
					transform: translateY(0);
				}
			}

			.panel {
				animation: fadeIn 0.4s ease;
			}

			/* Back Button */
			.back-btn {
				background: transparent;
				border: 2px solid var(--primary-blue);
				color: var(--primary-blue);
				padding: 10px 24px;
				border-radius: 10px;
				font-weight: 600;
				font-size: 14px;
				transition: all 0.3s ease;
				text-decoration: none;
				display: inline-flex;
				align-items: center;
				gap: 8px;
				margin-bottom: 20px;
			}

			.back-btn:hover {
				background: var(--primary-blue);
				color: white;
				transform: translateX(-4px);
				text-decoration: none;
			}

			.back-btn i {
				font-size: 16px;
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
						<!-- Page Header -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Edit Patient</h1>
								</div>
							</div>
						</section>

						<!-- Main Content -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
									<!-- Back Button -->
									<a href="manage-patient.php" class="back-btn">
										<i class="fa fa-arrow-left"></i>
										<span>Back to Patients</span>
									</a>

									<div class="row margin-top-30">
										<div class="col-lg-10 col-md-12 col-lg-offset-1">
											<div class="panel panel-white">
												<div class="panel-heading">
													<h5 class="panel-title">
														<i class="fa fa-user-md"></i> Patient Information
													</h5>
												</div>
												<div class="panel-body">
													<form role="form" name="patientForm" method="post">
														<?php
														$eid=$_GET['editid'];
														$ret=mysqli_query($con,"select * from tblpatient where ID='$eid'");
														$cnt=1;
														while ($row=mysqli_fetch_array($ret)) {
														?>
														
														<!-- Personal Information -->
														<div class="form-row">
															<div class="form-group">
																<label for="patname">Patient Name</label>
																<div class="input-group">
																	<i class="fa fa-user"></i>
																	<input type="text" name="patname" id="patname" class="form-control" value="<?php echo $row['PatientName'];?>" required="true" placeholder="Enter patient name">
																</div>
															</div>

															<div class="form-group">
																<label for="patcontact">Contact Number</label>
																<div class="input-group">
																	<i class="fa fa-phone"></i>
																	<input type="text" name="patcontact" id="patcontact" class="form-control" value="<?php echo $row['PatientContno'];?>" required="true" maxlength="10" pattern="[0-9]+" placeholder="Enter contact number">
																</div>
															</div>
														</div>

														<div class="form-row">
															<div class="form-group optional">
																<label for="patemail">Email Address</label>
																<div class="input-group">
																	<i class="fa fa-envelope"></i>
																	<input type="email" id="patemail" name="patemail" class="form-control" value="<?php echo $row['PatientEmail'];?>" readonly='true' placeholder="Email address">
																</div>
															</div>

															<div class="form-group">
																<label for="patage">Age</label>
																<div class="input-group">
																	<i class="fa fa-calendar"></i>
																	<input type="number" name="patage" id="patage" class="form-control" value="<?php echo $row['PatientAge'];?>" required="true" min="1" max="150" placeholder="Enter age">
																</div>
															</div>
														</div>

														<div class="form-group">
															<label class="control-label">Gender</label>
															<div class="radio-group">
																<div class="radio-option">
																	<input type="radio" name="gender" id="gender-male" value="Male" <?php if($row['PatientGender']=="Male"){ echo "checked='true'"; } ?>>
																	<label for="gender-male">Male</label>
																</div>
																<div class="radio-option">
																	<input type="radio" name="gender" id="gender-female" value="Female" <?php if($row['PatientGender']=="Female"){ echo "checked='true'"; } ?>>
																	<label for="gender-female">Female</label>
																</div>
																<div class="radio-option">
																	<input type="radio" name="gender" id="gender-other" value="Other" <?php if($row['PatientGender']=="Other"){ echo "checked='true'"; } ?>>
																	<label for="gender-other">Other</label>
																</div>
															</div>
														</div>

														<div class="form-group">
															<label for="pataddress">Address</label>
															<textarea name="pataddress" id="pataddress" class="form-control" required="true" placeholder="Enter patient address"><?php echo $row['PatientAdd'];?></textarea>
														</div>

														<div class="form-group optional">
															<label for="medhis">Medical History</label>
															<textarea name="medhis" id="medhis" class="form-control" placeholder="Enter patient medical history (if any)"><?php echo $row['PatientMedhis'];?></textarea>
														</div>

														<div class="form-group optional">
															<label for="creationdate">Record Created On</label>
															<div class="input-group">
																<i class="fa fa-clock-o"></i>
																<input type="text" id="creationdate" class="form-control" value="<?php echo $row['CreationDate'];?>" readonly='true'>
															</div>
														</div>

														<?php } ?>

														<!-- Action Buttons -->
														<div class="button-group">
															<button type="submit" name="submit" id="submit" class="btn btn-primary">
																<i class="fa fa-check"></i>
																<span>Update Patient</span>
															</button>
															<a href="manage-patient.php" class="btn btn-secondary">
																<i class="fa fa-times"></i>
																<span>Cancel</span>
															</a>
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
			
			<!-- Footer -->
			<?php include('include/footer.php');?>
			
			<!-- Settings -->
			<?php include('include/setting.php');?>
		</div>

		<!-- Scripts -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<script src="assets/js/main.js"></script>
		<script src="assets/js/form-elements.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();

				// Form validation
				$('form[name="patientForm"]').on('submit', function(e) {
					var contact = $('#patcontact').val();
					if(!/^[0-9]{10}$/.test(contact)) {
						alert('Please enter a valid 10-digit contact number');
						e.preventDefault();
						return false;
					}
				});
			});
		</script>
	</body>
</html>
<?php } ?>