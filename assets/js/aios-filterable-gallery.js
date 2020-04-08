( function($) {
	$( document ).ready( function() {

		var $document 		= $( document ),
			$window 		= $( window ),
			$viewport 		= $( 'html, body' ),
			$html 			= $( 'html' ),
			$body 			= $( 'body' );
		/**
		 * Construct.
		 */
		function __construct() {
			pagination();
		}
		function  pagination() {

			$paginate = $('.aios-gallery-pagination a');

			$paginate.on('click', function (e) {
				e.preventDefault();
				$('#paginate-value').val($(this).data('page'));
				$('.aios-gallery-submit-bttn input').trigger('click');
			});

		}
		/**
		 * Instantiate
		 */
		__construct();

	} );
} )( jQuery );
