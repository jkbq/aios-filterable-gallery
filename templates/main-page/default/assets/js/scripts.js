( function($) {
	$( document ).ready( function() {

		var $document 		= $( document ),
			$window 		= $( window ),
			$viewport 		= $( 'html, body' ),
			$html 			= $( 'html' ),
			$body 			= $( 'body' );

		function __construct() {
			aios_gallery_custom_dropdown();
			aios_gallery_custom_dropdown_v2();
			aios_custom_search();

		}
		function aios_custom_search() {

			$seachbody  = $('.aios-gallery-searc-second');
			$procedure =  $('.aios-gallery-dropdown-procedure');

			$procedure.on('click', function () {
					$seachbody.stop().slideToggle();
			});
		}
		function aios_gallery_custom_dropdown() {

			let parent		= $(".aios-gallery-dropdown-filter");

			parent.each(function(){
				const input = $(this).find("input");
				const dropDown = $(this).find("ul");

				$(this).on("click", function(){
					dropDown.stop().slideToggle();
					$(this).toggleClass( 'active');
				});

				dropDown.on("click", "li", function(){
					input.val( $(this).text() );
				});
			});

		}
		function aios_gallery_custom_dropdown_v2() {

			let parent		= $(".aios-gallery-dropdown-filter-v2");

			parent.each(function(){
				const input = $(this).find("input");
				const dropDown = $(this).find("ul");

				$(this).on("click", function(){
					$('.aios-gallery-dropdown-filter-v2').removeClass('active');
					$('.aios-gallery-dropdown-filter-v2 ul').slideUp();
					dropDown.stop().slideToggle();
					$(this).toggleClass( 'active');

				});

				dropDown.on("click", "li", function(){
					$('.aios-gallery-dropdown-filter-v2 input').animate({opacity: 0});
					input.val( $(this).data('slug') );
					input.animate({opacity: 1}, 1000);

					jQuery('.aios-gallery-third-level-wrap').slideUp();
					var activeTab = jQuery(this).data("slug");
					jQuery("."+activeTab).slideDown();

				});






			});

		}

		/** Instantiate **/
		__construct();

	} );
} )( jQuery );