<?php
/**
 * Between Dates Reports Page
 * File: between-dates-reports.php
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
    <title>Between Dates Reports | Admin</title>
    
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
        
        /* Form Card */
        .form-card-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.7);
            transition: all 0.4s ease;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .form-card-glass:hover {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
        }
        
        .card-header-section {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .card-icon-badge {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            flex-shrink: 0;
        }
        
        .card-icon-badge i {
            color: #ffffff;
            font-size: 28px;
        }
        
        .card-header-content h2 {
            font-size: 26px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 8px 0;
            letter-spacing: -0.5px;
        }
        
        .card-header-content p {
            font-size: 14px;
            color: #64748b;
            margin: 0;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 28px;
        }
        
        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-group label i {
            color: #667eea;
            font-size: 16px;
        }
        
        .form-control {
            height: 52px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0 18px;
            font-size: 15px;
            color: #1e293b;
            transition: all 0.3s ease;
            background: #ffffff;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
            background: #ffffff;
        }
        
        .form-control:hover {
            border-color: #cbd5e1;
        }
        
        /* Date Input Specific */
        input[type="date"].form-control {
            appearance: none;
            -webkit-appearance: none;
            position: relative;
        }
        
        input[type="date"].form-control::-webkit-calendar-picker-indicator {
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.3s ease;
        }
        
        input[type="date"].form-control::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }
        
        /* Button Styles */
        .btn-submit {
            width: 100%;
            height: 56px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 14px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 35px;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        }
        
        .btn-submit:active {
            transform: translateY(0);
        }
        
        .btn-submit i {
            font-size: 18px;
        }
        
        /* Info Box */
        .info-box {
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
            border-left: 4px solid #667eea;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }
        
        .info-box i {
            color: #667eea;
            font-size: 22px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        
        .info-box-content {
            flex: 1;
        }
        
        .info-box-content h4 {
            font-size: 15px;
            font-weight: 700;
            color: #4338ca;
            margin: 0 0 6px 0;
        }
        
        .info-box-content p {
            font-size: 13px;
            color: #4f46e5;
            margin: 0;
            line-height: 1.6;
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
            
            .form-card-glass {
                padding: 28px 20px;
            }
            
            .card-header-section {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }
            
            .card-icon-badge {
                width: 56px;
                height: 56px;
            }
            
            .card-icon-badge i {
                font-size: 24px;
            }
        }
        
        /* Container Overrides */
        .container-fluid.container-fullw {
            background: transparent;
            padding: 0;
        }
        
        .panel {
            border: none;
            box-shadow: none;
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
                            <i class="fas fa-calendar-week"></i>
                            Between Dates Reports
                        </h1>
                        <p>Generate appointment reports for a specific date range</p>
                        <div class="breadcrumb-modern">
                            <span>Admin</span>
                            <i class="fas fa-chevron-right"></i>
                            <span>Reports</span>
                            <i class="fas fa-chevron-right"></i>
                            <span class="active">Between Dates</span>
                        </div>
                    </div>
                    
                    <!-- Form Section -->
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                
                                <div class="form-card-glass">
                                    <div class="card-header-section">
                                        <div class="card-icon-badge">
                                            <i class="fas fa-filter"></i>
                                        </div>
                                        <div class="card-header-content">
                                            <h2>Date Range Filter</h2>
                                            <p>Select start and end dates to generate your report</p>
                                        </div>
                                    </div>
                                    
                                    <div class="info-box">
                                        <i class="fas fa-info-circle"></i>
                                        <div class="info-box-content">
                                            <h4>How to use this report</h4>
                                            <p>Select a start date and end date to view all appointments scheduled within that date range. The report will include appointment details, patient information, and status.</p>
                                        </div>
                                    </div>
                                    
                                    <form role="form" method="post" action="betweendates-detailsreports.php">
                                        <div class="form-group">
                                            <label for="fromdate">
                                                <i class="fas fa-calendar-check"></i>
                                                From Date
                                            </label>
                                            <input 
                                                type="date" 
                                                class="form-control" 
                                                name="fromdate" 
                                                id="fromdate" 
                                                required
                                                placeholder="Select start date"
                                            >
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="todate">
                                                <i class="fas fa-calendar-xmark"></i>
                                                To Date
                                            </label>
                                            <input 
                                                type="date" 
                                                class="form-control" 
                                                name="todate" 
                                                id="todate" 
                                                required
                                                placeholder="Select end date"
                                            >
                                        </div>
                                        
                                        <button type="submit" name="submit" id="submit" class="btn-submit">
                                            <i class="fas fa-file-chart-line"></i>
                                            Generate Report
                                        </button>
                                    </form>
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
            
            // Set max date for "From Date" to today
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('fromdate').setAttribute('max', today);
            document.getElementById('todate').setAttribute('max', today);
            
            // Validate date range
            document.getElementById('fromdate').addEventListener('change', function() {
                var fromDate = this.value;
                document.getElementById('todate').setAttribute('min', fromDate);
            });
            
            document.getElementById('todate').addEventListener('change', function() {
                var toDate = this.value;
                var fromDate = document.getElementById('fromdate').value;
                
                if(fromDate && toDate < fromDate) {
                    alert('End date cannot be earlier than start date');
                    this.value = '';
                }
            });
        });
    </script>
</body>
</html>