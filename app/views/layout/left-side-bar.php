<div class="offcanvas-mobile-menu-wrapper">
    <div class="mobile-menu-bottom">
        <div class="offcanvas-menu">
            <ul>
                <li>
                    <a href="<?= BASE_URL . '/'; ?>"><span><?= __('Home') ?></span></a>
                </li>
                <?php
                    use MVC\models\chat;
                    $chat          = new chat();
                    $unreadMessages = $chat->getUnreadMessages();
                ?>
                <?php if (isset($_SESSION['user'])): ?>
                    <li>
                        <a href="#"><span><?= __('Shop') ?></span></a>
                        <ul class="mobile-sub-menu">
                            <li><a href="<?= BASE_URL . '/offer'; ?>"><?= __('My Offers') ?></a></li>
                            <li><a href="<?= BASE_URL . '/favorite'; ?>"><?= __('Wishlist') ?></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><span><?= __('Pages') ?></span></a>
                        <ul class="mobile-sub-menu">
                            <li><a href="<?= BASE_URL . '/chat/index/'; ?>"> <?= __('Chat') ?><span class="badge bg-danger"> <?= $unreadMessages; ?></span></a></li>
                            <li><a href="<?= BASE_URL . '/contact'; ?>"><?= __('Contact Us') ?></a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] == 1 || $_SESSION['user']['role'] == 2)): ?>
                    <li>
                        <a href="#"><span><?= __('Admin Dashboard') ?></span></a>
                        <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] == 1)): ?>
                            <ul class="mobile-sub-menu">
                                <li><a href="<?= BASE_URL . '/country'; ?>"><?= __('Countries') ?></a></li>
                                <li><a href="<?= BASE_URL . '/city'; ?>"><?= __('Cities') ?></a></li>
                                <li><a href="<?= BASE_URL . '/service'; ?>"><?= __('Services') ?></a></li>
                                <li><a href="<?= BASE_URL . '/carType'; ?>"><?= __('Car Types') ?></a></li>
                                <li><a href="<?= BASE_URL . '/category'; ?>"><?= __('Categories') ?></a></li>
                                <li><a href="<?= BASE_URL . '/admin'; ?>"><?= __('Admins') ?></a></li>
                            </ul>
                        <?php endif; ?>
                    </li>
                    <li>
                        <a href="#"><span><?= __('management') ?></span></a>
                        <ul class="mobile-sub-menu">
                            <li><a href="<?= BASE_URL . '/OfferManagement'; ?>"><?= __('Offers management') ?></a></li>
                            <li><a href="<?= BASE_URL . '/report'; ?>"><?= __('Reports management') ?></a></li>
                        </ul>
                    </li>
                <?php endif; ?>


                <?php if (!isset($_SESSION['user'])): ?>
                    <li>
                        <a href="<?= BASE_URL . '/user/login'; ?>"><?= __('Login') ?></a>
                        <a href="<?= BASE_URL . '/user/register'; ?>"><?= __('Register') ?></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div> <!-- End Mobile Menu Nav -->
    </div> <!-- End Mobile Menu -->

    <!-- Start Mobile contact Info -->
    <div class="mobile-contact-info">
        <address class="address">
            <span><?= __('Address') ?> : 4710-4890 Breckinridge St, Fayettevill </span>
            <span> <?= __('Call Us') ?>: (+800) 345 678, (+800) 123 456</span>
            <span>Email <?= __('Email') ?>: yourmail@mail.com</span>
        </address>
    </div>
    <!-- End Mobile contact Info -->

</div> <!-- End Offcanvas Mobile Menu Wrapper -->