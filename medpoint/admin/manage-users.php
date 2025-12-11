<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {

    if(isset($_GET['del'])) {
        $uid = $_GET['id'];
        mysqli_query($con,"delete from users where id ='$uid'");
        $_SESSION['msg'] = "User data deleted successfully!";
        header('location:manage-users.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Manage Users</title>
        
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
            
            /* Page Title */
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
            
            .breadcrumb li + li:before {
                content: "/";
                margin: 0 8px;
                color: var(--text-light);
            }
            
            /* Success Message */
            .alert-success {
                background: linear-gradient(135deg, var(--success) 0%, #34d399 100%);
                color: white;
                border: none;
                border-radius: 16px;
                padding: 18px 24px;
                margin-bottom: 25px;
                box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
                display: flex;
                align-items: center;
                gap: 12px;
                animation: slideInDown 0.4s ease;
            }
            
            @keyframes slideInDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .alert-success i {
                font-size: 20px;
            }
            
            .alert-success .close {
                color: white;
                opacity: 0.8;
                text-shadow: none;
                font-size: 24px;
                font-weight: 300;
            }
            
            .alert-success .close:hover {
                opacity: 1;
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
                font-size: 22px;
                font-weight: 700;
                color: var(--text-primary);
                margin-bottom: 30px;
                padding-bottom: 15px;
                border-bottom: 2px solid var(--border-color);
                display: flex;
                align-items: center;
                gap: 10px;
            }
            
            .section-title i {
                color: var(--primary-blue);
                font-size: 24px;
            }
            
            /* Table Container */
            .table-responsive {
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                border: 1px solid var(--border-color);
                margin-top: 0;
                background: white;
            }
            
            /* Table Styling */
            .table {
                width: 100%;
                margin-bottom: 0;
                border-collapse: separate;
                border-spacing: 0;
            }
            
            .table thead {
                background: #f8fafc;
                position: sticky;
                top: 0;
                z-index: 10;
                border-bottom: 2px solid var(--border-color);
            }
            
            .table thead th {
                color: var(--text-primary) !important;
                font-weight: 700;
                padding: 18px 16px;
                border: none;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                font-size: 11px;
                white-space: nowrap;
                text-align: left;
                vertical-align: middle;
                border-bottom: 2px solid var(--border-color);
            }
            
            .table thead th:first-child {
                border-radius: 0;
                padding-left: 28px;
            }
            
            .table thead th:last-child {
                border-radius: 0;
                padding-right: 28px;
            }
            
            .table thead th.center,
            .table thead th.text-center {
                text-align: center;
            }
            
            /* Table Body Rows */
            .table tbody tr {
                background: white;
                transition: all 0.3s ease;
                border-bottom: 1px solid #f1f5f9;
            }
            
            .table tbody tr:last-child {
                border-bottom: none;
            }
            
            .table tbody tr:hover {
                background: #fafbff;
                transform: scale(1.002);
                box-shadow: 0 2px 8px rgba(37, 99, 235, 0.08);
            }
            
            .table tbody td {
                padding: 16px;
                border: none;
                color: var(--text-secondary);
                font-weight: 500;
                font-size: 14px;
                vertical-align: middle;
                line-height: 1.5;
            }
            
            .table tbody td:first-child {
                padding-left: 28px;
            }
            
            .table tbody td:last-child {
                padding-right: 28px;
            }
            
            .table tbody td.center {
                text-align: center;
                font-weight: 600;
                color: var(--primary-blue);
                font-size: 14px;
            }
            
            /* Better text wrapping for long content */
            .table tbody td {
                max-width: 200px;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            .table tbody td[data-label="Full Name"],
            .table tbody td[data-label="Email"] {
                font-weight: 600;
                color: var(--text-primary);
            }
            
            .table tbody td[data-label="Gender"] {
                text-transform: capitalize;
            }
            
            /* Action Button */
            .btn-action {
                background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
                color: white;
                padding: 8px 20px;
                border-radius: 8px;
                font-weight: 600;
                font-size: 13px;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                border: none;
                cursor: pointer;
                box-shadow: 0 2px 6px rgba(239, 68, 68, 0.2);
            }
            
            .btn-action:hover {
                background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
                text-decoration: none;
                color: white;
            }
            
            .btn-action:active {
                transform: translateY(0);
            }
            
            .btn-action i {
                font-size: 14px;
            }
            
            /* Empty State */
            .empty-state {
                text-align: center;
                padding: 80px 20px;
            }
            
            .empty-state i {
                font-size: 64px;
                color: var(--border-color);
                margin-bottom: 24px;
                display: block;
            }
            
            .empty-state h4 {
                color: var(--text-primary);
                font-size: 24px;
                font-weight: 700;
                margin-bottom: 12px;
            }
            
            .empty-state p {
                color: var(--text-light);
                font-size: 15px;
                margin-bottom: 0;
            }

            /* Zebra Striping (Optional - uncomment if preferred) */
            /* .table tbody tr:nth-child(even) {
                background: #fafbff;
            } */

            /* Responsive Design */
            @media (max-width: 1200px) {
                .table thead th {
                    padding: 16px 12px;
                    font-size: 11px;
                }
                .table tbody td {
                    padding: 14px 12px;
                    font-size: 13px;
                }
            }
            
            @media (max-width: 768px) {
                .wrap-content {
                    padding: 20px 15px;
                }
                
                #page-title .mainTitle {
                    font-size: 28px;
                }
                
                .container-fluid.container-fullw.bg-white {
                    padding: 20px;
                    border-radius: 16px;
                }
                
                .section-title {
                    font-size: 18px;
                }

                /* Mobile Card Layout */
                .table-responsive {
                    border: none;
                    box-shadow: none;
                    background: transparent;
                }
                
                .table thead {
                    display: none;
                }
                
                .table tbody tr {
                    display: block;
                    margin-bottom: 16px;
                    border-radius: 12px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                    border: 1px solid var(--border-color);
                    overflow: hidden;
                    background: white;
                }
                
                .table tbody tr:hover {
                    transform: none;
                }
                
                .table tbody td {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 14px 16px;
                    border-bottom: 1px solid #f1f5f9;
                    text-align: right;
                    max-width: 100%;
                }
                
                .table tbody td:first-child {
                    padding-left: 16px;
                    background: var(--light-blue-bg);
                    font-weight: 700;
                }
                
                .table tbody td:last-child {
                    border-bottom: none;
                    justify-content: center;
                    padding: 16px;
                    background: #fafbff;
                }
                
                .table tbody td:before {
                    content: attr(data-label);
                    font-weight: 700;
                    color: var(--primary-blue);
                    text-align: left;
                    flex: 0 0 40%;
                    padding-right: 15px;
                    font-size: 12px;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
                
                .table tbody td.center {
                    text-align: right;
                }
                
                .btn-action {
                    width: 100%;
                    font-size: 14px;
                    padding: 12px 20px;
                }
                
                .empty-state {
                    padding: 60px 20px;
                }
                
                .empty-state i {
                    font-size: 48px;
                }
                
                .empty-state h4 {
                    font-size: 20px;
                }
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
                                    <h1 class="mainTitle">Manage Users</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li>
                                        <span>Admin</span>
                                    </li>
                                    <li class="active">
                                        <span>Manage Users</span>
                                    </li>
                                </ol>
                            </div>
                        </section>
                        
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="section-title">
                                        <i class="fa fa-users"></i>
                                        Registered Users
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
                                        <table class="table table-hover" id="sample-table-1">
                                            <thead>
                                                <tr>
                                                    <th class="center">#</th>
                                                    <th>Full Name</th>
                                                    <th class="hidden-xs">Address</th>
                                                    <th>City</th>
                                                    <th>Gender</th>
                                                    <th>Email</th>
                                                    <th>Registration Date</th>
                                                    <th>Last Update</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql=mysqli_query($con,"select * from users");
                                                $cnt=1;
                                                $num_rows = mysqli_num_rows($sql);
                                                
                                                if ($num_rows > 0) {
                                                    while($row=mysqli_fetch_array($sql))
                                                    {
                                                ?>
                                                <tr>
                                                    <td class="center" data-label="#"><?php echo $cnt;?>.</td>
                                                    <td data-label="Full Name"><?php echo htmlentities($row['fullName']);?></td>
                                                    <td data-label="Address"><?php echo htmlentities($row['address']);?></td>
                                                    <td data-label="City"><?php echo htmlentities($row['city']);?></td>
                                                    <td data-label="Gender"><?php echo htmlentities($row['gender']);?></td>
                                                    <td data-label="Email"><?php echo htmlentities($row['email']);?></td>
                                                    <td data-label="Registration Date"><?php echo htmlentities($row['regDate']);?></td>
                                                    <td data-label="Last Update"><?php echo htmlentities($row['updationDate']);?></td>
                                                    <td data-label="Action" class="text-center">
                                                        <a href="manage-users.php?id=<?php echo $row['id']?>&del=delete" 
                                                            onClick="return confirm('Are you sure you want to delete this user?')"
                                                            class="btn-action" title="Delete User">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php 
                                                    $cnt=$cnt+1;
                                                    }
                                                } else {
                                                ?>
                                                <tr>
                                                    <td colspan="9">
                                                        <div class="empty-state">
                                                            <i class="fa fa-users"></i>
                                                            <h4>No Users Found</h4>
                                                            <p>There are no registered user records to display.</p>
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