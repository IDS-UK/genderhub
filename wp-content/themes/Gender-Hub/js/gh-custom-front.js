/**
 * Created by Sarah on 07/02/2016.
 */
(function($) {

    $(document).ready(function () {


        $('#searchicon').click(function(){
            $('header.site [id=searchform]').toggleClass('active');
        });


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

        var owl = $('.owl-carousel').owlCarousel({
            margin: 10,
            nav: true,
            dots: false,
            slideBy: 1,
            loop: false,
            navText : [ '<img src="/wp-content/uploads/2015/05/arrow-left.png">','<img src="/wp-content/uploads/2015/05/arrow-right.png">'],
            responsive: {
                0: {
                    items:1
                },
                450: {
                    items:1
                },
                640: {
                    items:2
                },
                960: {
                    items:4
                }
            }
        });

        var owlAnimateFilter = function(even) {
            $(this)
                .addClass('__loading')
                .delay(70 * $(this).parent().index())
                .queue(function() {
                    $(this).dequeue().removeClass('__loading')
                })
        };

        $('#filter').on('click', '.btn-filter', function(e) {
            var filter_data = $(this).data('filter');

            if($(this).hasClass('btn-active')) return;

            $(this).addClass('btn-active').siblings().removeClass('btn-active');

            owl.owlFilter(filter_data, function(_owl) {
                $(_owl).find('.item').each(owlAnimateFilter);
            });
        });

        $.fn.owlRemoveItem = function(num) {
            var owl_data = $(this).data('owlCarousel');

            owl_data._items = $.map(owl_data._items, function(data, index) {
                if(index != num) return data;
            })

            $(this).find('.owl-item').eq(num).remove();
        }

        $.fn.owlFilter = function(data, callback) {
            var owl = this,
                owl_data = $(owl).data('owlCarousel'),
                $elemCopy = $('<div>').css('display', 'none');

            /* check attr owl-clone exist */
            if(typeof($(owl).data('owl-clone')) == 'undefined') {
                $(owl).find('.owl-item:not(.cloned)').clone().appendTo($elemCopy);
                $(owl).data('owl-clone', $elemCopy);
            }else {
                $elemCopy = $(owl).data('owl-clone');
            }

            /* clear content */
            owl.trigger('replace.owl.carousel', ['<div/>']);

            switch(data){
                case '*':
                    $elemCopy.children().each(function() {
                        owl.trigger('add.owl.carousel', [$(this).clone()]);
                    })
                    break;
                default:
                    $elemCopy.find(data).each(function() {
                        owl.trigger('add.owl.carousel', [$(this).parent().clone()]);
                    })
                    break;
            }

            /* remove item empty when clear */
            owl.owlRemoveItem(0);
            owl.trigger('refresh.owl.carousel').trigger('to.owl.carousel', [0]);

            // callback
            if(callback) callback.call(this, owl);
        }



    });

}(jQuery));

