<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {
    if(isset($_POST['submit'])) {
        $vid = $_GET['viewid'];
        $bp = $_POST['bp'];
        $bs = $_POST['bs'];
        $weight = $_POST['weight'];
        $temp = $_POST['temp'];
        $pres = $_POST['pres'];
        
        $query = mysqli_query($con, "INSERT INTO tblmedicalhistory(PatientID, BloodPressure, BloodSugar, Weight, Temperature, MedicalPres) VALUES('$vid','$bp','$bs','$weight','$temp','$pres')");
        
        if($query) {
            echo '<script>alert("Medical history has been added.")</script>';
            echo "<script>window.location.href ='manage-patient.php'</script>";
        } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor | Patient Medical History</title>
    
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
        
        /* Simple Page Header */
        .page-header-simple {
            margin-bottom: 30px;
        }
        
        .page-title-main {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 5px;
        }
        
        .page-title-main h1 {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-blue);
            margin: 0;
        }
        
        .page-subtitle {
            color: var(--text-gray);
            font-size: 16px;
            margin: 0;
            padding-left: 45px;
        }
        
        /* Simple Section Header */
        .section-header-simple {
            margin-bottom: 25px;
        }
        
        .section-header-simple h2 {
            font-size: 22px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 15px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .section-header-simple h2 i {
            color: var(--primary-blue);
            font-size: 24px;
        }
        
        /* Patient Info Card */
        .patient-info-card {
            background: white;
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            border: 1px solid var(--border-blue);
        }
        
        /* Patient Details Grid */
        .patient-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .detail-item {
            background: var(--light-bg);
            border-radius: var(--radius);
            padding: 20px;
            border: 1px solid var(--border-blue);
        }
        
        .detail-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-gray);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .detail-label i {
            color: var(--primary-blue);
            font-size: 14px;
        }
        
        .detail-value {
            font-size: 16px;
            font-weight: 500;
            color: var(--text-dark);
            margin: 0;
        }
        
        /* Medical History Card */
        .medical-history-card {
            background: white;
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            border: 1px solid var(--border-blue);
        }
        
        .history-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
        }
        
        /* Table Styles */
        .table-container {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--border-blue);
        }
        
        .medical-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        
        .medical-table thead {
            background: var(--light-bg);
        }
        
        .medical-table th {
            padding: 16px 20px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            text-align: left;
            border-bottom: 2px solid var(--border-blue);
        }
        
        .medical-table tbody tr {
            border-bottom: 1px solid var(--border-blue);
            transition: background 0.3s ease;
        }
        
        .medical-table tbody tr:hover {
            background: var(--background-blue);
        }
        
        .medical-table td {
            padding: 16px 20px;
            font-size: 14px;
            color: var(--text-dark);
            vertical-align: middle;
        }
        
        /* Vital Stats */
        .vital-stat {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
        }
        
        .vital-bp {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .vital-bs {
            background: #dbeafe;
            color: var(--primary-blue);
        }
        
        .vital-weight {
            background: #d1fae5;
            color: #065f46;
        }
        
        .vital-temp {
            background: #fef3c7;
            color: #92400e;
        }
        
        /* Add History Button */
        .btn-add-history {
            background: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
        }
        
        .btn-add-history:hover {
            background: var(--secondary-blue);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
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
            height: 120px;
            padding: 12px 15px;
            resize: vertical;
        }
        
        /* Action Buttons */
        .btn-secondary {
            background: var(--text-gray);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: #475569;
            color: white;
        }
        
        .btn-primary {
            background: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: var(--secondary-blue);
            color: white;
        }
        
        /* No History State */
        .no-history {
            text-align: center;
            padding: 60px 20px;
        }
        
        .no-history i {
            font-size: 60px;
            color: var(--border-blue);
            margin-bottom: 20px;
        }
        
        .no-history h5 {
            font-size: 18px;
            color: var(--text-gray);
            margin-bottom: 10px;
        }
        
        .no-history p {
            color: var(--text-gray);
            font-size: 14px;
            margin: 0 0 20px 0;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .wrap-content {
                padding: 15px;
            }
            
            .page-title-main h1 {
                font-size: 24px;
            }
            
            .page-subtitle {
                font-size: 14px;
                padding-left: 35px;
            }
            
            .section-header-simple h2 {
                font-size: 20px;
            }
            
            .patient-info-card, .medical-history-card {
                padding: 20px;
            }
            
            .patient-details-grid {
                grid-template-columns: 1fr;
            }
            
            .history-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .btn-add-history {
                width: 100%;
                justify-content: center;
            }
            
            .modal-body {
                padding: 20px;
            }
            
            .medical-table {
                min-width: 600px;
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
                    
                    <!-- Simple Page Header -->
                    <div class="page-header-simple">
                        <div class="page-title-main">
                            <h1>
                                <i class="fas fa-user-injured"></i>
                                Patient Medical History
                            </h1>
                        </div>
                        <p class="page-subtitle">View and manage patient medical records</p>
                    </div>
                    
                    <?php
                    $vid = $_GET['viewid'];
                    $ret = mysqli_query($con, "SELECT * FROM tblpatient WHERE ID='$vid'");
                    $patient = mysqli_fetch_array($ret);
                    $initial = strtoupper(substr($patient['PatientName'], 0, 1));
                    ?>
                    
                    <!-- Simple Section Header -->
                    <div class="section-header-simple">
                        <h2>
                            <i class="fas fa-user-circle"></i>
                            Patient Information
                        </h2>
                    </div>
                    
                    <!-- Patient Information Card -->
                    <div class="patient-info-card">
                        <div class="patient-details-grid">
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-user"></i>
                                    Patient Name
                                </div>
                                <p class="detail-value"><?php echo htmlentities($patient['PatientName']); ?></p>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-envelope"></i>
                                    Email Address
                                </div>
                                <p class="detail-value"><?php echo htmlentities($patient['PatientEmail']); ?></p>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-phone"></i>
                                    Contact Number
                                </div>
                                <p class="detail-value"><?php echo htmlentities($patient['PatientContno']); ?></p>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Address
                                </div>
                                <p class="detail-value"><?php echo htmlentities($patient['PatientAdd']); ?></p>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-venus-mars"></i>
                                    Gender
                                </div>
                                <p class="detail-value"><?php echo htmlentities($patient['PatientGender']); ?></p>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-birthday-cake"></i>
                                    Age
                                </div>
                                <p class="detail-value"><?php echo htmlentities($patient['PatientAge']); ?> years</p>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-file-medical"></i>
                                    Medical History
                                </div>
                                <p class="detail-value"><?php echo htmlentities($patient['PatientMedhis']); ?></p>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-calendar-plus"></i>
                                    Registration Date
                                </div>
                                <p class="detail-value"><?php echo date('M d, Y h:i A', strtotime($patient['CreationDate'])); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Simple Section Header -->
                    <div class="section-header-simple">
                        <h2>
                            <i class="fas fa-history"></i>
                            Medical History Records
                        </h2>
                    </div>
                    
                    <!-- Medical History Card -->
                    <div class="medical-history-card">
                        <div class="history-header">
                            <div style="flex: 1;"></div>
                            <div>
                                <button class="btn-add-history" data-toggle="modal" data-target="#addHistoryModal">
                                    <i class="fas fa-plus-circle"></i>
                                    Add New Entry
                                </button>
                            </div>
                        </div>
                        
                        <?php  
                        $ret = mysqli_query($con, "SELECT * FROM tblmedicalhistory WHERE PatientID='$vid' ORDER BY CreationDate DESC");
                        $history_count = mysqli_num_rows($ret);
                        
                        if($history_count > 0) {
                        ?>
                        
                        <div class="table-container">
                            <table class="medical-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Blood Pressure</th>
                                        <th>Blood Sugar</th>
                                        <th>Weight</th>
                                        <th>Temperature</th>
                                        <th>Prescription</th>
                                        <th>Visit Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    $cnt = 1;
                                    while($row = mysqli_fetch_array($ret)) { 
                                    ?>
                                    <tr>
                                        <td><?php echo $cnt; ?></td>
                                        <td>
                                            <span class="vital-stat vital-bp">
                                                <i class="fas fa-heartbeat"></i>
                                                <?php echo htmlentities($row['BloodPressure']); ?> mmHg
                                            </span>
                                        </td>
                                        <td>
                                            <span class="vital-stat vital-bs">
                                                <i class="fas fa-tint"></i>
                                                <?php echo htmlentities($row['BloodSugar']); ?> mg/dL
                                            </span>
                                        </td>
                                        <td>
                                            <span class="vital-stat vital-weight">
                                                <i class="fas fa-weight"></i>
                                                <?php echo htmlentities($row['Weight']); ?> kg
                                            </span>
                                        </td>
                                        <td>
                                            <span class="vital-stat vital-temp">
                                                <i class="fas fa-thermometer-half"></i>
                                                <?php echo htmlentities($row['Temperature']); ?> °C
                                            </span>
                                        </td>
                                        <td>
                                            <div style="max-width: 200px; word-wrap: break-word;">
                                                <?php echo htmlentities($row['MedicalPres']); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-size: 13px;">
                                                <?php echo date('M d, Y', strtotime($row['CreationDate'])); ?>
                                            </div>
                                            <div style="font-size: 12px; color: var(--text-gray);">
                                                <?php echo date('h:i A', strtotime($row['CreationDate'])); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php 
                                    $cnt++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <?php } else { ?>
                        
                        <div class="no-history">
                            <i class="fas fa-file-medical-alt"></i>
                            <h5>No Medical History Found</h5>
                            <p>This patient doesn't have any medical history records yet.</p>
                            <button class="btn-add-history" data-toggle="modal" data-target="#addHistoryModal">
                                <i class="fas fa-plus-circle"></i>
                                Add First Medical Entry
                            </button>
                        </div>
                        
                        <?php } ?>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <!-- Add Medical History Modal -->
        <div class="modal fade" id="addHistoryModal" tabindex="-1" role="dialog" aria-labelledby="addHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addHistoryModalLabel">
                            <i class="fas fa-file-medical"></i>
                            Add Medical History
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" name="submit">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-heartbeat"></i>
                                            Blood Pressure
                                        </label>
                                        <input type="text" 
                                               name="bp" 
                                               placeholder="e.g., 120/80 mmHg" 
                                               class="form-control" 
                                               required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-tint"></i>
                                            Blood Sugar
                                        </label>
                                        <input type="text" 
                                               name="bs" 
                                               placeholder="e.g., 90 mg/dL" 
                                               class="form-control" 
                                               required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-weight"></i>
                                            Weight
                                        </label>
                                        <input type="text" 
                                               name="weight" 
                                               placeholder="e.g., 70 kg" 
                                               class="form-control" 
                                               required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-thermometer-half"></i>
                                            Body Temperature
                                        </label>
                                        <input type="text" 
                                               name="temp" 
                                               placeholder="e.g., 37.5 °C" 
                                               class="form-control" 
                                               required>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea name="pres" 
                                                  placeholder="Enter medical prescription details..." 
                                                  rows="6" 
                                                  class="form-control" 
                                                  required></textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i>
                            Cancel
                        </button>
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Save Medical Entry
                        </button>
                        </form>
                    </div>
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
            
            // Initialize DataTable for medical history
            $('.medical-table').DataTable({
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[0, 'desc']],
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search medical history..."
                }
            });
            
            // Add search box styling
            $('.dataTables_filter input').addClass('form-control');
            $('.dataTables_filter label').contents().filter(function() {
                return this.nodeType == 3;
            }).remove();
            
            // Form validation for medical entry
            $('form[name="submit"]').on('submit', function(e) {
                var bp = $('input[name="bp"]').val();
                var bs = $('input[name="bs"]').val();
                var weight = $('input[name="weight"]').val();
                var temp = $('input[name="temp"]').val();
                var pres = $('textarea[name="pres"]').val();
                
                if(!bp || !bs || !weight || !temp || !pres) {
                    e.preventDefault();
                    alert('Please fill in all required fields');
                    return false;
                }
                
                // Show loading state
                var submitBtn = $(this).find('button[type="submit"]');
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
        });
    </script>
</body>
</html>
<?php } ?>