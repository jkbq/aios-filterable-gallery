<?php 
/** 
 * All option value are extracted in render.php 
 * Adding optins just make sure you the ff option name: tabs, tab, tabChild
 */
use AIOS\Gallery\Classses\Constant;
$test = get_option('filterable_gallery_settings');

var_dump($test);
?>

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Gallery Pages</span>Select page for themes to display.<br><strong>Note:</strong> Details page slug must not be the same as the page slug or else gallery will return 404.</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="filterable_gallery_settings[main_page]" class="float-left w-100">Filterable Gallery</label>
			<?php
				$main_page_args = array(
					'depth'					=> 0,
					'child_of'				=> 0,
					'selected'				=> $main_page,
					'echo'					=> 1,
					'name'					=> 'filterable_gallery_settings[main_page]',
					'show_option_none'		=> '--',
					'option_none_value'		=> null,
				);
				wp_dropdown_pages( $main_page_args );
			?>
		</div>
</div>
<!-- END: Row Box -->


    <?php
        $args = array(
            'post_type'  => 'acf-field-group',

        );
        $postslist = get_posts( $args );

        foreach ( $postslist->posts as $value){

            $groupID= $value->ID;

            $custom_field_keys = get_post_custom_keys($groupID);
            foreach ( $custom_field_keys as $key => $fieldkey )
            {

                var_dump($fieldkey);
            }

        }

    ?>

<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase mt-0" value="Save Changes">
		</div>
	</div>
</div>