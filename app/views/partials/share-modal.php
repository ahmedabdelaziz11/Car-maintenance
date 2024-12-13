<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportCommentModalLabel"><?= __('Share Link') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-content" style="padding: 5px;">
                    <ul style="margin: 15px 0 20px 0;display: flex;justify-content: space-between;align-items: center;">
                        <p style="font-size: 16px;"><?= __('Share this link via') ?></p>
                        <a href="#" id="facebookShare" style="height: 50px; width: 50px; font-size: 20px; text-decoration: none; border: 1px solid transparent; color: #1877F2; border-color: #b7d4fb; display: flex; align-items: center; justify-content: center; transition: background 0.3s ease-in-out;">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" id="whatsappShare" style="height: 50px; width: 50px; font-size: 20px; text-decoration: none; border: 1px solid transparent; color: #25D366; border-color: #bef4d2; display: flex; align-items: center; justify-content: center; transition: background 0.3s ease-in-out;">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </ul>

                    <p style="font-size: 16px;"><?= __('Or copy the link') ?></p>
                    <div style="display: flex;align-items: center;justify-content: space-between;height: 45px;border-radius: 4px;padding: 0 5px;border: .5px solid #e1dfc7;">
                        <input style="width: 100%;height: 100%;border: none;outline: none;font-size: 15px;" id="copyInput" type="text" readonly="" value="">
                        <button id="copyLinkBtn" class="custom-btn-success"><?= __('Copy') ?></button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn custom-btn-secondary" data-dismiss="modal"> <?= __('Close') ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    const copyLinkBtn = document.getElementById('copyLinkBtn');
    const copyInput = document.getElementById('copyInput');

    copyLinkBtn.addEventListener('click', function() {
        copyInput.select();
        document.execCommand('copy');

        copyLinkBtn.innerText = "<?= __('Copied'); ?>";
        setTimeout(() => {
            copyLinkBtn.innerText = "<?= __('Copy'); ?>";
        }, 3000);
    });

    function openShareModal(offerUrl, offerTitle, offerDescription, offerImage) {
        const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(offerUrl)}`;
        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(offerTitle + " - " + offerUrl)}`;

        document.getElementById('facebookShare').setAttribute('href', facebookUrl);
        document.getElementById('whatsappShare').setAttribute('href', whatsappUrl);
        document.getElementById('copyInput').value = offerUrl;

        const modal = new bootstrap.Modal(document.getElementById('shareModal'));
        modal.show();
    }
</script>