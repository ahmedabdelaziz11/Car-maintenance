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

<?php 
    if (isset($content)) {
        echo $content; 
    }
?>

    <script src="../assets/js/vendor/modernizr-3.11.2.min.js"></script>
    <script src="../assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/vendor/jquery-migrate-3.3.2.min.js"></script>
    <script src="../assets/js/plugins/swiper-bundle.min.js"></script>
    <script src="../assets/js/plugins/ion.rangeSlider.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>