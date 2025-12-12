<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
    exit();
} else {
    date_default_timezone_set('Asia/Manila'); // Change according to timezone
    $currentTime = date('Y-m-d H:i:s');

    if(isset($_POST['submit'])) {
        $cpass = md5($_POST['cpass']);
        $did = $_SESSION['id'];
        
        // Using prepared statement for security
        $stmt = $con->prepare("SELECT password FROM doctors WHERE password=? AND id=?");
        $stmt->bind_param("si", $cpass, $did);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $npass = md5($_POST['npass']);
            $updateStmt = $con->prepare("UPDATE doctors SET password=?, updationDate=? WHERE id=?");
            $updateStmt->bind_param("ssi", $npass, $currentTime, $did);
            
            if($updateStmt->execute()) {
                $_SESSION['msg1'] = "Password Changed Successfully!";
                $_SESSION['msg_type'] = "success";
            } else {
                $_SESSION['msg1'] = "Error updating password. Please try again.";
                $_SESSION['msg_type'] = "error";
            }
            $updateStmt->close();
        } else {
            $_SESSION['msg1'] = "Current password is incorrect!";
            $_SESSION['msg_type'] = "error";
        }
        $stmt->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor | Change Password</title>
    
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
            --success-light: #d1fae5;
            --success-dark: #065f46;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --danger-dark: #991b1b;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 12px rgba(37, 99, 235, 0.1);
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
           ALERT MESSAGES
        ============================================ */
        .alert-message {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease;
        }

        .alert-success {
            background: var(--success-light);
            color: var(--success-dark);
            border: 1px solid var(--success);
        }

        .alert-error {
            background: var(--danger-light);
            color: var(--danger-dark);
            border: 1px solid var(--danger);
        }

        .alert-message i {
            font-size: 20px;
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

        /* ============================================
           SECURITY INFO CARD
        ============================================ */
        .security-info {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            padding: 25px;
            border-radius: 16px;
            color: white;
            margin-bottom: 30px;
        }

        .security-info h4 {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 12px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .security-info h4 i {
            font-size: 24px;
        }

        .security-info p {
            margin: 0;
            font-size: 14px;
            line-height: 1.6;
            opacity: 0.95;
        }

        .security-info ul {
            margin: 15px 0 0 0;
            padding-left: 20px;
        }

        .security-info li {
            font-size: 13px;
            margin-bottom: 8px;
            opacity: 0.9;
        }

        /* ============================================
           FORM PANEL
        ============================================ */
        .panel {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            background: white;
        }

        .panel-heading {
            background: var(--light-blue-bg) !important;
            border-bottom: 2px solid var(--border-color);
            padding: 20px 25px;
        }

        .panel-title {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 18px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .panel-title i {
            color: var(--primary-blue);
            font-size: 20px;
        }

        .panel-body {
            padding: 30px 25px;
        }

        /* ============================================
           FORM ELEMENTS
        ============================================ */
        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 10px;
            font-size: 14px;
        }

        .password-input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 14px 45px 14px 18px;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
            transition: var(--transition);
            background: white;
            height: auto;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-control::placeholder {
            color: var(--text-light);
        }

        .form-control.error {
            border-color: var(--danger);
        }

        .form-control.valid {
            border-color: var(--success);
        }

        /* ============================================
           PASSWORD TOGGLE
        ============================================ */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-light);
            font-size: 16px;
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--primary-blue);
        }

        /* ============================================
           PASSWORD STRENGTH INDICATOR
        ============================================ */
        .password-strength {
            margin-top: 10px;
            display: none;
        }

        .strength-bar {
            height: 6px;
            border-radius: 3px;
            background: var(--border-color);
            overflow: hidden;
            margin-bottom: 8px;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: var(--transition);
            border-radius: 3px;
        }

        .strength-weak .strength-fill {
            width: 33%;
            background: var(--danger);
        }

        .strength-medium .strength-fill {
            width: 66%;
            background: #f59e0b;
        }

        .strength-strong .strength-fill {
            width: 100%;
            background: var(--success);
        }

        .strength-text {
            font-size: 12px;
            font-weight: 600;
        }

        .strength-weak .strength-text {
            color: var(--danger);
        }

        .strength-medium .strength-text {
            color: #f59e0b;
        }

        .strength-strong .strength-text {
            color: var(--success);
        }

        /* ============================================
           VALIDATION MESSAGES
        ============================================ */
        .error-message {
            color: var(--danger);
            font-size: 12px;
            margin-top: 5px;
            display: block;
            font-weight: 600;
        }

        /* ============================================
           SUBMIT BUTTON
        ============================================ */
        .btn-primary {
            background: var(--primary-blue);
            color: white;
            padding: 14px 35px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            color: white;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* ============================================
           FORM ACTIONS
        ============================================ */
        .form-actions {
            margin-top: 35px;
            padding-top: 25px;
            border-top: 2px solid var(--border-color);
            text-align: right;
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

            .panel-heading {
                padding: 18px 20px;
            }

            .panel-body {
                padding: 25px 20px;
            }

            .security-info {
                padding: 20px;
            }

            .form-actions {
                text-align: center;
            }

            .btn-primary {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            #page-title .mainTitle {
                font-size: 24px;
            }

            .panel-heading {
                padding: 15px;
            }

            .panel-body {
                padding: 20px 15px;
            }

            .security-info h4 {
                font-size: 16px;
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
                <div class="wrap-content container" id="container">
                    
                    <!-- Page Title -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-12">
                                <h1 class="mainTitle">CHANGE PASSWORD</h1>
                            </div>
                        </div>
                    </section>

                    <!-- Main Content Card -->
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    <!-- Security Info Sidebar -->
                                    <div class="col-lg-4 col-md-12">
                                        <div class="security-info">
                                            <h4>
                                                <i class="fa fa-shield"></i>
                                                Password Security Tips
                                            </h4>
                                            <p>Keep your account secure by following these guidelines:</p>
                                            <ul>
                                                <li>Use at least 8 characters</li>
                                                <li>Include uppercase and lowercase letters</li>
                                                <li>Add numbers and special characters</li>
                                                <li>Avoid common words or patterns</li>
                                                <li>Don't reuse old passwords</li>
                                                <li>Change password regularly</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Change Password Form -->
                                    <div class="col-lg-8 col-md-12">
                                        
                                        <!-- Alert Message -->
                                        <?php if(!empty($_SESSION['msg1'])) { 
                                            $msgType = isset($_SESSION['msg_type']) ? $_SESSION['msg_type'] : 'error';
                                        ?>
                                            <div class="alert-message alert-<?php echo $msgType; ?>">
                                                <i class="fa fa-<?php echo ($msgType == 'success') ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                                                <span><?php echo htmlentities($_SESSION['msg1']); ?></span>
                                            </div>
                                            <?php 
                                            $_SESSION['msg1']="";
                                            $_SESSION['msg_type']="";
                                        } ?>

                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h5 class="panel-title">
                                                    <i class="fa fa-lock"></i>
                                                    Update Your Password
                                                </h5>
                                            </div>
                                            <div class="panel-body">
                                                <form role="form" name="chngpwd" id="changePasswordForm" method="post">
                                                    
                                                    <!-- Current Password -->
                                                    <div class="form-group">
                                                        <label for="cpass">
                                                            Current Password <span style="color: red;">*</span>
                                                        </label>
                                                        <div class="password-input-wrapper">
                                                            <input type="password" 
                                                                   name="cpass" 
                                                                   id="cpass" 
                                                                   class="form-control" 
                                                                   placeholder="Enter your current password"
                                                                   required>
                                                            <i class="fa fa-eye password-toggle" data-target="cpass"></i>
                                                        </div>
                                                    </div>

                                                    <!-- New Password -->
                                                    <div class="form-group">
                                                        <label for="npass">
                                                            New Password <span style="color: red;">*</span>
                                                        </label>
                                                        <div class="password-input-wrapper">
                                                            <input type="password" 
                                                                   name="npass" 
                                                                   id="npass" 
                                                                   class="form-control" 
                                                                   placeholder="Enter new password (min. 8 characters)"
                                                                   required
                                                                   minlength="8">
                                                            <i class="fa fa-eye password-toggle" data-target="npass"></i>
                                                        </div>
                                                        <div class="password-strength" id="passwordStrength">
                                                            <div class="strength-bar">
                                                                <div class="strength-fill"></div>
                                                            </div>
                                                            <span class="strength-text"></span>
                                                        </div>
                                                    </div>

                                                    <!-- Confirm Password -->
                                                    <div class="form-group">
                                                        <label for="cfpass">
                                                            Confirm New Password <span style="color: red;">*</span>
                                                        </label>
                                                        <div class="password-input-wrapper">
                                                            <input type="password" 
                                                                   name="cfpass" 
                                                                   id="cfpass" 
                                                                   class="form-control" 
                                                                   placeholder="Re-enter new password"
                                                                   required>
                                                            <i class="fa fa-eye password-toggle" data-target="cfpass"></i>
                                                        </div>
                                                        <span class="error-message" id="confirmError"></span>
                                                    </div>

                                                    <!-- Submit Button -->
                                                    <div class="form-actions">
                                                        <button type="submit" name="submit" id="submitBtn" class="btn btn-primary">
                                                            <i class="fa fa-check"></i> Change Password
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
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

            // Password toggle functionality
            $('.password-toggle').click(function() {
                var target = $(this).data('target');
                var input = $('#' + target);
                var type = input.attr('type');
                
                if(type === 'password') {
                    input.attr('type', 'text');
                    $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    input.attr('type', 'password');
                    $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Password strength checker
            $('#npass').on('input', function() {
                var password = $(this).val();
                var strength = 0;
                var strengthDiv = $('#passwordStrength');
                
                if(password.length >= 8) strength++;
                if(password.match(/[a-z]/)) strength++;
                if(password.match(/[A-Z]/)) strength++;
                if(password.match(/[0-9]/)) strength++;
                if(password.match(/[^a-zA-Z0-9]/)) strength++;

                strengthDiv.show();
                strengthDiv.removeClass('strength-weak strength-medium strength-strong');

                if(strength <= 2) {
                    strengthDiv.addClass('strength-weak');
                    strengthDiv.find('.strength-text').text('Weak password');
                } else if(strength <= 4) {
                    strengthDiv.addClass('strength-medium');
                    strengthDiv.find('.strength-text').text('Medium strength');
                } else {
                    strengthDiv.addClass('strength-strong');
                    strengthDiv.find('.strength-text').text('Strong password');
                }
            });

            // Form validation
            $('#changePasswordForm').submit(function(e) {
                var cpass = $('#cpass').val();
                var npass = $('#npass').val();
                var cfpass = $('#cfpass').val();
                var isValid = true;

                // Clear previous errors
                $('.error-message').text('');
                $('.form-control').removeClass('error');

                // Validate current password
                if(cpass === '') {
                    $('#cpass').addClass('error');
                    isValid = false;
                }

                // Validate new password
                if(npass === '') {
                    $('#npass').addClass('error');
                    isValid = false;
                } else if(npass.length < 8) {
                    $('#npass').addClass('error');
                    alert('New password must be at least 8 characters long!');
                    isValid = false;
                }

                // Validate confirm password
                if(cfpass === '') {
                    $('#cfpass').addClass('error');
                    isValid = false;
                } else if(npass !== cfpass) {
                    $('#cfpass').addClass('error');
                    $('#confirmError').text('Passwords do not match!');
                    alert('New password and confirm password do not match!');
                    isValid = false;
                }

                // Check if new password is same as current
                if(cpass === npass && cpass !== '') {
                    $('#npass').addClass('error');
                    alert('New password must be different from current password!');
                    isValid = false;
                }

                if(!isValid) {
                    e.preventDefault();
                    return false;
                }

                // Disable submit button to prevent double submission
                $('#submitBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Changing...');
            });

            // Real-time confirm password validation
            $('#cfpass').on('input', function() {
                var npass = $('#npass').val();
                var cfpass = $(this).val();
                
                if(cfpass !== '' && npass !== cfpass) {
                    $(this).addClass('error');
                    $('#confirmError').text('Passwords do not match!');
                } else {
                    $(this).removeClass('error').addClass('valid');
                    $('#confirmError').text('');
                }
            });

            // Auto-hide alert messages after 5 seconds
            setTimeout(function() {
                $('.alert-message').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>
</html>
<?php } ?>