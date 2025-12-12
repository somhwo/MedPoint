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
        <title>Admin | Search Patient</title>
        
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
            }
            
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
            
            /* Page Title - Matching Dashboard Style */
            #page-title {
                background: transparent;
                padding: 0 0 30px 0;
                border: none;
            }
            
            #page-title .mainTitle {
                color: var(--primary-blue);
                font-size: 36px;
                font-weight: 800;
                margin: 0 0 15px 0;
                letter-spacing: -0.5px;
                text-transform: uppercase;
                background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            /* Breadcrumb Removed (keeping style rules for completeness) */
            .breadcrumb {
                display: none; 
            }
            
            /* Main Card Container */
            .container-fluid.container-fullw.bg-white {
                background: white;
                border-radius: 20px;
                padding: 35px;
                box-shadow: var(--shadow-md);
                border: 1px solid var(--border-color);
            }

            /* Search Form Styling */
            .form-group {
                margin-bottom: 20px;
            }
            
            .form-control {
                border-radius: 8px;
                padding: 10px 15px;
                border: 1px solid var(--border-color);
                box-shadow: var(--shadow-sm);
                transition: all 0.3s ease;
            }
            
            .form-control:focus {
                border-color: var(--primary-light);
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            }

            /* Search Button */
            .btn-search {
                background: var(--primary-blue);
                color: white;
                border: none;
                padding: 10px 25px;
                border-radius: 8px;
                font-weight: 600;
                font-size: 14px;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
            }

            .btn-search:hover {
                background: var(--primary-dark);
                transform: translateY(-1px);
                color: white;
            }
            
            /* Table Section Title */
            h4[align="center"] {
                color: var(--text-primary);
                font-size: 20px;
                font-weight: 600;
                margin: 30px 0 20px 0;
                padding-bottom: 10px;
                border-bottom: 2px solid var(--primary-light);
                display: inline-block;
            }

            /* Table Styling */
            .table-responsive {
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                border: 1px solid var(--border-color);
                margin-top: 20px;
            }
            
            .table {
                width: 100%;
                margin-bottom: 0;
                border-collapse: collapse;
            }
            
            .table thead {
                background: var(--primary-dark);
            }
            
            .table thead th {
                color: #FFFFFF !important;
                font-weight: 700; 
                padding: 16px 20px;
                border: none;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                font-size: 12px;
                white-space: nowrap;
                text-align: left;
            }
            
            .table thead th.center {
                text-align: center;
            }
            
            .table tbody tr {
                background: white;
                transition: all 0.2s ease;
                border-bottom: 1px solid #f1f5f9;
            }
            
            .table tbody tr:hover {
                background: var(--light-blue-bg);
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
                color: var(--primary-blue);
                font-size: 14px;
            }
            
            /* Action Button (View) */
            .btn-view {
                background: var(--success);
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

            .btn-view:hover {
                background: #059669;
                transform: translateY(-1px);
                color: white;
            }
            
            /* No Record Found Row */
            .no-record {
                text-align: center;
                font-weight: 500;
                color: var(--danger);
                padding: 30px !important;
                background: #fff0f0;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .wrap-content { padding: 20px 15px; }
                #page-title .mainTitle { font-size: 28px; }
                .container-fluid.container-fullw.bg-white { padding: 20px; border-radius: 16px; }

                /* Mobile Table Cards */
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
                
                .table tbody td:last-child {
                    border-bottom: none; justify-content: center; padding: 16px;
                }
                
                .table tbody td:before {
                    content: attr(data-label); font-weight: 700; color: var(--primary-blue);
                    text-align: left; flex: 1; padding-right: 15px;
                }
                
                .btn-view { width: 100%; justify-content: center; }
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
                                    <h1 class="mainTitle">Search Patients</h1>
                                </div>
                                </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <form role="form" method="post" name="search">
                                        
                                        <h5 class="section-title">Search <span class="text-bold">Patient Records</span></h5>

                                        <div class="form-group">
                                            <input type="text" name="searchdata" id="searchdata" class="form-control" value="" required='true' placeholder="Enter patient name or mobile number">
                                        </div>

                                        <button type="submit" name="search" id="submit" class="btn btn-search">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </form>
                                    
                                    <?php
                                    if(isset($_POST['search']))
                                    { 
                                        $sdata=$_POST['searchdata'];
                                    ?>
                                    <h4 align="center">Results for "<?php echo htmlentities($sdata);?>" </h4>
                                    
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
                                            $sql=mysqli_query($con,"select * from tblpatient where PatientName like '%$sdata%' OR PatientContno like '%$sdata%'");
                                            $num=mysqli_num_rows($sql);
                                            
                                            if($num > 0) {
                                                $cnt=1;
                                                while($row=mysqli_fetch_array($sql))
                                                {
                                            ?>
                                                <tr>
                                                    <td class="center" data-label="#"><?php echo $cnt;?>.</td>
                                                    <td data-label="Patient Name"><?php echo htmlentities($row['PatientName']);?></td>
                                                    <td data-label="Contact Number"><?php echo htmlentities($row['PatientContno']);?></td>
                                                    <td data-label="Gender"><?php echo htmlentities($row['PatientGender']);?></td>
                                                    <td data-label="Registration Date"><?php echo htmlentities($row['CreationDate']);?></td>
                                                    <td data-label="Last Update"><?php echo htmlentities($row['UpdationDate']);?></td>
                                                    <td data-label="Action" class="text-center">
                                                        <a href="view-patient.php?viewid=<?php echo $row['ID'];?>" class="btn-view" target="_blank">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php 
                                                $cnt=$cnt+1;
                                                } 
                                            } else { ?>
                                                <tr>
                                                    <td colspan="7" class="no-record">
                                                        <i class="fa fa-warning"></i> No record found against this search.
                                                    </td>
                                                </tr>
                                            <?php } 
                                    }?>
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
        
        <?php include('include/footer.php');?>
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
                $('table thead th').each(function(index) {
                    var label = $(this).text().trim();
                    $('table tbody td:nth-child(' + (index + 1) + ')').attr('data-label', label);
                });
            });
        </script>
        </body>
</html>
<?php } ?>