
// as the page loads, call these scripts
jQuery(document).ready( function($) {


	$('#main-navigation .icon-list').click( function(){
		$('body').toggleClass('menu-expand');

	})
	
	$('#primary').fitVids();
	$('#secondary').fitVids();

	
	$('.share-box div > a').click( function(){
		$('#share-post').toggle();
		return false;
	});

	$('.slider-view').imagesLoaded( function(){
										fixFlexsliderNav(); 
									} );

		
	$(window).resize( function(){
		fixFlexsliderNav();
	});
	
	$('.load-more a').live('click', function(e){
		widgetId = $(this).parents('.widget').attr("id");
		e.preventDefault();
		$(this).addClass('loading').text('Loading...');
		$.ajax({
			type: "GET",
			url: $(this).attr('href') + '#content',
			dataType: "html",
			success: function(out){
				result = $(out).find('#' + widgetId + ' .post');
				nextlink = $(out).find('#' + widgetId + ' .load-more a').attr('href');
				$('#' + widgetId + ' .posts-block').append(result.fadeIn(300));
				$('#' + widgetId + ' .load-more a').removeClass('loading').text('Load More');
				if (nextlink != undefined) {
					$('#' + widgetId + ' .load-more a').attr('href', nextlink);
				} else {
					$('#' + widgetId + ' .load-more').remove();
				}
			}
		});
	});
	function fixFlexsliderNav(){
		$('.slider-view').find( function(){
			thisSlider = $(this);
			imgHeight = $('.flex-active-slide img').height();
			$('.flex-direction-nav', thisSlider).css('top', (imgHeight - 50) + 'px');
		});
	}


});	


