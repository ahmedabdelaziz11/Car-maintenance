<?php ob_start(); ?>

<div class="faq-container">
    <h1 class="faq-title"><?= __('Frequently Asked Questions') ?></h1>

    <div class="faq-item">
        <button class="faq-question" onclick="toggleAnswer(this)">
            test test test test?
        </button>
        <div class="faq-answer">
            tesst tessst tessttt
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question" onclick="toggleAnswer(this)">
            test test test test?
        </button>
        <div class="faq-answer">
            tesst tessst tessttt
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question" onclick="toggleAnswer(this)">
            test test test test?
        </button>
        <div class="faq-answer">
            tesst tessst tessttt
        </div>
    </div>
</div>

<script>
    function toggleAnswer(button) {
        const answer = button.nextElementSibling;
        answer.classList.toggle('open');
    }
</script>

<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master-2.php');
?>