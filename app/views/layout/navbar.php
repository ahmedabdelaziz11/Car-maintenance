<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-lg-5">
        <a class="navbar-brand" href="<?= BASE_URL . '/'; ?>">سيارات</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php
            use MVC\core\notifications;
            use MVC\models\chat;
            $notifications = notifications::userNotifications();
            $chat          = new chat();
            $unreadCount = count(array_filter($notifications, fn($n) => $n['is_read'] == 0));
            $unreadMessages = $chat->getUnreadMessages();
        ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?= BASE_URL . '/'; ?>">الرئيسية</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/contact'; ?>">تواصل معانا</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/offer'; ?>">عروضك</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/favorite'; ?>">المفضلة</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/chat/index/'; ?>" > المحدثات <span class="badge bg-danger"> <?= $unreadMessages; ?></span></a> </li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/notification/index'; ?>">إشعارات <span class="badge bg-danger"><?= $unreadCount; ?></span></a></li>
                <?php endif; ?>

                <!-- Admin Links -->
                <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] == 1 || $_SESSION['user']['role'] == 2)): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ادارة النظام</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="max-height: 300px; overflow-y: auto;">
                            <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] == 1)): ?>
                                <li><a class="dropdown-item" href="<?= BASE_URL . '/country'; ?>">البلدان</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL . '/city'; ?>">المدن</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL . '/service'; ?>">الخدمات</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL . '/carType'; ?>">أنواع السيارات</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL . '/category'; ?>">الفئات</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL . '/admin'; ?>">المسؤولون</a></li>
                            <?php endif; ?>


                            <li><a class="dropdown-item" href="<?= BASE_URL . '/OfferManagement'; ?>">إدارة العروض</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL . '/report'; ?>">إدارة البلاغات</a></li>
                        </ul>

                    </li>
                <?php endif; ?>
                

                <?php if (!isset($_SESSION['user'])): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/user/login'; ?>">تسجيل الدخول</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/user/register'; ?>">التسجيل</a></li>
                    <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/#'; ?>"><?=$_SESSION['user']['name']?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . '/user/logout'; ?>">تسجيل خروج</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

