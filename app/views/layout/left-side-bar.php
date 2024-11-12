<!-- Start Offcanvas Mobile Menu Wrapper -->
<div class="offcanvas-mobile-menu-wrapper">
    <!-- Start Mobile Menu  -->
    <div class="mobile-menu-bottom">
        <!-- Start Mobile Menu Nav -->
        <div class="offcanvas-menu">
            <ul>
                <li>
                    <a href="<?= BASE_URL . '/'; ?>"><span>Home</span></a>
                </li>



                <?php
                    use MVC\models\chat;
                    $chat          = new chat();
                    $unreadMessages = $chat->getUnreadMessages();
                ?>


                <?php if (isset($_SESSION['user'])): ?>
                    <li>
                        <a href="#"><span>Shop</span></a>
                        <ul class="mobile-sub-menu">
                            <li><a href="<?= BASE_URL . '/offer'; ?>">My Offers</a></li>
                            <li><a href="<?= BASE_URL . '/favorite'; ?>">Wishlist</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><span>Pages</span></a>
                        <ul class="mobile-sub-menu">
                            <li><a href="<?= BASE_URL . '/chat/index/'; ?>">Chat <span class="badge bg-danger"> <?= $unreadMessages; ?></span></a></li>
                            <li><a href="<?= BASE_URL . '/contact'; ?>">Contact Us</a></li>
                        </ul>
                    </li>
                <?php endif; ?>


                <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] == 1 || $_SESSION['user']['role'] == 2)): ?>
                    <li>
                        <a href="#"><span>Admin Dashboard</span></a>
                        <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] == 1)): ?>
                            <ul class="mobile-sub-menu">
                                <li><a href="<?= BASE_URL . '/country'; ?>">Countries</a></li>
                                <li><a href="<?= BASE_URL . '/city'; ?>">Cities</a></li>
                                <li><a href="<?= BASE_URL . '/service'; ?>">Services</a></li>
                                <li><a href="<?= BASE_URL . '/carType'; ?>">Car Types</a></li>
                                <li><a href="<?= BASE_URL . '/category'; ?>">Categories</a></li>
                                <li><a href="<?= BASE_URL . '/admin'; ?>">Admins</a></li>
                            </ul>
                        <?php endif; ?>
                    </li>
                    <li>
                        <a href="#"><span>management</span></a>
                        <ul class="mobile-sub-menu">
                            <li><a href="<?= BASE_URL . '/OfferManagement'; ?>">Offers management</a></li>
                            <li><a href="<?= BASE_URL . '/report'; ?>">Reports management</a></li>
                        </ul>
                    </li>
                <?php endif; ?>


                <?php if (!isset($_SESSION['user'])): ?>
                    <li>
                        <a href="<?= BASE_URL . '/user/login'; ?>">Login</a>
                        <a href="<?= BASE_URL . '/user/register'; ?>">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div> <!-- End Mobile Menu Nav -->
    </div> <!-- End Mobile Menu -->

    <!-- Start Mobile contact Info -->
    <div class="mobile-contact-info">
        <address class="address">
            <span>Address: 4710-4890 Breckinridge St, Fayettevill</span>
            <span>Call Us: (+800) 345 678, (+800) 123 456</span>
            <span>Email: yourmail@mail.com</span>
        </address>
    </div>
    <!-- End Mobile contact Info -->

</div> <!-- End Offcanvas Mobile Menu Wrapper -->