<?php
session_start();
error_reporting(0);
include('include/config.php');

// Check if the user is logged in (Doctor ID is set)
if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
    exit();
} else {

    if (isset($_POST['submit'])) {
        $docid = $_SESSION['id'];
        // --- Input from Form ---
        $patname = $_POST['patname'];
        $patcontact = $_POST['patcontact'];
        $patemail = $_POST['patemail'];
        $gender = $_POST['gender'];
        $pataddress = $_POST['pataddress'];
        $patage = $_POST['patage'];
        $medhis = $_POST['medhis'];

        // --- SECURITY FIX: Using Prepared Statements for safe insertion ---
        $sql = "INSERT INTO tblpatient(Docid, PatientName, PatientContno, PatientEmail, PatientGender, PatientAdd, PatientAge, PatientMedhis) 
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        
        // 1. Prepare the statement
        $stmt = $con->prepare($sql);

        if ($stmt === false) {
            // Handle preparation error
            error_log("Prepare failed: " . htmlspecialchars($con->error));
            echo "<script>alert('A database error occurred during preparation.');</script>";
        } else {
            // 2. Bind parameters (i: integer, s: string)
            $stmt->bind_param("isssisss", $docid, $patname, $patcontact, $patemail, $gender, $pataddress, $patage, $medhis);
            
            // 3. Execute the statement
            if ($stmt->execute()) {
                // Success
                echo "<script>alert('Patient info added Successfully');</script>";
                echo "<script>window.location.href ='manage-patient.php'</script>";
            } else {
                // Failure
                error_log("Execute failed: " . htmlspecialchars($stmt->error));
                echo "<script>alert('Error adding patient information');</script>";
            }
            // 4. Close the statement
            $stmt->close();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor | Add Patient</title>
    
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
           CSS VARIABLES - Matching MedPoint Design
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
           PAGE HEADER - Matching "MANAGE USERS" Style
        ============================================ */
        #page-title {
            background: transparent;
            padding: 0 0 30px 0;
            border: none;
            margin-bottom: 0;
        }

        #page-title .page-title-text {
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

        .form-control,
        textarea.form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
            transition: var(--transition);
            background: white;
            height: auto;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .form-control:focus,
        textarea.form-control:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-control::placeholder {
            color: var(--text-light);
        }

        /* ============================================
           RADIO BUTTONS
        ============================================ */
        .clip-radio {
            display: flex;
            gap: 25px;
            align-items: center;
            padding-top: 5px;
        }

        .clip-radio input[type="radio"] {
            display: none;
        }

        .clip-radio label {
            position: relative;
            padding-left: 32px;
            cursor: pointer;
            font-weight: 500;
            color: var(--text-secondary);
            font-size: 14px;
            margin: 0;
        }

        .clip-radio label:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid var(--border-color);
            border-radius: 50%;
            background: white;
            transition: var(--transition);
        }

        .clip-radio label:after {
            content: '';
            position: absolute;
            left: 6px;
            top: 50%;
            transform: translateY(-50%) scale(0);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary-blue);
            transition: var(--transition);
        }

        .clip-radio input[type="radio"]:checked + label:before {
            border-color: var(--primary-blue);
        }

        .clip-radio input[type="radio"]:checked + label:after {
            transform: translateY(-50%) scale(1);
        }

        .clip-radio input[type="radio"]:checked + label {
            color: var(--primary-blue);
            font-weight: 600;
        }

        /* ============================================
           EMAIL AVAILABILITY STATUS
        ============================================ */
        #user-availability-status1 {
            display: block;
            margin-top: 8px;
            font-size: 12px;
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

            #page-title .page-title-text {
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

            .clip-radio {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
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
            #page-title .page-title-text {
                font-size: 24px;
            }

            .panel-heading {
                padding: 15px;
            }

            .panel-body {
                padding: 20px 15px;
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

        /* ============================================
           VALIDATION MESSAGES
        ============================================ */
        .error {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
            font-weight: 600;
        }

        .form-control.error {
            border-color: #dc3545;
        }

        .form-control.valid {
            border-color: var(--success);
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
                                <h1 class="page-title-text">ADD PATIENT</h1>
                            </div>
                        </div>
                    </section>

                    <!-- Main Content Card -->
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">

                                <!-- Form Panel -->
                                <div class="row">
                                    <div class="col-lg-8 col-md-10 mx-auto">
                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h5 class="panel-title">Patient Details Form</h5>
                                            </div>
                                            <div class="panel-body">
                                                <form role="form" name="addpat" id="addPatientForm" method="post">

                                                    <!-- Patient Full Name -->
                                                    <div class="form-group">
                                                        <label for="patname">Patient Full Name <span style="color: red;">*</span></label>
                                                        <input type="text" name="patname" id="patname" class="form-control" placeholder="Enter Patient Name" required>
                                                    </div>

                                                    <!-- Patient Contact Number -->
                                                    <div class="form-group">
                                                        <label for="patcontact">Patient Contact No. <span style="color: red;">*</span></label>
                                                        <input type="text" name="patcontact" id="patcontact" class="form-control" placeholder="Enter Patient Contact no" required maxlength="10" pattern="[0-9]{10}">
                                                    </div>

                                                    <!-- Patient Email -->
                                                    <div class="form-group">
                                                        <label for="patemail">Patient Email <span style="color: red;">*</span></label>
                                                        <input type="email" id="patemail" name="patemail" class="form-control" placeholder="Enter Patient Email id" required onBlur="userAvailability()">
                                                        <span id="user-availability-status1"></span>
                                                    </div>

                                                    <!-- Gender -->
                                                    <div class="form-group">
                                                        <label class="block">Gender <span style="color: red;">*</span></label>
                                                        <div class="clip-radio radio-primary">
                                                            <input type="radio" id="rg-female" name="gender" value="female" required>
                                                            <label for="rg-female">Female</label>
                                                            <input type="radio" id="rg-male" name="gender" value="male">
                                                            <label for="rg-male">Male</label>
                                                        </div>
                                                    </div>

                                                    <!-- Patient Address -->
                                                    <div class="form-group">
                                                        <label for="pataddress">Patient Address <span style="color: red;">*</span></label>
                                                        <textarea name="pataddress" id="pataddress" class="form-control" placeholder="Enter Patient Address" required></textarea>
                                                    </div>

                                                    <!-- Patient Age -->
                                                    <div class="form-group">
                                                        <label for="patage">Patient Age <span style="color: red;">*</span></label>
                                                        <input type="number" name="patage" id="patage" class="form-control" placeholder="Enter Patient Age" required min="1" max="150">
                                                    </div>

                                                    <!-- Medical History -->
                                                    <div class="form-group">
                                                        <label for="medhis">Medical History <span style="color: red;">*</span></label>
                                                        <textarea name="medhis" id="medhis" class="form-control" placeholder="Enter Patient Medical History (if any)" required></textarea>
                                                    </div>

                                                    <!-- Submit Button -->
                                                    <div class="form-actions">
                                                        <button type="submit" name="submit" id="submit" class="btn btn-primary">
                                                            <i class="fa fa-check"></i> Add Patient
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
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    
    <!-- Custom Scripts -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/form-elements.js"></script>

    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();

            // Form validation
            $('#addPatientForm').validate({
                rules: {
                    patname: {
                        required: true,
                        minlength: 3
                    },
                    patcontact: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    patemail: {
                        required: true,
                        email: true
                    },
                    gender: {
                        required: true
                    },
                    pataddress: {
                        required: true,
                        minlength: 10
                    },
                    patage: {
                        required: true,
                        number: true,
                        min: 1,
                        max: 150
                    },
                    medhis: {
                        required: true,
                        minlength: 5
                    }
                },
                messages: {
                    patname: {
                        required: "Please enter patient name",
                        minlength: "Name must be at least 3 characters"
                    },
                    patcontact: {
                        required: "Please enter contact number",
                        digits: "Please enter only numbers",
                        minlength: "Contact number must be 10 digits",
                        maxlength: "Contact number must be 10 digits"
                    },
                    patemail: {
                        required: "Please enter email address",
                        email: "Please enter a valid email address"
                    },
                    gender: {
                        required: "Please select gender"
                    },
                    pataddress: {
                        required: "Please enter address",
                        minlength: "Address must be at least 10 characters"
                    },
                    patage: {
                        required: "Please enter age",
                        number: "Please enter a valid age",
                        min: "Age must be at least 1",
                        max: "Age must not exceed 150"
                    },
                    medhis: {
                        required: "Please enter medical history",
                        minlength: "Medical history must be at least 5 characters"
                    }
                }
            });

            // Loading state on form submit
            $('#addPatientForm').on('submit', function() {
                if ($(this).valid()) {
                    $('#submit').addClass('loading').prop('disabled', true);
                }
            });
        });

        // Check email availability
        function userAvailability() {
            var email = $("#patemail").val();
            if (email.length > 0) {
                jQuery.ajax({
                    url: "check_availability.php",
                    data: 'email=' + email,
                    type: "POST",
                    success: function(data) {
                        $("#user-availability-status1").html(data);
                    },
                    error: function() {
                        $("#user-availability-status1").html('<span style="color: red;">Error checking availability</span>');
                    }
                });
            }
        }
    </script>
</body>
</html>
<?php } ?>