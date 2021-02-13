<?php
session_start();
require_once 'server/Career.php';

if (isset($_SESSION['fileName'])) {
} else {
    $milliseconds         = round(microtime(true) * 1000);
    $_SESSION['fileName'] = date('dmY') . date('his') . $milliseconds;
}

$server = new Career();

$result = "";

if (isset($_POST['save'])) {
    $result = $server->saveApplicant_data($_POST);
}

$qustions = $server->getQustions_byPostId($_GET['trackingID']);
$qus_count = count($qustions);

$job = $server->jobPostsDetails_byID($_GET['trackingID']);


?>
<!DOCTYPE html>
<html class="html" lang="en-US">
<!-- Mirrored from trysolutions.us/contact-us/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 06 Feb 2021 05:13:13 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600" rel="stylesheet"><!-- End GOOGLE FONT -->
<!-- BEGIN PLUGINS STYLES -->
<link rel="stylesheet" href="assets/vendor/open-iconic/font/css/open-iconic-bootstrap.min.css">
<link rel="stylesheet" href="assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css"><!-- END PLUGINS STYLES -->
<link rel="stylesheet" href="assets/stylesheets/theme.min.css" data-skin="default">
<link rel="stylesheet" href="assets/stylesheets/custom.css">

<head>
    <link href="assets/stylesheets/video-js.min.css" rel="stylesheet">
    <link href="assets/stylesheets/videojs.record.css" rel="stylesheet">

    <script src="assets/javascript/video.min.js"></script>
    <script src="assets/javascript/RecordRTC.js"></script>
    <script src="assets/javascript/adapter.js"></script>
    <script src="assets/javascript/videojs.record.js"></script>
    <?php include 'parts/header.php' ?>

    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <style>
        #myAudio {
            background-color: #9FD6BA;
        }

        #myVideo {
            background-color: #9ab87a;
        }

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

        .file-upload {
            background-color: #ffffff;
            width: 400px;
            margin: 0 auto;
            padding: 20px;
        }

        .file-upload-btn {
            width: 100%;
            margin: 0;
            color: #fff;
            background: #1FB264;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #15824B;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .file-upload-btn:hover {
            background: #1AA059;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .file-upload-btn:active {
            border: 0;
            transition: all .2s ease;
        }

        .file-upload-content {
            display: none;
            text-align: center;
        }

        .file-upload-input {
            position: absolute;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            outline: none;
            opacity: 0;
            cursor: pointer;
        }

        .image-upload-wrap {
            margin-top: 20px;
            border: 4px dashed #1FB264;
            position: relative;
        }

        .image-dropping,
        .image-upload-wrap:hover {
            background-color: #1FB264;
            border: 4px dashed #ffffff;
        }

        .image-title-wrap {
            padding: 0 15px 15px 15px;
            color: #222;
        }

        .drag-text {
            text-align: center;
        }

        .drag-text h3 {
            font-weight: 100;
            text-transform: uppercase;
            color: #15824B;
            padding: 60px 0;
        }

        .file-upload-image {
            max-height: 200px;
            max-width: 200px;
            margin: auto;
            padding: 20px;
        }

        .remove-image {
            width: 200px;
            margin: 0;
            color: #fff;
            background: #cd4535;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #b02818;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .remove-image:hover {
            background: #c13b2a;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .remove-image:active {
            border: 0;
            transition: all .2s ease;
        }

        form.is-submitting::before {
            position: absolute;
            content: '';
            top: -0.5em;
            right: -0.5em;
            left: -0.5em;
            bottom: -0.5em;
            background: rgba(0, 0, 0, 0.2) url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBzdGFuZGFsb25lPSJubyI/Pgo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPgo8c3ZnIHdpZHRoPSI0MHB4IiBoZWlnaHQ9IjQwcHgiIHZpZXdCb3g9IjAgMCA0MCA0MCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4bWw6c3BhY2U9InByZXNlcnZlIiBzdHlsZT0iZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEuNDE0MjE7IiB4PSIwcHgiIHk9IjBweCI+CiAgICA8ZGVmcz4KICAgICAgICA8c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWwogICAgICAgICAgICBALXdlYmtpdC1rZXlmcmFtZXMgc3BpbiB7CiAgICAgICAgICAgICAgZnJvbSB7CiAgICAgICAgICAgICAgICAtd2Via2l0LXRyYW5zZm9ybTogcm90YXRlKDBkZWcpCiAgICAgICAgICAgICAgfQogICAgICAgICAgICAgIHRvIHsKICAgICAgICAgICAgICAgIC13ZWJraXQtdHJhbnNmb3JtOiByb3RhdGUoLTM1OWRlZykKICAgICAgICAgICAgICB9CiAgICAgICAgICAgIH0KICAgICAgICAgICAgQGtleWZyYW1lcyBzcGluIHsKICAgICAgICAgICAgICBmcm9tIHsKICAgICAgICAgICAgICAgIHRyYW5zZm9ybTogcm90YXRlKDBkZWcpCiAgICAgICAgICAgICAgfQogICAgICAgICAgICAgIHRvIHsKICAgICAgICAgICAgICAgIHRyYW5zZm9ybTogcm90YXRlKC0zNTlkZWcpCiAgICAgICAgICAgICAgfQogICAgICAgICAgICB9CiAgICAgICAgICAgIHN2ZyB7CiAgICAgICAgICAgICAgICAtd2Via2l0LXRyYW5zZm9ybS1vcmlnaW46IDUwJSA1MCU7CiAgICAgICAgICAgICAgICAtd2Via2l0LWFuaW1hdGlvbjogc3BpbiAxLjVzIGxpbmVhciBpbmZpbml0ZTsKICAgICAgICAgICAgICAgIC13ZWJraXQtYmFja2ZhY2UtdmlzaWJpbGl0eTogaGlkZGVuOwogICAgICAgICAgICAgICAgYW5pbWF0aW9uOiBzcGluIDEuNXMgbGluZWFyIGluZmluaXRlOwogICAgICAgICAgICB9CiAgICAgICAgXV0+PC9zdHlsZT4KICAgIDwvZGVmcz4KICAgIDxnIGlkPSJvdXRlciI+CiAgICAgICAgPGc+CiAgICAgICAgICAgIDxwYXRoIGQ9Ik0yMCwwQzIyLjIwNTgsMCAyMy45OTM5LDEuNzg4MTMgMjMuOTkzOSwzLjk5MzlDMjMuOTkzOSw2LjE5OTY4IDIyLjIwNTgsNy45ODc4MSAyMCw3Ljk4NzgxQzE3Ljc5NDIsNy45ODc4MSAxNi4wMDYxLDYuMTk5NjggMTYuMDA2MSwzLjk5MzlDMTYuMDA2MSwxLjc4ODEzIDE3Ljc5NDIsMCAyMCwwWiIgc3R5bGU9ImZpbGw6YmxhY2s7Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnPgogICAgICAgICAgICA8cGF0aCBkPSJNNS44NTc4Niw1Ljg1Nzg2QzcuNDE3NTgsNC4yOTgxNSA5Ljk0NjM4LDQuMjk4MTUgMTEuNTA2MSw1Ljg1Nzg2QzEzLjA2NTgsNy40MTc1OCAxMy4wNjU4LDkuOTQ2MzggMTEuNTA2MSwxMS41MDYxQzkuOTQ2MzgsMTMuMDY1OCA3LjQxNzU4LDEzLjA2NTggNS44NTc4NiwxMS41MDYxQzQuMjk4MTUsOS45NDYzOCA0LjI5ODE1LDcuNDE3NTggNS44NTc4Niw1Ljg1Nzg2WiIgc3R5bGU9ImZpbGw6cmdiKDIxMCwyMTAsMjEwKTsiLz4KICAgICAgICA8L2c+CiAgICAgICAgPGc+CiAgICAgICAgICAgIDxwYXRoIGQ9Ik0yMCwzMi4wMTIyQzIyLjIwNTgsMzIuMDEyMiAyMy45OTM5LDMzLjgwMDMgMjMuOTkzOSwzNi4wMDYxQzIzLjk5MzksMzguMjExOSAyMi4yMDU4LDQwIDIwLDQwQzE3Ljc5NDIsNDAgMTYuMDA2MSwzOC4yMTE5IDE2LjAwNjEsMzYuMDA2MUMxNi4wMDYxLDMzLjgwMDMgMTcuNzk0MiwzMi4wMTIyIDIwLDMyLjAxMjJaIiBzdHlsZT0iZmlsbDpyZ2IoMTMwLDEzMCwxMzApOyIvPgogICAgICAgIDwvZz4KICAgICAgICA8Zz4KICAgICAgICAgICAgPHBhdGggZD0iTTI4LjQ5MzksMjguNDkzOUMzMC4wNTM2LDI2LjkzNDIgMzIuNTgyNCwyNi45MzQyIDM0LjE0MjEsMjguNDkzOUMzNS43MDE5LDMwLjA1MzYgMzUuNzAxOSwzMi41ODI0IDM0LjE0MjEsMzQuMTQyMUMzMi41ODI0LDM1LjcwMTkgMzAuMDUzNiwzNS43MDE5IDI4LjQ5MzksMzQuMTQyMUMyNi45MzQyLDMyLjU4MjQgMjYuOTM0MiwzMC4wNTM2IDI4LjQ5MzksMjguNDkzOVoiIHN0eWxlPSJmaWxsOnJnYigxMDEsMTAxLDEwMSk7Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnPgogICAgICAgICAgICA8cGF0aCBkPSJNMy45OTM5LDE2LjAwNjFDNi4xOTk2OCwxNi4wMDYxIDcuOTg3ODEsMTcuNzk0MiA3Ljk4NzgxLDIwQzcuOTg3ODEsMjIuMjA1OCA2LjE5OTY4LDIzLjk5MzkgMy45OTM5LDIzLjk5MzlDMS43ODgxMywyMy45OTM5IDAsMjIuMjA1OCAwLDIwQzAsMTcuNzk0MiAxLjc4ODEzLDE2LjAwNjEgMy45OTM5LDE2LjAwNjFaIiBzdHlsZT0iZmlsbDpyZ2IoMTg3LDE4NywxODcpOyIvPgogICAgICAgIDwvZz4KICAgICAgICA8Zz4KICAgICAgICAgICAgPHBhdGggZD0iTTUuODU3ODYsMjguNDkzOUM3LjQxNzU4LDI2LjkzNDIgOS45NDYzOCwyNi45MzQyIDExLjUwNjEsMjguNDkzOUMxMy4wNjU4LDMwLjA1MzYgMTMuMDY1OCwzMi41ODI0IDExLjUwNjEsMzQuMTQyMUM5Ljk0NjM4LDM1LjcwMTkgNy40MTc1OCwzNS43MDE5IDUuODU3ODYsMzQuMTQyMUM0LjI5ODE1LDMyLjU4MjQgNC4yOTgxNSwzMC4wNTM2IDUuODU3ODYsMjguNDkzOVoiIHN0eWxlPSJmaWxsOnJnYigxNjQsMTY0LDE2NCk7Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnPgogICAgICAgICAgICA8cGF0aCBkPSJNMzYuMDA2MSwxNi4wMDYxQzM4LjIxMTksMTYuMDA2MSA0MCwxNy43OTQyIDQwLDIwQzQwLDIyLjIwNTggMzguMjExOSwyMy45OTM5IDM2LjAwNjEsMjMuOTkzOUMzMy44MDAzLDIzLjk5MzkgMzIuMDEyMiwyMi4yMDU4IDMyLjAxMjIsMjBDMzIuMDEyMiwxNy43OTQyIDMzLjgwMDMsMTYuMDA2MSAzNi4wMDYxLDE2LjAwNjFaIiBzdHlsZT0iZmlsbDpyZ2IoNzQsNzQsNzQpOyIvPgogICAgICAgIDwvZz4KICAgICAgICA8Zz4KICAgICAgICAgICAgPHBhdGggZD0iTTI4LjQ5MzksNS44NTc4NkMzMC4wNTM2LDQuMjk4MTUgMzIuNTgyNCw0LjI5ODE1IDM0LjE0MjEsNS44NTc4NkMzNS43MDE5LDcuNDE3NTggMzUuNzAxOSw5Ljk0NjM4IDM0LjE0MjEsMTEuNTA2MUMzMi41ODI0LDEzLjA2NTggMzAuMDUzNiwxMy4wNjU4IDI4LjQ5MzksMTEuNTA2MUMyNi45MzQyLDkuOTQ2MzggMjYuOTM0Miw3LjQxNzU4IDI4LjQ5MzksNS44NTc4NloiIHN0eWxlPSJmaWxsOnJnYig1MCw1MCw1MCk7Ii8+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4K') no-repeat 50% 50% / 1em 1em;
        }
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

            <?= $result; ?>

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
                                <div class="container">
                                    <div class="section-block">

                                        <!-- Default Steps -->
                                        <!-- .bs-stepper -->
                                        <div id="stepper" class="bs-stepper">
                                            <h3 style="text-align: center;"><u><?= $job['post_title'] ?></u></h3>
                                            <div class="card" style="min-height: 600px;">
                                                <!-- .card-header -->
                                                <div class="card-header">
                                                    <!-- .steps -->
                                                    <div class="steps steps-" role="tablist">
                                                        <ul>
                                                            <li class="step" data-target="#test-l-1" data-validate="fieldset01">
                                                                <a href="#" class="step-trigger" tabindex="-1"><span class="step-indicator step-indicator-icon"><i class="oi oi-person"></i></span> <span class="d-none d-sm-inline">Personal</span></a>
                                                            </li>
                                                            <li class="step" data-target="#test-l-2" data-validate="fieldset02">
                                                                <a href="#" class="step-trigger" tabindex="-1"><span class="step-indicator step-indicator-icon"><i class="oi oi-account-login"></i></span> <span class="d-none d-sm-inline">Career</span></a>
                                                            </li>
                                                            <li class="step" data-target="#test-l-3" data-validate="fieldset03">
                                                                <a href="#" class="step-trigger" tabindex="-1"><span class="step-indicator step-indicator-icon"><i class="oi oi-credit-card"></i></span> <span class="d-none d-sm-inline">Uploads</span></a>
                                                            </li>
                                                            <li class="step" data-target="#test-l-4" data-validate="agreement">
                                                                <a href="#" class="step-trigger" tabindex="-1"><span class="step-indicator step-indicator-icon"><i class="oi oi-check"></i></span> <span class="d-none d-sm-inline">Confirm</span></a>
                                                            </li>
                                                        </ul>
                                                    </div><!-- /.steps -->
                                                </div><!-- /.card-header -->
                                                <!-- .card-body -->
                                                <div class="card-body">
                                                    <form method="POST" id="stepper-form" name="stepperForm" class="p-lg-4 p-sm-3 p-0" enctype="multipart/form-data" onsubmit="document.getElementById('#registration').style.display='none';window.location='#modal@processing';">

                                                        <input type="hidden" name="post_id" value="<?= $_GET['trackingID'] ?>">
                                                        <input type="hidden" name="audio" value="<?= $_SESSION['fileName'] . ".mp3" ?>">
                                                        <input type="hidden" name="video" value="<?= $_SESSION['fileName'] . ".webm" ?>">

                                                        <div id="test-l-1" class="content dstepper-none fade">

                                                            <fieldset>
                                                                <legend>Provide your basic information</legend>
                                                                <div class="row">
                                                                    <div class="col-sm-6"></div>
                                                                    <div class="col-sm-6"></div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>First Name</label>
                                                                                <input type="text" name="firstname" class="form-control" placeholder="Enter firstname" autocomplete="off" data-parsley-group="fieldset01" required>
                                                                            </div>
                                                                            <div class="invalid-feedback"> First Name is required. </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>Last Name</label>
                                                                                <input type="text" name="lastname" class="form-control" placeholder="Enter Lastname" autocomplete="off" data-parsley-group="fieldset01" required>
                                                                            </div>
                                                                            <div class="invalid-feedback"> Last Name is required. </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>Father's Name</label>
                                                                                <input type="text" name="father_name" placeholder="Enter father's name" class="form-control" autocomplete="off" data-parsley-group="fieldset01" required>
                                                                            </div>
                                                                            <div class="invalid-feedback"> Father's Name is required. </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>Father's Profession</label>
                                                                                <input type="text" name="father_profession" placeholder="Enter father's profession" class="form-control" autocomplete="off" data-parsley-group="fieldset01" required>
                                                                            </div>
                                                                            <div class="invalid-feedback"> Father's Profession is required. </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>Mother's Name</label>
                                                                                <input type="text" name="mother_name" placeholder="Enter mother's name" class="form-control" autocomplete="off" data-parsley-group="fieldset01" required>
                                                                            </div>
                                                                            <div class="invalid-feedback"> Mother's Name is required. </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>Mother's Profession</label>
                                                                                <input type="text" name="mother_profession" placeholder="Enter mother's profession" class="form-control" autocomplete="off" data-parsley-group="fieldset01" required>
                                                                            </div>
                                                                            <div class="invalid-feedback"> Father's Profession is required. </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>Phone Number</label>
                                                                                <input type="text" name="phone" placeholder="Enter phone number" class="form-control" autocomplete="off" data-parsley-group="fieldset01" required>
                                                                            </div>
                                                                            <div class="invalid-feedback"> Phone is required. </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>Email Address</label>
                                                                                <input type="email" name="email" placeholder="Enter email address" class="form-control" autocomplete="off" data-parsley-group="fieldset01" required>
                                                                            </div>
                                                                            <div class="invalid-feedback"> Email is required. </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>Emergency Contact Name</label>
                                                                                <input type="text" name="emergency_name" placeholder="Enter Emergency Contact name" class="form-control" autocomplete="off" data-parsley-group="fieldset01" required>
                                                                            </div>
                                                                            <div class="invalid-feedback"> Emergency Contact Name is required. </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>Emergency Contact [ Email/phone ]</label>
                                                                                <input type="text" name="emergency_contact" placeholder="Enter relation" class="form-control" autocomplete="off" data-parsley-group="fieldset01" required>
                                                                            </div>
                                                                            <div class="invalid-feedback">Emergency Contact is required. </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>Permanent Address</label>
                                                                                <textarea name="permanent_address" placeholder="Enter permanent address" class="form-control" autocomplete="off" data-parsley-group="fieldset01" required></textarea>
                                                                            </div>
                                                                            <div class="invalid-feedback">Permanent Address is required. </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>Present Address</label>
                                                                                <textarea name="present_address" placeholder="Enter present address" class="form-control" data-parsley-group="fieldset01" required></textarea>
                                                                            </div>
                                                                            <div class="invalid-feedback"> Present Address is required. </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>NID/Passport/Birth Certificate Number</label>
                                                                                <input type="text" name="identification_docNo" placeholder="Enter document id" class="form-control" autocomplete="off" data-parsley-group="fieldset03" required>
                                                                            </div>
                                                                            <div class="invalid-feedback"> Document is required. </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label for="sel1">Choose Your Document</label>
                                                                                <div class="form-group">
                                                                                    <select name="identification_select" class="form-control" id="sel1" data-parsley-group="fieldset01" required>
                                                                                        <option selected>----SELECT YOUR DOCUMENT TYPE----</option>
                                                                                        <option value="NID">NID</option>
                                                                                        <option value="PASSPORT">PASSPORT</option>
                                                                                        <option value="BIRTH CERTIFICATE">BIRTH CERTIFICATE</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="invalid-feedback">Choose Document type. </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <hr class="mt-5">

                                                                <div class="d-flex">
                                                                    <p></p><button type="button" class="next btn btn-primary ml-auto" data-validate="fieldset01" style="height: 40px;width:100px">Next step</button>
                                                                </div>
                                                            </fieldset>

                                                        </div>

                                                        <div id="test-l-2" class="content dstepper-none fade">
                                                            <!-- fieldset -->

                                                            <fieldset>
                                                                <div style="min-height: 500px;">
                                                                    <legend>Career Objectives</legend>
                                                                    <div class="col-md-12 mb-4">
                                                                        <div class="">
                                                                            <textarea name="career_objectives" id="" cols="30" rows="6" placeholder="Enter your Career objectives"></textarea>
                                                                        </div>
                                                                        <div class="invalid-feedback"> Career Objectives are required. </div>
                                                                    </div>
                                                                    <legend>Education Qualification <span style="color: #286090; font-size:18px">(Most Recent First)</span></legend>
                                                                    <div class="row" style="padding-left: 2%;">
                                                                        <div class="col-md-3 mb-4">
                                                                            <div class="">
                                                                                <label>Degree</label>
                                                                                <input type="text" class="form-control" name="degree[]">
                                                                            </div>
                                                                            <div class="invalid-feedback"> Degree is required. </div>
                                                                        </div>

                                                                        <div class="col-md-3 mb-4">
                                                                            <div class="">
                                                                                <label>Institute</label>
                                                                                <input type="text" class="form-control" name="institute[]">
                                                                            </div>
                                                                            <div class="invalid-feedback"> Institute is required. </div>
                                                                        </div>

                                                                        <div class="col-md-3 mb-4">
                                                                            <div class="">
                                                                                <label for="sel1">Passing Year</label>
                                                                                <select name="pass_year[]" class="form-control" id="sel1">
                                                                                    <option>---Select Passing Year----</option>
                                                                                    <?php for ($i = date('Y'); $i > 1970; $i--) { ?>
                                                                                        <option value="<?= $i ?>"> <?= $i ?> </option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="invalid-feedback">Passing Year is required. </div>
                                                                        </div>

                                                                        <div class="col-md-3 mb-4">
                                                                            <div class="">
                                                                                <label>CGPA</label>
                                                                                <input type="text" class="form-control" name="cgpa[]">
                                                                            </div>
                                                                            <div class="invalid-feedback">CGPA is required. </div>
                                                                        </div>

                                                                    </div>
                                                                    <ul id="list" style="list-style-type: none;">
                                                                        <li class="default" style="display: none;">
                                                                            <div class="row">

                                                                                <div class="col-md-3 mb-4">
                                                                                    <div class="">
                                                                                        <label>Degree</label>
                                                                                        <input type="text" class="form-control" name="degree[]">
                                                                                    </div>
                                                                                    <div class="invalid-feedback"> Degree is required. </div>
                                                                                </div>

                                                                                <div class="col-md-3 mb-4">
                                                                                    <div class="">
                                                                                        <label>Institute</label>
                                                                                        <input type="text" class="form-control" name="institute[]">
                                                                                    </div>
                                                                                    <div class="invalid-feedback"> Institute is required. </div>
                                                                                </div>

                                                                                <div class="col-md-3 mb-4">
                                                                                    <div class="">
                                                                                        <label for="sel1">Passing Year</label>
                                                                                        <select name="pass_year[]" class="form-control" id="sel1">
                                                                                            <option>---Select Passing Year----</option>
                                                                                            <?php for ($i = date('Y'); $i > 1970; $i--) { ?>
                                                                                                <option value="<?= $i ?>"> <?= $i ?> </option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="invalid-feedback"> Valid last name is required. </div>
                                                                                </div>

                                                                                <div class="col-md-3 mb-4">
                                                                                    <div class="">
                                                                                        <label>CGPA</label>
                                                                                        <input type="text" class="form-control" name="cgpa[]">
                                                                                    </div>
                                                                                    <div class="invalid-feedback"> Valid last name is required. </div>
                                                                                </div>

                                                                            </div>
                                                                            <button type="button" class="btn btn-default" style="height: 30px;width:50px;cursor: pointer;color:red;margin-left: 94.8%;" onclick="closeMe(this);"><i class="fa fa-times"></i></button>
                                                                        </li>
                                                                    </ul>
                                                                    <button type="button" class="btn btn-default" onclick="addMore();" style="height: 30px;width:50px;float: right;margin-right:.5%"><i class="fa fa-plus"></i></button>
                                                                    <legend>Job Experience <span style="color: #286090; font-size:18px">(Most Recent First)</span></legend>
                                                                    <div class="row" style="padding-left: 2%;">
                                                                        <div class="col-md-3 mb-4">
                                                                            <div class="">
                                                                                <label>Organization</label>
                                                                                <input type="text" class="form-control" name="organization[]">
                                                                            </div>
                                                                            <div class="invalid-feedback"> Organization is required. </div>
                                                                        </div>

                                                                        <div class="col-md-3 mb-4">
                                                                            <div class="">
                                                                                <label>Position</label>
                                                                                <input type="text" class="form-control" name="position[]">
                                                                            </div>
                                                                            <div class="invalid-feedback"> Position is required. </div>
                                                                        </div>

                                                                        <div class="col-md-2 mb-4">
                                                                            <div class="">
                                                                                <label>Responsibility</label>
                                                                                <input type="text" class="form-control" name="responsibility[]">
                                                                            </div>
                                                                            <div class="invalid-feedback"> Responsibility is required. </div>
                                                                        </div>

                                                                        <div class="col-md-2 mb-4">
                                                                            <div class="">
                                                                                <label>From</label>
                                                                                <input type="date" class="form-control" name="experience_from[]">
                                                                            </div>
                                                                            <div class="invalid-feedback"> required. </div>
                                                                        </div>

                                                                        <div class="col-md-2 mb-4">
                                                                            <div class="">
                                                                                <label style="display: block;">To</label>
                                                                                <input id="experience_to" type="date" class="form-control" name="experience_to[]">
                                                                                <label class="checkbox-inline pt-1"><input name="is_working[]" type="checkbox" value="1">Still Working</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <ul id="list2" style="list-style-type: none;">
                                                                        <li class="default" style="display: none;">
                                                                            <div class="row">

                                                                                <div class="col-md-3 mb-4">
                                                                                    <div class="">
                                                                                        <label>Organization</label>
                                                                                        <input type="text" class="form-control" name="organization[]">
                                                                                    </div>
                                                                                    <div class="invalid-feedback"> required. </div>
                                                                                </div>

                                                                                <div class="col-md-3 mb-4">
                                                                                    <div class="">
                                                                                        <label>Position</label>
                                                                                        <input type="text" class="form-control" name="position[]">
                                                                                    </div>
                                                                                    <div class="invalid-feedback"> required. </div>
                                                                                </div>

                                                                                <div class="col-md-2 mb-4">
                                                                                    <div class="">
                                                                                        <label>Responsibility</label>
                                                                                        <input type="text" class="form-control" name="responsibility[]">
                                                                                    </div>
                                                                                    <div class="invalid-feedback"> required. </div>
                                                                                </div>

                                                                                <div class="col-md-2 mb-4">
                                                                                    <div class="">
                                                                                        <label>From</label>
                                                                                        <input type="date" class="form-control" name="experience_from[]">
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-2 mb-4">
                                                                                    <div class="">
                                                                                        <label style="display: block;">To</label>
                                                                                        <input id="experience_to" type="date" class="form-control" name="experience_to[]">
                                                                                        <label class="checkbox-inline pt-1"><input name="is_working[]" type="checkbox" value="1">Still Working</label>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                            <button type="button" class="btn btn-default" style="height: 30px;width:50px;cursor: pointer;color:red;margin-left: 94.8%;" onclick="closeMe(this);"><i class="fa fa-times"></i></button>
                                                                        </li>
                                                                    </ul>

                                                                    <button type="button" class="btn btn-default" onclick="addMore2();" style="height: 30px;width:50px;float: right;margin-right:.5%"><i class="fa fa-plus"></i></button>

                                                                    <legend>Add Your Skills</legend>
                                                                    <div class="col-md-12 mb-4">
                                                                        <div class="">
                                                                            <textarea name="skills" id="" cols="30" rows="3" placeholder="Enter your skills"></textarea>
                                                                        </div>
                                                                        <div class="invalid-feedback"> Skills are required. </div>
                                                                    </div>
                                                                    <legend>References</legend>

                                                                    <div class="row" style="padding-left: 2%;">

                                                                        <div class="col-md-3 mb-4">
                                                                            <div class="">
                                                                                <label>Name</label>
                                                                                <input type="text" class="form-control" name="ref_name[]">
                                                                            </div>
                                                                            <div class="invalid-feedback"> Name is required. </div>
                                                                        </div>

                                                                        <div class="col-md-3 mb-4">
                                                                            <div class="">
                                                                                <label>Organization</label>
                                                                                <input type="text" class="form-control" name="ref_organization[]">
                                                                            </div>
                                                                            <div class="invalid-feedback">Organization is required. </div>
                                                                        </div>

                                                                        <div class="col-md-3 mb-4">
                                                                            <div class="">
                                                                                <label>Designation</label>
                                                                                <input type="text" class="form-control" name="ref_designation[]">
                                                                            </div>
                                                                            <div class="invalid-feedback"> Designation is required. </div>
                                                                        </div>

                                                                        <div class="col-md-3 mb-4">
                                                                            <div class="">
                                                                                <label>Conatct [ Phone / Email ]</label>
                                                                                <input type="text" class="form-control" name="ref_contactNo[]">
                                                                            </div>
                                                                            <div class="invalid-feedback"> Conatct No is required. </div>
                                                                        </div>

                                                                    </div>

                                                                    <ul id="list3" style="list-style-type: none;">
                                                                        <li class="default" style="display: none;">
                                                                            <div class="row">

                                                                                <div class="col-md-3 mb-4">
                                                                                    <div class="">
                                                                                        <label>Name</label>
                                                                                        <input type="text" class="form-control" name="ref_name[]">
                                                                                    </div>
                                                                                    <div class="invalid-feedback"> Name is required. </div>
                                                                                </div>

                                                                                <div class="col-md-3 mb-4">
                                                                                    <div class="">
                                                                                        <label>Organization</label>
                                                                                        <input type="text" class="form-control" name="ref_organization[]">
                                                                                    </div>
                                                                                    <div class="invalid-feedback">Organization is required. </div>
                                                                                </div>

                                                                                <div class="col-md-3 mb-4">
                                                                                    <div class="">
                                                                                        <label>Designation</label>
                                                                                        <input type="text" class="form-control" name="ref_designation[]">
                                                                                    </div>
                                                                                    <div class="invalid-feedback"> Designation is required. </div>
                                                                                </div>

                                                                                <div class="col-md-3 mb-4">
                                                                                    <div class="">
                                                                                        <label>Conatct [ Phone / Email ]</label>
                                                                                        <input type="text" class="form-control" name="ref_contactNo[]">
                                                                                    </div>
                                                                                    <div class="invalid-feedback"> Conatct No is required. </div>
                                                                                </div>

                                                                            </div>
                                                                            <button type="button" class="btn btn-default" style="height: 30px;width:50px;cursor: pointer;color:red;margin-left: 94.8%;" onclick="closeMe(this);"><i class="fa fa-times"></i></button>
                                                                        </li>
                                                                    </ul>

                                                                    <button type="button" class="btn btn-default" onclick="addMore3();" style="height: 30px;width:50px;float: right;margin-right:.5%"><i class="fa fa-plus"></i></button>

                                                                    <br>

                                                                </div>
                                                                <br>
                                                                <br>
                                                                <br>
                                                                <hr class="mt-5">
                                                                <div class="d-flex">
                                                                    <button type="button" class="prev btn btn-info" style="height: 40px;width:100px">Previous</button> <button type="button" class="next btn btn-primary ml-auto" data-validate="fieldset02" style="height: 40px;width:100px">Next step</button>
                                                                </div>
                                                            </fieldset>

                                                        </div>

                                                        <div id="test-l-3" class="content dstepper-none fade">
                                                            <style>
                                                                .image-upload>input {
                                                                    display: none;
                                                                }
                                                            </style>
                                                            <fieldset>
                                                                <!-- <legend>Profile Picture</legend> -->
                                                                <div class="row">
                                                                    <div class="col-sm-6 text-center">
                                                                        <div class="container">
                                                                            <div class="image-upload">
                                                                                <h4 style="color: #286090; font-size:20px;">Profile Picture</h4>
                                                                                <label for="file-input">
                                                                                    <div class="visual-picker has-peek">
                                                                                        <!-- visual-picker input -->
                                                                                        <input type="checkbox" id="vpc01"> <!-- .visual-picker-figure -->
                                                                                        <span class="visual-picker-figure" style="height:200px;width:200px; border-radius:50%;">
                                                                                            <img id="blah" src="" alt="your image" style="float: right;height:200px;width:200px;border: 1px solid #E3E3E3; border-radius:50%" onerror="this.onerror=null; this.src='assets/images/default-user.png'" />
                                                                                        </span> <!-- /.visual-picker-figure -->
                                                                                        <!-- .visual-picker-peek -->
                                                                                        <span class="visual-picker-peek">Choose Image</span>
                                                                                    </div>
                                                                                </label>
                                                                                <input id="file-input" type="file" name="propic" accept="image/jpeg , image/png" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0]); ValidateSize(this);" data-parsley-group="fieldset03" required />
                                                                                <div class="invalid-feedback"> Profile Picture is required. </div>
                                                                                <div class="pt-3 text-info">
                                                                                    - Max allowed size 2 mb.<br>
                                                                                    - Allowed format Jpeg, Png. <br>
                                                                                    - Expected ratio 300*300.
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="file-upload">
                                                                            <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Upload NID/Passport/Birth Certificate File</button>
                                                                            <div class="image-upload-wrap">
                                                                                <input id="file-upload" name="identificationDoc_file" class="file-upload-input" type='file' onchange="readURL(this); ValidateSize(this);" accept="image/jpeg , image/png" />
                                                                                <div class="drag-text">
                                                                                    <h3>Drag and drop a file or Click on the upload button</h3>
                                                                                </div>
                                                                            </div>
                                                                            <div class="file-upload-content">
                                                                                <img class="file-upload-image" src="#" alt="your File" />
                                                                                <div class="image-title-wrap">
                                                                                    <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded File</span></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <!-- <legend>Identification</legend> -->
                                                                <!-- <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>Upload NID/Passport/Birth Certificate File</label>
                                                                                <input  type="file" name="identificationDoc_file" class="form-control" id="fileupload-customInput" style="height: 40px;" data-parsley-group="fieldset03" required>
                                                                            </div>
                                                                            <div class="invalid-feedback"> This Document file is required.</div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                <?php if ($server->data_byId($_GET['trackingID'], 'upload_audio') || $server->data_byId($_GET['trackingID'], 'upload_video')  == 1) { ?>
                                                                    <hr>
                                                                <?php } ?>
                                                                <!-- <legend style="color: #286090;">Record The Following Paragraph</legend> -->
                                                                <div class="row">
                                                                    <?php if ($server->data_byId($_GET['trackingID'], 'upload_audio') == 1) { ?>
                                                                        <div class="col-sm-6">
                                                                            <h4 style="color: #286090; font-size:20px;">Record The Following Paragraph</h4>
                                                                            <div class="form-group mb-4 text-justify" style="font-size: 18px;">
                                                                                <span> <?= $server->data_byId($_GET['trackingID'], 'audio_text') ?></span>
                                                                            </div>
                                                                            <div class="form-group mb-4">
                                                                                <iframe src="audio-only.php" height="250px" width="300px" title="Iframe Example"></iframe>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($server->data_byId($_GET['trackingID'], 'upload_video') == 1) { ?>
                                                                        <div class="col-sm-6">
                                                                            <h4 style="color: #286090; font-size:20px;"><span> <?= $server->data_byId($_GET['trackingID'], 'video_about') ?></span></h4>
                                                                            <div class="form-group mb-2">
                                                                                <video id="myVideo" class="video-js vjs-default-skin"></video>
                                                                                <span style="color:green; width:100%;" id="audioSuccess"></span>
                                                                                <span style="color:red; width:100%;" id="audioError"></span>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>

                                                                <div class="row mt-2">
                                                                    <?php if ($server->data_byId($_GET['trackingID'], 'upload_audio') == 1) { ?>
                                                                        <div class="col-sm-6">
                                                                            <div class="alert alert-warning alert-dismissible">
                                                                                <h4 class="alert-heading"><i class="fa fa-warning"></i> Warning!</h4>
                                                                                <h5>Audio Recording is required for application validation. Click on the Device button to record your audio.</h5>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($server->data_byId($_GET['trackingID'], 'upload_video') == 1) { ?>
                                                                        <div class="col-sm-6">
                                                                            <div class="alert alert-warning alert-dismissible">
                                                                                <h4 class="alert-heading"><i class="fa fa-warning"></i> Warning!</h4>
                                                                                <h5>Video Recording is required for application validation. Click on the Device button to record your video.</h5>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                                <hr class="mt-5">
                                                                <div class="d-flex">
                                                                    <button type="button" class="prev btn btn-info" style="height: 40px;width:100px">Previous</button> <button id="checkFiles" type="button" class="next btn btn-primary ml-auto" data-validate="fieldset03" style="height: 40px;width:100px">Next step</button>
                                                                </div>
                                                            </fieldset>
                                                        </div>

                                                        <div id="test-l-4" class="content dstepper-none fade">

                                                            <fieldset>
                                                                <?php if ($qus_count > 0) { ?>
                                                                    <legend>Please Answer The Following Questions!</legend>
                                                                    <?php foreach ($qustions as $qus) { ?>
                                                                        <div class="col-md-12 mb-3">
                                                                            <div class="">
                                                                                <label for=""><?= $qus['question'] ?></label>
                                                                                <input type="hidden" name="qus_id[]" value="<?= $qus['question_id'] ?>">
                                                                                <textarea name="answer[]" id="" cols="30" rows="3" placeholder="Enter your answer" data-parsley-group="agreement" required></textarea>
                                                                            </div>
                                                                            <div class="invalid-feedback"> answer are required. </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group mb-4">
                                                                            <div>
                                                                                <label>Expected Salary</label>
                                                                                <input type="text" name="salary" class="form-control" data-parsley-group="agreement" required>
                                                                            </div>
                                                                            <div class="invalid-feedback">Salary is required.</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php if ($job['upload_terms'] == 1) { ?>
                                                                    <legend>Terms Agreement</legend>
                                                                    <div class="card bg-light">
                                                                        <div class="card-body overflow-auto" style="height: 260px">
                                                                            <?= $job['term_text'] ?>
                                                                        </div>
                                                                    </div>

                                                                    <input type="checkbox" id="aggrementCheck" data-parsley-group="agreement" required />
                                                                    <label for="aggrementCheck"> I agree to the terms and policy.</label>
                                                                <?php } ?>
                                                                <hr class="mt-5">
                                                                <div class="">
                                                                    <button type="button" class="prev btn btn-info" style="height: 40px;width:100px">Previous</button>
                                                                    <button id="registration" type="submit" name="save" class="btn btn-primary pull-right" data-parsley-group="agreement" style="height: 40px;width:100px">Submit</button>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </form>
                                                    <div class="awesome-modal" id="modal@processing" style="background-color:white;">
                                                        <div class="text-center container">
                                                            <img src="assets/images/please_wait.gif" alt="">
                                                        </div>
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

            <footer id="footer" class="site-footer" itemscope="itemscope" itemtype="https://schema.org/WPFooter" role="contentinfo">
                <div id="footer-inner" class="clr">
                    <div id="footer-widgets" class="oceanwp-row clr">
                        <div class="footer-widgets-inner container">
                            <div class="footer-box span_1_of_4 col col-3">
                                <div id="text-3" class="footer-widget widget_text clr">
                                    <h4 class="widget-title">About Company</h4>
                                    <div class="textwidget">
                                        <p><a href="https://trysolutions.us/">Home</a></p>
                                        <p>
                                            <a href="https://trysolutions.us/about-us/">About Us</a>
                                        </p>
                                        <p><a href="index.html">Contact us</a></p>
                                        <p><a href="#">Pricing</a></p>
                                        <p><a href="#">Blog</a></p>
                                    </div>
                                </div>
                            </div>
                            <!-- .footer-one-box -->

                            <div class="footer-box span_1_of_4 col col-3">
                                <div id="text-4" class="footer-widget widget_text clr">
                                    <h4 class="widget-title">Our Services</h4>
                                    <div class="textwidget">
                                        <p>
                                            <a href="https://trysolutions.us/rei-services/">Featured Voice Service</a>
                                        </p>
                                        <p>
                                            <a href="https://trysolutions.us/cold-calling/">Call Center Service</a>
                                        </p>
                                        <p>
                                            <a href="https://trysolutions.us/administrative/">Administrative</a>
                                        </p>
                                        <p>
                                            <a href="https://trysolutions.us/web-design/">Development and Programming</a>
                                        </p>
                                        <p>
                                            <a href="https://trysolutions.us/graphics-design">Graphics Design</a>
                                        </p>
                                        <p>
                                            <a href="https://trysolutions.us/digital-marketing">Social media marketing</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- .footer-one-box -->

                            <div class="footer-box span_1_of_4 col col-3">
                                <div id="text-5" class="footer-widget widget_text clr">
                                    <h4 class="widget-title">Resource</h4>
                                    <div class="textwidget">
                                        <p><a href="#">Blog</a></p>
                                        <p><a href="#">Privacy Policy</a></p>
                                        <p><a href="#">Cookies Policy</a></p>
                                        <p><a href="#">Terms and Conditions</a></p>
                                        <p>
                                            <a href="https://trysolutions.us/sitemap/">Site Map</a>
                                        </p>
                                        <p>
                                            <a href="https://trybpoltd.com/career/">Career</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- .footer-one-box -->

                            <div class="footer-box span_1_of_4 col col-3">
                                <div id="text-2" class="footer-widget widget_text clr">
                                    <div class="textwidget">
                                        <p>
                                            <img loading="lazy" class="alignnone size-medium wp-image-115" src="../wp-content/uploads/2021/01/lgoooo_big-300x300.png" alt="" width="300" height="300" srcset="
                            https://trysolutions.us/wp-content/uploads/2021/01/lgoooo_big-300x300.png 300w,
                            https://trysolutions.us/wp-content/uploads/2021/01/lgoooo_big-150x150.png 150w,
                            https://trysolutions.us/wp-content/uploads/2021/01/lgoooo_big.png         477w
                          " sizes="(max-width: 300px) 100vw, 300px" />
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- .footer-box -->
                        </div>
                        <!-- .container -->
                    </div>
                    <!-- #footer-widgets -->

                    <div id="footer-bottom" class="clr no-footer-nav">
                        <div id="footer-bottom-inner" class="container clr">
                            <div id="copyright" class="clr" role="contentinfo">
                                Copyright &copy; 2021 - TRY SOLUTION LLC
                            </div>
                            <!-- #copyright -->
                        </div>
                        <!-- #footer-bottom-inner -->
                    </div>
                    <!-- #footer-bottom -->
                </div>
                <!-- #footer-inner -->
            </footer>
            <!-- #footer -->
        </div>
        <!-- #wrap -->
    </div>
    <!-- #outer-wrap -->
    <!-- video script -->
    <script>
        var player = videojs("myVideo", {
            controls: true,
            width: 520,
            height: 390,
            fluid: false,
            plugins: {
                record: {
                    audio: true,
                    video: true,
                    maxLength: 300,
                    debug: true
                }
            }
        }, function() {
            // print version information at startup
            var msg = 'Using video.js ' + videojs.VERSION +
                ' with videojs-record ' + videojs.getPluginVersion('record') +
                ' and recordrtc ' + RecordRTC.version;
            videojs.log(msg);
        });
        // error handling deviceReady progressRecord
        player.on('deviceError', function() {
            //console.log('device error:', player.deviceErrorCode);
            document.getElementById('audioError').innerHTML = 'Device Not Found!';
        });
        player.on('error', function(error) {
            //console.log('error:', error);
            document.getElementById('audioError').innerHTML = 'Please Connect Your Device!';
        });

        player.on('deviceReady', function() {
            //console.log('device error:', player.deviceErrorCode);
            document.getElementById('audioError').innerHTML = '';
            document.getElementById('audioSuccess').innerHTML = 'Device is Ready. You can record your video NOW!';
        });
        // user clicked the record button and started recording
        player.on('startRecord', function() {
            //console.log('started recording!');
            //document.getElementById('videoText').innerHTML = "Video Recording Started!";

        });

        player.on('progressRecord', function() {
            //console.log('started recording!');
            document.getElementById('audioSuccess').innerHTML = '';
            document.getElementById('audioError').innerHTML = "Recording is ON!";

        });
        // user completed recording and stream is available
        player.on('finishRecord', function() {
            // the blob object contains the recorded data that
            // can be downloaded by the user, stored on server etc.
            //console.log('finished recording: ', player.recordedData);
            //document.getElementById('videoText').innerHTML = "Video Recording Finished! You can check your recording or You can Record Again!";

            var formData = new FormData();
            formData.append('audiovideo', player.recordedData.video);

            // Execute the ajax request, in this case we have a very simple PHP script
            // that accepts and save the uploaded "video" file
            xhr('upload_files/upload-video.php', formData, function(fName) {
                //console.log("Video succesfully uploaded !");
                document.getElementById('audioError').innerHTML = '';
                document.getElementById('audioSuccess').innerHTML = "Recording Successfully Saved.You can check your record by click on play button or You can Record Again!";
            });

            // Helper function to send 
            function xhr(url, data, callback) {
                var request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (request.readyState == 4 && request.status == 200) {
                        callback(location.href + request.responseText);
                    }
                };
                request.open('POST', url);
                request.send(data);
            }
        });
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.image-upload-wrap').hide();

                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();

                    $('.image-title').html(input.files[0].name);
                };

                reader.readAsDataURL(input.files[0]);

            } else {
                removeUpload();
            }
        }

        function removeUpload() {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
        }
        $('.image-upload-wrap').bind('dragover', function() {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function() {
            $('.image-upload-wrap').removeClass('image-dropping');
        });
    </script>

    <?php include 'parts/scripts.php' ?>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/popper.js/umd/popper.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script> <!-- END BASE JS -->
    <!-- BEGIN PLUGINS JS -->

    <script src="assets/vendor/stacked-menu/js/stacked-menu.min.js"></script>
    <script src="assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/vendor/parsleyjs/parsley.min.js"></script>
    <script src="assets/vendor/vanilla-text-mask/vanillaTextMask.js"></script>
    <script src="assets/vendor/text-mask-addons/textMaskAddons.js"></script>
    <script src="assets/vendor/bs-stepper/js/bs-stepper.min.js"></script> <!-- END PLUGINS JS -->
    <!-- BEGIN THEME JS -->
    <script src="assets/javascript/theme.min.js"></script> <!-- END THEME JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="assets/javascript/pages/steps-demo.js"></script> <!-- END PAGE LEVEL JS -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-116692175-1"></script>
    <script>
        function closeMe(element) {
            $(element).parent().remove();
        }

        function addMore() {
            var container = $('#list');
            var item = container.find('.default').clone();
            item.removeClass('default');
            //add anything you like to item, ex: item.addClass('abc')....
            item.appendTo(container).show();
        }

        function addMore2() {
            var container = $('#list2');
            var item = container.find('.default').clone();
            item.removeClass('default');
            //add anything you like to item, ex: item.addClass('abc')....
            item.appendTo(container).show();
        }

        function addMore3() {
            var container = $('#list3');
            var item = container.find('.default').clone();
            item.removeClass('default');
            //add anything you like to item, ex: item.addClass('abc')....
            item.appendTo(container).show();
        }
    </script>
    <script>
        setInterval(function() {
            load();
        }, 1000);

        function load() {
            $('#loadSection').load(window.location.href + " #loadSection");
        }
    </script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#stepper-form").submit(function() {
                $("#stepper-form input[type=checkbox]:not(:checked)").each(function() {
                    $(this).val("0");
                    $(this).attr("checked", true);
                });
            });

        });
    </script>
    <script>
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                // Prevent if already submitting
                if (form.classList.contains('is-submitting')) {
                    e.preventDefault();
                }

                // Add class to hook our visual indicator on
                form.classList.add('is-submitting');
            });
        });

        function ValidateSize(file) {
        var FileSize = file.files[0].size / 1024 / 1024; // in MiB
        if (FileSize > 2) {
            alert('File size exceeds 2 MB');
           $(file).val('');
        } else {

        }
    }
    </script>

</body>

</html>