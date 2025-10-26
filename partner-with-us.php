<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner with Us - Architecture & Interior Design Partnership</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="split-img/Logo.png" rel="icon">

    <style>
        :root {
            --primary-color: #15537A;
            --secondary-color: #10b981;
            --accent-color: #f59e0b;
            --success-color: #10b981;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        html {
            scroll-behavior: smooth;
        }

        /* Header Styles */
        .main-header {
            background: rgba(1, 78, 121, 0.1);
            color: #014e79;

            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: white !important;
        }

        .navbar-nav .nav-link {
            color: #014e79 !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            color: rgb(0, 0, 0) !important;
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 50%;
            background-color: var(--accent-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }

        .btn-header {
            background: green;
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-header:hover {
            background: #014e79;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
            color: white;
        }

        /* Hero Section */
        .hero-section {
            background: #014e79;
            color: white;
            padding: 30px 0 30px;
            position: relative;
            overflow: hidden;

        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .commission-badge {
            background: var(--secondary-color);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            display: inline-block;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .section-padding {
            padding: 30px 0;
            background: rgba(1, 78, 121, 0.1);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            text-align: center;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .why-partner-card {
            background: white;
            border-radius: 15px;
            padding: 40px 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .why-partner-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .why-partner-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary-color);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.2);
        }

        .why-partner-card:hover::before {
            left: 100%;
        }

        .card-icon {
            width: 70px;
            height: 70px;
            background: #014e79;
            ;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2rem;
            color: white;
            transition: all 0.3s ease;
        }

        .why-partner-card:hover .card-icon {
            transform: rotateY(180deg);
        }

        .process-timeline {
            position: relative;
            padding: 50px 0;
        }

        .timeline-item {
            position: relative;
            padding-left: 60px;
            margin-bottom: 50px;
        }

        .timeline-number {
            position: absolute;
            left: 0;
            top: 0;
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .timeline-number h4 {
            color: #014e79;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 19px;
            top: 40px;
            width: 2px;
            height: calc(100% + 10px);
            background: linear-gradient(to bottom, var(--primary-color), var(--accent-color));
        }

        .timeline-item:last-child::before {
            display: none;
        }

        .timeline-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-left: 20px;
            transition: all 0.3s ease;
        }

        .timeline-content:hover {
            transform: translateX(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .cta-section {
            background: #014e79;
            ;
            color: white;
            padding: 80px 0;
            position: relative;
        }

        .cta-button {
            background: black;
            color: var(--success-color);
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            cursor: pointer;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            color: var(--success-color);
        }

        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
            transform: rotate(45deg);
        }

        .shape:nth-child(3) {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            top: 40%;
            left: 80%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .counter {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            display: block;
        }

        .stats-section {
            background: var(--bg-light);
            padding: 60px 0;
        }

        .stat-card {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        /* Partners Section */
        .scroll-wrapper {
            overflow: hidden;
            position: relative;
            width: 100%;
            background-color: #f9f9f9;
            padding: 40px 0;
        }

        .scroll-track {
            display: flex;
            width: max-content;
            animation: scroll-left 30s linear infinite;
        }

        .partner-card {
            flex: 0 0 auto;
            width: 200px;
            height: 150px;
            margin: 10px 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .partner-card img {
            max-width: 180px;
            max-height: 120px;
            object-fit: contain;
            filter: grayscale(100%);
            transition: filter 0.3s ease, transform 0.3s ease;
        }

        .partner-card:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        .partner-card:hover img {
            filter: grayscale(0%);
        }

        @keyframes scroll-left {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        /* Contact Form Popup */
        .popup-overlay {
            display: none;
            position: fixed;
            z-index: 2000;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .popup-box {
            background: #fff;
            padding: 40px;

            width: 50%;
            border-radius: 15px;
            position: relative;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            max-height: 90vh;
            overflow-y: auto;
        }

        .popup-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 28px;
            cursor: pointer;
            color: #555;
            transition: color 0.3s ease;
        }

        .popup-close:hover {
            color: var(--primary-color);
        }

        .popup-box h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .popup-box form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .popup-box input,
        .popup-box select,
        .popup-box textarea {
            padding: 15px;
            border: 2px solid #e5e5e5;
            border-radius: 8px;
            font-size: 16px;
            resize: none;
            transition: border-color 0.3s ease;
        }

        .popup-box input:focus,
        .popup-box select:focus,
        .popup-box textarea:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .popup-box textarea {
            height: 120px;
        }

        .popup-box button {
            padding: 15px;
            background: var(--primary-color);
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .popup-box button:hover {
            background: #0f4052;
            transform: translateY(-2px);
        }

        /* Footer Styles */
        .main-footer {
            background: linear-gradient(135deg, #1f2937, #111827);
            color: white;
            padding: 60px 0 20px;
        }

        .footer-section h5 {
            color: var(--accent-color);
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
        }

        .footer-section h5::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--accent-color);
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section ul li a {
            color: #d1d5db;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-section ul li a:hover {
            color: var(--accent-color);
            padding-left: 5px;
        }

        .social-links a {
            display: inline-block;
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-align: center;
            line-height: 45px;
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--accent-color);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            /* margin-top: 40px; */
            padding-top: 20px;
        }

        .company-info {
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .company-logo {
            font-size: 2rem;
            font-weight: 800;
            color: var(--accent-color);
            margin-bottom: 15px;
        }

        /* Social Icons in CTA */
        .social-icons a {
            color: #ffffff;
            transition: color 0.3s ease, transform 0.3s ease;
            margin: 0 10px;
            font-size: 1.5rem;
        }

        .social-icons a:hover {
            transform: scale(1.2);
        }

        .social-icon.facebook:hover {
            color: #1877f2;
        }

        .social-icon.instagram:hover {
            color: #e4405f;
        }

        .social-icon.linkedin:hover {
            color: #0a66c2;
        }

        .social-icon.twitter:hover {
            color: #1da1f2;
        }

        .cta-btn {
            transition: all 0.3s ease-in-out;
            margin: 10px;
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* Success message */
        .success-message {
            background: var(--success-color);
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        .error-message {
            background: #dc3545;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }

            .hero-section {
                padding: 100px 0 60px;
            }

            .section-padding {
                padding: 50px 0;
            }

            .timeline-item {
                padding-left: 50px;
            }

            .navbar-nav {
                text-align: center;
                margin-top: 15px;
            }

            .navbar-nav .nav-link {
                margin: 5px 0;
            }

            .partner-card {
                width: 140px;
                height: 100px;
                margin: 10px;
            }

            .partner-card img {
                max-width: 120px;
                max-height: 80px;
            }

            .popup-box {
                margin: 20px;
                padding: 30px;
            }

            .cta-btn {
                display: block;
                width: 100%;
                margin: 10px 0;
            }
        }

        @media (max-width: 480px) {
            .hero-section {
                padding: 80px 0 40px;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .popup-box {
                padding: 20px;
            }
        }
    </style>

    <style>
        footer {

            color: #fff;
        }

        /* CTA bar */
        .cta-bar {
            background: linear-gradient(to right, #1d5e82, #39505e);
            color: #fff;
            padding: 25px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 12px;
            margin: 0 auto;
            max-width: 1100px;
            transform: translateY(50%);
            position: relative;
            z-index: 2;
            border: 1px solid;
        }

        .cta-text {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .cta-action span {
            margin-right: 10px;
            font-weight: 600;
        }

        .cta-action .btn {
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: #fff;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
        }

        /* Footer main */
        .footer-main {
            background: #014e79;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 100px 40px 50px;
        }

        .footer-logo {
            flex: 1 1 200px;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .footer-logo img {
            height: 40px;
            margin-right: 10px;
        }

        .footer-logo .logo-text {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .footer-column {
            flex: 1 1 200px;
            margin: 10px;
        }

        .footer-column h4 {
            margin-bottom: 15px;
            font-size: 1rem;
            color: white;
        }

        .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-column ul li {
            margin-bottom: 8px;
        }

        .footer-column ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 0.9rem;
        }

        .footer-column ul li a:hover {
            text-decoration: underline;
        }

        /* Social */
        .social-icons {
            margin-bottom: 20px;
        }

        .social-icons a {
            color: #fff;
            margin-right: 12px;
            font-size: 1.2rem;
        }

        /* Subscribe */
        .subscribe p {
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .subscribe form {
            display: flex;
            margin-top: 10px;
        }

        .subscribe input {
            padding: 10px;
            border: none;
            border-radius: 25px 0 0 25px;
            outline: none;
            flex: 1;
        }

        .subscribe button {
            padding: 10px 20px;
            border: none;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: #fff;
            border-radius: 0 25px 25px 0;
            cursor: pointer;
            font-weight: bold;
        }

        /* Bottom bar */
        .footer-bottom {
            background: #014e79;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            font-size: 0.85rem;
        }

        .footer-links a {
            margin-right: 15px;
            text-decoration: none;
            color: #fff;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */

        /* Tablets */
        @media (max-width: 992px) {
            .cta-bar {
                flex-direction: column;
                text-align: center;
                gap: 15px;
                padding: 20px;
            }

            .cta-text {
                font-size: 1.2rem;
            }

            .cta-action span {
                display: block;
                margin-bottom: 8px;
            }

            .footer-main {
                flex-direction: column;
                text-align: center;
                padding: 80px 20px 40px;
            }

            .footer-logo {
                justify-content: center;
            }

            .footer-column {
                margin: 20px 0;
            }

            .social-icons {
                justify-content: center;
            }

            .subscribe form {
                flex-direction: column;
            }

            .subscribe input,
            .subscribe button {
                border-radius: 25px;
                margin: 5px 0;
                width: 100%;
            }
        }

        /* Mobile */
        @media (max-width: 576px) {
            .cta-bar {
                padding: 15px;
                font-size: 0.9rem;
            }

            .cta-text {
                font-size: 1rem;
            }

            .cta-action .btn {
                display: inline-block;
                padding: 8px 16px;
                font-size: 0.85rem;
            }

            .footer-main {
                padding: 60px 15px 30px;
            }

            .footer-column h4 {
                font-size: 0.95rem;
            }

            .footer-column ul li a {
                font-size: 0.85rem;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
                padding: 15px;
            }

            .footer-links {
                margin-bottom: 10px;
            }

            .footer-links a {
                display: block;
                margin: 5px 0;
            }
        }
    </style>

    <style>
        /* Autocomplete dropdown container */
        #autocomplete-results {
            position: absolute;
            top: 45px;
            /* Adjust based on your input's position */
            left: 0;
            right: 0;
            width: 136%;
            max-height: 250px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            z-index: 9999;
            list-style: none;
            padding: 0;
            margin: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Each suggestion item */
        .autocomplete-item {
            padding: 10px 12px;
            text-align: left;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s ease;
        }

        /* Last item (remove border) */
        .autocomplete-item:last-child {
            border-bottom: none;
        }

        /* Hover effect */
        .autocomplete-item:hover {
            background-color: #f5f5f5;
        }

        /* Optional: Style for "No results found" message */
        #autocomplete-results li {
            padding: 10px 12px;
            color: black;
            font-style: italic;
        }

        #ff-77 {
            display: none !important;
        }

        .new_cls {
            margin-top: 57px;
        }
    </style>

    <style>
        .logo {
            width: 150px;


        }

        .location {
            margin-left: 16px;
            color: black
        }

        .location a {
            color: black;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
        }

        .fa.fa-shopping-cart {
            font-size: 30px;
        }

        .amazon-header {
            background: linear-gradient(to bottom, rgba(1, 78, 121, 0.2), #fcfeff 113%);
            color: white;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .amazon-header a {
            color: black;
            text-decoration: none;
            margin: 0 10px;
        }

        .top-bar {
            padding: 10px;
        }

        .search-bar {
            flex: 0.8;
            margin: 0 20px;

        }

        .search-select {
            padding: 5px;
            border-right: 1px solid black;
        }

        .account {
            color: black;
        }

        .search-input {
            flex: 40%;
            padding: 8px;
            border-radius: 6px;

        }

        .search-btn {
            background: #568143;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            color: white;
        }

        .cart-badge {
            position: absolute;
            top: 0;
            right: -8px;
            background: #568143;
            color: black;
            font-weight: bold;
            border-radius: 50%;
            padding: 2px 6px;
            color: white;
        }

        .bottom-nav {
            background: #014e79;
            padding: 10px;
        }

        .bottom-nav a {
            color: white;
            margin-right: 15px;
            font-weight: 700;
        }

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Roboto", sans-serif;
            font-optical-sizing: auto;

            font-style: normal;

        }
    </style>




    <style>
        /* Mobile Drawer (hidden by default) */
        .mobile-drawer {
            position: fixed;
            top: 0;
            left: -100%;
            /* hidden outside screen */
            width: 75%;
            /* drawer width */
            height: 100%;
            background: #fff;
            padding: 20px;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            transition: left 0.3s ease-in-out;
            overflow-y: auto;
        }

        /* When open */
        .mobile-drawer.open {
            left: 0;
        }

        /* Location Section */
        .mobile-drawer .location {
            margin-bottom: 15px;
            font-size: 14px;
        }

        .mobile-drawer .location a {
            font-size: 13px;
            color: #007185;
            text-decoration: none;
        }

        .mobile-drawer .location a:hover {
            text-decoration: underline;
        }

        /* Search bar */
        .mobile-drawer .search-bar {
            margin: 15px 0;
        }

        .mobile-drawer .search-bar input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Account section */
        .mobile-drawer .account {
            margin: 15px 0;
            font-size: 14px;
        }

        .mobile-drawer .account a {
            color: #007185;
            font-weight: bold;
            text-decoration: none;
        }

        .mobile-drawer .account a:hover {
            text-decoration: underline;
        }

        /* Cart section */
        .mobile-drawer .cart {
            margin: 15px 0;
        }

        .mobile-drawer .cart a {
            color: #111;
            font-size: 16px;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .mobile-drawer .cart i {
            margin-right: 8px;
        }

        /* Navigation links */
        .mobile-drawer nav {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        .mobile-drawer nav a {
            padding: 10px 0;
            font-size: 15px;
            color: #111;
            text-decoration: none;
            border-bottom: 1px solid #eee;
        }

        .mobile-drawer nav a:hover {
            color: #e47911;
            /* Amazon-style orange */
        }

        /* Desktop default */
        .desktop-only {
            display: block;
        }

        .mobile-only {
            display: none;
        }

        .mobile-drawer {
            display: none;
        }

        /* Tablet & Mobile */
        @media (max-width: 992px) {
            .desktop-only {
                display: none !important;
            }

            .mobile-only {
                display: block;
            }

            .mobile-drawer {
                position: fixed;
                top: 0;
                left: -100%;
                width: 75%;
                height: 100%;
                background: #fff;
                padding: 20px;
                box-shadow: 2px 0 8px rgba(0, 0, 0, 0.3);
                z-index: 9999;
                transition: left 0.3s ease-in-out;
                overflow-y: auto;
                display: block;
            }

            .mobile-drawer.open {
                left: 0;
            }
        }
    </style>


    <style>
        .search-bar {
            position: relative;
            width: 30%;
            /* adjust */
        }

        .search-input {
            width: 100%;
            padding: 8px;
            padding-left: 10px;
        }

        .placeholder-wrapper {
            position: relative;
            flex: 1;
        }

        .placeholder-text {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #888;
            transition: transform 0.5s ease, opacity 0.5s ease;
        }

        .results-box {
            position: absolute;
            background: #fff;
            border: 1px solid #ccc;
            max-height: 416px;
            overflow-y: auto;
            width: 100%;
            z-index: 999;
            padding: 10px;
            top: 114%;
            border-radius: 3px;
            overflow-x: hidden;
        }

        #resultsList li {
            padding: 8px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            color: black;
        }

        #resultsList li:hover {
            background: #014e79;
            color: white;
            border-radius: 5px;
            /* box-shadow: 0px 0px 9px #0790dd; */
        }

        #previewBox {
            border-left: 1px solid #ddd;
            padding-left: 15px;
            min-height: 200px;
        }

        #previewBox h5 {
            margin-bottom: 20px;
        }

        .search-bar {

            margin: 0 20px;
            border: 1px solid black;
            border-radius: 6px;


        }

        .account a {
            margin: 0;
        }


        @media (max-width: 992px) {
            .mobile-only {
                display: block;
            }

            .hamburger {

                cursor: pointer;
                padding: 13px;
                border: 1px sol black;
                background: none;
                border-radius: 4px;
            }

        }
    </style>





    <style>
        footer {
            /* margin-top: 50px; */
            color: #fff;
        }

        /* CTA bar */
        .cta-bar {
            background: linear-gradient(to right, #1d5e82, #39505e);
            color: #fff;
            padding: 25px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 12px;
            margin: 0 auto;
            max-width: 1100px;
            transform: translateY(50%);
            position: relative;
            z-index: 2;
            border: 1px solid;
        }

        .cta-text {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .cta-action span {
            margin-right: 10px;
            font-weight: 600;
        }

        .cta-action .btn {
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: #fff;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
        }

        /* Footer main */
        .footer-main {

            background: linear-gradient(to top, rgba(1, 78, 121, 0.7), #fcfeff 113%);
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 100px 40px 50px;
        }

        .footer-logo {
            flex: 1 1 200px;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .footer-logo img {
            height: 40px;
            margin-right: 10px;
        }

        .footer-logo .logo-text {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .footer-column {
            flex: 1 1 200px;
            margin: 10px;
        }

        .footer-column h4 {
            margin-bottom: 15px;
            font-size: 1rem;
            color: rgba(1, 78, 121);
        }

        .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-column ul li {
            margin-bottom: 8px;
        }

        .footer-column ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 0.9rem;
        }

        .footer-column ul li a:hover {
            text-decoration: underline;
        }

        /* Social */
        .social-icons {
            margin-bottom: 20px;
        }

        .social-icons a {
            color: #fff;
            margin-right: 12px;
            font-size: 1.2rem;
        }

        /* Subscribe */
        .subscribe p {
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .subscribe form {
            display: flex;
            margin-top: 10px;
        }

        .subscribe input {
            padding: 10px;
            border: none;
            border-radius: 25px 0 0 25px;
            outline: none;
            flex: 1;
        }

        .subscribe button {
            padding: 10px 20px;
            border: none;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: #fff;
            border-radius: 0 25px 25px 0;
            cursor: pointer;
            font-weight: bold;
        }

        /* Bottom bar */
        .footer-bottom {
            background: #014e79;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            font-size: 0.85rem;
        }

        .footer-links a {
            margin-right: 15px;
            text-decoration: none;
            color: #fff;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */

        /* Tablets */
        @media (max-width: 992px) {
            .cta-bar {
                flex-direction: column;
                text-align: center;
                gap: 15px;
                padding: 20px;
            }

            .cta-text {
                font-size: 1.2rem;
            }

            .cta-action span {
                display: block;
                margin-bottom: 8px;
            }

            .footer-main {
                flex-direction: column;
                text-align: center;
                padding: 80px 20px 40px;
            }

            .footer-logo {
                justify-content: center;
            }

            .footer-column {
                margin: 20px 0;
            }

            .social-icons {
                justify-content: center;
            }

            .subscribe form {
                flex-direction: column;
            }

            .subscribe input,
            .subscribe button {
                border-radius: 25px;
                margin: 5px 0;
                width: 100%;
            }
        }

        /* Mobile */
        @media (max-width: 576px) {
            .cta-bar {
                padding: 15px;
                font-size: 0.9rem;
            }

            .cta-text {
                font-size: 1rem;
            }

            .cta-action .btn {
                display: inline-block;
                padding: 8px 16px;
                font-size: 0.85rem;
            }

            .footer-main {
                padding: 60px 15px 30px;
            }

            .footer-column h4 {
                font-size: 0.95rem;
            }

            .footer-column ul li a {
                font-size: 0.85rem;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
                padding: 15px;
            }

            .footer-links {
                margin-bottom: 10px;
            }

            .footer-links a {
                display: block;
                margin: 5px 0;
            }
        }

        .fab.fa-whatsapp {
            font-size: 24px;
            width: 70px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="index.php">
                    <img src="split-img/Logo.png" width="150" alt="Header Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto me-4">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#why-partner">About Partnership</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#our-partners">Our Partners</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#how-it-works">How It Works</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                    </ul>
                    <!-- <button class="btn btn-header" onclick="openPopup()">
                        <i class="fas fa-phone me-2"></i>Get Quote
                    </button> -->

                    <!-- ✅ WhatsApp Icon Button -->
                    <a href="https://wa.me/918171619719" target="_blank" class="btn btn-header btn-whatsapp">
                        <i class="fab fa-whatsapp"></i>
                    </a>

                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        <div class="container hero-content">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <p class="lead fs-2 mb-2">For Architects | Interior Designers | Contractors</p>
                    <p class="fs-5">Collaborate with Us and expand your reach to untapped customers</p>
                    <div class="commission-badge">
                        <i class="fas fa-star me-2"></i>0% Commission for One Year
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Partner Section -->
    <section id="why-partner" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Why should you partner with Splitfloor?</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="why-partner-card">
                        <div class="card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="fw-bold text-center mb-3">Engage Undiscovered Clients:</h4>
                        <p class="text-muted text-center">Splitfloor facilitates connections between architects/ interior designer and households through a unified platform.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="why-partner-card">
                        <div class="card-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-center">Design and Product Assistance:</h4>
                        <p class="text-muted text-center">Splitfloor provides support to architects, interior designers, and contractors in developing designs tailored to apartment specifications.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="why-partner-card">
                        <div class="card-icon">
                            <i class="fas fa-drafting-compass"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-center">Marketing:</h4>
                        <p class="text-muted text-center">Splitfloor shall assist Architects/ Interior Designers in marketing to connect with their target client. </p>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="why-partner-card">
                        <div class="card-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-center">Transparent Pricing:</h4>
                        <p class="text-muted text-center">Splitfloor maintains a policy of no hidden or additional fees.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- How It Works Section -->
    <section id="how-it-works" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">How It Works</h2>
                </div>
            </div>

            <div class="process-timeline">
                <div class="timeline-item">
                    <div class="timeline-number">1</div>
                    <div class="timeline-content">
                        <p class="text-muted mb-0">Architects and Interior Designers shall identify multi-storied apartments society and submit their layouts to Splitfloor for integration into the Splitfloor platform.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-number">2</div>
                    <div class="timeline-content">
                        <p class="text-muted mb-0">Architects and Interior Designers shall provide product designs or renovation models for various spaces, such as bathrooms, kitchens, bedrooms, balconies, and similar areas, for incorporation into the platform.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-number">3</div>
                    <div class="timeline-content">
                        <p class="text-muted mb-0">Splitfloor shall enhance the submitted apartment layouts and renovation models, which will then be uploaded to the platform</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-number">4</div>
                    <div class="timeline-content">
                        <p class="text-muted mb-0">Splitfloor will handle marketing efforts to connect with the customers/ households of the respective society.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-number">5</div>
                    <div class="timeline-content">
                        <p class="text-muted mb-0">Await customer onboarding to initiate business operations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

   
    <footer>


        <!-- Main footer -->
        <div class="footer-main">
            <!-- Logo -->
            <div class="footer-logo">
                <div class="row">
                    <div class="col-md-12">
                        <img src="split-img/Logo.png" alt="Site Logo">
                    </div>
                    <div class="col-md-12">
                        <p class="text-white">
                            Splitfloor offers a wide variety of renovation and upgradation options designed specifically for individual rooms in homes.
                        </p>
                    </div>
                </div>


            </div>

            <!-- Use Cases -->
            <div class="footer-column">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="product.php">Our Products</a></li>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>

            <!-- Company -->
            <div class="footer-column">
                <h4>Company</h4>
                <ul>
                    <li><a href="partner-with-us.php">Partner With Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">FAQs</a></li>
                </ul>
            </div>

            <!-- Social & Subscribe -->
            <div class="footer-column">
                <h4>Let's do it!</h4>
                <div class="social-icons">
                    <a href="https://m.facebook.com/61580851442530/" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="https://x.com/splitfloor?s=11" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/imsplitfloor/" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/splitfloor/" target="_blank"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom">
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Use</a>

                <a href="#">Site Map</a>
            </div>
            <div class="footer-copy">
                © 2025 All Rights Reserved
            </div>
        </div>
    </footer>


    </div>



    <?php $page = "";
    if ($page === 'index' || $page == 'splitfloor'  || $page == 'temp' || $page == 'payment'): ?>
        <!-- <script src="js/jquery-3.2.1.min.js"></script> -->
        <script src="https://code.jquery.com/jquery-3.3.0.min.js" integrity="sha256-RTQy8VOmNlT6b2PIRur37p6JEBZUE7o8wPgMvu18MC4=" crossorigin="anonymous"></script>
        <script src="styles/bootstrap4/popper.js"></script>
        <script src="styles/bootstrap4/bootstrap.min.js"></script>
        <script src="plugins/greensock/TweenMax.min.js"></script>
        <script src="plugins/greensock/TimelineMax.min.js"></script>
        <script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
        <script src="plugins/greensock/animation.gsap.min.js"></script>
        <script src="plugins/greensock/ScrollToPlugin.min.js"></script>
        <script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
        <script src="plugins/easing/easing.js"></script>
        <script src="plugins/parallax-js-master/parallax.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
        <script src="js/custom.js"></script>
    <?php endif; ?>

    <?php if ($page === 'blog'): ?>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="styles/bootstrap4/popper.js"></script>
        <script src="styles/bootstrap4/bootstrap.min.js"></script>
        <script src="plugins/easing/easing.js"></script>
        <script src="plugins/masonry/masonry.js"></script>
        <script src="plugins/video-js/video.min.js"></script>
        <script src="plugins/parallax-js-master/parallax.min.js"></script>
        <script src="js/blog.js"></script>
    <?php endif; ?>



    <?php
    if ($page == 'course' || $page == 'product_detail' || $page == 'payment_temp'): ?>
        <!-- 
<script src="js/jquery-3.2.1.min.js"></script> -->
        <script src="https://code.jquery.com/jquery-3.3.0.min.js" integrity="sha256-RTQy8VOmNlT6b2PIRur37p6JEBZUE7o8wPgMvu18MC4=" crossorigin="anonymous"></script>

        <script src="styles/bootstrap4/popper.js"></script>
        <script src="styles/bootstrap4/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
        <script src="plugins/easing/easing.js"></script>
        <script src="plugins/parallax-js-master/parallax.min.js"></script>
        <script src="plugins/colorbox/jquery.colorbox-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
        <script src="js/course.js"></script>

    <?php endif; ?>

    <?php
    if ($page == 'course1'): ?>
        <!-- 
<script src="js/jquery-3.2.1.min.js"></script> -->
        <script src="https://code.jquery.com/jquery-3.3.0.min.js" integrity="sha256-RTQy8VOmNlT6b2PIRur37p6JEBZUE7o8wPgMvu18MC4=" crossorigin="anonymous"></script>
        <script src="styles/bootstrap4/popper.js"></script>
        <script src="styles/bootstrap4/bootstrap.min.js"></script>
        <script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
        <script src="plugins/easing/easing.js"></script>
        <script src="plugins/parallax-js-master/parallax.min.js"></script>
        <script src="plugins/colorbox/jquery.colorbox-min.js"></script>
        <script src="js/course.js"></script>

    <?php endif; ?>

    <?php
    if ($page == 'product'): ?>

        <!-- <script src="js/jquery-3.2.1.min.js"></script> -->
        <script src="https://code.jquery.com/jquery-3.3.0.min.js" integrity="sha256-RTQy8VOmNlT6b2PIRur37p6JEBZUE7o8wPgMvu18MC4=" crossorigin="anonymous"></script>
        <script src="styles/bootstrap4/popper.js"></script>
        <script src="styles/bootstrap4/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
        <script src="plugins/easing/easing.js"></script>
        <script src="plugins/parallax-js-master/parallax.min.js"></script>
        <script src="plugins/colorbox/jquery.colorbox-min.js"></script>
        <script src="js/courses.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <?php endif; ?>

    <?php if ($page == 'about'): ?>

        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="styles/bootstrap4/popper.js"></script>
        <script src="styles/bootstrap4/bootstrap.min.js"></script>
        <script src="plugins/greensock/TweenMax.min.js"></script>
        <script src="plugins/greensock/TimelineMax.min.js"></script>
        <script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
        <script src="plugins/greensock/animation.gsap.min.js"></script>
        <script src="plugins/greensock/ScrollToPlugin.min.js"></script>
        <script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
        <script src="plugins/easing/easing.js"></script>
        <script src="plugins/parallax-js-master/parallax.min.js"></script>
        <script src="plugins/colorbox/jquery.colorbox-min.js"></script>
        <script src="js/about.js"></script>
    <?php endif; ?>


    <?php if ($page == 'contact'): ?>

        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="styles/bootstrap4/popper.js"></script>
        <script src="styles/bootstrap4/bootstrap.min.js"></script>
        <script src="plugins/easing/easing.js"></script>
        <script src="plugins/parallax-js-master/parallax.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCIwF204lFZg1y4kPSIhKaHEXMLYxxuMhA"></script>
        <script src="plugins/marker_with_label/marker_with_label.js"></script>
        <script src="js/contact.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    <?php endif; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="custom_js.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2
                },
                480: {
                    slidesPerView: 1
                }
            }
        });


        $('.home_slider').owlCarousel({
            loop: false,
            rewind: false,
            items: 1
        });
    </script>

    <script>
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", function() {
                navigator.serviceWorker
                    .register("/splitfloor/service-worker.js")
                    .then(reg => console.log("Service Worker registered", reg))
                    .catch(err => console.log("Service Worker failed", err));
            });
        }
    </script>




    <!-- Contact Form Popup -->
    <div class="popup-overlay" id="popupOverlay">
        <div class="popup-box">
            <span class="popup-close" onclick="closePopup()">&times;</span>
            <h3><i class="fas fa-handshake me-2"></i>Start Your Partnership</h3>

            <div class="success-message" id="successMessage">
                <i class="fas fa-check-circle me-2"></i>Thank you! We'll contact you within 24 hours.
            </div>

            <div class="error-message" id="errorMessage">
                <i class="fas fa-exclamation-circle me-2"></i>Please fill in all required fields.
            </div>

            <form id="partnershipForm" method="post" class="container mt-4">

                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6 mb-3">
                        <input type="text" id="fullName" name="fullName" class="form-control mb-3" placeholder="Full Name *" required>
                        <input type="email" id="email" name="email" class="form-control mb-3" placeholder="Email Address *" required>
                        <input type="tel" id="phone" name="phone" class="form-control mb-3" placeholder="Phone Number *" required>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6 mb-3">
                        <select id="profession" name="profession" class="form-select mb-3" required>
                            <option value="">Select Your Profession *</option>
                            <option value="architect">Architect</option>
                            <option value="interior-designer">Interior Designer</option>
                            <option value="contractor">Contractor</option>
                            <option value="other">Other</option>
                        </select>

                        <input type="number" id="experience" name="experience" class="form-control mb-3"
                            placeholder="Years of Experience *" min="0" required>
                        <input type="text" id="location" name="location" class="form-control mb-3" placeholder="Your Location/City *"
                            required>
                    </div>
                </div>

                <!-- Full width textarea -->
                <div class="mb-3">
                    <textarea id="message" name="message" class="form-control" rows="4"
                        placeholder="Tell us about your expertise and what type of projects you're interested in..."></textarea>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i> Submit Application
                </button>
            </form>


        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Counter animation
        function animateCounters() {
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = parseInt(counter.textContent);
                const increment = target / 100;
                let current = 0;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target + (counter.id === 'counter4' ? '%' : '+');
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current) + (counter.id === 'counter4' ? '%' : '+');
                    }
                }, 20);
            });
        }

        // Trigger counter animation when stats section is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        });

        observer.observe(document.querySelector('.stats-section'));

        // Popup functions
        function openPopup() {
            document.getElementById('popupOverlay').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closePopup() {
            document.getElementById('popupOverlay').style.display = 'none';
            document.body.style.overflow = 'auto';
            // Reset form and messages
            document.getElementById('partnershipForm').reset();
            document.getElementById('successMessage').style.display = 'none';
            document.getElementById('errorMessage').style.display = 'none';
        }

        // Close popup when clicking outside
        document.getElementById('popupOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closePopup();
            }
        });

        // Form submission

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.main-header');
            if (window.scrollY > 100) {
                header.style.background = '#014e79;';
                header.style.backdropFilter = 'blur(10px)';
            } else {
                header.style.background = '#014e79;';
                header.style.backdropFilter = 'none';
            }
        });

        // Add loading animation to cards
        const cards = document.querySelectorAll('.why-partner-card, .stat-card, .timeline-content');
        const cardObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });

        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease';
            cardObserver.observe(card);
        });
    </script>

    <script>
        document.getElementById("partnershipForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const form = this;
            const successMessage = document.getElementById("successMessage");
            const errorMessage = document.getElementById("errorMessage");

            // Hide messages initially
            successMessage.style.display = "none";
            errorMessage.style.display = "none";

            // Collect form data
            const formData = new FormData(form);

            // Basic validation
            const requiredFields = ["fullName", "email", "phone", "profession", "experience", "location"];
            for (const field of requiredFields) {
                if (!formData.get(field)) {
                    errorMessage.style.display = "block";
                    errorMessage.textContent = "Please fill all required fields.";
                    return;
                }
            }

            // Send data to PHP
            fetch("ajax/submit_partnership.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        successMessage.style.display = "block";
                        errorMessage.style.display = "none";

                        // Reset form and close popup
                        form.reset();
                        setTimeout(() => closePopup(), 9000);
                    } else {
                        errorMessage.style.display = "block";
                        errorMessage.textContent = data.message || "Submission failed. Please try again.";
                    }
                })
                .catch(() => {
                    errorMessage.style.display = "block";
                    errorMessage.textContent = "Something went wrong. Please try again.";
                });
        });
    </script>

</body>

</html>