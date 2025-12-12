<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | User Session Logs</title>
        
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
                --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06);
                --shadow-md: 0 4px 12px rgba(37, 99, 235, 0.1);
                --transition: all 0.3s ease;
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
            
            /* Breadcrumbs Removed */
            .breadcrumb { display: none; }

            /* Main Card Container */
            .container-fluid.container-fullw.bg-white {
                background: white; border-radius: 20px; padding: 35px;
                box-shadow: var(--shadow-md); border: 1px solid var(--border-color);
            }
            
            /* Section Title */
            .section-title {
                font-size: 22px; font-weight: 700; color: var(--text-primary);
                margin-bottom: 30px; padding-bottom: 15px; border-bottom: 2px solid var(--border-color);
                display: flex; align-items: center; gap: 10px;
            }
            .section-title i { color: var(--primary-blue); font-size: 24px; }
            .section-title .text-bold { color: var(--primary-blue); font-weight: 700; }
            
            /* Table Container */
            .table-responsive {
                border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                border: 1px solid var(--border-color); margin-top: 20px;
            }
            
            /* Table Styling */
            .table { width: 100%; margin-bottom: 0; border-collapse: collapse; }
            
            /* Table Header */
            .table thead { 
                background: var(--card-bg); /* Light Header Background */
                border-bottom: 2px solid var(--border-color);
            } 
            
            .table thead th {
                color: var(--text-secondary) !important; /* Dark Gray text */
                font-weight: 600; 
                padding: 18px 20px;
                border: none; text-transform: uppercase; letter-spacing: 0.5px; 
                font-size: 12px; white-space: nowrap; text-align: left;
            }
            
            .table thead th.center { text-align: center; }
            
            /* Table Body */
            .table tbody tr { background: white; transition: all 0.2s ease; border-bottom: 1px solid #f1f5f9; }
            .table tbody tr:hover { background: var(--light-blue-bg); }
            
            .table tbody td {
                padding: 16px 20px; border: none; color: var(--text-secondary); font-weight: 500;
                font-size: 14px; vertical-align: middle;
            }
            
            .table tbody td.center { font-weight: 600; color: var(--primary-blue); font-size: 14px; text-align: center; }

            /* Status Badges */
            .status-badge {
                display: inline-block;
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .status-success {
                background: #d1fae5; /* Light Green */
                color: var(--success);
            }
            .status-failed {
                background: #fee2e2; /* Light Red */
                color: var(--danger);
            }
            
            /* Empty State */
            .empty-state { text-align: center; padding: 60px 20px; }
            .empty-state i { font-size: 50px; color: var(--border-color); margin-bottom: 20px; display: block; }
            .empty-state h4 { color: var(--text-primary); font-size: 20px; font-weight: 700; margin-bottom: 12px; }
            .empty-state p { color: var(--text-light); font-size: 14px; margin: 0; }

            /* Responsive Design (Mobile Card Layout) */
            @media (max-width: 768px) {
                .wrap-content { padding: 20px 15px; }
                #page-title .mainTitle { font-size: 28px; }
                .container-fluid.container-fullw.bg-white { padding: 20px; border-radius: 16px; }
                .section-title { font-size: 18px; }

                .table thead { display: none; }
                .table-responsive { border: none; box-shadow: none; }
                
                .table tbody tr {
                    display: block; margin-bottom: 15px; border-radius: 12px;
                    box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);
                    overflow: hidden;
                }
                
                .table tbody td {
                    display: flex; justify-content: space-between; align-items: center;
                    padding: 14px 16px; border-bottom: 1px solid var(--border-color);
                    text-align: right;
                }
                
                .table tbody td:last-child { border-bottom: none; }
                
                .table tbody td:before {
                    content: attr(data-label); font-weight: 700; color: var(--primary-blue);
                    text-align: left; flex: 1; padding-right: 15px;
                }
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
                                <div class="col-sm-12">
                                    <h1 class="mainTitle">User Session Logs</h1>
                                </div>
                                </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <h5 class="section-title">
                                        <i class="fa fa-history"></i> Manage <span class="text-bold">User Session Logs</span>
                                    </h5>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="sample-table-1">
                                            <thead>
                                                <tr>
                                                    <th class="center">#</th>
                                                    <th class="hidden-xs">User ID</th>
                                                    <th>Username</th>
                                                    <th>Login Time</th>
                                                    <th>Logout Time</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $sql=mysqli_query($con,"select * from userlog ORDER BY loginTime DESC");
                                            $cnt=1;
                                            $num_rows = mysqli_num_rows($sql);
                                            
                                            if ($num_rows > 0) {
                                                while($row=mysqli_fetch_array($sql))
                                                {
                                            ?>
                                                <tr>
                                                    <td class="center" data-label="#">
                                                        <?php echo $cnt;?>
                                                    </td>
                                                    <td class="hidden-xs" data-label="User ID">
                                                        <?php echo htmlentities($row['uid']);?>
                                                    </td>
                                                    <td class="hidden-xs" data-label="Username">
                                                        <?php echo htmlentities($row['username']);?>
                                                    </td>
                                                    <td data-label="Login Time">
                                                        <?php echo htmlentities($row['loginTime']);?>
                                                    </td>
                                                    <td data-label="Logout Time">
                                                        <?php 
                                                        // Display logout time, or 'N/A' if empty/null
                                                        echo !empty($row['logout']) ? htmlentities($row['logout']) : 'N/A';
                                                        ?>
                                                    </td>
                                                    <td data-label="Status" class="text-center">
                                                        <?php if($row['status']==1)
                                                        { ?>
                                                            <span class="status-badge status-success">Success</span>
                                                        <?php } else { ?>
                                                            <span class="status-badge status-failed">Failed</span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                
                                                <?php 
                                                $cnt=$cnt+1;
                                                }
                                            } else {
                                            ?>
                                                <tr>
                                                    <td colspan="6">
                                                        <div class="empty-state">
                                                            <i class="fa fa-terminal"></i>
                                                            <h4>No Session Logs Found</h4>
                                                            <p>There is no user log data to display.</p>
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
            <?php include('include/setting.php');?>
            </div>
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

                // Add data-label attributes for mobile responsiveness
                $('table thead th').each(function(index) {
                    var label = $(this).text().trim();
                    // Adjusted index due to removed column, but using .each should handle it correctly
                    $('table tbody td:nth-child(' + (index + 1) + ')').attr('data-label', label);
                });
            });
        </script>
        </body>
</html>
<?php } ?>