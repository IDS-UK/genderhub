/**
 * Created by Sarah on 07/02/2016.
 */
(function($) {

    $(document).ready(function () {

	var largestHeight = 0;
	$("#featured_content h6").each(function() {
		largestHeight = ( $(this).height() > largestHeight ? $(this).height() : largestHeight );
	});
	$("#featured_content h6").each(function() {
		$(this).height(largestHeight);
	});
	    
	$('.captioned-image').each(function() {
		$(this).addClass('processed');
		$(this).hover(
			function() {//console.log('over');
				$(this).children('.image-caption').fadeIn();
			},
			function() {//console.log('out');
				$(this).children('.image-caption').fadeOut();
	  		}
		);
	});
        // get the height of the document list in the first tab of the document container
        largestHeight = $("#doc-container .doclist:first-child").outerHeight();

        //$("#doc-container .doclist").each(function(){

        //    if ($(this).outerHeight() > largestHeight ) {

        //        largestHeight = $(this).outerHeight();
        //    }
        //});

        $("#doc-container").height(largestHeight);

        // show/hide the documents lists if a filter is applied
        $(".docfilter, .topicfilter").click(function() {

            var target = $(this).attr("rel");

            $(".docfilter").removeClass("active");

            $(".docfilter").each(function() {

                if ($(this).attr("rel") == target) {
                    $(this).addClass("active");
                }
            });

            $("#doc-container .doclist").each(function() {

                if ($(this).attr("id") == target) {
                    var container = $("#doc-container");
                    var h = $(this).outerHeight();
                    $(this).show(500);
                    container.animate({height:h});
                } else {

                    $(this).hide(500);
                }
            });

        });


    });

}(jQuery));

