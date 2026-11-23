jQuery(document).ready(function ($) {
    let mediaUploader;

    $(document).on('click', '.upload_image_button', function (e) {
        e.preventDefault();

        const button = $(this);
        const input = button.prev('input');

        // If mediaUploader already exists, reopen it
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        // Create new media uploader
        mediaUploader = wp.media({
            title: 'Select Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });

        mediaUploader.on('select', function () {
            const attachment = mediaUploader.state().get('selection').first().toJSON();
            input.val(attachment.url).trigger('change');;
        });

        mediaUploader.open();
    });
});
