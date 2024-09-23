<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <title><?= isset($title) ? $title : 'CARS' ?></title>
</head>

<body>
    <?php  require_once(VIEW . 'layout/navbar.php'); ?>

    <section class="pt-4">
        <div class="container px-lg-5">
        <?php 
            if (isset($content)) {
                echo $content; 
            }
        ?>
        </div>
    </section>

    <?php  require_once(VIEW . 'layout/footer.php'); ?>

</body>

</html>