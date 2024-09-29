<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-lg-5">
        <a class="navbar-brand" href="<?= BASE_URL . '/'; ?>">سيارات</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?= BASE_URL . '/'; ?>" >الرئيسية</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/offer'; ?>">عروضك</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/favorite'; ?>">المفضله</a></li>
                <?php endif; ?>    
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 1): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/service'; ?>">الخدمات</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/carType'; ?>">انوع السيارات</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/category'; ?>">الفئات</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/admin'; ?>">المسؤولون</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] == 1 || $_SESSION['user']['role'] == 2)): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/OfferManagement'; ?>">ادارة العروض</a></li>
                <?php endif; ?>

                <?php if (!isset($_SESSION['user'])): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/user/login'; ?>">تسجيل الدخول</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/user/register'; ?>">التسجيل</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/user/logout'; ?>">تسجيل خروج</a></li>
                <?php endif; ?>
                
            </ul>
        </div>
    </div>
</nav>
