( function($) {
	$( document ).ready( function() {

		const	$document 		= $( document );
		const	$window 		= $( window );
		const	$viewport 		= $( 'html, body' );
		const	$html 			= $( 'html' );
		const	$body 			= $( 'body' );


		// CONSTRUCT

		function __construct(){

			aios_ion_slider();
			aios_gallery_custom_dropdown();
			aios_render_cases();
			aios_search_func();
			aios_sort();
			taxonomy_quick_search();
			aios_pagination();

		}
		function  aios_ion_slider() {
			$(".js-range-slider").ionRangeSlider({
				 skin: "round",
				  onChange: function (data) {
					$('#age').val(''+data['from']+','+data['to']+'');
				}
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
		
		function aios_render_cases() {
				$.post( ajaxurl, {
					'action' 	: 'aios_medical_post_filter',
					'data'		: jQuery('.aios-gallery-form form').serialize(),
				}, function(response) {
					$('.aios-gallery-lists .row').append(response);
					$('#loader').fadeOut();
					$('.aios-gallery-lists .row').animate({
						opacity: 1,
					});
					initComparisons();
				} ).done( function() {

				} );

		}
		
		function aios_search_func() {
			let button = $('.aios-gallery-submit-bttn input');
			
			button.on('click', function (e) {
				e.preventDefault();
				e.stopPropagation();
				$('#loader').fadeIn();
				$('.aios-gallery-lists .row').empty();
				aios_render_cases();
			});



		}
		
		function aios_sort() {

			sort = $('.aios-sort-by select');

			sort.on('change', function () {

					$('#loader').fadeIn();
					$('.aios-gallery-lists .row').empty();
					$('input[name="sorts"]').val($(this).val());
					aios_render_cases();
			})
		}
		
		function taxonomy_quick_search() {

			taxonomy 	= $('.aios-toxonomy-quick-search input');
			procedure	= $('input[name="procedure"]');

			 taxonomy.click(function () {
				$("[name="+$(this).prop('name')+"]").prop("checked", false);
				$(this).prop("checked", true);
				$('#loader').fadeIn();
				$('.aios-gallery-lists .row').empty();

				if ($(this).is(':checked')) {
					procedure.val($(this).val());

				}else{
						procedure.val('');
				}
				aios_render_cases();
			});

		}
		
		function aios_pagination() {

			let li = $('.aios-gallery-pagination a');

			$('.aios-gallery-pagination li:first a').addClass('active');
			li.on('click', function (e) {
				e.preventDefault();
				e.stopPropagation();

				li.removeClass('active');
				$('input[name="page"]').val($(this).data('page'));

				$('.aios-gallery-submit-bttn input').trigger('click');
				$(this).addClass('active');
			});
		}

		__construct();

	} );
} )( jQuery );