<?php
/** Common methods to create input, select, and textarea */
namespace AIOS\Gallery\Classses;

class CreateFields {

    /**
     * Create Input Field.
     *
     * @since 1.0.0
     *
     * @access public
     * @return string
     */
    public static function input_field( $args = array() ) {
        /** Accepted args and default values **/
        $defaults = array(
            'name' 			=> 'default-name',
            'class' 		=> '',
            'value' 		=> '',
            'placeholder' 	=> '',
            'label' 		=> true,
            'label_value' 	=> 'Add label',
            'type' 			=> 'text',
            'autocomplete' 	=> 'on'
        );

        $r = wp_parse_args( $args, $defaults );

        extract( $r );
        $html = '';
        $class = !empty( $class ) ? 'class="' . $class . '"' : '';

        $html .= '<div class="form-group">';
            $html .= ( $label ? '<label for="' . $name . '">' . $label_value . '</label>' : '' );
            $html .= '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" ' . $class . ' value="' . $value . '" placeholder="' . $placeholder . '" autocomplete="' . $autocomplete . '">';
        $html .= '</div>';

        return $html;
    }

    /**
     * Create Input Text.
     *
     * @since 1.0.0
     *
     * @access public
     * @return string
     */
    public static function input_text( $args = array() ) {
        /** Accepted args and default values **/
        $defaults = array(
            'name' 			=> 'default-name',
            'class' 		=> '',
            'value' 		=> '',
            'placeholder' 	=> '',
            'label' 		=> true,
            'label_value' 	=> 'Add label',
            'autocomplete' 	=> 'on',
            'readonly' 		=> false
        );

        $r = wp_parse_args( $args, $defaults );

        extract( $r );
        $html = '';
        $class = !empty( $class ) ? 'class="' . $class . '"' : '';

        $html .= '<div class="form-group">';
            $html .= ( $label ? '<label for="' . $name . '">' . $label_value . '</label>' : '' );
            $html .= '<input type="text" name="' . $name . '" id="' . $name . '" ' . $class . ' value="' . $value . '" placeholder="' . $placeholder . '" autocomplete="' . $autocomplete . '" ' . ( $readonly ? 'readonly' : '' ) . '>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Create Input Checkbox.
     *
     * @since 1.0.0
     *
     * @access public
     * @return string
     */
    public static function input_checkbox( $args = array() ) {
        /** Accepted args and default values **/
        $defaults = array(
            'name' 				=> 'default-name',
            'options' 			=> array(),
            'default_option' 	=> array(),
            'has_delete' 		=> false
        );

        $r = wp_parse_args( $args, $defaults );

        extract( $r );
        $html = '';
        $delete = '';
        $delete_class = '';

        if ( $has_delete ) {
            $delete = '<span class="delete-checkbox">Delete</span>';
            $delete_class = 'has-delete';
        }

        $html .= '<div class="form-group">';
            $html .= '<div class="form-checkbox-group">';

                foreach ( $options as $option ) {
                    $is_checked = ( array_search( $option, $default_option ) !== false ? 'checked="checked"' : '' );

                    $html .= '<div class="form-checkbox ' . $delete_class . '">
                        <label><input type="checkbox" name="' . $name . '[]" id="' . $name . '" value="' . $option . '" ' . $is_checked . '> ' . $option . ' ' . $delete . '</label>
                    </div>';
                }

            $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Create Input with Select.
     *
     * @since 1.0.0
     *
     * @access public
     * @return string
     */
    public static function input_with_select( $args = array() ){
        /** Accepted args and default values **/
        $defaults = array(
            /** Both **/
            'label' 				=> true,
            'label_value' 			=> 'Add label',
            /** Input **/
            'input_name'			=> 'default-name',
            'value' 				=> '',
            'placeholder' 			=> '',
            'padding_right' 		=> 80,
            /** Select **/
            'select_name' 			=> 'default-name-select',
            'is_select_name_array' 	=> false,
            'has_slash' 			=> false,
            'options' 				=> array(),
            'default_option' 		=> '',
            'reverse' 				=> false
        );

        $r = wp_parse_args( $args, $defaults );

        extract( $r );
        $html = '';

        $html .= '<div class="form-group with-selection">';
            $html .= ( $label ? '<label for="' . $input_name . '">' . $label_value . '</label>' : '' );
            $html .= '<input type="text" name="' . $input_name . '" id="' . $input_name . '" value="' . $value . '" placeholder="' . $placeholder . '" style="padding-right:' . $padding_right . 'px">';

            $html .= '<select name="' . $select_name . ( $is_select_name_array ? '[]' : '' ) . '" id="' . $select_name . '">';
                foreach( $options as $option => $select_value ){
                    $is_checked = ( $default_option == $option ) ? 'selected' : '';
                    if( $reverse == true ){
                        $html .= '<option ' . $is_checked . ' value="' . $select_value . '">' . ( $has_slash ? '/ ' : '' ) . $option . '</option>';	
                    } else {
                        $html .= '<option ' . $is_checked . ' value="' . $option . '">' . ( $has_slash ? '/ ' : '' ) . $select_value . '</option>';	
                    }
                }
            $html .= '</select>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Create Select.
     *
     * @since 1.0.0
     *
     * @access public
     * @return string
     */
    public static function select( $args = array() ){
        /** Accepted args and default values **/
        $defaults = array(
            'name' 				=> 'default-name',
            'is_name_array' 	=> false,
            'options' 			=> array(),
            'default_option' 	=> '',
            'label' 			=> true,
            'label_value' 		=> 'Add label',
            'reverse' 			=> false
        );

        $r = wp_parse_args( $args, $defaults );

        extract( $r );
        $html = '';

        $html .= '<div class="form-group">';
            $html .= ( $label ? '<label for="' . $name . '" class="float-left w-100">' . $label_value . '</label>' : '' );

            $html .= '<select name="' . $name . ( $is_name_array ? '[]' : '' ) . '" id="' . $name . '" class="w-100">';
                foreach( $options as $option => $value ){
                    $is_checked = ( $default_option == $option ) ? 'selected' : '';
                    if( $reverse == true ){
                        $html .= '<option ' . $is_checked . ' value="' . $value . '">' . $option . '</option>';	
                    } else {
                        $html .= '<option ' . $is_checked . ' value="' . $option . '">' . $value . '</option>';	
                    }
                }
            $html .= '</select>';
        $html .= '</div>';

        return $html;
    }

}