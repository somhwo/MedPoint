<?php
/**
 * Appointment History Page
 * File: appointment-history.php
 */
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Appointment History</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
        
        /* Modern Page Header */
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
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
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
        }
        
        .page-header-modern p {
            font-size: 16px;
            opacity: 0.95;
            margin: 0;
            position: relative;
            z-index: 1;
        }
        
        .breadcrumb-modern {
            background: rgba(255, 255, 255, 0.15);
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
        }
        
        .breadcrumb-modern span {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
        }
        
        .breadcrumb-modern .active {
            color: #ffffff;
            font-weight: 700;
        }
        
        .breadcrumb-modern i {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
        }
        
        /* Glass Table Card */
        .table-card-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.7);
            transition: all 0.4s ease;
        }
        
        .table-card-glass:hover {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
        }
        
        .card-header-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .card-header-left {
            display: flex;
            align-items: center;
            gap: 15px;
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
        }
        
        /* Stats Summary */
        .stats-summary {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .stat-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
        }
        
        .stat-badge.total {
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
            color: #667eea;
        }
        
        .stat-badge.active {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #059669;
        }
        
        .stat-badge.cancelled {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #dc2626;
        }
        
        /* Modern Table */
        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
        }
        
        .table-modern thead {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        .table-modern thead th {
            padding: 18px 12px;
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
            width: 50px;
            text-align: center;
        }
        
        .table-modern thead th:nth-child(2) {
            width: 12%;
        }
        
        .table-modern thead th:nth-child(3) {
            width: 12%;
        }
        
        .table-modern thead th:nth-child(4) {
            width: 13%;
        }
        
        .table-modern thead th:nth-child(5) {
            width: 8%;
        }
        
        .table-modern thead th:nth-child(6) {
            width: 13%;
        }
        
        .table-modern thead th:nth-child(7) {
            width: 11%;
        }
        
        .table-modern thead th:nth-child(8) {
            width: 13%;
        }
        
        .table-modern thead th:nth-child(9) {
            width: 13%;
        }
        
        .table-modern thead th:last-child {
            border-radius: 0 12px 0 0;
        }
        
        .table-modern tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .table-modern tbody tr:hover {
            background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
            transform: scale(1.002);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
        }
        
        .table-modern tbody td {
            padding: 18px 12px;
            font-size: 14px;
            color: #334155;
            vertical-align: middle;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .table-modern tbody td:first-child {
            text-align: center;
            width: 50px;
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
            text-align: center;
        }
        
        .cell-name {
            font-weight: 600;
            color: #0f172a;
            white-space: normal;
            word-wrap: break-word;
        }
        
        .cell-content {
            display: block;
            width: 100%;
            white-space: normal;
            word-wrap: break-word;
        }
        
        .cell-icon {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cell-icon i {
            color: #94a3b8;
            font-size: 16px;
            flex-shrink: 0;
        }
        
        .date-time-cell {
            white-space: nowrap;
        }
        
        .date-time-cell small {
            display: block;
            margin-top: 4px;
            color: #64748b;
            font-size: 11px;
        }
        
        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }
        
        .status-badge.active {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #059669;
        }
        
        .status-badge.cancelled-patient {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #dc2626;
        }
        
        .status-badge.cancelled-doctor {
            background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
            color: #c2410c;
        }
        
        /* Action Text */
        .action-text {
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }
        
        .action-text.no-action {
            color: #64748b;
        }
        
        .action-text.cancelled {
            color: #ef4444;
        }
        
        .action-text i {
            font-size: 12px;
        }
        
        /* Alert Message */
        .alert-message {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 25px;
            color: #92400e;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .empty-state-icon i {
            font-size: 48px;
            color: #94a3b8;
        }
        
        .empty-state-title {
            font-size: 20px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 10px;
        }
        
        .empty-state-text {
            font-size: 14px;
            color: #64748b;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .card-header-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }
            
            .stats-summary {
                width: 100%;
            }
        }
        
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
            }
            
            .table-wrapper {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .table-modern {
                min-width: 1200px;
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
                            <i class="fas fa-calendar-check"></i>
                            Appointment History
                        </h1>
                        <p>View and manage all patient appointments</p>
                        <div class="breadcrumb-modern">
                            <span>Admin</span>
                            <i class="fas fa-chevron-right"></i>
                            <span>Patients</span>
                            <i class="fas fa-chevron-right"></i>
                            <span class="active">Appointment History</span>
                        </div>
                    </div>
                    
                    <!-- Table Section -->
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                
                                <?php if(!empty($_SESSION['msg'])): ?>
                                <div class="alert-message">
                                    <i class="fas fa-info-circle"></i>
                                    <span><?php echo htmlentities($_SESSION['msg']); $_SESSION['msg'] = ""; ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <div class="table-card-glass">
                                    <div class="card-header-section">
                                        <div class="card-header-left">
                                            <div class="card-icon-badge">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                            <div>
                                                <h2 class="card-title-main">All Appointments</h2>
                                                <p class="card-subtitle">Complete appointment records</p>
                                            </div>
                                        </div>
                                        <div class="stats-summary">
                                            <?php 
                                            // Count only appointments that have valid doctor and user records (matching the main query)
                                            $total_query = mysqli_query($con, "
                                                SELECT COUNT(*) as total 
                                                FROM appointment 
                                                JOIN doctors ON doctors.id = appointment.doctorId 
                                                JOIN users ON users.id = appointment.userId
                                            ");
                                            $total_row = mysqli_fetch_assoc($total_query);
                                            $total = $total_row['total'];
                                            
                                            $active_query = mysqli_query($con, "
                                                SELECT COUNT(*) as active 
                                                FROM appointment 
                                                JOIN doctors ON doctors.id = appointment.doctorId 
                                                JOIN users ON users.id = appointment.userId
                                                WHERE appointment.userStatus=1 AND appointment.doctorStatus=1
                                            ");
                                            $active_row = mysqli_fetch_assoc($active_query);
                                            $active = $active_row['active'];
                                            
                                            $cancelled_query = mysqli_query($con, "
                                                SELECT COUNT(*) as cancelled 
                                                FROM appointment 
                                                JOIN doctors ON doctors.id = appointment.doctorId 
                                                JOIN users ON users.id = appointment.userId
                                                WHERE appointment.userStatus=0 OR appointment.doctorStatus=0
                                            ");
                                            $cancelled_row = mysqli_fetch_assoc($cancelled_query);
                                            $cancelled = $cancelled_row['cancelled'];
                                            ?>
                                            <div class="stat-badge total">
                                                <i class="fas fa-list"></i>
                                                Total: <?php echo $total; ?>
                                            </div>
                                            <div class="stat-badge active">
                                                <i class="fas fa-check-circle"></i>
                                                Active: <?php echo $active; ?>
                                            </div>
                                            <div class="stat-badge cancelled">
                                                <i class="fas fa-times-circle"></i>
                                                Cancelled: <?php echo $cancelled; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="table-wrapper">
                                        <table class="table-modern">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">#</th>
                                                    <th>DOCTOR</th>
                                                    <th>PATIENT</th>
                                                    <th>SPECIALIZATION</th>
                                                    <th>FEE</th>
                                                    <th>APPOINTMENT</th>
                                                    <th>CREATED</th>
                                                    <th>STATUS</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = mysqli_query($con, "
                                                    SELECT 
                                                        doctors.doctorName as docname,
                                                        users.fullName as pname,
                                                        appointment.*  
                                                    FROM appointment 
                                                    JOIN doctors ON doctors.id = appointment.doctorId 
                                                    JOIN users ON users.id = appointment.userId 
                                                    ORDER BY appointment.id DESC
                                                ");
                                                
                                                $cnt = 1;
                                                $has_records = false;
                                                
                                                while($row = mysqli_fetch_array($sql)) {
                                                    $has_records = true;
                                                ?>
                                                <tr>
                                                    <td class="cell-number"><?php echo $cnt; ?></td>
                                                    <td>
                                                        <div class="cell-name"><?php echo htmlentities($row['docname']); ?></div>
                                                    </td>
                                                    <td>
                                                        <div class="cell-name"><?php echo htmlentities($row['pname']); ?></div>
                                                    </td>
                                                    <td>
                                                        <div class="cell-content"><?php echo htmlentities($row['doctorSpecialization']); ?></div>
                                                    </td>
                                                    <td>
                                                        <div class="cell-content">$<?php echo number_format($row['consultancyFees'], 2); ?></div>
                                                    </td>
                                                    <td>
                                                        <div class="date-time-cell">
                                                            <div><?php echo date('M d, Y', strtotime($row['appointmentDate'])); ?></div>
                                                            <small><?php echo htmlentities($row['appointmentTime']); ?></small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="cell-content"><?php echo date('M d, Y', strtotime($row['postingDate'])); ?></div>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        if($row['userStatus'] == 1 && $row['doctorStatus'] == 1) {
                                                            echo '<span class="status-badge active"><i class="fas fa-check-circle"></i> Active</span>';
                                                        } elseif($row['userStatus'] == 0 && $row['doctorStatus'] == 1) {
                                                            echo '<span class="status-badge cancelled-patient"><i class="fas fa-user-xmark"></i> Cancel by Patient</span>';
                                                        } elseif($row['userStatus'] == 1 && $row['doctorStatus'] == 0) {
                                                            echo '<span class="status-badge cancelled-doctor"><i class="fas fa-user-doctor-slash"></i> Cancel by Doctor</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        if($row['userStatus'] == 1 && $row['doctorStatus'] == 1) {
                                                            echo '<span class="action-text no-action"><i class="fas fa-hourglass-half"></i> No Action Yet</span>';
                                                        } else {
                                                            echo '<span class="action-text cancelled"><i class="fas fa-ban"></i> Cancelled</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php 
                                                    $cnt++;
                                                }
                                                
                                                if(!$has_records) {
                                                ?>
                                                <tr>
                                                    <td colspan="9">
                                                        <div class="empty-state">
                                                            <div class="empty-state-icon">
                                                                <i class="fas fa-calendar-xmark"></i>
                                                            </div>
                                                            <h3 class="empty-state-title">No Appointments Found</h3>
                                                            <p class="empty-state-text">There are no appointment records to display at this time.</p>
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