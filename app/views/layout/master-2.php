<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Car</title>
    <meta name="car" content="car" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= BASE_URL . '/assets/js/vendor/jquery-3.6.0.min.js'?>"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <link rel="shortcut icon" href="<?= BASE_URL . '/assets/images/favicon.ico'?>" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL . '/assets/css/vendor/icomoon.css'?>" />
    <link rel="stylesheet" href="<?= BASE_URL . '/assets/css/plugins/swiper-bundle.min.css'?>">
    <link rel="stylesheet" href="<?= BASE_URL . '/assets/css/plugins/ion.rangeSlider.min.css'?>">
    <link rel="stylesheet" href="<?= BASE_URL . '/assets/css/style.css'?>">

    <style>
        .custom-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-group {
            flex: 1;
            min-width: 200px;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .custom-select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            background-color: #f8f8f8;
            color: #333;
        }

        .custom-select:focus {
            outline: none;
            border-color: #ff375f; /* Matches template accent color */
        }

        .custom-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .primary-btn {
            background-color: #ff375f;
            color: white;
        }

        .primary-btn:hover {
            background-color: #e03354;
        }

        .success-btn {
            background-color: green;
            color: white;
        }

        .secondary-btn {
            background-color: gray;
            color: white;
        }

        .form-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .custom-btn-success {
            background-color: #28a745;
            border: none;
            color: #fff;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .custom-btn-success:hover {
            background-color: #218838;
            color: #fff;
        }
        .custom-btn-warning {
            background-color: #ffc107;
            border: none;
            color: #212529;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .custom-btn-warning:hover {
            background-color: #e0a800;
            color: #212529;
        }
        .custom-btn-danger {
            background-color: #dc3545;
            border: none;
            color: #fff;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .custom-btn-danger:hover {
            background-color: #c82333;
            color: #fff;
        }
        .custom-btn-secondary {
            background-color: #6c757d;
            border: none;
            color: #fff;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .custom-btn-secondary:hover {
            background-color: #5a6268;
            color: #fff;
        }
        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-items-center {
            align-items: center;
        }

        .mb-2 {
            margin-bottom: 0.5rem; /* Adjust spacing as needed */
        }
    </style>
</head>

<body>

    <main class="main-wrapper">
        <!-- ...:::Start User Event Section:::... -->
        <header class="header-section">
            <div class="container">
                <!-- Start User Event Area -->
                <div class="header-area">
                    <div class="header-top-area header-top-area--style-2">
                        <ul class="event-list">
                            <li class="list-item">
                                <a href="#mobile-menu-offcanvas" area-label="mobile menu offcanvas svg icon" class="btn btn--size-33-33 btn--center btn--round btn--color-radical-red btn--bg-white btn--box-shadow main-menu offcanvas-toggle offside-menu">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <g id="Group_1" data-name="Group 1" transform="translate(-28 -63)">
                                            <path id="Rectangle_3" data-name="Rectangle 3" d="M0,0H5A2,2,0,0,1,7,2V5A2,2,0,0,1,5,7H2A2,2,0,0,1,0,5V0A0,0,0,0,1,0,0Z" transform="translate(28 63)" fill="#ff375f" />
                                            <path id="Rectangle_6" data-name="Rectangle 6" d="M2,0H5A2,2,0,0,1,7,2V5A2,2,0,0,1,5,7H0A0,0,0,0,1,0,7V2A2,2,0,0,1,2,0Z" transform="translate(28 72)" fill="#ff375f" />
                                            <path id="Rectangle_4" data-name="Rectangle 4" d="M2,0H7A0,0,0,0,1,7,0V5A2,2,0,0,1,5,7H2A2,2,0,0,1,0,5V2A2,2,0,0,1,2,0Z" transform="translate(37 63)" fill="#ff375f" />
                                            <path id="Rectangle_5" data-name="Rectangle 5" d="M2,0H5A2,2,0,0,1,7,2V7A0,0,0,0,1,7,7H2A2,2,0,0,1,0,5V2A2,2,0,0,1,2,0Z" transform="translate(37 72)" fill="#ff375f" />
                                        </g>
                                    </svg>
                                </a>
                            </li>

                            <?php if (isset($_SESSION['user'])): ?>
                                <li class="list-item">
                                    <ul class="list-child">
                                        <li class="list-item">
                                            <span class="notch-bg notch-bg--emerald"></span>
                                            <a href="#profile-menu-offcanvas" area-label="User" class="btn btn--size-33-33 btn--center btn--round offcanvas-toggle offside-menu"><img class="img-fluid" height="33" width="33" src="<?= BASE_URL . '/assets/images/header-top-user-img.jpg'?>" alt="image"></a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <!-- End User Event Area -->
            </div>
        </header>
        <!-- ...:::End User Event Section:::... -->

        <!--  Start Offcanvas Mobile Menu Section -->
        <div id="mobile-menu-offcanvas" class="offcanvas offcanvas-leftside offcanvas-mobile-menu-section">
            <!-- Start Offcanvas Header -->
            <div class="offcanvas-header flex-end">

                <div class="logo">
                    <a href="index.html"><img class="img-fluid" width="147" height="26" src="<?= BASE_URL . '/assets/images/logo.png'?>" alt="image"></a>
                </div>

                <button class="offcanvas-close" aria-label="offcanvas svg icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="5.973" height="10.449" viewBox="0 0 5.973 10.449">
                        <path id="Icon_ionic-ios-arrow-back" data-name="Icon ionic-ios-arrow-back" d="M13.051,11.417,17,7.466a.747.747,0,0,0-1.058-1.054l-4.479,4.476a.745.745,0,0,0-.022,1.03l4.5,4.507A.747.747,0,1,0,17,15.37Z" transform="translate(-11.251 -6.194)" />
                    </svg>
                </button>
            </div>
            <!-- End Offcanvas Header -->

            <?php require_once(VIEW . 'layout/left-side-bar.php'); ?>
            
        </div> <!-- ...:::: End Offcanvas Mobile Menu Section:::... -->
        <?php if (isset($_SESSION['user'])): ?>
            <?php require_once(VIEW . 'layout/right-side-bar.php'); ?>
        <?php endif; ?>

        <?php if (isset($errorMessage) && $errorMessage != ""): ?>
            <div class="error-message" id="error-message">
                <?= $errorMessage ?>
            </div>
        <?php endif; ?>
        <?php 
            if (isset($content)) {
                echo $content; 
            }
        ?>

        <div class="offcanvas-overlay"></div>
        <?php require_once(VIEW . 'layout/footer-2.php'); ?>
    </main>
    <script src="<?= BASE_URL . '/assets/js/vendor/modernizr-3.11.2.min.js'?>"></script>
    <script src="<?= BASE_URL . '/assets/js/vendor/jquery-migrate-3.3.2.min.js'?>"></script>
    <script src="<?= BASE_URL . '/assets/js/plugins/swiper-bundle.min.js'?>"></script>
    <script src="<?= BASE_URL . '/assets/js/plugins/ion.rangeSlider.min.js'?>"></script>
    <script src="<?= BASE_URL . '/assets/js/main.js'?>"></script>
</body>

</html>