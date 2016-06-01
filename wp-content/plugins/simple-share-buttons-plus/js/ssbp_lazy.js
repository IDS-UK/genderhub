jQuery(document).ready(function(){

	// toggle switch
	jQuery('.ssbp-toggle-switch').on('click', function() {
		jQuery(this).parent().toggleClass('ssbp--state-hidden');
	});

	// loop through each container so they're unique
	jQuery('.ssbp-container').each(function(i, obj) {

		// collect and compile posted data to an array
		var data = {
			    action: 'ssbp_lazy',
			    security : ssbpLazy.security,
			    ssbppostid: jQuery(this).data("ssbp-post-id"),
			    ssbptitle: jQuery(this).data("ssbp-title"),
			    ssbpurl: jQuery(this).data("ssbp-url"),
			    ssbpshorturl: jQuery(this).data("ssbp-short-url"),
			    ssbpsharetext: jQuery(this).data("ssbp-share-text")
			};

		// load the share buttons via ajax
		jQuery.post(ssbpLazy.ajax_url, data, function(response) {

			// display buttons
			jQuery(obj).append(response);
			jQuery(obj).parent().removeClass('ssbp--state-hidden');
			jQuery('.ssbp-toggle-switch').fadeIn();

	        // upon clicking a simple share buttons plus button
			jQuery(obj).find('.ssbp-btn').click(function(event){

				// don't go the the href yet
				event.preventDefault();

				// collect and compile posted data to an array
				var data = {
					    action: 'ssbp_tracking',
					    security : ssbpAjax.security,
					    title: jQuery(this).data("ssbp-title"),
					    url: jQuery(this).data("ssbp-url"),
					    site: jQuery(this).data("ssbp-site"),
					    href: jQuery(this).attr("href"),
					};

				// these share options don't need to have a popup
				if (data['site'] == 'Email' || data['site'] == 'Print' || data['site'] == 'Pinterest' || data['site'] == 'WhatsApp')
				{
					// just redirect
					window.location.href = data['href'];
				}
				else
				{
					// prepare popup window
					var width  = 575,
					    height = 520,
					    left   = (jQuery(window).width()  - width)  / 2,
					    top    = (jQuery(window).height() - height) / 2,
					    opts   = 'status=1' +
					             ',width='  + width  +
					             ',height=' + height +
					             ',top='    + top    +
					             ',left='   + left;

					// open the share url in a smaller window
				    window.open(data['href'], 'SSBP', opts);
				}

				// log the share via ajax
				jQuery.post(ssbpAjax.ajax_url, data, function(response) {
					console.log(response);
				});
			}); // end of click event for buttons
	    }); // end of ajax post and response to get buttons
	}); // close loop of ssbp-containers
});
