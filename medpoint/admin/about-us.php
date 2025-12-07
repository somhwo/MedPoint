<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
    exit(); 
} 

if (isset($_POST['submit'])) {
    $pagetitle = trim($_POST['pagetitle']);
    
    if (isset($con) && $con instanceof mysqli) {
        $pagedes = $con->real_escape_string($_POST['pagedes']);
    } else {
        $pagedes = htmlspecialchars($_POST['pagedes'], ENT_QUOTES, 'UTF-8');
    }

    $query_text = "UPDATE tblpage SET PageTitle='$pagetitle', PageDescription='$pagedes' WHERE PageType='aboutus'";
    $query = mysqli_query($con, $query_text);
    
    if ($query) {
        echo '<script>alert("About Us content updated successfully!");</script>';
    } else {
        error_log("Database Error updating About Us: " . mysqli_error($con));
        echo '<script>alert("Something Went Wrong. Please try again.");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | About Us Editor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="assets/css/styles.css">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif !important;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #f0f4f8;
            color: #1e293b;
            overflow-x: hidden;
        }
        
        .main-content {
            background: #f0f4f8;
            padding: 35px 40px;
        }
        
        /* Page Header with Gradient */
        .page-header-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 24px;
            padding: 45px 50px;
            margin-bottom: 40px;
            color: #ffffff;
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.4);
            position: relative;
            overflow: hidden;
        }
        
        .page-header-modern::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .page-header-modern h1 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            z-index: 1;
            letter-spacing: -0.5px;
        }
        
        .page-header-modern p {
            font-size: 16px;
            opacity: 0.95;
            margin: 0;
            position: relative;
            z-index: 1;
            font-weight: 400;
        }
        
        .breadcrumb-modern {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 12px 24px;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            position: relative;
            z-index: 1;
            margin-top: 20px;
        }
        
        .breadcrumb-modern span {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
        }
        
        .breadcrumb-modern .active {
            color: #ffffff;
            font-weight: 700;
        }
        
        .breadcrumb-modern i {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
        }
        
        /* Section Container */
        .section-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }
        
        /* Modern Glass Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.7);
            transition: all 0.4s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
        }
        
        .card-header-section {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .card-icon-badge {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
        
        .card-icon-badge i {
            color: #ffffff;
            font-size: 22px;
        }
        
        .card-title-main {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.5px;
        }
        
        /* Form Elements */
        .form-group-modern {
            margin-bottom: 28px;
        }
        
        .form-label-modern {
            font-weight: 600;
            color: #334155;
            margin-bottom: 12px;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-label-modern i {
            color: #667eea;
            font-size: 16px;
        }
        
        .input-modern {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #ffffff;
        }
        
        .input-modern:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        
        /* Editor Toolbar */
        .editor-toolbar-modern {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 2px solid #e2e8f0;
            border-bottom: none;
            border-radius: 14px 14px 0 0;
            padding: 12px 20px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .editor-btn-modern {
            background: #ffffff;
            color: #475569;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.2s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }
        
        .editor-btn-modern:hover {
            background: #667eea;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        .editor-btn-modern.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            border-color: #5568d3;
        }
        
        .toolbar-divider {
            width: 2px;
            background: #cbd5e1;
            height: 24px;
            margin: 0 8px;
        }
        
        .editor-area-modern {
            min-height: 400px;
            border: 2px solid #e2e8f0;
            border-radius: 0 0 14px 14px;
            background: #ffffff;
            padding: 28px;
            font-size: 15px;
            line-height: 1.8;
            cursor: text;
            transition: border-color 0.3s ease;
        }
        
        .editor-area-modern:focus {
            outline: none;
            border-color: #667eea;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin: 30px 0;
        }
        
        .stat-box {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .stat-box:hover {
            transform: translateY(-4px);
            border-color: #667eea;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Action Buttons */
        .action-buttons-modern {
            display: flex;
            gap: 16px;
            margin-top: 35px;
        }
        
        .btn-modern {
            padding: 16px 32px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            border: none;
            letter-spacing: 0.3px;
        }
        
        .btn-save-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .btn-save-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }
        
        .btn-reset-modern {
            background: #ffffff;
            color: #475569;
            border: 2px solid #e2e8f0;
        }
        
        .btn-reset-modern:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }
        
        /* Preview Card */
        .preview-box {
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
            border-radius: 16px;
            padding: 25px;
            border-left: 5px solid #667eea;
            margin-bottom: 25px;
        }
        
        .preview-title {
            color: #1e293b;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .preview-content-area {
            font-size: 14px;
            line-height: 1.7;
            color: #475569;
        }
        
        /* Services List */
        .services-showcase {
            margin-top: 25px;
            padding-top: 25px;
            border-top: 2px dashed #cbd5e1;
        }
        
        .services-title {
            color: #1e293b;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .service-item {
            padding: 14px 0;
            border-bottom: 1px solid rgba(203, 213, 225, 0.5);
            display: flex;
            align-items: center;
            gap: 14px;
            font-weight: 500;
            color: #334155;
            transition: all 0.2s ease;
        }
        
        .service-item:hover {
            padding-left: 10px;
            color: #667eea;
        }
        
        .service-item i {
            color: #10b981;
            font-size: 20px;
        }
        
        /* Tips Section */
        .tips-banner {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 2px solid #fbbf24;
            border-radius: 16px;
            padding: 24px;
            margin-top: 25px;
        }
        
        .tips-banner h4 {
            color: #92400e;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .tips-banner ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .tips-banner li {
            padding: 8px 0;
            color: #78350f;
            font-size: 14px;
            display: flex;
            align-items: start;
            gap: 10px;
        }
        
        .tips-banner li::before {
            content: "✓";
            color: #10b981;
            font-weight: 700;
            font-size: 16px;
        }
        
        /* Character Counter */
        .char-counter {
            text-align: right;
            font-size: 13px;
            color: #64748b;
            margin-top: 12px;
            font-weight: 600;
        }
        
        .char-counter.warning {
            color: #ef4444;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .section-container {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .main-content {
                padding: 20px 16px;
            }
            
            .page-header-modern {
                padding: 30px 24px;
                border-radius: 16px;
            }
            
            .page-header-modern h1 {
                font-size: 28px;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
            
            .glass-card {
                padding: 24px;
            }
            
            .action-buttons-modern {
                flex-direction: column;
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
                <!-- Modern Page Header -->
                <div class="page-header-modern">
                    <h1>
                        <i class="fas fa-edit"></i>
                        About Us Content Editor
                    </h1>
                    <p>Manage and optimize your institution's public-facing information with ease.</p>
                    <div class="breadcrumb-modern">
                        <span>Admin Panel</span>
                        <i class="fas fa-chevron-right"></i>
                        <span>Pages</span>
                        <i class="fas fa-chevron-right"></i>
                        <span class="active">About Us Editor</span>
                    </div>
                </div>
                
                <!-- Content Section -->
                <div class="section-container">
                    <!-- Editor Card -->
                    <div class="glass-card">
                        <div class="card-header-section">
                            <div class="card-icon-badge">
                                <i class="fas fa-pen-to-square"></i>
                            </div>
                            <h2 class="card-title-main">Content Details</h2>
                        </div>
                        
                        <form method="post" id="aboutForm">
                            <?php
                            $ret = mysqli_query($con, "select * from tblpage where PageType='aboutus'");
                            if ($ret && $row = mysqli_fetch_array($ret)) {
                                $original_page_title = $row['PageTitle'];
                                $original_page_desc = $row['PageDescription'];
                            ?>
                            
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-heading"></i>
                                    Page Title
                                </label>
                                <input type="text" 
                                       name="pagetitle" 
                                       class="input-modern" 
                                       value="<?php echo htmlspecialchars($original_page_title); ?>"
                                       placeholder="Enter the main title for the About Us page">
                            </div>
                            
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-align-left"></i>
                                    Page Content (Rich Text Editor)
                                </label>
                                
                                <div class="editor-toolbar-modern">
                                    <button type="button" class="editor-btn-modern" onclick="formatText('bold')" title="Bold">
                                        <i class="fas fa-bold"></i>
                                    </button>
                                    <button type="button" class="editor-btn-modern" onclick="formatText('italic')" title="Italic">
                                        <i class="fas fa-italic"></i>
                                    </button>
                                    <button type="button" class="editor-btn-modern" onclick="formatText('underline')" title="Underline">
                                        <i class="fas fa-underline"></i>
                                    </button>
                                    <div class="toolbar-divider"></div>
                                    <button type="button" class="editor-btn-modern" onclick="formatList('ul')" title="Bullet List">
                                        <i class="fas fa-list-ul"></i>
                                    </button>
                                    <button type="button" class="editor-btn-modern" onclick="formatList('ol')" title="Numbered List">
                                        <i class="fas fa-list-ol"></i>
                                    </button>
                                    <button type="button" class="editor-btn-modern" onclick="insertHeading()" title="Heading">
                                        <i class="fas fa-heading"></i>
                                    </button>
                                    <div class="toolbar-divider"></div>
                                    <button type="button" class="editor-btn-modern" onclick="insertLink()" title="Insert Link">
                                        <i class="fas fa-link"></i>
                                    </button>
                                </div>
                                
                                <div class="editor-area-modern" 
                                     contenteditable="true" 
                                     id="contentEditor"
                                     oninput="updatePreview()">
                                    <?php echo $original_page_desc; ?>
                                </div>
                                
                                <textarea name="pagedes" id="pagedes" style="display: none;"></textarea>
                                <div class="char-counter" id="charCounter">Characters: 0</div>
                            </div>

                            <!-- Stats Grid -->
                            <div class="stats-grid">
                                <div class="stat-box">
                                    <div class="stat-number" id="wordCount">0</div>
                                    <div class="stat-label">Words</div>
                                </div>
                                <div class="stat-box">
                                    <div class="stat-number" id="charCount">0</div>
                                    <div class="stat-label">Characters</div>
                                </div>
                                <div class="stat-box">
                                    <div class="stat-number" id="headingCount">0</div>
                                    <div class="stat-label">Headings</div>
                                </div>
                                <div class="stat-box">
                                    <div class="stat-number" id="linkCount">0</div>
                                    <div class="stat-label">Links</div>
                                </div>
                            </div>
                            
                            <?php } else { ?>
                                <p style="color: #ef4444; font-weight: 600;">Error: Could not retrieve existing content from the database.</p>
                            <?php } ?>
                            
                            <!-- Action Buttons -->
                            <div class="action-buttons-modern">
                                <button type="submit" class="btn-modern btn-save-modern" name="submit">
                                    <i class="fas fa-save"></i>
                                    Save Changes
                                </button>
                                <button type="button" class="btn-modern btn-reset-modern" onclick="resetEditor()">
                                    <i class="fas fa-rotate-left"></i>
                                    Reset to Original
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Preview Card -->
                    <div class="glass-card">
                        <div class="card-header-section">
                            <div class="card-icon-badge">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h2 class="card-title-main">Live Preview</h2>
                        </div>
                        
                        <div class="preview-box">
                            <h3 class="preview-title" id="previewTitle">About Us</h3>
                            <div id="previewContent" class="preview-content-area">
                                <p>Your content will appear here after typing...</p>
                            </div>
                            
                            <div class="services-showcase">
                                <h4 class="services-title">
                                    <i class="fas fa-stethoscope"></i>
                                    Our Key Services
                                </h4>
                                <div class="service-item">
                                    <i class="fas fa-ambulance"></i>
                                    <span>Emergency Services</span>
                                </div>
                                <div class="service-item">
                                    <i class="fas fa-baby"></i>
                                    <span>Pediatric Care</span>
                                </div>
                                <div class="service-item">
                                    <i class="fas fa-heartbeat"></i>
                                    <span>Cardiology & Wellness</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tips-banner">
                            <h4>
                                <i class="fas fa-lightbulb"></i>
                                SEO & Quality Tips
                            </h4>
                            <ul>
                                <li>Use H2/H3 tags for better structure and SEO</li>
                                <li>Keep primary content focused (max 1000 words)</li>
                                <li>Ensure all links are relevant and working</li>
                                <li>Add keywords naturally in your content</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    
    <script>
        const initialTitle = "<?php echo isset($original_page_title) ? htmlspecialchars($original_page_title, ENT_QUOTES) : 'About Us'; ?>";
        const initialContent = (function() {
            let content = `<?php echo isset($original_page_desc) ? str_replace(["\r", "\n"], "", $original_page_desc) : '<p>Please enter your content here.</p>'; ?>`;
            return content.trim(); 
        })();

        document.addEventListener('DOMContentLoaded', function() {
            const editor = document.getElementById('contentEditor');
            const titleInput = document.querySelector('input[name="pagetitle"]');
            
            editor.innerHTML = initialContent;
            titleInput.value = initialTitle;

            updateCounters();
            updatePreview();
            
            titleInput.addEventListener('input', updatePreview);
        });
        
        function updateCounters() {
            const editor = document.getElementById('contentEditor');
            const text = editor.innerText;
            
            const charCount = text.length;
            document.getElementById('charCount').textContent = charCount;
            
            const wordCount = text.trim() ? text.trim().split(/\s+/).length : 0;
            document.getElementById('wordCount').textContent = wordCount;
            
            const headingCount = editor.querySelectorAll('h1, h2, h3, h4, h5, h6').length;
            document.getElementById('headingCount').textContent = headingCount;
            
            const linkCount = editor.querySelectorAll('a').length;
            document.getElementById('linkCount').textContent = linkCount;
            
            const counter = document.getElementById('charCounter');
            counter.textContent = `Characters: ${charCount}`;
            counter.classList.toggle('warning', charCount > 2000);
            
            document.getElementById('pagedes').value = editor.innerHTML;
        }
        
        function updatePreview() {
            const editor = document.getElementById('contentEditor');
            const titleInput = document.querySelector('input[name="pagetitle"]');
            
            document.getElementById('previewTitle').textContent = titleInput.value || 'About Us';
            document.getElementById('previewContent').innerHTML = editor.innerHTML || '<p>Your content will appear here after typing...</p>';

            updateCounters();
        }
        
        function formatText(command) {
            document.execCommand(command, false, null);
            updatePreview(); 
        }
        
        function formatList(type) {
            document.execCommand('insert' + (type === 'ul' ? 'Unordered' : 'Ordered') + 'List', false, null);
            updatePreview();
        }
        
        function insertHeading() {
            const level = prompt('Enter heading level (2-6):', '2');
            if (level >= 2 && level <= 6) { 
                document.execCommand('formatBlock', false, `h${level}`);
            }
            updatePreview();
        }
        
        function insertLink() {
            const url = prompt('Enter URL:', 'https://');
            if (url) {
                document.execCommand('createLink', false, url);
            }
            updatePreview();
        }
        
        function resetEditor() {
            if (confirm('Are you sure you want to discard all changes and reset to the original content?')) {
                const editor = document.getElementById('contentEditor');
                const titleInput = document.querySelector('input[name="pagetitle"]');
                
                editor.innerHTML = initialContent;
                titleInput.value = initialTitle;
                
                updatePreview();
            }
        }
        
        document.getElementById('contentEditor').addEventListener('input', updatePreview);
        
        document.getElementById('aboutForm').addEventListener('submit', function(e) {
            updateCounters(); 
            
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            submitBtn.disabled = true;
        });
        
        document.querySelectorAll('.editor-btn-modern').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('contentEditor').focus();
            });
        });
    </script>
</body>
</html>