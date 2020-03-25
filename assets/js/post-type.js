( function($) {
	$( document ).ready( function() {

		function __construct() {
			filterable_gallery_select();
			add_options();
			delete_options();
			pdf_upload();
			convert_currency();
			listing_upload_images();
			open_house_date_picker();
			property_status();
			sold_date();
			date_listed();
		}

        /** Initialize select bootstrap */
		function filterable_gallery_select() {
			$( '.filterable_gallery-select' ).each(function(){
				$( this ).select2({
					tags: true,
					closeOnSelect: false
				});
			});
		}

		/** Add term features, types, statuses, and neighborhoods */
		function add_options() {
			var $additional_items = $( '.additional-items-buttons' );

			$additional_items.on( 'click', function( e ) {
				e.preventDefault();

				var $this 					= $( this ),
					$parent 				= $( this ).parent(),
					$additional_items_input = $parent.find( '#additional-items' ),
					insertToDiv 			= $additional_items_input.attr('data-id'),
					$insertToDiv 			= $( '#' +  insertToDiv ),
					taxonomy_name			= $insertToDiv.attr('data-taxonomy-name'),
					taxonomy_terms_name		= $additional_items_input.val();

				if ( taxonomy_terms_name == '' ) {
					swal({
						type: 'error',
						title: 'Value must not be empty',
						showConfirmButton: false,
						timer: 1500
					});
				} else {
					$.post( ajaxurl, {
						'action' 				: 'aios_filterable_gallery_add_options',
						'taxonomy_name' 		: taxonomy_name,
						'taxonomy_terms_name' 	: taxonomy_terms_name
					}, function( response ) {
						var res = JSON.parse( response );
						if ( res[0] == 'Successfully Added' ) {
							$insertToDiv.find( '.form-checkbox-group' ).append('<div class="form-checkbox has-delete"><label><input type="checkbox" name="property-features[]" id="property-features" value="' + res[1] + '"> ' + taxonomy_terms_name + ' <span class="delete-checkbox">Delete</span></label></div>');
							$additional_items_input.val('');

							swal({
								type: 'success',
								title: 'Successfully Added',
								showConfirmButton: false,
								timer: 1500,
							});
						} else {
							swal({
								type: 'error',
								title: res[0],
								showConfirmButton: false,
								timer: 1500
							});
						}
					} );
				}

			} );
		}

		/** Add term features, types, statuses, and neighborhoods */
		function delete_options() {
			var $delete_items = $( '.form-checkbox.has-delete span' );

			$delete_items.on( 'click', function( e ) {
				e.preventDefault();

				var $this 				= $( this ),
					$parent_checkbox 	= $this.parents( '.form-checkbox' ),
					$parent_container 	= $this.parents( '.options-container' ),
					taxonomy_name 		= $parent_container.attr('data-taxonomy-name'),
					taxonomy_terms_name = $parent_checkbox.find( 'input[type="checkbox"]' ).val();


				swal({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.value) {
						$.post( ajaxurl, {
							'action' 				: 'aios_filterable_gallery_delete_options',
							'taxonomy_name' 		: taxonomy_name,
							'taxonomy_terms_name' 	: taxonomy_terms_name
						}, function( response ) {
							var res = JSON.parse( response );

							if ( res[0] == 'Successfully Deleted' ) {
								swal({
									type: 'success',
									title: 'Successfully Deleted',
									showConfirmButton: false,
									timer: 1500
								});

								$parent_checkbox.remove();
							} else {
								swal({
									type: 'error',
									title: res[0],
									showConfirmButton: false,
									timer: 1500
								});
							}
							
						} );
					}
				});

			} );
		}

		/** Upload PDF */
		function pdf_upload() {
			var $pdfUploadBtn = $( '#pdf-link-uploader' );

			$pdfUploadBtn.on( 'click', function() {
				var image = wp.media( {
					title: 'Upload PDF',
					library: {
						type : 'application/pdf'
					},
					multiple: false
				} ).open()
				.on( 'select', function(e){
					/** This will return the selected image from the featured-image Uploader, the result is an object */
					var uploaded_image = image.state().get( 'selection' ).first();

					/** We convert uploaded_image to a JSON object to make accessing it easier */
					var image_url = uploaded_image.toJSON().url;

					/** Let's assign the url value to the input field */
					$( '#others_pdf_link' ).val( image_url );
				});
			} );
		}

		/** Price input convert to currency */
		function convert_currency() {
			var $inputPrice = $( '#list_price, #sold_price, #details_lot_area, #details_flooring_size, #details_appx_living_area' );

			$inputPrice.on( 'keyup', function() {
				var $this 	= $( this ),
					$val 	= convertToPrice( $this.val() );

				$this.val( $val );
			} );
		}
			function convertToPrice(numbers) {
				numbers = numbers
					.replace(/\s+/g, '') /** Replace spaces with */
					.replace(/[^0-9.]/g, '') /** Replace all non-numbers and not a dot and existings comma */
					.replace(/\.\.+/g, ''); /** Replace multiple .. with single .. */

				x = numbers.split('.');
				x1 = x[0];
				x2 = x.length > 1 ? '.' + x[1] : '';
				var rgx = /(\d+)(\d{3})/;
				while (rgx.test(x1)) {
					x1 = x1.replace(rgx, '$1' + ',' + '$2');
				}
				return x1 + x2;
			}

		/** Image uploader */
		function listing_upload_images() {
			$( '.listing-button' ).on( 'click', 'input[type=button]', function() {
				/** Element var */
				var this_parent			= $( this ).parents( '.listing-container-parent' ),
					image_input 		= this_parent.find( '.listing-image-input' ),
					image_prev 			= this_parent.find( '.listing-image-preview' );


				if ( $( this ).hasClass( 'listing-upload' ) ) {
					/** To change type you need to rename all type under createFilters and controller_states */
					/** Get currrent Post ID */
					wp.media.view.settings.post.id = $( '#post_ID' ).val();

					/** Create our custom upload/browse view for our workflow. */
					var attachmentFiltersView = wp.media.view.AttachmentFilters.Uploaded.extend({
						/** Rename filter */
						createFilters: function() {
							var filters = {};

								filters.all = {
									text: 'All Images',
									props: {
										status:  null,
										type:    'image',
										uploadedTo: null,
										orderby: 'date',
										order:   'DESC'
									},
									priority: 10
								};

								filters.not_previously_attached = {
									text: 'All Not Previously Attached',
									props: {
										status:  null,
										type:    'image',
										uploadedTo: null,
										orderby: 'date',
										order:   'DESC'
									},
									priority: 15
								};

								filters.uploaded = {
									text:  'Uploaded to this Listing',
									props: {
										status:  null,
										type:    'image',
										uploadedTo: wp.media.view.settings.post.id,
										orderby: 'menuOrder',
										order:   'ASC'
									},
									priority: 20
								};

							this.filters = filters;
						},
						/** on Change */
						change: function(event){
							var filter = this.filters[this.el.value];

							if ( filter ) {
								if ( 'all' == this.el.value ){
									/** All images will display */
									this.filters[this.el.value].props.post_parent = null;
								} else if ( 'not_previously_attached' == this.el.value ) {
									/** If we are viewing all the items, only show media items not previously attached to other posts.  */
									this.filters[this.el.value].props.post_parent = 0;
								} else {
									this.filters[this.el.value].props.post_parent = wp.media.view.settings.post.id;
								}

								this.model.set(filter.props);
							}
						},
						/** Selected Filter */
						select: function(){
							var model = this.model,
								value = 'uploaded',
								props = model.toJSON();

							_.find( this.filters, function(filter, id){
								var equal = _.all(filter.props, function(prop, key){
									return prop === ( _.isUndefined(props[key]) ? null : props[key] );
								});

								if ( equal ) return value = id;
							});

							this.$el.val(value);
						}
					});

					/** Overwrite the default view workflow with our own that has been created above. */
					wp.media.view.AttachmentFilters.Uploaded = attachmentFiltersView;

					/** Create our default controller states */
					var controller_states = [
						new wp.media.controller.Library({
							title: 'Upload Featured Image',
							filterable: 'uploaded',
							library: wp.media.query({ 
								type : 'image',
								uploadedTo: wp.media.view.settings.post.id
							}),
							multiple: false,
							contentUserSetting: true
						})
					]

					var image = wp.media( {
						button: { text: 'Upload Image' },
						state : 'library',
						states: controller_states,
						multiple: false
					} ).open()
					.on( 'select', function(e){
						/** This will return the selected image from the listing Uploader, the result is an object */
						var uploaded_image = image.state().get( 'selection' ).first();

						/** We convert uploaded_image to a JSON object to make accessing it easier */
						var image_url = uploaded_image.toJSON().url,
							image_id = uploaded_image.toJSON().id;

						/** Let's assign the url value to the input field */
						image_input.val( image_id );
						image_prev.empty( '' );
						image_prev.append( '<img src="' + image_url + '">' );
						/** animate tabContentWrapper height when content changes  */
					});
				} else if( $( this ).hasClass( 'listing-remove' ) ) {
					image_input.val( '' );
					image_prev.empty( '' );
					image_prev.append( '<p>No image uploaded</p>' );
				}

			} );
		}

		/** Date Picker */
		function open_house_date_picker() {
			var $datePairOpenHouse 	= $( '.datePairOpenHouse' ),
				date 				= new Date();
			date.setDate(date.getDate()-1);

			$datePairOpenHouse.each( function( i,v ) {
				/** initialize input widgets first */
				$( v ).find( '.time' ).timepicker({
					'showDuration': true,
					'timeFormat': 'g:ia'
				} );

				$( v ).find( '.date' ).datepicker({
					'format': 'yyyy-m-d',
					'autoclose': true,
					'startDate': date
				} );

				/** initialize datepair */
				$( v ).datepair();
			} );
		}

		/** Property Status */
		function property_status() {
			var $property_statuses 	= $( '.property_statuses' ),
				$sold_date 			= $( '#sold-date' );

			$property_statuses.on( 'change', function() {
				var $this 			= $( this ),
					status_single 	= [ 'sold', 'pending', 'withdrawn' ],
					status 			= $this.attr( 'data-property-status' );

				if ( status != 'sold' ) $sold_date.addClass( 'wpui-temporary-hide' );

				if ( $.inArray( status, status_single ) != -1 ) {
					$property_statuses.not(this).prop('checked', false);
				} else {
					$( 'input[data-property-status="sold"], input[data-property-status="pending"], input[data-property-status="withdrawn"]' ).prop('checked', false);
				}
			} );
		}

		/** Sold Date */
		function sold_date() {
			var $sold_date 			= $( '#sold-date' ),
				$sold_date_input 	= $( '#sold_date' ),
				$status_sold_input 	= $( 'input[data-property-status="sold"]' );

			$sold_date_input.datepicker({
				'format': 'yyyy-m-d',
				'autoclose': true,
				'todayHighlight': true
			} );

			$status_sold_input.on( 'change', function() {
				var $this = $( this );

				if ( $this.is( ':checked' ) ) {
					$sold_date.removeClass( 'wpui-temporary-hide' );
				} else {
					$sold_date.addClass( 'wpui-temporary-hide' );
				}
			} );
		}

		/** Date Listed */
		function date_listed() {
			var $details_date_listed = $( '#details_date_listed' );

			$details_date_listed.datepicker({
				'format': 'yyyy-m-d',
				'autoclose': true,
				'todayHighlight': true
			} );
		}

		/** Instantiate */
		__construct();

	} );
} )( jQuery );