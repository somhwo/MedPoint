<?php
/**
 * Between Dates Details Reports Page
 * File: betweendates-detailsreports.php
 */
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
    exit;
}

// Get date range from POST
$fdate = isset($_POST['fromdate']) ? $_POST['fromdate'] : '';
$tdate = isset($_POST['todate']) ? $_POST['todate'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | View Patients Report</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Using Font Awesome 6 from CDN for better icon support -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link rel="stylesheet" href="vendor/animate.css/animate.min.css">
    <link rel="stylesheet" href="vendor/perfect-scrollbar/perfect-scrollbar.min.css">
    <link rel="stylesheet" href="vendor/switchery/switchery.min.css">
    <link rel="stylesheet" href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css">
    <link rel="stylesheet" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css">
    <link rel="stylesheet" href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color">
    
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
        
        /* Modern Page Header - FIXED FOR READABILITY */
        .page-header-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 24px;
            padding: 45px 50px;
            margin-bottom: 40px;
            color: #ffffff;
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.4);
            position: relative;
            overflow: hidden;
        }
        
        .page-header-modern::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }
        
        /* FIXED: Made title fully white and more visible */
        .page-header-modern h1 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            z-index: 1;
            letter-spacing: -0.5px;
            color: #ffffff !important;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
        
        .page-header-modern h1 i {
            color: #ffffff !important;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }
        
        /* FIXED: Made subtitle more readable */
        .page-header-modern p {
            font-size: 16px;
            opacity: 1;
            color: rgba(255, 255, 255, 0.95);
            margin: 0;
            position: relative;
            z-index: 1;
            font-weight: 500;
        }
        
        .breadcrumb-modern {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 12px 24px;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            position: relative;
            z-index: 1;
            margin-top: 20px;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }
        
        .breadcrumb-modern span {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }
        
        .breadcrumb-modern .active {
            color: #ffffff;
            font-weight: 700;
        }
        
        .breadcrumb-modern i {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
        }
        
        /* Date Range Display - Simple & Clean */
        .date-range-simple {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
            font-size: 15px;
            color: #475569;
        }
        
        .date-label {
            font-weight: 600;
            color: #64748b;
        }
        
        .date-values {
            font-weight: 700;
            color: #0f172a;
        }
        
        .date-separator {
            color: #667eea;
            font-weight: 600;
            padding: 0 6px;
        }
        
        /* Glass Table Card */
        .table-card-glass {
            background: #ffffff;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
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
            margin-bottom: 30px;
            padding-bottom: 24px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .card-header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .card-icon-badge {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
        
        .card-icon-badge i {
            color: #ffffff;
            font-size: 24px;
        }
        
        .card-title-main {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.5px;
        }
        
        .card-subtitle {
            font-size: 14px;
            color: #64748b;
            margin: 5px 0 0 0;
            font-weight: 500;
        }
        
        /* Stats Badge */
        .stat-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        .stat-badge i {
            font-size: 16px;
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
            padding: 18px 16px;
            font-size: 13px;
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
            width: 60px;
            text-align: center;
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
            padding: 20px 16px;
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
        
        /* Table Cell Styles */
        .cell-number {
            font-weight: 700;
            color: #667eea;
            font-size: 15px;
        }
        
        .cell-name {
            font-weight: 600;
            color: #0f172a;
            font-size: 15px;
        }
        
        .cell-content {
            display: block;
            width: 100%;
            color: #475569;
            font-weight: 500;
        }
        
        /* Gender Badge */
        .gender-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
        }
        
        .gender-badge.male {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            border: 1px solid #93c5fd;
        }
        
        .gender-badge.female {
            background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
            color: #be185d;
            border: 1px solid #f9a8d4;
        }
        
        .gender-badge.other {
            background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
            color: #7c3aed;
            border: 1px solid #d8b4fe;
        }
        
        .gender-badge i {
            font-size: 13px;
        }
        
        /* Action Button */
        .btn-view {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
            color: #ffffff;
            text-decoration: none;
            background: linear-gradient(135deg, #7c8ff0 0%, #8557ac 100%);
        }
        
        .btn-view i {
            font-size: 13px;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }
        
        .empty-state-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        
        .empty-state-icon i {
            font-size: 48px;
            color: #94a3b8;
        }
        
        .empty-state-title {
            font-size: 22px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 12px;
        }
        
        .empty-state-text {
            font-size: 15px;
            color: #64748b;
            line-height: 1.6;
        }
        
        /* Back Button */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.25);
            color: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .btn-back:hover {
            background: rgba(255, 255, 255, 0.35);
            border-color: rgba(255, 255, 255, 0.6);
            color: #ffffff;
            text-decoration: none;
            transform: translateX(-5px);
        }
        
        .btn-back i {
            font-size: 14px;
        }
        
        /* Back Button Bottom - NEW CLEAR DESIGN */
        .btn-back-bottom {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            background: #ffffff;
            color: #667eea;
            border: 2px solid #667eea;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.15);
        }
        
        .btn-back-bottom:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            border-color: #667eea;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        }
        
        .btn-back-bottom i {
            font-size: 15px;
            transition: transform 0.3s ease;
        }
        
        .btn-back-bottom:hover i {
            transform: translateX(-4px);
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
            
            .table-card-glass {
                padding: 20px;
                border-radius: 16px;
            }
            
            .card-header-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
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
            
            .breadcrumb-modern i {
                color: rgba(255, 255, 255, 0.7);
                font-size: 12px;
            }
            
            .date-range-simple {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                font-size: 14px;
            }
        }
        
        /* Container Overrides */
        .container-fluid.container-fullw {
            background: transparent;
            padding: 0;
        }
    </style>
</head>
<body>
    <div id="app">
        <?php include('include/sidebar.php'); ?>
        
        <div class="app-content">
            <?php include('include/header.php'); ?>
            
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    
                    <!-- Modern Page Header -->
                    <div class="page-header-modern">
                        <h1>
                            <i class="fas fa-file-medical"></i>
                            Patients Report
                        </h1>
                        <p>View patients registered within the selected date range</p>
                    </div>
                    
                    <!-- Date Range Display -->
                    <?php if($fdate && $tdate): ?>
                    <div class="date-range-simple">
                        <span class="date-label">Report Date Range:</span>
                        <span class="date-values">
                            <?php echo date('F d, Y', strtotime($fdate)); ?> 
                            <span class="date-separator">to</span> 
                            <?php echo date('F d, Y', strtotime($tdate)); ?>
                        </span>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Table Section -->
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                
                                <div class="table-card-glass">
                                    <div class="card-header-section">
                                        <div class="card-header-left">
                                            <div class="card-icon-badge">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <div>
                                                <h2 class="card-title-main">Patient Records</h2>
                                                <p class="card-subtitle">Registered patients in selected period</p>
                                            </div>
                                        </div>
                                        <div>
                                            <?php 
                                            // Use prepared statement for security
                                            $stmt = $con->prepare("SELECT COUNT(*) as total FROM tblpatient WHERE DATE(CreationDate) BETWEEN ? AND ?");
                                            $stmt->bind_param("ss", $fdate, $tdate);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $count_row = $result->fetch_assoc();
                                            $total_patients = $count_row['total'];
                                            ?>
                                            <div class="stat-badge">
                                                <i class="fas fa-users"></i>
                                                Total: <?php echo $total_patients; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="table-wrapper">
                                        <table class="table-modern">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">#</th>
                                                    <th>PATIENT NAME</th>
                                                    <th>CONTACT NUMBER</th>
                                                    <th>GENDER</th>
                                                    <th>CREATION DATE</th>
                                                    <th>UPDATION DATE</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Use prepared statement for security
                                                $stmt = $con->prepare("SELECT * FROM tblpatient WHERE DATE(CreationDate) BETWEEN ? AND ? ORDER BY CreationDate DESC");
                                                $stmt->bind_param("ss", $fdate, $tdate);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                
                                                $cnt = 1;
                                                $has_records = false;
                                                
                                                while($row = $result->fetch_assoc()) {
                                                    $has_records = true;
                                                    
                                                    // Determine gender badge class
                                                    $gender_class = 'other';
                                                    $gender_icon = 'fa-genderless';
                                                    if(strtolower($row['PatientGender']) == 'male') {
                                                        $gender_class = 'male';
                                                        $gender_icon = 'fa-mars';
                                                    } elseif(strtolower($row['PatientGender']) == 'female') {
                                                        $gender_class = 'female';
                                                        $gender_icon = 'fa-venus';
                                                    }
                                                ?>
                                                <tr>
                                                    <td class="cell-number"><?php echo $cnt; ?></td>
                                                    <td>
                                                        <div class="cell-name"><?php echo htmlentities($row['PatientName']); ?></div>
                                                    </td>
                                                    <td>
                                                        <div class="cell-content"><?php echo htmlentities($row['PatientContno']); ?></div>
                                                    </td>
                                                    <td>
                                                        <span class="gender-badge <?php echo $gender_class; ?>">
                                                            <i class="fas <?php echo $gender_icon; ?>"></i>
                                                            <?php echo htmlentities($row['PatientGender']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="cell-content">
                                                            <?php echo date('M d, Y h:i A', strtotime($row['CreationDate'])); ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="cell-content">
                                                            <?php 
                                                            echo $row['UpdationDate'] 
                                                                ? date('M d, Y h:i A', strtotime($row['UpdationDate'])) 
                                                                : '<span style="color: #94a3b8;">Not updated</span>'; 
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="view-patient.php?viewid=<?php echo $row['ID']; ?>" 
                                                           class="btn-view" 
                                                           target="_blank">
                                                            <i class="fas fa-eye"></i>
                                                            View
                                                        </a>
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
                                                                <i class="fas fa-calendar-xmark"></i>
                                                            </div>
                                                            <h3 class="empty-state-title">No Patients Found</h3>
                                                            <p class="empty-state-text">
                                                                There are no patients registered between 
                                                                <?php echo date('F d, Y', strtotime($fdate)); ?> and 
                                                                <?php echo date('F d, Y', strtotime($tdate)); ?>
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
                    
                    <!-- Back Button Section -->
                    <div style="margin-top: 30px; text-align: center;">
                        <a href="between-dates-reports.php" class="btn-back-bottom">
                            <i class="fas fa-arrow-left"></i>
                            Back to Date Selection
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <?php include('include/footer.php'); ?>
        
        <!-- Settings -->
        <?php include('include/setting.php'); ?>
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