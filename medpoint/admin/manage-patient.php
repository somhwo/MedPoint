<?php
session_start();
error_reporting(0);
include('include/config.php');

// Check if admin is logged in, otherwise redirect to logout
if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | View Patients</title>
        
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
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
            /* --- Custom Blue Theme Variables (Matching Manage Doctors) --- */
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
                --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06);
                --shadow-md: 0 4px 12px rgba(37, 99, 235, 0.1);
            }
            
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: 'Poppins', sans-serif !important;
                background: var(--light-blue-bg);
                color: var(--text-primary);
                line-height: 1.6;
            }
            
            .main-content {
                background: var(--light-blue-bg);
                min-height: 100vh;
            }
            
            .wrap-content {
                padding: 30px 25px;
            }
            
            /* Page Header Section */
            #page-title {
                background: transparent;
                padding: 0;
                margin-bottom: 30px;
                border: none;
            }
            
            #page-title .mainTitle {
                color: var(--primary-blue);
                font-size: 36px;
                font-weight: 800;
                margin: 0 0 15px 0;
                letter-spacing: -0.5px;
                text-transform: uppercase;
            }
            
            /* Breadcrumbs - styled but cleaned up from previous template */
            .breadcrumb {
                background: transparent;
                padding: 0;
                margin: 0;
                display: flex;
                align-items: center;
                gap: 8px;
                list-style: none;
            }
            
            .breadcrumb li {
                color: var(--text-secondary);
                font-size: 14px;
                font-weight: 400;
            }
            
            .breadcrumb li.active {
                font-weight: 600;
                color: var(--primary-blue);
            }
            
            .breadcrumb li a {
                color: var(--text-light);
                text-decoration: none;
                transition: all 0.3s;
            }
            
            .breadcrumb li a:hover {
                color: var(--primary-blue);
            }
            
            .breadcrumb li + li:before {
                content: "/";
                margin: 0 8px;
                color: var(--text-light);
            }
            
            /* Main Card Container */
            .container-fluid.container-fullw.bg-white {
                background: white;
                border-radius: 20px;
                padding: 35px;
                box-shadow: var(--shadow-md);
                border: 1px solid var(--border-color);
            }
            
            .section-title {
                font-size: 20px;
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: 25px;
                padding-bottom: 0;
                border-bottom: none;
            }
            
            .section-title span {
                color: var(--primary-blue);
                font-weight: 700;
            }
            
            /* Table Container */
            .table-responsive {
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                border: 1px solid var(--border-color);
                margin-top: 20px;
            }
            
            /* Table Styling */
            .table {
                width: 100%;
                margin-bottom: 0;
                border-collapse: collapse;
            }
            
            .table thead {
                background: var(--primary-blue);
            }
            
            .table thead th {
                color: #FFFFFF !important; /* Fixed: Force white text */
                font-weight: 700; 
                padding: 16px 20px;
                border: none;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                font-size: 12px;
                white-space: nowrap;
                text-align: left;
            }
            
            .table thead th.center,
            .table thead th.text-center {
                text-align: center;
            }
            
            .table tbody tr {
                background: white;
                transition: all 0.2s ease;
                border-bottom: 1px solid #f1f5f9;
                /* Add subtle animation like in the other file */
                animation: fadeIn 0.4s ease forwards;
            }
            
            .table tbody tr:last-child {
                border-bottom: none;
            }
            
            .table tbody tr:hover {
                background: #f8fafc;
            }
            
            .table tbody td {
                padding: 16px 20px;
                border: none;
                color: var(--text-secondary);
                font-weight: 500;
                font-size: 14px;
                vertical-align: middle;
            }
            
            .table tbody td.center {
                text-align: center;
                font-weight: 600;
                color: var(--text-primary);
                font-size: 14px;
            }
            
            /* Action Buttons */
            .btn-action {
                background: var(--success); /* Green for View action */
                color: white;
                padding: 7px 18px;
                border-radius: 8px;
                font-weight: 600;
                font-size: 13px;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                border: none;
                cursor: pointer;
            }

            .btn-action:hover {
                background: #059669;
                transform: translateY(-1px);
                box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);
                text-decoration: none;
                color: white;
            }
            
            /* Responsive Design */
            @media (max-width: 768px) {
                .wrap-content { padding: 20px 15px; }
                #page-title .mainTitle { font-size: 28px; }
                .container-fluid.container-fullw.bg-white { padding: 20px; border-radius: 16px; }
                .section-title { font-size: 18px; }
                .table thead th { padding: 14px 12px; font-size: 11px; }
                .table tbody td { padding: 14px 12px; font-size: 13px; }
                .btn-action { width: 100%; justify-content: center; }
                
                /* Mobile Table Cards */
                .table thead { display: none; }
                .table tbody tr { 
                    display: block; 
                    margin-bottom: 20px; 
                    border-radius: 16px; 
                    box-shadow: var(--shadow-sm); 
                    border: 1px solid var(--border-color); 
                    overflow: hidden; 
                }
                .table tbody td { 
                    display: flex; 
                    justify-content: space-between; 
                    align-items: center; 
                    padding: 14px 16px; 
                    border-bottom: 1px solid var(--border-color); 
                    text-align: right; 
                }
                .table tbody td:last-child { border-bottom: none; }
                
                .table tbody td:before {
                    content: attr(data-label); 
                    font-weight: 700; 
                    color: var(--primary-blue);
                    text-align: left; 
                    flex: 1; 
                    padding-right: 15px;
                }
            }
            
            @media (max-width: 576px) {
                #page-title .mainTitle { font-size: 24px; }
            }

            /* Animation */
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .table tbody tr:nth-child(1) { animation-delay: 0.05s; }
            .table tbody tr:nth-child(2) { animation-delay: 0.1s; }
            .table tbody tr:nth-child(3) { animation-delay: 0.15s; }
            .table tbody tr:nth-child(4) { animation-delay: 0.2s; }
            .table tbody tr:nth-child(5) { animation-delay: 0.25s; }
            
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
                                    <li>
                                        <span>Admin</span>
                                    </li>
                                    <li class="active">
                                        <span>Patients</span>
                                    </li>
                                </ol>
                            </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="section-title">View <span class="text-bold">Patients</span></h5>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="sample-table-1">
                                            <thead>
                                                <tr>
                                                    <th class="center">#</th>
                                                    <th>Patient Name</th>
                                                    <th>Contact Number</th>
                                                    <th>Gender</th>
                                                    <th>Registration Date</th>
                                                    <th>Last Update</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql=mysqli_query($con,"select * from tblpatient");
                                                $cnt=1;
                                                $num_rows = mysqli_num_rows($sql);
                                                
                                                if($num_rows > 0) {
                                                    while($row=mysqli_fetch_array($sql)) {
                                                ?>
                                                <tr>
                                                    <td class="center" data-label="#"><?php echo $cnt;?>.</td>
                                                    <td data-label="Patient Name"><?php echo htmlentities($row['PatientName']);?></td>
                                                    <td data-label="Contact Number"><?php echo htmlentities($row['PatientContno']);?></td>
                                                    <td data-label="Gender"><?php echo htmlentities($row['PatientGender']);?></td>
                                                    <td data-label="Registration Date"><?php echo htmlentities($row['CreationDate']);?></td>
                                                    <td data-label="Last Update"><?php echo htmlentities($row['UpdationDate']);?></td>
                                                    <td data-label="Action" class="text-center">
                                                        <a href="view-patient.php?viewid=<?php echo $row['ID'];?>" class="btn-action" target="_blank">
                                                            <i class="fa fa-eye"></i> View Details
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php 
                                                    $cnt=$cnt+1;
                                                    }
                                                } else {
                                                ?>
                                                <tr>
                                                    <td colspan="7">
                                                        <div class="empty-state" style="text-align: center;">
                                                            <div style="font-size: 50px; color: var(--primary-blue); margin-bottom: 20px;">
                                                                <i class="fa fa-users"></i>
                                                            </div>
                                                            <h4>No Patients Found</h4>
                                                            <p style="color: var(--text-light);">There are currently no patients registered in the system.</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
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

                // Script to set data-label attribute for mobile responsiveness
                $('table thead th').each(function() {
                    var label = $(this).text();
                    $('table tbody td:nth-child(' + ($(this).index() + 1) + ')').attr('data-label', label);
                });
            });
        </script>
        </body>
</html>
<?php } ?>