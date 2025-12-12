<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {
    $docid = $_SESSION['id'];
    
    // Handle form submission for adding new patient
    if(isset($_POST['add_patient'])) {
        $patientName = $_POST['patient_name'];
        $patientEmail = $_POST['patient_email'];
        $patientContno = $_POST['patient_contact'];
        $patientAdd = $_POST['patient_address'];
        $patientGender = $_POST['patient_gender'];
        $patientAge = $_POST['patient_age'];
        $patientMedhis = $_POST['patient_medhis'];
        
        // Validate required fields
        if(!empty($patientName) && !empty($patientEmail) && !empty($patientContno)) {
            $query = mysqli_query($con, "INSERT INTO tblpatient(PatientName, PatientEmail, PatientContno, PatientAdd, PatientGender, PatientAge, PatientMedhis, Docid, CreationDate) 
                                        VALUES('$patientName', '$patientEmail', '$patientContno', '$patientAdd', '$patientGender', '$patientAge', '$patientMedhis', '$docid', NOW())");
            
            if($query) {
                $success_msg = "Patient added successfully!";
                echo "<script>alert('Patient added successfully!');</script>";
                echo "<script>window.location.href ='manage-patient.php'</script>";
            } else {
                $error_msg = "Error adding patient. Please try again.";
            }
        } else {
            $error_msg = "Please fill in all required fields.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor | Manage Patients</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
    <link href="vendor/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet" media="screen">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    
    <style>
        :root {
            --primary-blue: #2563eb;
            --secondary-blue: #1d4ed8;
            --light-blue: #3b82f6;
            --dark-blue: #1e40af;
            --background-blue: #eff6ff;
            --light-bg: #f8fafc;
            --border-blue: #dbeafe;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
            --radius: 10px;
        }
        
        * {
            font-family: 'Poppins', sans-serif !important;
        }
        
        body {
            background: var(--background-blue);
            color: var(--text-dark);
        }
        
        .main-content {
            background: transparent;
            min-height: calc(100vh - 70px);
        }
        
        .wrap-content {
            padding: 20px 30px;
        }
        
        /* Page Header */
        .page-header {
            background: white;
            border-radius: var(--radius);
            padding: 25px 30px;
            margin-bottom: 25px;
            box-shadow: var(--shadow);
            border-left: 5px solid var(--primary-blue);
        }
        
        .page-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .page-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-blue);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .page-title h1 i {
            background: var(--primary-blue);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }
        
        .page-stats {
            display: flex;
            gap: 20px;
        }
        
        .stat-badge {
            background: var(--light-bg);
            padding: 8px 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
        }
        
        .stat-badge i {
            color: var(--primary-blue);
        }
        
        .breadcrumb {
            background: var(--light-bg);
            padding: 10px 15px;
            border-radius: 8px;
            margin: 0;
            display: inline-flex;
        }
        
        .breadcrumb-item {
            color: var(--text-gray);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .breadcrumb-item.active {
            color: var(--primary-blue);
            font-weight: 600;
        }
        
        /* Main Card */
        .main-card {
            background: white;
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-blue);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-blue);
        }
        
        .card-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .card-title i {
            color: var(--primary-blue);
            font-size: 22px;
        }
        
        .card-title h4 {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }
        
        /* Search and Filter */
        .table-controls {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .search-box {
            position: relative;
            flex: 1;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
        }
        
        .search-input {
            width: 100%;
            height: 45px;
            padding: 0 15px 0 45px;
            border: 2px solid var(--border-blue);
            border-radius: 8px;
            font-size: 14px;
            color: var(--text-dark);
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            border-color: var(--primary-blue);
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .filter-select {
            height: 45px;
            border: 2px solid var(--border-blue);
            border-radius: 8px;
            padding: 0 15px;
            font-size: 14px;
            color: var(--text-dark);
            background: white;
            min-width: 150px;
        }
        
        /* Table Styles */
        .table-container {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--border-blue);
        }
        
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        
        .custom-table thead {
            background: var(--light-bg);
        }
        
        .custom-table th {
            padding: 16px 20px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            text-align: left;
            border-bottom: 2px solid var(--border-blue);
        }
        
        .custom-table tbody tr {
            border-bottom: 1px solid var(--border-blue);
            transition: background 0.3s ease;
        }
        
        .custom-table tbody tr:hover {
            background: var(--background-blue);
        }
        
        .custom-table td {
            padding: 16px 20px;
            font-size: 14px;
            color: var(--text-dark);
            vertical-align: middle;
        }
        
        .patient-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .patient-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }
        
        .patient-name {
            font-weight: 500;
            color: var(--text-dark);
        }
        
        .badge {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-male {
            background: #dbeafe;
            color: var(--primary-blue);
        }
        
        .badge-female {
            background: #fce7f3;
            color: #db2777;
        }
        
        /* Action Buttons */
        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-edit {
            background: #dbeafe;
            color: var(--primary-blue);
            border: 1px solid #bfdbfe;
        }
        
        .btn-edit:hover {
            background: #bfdbfe;
            color: var(--secondary-blue);
        }
        
        .btn-view {
            background: #fef3c7;
            color: #d97706;
            border: 1px solid #fde68a;
        }
        
        .btn-view:hover {
            background: #fde68a;
            color: #b45309;
        }
        
        /* Add Patient Button */
        .btn-add-patient {
            background: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        
        .btn-add-patient:hover {
            background: var(--secondary-blue);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state i {
            font-size: 60px;
            color: var(--border-blue);
            margin-bottom: 20px;
        }
        
        .empty-state h5 {
            font-size: 18px;
            color: var(--text-gray);
            margin-bottom: 10px;
        }
        
        .empty-state p {
            color: var(--text-gray);
            font-size: 14px;
            margin: 0 0 20px 0;
        }
        
        /* Table Footer */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border-blue);
            font-size: 14px;
            color: var(--text-gray);
        }
        
        /* Export Buttons */
        .export-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-export {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            background: white;
            border: 1px solid var(--border-blue);
            color: var(--text-gray);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-export:hover {
            background: var(--light-bg);
            color: var(--primary-blue);
        }
        
        /* Modal Styles */
        .modal-content {
            border-radius: var(--radius);
            border: none;
            box-shadow: var(--shadow);
        }
        
        .modal-header {
            background: var(--primary-blue);
            color: white;
            border-radius: var(--radius) var(--radius) 0 0;
            padding: 20px 25px;
            border-bottom: none;
        }
        
        .modal-header .close {
            color: white;
            opacity: 0.8;
            text-shadow: none;
        }
        
        .modal-header .close:hover {
            opacity: 1;
        }
        
        .modal-title {
            font-size: 18px;
            font-weight: 600;
        }
        
        .modal-body {
            padding: 25px;
        }
        
        .modal-footer {
            padding: 20px 25px;
            border-top: 1px solid var(--border-blue);
        }
        
        /* Form Styles in Modal */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }
        
        .form-label i {
            color: var(--primary-blue);
            font-size: 15px;
            width: 20px;
        }
        
        .form-control {
            height: 45px;
            border: 2px solid var(--border-blue);
            border-radius: 8px;
            padding: 0 15px;
            font-size: 14px;
            color: var(--text-dark);
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }
        
        textarea.form-control {
            height: 100px;
            padding: 12px 15px;
            resize: vertical;
        }
        
        .required::after {
            content: " *";
            color: var(--danger);
        }
        
        /* Alert Messages */
        .alert-message {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }
        
        .alert-success {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        
        .alert-success i {
            color: var(--success);
        }
        
        .alert-danger {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        
        .alert-danger i {
            color: var(--danger);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .wrap-content {
                padding: 15px;
            }
            
            .page-header {
                padding: 20px;
            }
            
            .page-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .page-stats {
                width: 100%;
                justify-content: space-between;
            }
            
            .table-controls {
                flex-direction: column;
            }
            
            .search-box, .filter-select {
                width: 100%;
            }
            
            .main-card {
                padding: 20px;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .table-footer {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .modal-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <?php include('include/sidebar.php'); ?>
        
        <div class="app-content">
            <?php include('include/header.php'); ?>
            
            <div class="main-content">
                <div class="wrap-content container">
                    
                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="page-title">
                            <h1>
                                <i class="fas fa-users"></i>
                                Manage Patients
                            </h1>
                            <div class="page-stats">
                                <?php
                                $total_patients = mysqli_query($con, "SELECT COUNT(*) as total FROM tblpatient WHERE Docid='$docid'");
                                $total_row = mysqli_fetch_assoc($total_patients);
                                $total = $total_row['total'];
                                
                                $today_patients = mysqli_query($con, "SELECT COUNT(*) as today FROM tblpatient WHERE Docid='$docid' AND DATE(CreationDate) = CURDATE()");
                                $today_row = mysqli_fetch_assoc($today_patients);
                                $today = $today_row['today'];
                                ?>
                                <div class="stat-badge">
                                    <i class="fas fa-user-injured"></i>
                                    <span>Total: <?php echo $total; ?> Patients</span>
                                </div>
                                <div class="stat-badge">
                                    <i class="fas fa-calendar-day"></i>
                                    <span>Today: <?php echo $today; ?> New</span>
                                </div>
                            </div>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Dashboard
                                </li>
                                <li class="breadcrumb-item active">
                                    <i class="fas fa-user-injured"></i>
                                    Manage Patients
                                </li>
                            </ol>
                        </nav>
                    </div>
                    
                    <!-- Display Messages -->
                    <?php if(isset($success_msg)): ?>
                    <div class="alert-message alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $success_msg; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(isset($error_msg)): ?>
                    <div class="alert-message alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $error_msg; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Main Card -->
                    <div class="main-card">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-list-ul"></i>
                                <h4>Patient List</h4>
                            </div>
                            <div class="export-buttons">
                                <button class="btn-export" onclick="window.print()">
                                    <i class="fas fa-print"></i>
                                    Print
                                </button>
                                <button class="btn-export" onclick="exportToExcel()">
                                    <i class="fas fa-file-excel"></i>
                                    Export
                                </button>
                            </div>
                        </div>
                        
                        <!-- Search and Filter -->
                        <div class="table-controls">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" class="search-input" placeholder="Search patients by name or contact...">
                            </div>
                            <select class="filter-select">
                                <option value="">All Patients</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                            </select>
                        </div>
                        
                        <!-- Table Container -->
                        <div class="table-container">
                            <?php
                            $sql = mysqli_query($con, "SELECT * FROM tblpatient WHERE Docid='$docid' ORDER BY CreationDate DESC");
                            $cnt = mysqli_num_rows($sql);
                            
                            if($cnt > 0) {
                            ?>
                            <table class="custom-table" id="patientsTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Patient Information</th>
                                        <th>Contact</th>
                                        <th>Gender</th>
                                        <th>Registration Date</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = 1;
                                    while($row = mysqli_fetch_array($sql)) {
                                        $initial = strtoupper(substr($row['PatientName'], 0, 1));
                                        $gender_class = ($row['PatientGender'] == 'Male') ? 'badge-male' : 'badge-female';
                                    ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td>
                                            <div class="patient-info">
                                                <div class="patient-avatar">
                                                    <?php echo $initial; ?>
                                                </div>
                                                <div>
                                                    <div class="patient-name"><?php echo htmlentities($row['PatientName']); ?></div>
                                                    <div style="font-size: 12px; color: var(--text-gray);">ID: P<?php echo str_pad($row['ID'], 4, '0', STR_PAD_LEFT); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo htmlentities($row['PatientContno']); ?></td>
                                        <td>
                                            <span class="badge <?php echo $gender_class; ?>">
                                                <i class="fas fa-<?php echo ($row['PatientGender'] == 'Male') ? 'mars' : 'venus'; ?>"></i>
                                                <?php echo htmlentities($row['PatientGender']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div style="font-size: 13px;">
                                                <?php echo date('M d, Y', strtotime($row['CreationDate'])); ?>
                                            </div>
                                            <div style="font-size: 12px; color: var(--text-gray);">
                                                <?php echo date('h:i A', strtotime($row['CreationDate'])); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($row['UpdationDate']) { ?>
                                            <div style="font-size: 13px;">
                                                <?php echo date('M d, Y', strtotime($row['UpdationDate'])); ?>
                                            </div>
                                            <div style="font-size: 12px; color: var(--text-gray);">
                                                <?php echo date('h:i A', strtotime($row['UpdationDate'])); ?>
                                            </div>
                                            <?php } else { ?>
                                            <span style="color: var(--text-gray); font-size: 13px;">Not updated</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 8px;">
                                                <a href="edit-patient.php?editid=<?php echo $row['ID']; ?>" class="btn-action btn-edit" target="_blank">
                                                    <i class="fas fa-edit"></i>
                                                    Edit
                                                </a>
                                                <a href="view-patient.php?viewid=<?php echo $row['ID']; ?>" class="btn-action btn-view" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                    View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php 
                                    $counter++;
                                    } ?>
                                </tbody>
                            </table>
                            <?php } else { ?>
                            <div class="empty-state">
                                <i class="fas fa-user-injured"></i>
                                <h5>No Patients Found</h5>
                                <p>You haven't added any patients yet. Start by adding your first patient.</p>
                            </div>
                            <?php } ?>
                        </div>
                        
                        <!-- Table Footer -->
                        <div class="table-footer">
                            <div>
                                Showing <?php echo min($counter-1, 10); ?> of <?php echo $cnt; ?> patients
                            </div>
                            <div>
                                <button class="btn-add-patient" data-toggle="modal" data-target="#addPatientModal">
                                    <i class="fas fa-user-plus"></i>
                                    Add New Patient
                                </button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <!-- Add Patient Modal -->
        <div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="addPatientModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPatientModalLabel">
                            <i class="fas fa-user-plus"></i>
                            Add New Patient
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" name="addPatientForm" id="addPatientForm">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label required">
                                            <i class="fas fa-user"></i>
                                            Patient Name
                                        </label>
                                        <input type="text" 
                                               name="patient_name" 
                                               class="form-control" 
                                               placeholder="Enter full name"
                                               required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label required">
                                            <i class="fas fa-envelope"></i>
                                            Email Address
                                        </label>
                                        <input type="email" 
                                               name="patient_email" 
                                               class="form-control" 
                                               placeholder="Enter email address"
                                               required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label required">
                                            <i class="fas fa-phone"></i>
                                            Contact Number
                                        </label>
                                        <input type="text" 
                                               name="patient_contact" 
                                               class="form-control" 
                                               placeholder="Enter phone number"
                                               required
                                               maxlength="15">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-home"></i>
                                            Address
                                        </label>
                                        <input type="text" 
                                               name="patient_address" 
                                               class="form-control" 
                                               placeholder="Enter address">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-venus-mars"></i>
                                            Gender
                                        </label>
                                        <select name="patient_gender" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-birthday-cake"></i>
                                            Age
                                        </label>
                                        <input type="number" 
                                               name="patient_age" 
                                               class="form-control" 
                                               placeholder="Enter age"
                                               min="0"
                                               max="150">
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-file-medical"></i>
                                            Medical History (if any)
                                        </label>
                                        <textarea name="patient_medhis" 
                                                  class="form-control" 
                                                  placeholder="Enter any existing medical conditions or history..."
                                                  rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fas fa-times"></i>
                                Cancel
                            </button>
                            <button type="submit" name="add_patient" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Save Patient
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Settings -->
        <?php include('include/setting.php'); ?>
    </div>
    
    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/media/js/dataTables.bootstrap.js"></script>
    <script src="assets/js/main.js"></script>
    
    <script>
        $(document).ready(function() {
            Main.init();
            
            // Initialize DataTable
            $('#patientsTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[0, 'asc']],
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search patients..."
                },
                "dom": '<"top"f>rt<"bottom"lip><"clear">'
            });
            
            // Add search box styling
            $('.dataTables_filter input').addClass('search-input');
            $('.dataTables_filter label').contents().filter(function() {
                return this.nodeType == 3;
            }).remove();
            
            // Filter functionality
            $('.filter-select').on('change', function() {
                var filter = $(this).val();
                var table = $('#patientsTable').DataTable();
                
                if(filter === 'today') {
                    table.search('').draw();
                    // Custom filtering for today's date
                    $.fn.dataTable.ext.search.push(
                        function(settings, data, dataIndex) {
                            var date = new Date(data[4]);
                            var today = new Date();
                            return date.getDate() === today.getDate() &&
                                   date.getMonth() === today.getMonth() &&
                                   date.getFullYear() === today.getFullYear();
                        }
                    );
                } else if(filter) {
                    table.search(filter).draw();
                } else {
                    $.fn.dataTable.ext.search.pop();
                    table.search('').draw();
                }
                
                updateTableCount();
            });
            
            // Search functionality
            $('.search-input').on('keyup', function() {
                var search = $(this).val();
                $('#patientsTable').DataTable().search(search).draw();
                updateTableCount();
            });
            
            function updateTableCount() {
                var visibleRows = $('#patientsTable tbody tr:visible').length;
                $('.table-footer div:first-child').text('Showing ' + visibleRows + ' of ' + <?php echo $cnt; ?> + ' patients');
            }
            
            // Form validation for add patient
            $('#addPatientForm').on('submit', function(e) {
                var patientName = $('input[name="patient_name"]').val().trim();
                var patientEmail = $('input[name="patient_email"]').val().trim();
                var patientContact = $('input[name="patient_contact"]').val().trim();
                
                if(!patientName) {
                    e.preventDefault();
                    alert('Please enter patient name');
                    $('input[name="patient_name"]').focus();
                    return false;
                }
                
                if(!patientEmail) {
                    e.preventDefault();
                    alert('Please enter email address');
                    $('input[name="patient_email"]').focus();
                    return false;
                }
                
                if(!patientContact) {
                    e.preventDefault();
                    alert('Please enter contact number');
                    $('input[name="patient_contact"]').focus();
                    return false;
                }
                
                // Email validation
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if(!emailRegex.test(patientEmail)) {
                    e.preventDefault();
                    alert('Please enter a valid email address');
                    $('input[name="patient_email"]').focus();
                    return false;
                }
                
                // Show loading state
                var submitBtn = $(this).find('button[name="add_patient"]');
                var originalText = submitBtn.html();
                submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Saving...');
                submitBtn.prop('disabled', true);
                
                // Re-enable after 3 seconds if still on page (fallback)
                setTimeout(function() {
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                }, 3000);
                
                return true;
            });
            
            // Contact number formatting
            $('input[name="patient_contact"]').on('input', function() {
                this.value = this.value.replace(/\D/g, '');
            });
            
            // Auto-focus on modal open
            $('#addPatientModal').on('shown.bs.modal', function () {
                $('input[name="patient_name"]').focus();
            });
            
            // Export to Excel function
            window.exportToExcel = function() {
                alert('Export functionality would export data to Excel format');
                // In a real application, you would implement actual Excel export here
            };
            
            // Clear form when modal is closed
            $('#addPatientModal').on('hidden.bs.modal', function () {
                $('#addPatientForm')[0].reset();
            });
        });
    </script>
</body>
</html>
<?php } ?>