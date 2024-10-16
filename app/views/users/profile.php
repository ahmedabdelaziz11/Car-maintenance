<?php ob_start(); ?>

<h1><?= $user['name'] ?>'s Profile</h1>
<p>Email: <?= $user['email'] ?></p>

<h2>Offers</h2>
<ul>
    <?php foreach ($offers as $offer): ?>
        <li>
            <a href="<?= BASE_URL ?>/offer/details/<?= $offer['id'] ?>"><?= $offer['title'] ?></a>
        </li>
    <?php endforeach; ?>
</ul>


<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master.php'); 
?>
