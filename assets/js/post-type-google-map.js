( function($) {
	$( document ).ready( function() {

		var $address 				= $( '#address_street_number, #address_street_name, #address_unit_number, #address_city, #address_state, #address_zip_code' )
			$address_street_number 	= $( '#address_street_number' ), 
			$address_street_name 	= $( '#address_street_name' ), 
			$address_unit_number 	= $( '#address_unit_number' ), 
			$address_city 			= $( '#address_city' ), 
			$address_state 			= $( '#address_state' ), 
			$address_zip_code 		= $( '#address_zip_code' ),
			$map_latitude 			= $( '#map_latitude' ),
			$map_longitude 			= $( '#map_longitude' ),
			$map_address 			= $( '#map-address span' ),
			geocoder 				= (typeof google === 'object' && typeof google.maps === 'object') ? new google.maps.Geocoder() : undefined;

		function __construct() {
			listing_map();
		}

		/** Get long and lat of address **/
		function listing_map() {
			var $map = $( '#map-canvas' );

			if ( $map.length > 0 ) {

				/** Check if lat and long have value else point to agentimage location **/
				if ( $map_latitude.val() == '' && $map_longitude.val() == '' ) {
					listing_map_search_by_address( '1700 E Walnut Ave suite 400, El Segundo, CA 90245, USA' );
				} else {
					listing_map_search_by_latlng( $map_latitude.val(), $map_longitude.val() );
				}

				$type_timeout = null;

				$address.on( 'input', function() {
					clearTimeout( $type_timeout );

					$type_timeout = setTimeout( function() {
						var _address_street_number 	= $address_street_number.val() != '' ? $address_street_number.val() + ' ' : '';
							_address_street_name 	= $address_street_name.val() != '' ? $address_street_name.val() + ' ' : '';
							_address_unit_number 	= $address_unit_number.val() != '' ? $address_unit_number.val() + ' ' : '';
							_address_city 			= $address_city.val() != '' ? $address_city.val() + ' ' : '';
							_address_state 			= $address_state.val() != '--' ? $address_state.val() + ' ' : '';
							_address_zip_code 		= $address_zip_code.val();

						listing_map_search_by_address( _address_street_number + _address_street_name + _address_unit_number + _address_city + _address_state + _address_zip_code );
					}, 1500 );
				} );

			}
		}
			/** Get latlng by Address **/
			function listing_map_search_by_address( address ){
				var target 		= 'map-canvas',
					lat_lng 	= '';

                /** Don't run if google.maps is undefined */
                if( geocoder === undefined ) {
                    $( '#' + target ).before( '<p>Google Maps API Key is NEEDED!</p>' ).remove();
                    return;
                }

				geocoder.geocode( 
					{ "address": address }, 
					function( results, status ) {
						if ( status == google.maps.GeocoderStatus.OK ) {
							var sel_map_type = google.maps.MapTypeId.ROADMAP;

							lat = results[0].geometry.location.lat();
							lng = results[0].geometry.location.lng();
							lat_lng = new google.maps.LatLng( lat, lng );

							/** parsed = placeParser(results[0]); $address_zip_code.val( parsed.postal_code ); **/
							$map_address.text( results[0].formatted_address );
							$map_latitude.val( lat );
							$map_longitude.val( lng );

							map_options = {
								zoom: 17,
								center: lat_lng,
								mapTypeId: sel_map_type
							}

							map = new google.maps.Map( document.getElementById( target ), map_options );

							/** normal map **/
							marker = new google.maps.Marker({
								position: lat_lng,
								map: map,
								title: address,
								draggable: true
							});

							infowindow = new google.maps.InfoWindow({
								content: address
							});

							google.maps.event.addListener(marker, "click", function() {
								infowindow.open( map, marker );
							});

							google.maps.event.addListener(
								marker,
								'dragend',
								function(event) {
									map_auto_populate();
								}
							);

						} else {
							console.log("Geocode was not successful for the following reason: " + status);
						}
					}
				);
			}
				/** Point marker on ready by latlng **/
				function listing_map_search_by_latlng( latitude, longitude ){
					var target 					= 'map-canvas',
						lat_lng 				= new google.maps.LatLng( latitude, longitude ),
						sel_map_type 			= google.maps.MapTypeId.ROADMAP,
						_address_street_number 	= $address_street_number.val() != '' ? $address_street_number.val() + ' ' : '';
						_address_street_name 	= $address_street_name.val() != '' ? $address_street_name.val() + ' ' : '';
						_address_unit_number 	= $address_unit_number.val() != '' ? $address_unit_number.val() + ' ' : '';
						_address_city 			= $address_city.val() != '' ? $address_city.val() + ' ' : '';
						_address_state 			= $address_state.val() != '--' ? $address_state.val() + ' ' : '';
						_address_zip_code 		= $address_zip_code.val(),
						address 				= _address_street_number + _address_street_name + _address_unit_number + _address_city + _address_state + _address_zip_code;

					map = new google.maps.Map( document.getElementById( target ), {
						zoom: 17,
						center: lat_lng,
						mapTypeId: sel_map_type
					} );

					marker = new google.maps.Marker({
						position: lat_lng,
						map: map,
						title: address,
						draggable: true
					});

					infowindow = new google.maps.InfoWindow({
						content: address
					});

					google.maps.event.addListener(marker, "click", function() {
						infowindow.open( map, marker );
					});

					google.maps.event.addListener(
						marker,
						'dragend',
						function(event) {
							map_auto_populate();
						}
					);

					/** Check if it loaded successfully **/
					if (typeof google === 'object' && typeof google.maps === 'object') {
						map_auto_populate();
					}
				}
				function map_auto_populate( arg ) {
					geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							if (results[0]) {
								/** Parse Places **/
								parsed = placeParser( results[0]) ;

								/** Insert suggested address by google and add postal code in input **/
								$map_address.text( results[0].formatted_address );
								/** if ( arg != 'onload' ) $address_zip_code.val( parsed.postal_code ); **/

								/** Insert long and lat in input **/
								$map_latitude.val( results[0].geometry.location.lat() );
								$map_longitude.val( results[0].geometry.location.lng() );

								/** This will display on popup marker**/
								infowindow.setContent( results[0].formatted_address );
								/** infowindow.open(map, marker); **/
							}
						}
					});
				}
					function placeParser( place ){
						result = {};
						for(var i = 0; i < place.address_components.length; i++){
							ac = place.address_components[i];
							result[ac.types[0]] = ac.long_name;
						}
						return result;
                    };
                    
		/** Instantiate **/
		__construct();

	} );
} )( jQuery );