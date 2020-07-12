<?php
use AIOS\Gallery\Classses\Constant;

if ( !class_exists( 'aios_filterable_url_rewrite' ) ) {

    class aios_filterable_url_rewrite
    {

        /**
         * Constructor
         *
         * @since 1.0.0
         * @access public
         * @return void
         */
        public function __construct()
        {
            $this->add_actions();
        }

        /**
         * Add Actions.
         *
         * @since 1.0.0
         * @access protected
         * @return void
         */
        protected function add_actions()
        {

    add_filter( 'post_type_link', array( $this, 'wpa_show_permalinks'), 1, 2 );
            add_action( 'init', array( $this, 'archive_rewrite_rules' ));

        }
		function archive_rewrite_rules() {
            add_rewrite_rule(
                '^cases/(.*)/(.*)/?$',
                'index.php?post_type=cases&name=$matches[2]',
                'top'
            );
            flush_rewrite_rules(); // use only once
        }


		function wpa_show_permalinks( $post_link, $post ){
            if ( is_object( $post ) && $post->post_type == 'cases' ){
                $terms = wp_get_object_terms( $post->ID, 'casenumber' );
                if( $terms ){
                    return str_replace( '%casenumber%' , $terms[0]->slug , $post_link );
                }
            }
            return $post_link;
        }
        
    }
    $aios_filterable_url_rewrite = new aios_filterable_url_rewrite();

}
