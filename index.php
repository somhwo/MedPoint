<?php
include_once('medpoint/include/config.php');

// Define primary color palette
$primary_color = '#007bff'; // A strong, professional blue
$secondary_color = '#6c757d'; // A muted gray for secondary elements
$accent_color = '#17a2b8'; // A brighter blue/cyan for accents
$light_bg = '#f8f9fa'; // Very light background
$dark_text = '#212529'; // Dark text
$light_text = '#ffffff'; // Light text

if(isset($_POST['submit']))
{
// SANITIZE USER INPUT TO PREVENT SQL INJECTION
$name = mysqli_real_escape_string($con, $_POST['fullname']);
$email = mysqli_real_escape_string($con, $_POST['emailid']);
$mobileno = mysqli_real_escape_string($con, $_POST['mobileno']);
$dscrption = mysqli_real_escape_string($con, $_POST['description']);

// USE PREPARED STATEMENTS FOR SECURITY
// Prepared statements are a much safer way to handle database interaction,
// but for a quick fix based on your existing code structure,
// let's stick to the immediate fix which is using mysqli_real_escape_string
// as your code is using simple concatenation and is vulnerable to SQL injection.

// Original Query (VULNERABLE)
// $query=mysqli_query($con,"insert into tblcontactus(fullname,email,contactno,message) value('$name','$email','$mobileno','$dscrption')");

// Safer Query using mysqli_real_escape_string on all inputs
$query = mysqli_query($con, "INSERT INTO tblcontactus(fullname, email, contactno, message) 
                                 VALUES ('$name', '$email', '$mobileno', '$dscrption')");

if($query) {
    echo "<script>alert('Your information successfully submitted');</script>";
} else {
    // Error handling
    echo "<script>alert('Error submitting information: " . mysqli_error($con) . "');</script>";
}

echo "<script>window.location.href ='index.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MedPoint - Healthcare Management System</title>

    <link rel="shortcut icon" href="assets/images/fav.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    
    <style>
        /*
         * ====================================================================
         * MODERN BLUE THEME STYLES
         * ====================================================================
         */

        :root {
            --primary-blue: #007bff; /* Main Blue */
            --secondary-blue: #0056b3; /* Darker Blue */
            --accent-cyan: #17a2b8; /* Cyan/Teal Accent */
            --light-gray: #f8f9fa; /* Section Background */
            --white: #ffffff;
            --dark-text: #212529;
            --muted-text: #6c757d;
            --box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            --gradient-blue: linear-gradient(135deg, var(--primary-blue) 0%, #0099ff 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif !important;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            background: var(--light-gray);
            color: var(--dark-text);
            overflow-x: hidden;
        }
        
        /* ============= HEADER / NAVBAR ============= */
        .header-modern {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: var(--box-shadow);
            padding: 18px 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .header-modern.scrolled {
            padding: 10px 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .logo-text {
            font-size: 34px;
            font-weight: 900;
            background: var(--gradient-blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1.5px;
            margin: 0;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
            gap: 30px; 
            margin: 0;
            padding: 0;
            align-items: center;
        }
        
        .nav-links a {
            color: var(--dark-text);
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            position: relative;
            padding: 5px 0;
        }
        
        .nav-links a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: var(--primary-blue);
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        
        .nav-links a:hover::before {
            width: 100%;
        }
        
        .nav-links a:hover {
            color: var(--primary-blue);
        }
        
        /* Primary Call-to-Action Button */
        .btn-book {
            background: var(--gradient-blue);
            color: var(--white) !important;
            padding: 12px 32px;
            border-radius: 30px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 10px 20px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
            border: none;
            font-size: 14px;
            letter-spacing: 0.5px;
        }
        
        .btn-book:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(0, 123, 255, 0.45);
            color: var(--white) !important;
        }
        
        /* ============= CAROUSEL / HERO ============= */
        .hero-carousel {
            margin-top: 85px;
            position: relative;
        }
        
        .carousel-item {
            height: 700px;
            position: relative;
        }
        
        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.5); /* Make images darker for better text contrast */
        }
        
        .gradient-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* Lighter blue overlay for a fresher look */
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.8) 0%, rgba(23, 162, 184, 0.8) 100%);
        }
        
        .hero-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: var(--white);
            z-index: 3;
            width: 85%;
            max-width: 1000px;
        }
        
        .hero-text h1 {
            font-size: 68px; /* Slightly refined size */
            font-weight: 900;
            margin-bottom: 25px;
            line-height: 1.1;
            letter-spacing: -2.5px;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            animation: fadeInUp 0.8s ease;
        }
        
        .hero-text p {
            font-size: 22px;
            margin-bottom: 40px;
            opacity: 0.95;
            font-weight: 400;
            line-height: 1.6;
            max-width: 750px;
            margin-left: auto;
            margin-right: auto;
            animation: fadeInUp 1s ease;
        }
        
        .hero-features {
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 40px;
            animation: fadeInUp 1.2s ease;
        }
        
        .feature-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            padding: 14px 25px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
        }
        
        .feature-badge:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-3px);
        }
        
        .feature-badge i {
            font-size: 20px;
            color: var(--white);
        }
        
        .feature-badge span {
            font-size: 14px;
            font-weight: 600;
            color: var(--white);
            letter-spacing: 0.5px;
        }
        
        .hero-stats {
            display: flex;
            gap: 60px;
            justify-content: center;
            margin-top: 50px;
            animation: fadeInUp 1.4s ease;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 42px;
            font-weight: 900;
            color: var(--white);
            line-height: 1;
            margin-bottom: 8px;
            text-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }
        
        .stat-label {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
        }
        
        /* ============= SECTIONS ============= */
        .section-wrapper {
            padding: 100px 0;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-header h2 {
            font-size: 44px;
            font-weight: 800;
            background: var(--gradient-blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
            letter-spacing: -1.5px;
        }
        
        .section-header p {
            font-size: 18px;
            color: var(--muted-text);
            font-weight: 400;
            max-width: 650px;
            margin: 0 auto;
        }
        
        /* ============= ABOUT US ============= */
        #about .col-lg-6:first-child {
            padding-right: 30px; /* Space out the image and text */
        }

        #about img {
            max-height: 450px; /* Set max height for better presentation */
        }
        
        #about h3 {
            font-size: 34px;
            font-weight: 800;
            color: var(--dark-text);
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        #about p {
            font-size: 16px;
            color: var(--muted-text);
            line-height: 1.7;
        }
        
        /* ============= LOGIN CARDS ============= */
        .portal-card {
            background: var(--white);
            border-radius: 20px; /* Slightly softer corners */
            padding: 45px 35px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--light-gray);
            transition: all 0.4s cubic-bezier(0.2, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            height: 100%;
        }
        
        .portal-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--primary-blue);
            transition: all 0.4s ease;
        }
        
        .portal-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 123, 255, 0.15);
            border-color: rgba(0, 123, 255, 0.2);
        }
        
        .portal-icon {
            width: 90px;
            height: 90px;
            background: var(--gradient-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.3);
            transition: all 0.4s ease;
        }
        
        .portal-card:hover .portal-icon {
            transform: scale(1.1);
            box-shadow: 0 15px 40px rgba(0, 123, 255, 0.4);
        }
        
        .portal-icon i {
            font-size: 40px;
            color: var(--white);
        }
        
        .portal-card h3 {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }
        
        .portal-card p {
            color: var(--muted-text);
            font-size: 15px;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        
        .btn-portal {
            background: var(--gradient-blue);
            color: var(--white);
            padding: 14px 45px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
            border: none;
            display: inline-block;
            font-size: 15px;
        }
        
        .btn-portal:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0, 123, 255, 0.4);
            color: var(--white);
            text-decoration: none;
        }

        /* ============= CONTACT INFO CARDS (Reusing portal-card style) ============= */
        #contact .portal-card {
            border: none;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 40px;
            transition: transform 0.3s ease;
            height: auto;
        }
        #contact .portal-card:hover {
            transform: translateY(-5px);
        }
        #contact .portal-card::before {
            display: none;
        }
        #contact .contact-icon-wrap {
            width: 65px;
            height: 65px;
            background: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }
        #contact .contact-icon-wrap i {
            font-size: 28px;
            color: var(--white);
        }
        #contact h4 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 10px;
        }
        #contact p {
            color: var(--muted-text);
            font-size: 15px;
        }
        
        /* Contact Form Fields */
        #contact .form-control {
            padding: 14px 18px;
            border: 1px solid #ced4da;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        #contact .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        /* ============= SERVICE CARDS ============= */
        .service-box {
            background: var(--white);
            border-radius: 18px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--light-gray);
            transition: all 0.4s ease;
            margin-bottom: 30px;
            height: 100%;
        }
        
        .service-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 123, 255, 0.1);
            border-color: rgba(0, 123, 255, 0.1);
        }
        
        .service-icon-wrap {
            width: 80px;
            height: 80px;
            background: rgba(0, 123, 255, 0.1); /* Lighter blue background */
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            transition: all 0.4s ease;
        }
        
        .service-box:hover .service-icon-wrap {
            background: var(--gradient-blue);
            transform: scale(1.1);
        }
        
        .service-icon-wrap i {
            font-size: 36px;
            color: var(--primary-blue);
            transition: all 0.4s ease;
        }
        
        .service-box:hover .service-icon-wrap i {
            color: var(--white);
        }
        
        .service-box h5 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark-text);
            margin: 15px 0 10px 0;
            letter-spacing: -0.5px;
        }
        
        .service-box p {
            color: var(--muted-text);
            font-size: 15px;
            line-height: 1.6;
        }
        
        /* ============= GALLERY ============= */
        .gallery-wrap {
            background: var(--light-gray);
            padding: 100px 0;
        }
        
        .filter-bar {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .btn-filter {
            background: var(--white);
            color: var(--dark-text);
            padding: 10px 25px;
            border-radius: 20px;
            font-weight: 500;
            border: 1px solid #ced4da;
            margin: 6px;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-filter:hover,
        .btn-filter.active {
            background: var(--primary-blue);
            color: var(--white);
            border-color: var(--primary-blue);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
        }
        
        .gallery-image {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            transition: all 0.4s ease;
            cursor: pointer;
        }
        
        .gallery-image:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .gallery-image img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: all 0.4s ease;
        }
        
        .gallery-image:hover img {
            transform: scale(1.03);
        }
        
        /* ============= FOOTER ============= */
        .footer-wrap {
            background: var(--secondary-blue);
            color: var(--white);
            padding: 30px 0;
            text-align: center;
        }
        
        .footer-wrap p {
            margin: 0;
            font-size: 15px;
            font-weight: 400;
            opacity: 0.9;
        }
        
        /* ============= RESPONSIVE ============= */
        @media (max-width: 992px) {
            .nav-links {
                display: none;
            }
            .logo-text {
                font-size: 30px;
            }
        }

        @media (max-width: 768px) {
            .hero-text h1 {
                font-size: 42px;
            }
            
            .hero-text p {
                font-size: 18px;
            }
            
            .section-header h2 {
                font-size: 32px;
            }
            
            .carousel-item {
                height: 500px;
            }

            .stat-number {
                font-size: 36px;
            }

            #about .col-lg-6:first-child {
                padding-right: 15px;
            }
            
            #about img {
                max-height: 300px;
                margin-bottom: 50px;
            }
        }
    </style>
</head>
<body>
    <header class="header-modern">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-6">
                    <h1 class="logo-text">MedPoint</h1>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <ul class="nav-links" style="justify-content: center;">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#gallery">Gallery</a></li>
                        <li><a href="#about" style="white-space: nowrap;">About Us</a></li> 
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="#logins">Logins</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-6 text-right">
                    <a href="medpoint/user-login.php" class="btn-book">
                        <i class="fas fa-right-to-bracket"></i> Book Now
                    </a>
                </div>
            </div>
        </div>
    </header>

    <section id="home" class="hero-carousel">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            </ol>
            
            <div class="carousel-inner">
                <div class="carousel-item">
                     
                    <img src="assets/images/slider/slider_4.jpg" alt="Healthcare">
                    <div class="gradient-overlay"></div>
                    <div class="hero-text">
                        <h1>Excellence in Comprehensive Healthcare</h1>
                        <p>World-class medical services with compassion and expertise for you and your family, available 24/7.</p>
                        <div class="hero-features">
                            <div class="feature-badge">
                                <i class="fas fa-shield-heart"></i>
                                <span>Trusted Care</span>
                            </div>
                            <div class="feature-badge">
                                <i class="fas fa-clock"></i>
                                <span>24/7 Available</span>
                            </div>
                            <div class="feature-badge">
                                <i class="fas fa-user-doctor"></i>
                                <span>Expert Doctors</span>
                            </div>
                        </div>
                        <div class="hero-stats">
                            <div class="stat-item">
                                <div class="stat-number">500+</div>
                                <div class="stat-label">Doctors</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">50k+</div>
                                <div class="stat-label">Happy Patients</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">20+</div>
                                <div class="stat-label">Specialties</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="carousel-item active">
                    
                    <img src="assets/images/slider/slider_5.jpg" alt="Medical Care">
                    <div class="gradient-overlay"></div>
                    <div class="hero-text">
                        <h1>Your Health, Our Top Priority</h1>
                        <p>Modern facilities and experienced doctors providing comprehensive and personalized healthcare solutions.</p>
                        <div class="hero-features">
                            <div class="feature-badge">
                                <i class="fas fa-hospital"></i>
                                <span>Modern Facilities</span>
                            </div>
                            <div class="feature-badge">
                                <i class="fas fa-medal"></i>
                                <span>Award Winning</span>
                            </div>
                            <div class="feature-badge">
                                <i class="fas fa-heart-pulse"></i>
                                <span>Advanced Care</span>
                            </div>
                        </div>
                        <div class="hero-stats">
                            <div class="stat-item">
                                <div class="stat-number">15+</div>
                                <div class="stat-label">Years Experience</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">98%</div>
                                <div class="stat-label">Success Rate</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">100k+</div>
                                <div class="stat-label">Treatments</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>

    <section id="about" class="section-wrapper">
        <div class="container">
            <div class="section-header">
                <h2>About MedPoint</h2>
                <p>Committed to excellence in healthcare delivery and patient well-being.</p>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4">
                    <div style="position: relative;">
                        <img src="assets/images/slider/slider_5.jpg" alt="About Us" class="img-fluid" style="border-radius: 20px; box-shadow: 0 15px 45px rgba(0,0,0,0.1);">
                        <div style="position: absolute; bottom: -20px; right: -20px; background: var(--primary-blue); padding: 25px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 123, 255, 0.4);">
                            <div style="text-align: center; color: white;">
                                <div style="font-size: 38px; font-weight: 800; line-height: 1;">15+</div>
                                <div style="font-size: 13px; font-weight: 600; margin-top: 3px;">Years of Excellence</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <h3>Your Dedicated Health Partner</h3>
                    <p>MedPoint has been at the forefront of healthcare excellence for over 15 years. We seamlessly integrate **cutting-edge medical technology** with compassionate care to provide comprehensive healthcare solutions tailored for every individual.</p>
                    <p>Our team of highly experienced doctors and dedicated medical professionals are passionate about your well-being, utilizing **personalized treatment plans** and our state-of-the-art facilities to ensure the best possible outcomes.</p>
                    <div class="d-flex flex-wrap" style="gap: 30px;">
                        <div class="d-flex align-items-center" style="gap: 15px;">
                            <div class="contact-icon-wrap" style="background: rgba(0, 123, 255, 0.1); box-shadow: none;">
                                <i class="fas fa-check-circle" style="font-size: 26px; color: var(--primary-blue);"></i>
                            </div>
                            <div>
                                <div style="font-size: 17px; font-weight: 600; color: var(--dark-text);">Certified</div>
                                <div style="font-size: 14px; color: var(--muted-text);">ISO Certified Facilities</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 15px;">
                            <div class="contact-icon-wrap" style="background: rgba(0, 123, 255, 0.1); box-shadow: none;">
                                <i class="fas fa-award" style="font-size: 26px; color: var(--primary-blue);"></i>
                            </div>
                            <div>
                                <div style="font-size: 17px; font-weight: 600; color: var(--dark-text);">Excellence</div>
                                <div style="font-size: 14px; color: var(--muted-text);">Award-Winning Service</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="logins" class="section-wrapper" style="background: var(--light-gray);">
        <div class="container">
            <div class="section-header">
                <h2>Access Your Account</h2>
                <p>Choose your portal to login and seamlessly manage your healthcare journey.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="portal-card">
                        <div class="portal-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3>Patient Portal</h3>
                        <p>Book appointments, view lab results, and manage your health records securely.</p>
                        <a href="medpoint/user-login.php" class="btn-portal">
                            Login Now
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="portal-card">
                        <div class="portal-icon">
                            <i class="fas fa-user-doctor"></i>
                        </div>
                        <h3>Doctor Portal</h3>
                        <p>Manage appointments, access patient history, and update clinical notes efficiently.</p>
                        <a href="medpoint/doctor" class="btn-portal">
                            Login Now
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="portal-card">
                        <div class="portal-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h3>Admin Portal</h3>
                        <p>System administration, complete management control, and reporting tools.</p>
                        <a href="medpoint/admin" class="btn-portal">
                            Login Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="section-wrapper">
        <div class="container">
            <div class="section-header">
                <h2>Our Specialized Medical Services</h2>
                <p>Comprehensive healthcare solutions delivered by top specialists with clinical excellence.</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="service-box">
                        <div class="service-icon-wrap">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h5>Cardiology</h5>
                        <p>Expert heart care using advanced diagnostics and cardiovascular treatments.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-box">
                        <div class="service-icon-wrap">
                            <i class="fas fa-bone"></i>
                        </div>
                        <h5>Orthopedics</h5>
                        <p>Comprehensive bone, joint, and muscle care for improved mobility and recovery.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-box">
                        <div class="service-icon-wrap">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h5>Neurology</h5>
                        <p>Specialized care for disorders of the brain and nervous system by leading experts.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-box">
                        <div class="service-icon-wrap">
                            <i class="fas fa-capsules"></i>
                        </div>
                        <h5>Pharmacy Pipeline</h5>
                        <p>Ensuring timely access to quality medications and the latest pharmaceutical treatments.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-box">
                        <div class="service-icon-wrap">
                            <i class="fas fa-prescription-bottle"></i>
                        </div>
                        <h5>Medication Management</h5>
                        <p>Professional oversight and consultation for all your prescription and pharmacy needs.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-box">
                        <div class="service-icon-wrap">
                            <i class="fas fa-microscope"></i>
                        </div>
                        <h5>Diagnostics & Lab</h5>
                        <p>Precise and rapid laboratory testing for accurate and timely diagnosis.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="gallery" class="gallery-wrap">
        <div class="container">
            <div class="section-header">
                <h2>Our Modern Facilities</h2>
                <p>Explore the clean and advanced environment where your care takes place.</p>
            </div>
            <div class="filter-bar">
                <button class="btn-filter active" data-filter="all">All</button>
                <button class="btn-filter" data-filter="hdpe">Dental</button>
                <button class="btn-filter" data-filter="sprinkle">Cardiology</button>
                <button class="btn-filter" data-filter="spray">Neurology</button>
                <button class="btn-filter" data-filter="irrigation">Laboratory</button>
            </div>
            <div class="row" id="galleryContainer">
                <div class="col-lg-4 col-md-6 filter hdpe">
                    <div class="gallery-image">
                         
                        <img src="assets/images/gallery/dental.jpg" alt="Dental Clinic">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 filter sprinkle">
                    <div class="gallery-image">
                        
                        <img src="assets/images/gallery/cardiology.jpg" alt="Cardiology Unit">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 filter hdpe">
                    <div class="gallery-image">
                        
                        <img src="assets/images/gallery/gallery_03.jpg" alt="Examination Room">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 filter irrigation">
                    <div class="gallery-image">
                        
                        <img src="assets/images/gallery/kabir.jpg" alt="Medical Laboratory">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 filter spray">
                    <div class="gallery-image">
                        
                        <img src="assets/images/gallery/gallery_05.jpg" alt="Diagnostic Imaging">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 filter spray">
                    <div class="gallery-image">
                        
                        <img src="assets/images/gallery/gallery_06.jpg" alt="Patient Waiting Area">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="section-wrapper">
        <div class="container">
            <div class="section-header">
                <h2>Get In Touch</h2>
                <p>We'd love to hear from you. Reach out to our team today for inquiries or support.</p>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="portal-card">
                        <div class="contact-icon-wrap">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Visit Our Clinic</h4>
                        <p>123 Medical Center Drive<br>Healthcare City, HC 12345<br>Philippines</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="portal-card">
                        <div class="contact-icon-wrap">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h4>Call Our Hotline</h4>
                        <p>Phone: +63 123 456 7890<br>Emergency: +63 987 654 3210<br>**Available 24/7**</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="portal-card">
                        <div class="contact-icon-wrap">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email Us Directly</h4>
                        <p>info@medpoint.com<br>support@medpoint.com<br>appointments@medpoint.com</p>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-lg-8 mx-auto">
                    <div class="portal-card">
                        <h3>Send Us a Message</h3>
                        <form method="post">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <input type="text" name="fullname" class="form-control" placeholder="Your Full Name" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <input type="email" name="emailid" class="form-control" placeholder="Your Email Address" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <input type="text" name="mobileno" class="form-control" placeholder="Your Phone Number" required>
                            </div>
                            <div class="mb-4">
                                <textarea name="description" class="form-control" rows="5" placeholder="Your Message or Inquiry" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="submit" class="btn-portal" style="padding: 16px 50px;">
                                    <i class="fas fa-paper-plane"></i> Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer-wrap">
        <div class="container">
            <p>© 2025 MedPoint - Doctor Appointment Management System. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
    <script>
        // Navbar scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header-modern');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    // Calculate offset for fixed header
                    const headerHeight = document.querySelector('.header-modern').offsetHeight;
                    const targetPosition = target.offsetTop - headerHeight - 10; // 10px extra padding
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Gallery filter
        document.querySelectorAll('.btn-filter').forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                document.querySelectorAll('.btn-filter').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                document.querySelectorAll('#galleryContainer > [class*="filter"]').forEach(item => {
                    // Check if the item should be visible
                    const isVisible = (filter === 'all' || item.classList.contains(filter));

                    // Use display: none/block for filtering
                    if (isVisible) {
                        item.style.display = 'block'; 
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>