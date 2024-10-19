<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>


    <link href="../app/views/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    <title><?= isset($title) ? $title : 'CARS' ?></title>

    <style>
        .error-message {
            color: red;
            display: none;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <?php  require_once(VIEW . 'layout/navbar.php'); ?>

    <section class="pt-4">
        <div class="container px-lg-5">
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
        </div>
    </section>

    <?php  require_once(VIEW . 'layout/footer.php'); ?>
</body>

</html>