<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {

    // Processing submission for adding medical history
    if(isset($_POST['submit'])) {
        
        $vid = intval($_GET['viewid']); // Ensure viewid is the patient ID
        $bp = $_POST['bp'];
        $bs = $_POST['bs'];
        $weight = $_POST['weight'];
        $temp = $_POST['temp'];
        $pres = $_POST['pres'];
        
        // Use prepared statement principles for basic security (though still using mysqli_query for simplicity)
        $query = mysqli_query($con, "insert into tblmedicalhistory(PatientID,BloodPressure,BloodSugar,Weight,Temperature,MedicalPres) value('$vid','$bp','$bs','$weight','$temp','$pres')");
        
        if ($query) {
            echo '<script>alert("Medical history has been added successfully.");</script>';
            // Redirect back to the same patient's detail page to show the update
            echo "<script>window.location.href ='view-patient.php?viewid=$vid'</script>";
        } else {
            echo '<script>alert("Something Went Wrong. Please try again: ' . mysqli_error($con) . '")</script>';
        }

    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | Manage Patients</title>
        
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
        <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
        <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
        <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
        <link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
        <link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
        <link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
        <link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/plugins.css">
        <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />

        <style>
            /* --- Custom Blue Theme Variables --- */
            :root {
                --primary-blue: #2563eb;
                --primary-dark: #1e40af;
                --primary-light: #3b82f6;
                --light-blue-bg: #eff6ff;
                --card-bg: #ffffff;
                --text-primary: #1e293b;
                --text-secondary: #475569;
                --text-light: #64748b;
                --border-color: #e2e8f0;
                --success: #10b981;
                --danger: #ef4444;
                --shadow-md: 0 4px 12px rgba(37, 99, 235, 0.1);
            }
            
            * {
                font-family: 'Poppins', sans-serif !important;
            }
            
            body { background: var(--light-blue-bg); color: var(--text-primary); }
            .main-content { background: var(--light-blue-bg); }
            .wrap-content { padding: 30px 25px; }
            
            /* Page Title - Consistent Style */
            #page-title { background: transparent; padding: 0 0 30px 0; border: none; }
            #page-title .mainTitle {
                color: var(--primary-blue); font-size: 36px; font-weight: 800; margin: 0 0 15px 0;
                letter-spacing: -0.5px; text-transform: uppercase;
                background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
                -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            }
            
            /* Breadcrumbs */
            .breadcrumb { background: transparent; padding: 0; margin: 0; list-style: none; }
            .breadcrumb li { color: var(--text-secondary); font-size: 14px; }
            .breadcrumb li.active { font-weight: 600; color: var(--primary-blue); }
            .breadcrumb li + li:before { content: "/"; margin: 0 8px; color: var(--text-light); }


            /* Main Card Container */
            .container-fluid.container-fullw.bg-white {
                background: white; border-radius: 20px; padding: 35px;
                box-shadow: var(--shadow-md); border: 1px solid var(--border-color);
                margin-bottom: 30px;
            }
            
            .section-title, .data-card-title {
                font-size: 22px; font-weight: 700; color: var(--text-primary);
                margin-bottom: 30px; padding-bottom: 15px; border-bottom: 2px solid var(--border-color);
                display: flex; align-items: center; gap: 10px;
            }
            .data-card-title i { color: var(--primary-blue); font-size: 24px; }

            /* =======================================
               DETAIL CARD (Patient Info)
               ======================================= */
            .table-details {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                border: 1px solid var(--border-color);
                margin-top: 20px;
                margin-bottom: 30px;
            }
            
            /* Table Caption/Title */
            .table-details tr.title-row td {
                background: var(--primary-dark);
                color: white;
                font-size: 20px;
                font-weight: 600;
                text-align: center;
                padding: 15px;
            }
            
            /* Header (Left Column) */
            .table-details th {
                background: var(--light-blue-bg);
                color: var(--primary-dark);
                font-weight: 600;
                padding: 14px 20px;
                border-right: 1px solid var(--border-color);
                width: 25%; /* Set width for consistent layout */
                vertical-align: middle;
                font-size: 14px;
            }
            
            /* Data Cell (Right Column) */
            .table-details td {
                background: var(--card-bg);
                color: var(--text-primary);
                font-weight: 500;
                padding: 14px 20px;
                vertical-align: middle;
                font-size: 14px;
            }

            /* Horizontal Dividers */
            .table-details tr:not(:last-child) th,
            .table-details tr:not(:last-child) td {
                border-bottom: 1px solid var(--border-color);
            }
            
            /* =======================================
               MEDICAL HISTORY TABLE
               ======================================= */
            .med-history-table {
                width: 100%;
                margin-top: 20px;
                border-collapse: separate;
                border-spacing: 0;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                border: 1px solid var(--border-color);
            }

            /* Dark Blue Header Row for Medical History Table */
            .med-history-table thead, .med-history-table tr.med-history-header { 
                background: var(--primary-dark); 
            } 
            
            .med-history-table th {
                color: #FFFFFF !important; 
                font-weight: 700; padding: 16px 20px;
                border: none; text-transform: uppercase; letter-spacing: 0.8px; 
                font-size: 12px; white-space: nowrap; text-align: left;
            }

            .med-history-table tbody tr { background: white; transition: all 0.2s ease; border-bottom: 1px solid #f1f5f9; }
            .med-history-table tbody tr:hover { background: var(--light-blue-bg); }
            
            .med-history-table td {
                padding: 14px 20px; border: none; color: var(--text-secondary); font-weight: 500;
                font-size: 13px; vertical-align: middle;
            }
            .med-history-table td:first-child { font-weight: 600; color: var(--primary-blue); }

            /* =======================================
               ADD HISTORY FORM
               ======================================= */
            .form-add-history {
                margin-top: 30px;
                padding: 30px;
                border: 1px solid var(--border-color);
                border-radius: 15px;
                background: var(--light-blue-bg);
            }

            .form-add-history label {
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: 8px;
            }
            .form-add-history .form-control {
                border-radius: 8px;
                border: 1px solid var(--border-color);
                padding: 10px 15px;
            }
            
            /* Submit Button */
            .btn-submit {
                background: var(--success);
                color: white;
                padding: 10px 25px;
                border-radius: 8px;
                font-weight: 600;
                font-size: 14px;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                margin-top: 20px;
            }
            .btn-submit:hover {
                background: #059669;
                transform: translateY(-1px);
            }


            /* =======================================
               RESPONSIVENESS
               ======================================= */
            @media (max-width: 768px) {
                .wrap-content { padding: 20px 15px; }
                #page-title .mainTitle { font-size: 28px; }

                /* Detail Tables Stack on Mobile */
                .table-details, .table-details tr, .table-details th, .table-details td {
                    display: block; width: 100%;
                }
                .table-details tr { margin-bottom: 10px; }
                .table-details th { 
                    border-right: none; 
                    background: var(--primary-light); 
                    color: white;
                    font-size: 12px;
                    text-transform: uppercase;
                    font-weight: 700;
                }
                .table-details td { border-bottom: 1px solid var(--border-color); }
                .table-details tr.title-row td { font-size: 18px; }
                .table-details tr:last-child td:last-child { border-bottom: none; }
                .table-details tr:last-child th:last-child { border-bottom: none; }
                
                /* Medical History Table Scrolls on Mobile */
                .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
                .med-history-table { min-width: 800px; }
                
                .form-add-history { padding: 20px; }
            }
        </style>
    </head>
    <body>
        <div id="app">      
            <?php include('include/sidebar.php');?>
            <div class="app-content">
                <?php include('include/header.php');?>
                <div class="main-content" >
                    <div class="wrap-content container" id="container">
                        
                        <section id="page-title">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h1 class="mainTitle">Manage Patients</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><span>Doctor</span></li>
                                    <li class="active"><span>Manage Patients</span></li>
                                </ol>
                            </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="data-card-title">
                                        <i class="fa fa-user"></i> Patient Records
                                    </h5>
                                    
                                    <?php
                                    $vid = intval($_GET['viewid']);
                                    $ret = mysqli_query($con, "select * from tblpatient where ID='$vid'");
                                    
                                    while ($row = mysqli_fetch_array($ret)) {
                                    ?>
                                    <table class="table table-details">
                                        <thead>
                                            <tr class="title-row">
                                                <td colspan="4">Patient Details (Reg. ID: <?php echo $vid; ?>)</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Patient Name</th>
                                                <td><?php echo htmlentities($row['PatientName']);?></td>
                                                <th>Patient Email</th>
                                                <td><?php echo htmlentities($row['PatientEmail']);?></td>
                                            </tr>
                                            <tr>
                                                <th>Patient Mobile Number</th>
                                                <td><?php echo htmlentities($row['PatientContno']);?></td>
                                                <th>Patient Address</th>
                                                <td><?php echo htmlentities($row['PatientAdd']);?></td>
                                            </tr>
                                            <tr>
                                                <th>Patient Gender</th>
                                                <td><?php echo htmlentities($row['PatientGender']);?></td>
                                                <th>Patient Age</th>
                                                <td><?php echo htmlentities($row['PatientAge']);?></td>
                                            </tr>
                                            <tr>
                                                <th>Patient Medical History (if any)</th>
                                                <td><?php echo htmlentities($row['PatientMedhis']);?></td>
                                                <th>Patient Reg Date</th>
                                                <td><?php echo htmlentities($row['CreationDate']);?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php }?>

                                    <h5 class="data-card-title">
                                        <i class="fa fa-clipboard"></i> Medical History Log
                                    </h5>
                                    
                                    <?php 
                                    $ret = mysqli_query($con, "select * from tblmedicalhistory where PatientID='$vid' ORDER BY CreationDate DESC");
                                    $has_history = (mysqli_num_rows($ret) > 0);
                                    ?>
                                    
                                    <div class="table-responsive">
                                        <table class="table med-history-table">
                                            <thead>
                                                <tr class="med-history-header">
                                                    <th>#</th>
                                                    <th>Visit Date</th>
                                                    <th>Blood Pressure</th>
                                                    <th>Blood Sugar</th>
                                                    <th>Weight (kg)</th>
                                                    <th>Temp (&deg;C/&deg;F)</th>
                                                    <th>Medical Prescription</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            if ($has_history) {
                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($ret)) { 
                                            ?>
                                                <tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td><?php echo htmlentities($row['CreationDate']);?></td>
                                                    <td><?php echo htmlentities($row['BloodPressure']);?></td>
                                                    <td><?php echo htmlentities($row['BloodSugar']);?></td> 
                                                    <td><?php echo htmlentities($row['Weight']);?></td>
                                                    <td><?php echo htmlentities($row['Temperature']);?></td>
                                                    <td><?php echo htmlentities($row['MedicalPres']);?></td> 
                                                </tr>
                                            <?php 
                                                $cnt++;
                                                }
                                            } else { 
                                            ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">No medical history recorded yet.</td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <hr style="margin-top: 40px;">
                                    
                                    <h5 class="data-card-title">
                                        <i class="fa fa-plus-circle"></i> Add New Medical History
                                    </h5>
                                    
                                    <div class="form-add-history">
                                        <form method="post" name="submit">
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="bp">Blood Pressure</label>
                                                    <input type="text" class="form-control" name="bp" placeholder="e.g., 120/80 mmHg" required>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="bs">Blood Sugar</label>
                                                    <input type="text" class="form-control" name="bs" placeholder="e.g., 90 mg/dL" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="weight">Weight (in kg/lbs)</label>
                                                    <input type="text" class="form-control" name="weight" placeholder="e.g., 75 kg" required>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="temp">Body Temperature</label>
                                                    <input type="text" class="form-control" name="temp" placeholder="e.g., 98.6 F" required>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="pres">Medical Prescription</label>
                                                    <textarea name="pres" class="form-control" rows="1" placeholder="Enter brief prescription" required></textarea>
                                                </div>
                                            </div>
                                            <button type="submit" name="submit" class="btn btn-submit">
                                                <i class="fa fa-save"></i> Save History
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include('include/setting.php');?>
        
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
        <script src="assets/js/main.js"></script>
        <script src="assets/js/form-elements.js"></script>
        <script>
            jQuery(document).ready(function() {
                Main.init();
                FormElements.init();
            });
        </script>
    </body>
</html>
<?php } ?>