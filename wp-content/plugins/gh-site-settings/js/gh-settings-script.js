(function($) {

	$(document).ready(function () {

		var mediaUploader;

		$('.upload-button').click(function(e) {
			e.preventDefault();
			target_input = $(this).prev().attr('id');

			var btnClicked = $(this);
			var selectedField = btnClicked.prev('.uploaded-image');
			// If the uploader object has already been created, reopen the dialog
			if (mediaUploader) {
				mediaUploader.open();
				return;
			}
			// Extend the wp.media object
			mediaUploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Choose Image'
				}, multiple: false });

			// When a file is selected, grab the URL and set it as the text field's value
			mediaUploader.on('select', function() {
				attachment = mediaUploader.state().get('selection').first().toJSON();

				$('#' + target_input).val(attachment.url);
                console.log('image selected for '+target_input);
			});
			// Open the uploader dialog
			mediaUploader.open();
		});


	});

}(jQuery));