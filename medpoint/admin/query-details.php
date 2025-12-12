<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {

    //updating Admin Remark
    if(isset($_POST['update'])) {
        $qid = intval($_GET['id']);
        $adminremark = $_POST['adminremark'];
        $isread = 1;
        // Using NOW() for the update date
        $query = mysqli_query($con, "update tblcontactus set AdminRemark='$adminremark', IsRead='$isread', LastupdationDate=NOW() where id='$qid'");
        
        if($query){
            echo "<script>alert('Admin Remark updated successfully.');</script>";
            // Redirect to read-query.php, as done in original PHP logic
            echo "<script>window.location.href ='read-query.php'</script>";
        } else {
            echo "<script>alert('Error updating remark.');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Query Details</title>
        
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
            
            /* REMOVED BREADCRUMB STYLES */
            .breadcrumb {
                display: none;
            }

            /* Main Card Container */
            .container-fluid.container-fullw.bg-white {
                background: white; border-radius: 20px; padding: 35px;
                box-shadow: var(--shadow-md); border: 1px solid var(--border-color);
            }
            
            .section-title {
                font-size: 22px; font-weight: 700; color: var(--text-primary);
                margin-bottom: 30px; padding-bottom: 15px; border-bottom: 2px solid var(--border-color);
                display: flex; align-items: center; gap: 10px;
            }

            /* Query Details Table Styling */
            .table-details {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                border: 1px solid var(--border-color);
            }
            
            /* Header (Left Column) */
            .table-details tr th {
                background: var(--light-blue-bg);
                color: var(--primary-dark);
                font-weight: 600;
                padding: 15px 20px;
                border-right: 1px solid var(--border-color);
                width: 25%; /* Set width for consistent layout */
                vertical-align: top;
                font-size: 14px;
            }
            
            /* Data Cell (Right Column) */
            .table-details tr td {
                background: var(--card-bg);
                color: var(--text-primary);
                font-weight: 500;
                padding: 15px 20px;
                vertical-align: top;
                font-size: 14px;
            }

            /* Horizontal Dividers */
            .table-details tr:not(:last-child) th,
            .table-details tr:not(:last-child) td {
                border-bottom: 1px solid var(--border-color);
            }
            
            /* Textarea and Form Styling */
            .form-control {
                border-radius: 8px;
                padding: 10px 15px;
                border: 1px solid var(--border-color);
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
                transition: all 0.3s ease;
            }

            .form-control:focus {
                border-color: var(--primary-light);
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            }
            
            /* Update Button */
            .btn-update {
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

            .btn-update:hover {
                background: var(--primary-dark);
                transform: translateY(-1px);
                color: white;
            }
            
            /* Responsive adjustments for mobile view */
            @media (max-width: 768px) {
                .table-details {
                    display: block;
                    width: 100%;
                    border: none;
                    box-shadow: none;
                }
                
                .table-details tbody, .table-details tr {
                    display: block;
                    width: 100%;
                }

                .table-details tr {
                    margin-bottom: 15px;
                    border: 1px solid var(--border-color);
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
                }

                .table-details tr th, .table-details tr td {
                    display: block;
                    width: 100%;
                    border: none;
                    padding: 10px 15px;
                }

                .table-details tr th {
                    background: var(--light-blue-bg);
                    font-size: 12px;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    font-weight: 700;
                    color: var(--primary-blue);
                    border-bottom: 1px solid var(--border-color);
                }
                
                .table-details tr td {
                    color: var(--text-primary);
                    font-size: 14px;
                    padding-top: 10px;
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
                                    <h1 class="mainTitle">Query Details</h1>
                                </div>

                                </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="section-title"><i class="fa fa-info-circle"></i> Manage <span class="text-bold">Query Details</span></h5>
                                    
                                    <table class="table table-details">
                                        <tbody>
                                        <?php
                                        $qid=intval($_GET['id']);
                                        // Using a left join to ensure we display details even if LastupdationDate is NULL
                                        $sql=mysqli_query($con,"select * from tblcontactus where id='$qid'");
                                        $cnt=1;
                                        while($row=mysqli_fetch_array($sql))
                                        {
                                        ?>

                                            <tr>
                                                <th>Full Name</th>
                                                <td><?php echo htmlentities($row['fullname']);?></td>
                                            </tr>

                                            <tr>
                                                <th>Email Id</th>
                                                <td><?php echo htmlentities($row['email']);?></td>
                                            </tr>
                                            <tr>
                                                <th>Contact Number</th>
                                                <td><?php echo htmlentities($row['contactno']);?></td>
                                            </tr>
                                            <tr>
                                                <th>Message</th>
                                                <td><?php echo htmlentities($row['message']);?></td>
                                            </tr>

                                            <tr>
                                                <th>Query Date</th>
                                                <td><?php echo htmlentities($row['PostingDate']);?></td>
                                            </tr>

                                            <?php if($row['AdminRemark']==""){?>    
                                            <form name="query" method="post">
                                                <tr>
                                                    <th>Admin Remark</th>
                                                    <td><textarea name="adminremark" class="form-control" required="true" rows="4"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>    
                                                        <button type="submit" class="btn btn-update" name="update">
                                                            Update <i class="fa fa-check-circle"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </form>                                             
                                            <?php } else {?>                                        
                                            
                                            <tr>
                                                <th>Admin Remark</th>
                                                <td><?php echo htmlentities($row['AdminRemark']);?></td>
                                            </tr>

                                            <tr>
                                                <th>Last Updatation Date</th>
                                                <td><?php echo htmlentities($row['LastupdationDate']);?></td>
                                            </tr>
                                            
                                            <?php 
                                            // Close the loop after the single result
                                            }} ?>
                                            
                                        </tbody>
                                    </table>
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
            });
        </script>
        </body>
</html>
<?php } ?>