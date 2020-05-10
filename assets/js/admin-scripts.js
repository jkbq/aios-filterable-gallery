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

			generate_shortcode();
			jQuery(window).on('load', function () {
				jQuery('#procedurediv').insertAfter('.acf-postbox:first-child');
				jQuery('#procedurediv').show();
			});
		}

		function copyToClipboard(selector){
		  var $temp = $("<div>");
		  $("body").append($temp);
		  $temp.attr("contenteditable", true)
			   .html($(selector).html()).select()
			   .on("focus", function() { document.execCommand('selectAll',false,null); })
			   .focus();
		  document.execCommand("copy");
		  $temp.remove();
		}

		function generate_shortcode() {
			jQuery('.gal-generate-btn').on('click', function(e){
					e.preventDefault();

					$gender 		= jQuery('#gender').val();
					$procedure  	= jQuery('#procedure').val();
					$sort       	= jQuery('#sort').val();
					$order_by   	= jQuery('#order-by').val();
					$showposts   	= jQuery('#showposts').val();



					Swal.fire({
					  title: '<strong>Shortcode Generated</strong>',
					  icon: 'info',
					  html: '<p>Copy the code below</p>' +
						  '<div id="copyshortcode">' +
						  '[aios_filterable_gallery' +
						  ' '+ ($showposts != '' ? 'showposts="'+$showposts+'"' : '') +'' +
						  ' '+ ($order_by != '' ? 'orderby="'+ $order_by +'"' : '' ) +'' +
						  ' '+ ( $sort != '' ? 'order="'+ $sort +'"' : '' ) +'' +
						  '  '+ ($procedure != '' ? 'procedure="'+ $procedure +'"' : '' ) +' ' +
						  ' '+ ($gender != '' ? 'gender="'+ $gender +'"' : '' ) +']' +
						  '</div>',
						showCloseButton: true,
						showCancelButton: false,
						confirmButtonText: 'Copy Shortcode!',
						focusConfirm: false,
						cancelButtonAriaLabel: 'Thumbs down',
						onBeforeOpen: () => {
							jQuery('.swal2-confirm').on('click', function () {
								copyToClipboard('#copyshortcode');
							});
						},
					})


			});
		}

		/**
		 * Instantiate
		 */
		__construct();

	} );
} )( jQuery );
