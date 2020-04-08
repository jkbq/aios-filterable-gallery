( function($) {
	$( document ).ready( function() {

		var $document 		= $( document ),
			$window 		= $( window ),
			$viewport 		= $( 'html, body' ),
			$html 			= $( 'html' ),
			$body 			= $( 'body' );

		function __construct() {
			custom_select();
			gallery_lists();


		}

		function custom_select() {


			 $('form').submit(function () {
				var $empty_fields = $(this).find(':input').filter(function () {
					return $(this).val() === '';
				});
				$empty_fields.prop('disabled', true);
				return true;
			});

			$(".js-range-slider").ionRangeSlider({
				 skin: "round",
				  onChange: function (data) {
				 	$('#age').val(''+data['from']+','+data['to']+'');
				}
			});


			$parent		= $(".aios-gallery-dropdown-filter");

			$parent.each(function(){
				var $input = $(this).find("input");
				var $dropDown = $(this).find("ul");

				$(this).on("click", function(){
				  $dropDown.stop().slideToggle();
				  $(this).toggleClass( 'active');
				});

				$dropDown.on("click", "li", function(){
				  $input.val( $(this).text() );
				});

			  });

			// more options
			$more = $('.aios-more-option');

			$more.on('click', function () {
				$('.aios-gallery-form-more-wrap').slideToggle();

				$procedure_types = $('input[name="procedure_types"]');


				if ($procedure_types.val() == 'Breast Augmentation'){

					// procedure types
					$('.breast-augmentation').css({
						'display': 'flex',
					});
				}else{
					$('.breast-augmentation').hide();
				}


			});


			$procedure_types = $('input[name="procedure_types"]');

			if ($procedure_types.val() == 'Breast Augmentation'){

				// procedure types
				$('.breast-augmentation').css({
					'display': 'flex',
				});
			}else{
				$('.breast-augmentation').hide();
			}

			// checkbox
			jQuery('.aios-producedure-filter .styled-checkbox').on('click', function(){



					jQuery('input[name="procedure_types"]').val(jQuery(this).val());
					jQuery('.aios-gallery-submit-bttn input').trigger('click');

			});

			//sort

			jQuery('.aios-sort-by select').on('change', function () {

				jQuery('#sort').val(jQuery(this).val());
				jQuery('.aios-gallery-submit-bttn input').trigger('click');
			})
		}
		
		function gallery_lists() {


		}


		/** Instantiate **/
		__construct();

	} );
} )( jQuery );