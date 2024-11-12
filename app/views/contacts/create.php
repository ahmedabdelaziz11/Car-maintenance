<?php ob_start(); ?>

<h1 style="font-size: 24px; margin-bottom: 20px;">Contact Us</h1>
<form method="POST" action="<?= BASE_URL . '/contact/create'; ?>" style="
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 8px;
    max-width: 500px;
    margin: 0 auto;
">
    <label for="contact_type" style="
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
        font-weight: bold;
    ">Contact Type</label>
    <select id="contact_type" name="contact_type" style="
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
    ">
        <option value="Complaint">Complaint</option>
        <option value="Suggestion">Suggestion</option>
        <option value="Inquiry">Inquiry</option>
    </select>

    <label for="title" style="
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
        font-weight: bold;
    ">Title</label>
    <input id="title" name="title" style="
        width: 100%;
        height: 120px;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
        resize: vertical;
        margin-bottom: 15px;
    " placeholder="Type your title here..." required>

    <label for="message" style="
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
        font-weight: bold;
    ">Message</label>
    <textarea id="message" name="message" style="
        width: 100%;
        height: 120px;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
        resize: vertical;
        margin-bottom: 15px;
    " placeholder="Type your message here..." required></textarea>



    <button type="submit" class="btn btn-primary" style="
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
    ">Send</button>
</form>

<?php $content = ob_get_clean(); ?>
<?php require_once(VIEW . 'layout/master.php'); ?>
