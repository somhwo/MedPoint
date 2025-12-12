<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {
    if(isset($_POST['submit'])) {
        $docspecialization = $_POST['Doctorspecialization'];
        $docname = $_POST['docname'];
        $docaddress = $_POST['clinicaddress'];
        $docfees = $_POST['docfees'];
        $doccontactno = $_POST['doccontact'];
        $docemail = $_POST['docemail'];
        
        $sql = mysqli_query($con, "UPDATE doctors SET specilization='$docspecialization', doctorName='$docname', address='$docaddress', docFees='$docfees', contactno='$doccontactno' WHERE id='".$_SESSION['id']."'");
        
        if($sql) {
            echo "<script>alert('Doctor Details updated Successfully');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctr | Edit Doctor Profile</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
    
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
            --shadow: 0 2px 10px rgba(37, 99, 235, 0.1);
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
            margin-bottom: 30px;
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
        
        /* Doctor Profile Card */
        .profile-card {
            background: white;
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            border: 1px solid var(--border-blue);
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 2px solid var(--border-blue);
        }
        
        .profile-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            font-weight: 600;
            flex-shrink: 0;
        }
        
        .profile-info h3 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 5px 0;
        }
        
        .profile-info p {
            color: var(--text-gray);
            margin: 0 0 10px 0;
        }
        
        .profile-meta {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: var(--text-gray);
        }
        
        .meta-item i {
            color: var(--primary-blue);
            font-size: 16px;
        }
        
        /* Form Section */
        .form-section {
            background: white;
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            border: 1px solid var(--border-blue);
        }
        
        .section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-blue);
        }
        
        .section-header h4 {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }
        
        .section-header i {
            color: var(--primary-blue);
            font-size: 22px;
        }
        
        /* Form Elements */
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-label i {
            color: var(--primary-blue);
            font-size: 16px;
            width: 20px;
        }
        
        .form-control, .form-select {
            height: 50px;
            border: 2px solid var(--border-blue);
            border-radius: 8px;
            padding: 0 15px;
            font-size: 14px;
            color: var(--text-dark);
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }
        
        textarea.form-control {
            height: 120px;
            padding: 15px;
            resize: vertical;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group .prefix-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
            pointer-events: none;
        }
        
        .input-group .form-control {
            padding-left: 45px;
        }
        
        /* Buttons */
        .btn-primary {
            background: var(--primary-blue);
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-size: 15px;
            font-weight: 600;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: var(--secondary-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        
        /* Alert */
        .alert-success {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }
        
        .alert-success i {
            color: #10b981;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: var(--radius);
            padding: 20px;
            border: 1px solid var(--border-blue);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            background: #dbeafe;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: var(--primary-blue);
            font-size: 20px;
        }
        
        .stat-card h6 {
            font-size: 13px;
            color: var(--text-gray);
            margin: 0 0 8px 0;
            font-weight: 500;
        }
        
        .stat-card .value {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }
        
        /* Tips Card */
        .tips-card {
            background: white;
            border-radius: var(--radius);
            padding: 25px;
            border: 1px solid var(--border-blue);
            margin-bottom: 30px;
        }
        
        .tip-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-blue);
        }
        
        .tip-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .tip-item i {
            color: var(--primary-blue);
            font-size: 18px;
            margin-top: 2px;
        }
        
        .tip-content h6 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 5px 0;
        }
        
        .tip-content p {
            font-size: 13px;
            color: var(--text-gray);
            margin: 0;
            line-height: 1.5;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .wrap-content {
                padding: 15px;
            }
            
            .page-header {
                padding: 20px;
            }
            
            .page-title h1 {
                font-size: 24px;
            }
            
            .profile-header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }
            
            .profile-meta {
                flex-direction: column;
                gap: 10px;
                align-items: center;
            }
            
            .profile-card, .form-section, .tips-card {
                padding: 20px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
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
                                <i class="fas fa-user-md"></i>
                                Edit Doctor Profile
                            </h1>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Dashboard
                                </li>
                                <li class="breadcrumb-item">
                                    <i class="fas fa-user-md"></i>
                                    Profile
                                </li>
                                <li class="breadcrumb-item active">
                                    <i class="fas fa-edit"></i>
                                    Edit Details
                                </li>
                            </ol>
                        </nav>
                    </div>
                    
                    <?php 
                    $did = $_SESSION['dlogin'];
                    $sql = mysqli_query($con, "SELECT * FROM doctors WHERE docEmail='$did'");
                    while($data = mysqli_fetch_array($sql)) {
                        $initial = strtoupper(substr($data['doctorName'], 0, 1));
                    ?>
                    
                    <!-- Profile Card -->
                    <div class="profile-card">
                        <div class="profile-header">
                            <div class="profile-avatar">
                                <?php echo $initial; ?>
                            </div>
                            <div class="profile-info">
                                <h3>Dr. <?php echo htmlentities($data['doctorName']); ?></h3>
                                <p><?php echo htmlentities($data['specilization']); ?> Specialist</p>
                                <div class="profile-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-plus"></i>
                                        Joined: <?php echo date('M d, Y', strtotime($data['creationDate'])); ?>
                                    </div>
                                    <?php if($data['updationDate']) { ?>
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-check"></i>
                                        Updated: <?php echo date('M d, Y', strtotime($data['updationDate'])); ?>
                                    </div>
                                    <?php } ?>
                                    <div class="meta-item">
                                        <i class="fas fa-id-badge"></i>
                                        ID: DR<?php echo str_pad($data['id'], 4, '0', STR_PAD_LEFT); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Main Form -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-edit"></i>
                                <h4>Profile Information</h4>
                            </div>
                            
                            <form role="form" name="adddoc" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-stethoscope"></i>
                                                Specialization
                                            </label>
                                            <select name="Doctorspecialization" class="form-select" required>
                                                <option value="<?php echo htmlentities($data['specilization']); ?>">
                                                    <?php echo htmlentities($data['specilization']); ?>
                                                </option>
                                                <?php 
                                                $ret = mysqli_query($con, "SELECT * FROM doctorspecilization");
                                                while($row = mysqli_fetch_array($ret)) {
                                                ?>
                                                <option value="<?php echo htmlentities($row['specilization']); ?>">
                                                    <?php echo htmlentities($row['specilization']); ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-user"></i>
                                                Full Name
                                            </label>
                                            <div class="input-group">
                                                <i class="fas fa-user prefix-icon"></i>
                                                <input type="text" name="docname" class="form-control" 
                                                       value="<?php echo htmlentities($data['doctorName']); ?>"
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Clinic Address
                                    </label>
                                    <textarea name="clinicaddress" class="form-control" rows="4"><?php echo htmlentities($data['address']); ?></textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-money-bill"></i>
                                                Consultation Fee
                                            </label>
                                            <div class="input-group">
                                                <i class="fas fa-dollar-sign prefix-icon"></i>
                                                <input type="text" name="docfees" class="form-control" 
                                                       value="<?php echo htmlentities($data['docFees']); ?>"
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-phone"></i>
                                                Contact Number
                                            </label>
                                            <div class="input-group">
                                                <i class="fas fa-phone-alt prefix-icon"></i>
                                                <input type="text" name="doccontact" class="form-control" 
                                                       value="<?php echo htmlentities($data['contactno']); ?>"
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-envelope"></i>
                                        Email Address
                                    </label>
                                    <div class="input-group">
                                        <i class="fas fa-envelope prefix-icon"></i>
                                        <input type="email" name="docemail" class="form-control" 
                                               value="<?php echo htmlentities($data['docEmail']); ?>"
                                               readonly>
                                    </div>
                                    <small class="text-muted">Email cannot be changed for security reasons</small>
                                </div>
                                
                                <div class="text-end mt-4">
                                    <button type="submit" name="submit" class="btn-primary">
                                        <i class="fas fa-save"></i>
                                        Update Profile
                                    </button>
                                </div>
                            </form>
                            
                            <!-- Stats -->
                            <div class="stats-grid">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <h6>Today's Appointments</h6>
                                    <p class="value">8</p>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h6>Total Patients</h6>
                                    <p class="value">156</p>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <h6>Rating</h6>
                                    <p class="value">4.8</p>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <h6>Experience</h6>
                                    <p class="value">5y</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tips Card -->
                    <div class="tips-card">
                        <div class="section-header">
                            <i class="fas fa-lightbulb"></i>
                            <h4>Profile Tips</h4>
                        </div>
                        <div class="mt-3">
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <div class="tip-content">
                                    <h6>Keep Information Updated</h6>
                                    <p>Regularly update your contact details and consultation fees for better patient communication.</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <div class="tip-content">
                                    <h6>Complete Address</h6>
                                    <p>Provide your full clinic address including landmark for easy patient navigation.</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <div class="tip-content">
                                    <h6>Accurate Specialization</h6>
                                    <p>Select the correct specialization to match with suitable patients and appointments.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php } ?>
                    
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
    <script src="assets/js/main.js"></script>
    
    <script>
        $(document).ready(function() {
            Main.init();
            
            // Format contact number input
            $('input[name="doccontact"]').on('input', function() {
                this.value = this.value.replace(/\D/g, '').substring(0, 10);
            });
            
            // Format fees input
            $('input[name="docfees"]').on('input', function() {
                this.value = this.value.replace(/[^0-9.]/g, '');
            });
            
            // Form validation
            $('form[name="adddoc"]').on('submit', function(e) {
                var contact = $('input[name="doccontact"]').val();
                var fees = $('input[name="docfees"]').val();
                
                if (contact.length < 10) {
                    alert('Please enter a valid 10-digit contact number');
                    e.preventDefault();
                    return false;
                }
                
                if (!fees || isNaN(parseFloat(fees))) {
                    alert('Please enter a valid consultation fee');
                    e.preventDefault();
                    return false;
                }
                
                return true;
            });
        });
    </script>
</body>
</html>
<?php } ?>