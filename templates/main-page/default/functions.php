<?php
/** Default Config */
use AIOS\Gallery\Classses\Options;

if ( !class_exists( 'aios_listings_main_page_template_default' ) ) {

	class aios_listings_main_page_template_default{

		/**
		 * Current file URL & DIR
		 *
		 * @access private
		 */
		private $active_template_url;
		private $active_template_dir;

		/**
		 * Constructor.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
			/**
			 * Custom - If files is under active theme
			 * $this->active_template_url = get_stylesheet_directory_uri() . '/listings-templates/main-page/default';
			 * $this->active_template_dir = get_stylesheet_directory() . '/listings-templates/main-page/default';
			 */
            $this->active_template_url = AIOS_FILTERABLE_URL . 'templates/main-page/default';
            $this->active_template_dir = AIOS_FILTERABLE_DIR . '/templates/main-page/default';

			$this->add_actions();
		}

		/**
		 * Add Actions.
		 *
		 * @access public
		 * @return void
		 */
		public function add_actions() {
			
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10);
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 11);
			add_filter( 'template_include', array( $this, 'custom_templates' ), 20 );

            add_action( 'wp_ajax_aios_medical_post_filter', array( $this, 'aios_medical_post_filter' ) );
			add_action( 'wp_ajax_nopriv_aios_medical_post_filter', array( $this, 'aios_medical_post_filter' ) );


		}

		/**
		 * Enqueue Scripts
		 *
		 * @access public
		 * @return void
		 */
		public function enqueue_scripts() {
            $gallery_settings = Options::Settings();
			if( !empty( $gallery_settings ) ) extract( $gallery_settings );
			if ( $main_page == get_the_ID() && get_the_ID() != 0 ) {

				wp_enqueue_script( 'aios-ionSlider-script', $this->active_template_url . '/assets/js/ion.rangeSlider.min.js', ['jQuery'] );
				wp_enqueue_script( 'aios-fileterable-gallery-main-page-template-default-script', $this->active_template_url . '/assets/js/scripts.js' );

			}

		}
		
		/**
		 * Enqueue Styles
		 *
		 * @access public
		 * @return void
		 */
		public function enqueue_styles() {
            $gallery_settings = Options::Settings();
			if( !empty( $gallery_settings ) ) extract( $gallery_settings );
			if ( $main_page == get_the_ID() && get_the_ID() != 0 ) {
				wp_enqueue_style( 'aios-ionSlider', $this->active_template_url . '/assets/css/ion.rangeSlider.min.css' );
				wp_enqueue_style( 'aios-fileterable-gallery-main-page-template-default-style', $this->active_template_url . '/assets/css/style.css' );

			}

		}

        /**
		 * Return Post Base on filter value
		 *
		 * @access public
		 * @param Ajax
		 * @return void
		 */

		public function aios_medical_post_filter(){


		    $data = $_POST['data'];

            parse_str($data, $params);


            $meta_query = array(
                'relation' => 'AND'
            );

            $tax_query = array(
                    'relation' => 'AND'
            );


            foreach ($params as $key => $param){


                if (!empty($param)){
                     if ($key != 'page' && $key != 'sorts'){
                    if ($param != 'Any' && $param != 'All' ){


                        if ($key == 'age'){
                            $ages = explode(",", $param);

                            // edited to accept cases with their Age set as 'Any'
                            $meta_query[] = array(
                                'relation' => 'OR',
                                array(
                                    'key'     => $key,
                                    'value'   => 'Any',
                                    'compare' => '='
                                ),
                                array(
                                    array(
                                        'key'     => $key,
                                        'value'   => $ages[0],
                                        'compare' => '>=',
                                        'type'    => 'NUMERIC',
                                    ),
                                    array(
                                        'key'     => $key,
                                        'value'   => $ages[1],
                                        'compare' => '<=',
                                        'type'    => 'NUMERIC',
                                   )
                                )
                            );

                        }else{
                            /// if query is procedure
                            if ($key == 'procedure') {

                                 $tax_query[] =  array(
                                    'taxonomy' => 'procedure',
                                    'field'    => 'slug',
                                    'terms'    => array($param),
                                );

                             }else{
                                // if query is not proceddure

                                // edited to accept cases with value set as 'Any'
                                $meta_query[] = array(
                                    'relation' => 'OR',
                                    array(
                                        'key'     => $key,
                                        'value'   => 'Any',
                                        'compare' => '='
                                    ),
                                    array(
                                        'key'=> $key,
                                        'compare'=>'=',
                                        'value'=> $param
                                    )
                                );
                            }
                        }
                    }
                }

                }

            }
            //what pagination page are we on?
            if(! empty($params['page']) && is_numeric($params['page']) ){
                $paged = $params['page'];
            }else{
                $paged = 1;
            }

            $post_type = 'cases';
            $posts_per_page = (get_option('posts_per_page')) ? get_option('posts_per_page') : 2;

            $CountArgs  = array(
                'post_type' => $post_type,
                'posts_per_page' => -1,
                'paged'        => $paged,
                'post_status' => 'publish',
                'meta_query'    => $meta_query,
                'tax_query'     => $tax_query,

            );

            $all_posts = get_posts($CountArgs);

            $post_count = count($all_posts);
            $num_pages = ceil($post_count / $posts_per_page);


            // args
            $args = array(
                'post_type' => $post_type,
                'posts_per_page' => $posts_per_page,
                 'paged'        => $paged,
                'meta_query'    => $meta_query,
                'tax_query'     => $tax_query,
                'orderby'          => 'date',
                'post_status' => 'publish',
                'order'            => $params['sorts'],
            );


            // query
            $the_query = new WP_Query( $args );


            $html = '';

            if(!empty($the_query->posts)){


                 foreach ( $the_query->posts as $value){

                $post_id = $value->ID;
                $permalink = get_permalink($post_id);
                $case_number = get_field( 'case_number', $post_id );
                $gender = get_field( 'gender', $post_id);
                $age = get_field( 'age', $post_id);
                $ethnicity = get_field( 'ethnicity', $post_id);


                $procedures = wp_get_post_terms( $post_id, 'procedure',  array( 'orderby' => 'title', 'order' => 'ASC' ) );

                $args = array(
                    'numberposts' => -1,
                    'post_type'   => 'acf-field-group'
                );

                $group_fields = get_posts( $args );


                $html .= '<div class="col-md-4 aios-gallery-list">';
                    $html .= '<div class="aios-gallery-wrap">';

                        $html .= '<div class="aios-gallery-list-wrap">';



                         foreach ($procedures as $key =>$procedure) {

                              if ($procedure->parent != 0) {

                                  foreach ($group_fields as $group_field){
                                    if ($procedure->name  == $group_field->post_title) {
                                        $fieldGroup = acf_get_field_group($group_field->ID);
                                        $fields = acf_get_fields_by_id($group_field->ID);

                                        foreach ($fields as $field) {

                                            if ($field['label'] == 'Add Photos') {
                                                $imgGallery = get_field($field['name'], $post_id);
                                                $imgBefore  =  $imgGallery[0]['before']['ID'];
                                                $imgAfter   = $imgGallery[0]['after']['ID'];


                                                    $html .= '<div class="aios-gallery-image">';
                                                        if (empty($imgAfter)){
                                                            $html .= '<canvas width="442" height="329" style="background-image: url('.wp_get_attachment_url($imgBefore).')"></canvas>';
                                                        }elseif(empty($imgBefore)){
                                                              $html .= '<canvas width="442" height="329" style="background-image: url('.wp_get_attachment_url($imgAfter).')"></canvas>';
                                                        }
                                                        if (!empty($imgBefore) && !empty($imgAfter)){
                                                            $html .= '   <div class="ba-wrap">
                                                                            <h2 class="hidden">Before and After</h2>
                                                                            
                                                                            <div class="ba-slider-wrap">
                                                                                <div class="ba-slider">
                                                                                    <div class="ba-col before">
                                                                                        <div class="ba-item">
                                                                                            <div class="global-lines ba-lines">
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                            </div>
                                                                                            <div class="ba-img">
                                                                                            <canvas width="442" height="329" style="background-image: url('.wp_get_attachment_url($imgBefore).')"></canvas>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="ba-col after">
                                                                                        <div class="ba-item">
                                                                                            <div class="global-lines ba-lines">
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                            </div>
                                                                                            <div class="ba-img">
                                                                                                <canvas width="442" height="329" style="background-image: url('.wp_get_attachment_url($imgAfter).')"></canvas>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="ba-range">
                                                                                    <input type="range" name="ba-range" min="0" max="100" value="50" aria-label="Before and After Handler">
                                                                                </div>
                                                                                <div class="ba-handler">
                                                                                    <span></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>';
                                                        }
                                                    $html .='</div>';

                                            }
                                        }
                                    }
                                  }
                              }
                         }


                        $html .=  '</div>';
                        $html .='<div class="aios-gallery-content">';
                            $html .= '<a href="'.$permalink.'">';
                                 $html .= '<span>CASE NO: <strong> '.$case_number.' </strong></span>';
                                 $html .= '<div class="aios-procedures-names">';

                                     foreach ($procedures as $key => $procedure ){

                                         if ($procedure->parent != 0) {
                                             $html .= '<span>' . $procedure->name .'</span>';
                                         }
                                     }
                                 $html .= '</div>';
                                 $html .= '<ul>';
                                     $html .='<li><strong>GENDER:</strong> '. $gender .'</li>';
                                     $html .='<li><strong>AGE:</strong> '. $age .'</li>';
                                     $html .='<li><strong>ETHNICITY:</strong> '. $ethnicity .'</li>';
                                 $html .= '</ul>';
                           $html .= '</a>';
                        $html .= '</div>';
                    $html .= '</div>';

                $html .= '</div>';


            }
            }else{
                $html .= '<div class="gallery-no-posts">no Case found</div>';
            }



            if ($num_pages != 0 ){
                $html .= ' <div class="clear"></div><div class="aios-gallery-pagination">
                <div class="aios-gallery-pagination-prev aios-gallery-pagination-arrows"><i class="ai-font-arrow-b-p"></i></div>
                <div class="pagination-info">
                      <div class="aios-gallery-numbers">'.$paged.'</div>
                      <div class="aios-gallery-seprator">of</div>
                      <div class="aios-gallery-final-count" data-num="'.$num_pages.'">'.$num_pages.'</div>
                </div>
                <div class="aios-gallery-pagination-next aios-gallery-pagination-arrows"><i class="ai-font-arrow-b-n"></i></div></div>';
            }

            echo $html;
            die;



        }

		/**
		 * Custom Template
		 *
		 * @access public
		 * @param $template - file
		 * @return void
		 */
		public function custom_templates( $template ) {
            $gallery_settings = Options::Settings();
			if( !empty( $gallery_settings ) ) extract( $gallery_settings );


			if (  $main_page == get_the_ID() && get_the_ID() != 0 ) {
				$template = $this->active_template_dir . '/template.php';
			}

			return $template;
		}

	}

    $aios_listings_main_page_template_default = new aios_listings_main_page_template_default();

}
