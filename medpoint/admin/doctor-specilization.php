<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
  } else{

if(isset($_POST['submit']))
{
$doctorspecilization=$_POST['doctorspecilization'];
$sql=mysqli_query($con,"insert into doctorSpecilization(specilization) values('$doctorspecilization')");
$_SESSION['msg']="Doctor Specialization added successfully !!";
}
//Code Deletion
if(isset($_GET['del']))
{
$sid=$_GET['id'];	
mysqli_query($con,"delete from doctorSpecilization where id = '$sid'");
$_SESSION['msg']="data deleted !!";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Doctor Specialization</title>
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
			
			/* Modern Page Header */
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
			
			/* Form Card */
			.form-card-modern {
				background: #ffffff;
				border-radius: 20px;
				padding: 28px;
				box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
				border: 1px solid #e2e8f0;
				transition: all 0.4s ease;
				margin-bottom: 30px;
			}
			
			.form-card-modern:hover {
				box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
			}
			
			.form-header {
				display: flex;
				align-items: center;
				gap: 14px;
				margin-bottom: 20px;
				padding-bottom: 18px;
				border-bottom: 2px solid #e2e8f0;
			}
			
			.form-icon-badge {
				width: 44px;
				height: 44px;
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				border-radius: 12px;
				display: flex;
				align-items: center;
				justify-content: center;
				box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
			}
			
			.form-icon-badge i {
				color: #ffffff;
				font-size: 18px;
			}
			
			.form-title {
				font-size: 18px;
				font-weight: 700;
				color: #0f172a;
				margin: 0;
			}
			
			/* Alert Messages */
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
			
			.alert-modern i {
				font-size: 18px;
			}
			
			/* Form Groups */
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
			
			/* Submit Button */
			.btn-submit-modern {
				display: inline-flex;
				align-items: center;
				justify-content: center;
				gap: 8px;
				padding: 12px 28px;
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				color: #ffffff;
				border: none;
				border-radius: 10px;
				font-size: 14px;
				font-weight: 700;
				cursor: pointer;
				transition: all 0.3s ease;
				box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
			}
			
			.btn-submit-modern:hover {
				transform: translateY(-2px);
				box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
			}
			
			.btn-submit-modern i {
				font-size: 14px;
			}
			
			/* Table Card */
			.table-card-glass {
				background: #ffffff;
				border-radius: 20px;
				padding: 28px;
				box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
				border: 1px solid #e2e8f0;
				transition: all 0.4s ease;
			}
			
			.table-card-glass:hover {
				box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
			}
			
			.card-header-section {
				display: flex;
				align-items: center;
				justify-content: space-between;
				margin-bottom: 20px;
				padding-bottom: 18px;
				border-bottom: 2px solid #e2e8f0;
			}
			
			.card-header-left {
				display: flex;
				align-items: center;
				gap: 14px;
			}
			
			.card-icon-badge {
				width: 44px;
				height: 44px;
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				border-radius: 12px;
				display: flex;
				align-items: center;
				justify-content: center;
				box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
			}
			
			.card-icon-badge i {
				color: #ffffff;
				font-size: 18px;
			}
			
			.card-title-main {
				font-size: 18px;
				font-weight: 700;
				color: #0f172a;
				margin: 0;
			}
			
			.card-subtitle {
				font-size: 12px;
				color: #64748b;
				margin: 4px 0 0 0;
				font-weight: 500;
			}
			
			/* Stats Badge */
			.stat-badge {
				display: flex;
				align-items: center;
				gap: 6px;
				padding: 8px 16px;
				border-radius: 10px;
				font-size: 12px;
				font-weight: 700;
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				color: #ffffff;
				box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
			}
			
			/* Modern Table */
			.table-modern {
				width: 100%;
				border-collapse: separate;
				border-spacing: 0;
			}
			
			.table-modern thead {
				background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
			}
			
			.table-modern thead th {
				padding: 14px 12px;
				font-size: 11px;
				font-weight: 700;
				text-transform: uppercase;
				color: #475569;
				letter-spacing: 0.5px;
				border-bottom: 2px solid #e2e8f0;
				text-align: left;
				white-space: nowrap;
				vertical-align: middle;
			}
			
			.table-modern thead th:first-child {
				border-radius: 12px 0 0 0;
				text-align: center;
				width: 60px;
			}
			
			.table-modern thead th:last-child {
				border-radius: 0 12px 0 0;
				text-align: center;
			}
			
			.table-modern tbody tr {
				transition: all 0.3s ease;
				border-bottom: 1px solid #f1f5f9;
			}
			
			.table-modern tbody tr:hover {
				background: linear-gradient(135deg, #f8faff 0%, #f1f5ff 100%);
				transform: scale(1.001);
				box-shadow: 0 2px 8px rgba(102, 126, 234, 0.08);
			}
			
			.table-modern tbody td {
				padding: 16px 12px;
				font-size: 13px;
				color: #334155;
				vertical-align: middle;
			}
			
			.table-modern tbody td:first-child {
				text-align: center;
			}
			
			.table-modern tbody td:last-child {
				text-align: center;
			}
			
			.table-modern tbody tr:last-child td:first-child {
				border-radius: 0 0 0 12px;
			}
			
			.table-modern tbody tr:last-child td:last-child {
				border-radius: 0 0 12px 0;
			}
			
			/* Cell Styles */
			.cell-number {
				font-weight: 700;
				color: #667eea;
				font-size: 14px;
			}
			
			.cell-content {
				display: block;
				width: 100%;
				color: #475569;
				font-weight: 500;
			}
			
			.cell-specialization {
				font-weight: 600;
				color: #0f172a;
				font-size: 14px;
			}
			
			/* Action Buttons */
			.btn-action {
				display: inline-flex;
				align-items: center;
				justify-content: center;
				width: 32px;
				height: 32px;
				border-radius: 8px;
				border: none;
				cursor: pointer;
				transition: all 0.3s ease;
				margin: 0 3px;
			}
			
			.btn-edit {
				background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
				color: #1e40af;
			}
			
			.btn-edit:hover {
				background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
				color: #ffffff;
				transform: translateY(-2px);
				box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
			}
			
			.btn-delete {
				background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
				color: #991b1b;
			}
			
			.btn-delete:hover {
				background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
				color: #ffffff;
				transform: translateY(-2px);
				box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
			}
			
			.btn-action i {
				font-size: 13px;
			}
			
			/* Empty State */
			.empty-state {
				text-align: center;
				padding: 50px 20px;
			}
			
			.empty-state-icon {
				width: 90px;
				height: 90px;
				background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
				margin: 0 auto 16px;
			}
			
			.empty-state-icon i {
				font-size: 36px;
				color: #94a3b8;
			}
			
			.empty-state-title {
				font-size: 16px;
				font-weight: 700;
				color: #334155;
				margin-bottom: 8px;
			}
			
			.empty-state-text {
				font-size: 13px;
				color: #64748b;
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
				
				.form-card-modern,
				.table-card-glass {
					padding: 20px;
					border-radius: 16px;
				}
				
				.card-header-section {
					flex-direction: column;
					align-items: flex-start;
					gap: 12px;
				}
				
				.table-wrapper {
					overflow-x: auto;
					-webkit-overflow-scrolling: touch;
					margin: 0 -20px;
					padding: 0 20px;
				}
				
				.table-modern {
					min-width: 700px;
				}
			}
			
			/* Container Overrides */
			.container-fluid.container-fullw {
				background: transparent;
				padding: 0;
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
								<i class="fas fa-stethoscope"></i>
								Doctor Specializations
							</h1>
							<p>Manage medical specializations for doctors</p>
						</div>
						
						<!-- Add Specialization Form -->
						<div class="form-card-modern">
							<div class="form-header">
								<div class="form-icon-badge">
									<i class="fas fa-plus-circle"></i>
								</div>
								<div>
									<h2 class="form-title">Add New Specialization</h2>
								</div>
							</div>
							
							<!-- Alert Message -->
							<?php if(!empty($_SESSION['msg'])): ?>
							<div class="alert-modern alert-success">
								<i class="fas fa-check-circle"></i>
								<span><?php echo htmlentities($_SESSION['msg']); ?></span>
							</div>
							<?php $_SESSION['msg']=""; ?>
							<?php endif; ?>
							
							<form role="form" name="dcotorspcl" method="post">
								<div class="form-group-modern">
									<label class="form-label-modern">
										<i class="fas fa-user-md"></i>
										Specialization Name
									</label>
									<div class="input-wrapper">
										<input type="text" 
											   name="doctorspecilization" 
											   class="form-control-modern" 
											   placeholder="e.g., Cardiology, Pediatrics, Neurology"
											   required>
										<i class="fas fa-user-md input-icon"></i>
									</div>
								</div>
								
								<button type="submit" name="submit" class="btn-submit-modern">
									<i class="fas fa-plus"></i>
									Add Specialization
								</button>
							</form>
						</div>
						
						<!-- Manage Specializations Table -->
						<div class="table-card-glass">
							<div class="card-header-section">
								<div class="card-header-left">
									<div class="card-icon-badge">
										<i class="fas fa-list"></i>
									</div>
									<div>
										<h2 class="card-title-main">Manage Specializations</h2>
										<p class="card-subtitle">View and manage all medical specializations</p>
									</div>
								</div>
								<div>
									<?php 
									$total_spec = mysqli_num_rows(mysqli_query($con,"SELECT * FROM doctorSpecilization"));
									?>
									<div class="stat-badge">
										<i class="fas fa-hashtag"></i>
										Total: <?php echo $total_spec; ?>
									</div>
								</div>
							</div>
							
							<div class="table-wrapper">
								<table class="table-modern">
									<thead>
										<tr>
											<th style="text-align: center;">#</th>
											<th>SPECIALIZATION</th>
											<th>CREATION DATE</th>
											<th>LAST UPDATE</th>
											<th style="text-align: center;">ACTIONS</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql=mysqli_query($con,"select * from doctorSpecilization ORDER BY id DESC");
										$cnt=1;
										$has_records = false;
										
										while($row=mysqli_fetch_array($sql))
										{
											$has_records = true;
										?>
										<tr>
											<td class="cell-number"><?php echo $cnt;?></td>
											<td>
												<span class="cell-specialization">
													<i class="fas fa-briefcase-medical" style="color: #667eea; margin-right: 8px;"></i>
													<?php echo htmlentities($row['specilization']);?>
												</span>
											</td>
											<td>
												<span class="cell-content">
													<i class="fas fa-calendar-plus" style="color: #10b981; margin-right: 6px;"></i>
													<?php echo htmlentities($row['creationDate']);?>
												</span>
											</td>
											<td>
												<span class="cell-content">
													<?php if($row['updationDate']): ?>
														<i class="fas fa-calendar-check" style="color: #f59e0b; margin-right: 6px;"></i>
														<?php echo htmlentities($row['updationDate']);?>
													<?php else: ?>
														<span style="color: #94a3b8; font-style: italic;">Not updated</span>
													<?php endif; ?>
												</span>
											</td>
											<td>
												<a href="edit-doctor-specialization.php?id=<?php echo $row['id'];?>" 
												   class="btn-action btn-edit"
												   title="Edit Specialization">
													<i class="fas fa-edit"></i>
												</a>
												<a href="doctor-specilization.php?id=<?php echo $row['id']?>&del=delete" 
												   onclick="return confirm('Are you sure you want to delete this specialization?')"
												   class="btn-action btn-delete"
												   title="Delete Specialization">
													<i class="fas fa-trash"></i>
												</a>
											</td>
										</tr>
										<?php 
										$cnt++;
										}
										
										if(!$has_records) {
										?>
										<tr>
											<td colspan="5">
												<div class="empty-state">
													<div class="empty-state-icon">
														<i class="fas fa-folder-open"></i>
													</div>
													<h3 class="empty-state-title">No Specializations Found</h3>
													<p class="empty-state-text">
														Add your first medical specialization using the form above.
													</p>
												</div>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
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