    <!--  Start Offcanvas Profile Menu Section -->
    <div id="profile-menu-offcanvas" class="offcanvas offcanvas-rightside">
        <!-- Start Offcanvas Header -->
        <div class="offcanvas-header flex-start offcanvas-modify">
            <button class="offcanvas-close" aria-label="offcanvas svg icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="5.973" height="10.449" viewBox="0 0 5.973 10.449">
                    <path id="Icon_ionic-ios-arrow-back" data-name="Icon ionic-ios-arrow-back" d="M13.051,11.417,17,7.466a.747.747,0,0,0-1.058-1.054l-4.479,4.476a.745.745,0,0,0-.022,1.03l4.5,4.507A.747.747,0,1,0,17,15.37Z" transform="translate(-11.251 -6.194)" />
                </svg>
            </button>
            <span>Home</span>

        </div> <!-- End Offcanvas Header -->
        <!-- Start Offcanvas Mobile Menu Wrapper -->
        <div class="offcanvas-profile-menu-wrapper">
            <!-- ...:::Start Profile Card Section:::... -->
            <div class="profile-card-section section-gap-top-25">
                <div class="profile-card-wrapper">
                    <div class="content">
                        <h2 class="name"><?=$_SESSION['user']['name']?></h2>
                        <span class="email"><?=$_SESSION['user']['email']?></span>
                    </div>
                    <div class="profile-shape profile-shape-1"><img class="img-fluid" width="61" height="50" src="<?= BASE_URL . '/assets/images/profile-shape-1.svg'; ?>" alt="image"></div>
                    <div class="profile-shape profile-shape-2"><img class="img-fluid" width="48" height="59" src="<?= BASE_URL . '/assets/images/profile-shape-2.svg'; ?>" alt="image"></div>
                </div>
            </div>
            <!-- ...:::End Profile Card Section:::... -->

            <!-- ...:::Start Profile Details Section:::... -->
            <?php
                use MVC\core\notifications;
                $notifications = notifications::userNotifications();
                $unreadCount = count(array_filter($notifications, fn($n) => $n['is_read'] == 0));
            ?>
            <div class="profile-details-section section-gap-top-30">
                <div class="profile-details-wrapper">
                    <div class="profile-details-bottom">
                        <ul class="profile-user-list">
                            <li class="profile-list-item">
                                <ul class="profile-single-list">
                                    <li class="list-item">
                                        <span class="title">Setting</span>
                                    </li>
                                    <li class="list-item">
                                        <a href="<?= BASE_URL . '/notification/index'; ?>" class="profile-link"><span class="icon"><i
                                            class="icon icon-carce-bell"></i></span>Notification <span class="badge bg-danger"><?= $unreadCount; ?></span></a>
                                    </li>
                                </ul>
                            </li>

                            <li class="profile-list-item">
                                <ul class="profile-single-list">
                                    <li class="list-item">
                                        <a href="<?= BASE_URL . '/user/logout'; ?>" class="profile-link"><span class="icon"><i
                                            class="icon icon-carce-login"></i></span>Log Out</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- ...:::End Profile Details Section:::... -->
        </div> <!-- End Offcanvas Mobile Menu Wrapper -->
    </div> <!-- ...:::: End Offcanvas Profile Menu Section:::... -->