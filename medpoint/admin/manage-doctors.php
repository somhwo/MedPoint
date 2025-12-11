<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {

    if(isset($_GET['del'])) {
        $docid = $_GET['id'];
        mysqli_query($con,"delete from doctors where id ='$docid'");
        $_SESSION['msg'] = "Doctor deleted successfully!";
        header('location:manage-doctors.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Manage Doctors</title>
        
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
                --primary-dark: #1e3a8a;
                --primary-light: #3b82f6;
                --light-blue-bg: #f0f7ff;
                --card-bg: #ffffff;
                --text-primary: #1e293b;
                --text-secondary: #475569;
                --text-light: #64748b;
                --border-color: #e2e8f0;
                --success: #10b981;
                --danger: #ef4444;
                --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06);
                --shadow-md: 0 4px 12px rgba(37, 99, 235, 0.08);
            }
            
            * {
                font-family: 'Poppins', sans-serif !important;
            }
            
            body { background: var(--light-blue-bg); color: var(--text-primary); }
            .main-content { background: var(--light-blue-bg); }
            .wrap-content { padding: 30px 25px; }
            
            /* Page Title */
            #page-title { background: transparent; padding: 0 0 30px 0; border: none; }
            #page-title .mainTitle {
                color: var(--primary-blue); font-size: 36px; font-weight: 800; margin: 0 0 15px 0;
                letter-spacing: -0.5px; text-transform: uppercase;
                background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
                -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            }
            
            /* Add Doctor Button */
            .add-doctor-btn {
                background: var(--primary-blue); color: white; border: none; padding: 12px 28px;
                border-radius: 10px; font-weight: 600; font-size: 14px; transition: all 0.3s ease;
                text-decoration: none; display: inline-flex; align-items: center; gap: 10px;
                box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3); cursor: pointer; float: right;
            }
            .add-doctor-btn:hover {
                transform: translateY(-2px); box-shadow: 0 6px 18px rgba(37, 99, 235, 0.4);
                background: var(--primary-dark); color: white; text-decoration: none;
            }
            .add-doctor-btn i { font-size: 16px; }
            
            /* Success Message */
            .alert-success {
                background: linear-gradient(135deg, var(--success) 0%, #34d399 100%); color: white; border: none;
                border-radius: 16px; padding: 18px 24px; margin-bottom: 25px;
                box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2); display: flex; align-items: center;
                gap: 12px; animation: slideInDown 0.4s ease;
            }
            @keyframes slideInDown {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .alert-success i { font-size: 20px; }
            .alert-success .close { color: white; opacity: 0.8; text-shadow: none; font-size: 24px; font-weight: 300; }
            .alert-success .close:hover { opacity: 1; }
            
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
            .section-title i { color: var(--primary-blue); font-size: 24px; }
            
            /* Table Container */
            .table-responsive {
                border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                border: 1px solid var(--border-color); margin-top: 0; background: white;
            }
            
            /* Table Styling */
            .table { width: 100%; margin-bottom: 0; border-collapse: separate; border-spacing: 0; }
            .table thead { background: #f8fafc; position: sticky; top: 0; z-index: 10; border-bottom: 2px solid var(--border-color); }
            
            .table thead th {
                color: var(--text-primary) !important; font-weight: 700; padding: 18px 20px;
                border: none; text-transform: uppercase; letter-spacing: 0.8px; font-size: 11px;
                white-space: nowrap; text-align: left; vertical-align: middle;
                border-bottom: 2px solid var(--border-color);
            }
            
            .table thead th:first-child { padding-left: 28px; }
            .table thead th:last-child { padding-right: 28px; }
            .table thead th.center, .table thead th.text-center { text-align: center; }
            
            /* Table Body Rows */
            .table tbody tr { background: white; transition: all 0.3s ease; border-bottom: 1px solid #f1f5f9; }
            .table tbody tr:last-child { border-bottom: none; }
            .table tbody tr:hover { background: #fafbff; transform: scale(1.002); box-shadow: 0 2px 8px rgba(37, 99, 235, 0.08); }
            
            .table tbody td {
                padding: 16px 20px; border: none; color: var(--text-secondary); font-weight: 500;
                font-size: 14px; vertical-align: middle; line-height: 1.5;
            }
            
            .table tbody td:first-child { padding-left: 28px; }
            .table tbody td:last-child { padding-right: 28px; }
            .table tbody td.center { font-weight: 600; color: var(--primary-blue); }
            
            .table tbody td[data-label="Doctor Name"],
            .table tbody td[data-label="Specialization"] { font-weight: 600; color: var(--text-primary); }
            
            /* Action Buttons */
            .action-buttons { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
            
            .btn-action {
                padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px;
                transition: all 0.3s ease; text-decoration: none; display: inline-flex;
                align-items: center; gap: 6px; border: none; cursor: pointer;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            }
            
            .btn-action i { font-size: 14px; }
            
            /* Edit Button */
            .btn-edit { background: linear-gradient(135deg, var(--success) 0%, #34d399 100%); color: white; }
            .btn-edit:hover {
                background: linear-gradient(135deg, #059669 0%, #10b981 100%); transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35); color: white; text-decoration: none;
            }
            
            /* Delete Button */
            .btn-delete { background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%); color: white; }
            .btn-delete:hover {
                background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35); color: white; text-decoration: none;
            }
            
            .btn-action:active { transform: translateY(0); }
            
            /* Empty State */
            .empty-state { text-align: center; padding: 80px 20px; }
            .empty-state i { font-size: 64px; color: var(--border-color); margin-bottom: 24px; display: block; }
            .empty-state h4 { color: var(--text-primary); font-size: 24px; font-weight: 700; margin-bottom: 12px; }
            .empty-state p { color: var(--text-light); font-size: 15px; margin-bottom: 25px; }

            /* Responsive Design */
            @media (max-width: 1200px) {
                .table thead th { padding: 16px 12px; font-size: 11px; }
                .table tbody td { padding: 14px 12px; font-size: 13px; }
            }
            
            @media (max-width: 768px) {
                .wrap-content { padding: 20px 15px; }
                #page-title .mainTitle { font-size: 28px; }
                .add-doctor-btn { float: none; width: 100%; justify-content: center; margin-top: 15px; }
                .container-fluid.container-fullw.bg-white { padding: 20px; border-radius: 16px; }
                .section-title { font-size: 18px; }

                /* Mobile Card Layout */
                .table-responsive { border: none; box-shadow: none; background: transparent; }
                .table thead { display: none; }
                .table tbody tr {
                    display: block; margin-bottom: 16px; border-radius: 12px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); border: 1px solid var(--border-color);
                    overflow: hidden; background: white;
                }
                .table tbody td {
                    display: flex; justify-content: space-between; align-items: center;
                    padding: 14px 16px; border-bottom: 1px solid #f1f5f9; text-align: right;
                }
                
                .table tbody td:first-child { padding-left: 16px; background: var(--light-blue-bg); font-weight: 700; }
                
                .table tbody td:last-child {
                    border-bottom: none; justify-content: center; padding: 16px; background: #fafbff;
                }
                
                .table tbody td:before {
                    content: attr(data-label); font-weight: 700; color: var(--primary-blue);
                    text-align: left; flex: 0 0 40%; padding-right: 15px; font-size: 12px;
                    text-transform: uppercase; letter-spacing: 0.5px;
                }
                
                .action-buttons { flex-direction: column; width: 100%; gap: 8px; }
                
                .btn-action { width: 100%; justify-content: center; font-size: 14px; padding: 12px 20px; }
                
                .empty-state { padding: 60px 20px; }
                .empty-state i { font-size: 48px; }
                .empty-state h4 { font-size: 20px; }
            }
        </style>
    </head>
    <body>
        <div id="app">      
            <?php include('include/sidebar.php');?>
            <div class="app-content">
                <?php include('include/header.php');?>
                
                <div class="main-content">
                    <div class="wrap-content container" id="container">
                        <section id="page-title">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h1 class="mainTitle">Manage Doctors</h1>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <a href="add-doctor.php" class="add-doctor-btn">
                                        <i class="fa fa-plus-circle"></i>
                                        <span>Add New Doctor</span>
                                    </a>
                                </div>
                            </div>
                        </section>
                        
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="section-title">
                                        <i class="fa fa-user-md"></i>
                                        All Doctors
                                    </h5>
                                    
                                    <?php if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])): ?>
                                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <i class="fa fa-check-circle"></i>
                                        <span><?php echo htmlentities($_SESSION['msg']); ?></span>
                                    </div>
                                    <?php unset($_SESSION['msg']); endif; ?>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="center">#</th>
                                                    <th>Specialization</th>
                                                    <th>Doctor Name</th>
                                                    <th>Creation Date</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql=mysqli_query($con,"select * from doctors");
                                                $cnt=1;
                                                $num_rows = mysqli_num_rows($sql);
                                                
                                                if($num_rows > 0) {
                                                    while($row=mysqli_fetch_array($sql)) {
                                                ?>
                                                <tr>
                                                    <td class="center" data-label="#"><?php echo $cnt;?>.</td>
                                                    <td data-label="Specialization"><?php echo htmlentities($row['specilization']);?></td>
                                                    <td data-label="Doctor Name"><?php echo htmlentities($row['doctorName']);?></td>
                                                    <td data-label="Creation Date"><?php echo htmlentities($row['creationDate']);?></td>
                                                    <td data-label="Actions">
                                                        <div class="action-buttons">
                                                            <a href="edit-doctor.php?id=<?php echo $row['id'];?>" class="btn-action btn-edit">
                                                                <i class="fa fa-pencil"></i>
                                                                <span>Edit</span>
                                                            </a>
                                                            <a href="manage-doctors.php?id=<?php echo $row['id']?>&del=delete" 
                                                                onClick="return confirm('Are you sure you want to delete this doctor?')" 
                                                                class="btn-action btn-delete">
                                                                <i class="fa fa-trash"></i>
                                                                <span>Delete</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php 
                                                    $cnt=$cnt+1;
                                                    } 
                                                } else { 
                                                ?>
                                                <tr>
                                                    <td colspan="5">
                                                        <div class="empty-state">
                                                            <i class="fa fa-user-md"></i>
                                                            <h4>No Doctors Found</h4>
                                                            <p>Get started by adding your first doctor to the system.</p>
                                                            <a href="add-doctor.php" class="add-doctor-btn" style="float: none; display: inline-flex;">
                                                                <i class="fa fa-plus-circle"></i>
                                                                <span>Add First Doctor</span>
                                                            </a>
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
                
                // Set data-label attributes for mobile responsiveness
                $('table thead th').each(function(index) {
                    var label = $(this).text().trim();
                    $('table tbody td:nth-child(' + (index + 1) + ')').attr('data-label', label);
                });

                // Auto-dismiss alert after 4 seconds
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function(){
                        $(this).remove(); 
                    });
                }, 4000); 
            });
        </script>
    </body>
</html>
<?php } ?>