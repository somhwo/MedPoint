<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id'])==0) {
    header('location:logout.php');
    exit();
} else {

    $docid = $_SESSION['id'];

    // 1. Get total number of patients associated with this doctor
    $query_patients = $con->prepare("SELECT COUNT(ID) FROM tblpatient WHERE Docid = ?");
    $query_patients->bind_param("i", $docid);
    $query_patients->execute();
    $query_patients->bind_result($totalPatients);
    $query_patients->fetch();
    $query_patients->close();

    // 2. Get total number of active appointments
    $query_appointments = $con->prepare("SELECT COUNT(ID) FROM appointment WHERE doctorId = ? AND doctorStatus = '1' AND userStatus = '1'");
    $query_appointments->bind_param("i", $docid);
    $query_appointments->execute();
    $query_appointments->bind_result($activeAppointments);
    $query_appointments->fetch();
    $query_appointments->close();

    // 3. Get total number of new appointments today
    $query_new_appointments = $con->prepare("SELECT COUNT(ID) FROM appointment WHERE doctorId = ? AND doctorStatus = '1' AND userStatus = '1' AND DATE(postingDate) = CURDATE()");
    $query_new_appointments->bind_param("i", $docid);
    $query_new_appointments->execute();
    $query_new_appointments->bind_result($newAppointmentsToday);
    $query_new_appointments->fetch();
    $query_new_appointments->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | Dashboard</title>
        
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
        <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
        
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/plugins.css">
        <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />

        <style>
            /* Modern Dashboard - Exact Match to Admin Design */
            :root {
                --primary-blue: #2563eb;
                --primary-green: #10b981;
                --primary-purple: #8b5cf6;
                --light-bg: #f8fafc;
                --card-bg: #ffffff;
                --text-primary: #1e293b;
                --text-secondary: #64748b;
            }

            * {
                font-family: 'Poppins', sans-serif !important;
            }

            body {
                background: var(--light-bg);
            }

            .main-content, .app-content {
                background: var(--light-bg);
            }

            .wrap-content {
                padding: 30px 25px;
            }
            
            /* Page Title */
            #page-title {
                background: transparent;
                padding: 0 0 30px 0;
                border: none;
                margin-bottom: 20px;
            }

            .mainTitle {
                color: #2563eb;
                font-size: 36px;
                font-weight: 700;
                margin: 0;
                letter-spacing: -0.5px;
                text-transform: uppercase;
            }

            .breadcrumb {
                display: none;
            }

            /* Modern Card - Matching Admin Exactly */
            .stat-card {
                background: white;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                height: 100%;
            }

            .stat-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
            }

            /* Card Header with Gradient Background */
            .card-header-gradient {
                padding: 40px 30px;
                text-align: center;
                position: relative;
                background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
            }

            /* Decorative Pattern Overlay */
            .card-header-gradient::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image: 
                    linear-gradient(45deg, rgba(255,255,255,0.1) 25%, transparent 25%),
                    linear-gradient(-45deg, rgba(255,255,255,0.1) 25%, transparent 25%),
                    linear-gradient(45deg, transparent 75%, rgba(255,255,255,0.1) 75%),
                    linear-gradient(-45deg, transparent 75%, rgba(255,255,255,0.1) 75%);
                background-size: 60px 60px;
                background-position: 0 0, 0 30px, 30px -30px, -30px 0px;
                opacity: 0.5;
            }

            .card-icon-box {
                width: 80px;
                height: 80px;
                background: rgba(255, 255, 255, 0.25);
                border-radius: 16px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto;
                backdrop-filter: blur(10px);
                position: relative;
                z-index: 1;
            }

            .card-icon-box i {
                font-size: 36px;
                color: white;
            }

            .card-title-top {
                font-size: 16px;
                font-weight: 700;
                color: white;
                text-transform: uppercase;
                margin-top: 20px;
                letter-spacing: 1px;
                position: relative;
                z-index: 1;
            }

            /* Card Body */
            .card-body-stats {
                padding: 30px;
                background: white;
            }

            .status-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 18px;
                border-radius: 25px;
                font-size: 12px;
                font-weight: 600;
                color: white;
                margin-bottom: 20px;
            }

            .stat-number {
                font-size: 56px;
                font-weight: 700;
                color: var(--text-primary);
                line-height: 1;
                margin-bottom: 15px;
            }

            .stat-description {
                font-size: 14px;
                color: var(--text-secondary);
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 20px;
            }

            .stat-description i {
                font-size: 14px;
            }

            /* Progress Bar */
            .stat-progress {
                height: 8px;
                background: #f1f5f9;
                border-radius: 10px;
                overflow: hidden;
                margin-bottom: 25px;
            }

            .stat-progress-bar {
                height: 100%;
                border-radius: 10px;
                transition: width 0.8s ease;
            }

            /* Card Action Button */
            .card-action-btn {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 14px 24px;
                background: rgba(37, 99, 235, 0.08);
                color: var(--gradient-start);
                font-weight: 600;
                font-size: 14px;
                text-decoration: none;
                border-radius: 12px;
                transition: all 0.3s ease;
                border: 2px solid transparent;
            }

            .card-action-btn:hover {
                background: rgba(37, 99, 235, 0.12);
                transform: translateX(4px);
                text-decoration: none;
                color: var(--gradient-start);
            }

            .card-action-btn i {
                font-size: 16px;
            }

            /* Color Schemes */
            .card-blue {
                --gradient-start: #3b82f6;
                --gradient-end: #2563eb;
            }

            .card-green {
                --gradient-start: #10b981;
                --gradient-end: #059669;
            }

            .card-purple {
                --gradient-start: #8b5cf6;
                --gradient-end: #7c3aed;
            }

            .card-orange {
                --gradient-start: #f59e0b;
                --gradient-end: #d97706;
            }

            .card-indigo {
                --gradient-start: #6366f1;
                --gradient-end: #4f46e5;
            }

            /* Badge Colors */
            .badge-blue {
                background: #3b82f6;
            }

            .badge-green {
                background: #10b981;
            }

            .badge-purple {
                background: #8b5cf6;
            }

            .badge-orange {
                background: #f59e0b;
            }

            .badge-indigo {
                background: #6366f1;
            }

            /* Button Colors */
            .card-green .card-action-btn {
                background: rgba(16, 185, 129, 0.08);
                color: #10b981;
            }
            .card-green .card-action-btn:hover {
                background: rgba(16, 185, 129, 0.12);
                color: #059669;
            }

            .card-purple .card-action-btn {
                background: rgba(139, 92, 246, 0.08);
                color: #8b5cf6;
            }
            .card-purple .card-action-btn:hover {
                background: rgba(139, 92, 246, 0.12);
                color: #7c3aed;
            }

            .card-orange .card-action-btn {
                background: rgba(245, 158, 11, 0.08);
                color: #f59e0b;
            }
            .card-orange .card-action-btn:hover {
                background: rgba(245, 158, 11, 0.12);
                color: #d97706;
            }

            .card-indigo .card-action-btn {
                background: rgba(99, 102, 241, 0.08);
                color: #6366f1;
            }
            .card-indigo .card-action-btn:hover {
                background: rgba(99, 102, 241, 0.12);
                color: #4f46e5;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .mainTitle {
                    font-size: 28px;
					color: #2563eb;
                }
                
                .stat-number {
                    font-size: 42px;
                }
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
                        <section id="page-title">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h1 class="mainTitle">DOCTOR DASHBOARD</h1>
                                </div>
                            </div>
                        </section>
                        
                        <div class="container-fluid container-fullw">
                            <div class="row">
                                
                                <!-- Total Patients Card -->
                                <div class="col-sm-4 col-md-4 mb-4">
                                    <div class="stat-card card-green">
                                        <div class="card-header-gradient">
                                            <div class="card-icon-box">
                                                <i class="fa fa-users"></i>
                                            </div>
                                            <div class="card-title-top">TOTAL PATIENTS</div>
                                        </div>
                                        <div class="card-body-stats">
                                            <div class="status-badge badge-green">
                                                <i class="fa fa-check-circle"></i> Active
                                            </div>
                                            <div class="stat-number"><?php echo htmlentities($totalPatients); ?></div>
                                            <div class="stat-description">
                                                <i class="fa fa-user-plus"></i>
                                                Registered patients in system
                                            </div>
                                            <div class="stat-progress">
                                                <div class="stat-progress-bar" style="width: 100%; background: linear-gradient(90deg, #10b981 0%, #059669 100%);"></div>
                                            </div>
                                            <a href="manage-patient.php" class="card-action-btn">
                                                Manage Patients <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Active Appointments Card -->
                                <div class="col-sm-4 col-md-4 mb-4">
                                    <div class="stat-card card-blue">
                                        <div class="card-header-gradient">
                                            <div class="card-icon-box">
                                                <i class="fa fa-calendar-check-o"></i>
                                            </div>
                                            <div class="card-title-top">ACTIVE APPOINTMENTS</div>
                                        </div>
                                        <div class="card-body-stats">
                                            <div class="status-badge badge-blue">
                                                <i class="fa fa-check-circle"></i> Active
                                            </div>
                                            <div class="stat-number"><?php echo htmlentities($activeAppointments); ?></div>
                                            <div class="stat-description">
                                                <i class="fa fa-clock-o"></i>
                                                Confirmed appointments
                                            </div>
                                            <div class="stat-progress">
                                                <div class="stat-progress-bar" style="width: 85%; background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);"></div>
                                            </div>
                                            <a href="appointment-history.php" class="card-action-btn">
                                                View All <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Appointments Today Card -->
                                <div class="col-sm-4 col-md-4 mb-4">
                                    <div class="stat-card card-purple">
                                        <div class="card-header-gradient">
                                            <div class="card-icon-box">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <div class="card-title-top">APPOINTMENTS</div>
                                        </div>
                                        <div class="card-body-stats">
                                            <div class="status-badge badge-purple">
                                                <i class="fa fa-calendar"></i> Today
                                            </div>
                                            <div class="stat-number"><?php echo htmlentities($newAppointmentsToday); ?></div>
                                            <div class="stat-description">
                                                <i class="fa fa-calendar-check-o"></i>
                                                Scheduled appointments
                                            </div>
                                            <div class="stat-progress">
                                                <div class="stat-progress-bar" style="width: 75%; background: linear-gradient(90deg, #8b5cf6 0%, #7c3aed 100%);"></div>
                                            </div>
                                            <a href="appointment-history.php" class="card-action-btn">
                                                View All <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- Second Row -->
                        <div class="container-fluid container-fullw" style="margin-top: 20px;">
                            <div class="row">
                                
                                <!-- Profile Card -->
                                <div class="col-sm-6 col-md-6 mb-4">
                                    <div class="stat-card card-orange">
                                        <div class="card-header-gradient">
                                            <div class="card-icon-box">
                                                <i class="fa fa-user-circle-o"></i>
                                            </div>
                                            <div class="card-title-top">MY PROFILE</div>
                                        </div>
                                        <div class="card-body-stats">
                                            <div class="status-badge badge-orange">
                                                <i class="fa fa-pencil"></i> Edit
                                            </div>
                                            <div class="stat-number" style="font-size: 36px;">Update Details</div>
                                            <div class="stat-description">
                                                <i class="fa fa-info-circle"></i>
                                                Manage your account information
                                            </div>
                                            <div class="stat-progress">
                                                <div class="stat-progress-bar" style="width: 100%; background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);"></div>
                                            </div>
                                            <a href="edit-profile.php" class="card-action-btn">
                                                Edit Account Settings <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Security Card -->
                                <div class="col-sm-6 col-md-6 mb-4">
                                    <div class="stat-card card-indigo">
                                        <div class="card-header-gradient">
                                            <div class="card-icon-box">
                                                <i class="fa fa-key"></i>
                                            </div>
                                            <div class="card-title-top">SECURITY</div>
                                        </div>
                                        <div class="card-body-stats">
                                            <div class="status-badge badge-indigo">
                                                <i class="fa fa-lock"></i> Secure
                                            </div>
                                            <div class="stat-number" style="font-size: 36px;">Change Password</div>
                                            <div class="stat-description">
                                                <i class="fa fa-shield"></i>
                                                Update your security credentials
                                            </div>
                                            <div class="stat-progress">
                                                <div class="stat-progress-bar" style="width: 100%; background: linear-gradient(90deg, #6366f1 0%, #4f46e5 100%);"></div>
                                            </div>
                                            <a href="change-password.php" class="card-action-btn">
                                                Update Security <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <?php include('include/setting.php');?>
        </div>
        
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="vendor/modernizr/modernizr.js"></script>
        <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
        <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="vendor/switchery/switchery.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script>
            jQuery(document).ready(function() {
                Main.init();
            });
        </script>
    </body>
</html>
<?php } ?>