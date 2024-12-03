<?php
use MVC\core\session;
$lang = session::Get('lang') ?? 'ar';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Car</title>
    <meta name="car" content="car" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/png">

    <script src="<?= BASE_URL . '/assets/js/vendor/jquery-3.6.0.min.js'?>"></script>
    <?php
        if($lang == 'ar'){
            echo '<link rel="stylesheet" href="' . BASE_URL . '/assets/css/bootstrapAr.css">';
            echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">';
        }else{
            echo '<link rel="stylesheet" href="' . BASE_URL . '/assets/css/bootstrap.css">';
        }
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <?php
        if ($lang == 'ar') {
            echo '<link rel="stylesheet" href="' . BASE_URL . '/assets/css/vendor/icomoonAr.css">';
            echo '<link rel="stylesheet" href="' . BASE_URL . '/assets/css/plugins/swiper-bundleAr.min.css">';
            echo '<link rel="stylesheet" href="' . BASE_URL . '/assets/css/plugins/ion.rangeSliderAr.min.css">';
            echo '<link rel="stylesheet" href="' . BASE_URL . '/assets/css/style2_ar.css">';
        }else{
            echo '<link rel="stylesheet" href="' . BASE_URL . '/assets/css/vendor/icomoon.css">';
            echo '<link rel="stylesheet" href="' . BASE_URL . '/assets/css/plugins/swiper-bundle.min.css">';
            echo '<link rel="stylesheet" href="' . BASE_URL . '/assets/css/plugins/ion.rangeSlider.min.css">';
            echo '<link rel="stylesheet" href="' . BASE_URL . '/assets/css/style2.css">';
        }
    ?>

</head>

<body>

    <main class="main-wrapper">
        <!-- ...:::Start User Event Section:::... -->
        <header class="header-section">
            <div class="container">
                <!-- Start User Event Area -->
                <div class="header-area">
                    <div class="header-top-area header-top-area--style-2">
                        <ul class="event-list mb-3">
                            <?php if (!isset($_SESSION['user'])): ?>
                                <li class="list-item">
                                    <a href="<?= BASE_URL . '/user/login'; ?>" aria-label="<?= __('Login') ?>" class="btn btn--size-33-33 btn--center btn--round btn--color-radical-red btn--bg-white btn--box-shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="#ff375f">
                                            <path d="M6 3a1 1 0 011-1h6a1 1 0 011 1v10a1 1 0 01-1 1H7a1 1 0 01-1-1v-1h1v1h6V3H7v1H6V3zm2.854 2.854a.5.5 0 00-.708-.708L5.5 7.293 3.854 5.646a.5.5 0 10-.708.708l2 2a.5.5 0 00.708 0l3-3z"></path>
                                        </svg>
                                    </a>
                                </li>
                                <li class="list-item">
                                    <a href="<?= BASE_URL . '/user/register'; ?>" aria-label="<?= __('Register') ?>" class="btn btn--size-33-33 btn--center btn--round btn--color-radical-red btn--bg-white btn--box-shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="#ff375f">
                                            <path d="M8 0a4 4 0 100 8A4 4 0 008 0zM3 5.5a.5.5 0 01.5-.5H6v-2a.5.5 0 011 0v2h2.5a.5.5 0 010 1H7v2.5a.5.5 0 01-1 0V6H3.5a.5.5 0 01-.5-.5zm5 4.5c-4.418 0-5.979 2.243-6 3.75V15h12v-1.25c-.021-1.507-1.582-3.75-6-3.75z"></path>
                                        </svg>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['user'])): ?>
                                <li class="list-item">
                                    <a href="<?= BASE_URL . '/user/logout'; ?>" aria-label="<?= __('Log Out') ?>" class="btn btn--size-33-33 btn--center btn--round btn--color-radical-red btn--bg-white btn--box-shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="#ff375f">
                                            <path d="M6 3a1 1 0 011-1h6a1 1 0 011 1v10a1 1 0 01-1 1H7a1 1 0 01-1-1v-1h1v1h6V3H7v1H6V3zM3.146 8.854a.5.5 0 000-.708l2-2a.5.5 0 10-.708-.708L2.293 8l2.145 2.146a.5.5 0 10.708-.708l-2-2z"></path>
                                        </svg>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <li class="list-item">
                                <div class="toggle-btn <?= $lang === 'en' ? 'toggled' : '' ?>" onclick="toggleLanguage(this)">
                                    <div class="toggle-circle"></div>
                                    <span class="ar">AR</span>
                                    <span class="en">EN</span>
                                </div>
                            </li>
                            <?php if (isset($_SESSION['user'])): ?>
                                <li class="list-item">
                                    <a href="<?= BASE_URL . '/offer'; ?>" aria-label="<?= __('offer') ?>" class="btn btn--size-33-33 btn--center btn--round btn--color-radical-red btn--bg-white btn--box-shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="#ff375f">
                                            <path d="M8 0a8 8 0 100 16A8 8 0 008 0zm4.5 8.5h-4v4a.5.5 0 01-1 0v-4h-4a.5.5 0 010-1h4v-4a.5.5 0 011 0v4h4a.5.5 0 010 1z"></path>
                                        </svg>
                                    </a>
                                </li>

                                <li class="list-item">
                                    <a href="<?= BASE_URL . '/my-desires'; ?>" aria-label="My Desires Page" class="btn btn--size-33-33 btn--center btn--round btn--color-radical-red btn--bg-white btn--box-shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="#ff375f">
                                            <path d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.08-.641 2.578.314 3.994C3.345 8.293 8 12.125 8 12.125s4.655-3.832 6.286-5.078c.955-1.416.837-2.914.314-3.994C13.486.878 10.4.28 8.717 2.011L8 2.748zM8 15s-5-4.133-6.5-6.164c-1.46-1.97-1.6-4.602-.646-6.158C2.745.78 5.322.246 7.082 1.972L8 2.88l.918-.908C10.678.246 13.255.78 14.146 2.678c.954 1.556.814 4.188-.646 6.158C13 10.867 8 15 8 15z"></path>
                                        </svg>
                                    </a>
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
                    <a href="/"><img class="img-fluid" width="147" height="26" src="<?= BASE_URL . '/assets/images/logo.png'?>" alt="image"></a>
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
    <script>
        function toggleLanguage(button) {
            button.classList.toggle('toggled');
            const lang = button.classList.contains('toggled') ? 'en' : 'ar';

            const xhr = new XMLHttpRequest();
            xhr.open('GET', '<?= BASE_URL ?>/home/changLang/' + lang, true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        console.log('Language successfully changed to:', lang);
                        location.reload();
                    } else {
                        console.error('Failed to change language');
                    }
                } else {
                    console.error('Error with the request:', xhr.status);
                }
            };

            xhr.onerror = function () {
                console.error('Network error occurred while changing language');
            };

            xhr.send();
        }
    </script>
</body>

</html>