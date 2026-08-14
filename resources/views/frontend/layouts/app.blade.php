<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Latest Blogs & Articles') - Webwiders Software Solutions</title>
    <meta name="description" content="@yield('meta_description', 'Webwiders Software Solutions - Digital Marketing & Technology Insight Platform')">
    <meta name="keywords" content="@yield('meta_keywords', 'software solutions, webwiders, digital marketing, technology, blog, laravel')">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.svg') }}">

    <!-- CSS Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <style>
        /* Article & Custom Content Styling */
        .article-content {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #4a5568;
        }
        .article-content h1, .article-content h2, .article-content h3, .article-content h4 {
            color: #0f172a;
            font-weight: 700;
            margin-top: 1.8rem;
            margin-bottom: 1rem;
        }
        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 1.5rem 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .article-content blockquote {
            border-left: 4px solid #6A47ED;
            padding: 1.2rem 1.5rem;
            background-color: #F6F3FE;
            border-radius: 0 10px 10px 0;
            font-style: italic;
            margin: 1.5rem 0;
            color: #2D1B69;
        }
        .article-content pre {
            background-color: #0F172A;
            color: #F8FAFC;
            padding: 1.25rem;
            border-radius: 10px;
            overflow-x: auto;
            margin: 1.5rem 0;
        }
        .article-content table {
            width: 100%;
            margin: 1.5rem 0;
            border-collapse: collapse;
        }
        .article-content table td, .article-content table th {
            border: 1px solid #E2E8F0;
            padding: 0.75rem 1rem;
        }
        .article-content table th {
            background-color: #F8FAFC;
            font-weight: 600;
        }
        .article-content figure.media {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            margin: 2rem 0;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .article-content figure.media iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
        /* Custom Pagination styles */
        .page-nav-wrap ul.pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .page-nav-wrap ul.pagination li a,
        .page-nav-wrap ul.pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            font-weight: 600;
            color: #0f172a;
            background: #f4f4f9;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .page-nav-wrap ul.pagination li.active span,
        .page-nav-wrap ul.pagination li a:hover {
            background: #6A47ED;
            color: #ffffff;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Preloader Start -->
    <div id="preloader" class="preloader">
        <div class="animation-preloader">
            <div class="spinner"></div>
            <div class="txt-loading">
                <span data-text-preloader="W" class="letters-loading">W</span>
                <span data-text-preloader="E" class="letters-loading">E</span>
                <span data-text-preloader="B" class="letters-loading">B</span>
                <span data-text-preloader="W" class="letters-loading">W</span>
                <span data-text-preloader="I" class="letters-loading">I</span>
                <span data-text-preloader="D" class="letters-loading">D</span>
                <span data-text-preloader="E" class="letters-loading">E</span>
                <span data-text-preloader="R" class="letters-loading">R</span>
                <span data-text-preloader="S" class="letters-loading">S</span>
            </div>
            <p class="text-center">Loading</p>
        </div>
        <div class="loader">
            <div class="row">
                <div class="col-3 loader-section section-left"><div class="bg"></div></div>
                <div class="col-3 loader-section section-left"><div class="bg"></div></div>
                <div class="col-3 loader-section section-right"><div class="bg"></div></div>
                <div class="col-3 loader-section section-right"><div class="bg"></div></div>
            </div>
        </div>
    </div>

    <!-- Back To Top Start -->
    <button id="back-top" class="back-to-top">
        <i class="fa-regular fa-arrow-up"></i>
    </button>

    <!-- Offcanvas Area Start -->
    <div class="fix-area">
        <div class="offcanvas__info">
            <div class="offcanvas__wrapper">
                <div class="offcanvas__content">
                    <div class="offcanvas__top mb-5 d-flex justify-content-between align-items-center">
                        <div class="offcanvas__logo">
                            <a href="{{ route('frontend.blogs.index') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                                <span class="fs-4 fw-extrabold text-dark brand-font"><span style="color: #6A47ED;">Webwiders</span> Software Solutions</span>
                            </a>
                        </div>
                        <div class="offcanvas__close">
                            <button><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <p class="text d-none d-xl-block">
                        Webwiders Software Solutions - Leading Digital & Tech Insight Hub.
                    </p>
                    <div class="mobile-menu fix mb-3"></div>
                    <div class="offcanvas__contact">
                        <h4>Contact Info</h4>
                        <ul>
                            <li class="d-flex align-items-center">
                                <div class="offcanvas__contact-icon"><i class="fal fa-map-marker-alt"></i></div>
                                <div class="offcanvas__contact-text"><a target="_blank" href="#">Webwiders Software Solutions, India</a></div>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="offcanvas__contact-icon mr-15"><i class="fal fa-envelope"></i></div>
                                <div class="offcanvas__contact-text"><a href="mailto:support@webwiders.com">support@webwiders.com</a></div>
                            </li>
                        </ul>
                        <div class="main-button mt-4">
                            <a href="{{ route('admin.login') }}">
                                <span class="theme-btn">Admin Portal</span>
                                <span class="arrow-btn"><i class="fa-regular fa-arrow-up-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas__overlay"></div>

    <!-- Header Section Start -->
    <header id="header-sticky" class="header-1 style-2">
        <div class="container-fluid">
            <div class="mega-menu-wrapper">
                <div class="header-main">
                    <div class="logo">
                        <a href="{{ route('frontend.blogs.index') }}" class="header-logo-3 text-decoration-none d-flex align-items-center gap-2">
                            <span class="fs-3 fw-extrabold text-dark brand-font"><span style="color: #6A47ED;">Webwiders</span> Software Solutions</span>
                        </a>
                    </div>
                    <div class="mean__menu-wrapper">
                        <div class="main-menu">
                            <nav id="mobile-menu">
                                <ul>
                                    <li class="{{ request()->routeIs('frontend.blogs.index') ? 'active' : '' }}">
                                        <a href="{{ route('frontend.blogs.index') }}">Blogs & Articles</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.login') }}">Admin Login</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="header-right d-flex justify-content-end align-items-center">
                        <div class="main-button">
                            <a href="{{ route('admin.login') }}">
                                <span class="theme-btn">Admin Panel</span>
                                <span class="arrow-btn"><i class="fa-regular fa-arrow-up-right"></i></span>
                            </a>
                        </div>
                        <div class="header__hamburger d-xl-none my-auto">
                            <div class="sidebar__toggle">
                                <i class="fas fa-bars"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Breadcrumb Section -->
    @hasSection('breadcrumb_title')
    <div class="breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb.jpg') }}');">
        <div class="left-shape">
            <img src="{{ asset('assets/img/breadcrumb-shape.png') }}" alt="img">
        </div>
        <div class="right-shape">
            <img src="{{ asset('assets/img/breadcrumb-shape-2.png') }}" alt="img">
        </div>
        <div class="container">
            <div class="page-heading">
                <div class="breadcrumb-sub-title">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">@yield('breadcrumb_title', 'Blogs & Insights')</h1>
                </div>
                <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                    <li><a href="{{ route('frontend.blogs.index') }}">Home</a></li>
                    <li><i class="fa-solid fa-chevron-right"></i></li>
                    <li>@yield('breadcrumb_active', 'Blog Standard')</li>
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- Main View Content -->
    @yield('content')

    <!-- Footer Section Start -->
    <footer class="footer-section footer-bg">
        <div class="container">
            <div class="footer-widgets-wrapper style-2 section-padding border-bottom">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                        <div class="single-footer-widget">
                            <div class="widget-head mb-3">
                                <a href="{{ route('frontend.blogs.index') }}" class="text-decoration-none">
                                    <span class="fs-4 fw-extrabold text-white brand-font"><span style="color: #6A47ED;">Webwiders</span> Software Solutions</span>
                                </a>
                            </div>
                            <div class="footer-content">
                                <p>
                                    Webwiders Software Solutions - Professional Digital Marketing & Technology Insight Hub.
                                </p>
                                <div class="social-icon d-flex align-items-center">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-vimeo-v"></i></a>
                                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 ps-xl-5 wow fadeInUp" data-wow-delay=".4s">
                        <div class="single-footer-widget">
                            <div class="widget-head">
                                <h3>Quick Links</h3>
                            </div>
                            <ul class="list-area">
                                <li><a href="{{ route('frontend.blogs.index') }}"><i class="fa-solid fa-chevron-right me-2"></i>Articles & News</a></li>
                                <li><a href="{{ route('admin.login') }}"><i class="fa-solid fa-chevron-right me-2"></i>Admin Dashboard</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 ps-xl-5 wow fadeInUp" data-wow-delay=".6s">
                        <div class="single-footer-widget">
                            <div class="widget-head">
                                <h3>Contact Info</h3>
                            </div>
                            <div class="footer-content">
                                <ul class="contact-info">
                                    <li>
                                        <i class="fa-regular fa-envelope"></i>
                                        <a href="mailto:support@webwiders.com">support@webwiders.com</a>
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-phone-volume"></i>
                                        <a href="tel:+11002345909">+1 100 234 5909</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-wrapper d-flex align-items-center justify-content-between">
                    <p class="wow fadeInLeft color-2" data-wow-delay=".3s">
                        &copy; {{ date('Y') }} Webwiders Software Solutions. All Rights Reserved.
                    </p>
                    <ul class="footer-menu wow fadeInRight" data-wow-delay=".5s">
                        <li><a href="#">Terms & Condition</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <a href="#" id="scrollUp" class="scroll-icon">
                <i class="far fa-arrow-up"></i>
            </a>
        </div>
    </footer>

    <!-- JS Plugins -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/viewport.jquery.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
