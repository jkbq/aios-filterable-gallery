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
			aios_color_picker();
			filterable_gallery_permastructure();
			generate_forms();
		}

		/**
		 * Set color picker.
		 */
		function aios_color_picker() {
			var $inputPicker = $( '.aios-color-picker' );

			$inputPicker.each( function() {
				$( this ).wpColorPicker();
			} );
		}

		/** 
		 * Slug for Listings - On keypress remove replace special character to -
		 */
		function filterable_gallery_permastructure() {
			var $inputPermastructure = $( '.filterable_gallery-permastructure' );

			$inputPermastructure.on( 'keyup', function() {
				var $this 	= $( this ),
					$val 	= slugify( $this.val() );

				$this.val( $val );
			} );
		}
			function slugify(string) {
				const a = 'àáäâãèéëêìíïîòóöôùúüûñçßÿœæŕśńṕẃǵǹḿǘẍźḧ·/_,:;';
				const b = 'aaaaaeeeeiiiioooouuuuncsyoarsnpwgnmuxzh------';
				const p = new RegExp(a.split('').join('|'), 'g');

				return string.toString().toLowerCase()
					.replace(/\s+/g, '-') /** Replace spaces with **/
					.replace(p, c => b.charAt(a.indexOf(c))) /** Replace special characters **/
					.replace(/&/g, '-and-') /** Replace & with ‘and’ **/
					.replace(/[^\w\-]+/g, '-') /** Remove all non-word characters **/
					.replace(/\-\-+/g, '-') /** Replace multiple — with single - **/
					.replace(/^-+/, ''); /** Trim — from start of text .replace(/-+$/, '') Trim — from end of text **/
			}

		/**
		 * Generate Default Forms
		 */
		function generate_forms() {
			var $generate_form = $( '#filterable_gallery-generate-forms' );

			$generate_form.on( 'click', function( e ) {
				e.preventDefault();

				$.post( ajaxurl, {
					'action' : 'aios_filterable_gallery_generate_forms',
				}, function( response ) {
					var res = JSON.parse( response );

					swal({
						type: 'success',
						title: 'Successfully Generated',
						text: 'Changes will be made after the refresh',
						showConfirmButton: false,
						timer: 2000
					});

					setTimeout( function() {
						location.reload();
					}, 2000 );
					
				} );

			} );
		}

		/**
		 * Instantiate
		 */
		__construct();

	} );
} )( jQuery );
