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
    <title>Doctor | Search Patients</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
    <link href="vendor/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet" media="screen">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    
    <style>
        :root {
            --primary-blue: #2563eb;
            --secondary-blue: #1d4ed8;
            --light-blue: #3b82f6;
            --dark-blue: #1e40af;
            --background-blue: #eff6ff;
            --light-bg: #f8fafc;
            --border-blue: #dbeafe;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
            --radius: 10px;
        }
        
        * {
            font-family: 'Poppins', sans-serif !important;
        }
        
        body {
            background: var(--background-blue);
            color: var(--text-dark);
        }
        
        .main-content {
            background: transparent;
            min-height: calc(100vh - 70px);
        }
        
        .wrap-content {
            padding: 20px 30px;
        }
        
        /* Simplified Page Header */
        .page-header-simple {
            margin-bottom: 30px;
        }
        
        .page-title-main {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 5px;
        }
        
        .page-title-main h1 {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-blue);
            margin: 0;
        }
        
        .page-subtitle {
            color: var(--text-gray);
            font-size: 16px;
            margin: 0;
            padding-left: 45px;
        }
        
        /* Search Card */
        .search-card {
            background: white;
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            border: 1px solid var(--border-blue);
        }
        
        .card-header-simple {
            margin-bottom: 25px;
        }
        
        .card-header-simple h3 {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        /* Search Form */
        .search-form {
            background: var(--light-bg);
            border-radius: var(--radius);
            padding: 25px;
            border: 1px solid var(--border-blue);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
        }
        
        .form-label i {
            color: var(--primary-blue);
            font-size: 16px;
        }
        
        .search-input-group {
            position: relative;
        }
        
        .search-input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
            font-size: 18px;
        }
        
        .search-input {
            width: 100%;
            height: 52px;
            padding: 0 20px 0 50px;
            border: 2px solid var(--border-blue);
            border-radius: 10px;
            font-size: 15px;
            color: var(--text-dark);
            background: white;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }
        
        .search-input::placeholder {
            color: #94a3b8;
        }
        
        /* Search Button */
        .btn-search {
            background: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
        }
        
        .btn-search:hover {
            background: var(--secondary-blue);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        }
        
        /* Results Card */
        .results-card {
            background: white;
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-blue);
        }
        
        .results-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-blue);
        }
        
        .results-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .results-title i {
            color: var(--primary-blue);
            font-size: 22px;
        }
        
        .results-title h4 {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }
        
        .results-count {
            background: var(--light-bg);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .results-count i {
            color: var(--primary-blue);
        }
        
        /* Table Styles */
        .table-container {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--border-blue);
        }
        
        .results-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        
        .results-table thead {
            background: var(--light-bg);
        }
        
        .results-table th {
            padding: 16px 20px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            text-align: left;
            border-bottom: 2px solid var(--border-blue);
        }
        
        .results-table tbody tr {
            border-bottom: 1px solid var(--border-blue);
            transition: background 0.3s ease;
        }
        
        .results-table tbody tr:hover {
            background: var(--background-blue);
        }
        
        .results-table td {
            padding: 16px 20px;
            font-size: 14px;
            color: var(--text-dark);
            vertical-align: middle;
        }
        
        /* Patient Info */
        .patient-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .patient-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }
        
        .patient-details {
            display: flex;
            flex-direction: column;
        }
        
        .patient-name {
            font-weight: 500;
            color: var(--text-dark);
        }
        
        .patient-id {
            font-size: 12px;
            color: var(--text-gray);
        }
        
        /* Status Badges */
        .gender-badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .badge-male {
            background: #dbeafe;
            color: var(--primary-blue);
        }
        
        .badge-female {
            background: #fce7f3;
            color: #db2777;
        }
        
        /* Action Buttons */
        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-edit {
            background: #dbeafe;
            color: var(--primary-blue);
            border: 1px solid #bfdbfe;
        }
        
        .btn-edit:hover {
            background: #bfdbfe;
            color: var(--secondary-blue);
        }
        
        .btn-view {
            background: #fef3c7;
            color: #d97706;
            border: 1px solid #fde68a;
        }
        
        .btn-view:hover {
            background: #fde68a;
            color: #b45309;
        }
        
        /* No Results State */
        .no-results {
            text-align: center;
            padding: 60px 20px;
        }
        
        .no-results-icon {
            font-size: 60px;
            color: var(--border-blue);
            margin-bottom: 20px;
        }
        
        .no-results h5 {
            font-size: 18px;
            color: var(--text-gray);
            margin-bottom: 10px;
        }
        
        .no-results p {
            color: var(--text-gray);
            font-size: 14px;
            margin: 0 0 20px 0;
        }
        
        /* Search Tips - Clean Text Version */
        .search-tips-clean {
            margin-top: 25px;
        }
        
        .search-tips-clean h6 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .search-tips-clean h6 i {
            color: var(--primary-blue);
        }
        
        .search-tips-clean ul {
            margin: 0;
            padding-left: 25px;
        }
        
        .search-tips-clean li {
            font-size: 14px;
            color: var(--text-gray);
            margin-bottom: 6px;
            line-height: 1.5;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .wrap-content {
                padding: 15px;
            }
            
            .page-title-main h1 {
                font-size: 24px;
            }
            
            .page-subtitle {
                font-size: 14px;
                padding-left: 35px;
            }
            
            .search-card, .results-card {
                padding: 20px;
            }
            
            .results-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .search-form {
                padding: 20px;
            }
            
            .btn-search {
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
                <div class="wrap-content container">
                    
                    <!-- Simplified Page Header -->
                    <div class="page-header-simple">
                        <div class="page-title-main">
                            <h1>
                                <i class="fas fa-search"></i>
                                Search Patients
                            </h1>
                        </div>
                        <p class="page-subtitle">Find patients by name or contact number</p>
                    </div>
                    
                    <!-- Search Card -->
                    <div class="search-card">
                        <div class="card-header-simple">
                            <h3>
                                <i class="fas fa-search"></i>
                                Enter Search Criteria
                            </h3>
                        </div>
                        
                        <form role="form" method="post" name="search" class="search-form">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user"></i>
                                    Search by Name or Mobile Number
                                </label>
                                <div class="search-input-group">
                                    <i class="fas fa-search"></i>
                                    <input type="text" 
                                           name="searchdata" 
                                           id="searchdata" 
                                           class="search-input" 
                                           placeholder="Enter patient name or contact number..."
                                           value="<?php echo isset($_POST['searchdata']) ? htmlspecialchars($_POST['searchdata']) : ''; ?>"
                                           required>
                                </div>
                            </div>
                            
                            <div class="text-end">
                                <button type="submit" name="search" class="btn-search">
                                    <i class="fas fa-search"></i>
                                    Search Patients
                                </button>
                            </div>
                        </form>
                        
                        <!-- Search Tips - Clean Text Version -->
                        <div class="search-tips-clean">
                            <h6>
                                <i class="fas fa-lightbulb"></i>
                                Search Tips
                            </h6>
                            <ul>
                                <li>Search by full name or partial name (e.g., "John" or "John Doe")</li>
                                <li>Search by phone number with or without country code</li>
                                <li>Use keywords to find specific patients quickly</li>
                                <li>Results are sorted by most recent registration</li>
                            </ul>
                        </div>
                    </div>
                    
                    <?php
                    if(isset($_POST['search'])) { 
                        $sdata = trim($_POST['searchdata']);
                    ?>
                    
                    <!-- Results Card -->
                    <div class="results-card">
                        <div class="results-header">
                            <div class="results-title">
                                <i class="fas fa-list-check"></i>
                                <h4>Search Results</h4>
                            </div>
                            <div class="results-count">
                                <i class="fas fa-chart-bar"></i>
                                <span>
                                    <?php 
                                    $sql = mysqli_query($con, "SELECT COUNT(*) as total FROM tblpatient WHERE PatientName LIKE '%$sdata%' OR PatientContno LIKE '%$sdata%'");
                                    $total_row = mysqli_fetch_assoc($sql);
                                    $total = $total_row['total'];
                                    echo $total . ' result' . ($total != 1 ? 's' : '');
                                    ?>
                                </span>
                            </div>
                        </div>
                        
                        <?php if($total > 0) { ?>
                        
                        <!-- Results Table -->
                        <div class="table-container">
                            <table class="results-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Patient Information</th>
                                        <th>Contact</th>
                                        <th>Gender</th>
                                        <th>Registration Date</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "SELECT * FROM tblpatient WHERE PatientName LIKE '%$sdata%' OR PatientContno LIKE '%$sdata%' ORDER BY CreationDate DESC");
                                    $cnt = 1;
                                    
                                    while($row = mysqli_fetch_array($sql)) {
                                        $initial = strtoupper(substr($row['PatientName'], 0, 1));
                                        $gender_class = ($row['PatientGender'] == 'Male') ? 'badge-male' : 'badge-female';
                                        $gender_icon = ($row['PatientGender'] == 'Male') ? 'mars' : 'venus';
                                    ?>
                                    <tr>
                                        <td><?php echo $cnt; ?></td>
                                        <td>
                                            <div class="patient-info">
                                                <div class="patient-avatar">
                                                    <?php echo $initial; ?>
                                                </div>
                                                <div class="patient-details">
                                                    <div class="patient-name"><?php echo htmlentities($row['PatientName']); ?></div>
                                                    <div class="patient-id">ID: P<?php echo str_pad($row['ID'], 4, '0', STR_PAD_LEFT); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo htmlentities($row['PatientContno']); ?></td>
                                        <td>
                                            <span class="gender-badge <?php echo $gender_class; ?>">
                                                <i class="fas fa-<?php echo $gender_icon; ?>"></i>
                                                <?php echo htmlentities($row['PatientGender']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div style="font-size: 13px;">
                                                <?php echo date('M d, Y', strtotime($row['CreationDate'])); ?>
                                            </div>
                                            <div style="font-size: 12px; color: var(--text-gray);">
                                                <?php echo date('h:i A', strtotime($row['CreationDate'])); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($row['UpdationDate']) { ?>
                                            <div style="font-size: 13px;">
                                                <?php echo date('M d, Y', strtotime($row['UpdationDate'])); ?>
                                            </div>
                                            <div style="font-size: 12px; color: var(--text-gray);">
                                                <?php echo date('h:i A', strtotime($row['UpdationDate'])); ?>
                                            </div>
                                            <?php } else { ?>
                                            <span style="color: var(--text-gray); font-size: 13px;">Not updated</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 8px;">
                                                <a href="edit-patient.php?editid=<?php echo $row['ID']; ?>" class="btn-action btn-edit" target="_blank">
                                                    <i class="fas fa-edit"></i>
                                                    Edit
                                                </a>
                                                <a href="view-patient.php?viewid=<?php echo $row['ID']; ?>" class="btn-action btn-view" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                    View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php 
                                    $cnt++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <?php } else { ?>
                        
                        <!-- No Results -->
                        <div class="no-results">
                            <div class="no-results-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h5>No Results Found</h5>
                            <p>No patients found matching "<?php echo htmlspecialchars($sdata); ?>"</p>
                            <div class="search-tips-clean">
                                <h6>
                                    <i class="fas fa-lightbulb"></i>
                                    Try these suggestions:
                                </h6>
                                <ul>
                                    <li>Check for spelling errors</li>
                                    <li>Try different keywords</li>
                                    <li>Search by partial name</li>
                                    <li>Use phone number instead of name</li>
                                </ul>
                            </div>
                        </div>
                        
                        <?php } ?>
                    </div>
                    
                    <?php } ?>
                    
                </div>
            </div>
        </div>
        
        <!-- Settings -->
        <?php include('include/setting.php'); ?>
    </div>
    
    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/media/js/dataTables.bootstrap.js"></script>
    <script src="assets/js/main.js"></script>
    
    <script>
        $(document).ready(function() {
            Main.init();
            
            // Initialize DataTable for results
            $('.results-table').DataTable({
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[0, 'asc']],
                "language": {
                    "search": "",
                    "searchPlaceholder": "Filter results...",
                    "info": "Showing _START_ to _END_ of _TOTAL_ patients"
                },
                "dom": '<"top"f>rt<"bottom"lip><"clear">'
            });
            
            // Add search box styling
            $('.dataTables_filter input').addClass('search-input');
            $('.dataTables_filter label').contents().filter(function() {
                return this.nodeType == 3;
            }).remove();
            
            // Focus on search input on page load
            $('#searchdata').focus();
            
            // Auto-submit form on Enter key
            $('#searchdata').on('keypress', function(e) {
                if(e.which === 13) {
                    e.preventDefault();
                    $('form[name="search"]').submit();
                }
            });
            
            // Show search term in input after search
            <?php if(isset($_POST['searchdata'])) { ?>
            $('#searchdata').val('<?php echo htmlspecialchars($_POST['searchdata']); ?>');
            <?php } ?>
            
            // Clear search on escape key
            $(document).on('keydown', function(e) {
                if(e.key === 'Escape') {
                    $('#searchdata').val('').focus();
                }
            });
        });
    </script>
</body>
</html>
<?php } ?>