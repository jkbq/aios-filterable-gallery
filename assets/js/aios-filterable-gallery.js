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

		
		function aios_render_cases() {
				$.post( ajaxurl, {
					'action' 	: 'aios_medical_post_filter',
					'data'		: jQuery('.aios-gallery-form input').filter(function () {
							return !!this.value;
						}).serialize(),
				}, function(response) {
					$('.aios-gallery-lists .row').append(response);
					$('#loader').fadeOut();
					$('.aios-gallery-lists .row').animate({
						opacity: 1,
					});
					initComparisons();
					jQuery('.aios-gallery-list-wrap').slick({
						dots: true,
						infinite: false,
						speed: 300,
						swipe: false,
						slidesToShow: 1,
						slidesToScroll: 1,
					});

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

			  var current = $(".aios-gallery-numbers").text();

				  $(".aios-gallery-pagination-prev").on("click", function() {
					current = current - 1;
					$(".aios-gallery-numbers").text(current);
					$('#loader').fadeIn();
					$('.aios-gallery-lists .row').empty();
					$('#paginate-value').val(current);
					aios_render_cases();
				  });
				  $(".aios-gallery-pagination-next").on("click", function() {
						current = parseInt(current) + parseInt(1);
						$(".aios-gallery-numbers").text(current);
						$('#loader').fadeIn();
						$('.aios-gallery-lists .row').empty();
						$('#paginate-value').val(current);
						aios_render_cases();
				  });


		}

		__construct();

	} );
} )( jQuery );