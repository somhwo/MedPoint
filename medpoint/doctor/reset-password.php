<?php
session_start();
// error_reporting(0);
include("include/config.php");

// Code for updating Password
if(isset($_POST['change'])) {
    $cno = $_SESSION['cnumber'];
    $email = $_SESSION['email'];
    $newpassword = md5($_POST['password']);
    
    $query = mysqli_query($con, "UPDATE doctors SET password='$newpassword' WHERE contactno='$cno' AND docEmail='$email'");
    
    if($query) {
        echo "<script>alert('Password successfully updated.');</script>";
        echo "<script>window.location.href ='index.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Password Reset | MedPoint</title>
    
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
            --warning: #f59e0b;
            --shadow: 0 8px 30px rgba(37, 99, 235, 0.1);
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
        
        .reset-container {
            width: 100%;
            max-width: 450px;
        }
        
        /* Logo Section */
        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-blue);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .logo-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite linear;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }
        
        .logo-icon i {
            color: white;
            font-size: 36px;
            position: relative;
            z-index: 1;
        }
        
        .logo-section h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark-blue);
            margin: 0 0 5px 0;
        }
        
        .logo-section p {
            color: var(--text-gray);
            font-size: 14px;
            margin: 0;
        }
        
        /* Reset Card */
        .reset-card {
            background: white;
            border-radius: var(--radius);
            padding: 35px 30px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-blue);
            position: relative;
            overflow: hidden;
        }
        
        .reset-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--secondary-blue));
        }
        
        .card-header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .card-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
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
        
        .alert-success i {
            color: var(--success);
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            padding-left: 5px;
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
        
        /* Password Strength Indicator */
        .password-strength {
            margin-top: 8px;
        }
        
        .strength-meter {
            height: 4px;
            background: var(--border-blue);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 5px;
        }
        
        .strength-fill {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        
        .strength-weak .strength-fill {
            background: var(--danger);
            width: 33%;
        }
        
        .strength-medium .strength-fill {
            background: var(--warning);
            width: 66%;
        }
        
        .strength-strong .strength-fill {
            background: var(--success);
            width: 100%;
        }
        
        .strength-text {
            font-size: 12px;
            color: var(--text-gray);
            text-align: right;
        }
        
        /* Password Requirements */
        .password-requirements {
            background: var(--light-bg);
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            border: 1px solid var(--border-blue);
        }
        
        .requirements-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark-blue);
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .requirement-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            font-size: 13px;
            color: var(--text-gray);
        }
        
        .requirement-item.valid {
            color: var(--success);
        }
        
        .requirement-item i {
            font-size: 12px;
        }
        
        .requirement-item.valid i {
            color: var(--success);
        }
        
        /* Submit Button */
        .btn-submit {
            width: 100%;
            height: 52px;
            background: linear-gradient(90deg, var(--primary-blue), var(--secondary-blue));
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
            margin-top: 25px;
            position: relative;
            overflow: hidden;
        }
        
        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        
        .btn-submit:hover::before {
            left: 100%;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        }
        
        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        /* Login Link */
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
        
        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
            cursor: pointer;
            font-size: 16px;
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            body {
                padding: 15px;
            }
            
            .reset-container {
                max-width: 100%;
            }
            
            .reset-card {
                padding: 25px 20px;
            }
            
            .logo-section h1 {
                font-size: 24px;
            }
            
            .card-header h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <!-- Logo Section -->
        <div class="logo-section">
            <div class="logo-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h1>MedPoint</h1>
            <p>Doctor Appointment Booking System</p>
        </div>
        
        <!-- Reset Card -->
        <div class="reset-card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-key"></i>
                    Reset Password
                </h2>
                <p>Create a new strong password for your account</p>
            </div>
            
            <?php if(isset($_SESSION['errmsg']) && !empty($_SESSION['errmsg'])): ?>
            <div class="alert-message alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $_SESSION['errmsg']; ?>
                <?php unset($_SESSION['errmsg']); ?>
            </div>
            <?php endif; ?>
            
            <form class="form-login" name="passwordreset" method="post">
                <!-- New Password -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock" style="margin-right: 5px;"></i>
                        New Password
                    </label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password" 
                               placeholder="Enter new password"
                               required
                               minlength="8"
                               onkeyup="checkPasswordStrength(this.value)">
                        <span class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div class="password-strength" id="passwordStrength">
                        <div class="strength-meter">
                            <div class="strength-fill"></div>
                        </div>
                        <div class="strength-text">Password strength: Weak</div>
                    </div>
                </div>
                
                <!-- Confirm Password -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock" style="margin-right: 5px;"></i>
                        Confirm Password
                    </label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               class="form-control" 
                               id="password_again" 
                               name="password_again" 
                               placeholder="Confirm new password"
                               required
                               minlength="8"
                               onkeyup="checkPasswordMatch()">
                        <span class="password-toggle" onclick="togglePassword('password_again')">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div id="passwordMatch" style="font-size: 12px; margin-top: 5px;"></div>
                </div>
                
                <!-- Password Requirements -->
                <div class="password-requirements">
                    <h6 class="requirements-title">
                        <i class="fas fa-info-circle"></i>
                        Password Requirements
                    </h6>
                    <div class="requirement-item" id="reqLength">
                        <i class="fas fa-circle"></i>
                        At least 8 characters
                    </div>
                    <div class="requirement-item" id="reqUppercase">
                        <i class="fas fa-circle"></i>
                        At least one uppercase letter
                    </div>
                    <div class="requirement-item" id="reqLowercase">
                        <i class="fas fa-circle"></i>
                        At least one lowercase letter
                    </div>
                    <div class="requirement-item" id="reqNumber">
                        <i class="fas fa-circle"></i>
                        At least one number
                    </div>
                    <div class="requirement-item" id="reqSpecial">
                        <i class="fas fa-circle"></i>
                        At least one special character
                    </div>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" 
                        class="btn-submit" 
                        name="change" 
                        id="submitBtn" 
                        disabled>
                    <i class="fas fa-redo"></i>
                    Change Password
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
    
    <script>
        // Password toggle function
        function togglePassword(fieldId) {
            var field = document.getElementById(fieldId);
            var icon = field.parentElement.querySelector('.password-toggle i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // Check password strength
        function checkPasswordStrength(password) {
            var strength = 0;
            var meter = document.querySelector('.strength-meter');
            var fill = document.querySelector('.strength-fill');
            var text = document.querySelector('.strength-text');
            
            // Requirements check
            checkRequirements(password);
            
            // Length check
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            
            // Character type checks
            if (/[A-Z]/.test(password)) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            // Update strength meter
            meter.className = 'strength-meter';
            if (strength <= 2) {
                meter.classList.add('strength-weak');
                text.textContent = 'Password strength: Weak';
            } else if (strength <= 4) {
                meter.classList.add('strength-medium');
                text.textContent = 'Password strength: Medium';
            } else {
                meter.classList.add('strength-strong');
                text.textContent = 'Password strength: Strong';
            }
            
            // Enable/disable submit button
            checkFormValidity();
        }
        
        // Check password requirements
        function checkRequirements(password) {
            var requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[^A-Za-z0-9]/.test(password)
            };
            
            // Update requirement indicators
            document.getElementById('reqLength').className = requirements.length ? 'requirement-item valid' : 'requirement-item';
            document.getElementById('reqUppercase').className = requirements.uppercase ? 'requirement-item valid' : 'requirement-item';
            document.getElementById('reqLowercase').className = requirements.lowercase ? 'requirement-item valid' : 'requirement-item';
            document.getElementById('reqNumber').className = requirements.number ? 'requirement-item valid' : 'requirement-item';
            document.getElementById('reqSpecial').className = requirements.special ? 'requirement-item valid' : 'requirement-item';
            
            // Update requirement icons
            updateRequirementIcon('reqLength', requirements.length);
            updateRequirementIcon('reqUppercase', requirements.uppercase);
            updateRequirementIcon('reqLowercase', requirements.lowercase);
            updateRequirementIcon('reqNumber', requirements.number);
            updateRequirementIcon('reqSpecial', requirements.special);
        }
        
        function updateRequirementIcon(elementId, isValid) {
            var icon = document.getElementById(elementId).querySelector('i');
            if (isValid) {
                icon.className = 'fas fa-check-circle';
            } else {
                icon.className = 'fas fa-circle';
            }
        }
        
        // Check if passwords match
        function checkPasswordMatch() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('password_again').value;
            var matchDiv = document.getElementById('passwordMatch');
            
            if (confirmPassword === '') {
                matchDiv.textContent = '';
                matchDiv.style.color = '';
            } else if (password === confirmPassword) {
                matchDiv.textContent = '✓ Passwords match';
                matchDiv.style.color = '#10b981';
            } else {
                matchDiv.textContent = '✗ Passwords do not match';
                matchDiv.style.color = '#ef4444';
            }
            
            checkFormValidity();
        }
        
        // Check form validity
        function checkFormValidity() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('password_again').value;
            var submitBtn = document.getElementById('submitBtn');
            
            // Check all requirements
            var requirementsMet = (
                password.length >= 8 &&
                /[A-Z]/.test(password) &&
                /[a-z]/.test(password) &&
                /[0-9]/.test(password) &&
                /[^A-Za-z0-9]/.test(password) &&
                password === confirmPassword
            );
            
            submitBtn.disabled = !requirementsMet;
        }
        
        // Form validation
        document.forms['passwordreset'].onsubmit = function() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('password_again').value;
            
            if (password !== confirmPassword) {
                alert("Password and Confirm Password do not match!");
                document.getElementById('password_again').focus();
                return false;
            }
            
            // Show loading state
            var submitBtn = document.getElementById('submitBtn');
            var originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Changing Password...';
            submitBtn.disabled = true;
            
            // Re-enable after 3 seconds if still on page (fallback)
            setTimeout(function() {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
            
            return true;
        };
        
        // Initialize form validation
        $(document).ready(function() {
            checkPasswordStrength('');
            checkPasswordMatch();
        });
    </script>
</body>
</html>