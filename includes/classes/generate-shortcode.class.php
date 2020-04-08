<?php
use AIOS\Gallery\Classses\Constant;

if ( !class_exists( 'aios_filterable_generate_shortcode' ) ) {

	class aios_filterable_generate_shortcode {

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			$this->add_actions();
		}

		/**
		 * Add Actions.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @return void
		 */
		protected function add_actions() {
		    
                add_action( 'add_meta_boxes',  array( $this, 'wpdocs_register_meta_boxes') );
                add_action( 'save_post', array( $this, 'wpdocs_save_meta_box' ) );

		}

        /**
         * Register meta box(es).
         */
        function wpdocs_register_meta_boxes() {
            add_meta_box( 'meta-box-id', __( 'Filterable Gallery', 'textdomain' ), array( $this, 'wpdocs_my_display_callback'), 'post', 'side', 'high');
            add_meta_box( 'meta-box-id', __( 'Filterable Gallery', 'textdomain' ), array( $this, 'wpdocs_my_display_callback'), 'page', 'side', 'high');
        }
        /**
         * Meta box display callback.
         *
         * @param WP_Post $post Current post object.
         */
        function wpdocs_my_display_callback( $post ) {

            $html = '';

            $filterable_group_id = '';
            $args = array(
              'numberposts' => 10,
              'post_type'   => 'acf-field-group'
            );

            $group_fields = get_posts( $args );

           foreach ($group_fields as $group_field){

               if ($group_field->post_title == 'Filterable Gallery'){
                    $filterable_group_id .= $group_field->ID;
               }
           }

            if(function_exists('acf_get_field_groups')) {
                $fieldGroup = acf_get_field_group($filterable_group_id);
                $fields = acf_get_fields_by_id($filterable_group_id);

                $html .= '<div class="filterable-shortcode-wrap">';
                foreach ($fields as $field){

                    if ( $field['name'] == 'procedure_types'){

                        $html .= ' <div class="form-group"> <label for="procedure">Procedure</label>
                                <br><select name="" id="procedure"><option value="">...</option>';

                        foreach ($field['choices'] as $choice){

                            $html .= '<option value="'.$choice.'">'.$choice.'</option>';
                        }
                        $html .= '   </select>
                                </div>';
                    }
                    if ( $field['name'] == 'gender'){

                        $html .= ' <div class="form-group"> <label for="procedure">Gender</label>
                                <br><select name="" id="gender"><option value="">...</option>';

                        foreach ($field['choices'] as $choice){

                            $html .= '<option value="'.$choice.'">'.$choice.'</option>';
                        }
                        $html .= '   </select>
                                </div>';
                    }

                }
               $html .= '<div class="form-group"><label for="order-by">Order By</label>
                        <br><select name="" id="order-by">
                                <option value="">...</option>
                                <option value="date">Date</option>
                                <option value="title">title </option>
                                <option value="name">name </option>
                        </select>';
                $html .= '</div>';
                $html .= '<div class="form-group"><label for="sort">Sort</label>
                        <br><select name="" id="sort">
                                <option value="">...</option>
                                <option value="ASC">ascending </option>
                                <option value="DESC">descending </option>
                        </select>';
                $html .= '</div>';
                $html .= '<div class="form-group"><label for="showposts">Post Per Page</label><br>
                            <input type="number" placeholder="6" id="showposts">';
                $html .= '</div>';

                $html .= ' </div>';
            }

            $html .= '<div class="metabox-row">
                <div class="btn-holder">
                    <a style="width: 100%; text-align: center;" href="javascript:;" class="gal-generate-btn button">Generate Shortcode</a>
                </div>
            </div>';

            echo  $html;

        }

        /**
         * Save meta box content.
         *
         * @param int $post_id Post ID
         */
        function wpdocs_save_meta_box( $post_id ) {
            // Save logic goes here. Don't forget to include nonce checks!
        }

	}

	$aios_filterable_generate_shortcode = new aios_filterable_generate_shortcode();

}






