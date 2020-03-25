( function($) {
	$( document ).ready( function() {

		var $body 					= $( 'body' ),
			$window 				= $( window ),
			$filterable_gallery_gallery 		= $( '.filterable_gallery-gallery' ), /** This where to add uploaded images */
			_filterable_gallery_sortable 		= '.filterable_gallery-gallery-sortable',
			$filterable_gallery_sortable 		= $( _filterable_gallery_sortable ), /** Where sortable is triggered*/
			filterable_gallery_item_class 	= 'filterable_gallery-gallery-item', /** This class will be using as prefix of all items */
			$filterable_gallery_item 			= $( '.' + filterable_gallery_item_class ), /** List of items in gallery */
			$filterable_gallery_item_total 	= $( '.gallery-count strong' );

		function __construct() {

			/** Triggered Grid */
			var grid = new Muuri( _filterable_gallery_sortable , {
				items: '.' + filterable_gallery_item_class,
				dragEnabled: true,
				dragSortPredicate: {
					threshold: 10,
					action: 'move'
				},
				layout: {
					rounding: false
				}
			});

			/** Update Sorting */
			function update_gallery_index() {
				var allItems = grid.getItems().reverse(),
					_itemNumber = 1;

				$filterable_gallery_item_total.text( allItems.length );

				for (var i = allItems.length - 1; i >= 0; i--) {
					var $el = $( allItems[i]['_element'] );

					$el.attr( 'data-item-index', _itemNumber );
					$el.find( 'input' ).attr( 'name', filterable_gallery_item_class + '-input[' + _itemNumber + ']' );

					_itemNumber++;
				}
			}

			/** Refresh Grid on Gallery Active */
			$( 'a[data-id=gallery]' ).on( 'click', function() {
				setTimeout( function() {
					grid.refreshItems().layout( true );
				}, 500 );
			} );

			/** Updating sorting using grid events */
			$window.on( 'load', function() {
				grid.refreshItems().layout( true );
			} );

			grid.on('layoutEnd', function (items) {
				update_gallery_index();
			} );

			grid.on('move', function (data) {
				update_gallery_index();
			});

			grid.on('add', function (items) {
				update_gallery_index();
				grid.refreshItems().layout( true );
			});

			grid.on('remove', function (items, indices) {
				update_gallery_index();
				grid.refreshItems().layout( true );
			});

			/** Add/Remove class when dragstart */
			grid.on('dragStart', function (item, event) {
				$filterable_gallery_sortable.addClass( 'item-draggin-start' );
			} );

			grid.on('dragEnd', function (item, event) {
				$filterable_gallery_sortable.removeClass( 'item-draggin-start' );
				grid.refreshItems().layout( true );
			} );

			/** Upload images */
			$body.on( 'click', '#upload-gallery-images', function() {
				var _item_count = $( '.filterable_gallery-gallery-item' ).length + 1;

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

							filters.uploaded = {
								text:  'Uploaded to this Page',
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
							/** If we are viewing all the items, only show media items not previously attached to other posts. */
							if ( 'all' == this.el.value ){
								this.filters[this.el.value].props.post_parent = '';
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
						title: 'Upload Gallery Images',
						filterable: 'uploaded',
						library: wp.media.query({ 
							type : 'image',
							uploadedTo: wp.media.view.settings.post.id
						}),
						multiple: true,
						contentUserSetting: true
					})
				]

				var uploade_frame = wp.media( {
					button: { text: 'Select Images' },
					state : 'library',
					states: controller_states,
					/** mutiple: true if you want to upload multiple files at once */
					multiple: true
				} )
				.open()
				.on( 'select', function(e){
					/** This will return the selected image from the Media Uploader, the result is an object */
					var uploaded_image  = uploade_frame.state().get( 'selection' ),
						attachments 	= [];

					/** Let's Join All the images selected */
					uploaded_image.map( function( attachment, i ) {
						attachment = attachment.toJSON();
						i = _item_count + i;

						var newNode = document.createElement('div');
						newNode.className = filterable_gallery_item_class;
						newNode.innerHTML = '<canvas width="150" height="150" style="background-image: url( ' + attachment.url + ');"></canvas>' +
								'<input type="hidden" name="' + filterable_gallery_item_class + '-input[' + i + ']" value="' + attachment.id + '">' +
								'<span class="' + filterable_gallery_item_class + '-remove">X</span><span class="filterable_gallery-gallery-item-edit-info"></span>';

						grid.add( newNode );
					} );

					grid.refreshItems().layout( true );

				} );
			} );

			/** Remove Item */
			$body.on( 'click', '.' + filterable_gallery_item_class + '-remove', function() {
				var i = $( this ).parent().attr( 'data-item-index' ) - 1;
				grid.remove(i, {removeElements: true});
			} );

			/** Edit Item */
			$body.on( 'click', '.filterable_gallery-gallery-item-edit-info', function() {
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

							filters.uploaded = {
								text:  'Uploaded to this Page',
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
							/** If we are viewing all the items, only show media items not previously attached to other posts. */
							if ( 'all' == this.el.value ){
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
						title: 'Edit Image',
						filterable: 'all',
						// library: wp.media.query({ 
						// 	type : 'image',
						// 	uploadedTo: wp.media.view.settings.post.id
						// }),
						multiple: false,
						contentUserSetting: true
					})
				]
				
				var frame,
					$this = $( this );

				if( frame ){
					frame.open();
					return;
				}

				frame = wp.media({
					state : 'library',
					states: controller_states,
					button: {
						text: 'Close'
					}
				});
			  

				frame.on('open', function(){
					var selection = frame.state().get( 'selection' ),
						selected = $this.parent().find( 'input' ).val();

						selection.add( selected ? [wp.media.attachment(selected)] : [] );
				});

				frame.open();
			} );
		}

		/** Instantiate */
		__construct();

	} );
} )( jQuery );