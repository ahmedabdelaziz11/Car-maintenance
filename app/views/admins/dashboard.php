<?php ob_start(); ?>

<h1>Admin Dashboard</h1>

<div class="row">
    <div class="col-md-3 m-2">
        <a class="btn btn-primary" href="<?= BASE_URL . '/country'; ?>">البلدان</a>
    </div>
    <div class="col-md-3 m-2">
        <a class="btn btn-primary" href="<?= BASE_URL . '/city'; ?>">المدن</a>
    </div>
    <div class="col-md-3 m-2">
        <a class="btn btn-primary" href="<?= BASE_URL . '/service'; ?>">الخدمات</a>
    </div>
    <div class="col-md-3 m-2">
        <a class="btn btn-primary" href="<?= BASE_URL . '/carType'; ?>">أنواع السيارات</a>
    </div>
    <div class="col-md-3 m-2">
        <a class="btn btn-primary" href="<?= BASE_URL . '/category'; ?>">الفئات</a>
    </div>
    <div class="col-md-3 m-2">
        <a class="btn btn-primary" href="<?= BASE_URL . '/admin'; ?>">المسؤولون</a>
    </div>
</div>

<table class="table mt-4">
    <thead>
        <tr>
            <th>offers</th>
            <th><?= $data['offerCount'] ?></th>
        </tr>
        <tr>
            <th>users</th>
            <th><?= $data['userCount'] ?></th>
        </tr>
        <tr>
            <th>comments</th>
            <th><?= $data['commentCount'] ?></th>
        </tr>
        <tr>
            <th>reports</th>
            <th><?= $data['reportCount'] ?></th>
        </tr>
        <tr>
            <th>favorite</th>
            <th><?= $data['favoriteCount'] ?></th>
        </tr>
    </thead>
</table>
<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master.php');
?>