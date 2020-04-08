<?php
use AIOS\Gallery\Classses\Constant;

if ( !class_exists( 'aios_filterable_gallery_shortcodes' ) ) {

	class aios_filterable_gallery_shortcodes {

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

			if ( !shortcode_exists('aios_filterable_gallery') ) add_shortcode( 'aios_filterable_gallery', array( $this, 'get_aios_filterable_gallery' ) );


		}




		/**
		 * Display All Listings
		 *
		 * @since 3.1.8
		 * @access public
		 * @return string
		 */
		public function get_aios_filterable_gallery( $atts ) {


            extract( shortcode_atts( array(
                'post__in' 		=> '',
                'showposts' 	=> 6,
                'order' 		=> 'DESC',
                'orderby' 		=> 'date',
                'procedure'     => '',
                'gender'        => ''
            /** List of Search **/
            ), $atts ) );



            $page_id = get_queried_object_id();
            $params = $_GET;


            $html = '';
            $html .= '<script>jQuery(document).ready(function() { initComparisons(); })</script>';
            $html .= '<div class="aios-gallery-container">';
                $html .= '<div class="container container-wide">';
                    $html .= ' <div class="aios-gallery-lists">';
                        $html .='<div class="row">';

                            $meta_query = array(
                                'relation' => 'AND'
                            );


                            if (!empty($atts['procedure'])){
                                $meta_query[] = array(
                                    'key'=> 'procedure_types',
                                    'compare'=>'=',
                                    'value'=> $atts['procedure']
                                );

                            if (!empty($atts['gender'])){
                                $meta_query[] = array(
                                    'key'=> 'gender',
                                    'compare'=>'=',
                                    'value'=> $atts['gender']
                                );
                            }




                            //what pagination page are we on?
                            if(! empty($params['pages']) && is_numeric($params['pages']) ){
                                $paged = $params['pages'];
                            }else{
                                $paged = 1;
                            }
                            $post_type = 'gallery';
                            $posts_per_page = ($atts['showposts'] != '' ? $atts['showposts'] : 6);

                            $CountArgs  = array(
                                'post_type' => $post_type,
                                'posts_per_page' => -1,
                                'paged'        => $paged,
                            );

                            $all_posts = get_posts($CountArgs);

                            $post_count = count($all_posts);
                            $num_pages = ceil($post_count / $posts_per_page);

                            // args
                            $args = array(
                                'post_type' => $post_type,
                                'posts_per_page' => $posts_per_page,
                                 'paged'        => $paged,
                                'orderby'          => $atts['orderby'],
                                'order'            => $atts['order'],
                                'meta_query'=>$meta_query

                            );

                            // query
                            $the_query = new WP_Query( $args );

                            if ( $the_query->have_posts() ) :
                                while ( $the_query->have_posts() ) : $the_query->the_post();

                                    $case_number = get_field( 'case_number' );
                                    $procedure = get_field( 'procedure_types' );
                                    $gender = get_field( 'gender' );
                                    $age = get_field( 'age' );
                                    $ethnicity = get_field( 'ethnicity' );

                                    $slideshow = get_field( 'slideshow' );
                                    $before   = $slideshow[0]['before']['image']['ID'];
                                    $after   = $slideshow[0]['after']['image']['ID'];


                                    $html .='<div class="col-md-4 aios-gallery-list">';
                                        $html .='<div class="aios-gallery-wrap">';
                                                //images
                                                $html .=' <div class="aios-gallery-image">';

                                                if(!empty($before)){

                                                    $html .= '<canvas width="442" height="329" style="background-image: url('.wp_get_attachment_url($before).')"></canvas>';
                                                }else if( !empty($after) ){

                                                    $html .='  <canvas width="442" height="329" style="background-image: url('.wp_get_attachment_url($after).')"></canvas>';
                                                }else{
                                                    $html .= '<canvas width="442" height="329" style="background-image: url('.get_stylesheet_directory_uri().'/filterable-gallery-templates/main-page/aios-medical-main-page/assets/images/no-preview.jpg)"></canvas>';
                                                }

                                                if ( !empty($after) && !empty($before) ){
                                                    $html .=' <div class="img-comp-container">
                                                    <div class="img-comp-img">
                                                    <canvas width="442" height="329" style="background-image: url('.wp_get_attachment_url($after).')"></canvas>
                                                    </div>
                                                    <div class="img-comp-img img-comp-overlay">
                                                    <canvas width="442" height="329" style="background-image: url('.wp_get_attachment_url($before).')"></canvas>
                                                    </div>
                                                </div>';
                                                }

                                                $html .='</div>';

                                                $html .='<div class="aios-gallery-content">
                                                        <a href="'.get_permalink().'">
                                                            <span>CASE NO: '.$case_number.'</span>
                                                            <h4>'.$procedure.'</h4>
                                                            <ul>
                                                                <li><strong>GENDER:</strong> '.$gender.'</li>
                                                                <li><strong>AGE:</strong> '.$age.'</li>
                                                                <li><strong>ETHNICITY:</strong> '.$ethnicity.'</li>
                                                            </ul>
                                                            <em>View</em>
                                                        </a>
                                                    </div>';

                                        $html .='</div>';
                                    $html .='</div>';
                                endwhile;
                            else:
                                $html .= '<div class="gallery-no-posts">no Case found</div>';
                            endif;

                        $html .='</div>';

                        $html .='<div style="display:none;"><form action="'.get_the_permalink($page_id).'" method="get"><input type="hidden" name="pages" value="" id="paginate-value"><div class="aios-gallery-submit-bttn"><input type="submit" value="Search"></div></form></div>';
                        $html .='<div class="aios-gallery-pagination">  <ul>';
                            for($p = 1; $p <= $num_pages; $p++){
                                if ($params['pages'] == $p ){
                                 $html.= '<li><a  class="active" href="?page='.$p.'" data-page="'.$p.'">'.$p.'</a></li>';
                                }else{
                                     $html.= '<li><a data-page="'.$p.'">'.$p.'</a></li>';
                                }
                            }
                        $html .=' </ul></div>';

                    $html .= '</div>';
                $html .= '</div>';

            $html .= '</div>';

            return $html;


		}

	}

	$aios_filterable_gallery_shortcodes = new aios_filterable_gallery_shortcodes();

}
