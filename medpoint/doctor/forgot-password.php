<?php
session_start();
error_reporting(0);
include("include/config.php");

// Checking Details for reset password
if(isset($_POST['submit'])){
    $contactno = $_POST['contactno'];
    $email = $_POST['email'];
    $query = mysqli_query($con, "SELECT id FROM doctors WHERE contactno='$contactno' AND docEmail='$email'");
    $row = mysqli_num_rows($query);
    
    if($row > 0){
        $_SESSION['cnumber'] = $contactno;
        $_SESSION['email'] = $email;
        header('location:reset-password.php');
    } else {
        $error = "Invalid details. Please try with valid details";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Password Recovery | MedPoint</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    
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
            --danger: #ef4444;
            --shadow: 0 4px 20px rgba(37, 99, 235, 0.1);
            --radius: 12px;
        }
        
        * {
            font-family: 'Poppins', sans-serif !important;
        }
        
        body {
            background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        
        .recovery-container {
            width: 100%;
            max-width: 420px;
        }
        
        /* Logo Section */
        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo-icon {
            width: 70px;
            height: 70px;
            background: var(--primary-blue);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        }
        
        .logo-icon i {
            color: white;
            font-size: 32px;
        }
        
        .logo-section h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark-blue);
            margin: 0 0 5px 0;
        }
        
        .logo-section p {
            color: var(--text-gray);
            font-size: 14px;
            margin: 0;
        }
        
        /* Recovery Card */
        .recovery-card {
            background: white;
            border-radius: var(--radius);
            padding: 35px 30px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-blue);
            position: relative;
            overflow: hidden;
        }
        
        .recovery-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-blue);
        }
        
        .card-header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .card-header h2 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .card-header p {
            color: var(--text-gray);
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
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
        
        .alert-danger {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        
        .alert-danger i {
            color: #ef4444;
        }
        
        .alert-success {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
            font-size: 16px;
            z-index: 2;
        }
        
        .form-control {
            width: 100%;
            height: 52px;
            padding: 0 15px 0 45px;
            border: 2px solid var(--border-blue);
            border-radius: 10px;
            font-size: 14px;
            color: var(--text-dark);
            background: white;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }
        
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            padding-left: 5px;
        }
        
        /* Submit Button */
        .btn-submit {
            width: 100%;
            height: 52px;
            background: var(--primary-blue);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-submit:hover {
            background: var(--secondary-blue);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        }
        
        /* Links */
        .login-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid var(--border-blue);
        }
        
        .login-link p {
            color: var(--text-gray);
            font-size: 14px;
            margin: 0;
        }
        
        .login-link a {
            color: var(--primary-blue);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .login-link a:hover {
            color: var(--secondary-blue);
            text-decoration: underline;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid var(--border-blue);
        }
        
        .footer p {
            color: var(--text-gray);
            font-size: 13px;
            margin: 0;
            font-weight: 500;
        }
        
        /* Password Rules */
        .password-rules {
            background: var(--light-bg);
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            border: 1px solid var(--border-blue);
        }
        
        .password-rules h6 {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark-blue);
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .password-rules ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .password-rules li {
            font-size: 12px;
            color: var(--text-gray);
            margin-bottom: 5px;
            line-height: 1.5;
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            body {
                padding: 15px;
            }
            
            .recovery-container {
                max-width: 100%;
            }
            
            .recovery-card {
                padding: 25px 20px;
            }
            
            .logo-section h1 {
                font-size: 20px;
            }
            
            .card-header h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="recovery-container">
        <!-- Logo Section -->
        <div class="logo-section">
            <div class="logo-icon">
                <i class="fas fa-user-md"></i>
            </div>
            <h1>MedPoint</h1>
            <p>Doctor Appointment Booking System</p>
        </div>
        
        <!-- Recovery Card -->
        <div class="recovery-card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-key"></i>
                    Password Recovery
                </h2>
                <p>Enter your registered contact number and email to reset your password</p>
            </div>
            
            <?php if(isset($error)): ?>
            <div class="alert-message alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error; ?>
            </div>
            <?php endif; ?>
            
            <form class="form-login" method="post">
                <!-- Contact Number -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-phone-alt" style="margin-right: 5px;"></i>
                        Registered Contact Number
                    </label>
                    <div class="input-group">
                        <i class="fas fa-phone-alt"></i>
                        <input type="text" 
                               class="form-control" 
                               name="contactno" 
                               placeholder="Enter your 10-digit contact number"
                               required
                               maxlength="10"
                               pattern="[0-9]{10}">
                    </div>
                </div>
                
                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope" style="margin-right: 5px;"></i>
                        Registered Email Address
                    </label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" 
                               class="form-control" 
                               name="email" 
                               placeholder="Enter your registered email"
                               required>
                    </div>
                </div>
                
                <!-- Password Rules -->
                <div class="password-rules">
                    <h6>
                        <i class="fas fa-info-circle"></i>
                        Please Note
                    </h6>
                    <ul>
                        <li>Use your registered contact number and email</li>
                        <li>You will be redirected to password reset page</li>
                        <li>Check your email for verification if needed</li>
                    </ul>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn-submit" name="submit">
                    <i class="fas fa-redo"></i>
                    Reset Password
                </button>
            </form>
            
            <!-- Login Link -->
            <div class="login-link">
                <p>
                    Remember your password? 
                    <a href="index.php">
                        <i class="fas fa-sign-in-alt"></i>
                        Login here
                    </a>
                </p>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <p>© <?php echo date('Y'); ?> MedPoint. All rights reserved.</p>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    
    <script>
        $(document).ready(function() {
            // Format contact number input
            $('input[name="contactno"]').on('input', function() {
                this.value = this.value.replace(/\D/g, '').substring(0, 10);
            });
            
            // Form validation
            $('.form-login').on('submit', function(e) {
                var contact = $('input[name="contactno"]').val();
                var email = $('input[name="email"]').val();
                
                if (contact.length !== 10) {
                    alert('Please enter a valid 10-digit contact number');
                    e.preventDefault();
                    return false;
                }
                
                if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    alert('Please enter a valid email address');
                    e.preventDefault();
                    return false;
                }
                
                return true;
            });
            
            // Add loading state to button
            $('.form-login').on('submit', function() {
                var btn = $(this).find('.btn-submit');
                btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
                btn.prop('disabled', true);
            });
        });
    </script>
</body>
</html>