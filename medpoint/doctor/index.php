<?php
session_start();
include("include/config.php");
error_reporting(0);

// --- NOTE ON SECURITY: ---
// The original code used MD5 for password hashing.
// MD5 is insecure. For a modern system, you should update your doctor registration
// process to use password_hash() and use password_verify() for checking.
// Since your existing database likely uses MD5, we keep it for functionality,
// but the strong recommendation is to migrate to Argon2 or Bcrypt.
// ------------------------

if (isset($_POST['submit'])) {
    $uname = $_POST['username'];
    $password = $_POST['password']; 
    $dpassword_md5 = md5($password); // Still using MD5 for compatibility with old database structure

    // 1. Prepare the SQL statement using placeholders (?)
    $stmt = $con->prepare("SELECT id, docEmail, password FROM doctors WHERE docEmail = ?");
    
    if ($stmt === false) {
        // Handle preparation error
        error_log("Prepare failed: " . htmlspecialchars($con->error));
        echo "<script>alert('A database error occurred during preparation.');</script>";
        echo "<script>window.location.href='index.php'</script>";
    } else {
        // 2. Bind parameters and execute the query
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $ret = $stmt->get_result();
        $num = $ret->fetch_assoc();
        
        if ($num) {
            // Check MD5 hash (Insecure but kept for compatibility)
            if ($num['password'] === $dpassword_md5) {
                // Successful Login
                $_SESSION['dlogin'] = $num['docEmail'];
                $_SESSION['id'] = $num['id'];
                
                $uid = $num['id'];
                $uip = $_SERVER['REMOTE_ADDR'];
                $status = 1;

                // Log successful login (using prepared statement for safety)
                $log_stmt = $con->prepare("INSERT INTO doctorslog(uid, username, userip, status) VALUES(?, ?, ?, ?)");
                $log_stmt->bind_param("isss", $uid, $uname, $uip, $status);
                $log_stmt->execute();
                $log_stmt->close();
                
                header("location:dashboard.php");
                exit();
            } else {
                // Invalid Password
                $uip = $_SERVER['REMOTE_ADDR'];
                $status = 0;
                
                // Log failed login
                $fail_stmt = $con->prepare("INSERT INTO doctorslog(username, userip, status) VALUES(?, ?, ?)");
                $fail_stmt->bind_param("ssi", $uname, $uip, $status);
                $fail_stmt->execute();
                $fail_stmt->close();
                
                $_SESSION['errmsg'] = "Invalid username or password";
                header("location:index.php");
                exit();
            }
        } else {
            // User not found
            $uip = $_SERVER['REMOTE_ADDR'];
            $status = 0;
            
            // Log failed login attempt
            $fail_stmt = $con->prepare("INSERT INTO doctorslog(username, userip, status) VALUES(?, ?, ?)");
            $fail_stmt->bind_param("ssi", $uname, $uip, $status);
            $fail_stmt->execute();
            $fail_stmt->close();
            
            $_SESSION['errmsg'] = "Invalid username or password";
            header("location:index.php");
            exit();
        }
        
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login | MedPoint</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link rel="stylesheet" href="vendor/animate.css/animate.min.css">
    <link rel="stylesheet" href="vendor/perfect-scrollbar/perfect-scrollbar.min.css">
    <link rel="stylesheet" href="vendor/switchery/switchery.min.css">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color">

    <style>
        /* ============================================
           CSS VARIABLES
        ============================================ */
        :root {
            --primary-blue: #007bff;
            --secondary-blue: #0056b3;
            --light-blue: #4da3ff;
            --background-color: #f0f4f8;
            --card-bg: #ffffff;
            --text-primary: #2c3e50;
            --text-secondary: #6c757d;
            --text-muted: #95a5a6;
            --border-color: #e1e8ed;
            --success: #28a745;
            --error: #dc3545;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 123, 255, 0.15);
            --shadow-lg: 0 10px 30px rgba(0, 123, 255, 0.2);
            --transition: all 0.3s ease;
        }

        /* ============================================
           GLOBAL STYLES
        ============================================ */
        * {
            font-family: 'Poppins', sans-serif !important;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body.login {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--light-blue) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Background Decorative Elements */
        body.login::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -200px;
            right: -200px;
            animation: float 20s infinite ease-in-out;
        }

        body.login::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -150px;
            left: -150px;
            animation: float 15s infinite ease-in-out reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }

        /* ============================================
           MAIN CONTAINER
        ============================================ */
        .row {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .main-login {
            background: transparent;
        }

        /* ============================================
           LOGO SECTION
        ============================================ */
        .logo {
            text-align: center;
            margin-bottom: 30px;
            animation: fadeInDown 0.6s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo a {
            text-decoration: none;
        }

        .logo h2 {
            font-size: 32px;
            font-weight: 800;
            color: white;
            margin: 0;
            padding: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            letter-spacing: -0.5px;
        }

        .logo h2 .divider {
            color: rgba(255, 255, 255, 0.5);
            font-weight: 300;
            margin: 0 8px;
        }

        /* ============================================
           LOGIN BOX
        ============================================ */
        .box-login {
            background: white;
            border-radius: 20px;
            padding: 45px;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============================================
           FORM ELEMENTS
        ============================================ */
        .box-login fieldset {
            border: none;
            padding: 0;
            margin: 0;
        }

        .box-login legend {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 10px;
            border: none;
            padding: 0;
            text-align: center;
        }

        .box-login > form > fieldset > p {
            color: var(--text-secondary);
            font-size: 14px;
            margin-bottom: 30px;
            text-align: center;
            line-height: 1.6;
            font-weight: 500;
        }

        /* Error Message */
        .error-message {
            background: #fee;
            color: var(--error);
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 600;
            border-left: 4px solid var(--error);
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* ============================================
           FORM GROUPS
        ============================================ */
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group.form-actions {
            margin-bottom: 0;
        }

        /* ============================================
           INPUT FIELDS
        ============================================ */
        .input-icon {
            display: block;
            position: relative;
        }

        .input-icon .form-control {
            width: 100%;
            padding: 16px 18px 16px 50px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 15px;
            font-weight: 500;
            color: var(--text-primary);
            transition: var(--transition);
            background: white;
            height: auto;
        }

        .input-icon .form-control:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
            background: white;
        }

        .input-icon .form-control::placeholder {
            color: var(--text-muted);
            font-weight: 400;
        }

        .input-icon i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 18px;
            z-index: 2;
            transition: var(--transition);
        }

        .input-icon .form-control:focus ~ i {
            color: var(--primary-blue);
        }

        /* ============================================
           FORGOT PASSWORD LINK
        ============================================ */
        .forgot-password-link {
            display: block;
            text-align: right;
            margin-top: 12px;
        }

        .forgot-password-link a {
            color: var(--primary-blue);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .forgot-password-link a:hover {
            color: var(--secondary-blue);
            text-decoration: underline;
        }

        /* ============================================
           SUBMIT BUTTON
        ============================================ */
        .form-actions {
            margin-top: 35px;
            text-align: center;
        }

        .btn-primary {
            width: 100%;
            background: var(--primary-blue);
            border: none;
            color: white;
            padding: 16px 30px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--secondary-blue);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary i {
            font-size: 18px;
        }

        /* ============================================
           COPYRIGHT
        ============================================ */
        .copyright {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 2px solid var(--border-color);
            text-align: center;
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 500;
        }

        .copyright .text-bold {
            font-weight: 700;
            color: var(--primary-blue);
        }

        /* ============================================
           MEDICAL ICON DECORATION
        ============================================ */
        .medical-icon {
            text-align: center;
            margin-bottom: 20px;
        }

        .medical-icon i {
            font-size: 50px;
            color: var(--primary-blue);
            opacity: 0.15;
        }

        /* ============================================
           RESPONSIVE DESIGN
        ============================================ */
        @media (max-width: 768px) {
            body.login {
                padding: 15px;
            }

            body.login::before,
            body.login::after {
                display: none;
            }

            .logo {
                margin-bottom: 25px;
            }

            .logo h2 {
                font-size: 26px;
            }

            .box-login {
                padding: 35px 25px;
                border-radius: 16px;
            }

            .box-login legend {
                font-size: 24px;
            }

            .input-icon .form-control {
                padding: 14px 16px 14px 46px;
                font-size: 14px;
            }

            .input-icon i {
                left: 16px;
                font-size: 16px;
            }

            .btn-primary {
                padding: 14px 25px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .logo h2 {
                font-size: 22px;
            }

            .box-login {
                padding: 30px 20px;
            }

            .box-login legend {
                font-size: 22px;
            }
        }

        /* ============================================
           LOADING STATE
        ============================================ */
        .btn-primary.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-primary.loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>

<body class="login">
    <div class="row">
        <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            
            <!-- Logo -->
            <div class="logo">
                <a href="../../index.php">
                    <h2>MedPoint <span class="divider">|</span> Doctor Login</h2>
                </a>
            </div>

            <!-- Login Box -->
            <div class="box-login">
                <!-- Medical Icon Decoration -->
                <div class="medical-icon">
                    <i class="fa fa-user-md"></i>
                </div>

                <form class="form-login" method="post" id="loginForm">
                    <fieldset>
                        <legend>Sign in to your account</legend>
                        <p>
                            Please enter your email and password to log in.
                        </p>

                        <!-- Error Message -->
                        <?php if (!empty($_SESSION['errmsg'])): ?>
                            <div class="error-message">
                                <i class="fa fa-exclamation-circle"></i> <?php echo htmlspecialchars($_SESSION['errmsg']); ?>
                            </div>
                            <?php $_SESSION['errmsg'] = ""; ?>
                        <?php endif; ?>

                        <!-- Email Input -->
                        <div class="form-group">
                            <span class="input-icon">
                                <input type="email" class="form-control" name="username" placeholder="Email (Registered Email)" required autocomplete="email">
                                <i class="fa fa-envelope"></i>
                            </span>
                        </div>

                        <!-- Password Input -->
                        <div class="form-group">
                            <span class="input-icon">
                                <input type="password" class="form-control password" name="password" placeholder="Password" required autocomplete="current-password">
                                <i class="fa fa-lock"></i>
                            </span>
                            <div class="forgot-password-link">
                                <a href="forgot-password.php">
                                    <i class="fa fa-question-circle"></i> Forgot Password?
                                </a>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary" name="submit" id="loginBtn">
                                Login <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </fieldset>
                </form>

                <!-- Copyright -->
                <div class="copyright">
                    <span class="text-bold text-uppercase">MedPoint</span> - Doctor Appointment Booking System<br>
                    &copy; <span class="current-year"></span> All rights reserved
                </div>
            </div>

        </div>
    </div>

    <!-- Vendor Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    
    <!-- Custom Scripts -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/login.js"></script>

    <script>
        jQuery(document).ready(function() {
            Main.init();
            Login.init();

            // Set current year
            $('.current-year').text(new Date().getFullYear());

            // Form validation
            $('#loginForm').validate({
                rules: {
                    username: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    username: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please enter your password",
                        minlength: "Password must be at least 6 characters"
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element.closest('.input-icon'));
                    error.css({
                        'color': '#dc3545',
                        'font-size': '12px',
                        'margin-top': '5px',
                        'display': 'block'
                    });
                }
            });

            // Loading state on form submit
            $('#loginForm').on('submit', function() {
                if ($(this).valid()) {
                    $('#loginBtn').addClass('loading').prop('disabled', true);
                }
            });

            // Auto-hide error message after 5 seconds
            setTimeout(function() {
                $('.error-message').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>
</html>