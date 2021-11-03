(function ($, window, Typist) {
    
	/*---------owl-carousel------------*/
	
	
  $('.teams').owlCarousel({
		loop:true,
		margin:20,
		//autoplay:true,
		autoplayTimeout: 5000,
		//autoplayHoverPause: true,
		navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
		responsiveClass: true,
		smartSpeed: 2500,
		responsive:{
			0:{
				items:1,
				nav:true,
				loop:true
			},
			600:{
				items:2,
				nav:true,
				loop:true
			},
			1000:{
				items:3,
				nav:true,
				loop:true
			}
		}
	});
	
  
	/*-------tooltip---------*/
	
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});

	// wishlist func start
	// $('.wishlist').on('click', function(event) {
	// 	event.preventDefault();
	// 	var id = $(this).attr('data-id');
	// 	var type = $(this).attr('data-type');

	// 	console.log(id+' '+type);
	// });
	// wishlist func end 
	
	
	

/*-----------Right_nav--------*/

$(document).ready(function(){
    $('#slide').click(function(){
	    var hidden = $('.hidden');
		var noticeHidden = $('.noticeHidden');
	    if (hidden.hasClass('visible')){
	        hidden.animate({"right":"-100%"}, "slow").removeClass('visible'); //right = from -1920px to -100%
	    } else {
	        hidden.animate({"right":"0px"}, "slow").addClass('visible');
	    }

		if (noticeHidden.hasClass('visible')){
	        noticeHidden.animate({"right":"-100%"}, "slow").removeClass('visible'); //right = from -1920px to -100%
	    }
    });

	$('#noticeSlide').click(function(){
		var noticeHidden = $('.noticeHidden');
	    var hidden = $('.hidden');
		if (noticeHidden.hasClass('visible')){
			noticeHidden.animate({"right":"-100%"}, "slow").removeClass('visible'); //right = from -1920px to -100%
		} else {
			noticeHidden.animate({"right":"0px"}, "slow").addClass('visible');
		}
		if (hidden.hasClass('visible')){
	        hidden.animate({"right":"-100%"}, "slow").removeClass('visible'); //right = from -1920px to -100%
	    }
	});
});


})(jQuery, window);

