<?php ob_start(); ?>

<div class="about-container">
    <h1 class="about-title"><?= __('Terms And Conditions') ?></h1>
    <div class="about-content">
        <p>
            dsl kcxkc dsjkdjso kxjzks kakxlzm eewpeockbf sa[sp[lcsi ;c[x]]] fxjjckx
        </p>
        <p>
            dsl kcxkc dsjkdjso kxjzks kakxlzm eewpeockbf sa[sp[lcsi ;c[x]]] fxjjckx
        </p>
        <p>
            dsl kcxkc dsjkdjso kxjzks kakxlzm eewpeockbf sa[sp[lcsi ;c[x]]] fxjjckx
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master-2.php');
?>
