<?php
/** Constant value */
namespace AIOS\Gallery\Classses;

class Constant {

    /**
     * List of State.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function states(){
        return array(
            'United States' => array(
                'Alabama' 				=> 'AL',
                'Alaska' 				=> 'AK',
                'Arizona' 				=> 'AZ',
                'Arkansas' 				=> 'AR',
                'California' 			=> 'CA',
                'Colorado' 				=> 'CO',
                'Connecticut' 			=> 'CT',
                'Delaware' 				=> 'DE',
                'District of Columbia' 	=> 'DC',
                'Florida' 				=> 'FL',
                'Georgia' 				=> 'GA',
                'Hawaii' 				=> 'HI',
                'Idaho' 				=> 'ID',
                'Illinois' 				=> 'IL',
                'Indiana' 				=> 'IN',
                'Iowa' 					=> 'IA',
                'Kansas' 				=> 'KS',
                'Kentucky' 				=> 'KY',
                'Louisiana' 			=> 'LA',
                'Maine' 				=> 'ME',
                'Maryland' 				=> 'MD',
                'Massachusetts' 		=> 'MA',
                'Michigan' 				=> 'MI',
                'Minnesota' 			=> 'MN',
                'Mississippi' 			=> 'MS',
                'Missouri' 				=> 'MO',
                'Montana' 				=> 'MT',
                'Nebraska' 				=> 'NE',
                'Nevada' 				=> 'NV',
                'New Hampshire' 		=> 'NH',
                'New Jersey' 			=> 'NJ',
                'New Mexico' 			=> 'NM',
                'New York' 				=> 'NY',
                'North Carolina' 		=> 'NC',
                'North Dakota' 			=> 'ND',
                'Ohio' 					=> 'OH',
                'Oklahoma' 				=> 'OK',
                'Oregon' 				=> 'OR',
                'Pennsylvania' 			=> 'PA',
                'Rhode Island' 			=> 'RI',
                'South Carolina' 		=> 'SC',
                'South Dakota' 			=> 'SD',
                'Tennessee' 			=> 'TN',
                'Texas' 				=> 'TX',
                'Utah' 					=> 'UT',
                'Vermont' 				=> 'VT',
                'Virginia' 				=> 'VA',
                'Washington' 			=> 'WA',
                'West Virginia' 		=> 'WV',
                'Wisconsin' 			=> 'WI',
                'Wyoming' 				=> 'WY'
            ),
            'Australia' => array(
                'New South Wales' 		=> 'NSW',
                'Queensland' 			=> 'Qld',
                'South Australia' 		=> 'SA',
                'Tasmania' 				=> 'Tas',
                'Victoria' 				=> 'Vic',
                'Western Australia' 	=> 'WA'
            )
        );
    }

    /**
     * Architectural Styles.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function architectural_styles(){
        return array(
            '--' 						=> '--',
            'Adobe Revival' 			=> 'Adobe Revival',
            'Beach' 					=> 'Beach',
            'Bungalow' 					=> 'Bungalow',
            'Cape Cod' 					=> 'Cape Cod',
            'Colonial' 					=> 'Colonial',
            'Contemporary' 				=> 'Contemporary',
            'Contemporary Craftsman' 	=> 'Contemporary Craftsman',
            'Country' 					=> 'Country',
            'Craftsman' 				=> 'Craftsman',
            'English Cottage' 			=> 'English Cottage',
            'Farmhouse' 				=> 'Farmhouse',
            'Federal Colonial' 			=> 'Federal Colonial',
            'Florida' 					=> 'Florida',
            'French' 					=> 'French',
            'Georgian' 					=> 'Georgian',
            'Greek Revival' 			=> 'Greek Revival',
            'Log / Chalet' 				=> 'Log / Chalet',
            'Mediterranean' 			=> 'Mediterranean',
            'Mid-Century Modern' 		=> 'Mid-Century Modern',
            'Modern' 					=> 'Modern',
            'Mountain' 					=> 'Mountain',
            'Northwest' 				=> 'Northwest',
            'Prairie' 					=> 'Prairie',
            'Ranch' 					=> 'Ranch',
            'Shingle' 					=> 'Shingle',
            'Spanish' 					=> 'Spanish',
            'Southern' 					=> 'Southern',
            'Southwest' 				=> 'Southwest',
            'Traditional' 				=> 'Traditional',
            'Tudor' 					=> 'Tudor',
            'Tuscan' 					=> 'Tuscan',
            'Victorian' 				=> 'Victorian'
        );
    }

    /**
     * List of Currency.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function currency(){
        return array( 
            'Dollar'			=> '$',
            'Australian Dollar'	=> 'A$',
            'Pound'				=> '£',
            'Yen'				=> '¥',
            'Euro'				=> '€',
            'Lira'				=> '₤'
        );
    }

    /**
     * List of Currency in ISO-4217.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function currency_code(){
        return array( 
            'Dollar'			=> 'USD',
            'Australian Dollar'	=> 'AUD',
            'Pound'				=> 'GBP',
            'Yen'				=> 'JPY',
            'Euro'				=> 'EUR',
            'Lira'				=> 'TRY'
        );
    }

    /**
     * Number of Bed Rooms.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function bedrooms(){
        $arr= [];
        $max = 25;
        for ($i=0; $i < $max + 1; $i++) { 
            $arr[$i] = $i;
        }
        return $arr;
    }

    /**
     * Number of Bath Rooms.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function bathrooms(){
        $arr = [];
        $max = 25;
        for ($i=0; $i < $max + 1; $i++) { 
            $arr[$i] = $i;
            $arr[$i . '.5'] = $i . '.5';
        }
        return $arr;
    }

    /**
     * Number of Garage Spaces.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function garage_spaces() {
        $arr = [];
        $max = 25;
        for ($i=0; $i < $max + 1; $i++) { 
            $arr[$i] = $i;
        }
        return $arr;
    }

    /**
     * List of unit measurement.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function units( ){
        return array(
                'acres' 	=> 'acres',
                'sq. ft' 	=> 'sq. ft.',
                'sq. m.' 	=> 'sq. m.',
                'hectares' 	=> 'hectares',
            );
    }
    
    /**
     * List of Property Type.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function property_type(){
        return array( 
            'Commercial',
            'Condo/coop',
            'Investment',
            'Land',
            'Mobile/manufactured',
            'Residential',
            'Single Family',
            'Townhouse',
            'Vacation'
        );
    }

    /**
     * List of Property Status.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function property_status(){
        /** 'Expired', 'For Lease', 'For Rent', 'For Sale', 'In Escrow', 'Leased', 'Open House', 'Pending', 'Sold', 'Withdrawn' */
        return array( 
            'For Lease',
            'For Sale',
            'Open House',
            'Sold',
        );
    }

    /**
     * List of Property Features.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function property_features(){
        return array( 
            'Basement',
            'Central Air Conditioning',
            'Fireplace',
            'Garage',
            'Pool',
            'Water Front'
        );
    }

    /**
     * List of orderby.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function sorting(){
        return array( 
            'price' 	=> 'Price',
            'featured' 	=> 'Featured',
            'date' 		=> 'Most Recent',
            'type' 		=> 'Property Type',
            'status'	=> 'Property Status',
            'title' 	=> 'A-Z',
        );
    }

    /**
     * List of order.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function ascdesc(){
        return array( 
            'asc'	=> 'Ascending',
            'desc'	=> 'Descending'
        );
    }

    /**
     * Default Price.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function price(){
        return array( 10000 => '10,000' );
    }

    /**
     * List of Google Map Type.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function google_map_type() {
        return array(
            '1' => 'Roadmap',
            '2' => 'Satellite',
            '3' => 'Hybrid',
            '4' => 'Terrain',
            '5' => 'Street View'
        );
    }

    /**
     * List of Google Map Zoom.
     *
     * @since 1.0.0
     *
     * @access public
     * @return array
     */
    public static function google_map_zoom( ){
        return array(
            '0' 	=> '0',
            '1' 	=> '1',
            '2' 	=> '2',
            '3' 	=> '3',
            '4' 	=> '4',
            '5' 	=> '5',
            '6' 	=> '6',
            '7' 	=> '7',
            '8' 	=> '8',
            '9' 	=> '9',
            '10' 	=> '10',
            '11' 	=> '11',
            '12' 	=> '12',
            '13' 	=> '13',
            '14' 	=> '14',
            '15' 	=> '15',
            '16' 	=> '16',
            '17' 	=> '17',
            '18' 	=> '18',
            '19' 	=> '19',
            '20' 	=> '20'
        );
	}
	
	

	/**
	 * This will output responsive images with srcset and sizes
	 * 
	 * Sizes:
	 * 	- Medium resolution (default 400px x 400px max)
	 * 	- Medium Large resolution (default 768 x 768 max)
	 * 	- Large resolution (default 1024px x 1024px max)
	 * 	- Full resolution (original size uploaded) this will be fallback if width is greater input viewport size
	 * 
	 * 
	 * @return string
	 */
	public static function responsive_canvas( $args ) {
		$defaults = array(
			'id'		=> '', /** Image ID . Default: empty(required) */
			'width' 	=> '1600',
			'height' 	=> '829',
			'sizes'		=> '', /** Sizes separated by commas(viewport is required). Default: medium,medium_large,large,full. Default: 400,768,1024 */
			'viewport' 	=> '', /** Width of monitor where to change the image sizez separated by commas(viewport is required). Default: 400,768,1024 */
			'class' 	=> '', /** Class attribute for img element. Default: img-responsive */
			'lazyload' 	=> false
		);
		
		$args = wp_parse_args( $args, $defaults );

		/** let's extract shortcode attributes */
		extract( $args );

		/** Check if ID is not empty and int */
		if ( empty( $id ) ) return 'ID must not be a non-empty string.';
		if ( ! is_numeric( $id ) ) return 'ID must be numeric.';

		/** Let's match the sizes and viewport */
		$sizes = explode( ',', 'medium,medium_large,large' . ( ! empty( $sizes ) ? ',' . $sizes : '' ) );
		$viewport = explode( ',', '400,768,1024' . ( ! empty( $viewport ) ? ',' . $viewport : '' ) );
		if ( count( $sizes ) != count( $viewport ) ) return 'Sizes and viewport must be equal separated by comma.';

		/** Check given id if exists */
		$image = wp_get_attachment_image_src( $id, 'full' );

		/** Enable lazyload */
		if ( $lazyload ) $class = empty( $class ) ? $class : 'lazyload ' . $class;
		
		if ( $image ) {
			$images_srcs = array();
			$count = 0;
			foreach ( $sizes as $size ) {
				$image_src = wp_get_attachment_image_src( $id, $size );
				$images_srcs[] = $image_src[0] . ' '. $viewport[$count] .'w';
				$count++;
			}
			$image_set = implode( ',', array_reverse( $images_srcs ) );
			
			$output = '<canvas width="' . $width . '" height="' . $height . '" class="responsive-background-image ' . $class . '"  data-bg-src="' . $image[0] . '" data-bg-srcset="' . $image_set . '"></canvas>';

			return $output;
		}

		return 'ID is not an image attachment.';
	}

	/**
	 * This will output an array that contains reponsive set
	 * 
	 * Sizes:
	 * 	- Medium resolution (default 400px x 400px max)
	 * 	- Medium Large resolution (default 768 x 768 max)
	 * 	- Large resolution (default 1024px x 1024px max)
	 * 	- Full resolution (original size uploaded) this will be fallback if width is greater input viewport size
	 * 
	 * 
	 * @return array
	 */

	public static function reponsive_srcset( $args ) {
		$defaults = array(
			'id'		=> '', /** Image ID . Default: empty(required) */
			'sizes'		=> '', /** Sizes separated by commas(viewport is required). Default: medium,medium_large,large,full. Default: 400,768,1024 */
			'viewport' 	=> '', /** Width of monitor where to change the image sizez separated by commas(viewport is required). Default: 400,768,1024 */
		);
		
		$args = wp_parse_args( $args, $defaults );

		/** let's extract shortcode attributes */
		extract( $args );

		/** Check if ID is not empty and int */
		if ( empty( $id ) ) return 'ID must not be a non-empty string.';
		if ( ! is_numeric( $id ) ) return 'ID must be numeric.';

		/** Let's match the sizes and viewport */
		$sizes = explode( ',', 'medium,medium_large,large' . ( ! empty( $sizes ) ? ',' . $sizes : '' ) );
		$viewport = explode( ',', '320,768,1024' . ( ! empty( $viewport ) ? ',' . $viewport : '' ) );
		if ( count( $sizes ) != count( $viewport ) ) return 'Sizes and viewport must be equal separated by comma.';

		/** Check given id if exists */
		$image = wp_get_attachment_image_src( $id, 'full' );
		
		if ( $image ) {
			$images_srcs = array();
			$count = 0;
			
			foreach ( $sizes as $size ) {
				$image_src = wp_get_attachment_image_src( $id, $size );
				$images_srcs[] = $image_src[0] . ' '. $viewport[$count] .'w';
				$count++;
			}
			$image_set = implode( ',', array_reverse( $images_srcs ) );

			return [
				'src' => $image[0],
				'srcset' => $image_set
			];
		}

		return 'ID is not an image attachment.';
	}

}