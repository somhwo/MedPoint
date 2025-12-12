<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage Read Queries</title>
    
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
           PAGE HEADER
        ============================================ */
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
            display: none;
        }

        /* ============================================
           CARD CONTAINER
        ============================================ */
        .container-fluid.container-fullw.bg-white {
            background: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
        }

        /* ============================================
           SECTION TITLE
        ============================================ */
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

        .section-title .text-bold {
            color: var(--primary-blue);
            font-weight: 700;
        }

        /* ============================================
           TABLE CONTAINER
        ============================================ */
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-color);
            margin-top: 20px;
        }

        /* ============================================
           TABLE STYLES
        ============================================ */
        .table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: collapse;
        }

        /* Table Header */
        .table thead {
            background: #f8fafc;
            border-bottom: 2px solid var(--border-color);
        }

        .table thead th {
            color: #64748b !important;
            font-weight: 600;
            padding: 16px 20px;
            border: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 11px;
            white-space: nowrap;
            text-align: left;
        }

        .table thead th.text-center {
            text-align: center;
        }

        /* Table Body */
        .table tbody tr {
            background: white;
            transition: var(--transition);
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:hover {
            background: var(--light-blue-bg);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.08);
        }

        .table tbody td {
            padding: 16px 20px;
            border: none;
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 14px;
            vertical-align: middle;
        }

        /* Serial Number Column */
        .table tbody td.center {
            font-weight: 600;
            color: var(--primary-blue);
            font-size: 14px;
            text-align: center;
        }

        /* Center aligned cells */
        .table tbody td.text-center {
            text-align: center;
        }

        /* Truncate long text */
        .table tbody td.truncate {
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ============================================
           ACTION BUTTON
        ============================================ */
        .btn-action {
            background: var(--primary-blue);
            color: white;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
            cursor: pointer;
        }

        .btn-action:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-action i {
            font-size: 14px;
        }

        /* ============================================
           EMPTY STATE
        ============================================ */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 50px;
            color: var(--border-color);
            margin-bottom: 20px;
            display: block;
        }

        .empty-state h4 {
            color: var(--text-primary);
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .empty-state p {
            color: var(--text-light);
            font-size: 14px;
            margin: 0;
        }

        /* ============================================
           RESPONSIVE DESIGN (MOBILE)
        ============================================ */
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

            /* Hide table header on mobile */
            .table thead {
                display: none;
            }

            .table-responsive {
                border: none;
                box-shadow: none;
            }

            /* Card-style rows for mobile */
            .table tbody tr {
                display: block;
                margin-bottom: 15px;
                border-radius: 12px;
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

            .table tbody td:last-child {
                border-bottom: none;
                justify-content: center;
                padding: 16px;
            }

            /* Add labels before content on mobile */
            .table tbody td:before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--primary-blue);
                text-align: left;
                flex: 1;
                padding-right: 15px;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }
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
                                <h1 class="mainTitle">Manage Read Queries</h1>
                            </div>
                        </div>
                    </section>
                    
                    <!-- Main Content Card -->
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                
                                <!-- Section Title -->
                                <h5 class="section-title">
                                    <i class="fa fa-eye"></i> Manage <span class="text-bold">Read Queries</span>
                                </h5>
                                
                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="table table-hover" id="sample-table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Contact No.</th>
                                                <th>Message</th>
                                                <th>Query Date</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = mysqli_query($con, "SELECT * FROM tblcontactus WHERE IsRead IS NOT NULL ORDER BY PostingDate DESC");
                                            $cnt = 1;
                                            $num_rows = mysqli_num_rows($sql);
                                            
                                            if ($num_rows > 0) {
                                                while ($row = mysqli_fetch_array($sql)) {
                                            ?>
                                                <tr>
                                                    <td class="center" data-label="#"><?php echo $cnt; ?></td>
                                                    <td data-label="Name"><?php echo htmlentities($row['fullname']); ?></td>
                                                    <td data-label="Email"><?php echo htmlentities($row['email']); ?></td>
                                                    <td data-label="Contact No."><?php echo htmlentities($row['contactno']); ?></td>
                                                    <td class="truncate" data-label="Message" title="<?php echo htmlentities($row['message']); ?>">
                                                        <?php echo htmlentities($row['message']); ?>
                                                    </td>
                                                    <td data-label="Query Date"><?php echo date('M d, Y', strtotime($row['PostingDate'])); ?></td>
                                                    <td class="text-center" data-label="Action">
                                                        <a href="query-details.php?id=<?php echo $row['id']; ?>" class="btn-action" title="View Details">
                                                            <i class="fa fa-file-text-o"></i> View Details
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                                    $cnt++;
                                                }
                                            } else {
                                            ?>
                                                <tr>
                                                    <td colspan="7">
                                                        <div class="empty-state">
                                                            <i class="fa fa-inbox"></i>
                                                            <h4>No Read Queries Found</h4>
                                                            <p>There are no processed queries to display at this time.</p>
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
        
        <?php include('include/setting.php'); ?>
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
    
    <!-- Custom Scripts -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/form-elements.js"></script>
    
    <script>
        jQuery(document).ready(function() {
            // Initialize main functions
            Main.init();
            FormElements.init();
            
            // Add data-label attributes for mobile responsiveness
            $('table thead th').each(function(index) {
                var label = $(this).text().trim();
                $('table tbody td:nth-child(' + (index + 1) + ')').attr('data-label', label);
            });
        });
    </script>
</body>
</html>