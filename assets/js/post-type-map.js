( function( $ ) {

    /** Generate the observer */
    var observer = new MutationObserver(function(mutations){
        mutations.forEach(function(mutation){
            mapInitialize(mutation);
        });
    });
        
    /** Start observing: */
    var detailsTab = document.querySelector('a[data-child-id=details]');
    observer.observe(
        detailsTab, {
            attributes: true, /** attribute changes will be observed | on add/remove/change attributes */
            attributeOldValue: true, /** will show oldValue of attribute | on add/remove/change attributes | default: null */
            
            characterData: true, /** data changes will be observed | on add/remove/change characterData */
            characterDataOldValue: true, /** will show OldValue of characterData | on add/remove/change characterData | default: null */
            
            childList: true, /** target childs will be observed | on add/remove */
            subtree: true, /** target childs will be observed | on attributes/characterData changes if they observed on target */
            
            attributeFilter: ['class'] /** filter for attributes | array of attributes that should be observed, in this case only style */
        }
    );
    
    /** Create function to trigger map */
    function mapInitialize( mutation ) {

        if( mutation['target'].innerHTML == 'Details' && mutation['target'].className === 'active-child-panel' ) {
            /** Stop listening to mutation */    
            observer.disconnect();

            /** Get elements */
            var $searchAddress          = $( '#searchAddress' )
                $address 				= $( '#address_street_number, #address_street_name, #address_unit_number, #address_city, #address_state, #address_zip_code' )
			    $address_street_number 	= $( '#address_street_number' ), 
			    $address_street_name 	= $( '#address_street_name' ), 
			    $address_unit_number 	= $( '#address_unit_number' ), 
			    $address_city 			= $( '#address_city' ), 
			    $address_state 			= $( '#address_state' ), 
                $address_zip_code 		= $( '#address_zip_code' ),
                $maplat                 = $( '#map_latitude' ),
                _maplat                 = $maplat.val(),
                $maplon                 = $( '#map_longitude' ),
                _maplon                 = $maplon.val();

            /** Create default coordinates */
            var coor = ( _maplat == '' && _maplon == '' ? [ 33.92878, -118.39778 ] : [ _maplat, _maplon ] ); /** default: [ 33.92878, -118.39778 ] */

            /** Initialize Map */
			var mapid = L.map( 'mapidleaflet' ).setView( coor, 17 );
			
			/** Create an icon */
			var mapIcon = L.icon({
				iconUrl: 'https://resources.agentimage.com/libraries/images/map-marker/52.png',
				// shadowUrl: 'leaf-shadow.png',

				iconSize:     [52, 52], // size of the icon
				// shadowSize:   [50, 64], // size of the shadow
				// iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
				// shadowAnchor: [4, 62],  // the same for the shadow
				// popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
			});

            /** Create marker */
            var marker = L.marker( coor, { 
				icon: mapIcon,
                draggable: true, 
                riseOnHover:true, 
                riseOffset: 500 
            } ).addTo( mapid );
            
            /** Marker eventlister */
            marker.on("dragend",function(e){
                $latLng = e.target.getLatLng();

                /** Change coordinate when drag ends */
                $maplat.val( $latLng['lat'] );
                $maplon.val( $latLng['lng'] );
            });

            /** Add map data */
            // L.tileLayer(
            //     'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
            //     {
			// 		attribution: `Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, 
			// 						<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>`
            //     }
			// ).addTo(mapid);
			L.mapboxGL({
				attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a>',
				accessToken: 'not-needed',
				style: 'https://api.maptiler.com/maps/streets/style.json?key=3i8dcrACEAmtPrc6lzeW'
			}).addTo(mapid);

            /** Search Address */
            $searchAddress.on( 'click', function(e) {
                e.preventDefault(); 

                /** Add text when searching */
                $('#results').empty();
                $('<p>', { html: "Searching results..." }).appendTo('#results');

                var _address_street_number 	= $address_street_number.val() != '' ? $address_street_number.val() + ', ' : '';
                    _address_street_name 	= $address_street_name.val() != '' ? $address_street_name.val() + ', ' : '';
                    _address_city 			= $address_city.val() != '' ? $address_city.val() + ', ' : '';
                    _address_state 			= $address_state.val() != '--' ? $address_state.find( 'option:selected' ).attr( 'data-description' ) + ' ' : '';
                    _address_zip_code 		= $address_zip_code.val();

                searchMapByAddress( _address_street_number + _address_street_name + _address_city + _address_state );
            } );

            /** Listen to clicked suggested address */
            $( document ).on( 'click', 'a.osm-result', function( e ) {
                e.preventDefault();

                var lat = $( this ).attr( 'lat' ), 
                    lng = $( this ).attr( 'lng' );

                mapid.setView( [lat, lng], 17 );
                marker.setLatLng( [lat, lng] ).update();
                $maplat.val( lat );
                $maplon.val( lng );
            } );
        }

    }

    /** Get suggested addresses that can be found in OSM */
    function searchMapByAddress( faddress ) {

        $.getJSON( 'https://nominatim.openstreetmap.org/search?format=jsonv2&limit=10&addressdetails=1&q=' + faddress, function(data) {
            var items = [];

            $.each(data, function(key, val) {
                items.push( `<li><a href="#" class="osm-result" lat="${val.lat}" lng="${val.lon}" osm_type="${val.osm_type}">${val.display_name}</a></li>` );
            });

            $('#results').empty();
            if (items.length != 0) {
                $('<p>', { html: "Select search results:" }).appendTo('#results');
                $('<ul/>', {
                    'class': 'results-lists',
                    html: items.join('')
                }).appendTo('#results');
            } else {
                $('<p>', { html: "No results found" }).appendTo('#results');
            }
        });
        
    }

} )(jQuery);