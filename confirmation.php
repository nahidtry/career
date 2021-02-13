<?php
session_start();
require_once 'server/Career.php';

$server = new Career();

$result = "";

unset($_SESSION['fileName']);
?>
<!DOCTYPE html>
<html class="html" lang="en-US">
<!-- Mirrored from trysolutions.us/contact-us/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 06 Feb 2021 05:13:13 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600&display=swap" rel="stylesheet">

<head>
    <?php include 'parts/header.php' ?>
    <style>
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            width: 100%;
            margin-bottom: 5%;
            cursor: pointer;
            font-family: 'Rajdhani', sans-serif;
            font-size: 15px
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .container {
            padding: 2px 16px;
        }

        /*--thank you pop starts here--*/
        .thank-you-pop {
            width: 100%;
            padding: 20px;
            text-align: center;
        }

        .thank-you-pop img {
            width: 76px;
            height: auto;
            margin: 0 auto;
            display: block;
            margin-bottom: 25px;
        }

        .thank-you-pop h1 {
            font-size: 42px;
            margin-bottom: 25px;
            color: #5C5C5C;
        }

        .thank-you-pop p {
            font-size: 20px;
            margin-bottom: 27px;
            color: #5C5C5C;
        }

        
        /*--thank you pop ends here--*/
    </style>
</head>

<body data-rsssl="1" class="page-template page-template-elementor_header_footer page page-id-15 wp-custom-logo wp-embed-responsive mega-menu-main-menu oceanwp-theme dropdown-mobile no-header-border default-breakpoint content-full-screen has-topbar page-header-disabled has-breadcrumbs elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-15" itemscope="itemscope" itemtype="https://schema.org/WebPage">
    <div id="outer-wrap" class="site clr">
        <a class="skip-link screen-reader-text" href="#main">Skip to content</a>

        <div id="wrap" class="clr">
            <div id="top-bar-wrap" class="clr">
                <div id="top-bar" class="clr">

                    <?php include 'parts/top-bar.php' ?>
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
                </div>

            </div>
            <!-- #top-bar-wrap -->

            <header id="site-header" class="minimal-header clr" data-height="76" itemscope="itemscope" itemtype="https://schema.org/WPHeader" role="banner">
                <div id="site-header-inner" class="clr">
                    <div id="site-logo" class="clr" itemscope itemtype="https://schema.org/Brand">
                        <div id="site-logo-inner" class="clr">
                            <a href="https://trysolutions.us/" class="custom-logo-link" rel="home"><img width="336" height="63" src="../wp-content/uploads/2021/01/logo.png" class="custom-logo" alt="TRY SOLUTION" srcset="
                      https://trysolutions.us/wp-content/uploads/2021/01/logo.png        336w,
                      https://trysolutions.us/wp-content/uploads/2021/01/logo-300x56.png 300w
                    " sizes="(max-width: 336px) 100vw, 336px" /></a>
                        </div>
                        <!-- #site-logo-inner -->
                    </div>
                    <!-- #site-logo -->

                    <div id="site-navigation-wrap" class="clr">
                        <?php include 'parts/navbar.php' ?>
                        <!-- #site-navigation -->
                    </div>
                    <!-- #site-navigation-wrap -->

                    <div class="oceanwp-mobile-menu-icon clr mobile-right">
                        <a href="javascript:void(0)" class="mobile-menu" aria-label="Mobile Menu">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                            <span class="oceanwp-text">Menu</span>
                            <span class="oceanwp-close-text">Close</span>
                        </a>
                    </div>
                    <!-- #oceanwp-mobile-menu-navbar -->
                </div>
                <!-- #site-header-inner -->

                <div id="mobile-dropdown" class="clr">
                    <?php include 'parts/mobile-nav.php' ?>
                </div>
            </header>
            <!-- #site-header -->

            <main id="main" class="site-main clr" role="main">
                <div data-elementor-type="wp-page" data-elementor-id="15" class="elementor elementor-15" data-elementor-settings="[]">
                    <div class="elementor-inner">
                        <div class="elementor-section-wrap">
                            <section class="elementor-section elementor-top-section elementor-element elementor-element-dd37e8d elementor-section-full_width elementor-section-height-default elementor-section-height-default" data-id="dd37e8d" data-element_type="section" data-settings='{"background_background":"classic","shape_divider_bottom":"opacity-tilt","_ha_eqh_enable":false}'>
                                <div class="elementor-background-overlay"></div>
                                <div class="elementor-shape elementor-shape-bottom" data-negative="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2600 131.1" preserveAspectRatio="none">
                                        <path class="elementor-shape-fill" d="M0 0L2600 0 2600 69.1 0 0z" />
                                        <path class="elementor-shape-fill" style="opacity: 0.5" d="M0 0L2600 0 2600 69.1 0 69.1z" />
                                        <path class="elementor-shape-fill" style="opacity: 0.25" d="M2600 0L0 0 0 130.1 2600 69.1z" />
                                    </svg>
                                </div>
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-row">
                                        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-1e6436b" data-id="1e6436b" data-element_type="column">
                                            <div class="elementor-column-wrap elementor-element-populated">
                                                <div class="elementor-widget-wrap">
                                                    <div class="elementor-element elementor-element-934750a elementor-widget elementor-widget-heading" data-id="934750a" data-element_type="widget" data-widget_type="heading.default">
                                                        <div class="elementor-widget-container">
                                                            <h2 class="elementor-heading-title elementor-size-default">
                                                                Build Your Career With Us
                                                            </h2>
                                                            <br>
                                                            <button class="btn btn-primary" onclick="window.location='index.php'" style="width: 200px;height: 40px;"><i class="fa fa-backward"></i> Back TO Jobs</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="elementor-section elementor-top-section elementor-element elementor-element-611ab3d elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="611ab3d" data-element_type="section" data-settings='{"_ha_eqh_enable":false}'>
                                <div class="container" style="margin-top:50px; margin-bottom: 200px">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card" style="display: inline-block; padding-bottom:50px;">
                                                <div class="container">
                                                    <div class="thank-you-pop">
                                                        <img src="assets/images/Green-Round-Tick.png" alt="">
                                                        <h1>Thank You!</h1>
                                                        <p>Your submission is received and we will contact you soon</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </main>
            <!-- #main -->

            <?php include 'parts/footer.php' ?>
            <!-- #footer -->
        </div>
        <!-- #wrap -->
    </div>
    <!-- #outer-wrap -->

    <?php include 'parts/scripts.php' ?>
</body>

<!-- Mirrored from trysolutions.us/contact-us/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 06 Feb 2021 05:15:06 GMT -->

</html>