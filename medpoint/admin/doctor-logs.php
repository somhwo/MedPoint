<?php
session_start();
//error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
  } else{

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Doctor Session Logs</title>
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
			
			/* Table Card */
			.table-card-glass {
				background: #ffffff;
				border-radius: 20px;
				padding: 32px;
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
				margin-bottom: 24px;
				padding-bottom: 20px;
				border-bottom: 2px solid #e2e8f0;
			}
			
			.card-header-left {
				display: flex;
				align-items: center;
				gap: 14px;
			}
			
			.card-icon-badge {
				width: 48px;
				height: 48px;
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				border-radius: 14px;
				display: flex;
				align-items: center;
				justify-content: center;
				box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
			}
			
			.card-icon-badge i {
				color: #ffffff;
				font-size: 20px;
			}
			
			.card-title-main {
				font-size: 20px;
				font-weight: 700;
				color: #0f172a;
				margin: 0;
				letter-spacing: -0.5px;
			}
			
			.card-subtitle {
				font-size: 13px;
				color: #64748b;
				margin: 4px 0 0 0;
				font-weight: 500;
			}
			
			/* Stats Badge */
			.stat-badge {
				display: flex;
				align-items: center;
				gap: 8px;
				padding: 10px 18px;
				border-radius: 12px;
				font-size: 13px;
				font-weight: 700;
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				color: #ffffff;
				box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
			}
			
			.stat-badge i {
				font-size: 14px;
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
				padding: 16px 14px;
				font-size: 12px;
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
				padding: 18px 14px;
				font-size: 14px;
				color: #334155;
				vertical-align: middle;
			}
			
			.table-modern tbody td:first-child {
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
				font-size: 15px;
			}
			
			.cell-content {
				display: block;
				width: 100%;
				color: #475569;
				font-weight: 500;
			}
			
			.cell-username {
				font-weight: 600;
				color: #0f172a;
			}
			
			/* Status Badge */
			.status-badge {
				display: inline-flex;
				align-items: center;
				gap: 6px;
				padding: 6px 12px;
				border-radius: 20px;
				font-size: 11px;
				font-weight: 700;
				text-transform: uppercase;
				white-space: nowrap;
			}
			
			.status-badge.success {
				background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
				color: #065f46;
				border: 1px solid #6ee7b7;
			}
			
			.status-badge.failed {
				background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
				color: #991b1b;
				border: 1px solid #fca5a5;
			}
			
			.status-badge i {
				font-size: 11px;
			}
			
			/* Empty State */
			.empty-state {
				text-align: center;
				padding: 60px 20px;
			}
			
			.empty-state-icon {
				width: 100px;
				height: 100px;
				background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
				margin: 0 auto 20px;
			}
			
			.empty-state-icon i {
				font-size: 40px;
				color: #94a3b8;
			}
			
			.empty-state-title {
				font-size: 18px;
				font-weight: 700;
				color: #334155;
				margin-bottom: 8px;
			}
			
			.empty-state-text {
				font-size: 14px;
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
					min-width: 900px;
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
								<i class="fas fa-user-clock"></i>
								Doctor Session Logs
							</h1>
							<p>Monitor doctor login and logout activities</p>
						</div>
						
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
									
									<div class="table-card-glass">
										<div class="card-header-section">
											<div class="card-header-left">
												<div class="card-icon-badge">
													<i class="fas fa-clipboard-list"></i>
												</div>
												<div>
													<h2 class="card-title-main">Session Activity Log</h2>
													<p class="card-subtitle">Track all doctor authentication attempts</p>
												</div>
											</div>
											<div>
												<?php 
												$total_logs = mysqli_num_rows(mysqli_query($con,"SELECT * FROM doctorslog"));
												?>
												<div class="stat-badge">
													<i class="fas fa-database"></i>
													Total Logs: <?php echo $total_logs; ?>
												</div>
											</div>
										</div>
										
										<div class="table-wrapper">
											<table class="table-modern">
												<thead>
													<tr>
														<th style="text-align: center;">#</th>
														<th>USER ID</th>
														<th>USERNAME</th>
														<th>IP ADDRESS</th>
														<th>LOGIN TIME</th>
														<th>LOGOUT TIME</th>
														<th>STATUS</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sql=mysqli_query($con,"select * from doctorslog ORDER BY id DESC");
													$cnt=1;
													$has_records = false;
													
													while($row=mysqli_fetch_array($sql))
													{
														$has_records = true;
													?>
													<tr>
														<td class="cell-number"><?php echo $cnt;?></td>
														<td>
															<span class="cell-content"><?php echo htmlentities($row['uid']);?></span>
														</td>
														<td>
															<span class="cell-username"><?php echo htmlentities($row['username']);?></span>
														</td>
														<td>
															<span class="cell-content">
																<i class="fas fa-network-wired" style="color: #94a3b8; margin-right: 6px;"></i>
																<?php echo htmlentities($row['userip']);?>
															</span>
														</td>
														<td>
															<span class="cell-content">
																<i class="fas fa-sign-in-alt" style="color: #10b981; margin-right: 6px;"></i>
																<?php echo htmlentities($row['loginTime']);?>
															</span>
														</td>
														<td>
															<span class="cell-content">
																<?php if($row['logout']): ?>
																	<i class="fas fa-sign-out-alt" style="color: #ef4444; margin-right: 6px;"></i>
																	<?php echo htmlentities($row['logout']);?>
																<?php else: ?>
																	<span style="color: #94a3b8; font-style: italic;">Still active</span>
																<?php endif; ?>
															</span>
														</td>
														<td>
															<?php if($row['status']==1): ?>
																<span class="status-badge success">
																	<i class="fas fa-check-circle"></i>
																	Success
																</span>
															<?php else: ?>
																<span class="status-badge failed">
																	<i class="fas fa-times-circle"></i>
																	Failed
																</span>
															<?php endif; ?>
														</td>
													</tr>
													<?php 
													$cnt++;
													}
													
													if(!$has_records) {
													?>
													<tr>
														<td colspan="7">
															<div class="empty-state">
																<div class="empty-state-icon">
																	<i class="fas fa-inbox"></i>
																</div>
																<h3 class="empty-state-title">No Session Logs Found</h3>
																<p class="empty-state-text">
																	There are no doctor session logs recorded yet.
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