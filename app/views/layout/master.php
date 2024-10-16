<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <link href="../app/views/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


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