<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {

    if(isset($_GET['cancel'])) {
        $appointmentId = $_GET['id'];
        // Using prepared statement for security
        $stmt = $con->prepare("UPDATE appointment SET doctorStatus='0' WHERE id = ?");
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();
        $stmt->close();
        $_SESSION['msg']="Appointment canceled !!";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor | Appointment History</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link rel="stylesheet" href="vendor/animate.css/animate.min.css">
    <link rel="stylesheet" href="vendor/perfect-scrollbar/perfect-scrollbar.min.css">
    <link rel="stylesheet" href="vendor/switchery/switchery.min.css">
    <link rel="stylesheet" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css">
    <link rel="stylesheet" href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color">

    <style>
        /* ============================================
           CSS VARIABLES - Modern Design System
        ============================================ */
        :root {
            --primary-blue: #2563eb;
            --primary-dark: #1e40af;
            --primary-light: #3b82f6;
            --light-blue-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-light: #64748b;
            --border-color: #e2e8f0;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 12px rgba(37, 99, 235, 0.1);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        /* ============================================
           GLOBAL STYLES
        ============================================ */
        * {
            font-family: 'Poppins', sans-serif !important;
        }

        body {
            background: var(--light-blue-bg);
            color: var(--text-primary);
        }

        .main-content {
            background: var(--light-blue-bg);
        }

        .wrap-content {
            padding: 30px 25px;
        }

        /* ============================================
           PAGE HEADER
        ============================================ */
        #page-title {
            background: transparent;
            padding: 0 0 30px 0;
            border: none;
            margin-bottom: 0;
        }

        #page-title .mainTitle {
            color: var(--primary-blue);
            font-size: 36px;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .breadcrumb {
            display: none;
        }

        /* ============================================
           MAIN CONTAINER
        ============================================ */
        .container-fluid.container-fullw.bg-white {
            background: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
        }

        /* ============================================
           SUCCESS MESSAGE
        ============================================ */
        .alert-message {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .alert-message i {
            font-size: 20px;
        }

        /* ============================================
           TABLE STYLES
        ============================================ */
        .table-container {
            overflow-x: auto;
            border-radius: 16px;
            border: 1px solid var(--border-color);
        }

        .table {
            margin: 0;
            background: white;
        }

        .table thead {
            background: var(--light-blue-bg);
        }

        .table thead th {
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-primary);
            padding: 18px 16px;
            border: none;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
        }

        .table tbody td {
            padding: 16px;
            vertical-align: middle;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ============================================
           STATUS BADGES
        ============================================ */
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .status-cancelled-patient {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-cancelled-doctor {
            background: #fef3c7;
            color: #92400e;
        }

        /* ============================================
           ACTION BUTTONS
        ============================================ */
        .btn-cancel {
            background: var(--danger);
            color: white;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
        }

        .btn-cancel:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-cancel:active {
            transform: translateY(0);
        }

        .text-cancelled {
            color: var(--text-light);
            font-weight: 600;
            font-size: 13px;
        }

        /* ============================================
           SERIAL NUMBER
        ============================================ */
        .serial-number {
            font-weight: 700;
            color: var(--text-primary);
        }

        /* ============================================
           PATIENT NAME
        ============================================ */
        .patient-name {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* ============================================
           RESPONSIVE DESIGN
        ============================================ */
        @media (max-width: 768px) {
            .wrap-content {
                padding: 20px 15px;
            }

            #page-title .mainTitle {
                font-size: 28px;
            }

            .container-fluid.container-fullw.bg-white {
                padding: 20px;
                border-radius: 16px;
            }

            .table thead th {
                font-size: 11px;
                padding: 14px 12px;
            }

            .table tbody td {
                font-size: 13px;
                padding: 12px;
            }

            .status-badge {
                font-size: 10px;
                padding: 5px 10px;
            }

            .btn-cancel {
                font-size: 12px;
                padding: 6px 14px;
            }
        }

        @media (max-width: 480px) {
            #page-title .mainTitle {
                font-size: 24px;
            }

            .container-fluid.container-fullw.bg-white {
                padding: 15px;
            }

            .table thead th,
            .table tbody td {
                font-size: 12px;
                padding: 10px 8px;
            }
        }

        /* ============================================
           EMPTY STATE
        ============================================ */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-light);
        }

        .empty-state i {
            font-size: 64px;
            color: var(--border-color);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-secondary);
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 14px;
            color: var(--text-light);
        }

        /* ============================================
           LOADING ANIMATION
        ============================================ */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table tbody tr {
            animation: fadeIn 0.3s ease;
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
                    
                    <!-- Page Title -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-12">
                                <h1 class="mainTitle">APPOINTMENT HISTORY</h1>
                            </div>
                        </div>
                    </section>

                    <!-- Main Content Card -->
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                
                                <!-- Success Message -->
                                <?php if(!empty($_SESSION['msg'])) { ?>
                                    <div class="alert-message">
                                        <i class="fa fa-check-circle"></i>
                                        <span><?php echo htmlentities($_SESSION['msg']); ?></span>
                                    </div>
                                    <?php $_SESSION['msg']=""; ?>
                                <?php } ?>

                                <!-- Appointments Table -->
                                <div class="table-container">
                                    <table class="table table-hover" id="sample-table-1">
                                        <thead>
                                            <tr>
                                                <th class="center">#</th>
                                                <th>Patient Name</th>
                                                <th>Specialization</th>
                                                <th>Consultancy Fee</th>
                                                <th>Appointment Date/Time</th>
                                                <th>Created Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
$doctorId = $_SESSION['id'];
$stmt = $con->prepare("SELECT users.fullName as fname, appointment.* FROM appointment JOIN users ON users.id=appointment.userId WHERE appointment.doctorId=?");
$stmt->bind_param("i", $doctorId);
$stmt->execute();
$result = $stmt->get_result();
$cnt = 1;

if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
?>
                                            <tr>
                                                <td class="center serial-number"><?php echo $cnt; ?></td>
                                                <td class="patient-name"><?php echo htmlentities($row['fname']); ?></td>
                                                <td><?php echo htmlentities($row['doctorSpecialization']); ?></td>
                                                <td>₱<?php echo number_format($row['consultancyFees'], 2); ?></td>
                                                <td>
                                                    <?php echo date('M d, Y', strtotime($row['appointmentDate'])); ?><br>
                                                    <small style="color: var(--text-light);"><?php echo date('h:i A', strtotime($row['appointmentTime'])); ?></small>
                                                </td>
                                                <td><?php echo date('M d, Y', strtotime($row['postingDate'])); ?></td>
                                                <td>
<?php 
if(($row['userStatus']==1) && ($row['doctorStatus']==1)) {
    echo '<span class="status-badge status-active">Active</span>';
}
if(($row['userStatus']==0) && ($row['doctorStatus']==1)) {
    echo '<span class="status-badge status-cancelled-patient">Cancelled by Patient</span>';
}
if(($row['userStatus']==1) && ($row['doctorStatus']==0)) {
    echo '<span class="status-badge status-cancelled-doctor">Cancelled by You</span>';
}
?>
                                                </td>
                                                <td>
<?php if(($row['userStatus']==1) && ($row['doctorStatus']==1)) { ?>
                                                    <a href="appointment-history.php?id=<?php echo $row['id']; ?>&cancel=update" 
                                                       onclick="return confirm('Are you sure you want to cancel this appointment?')" 
                                                       class="btn-cancel">
                                                        Cancel
                                                    </a>
<?php } else { ?>
                                                    <span class="text-cancelled">Cancelled</span>
<?php } ?>
                                                </td>
                                            </tr>
<?php 
        $cnt++;
    }
} else {
?>
                                            <tr>
                                                <td colspan="8">
                                                    <div class="empty-state">
                                                        <i class="fa fa-calendar-times-o"></i>
                                                        <h3>No Appointments Found</h3>
                                                        <p>You don't have any appointment history yet.</p>
                                                    </div>
                                                </td>
                                            </tr>
<?php
}
$stmt->close();
?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Settings -->
        <?php include('include/setting.php'); ?>
    </div>

    <!-- Vendor Scripts -->
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
    
    <!-- Custom Scripts -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/form-elements.js"></script>

    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();

            // Auto-hide success message after 5 seconds
            setTimeout(function() {
                $('.alert-message').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>
</html>
<?php } ?>