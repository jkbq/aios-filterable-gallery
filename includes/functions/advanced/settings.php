<?php 
/** 
 * All option value are extracted in render.php 
 * Adding optins just make sure you the ff option name: tabs, tab, tabChild
 */
use AIOS\Gallery\Classses\Constant;
?>

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Listings Pages</span>Select page for themes to display.<br><strong>Note:</strong> Details page slug must not be the same as the page slug or else listing details will return 404.</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="filterable_gallery_settings[main_page]" class="float-left w-100">Active and Sold Page with Search</label>
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
		<div class="form-group">
			<label for="filterable_gallery_settings[active_page]" class="float-left w-100">Active Page</label>
			<?php
				$active_page_args = array(
					'depth'					=> 0,
					'child_of'				=> 0,
					'selected'				=> $active_page,
					'echo'					=> 1,
					'name'					=> 'filterable_gallery_settings[active_page]',
					'show_option_none'		=> '--', 
					'option_none_value'		=> null,
				); 
				wp_dropdown_pages( $active_page_args );
			?>
		</div>
		<div class="form-group">
			<label for="filterable_gallery_settings[sold_page]" class="float-left w-100">Sold Page</label>
			<?php
				$sold_page_args = array(
					'depth'					=> 0,
					'child_of'				=> 0,
					'selected'				=> $sold_page,
					'echo'					=> 1,
					'name'					=> 'filterable_gallery_settings[sold_page]',
					'show_option_none'		=> '--', 
					'option_none_value'		=> null,
				); 
				wp_dropdown_pages( $sold_page_args );
			?>
		</div>
		<div class="form-group">
			<label for="filterable_gallery_settings[neighborhoods_page]" class="float-left w-100">Neighborhoods Page</label>
			<?php
				$neighborhoods_page_args = array(
					'depth'					=> 0,
					'child_of'				=> 0,
					'selected'				=> $neighborhoods_page,
					'echo'					=> 1,
					'name'					=> 'filterable_gallery_settings[neighborhoods_page]',
					'show_option_none'		=> '--', 
					'option_none_value'		=> null,
				); 
				wp_dropdown_pages( $neighborhoods_page_args );
			?>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Listings Slugs</span>Custom for Default Pages.</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="filterable_gallery_settings[permastructure]">Details Page</label>
			<input type="text" id="filterable_gallery_settings[permastructure]" name="filterable_gallery_settings[permastructure]" class="filterable_gallery-permastructure" value="<?=$permastructure?>">
		</div>
		<div class="form-group">
			<label for="filterable_gallery_settings[property_features]">Property Features</label>
			<input type="text" id="filterable_gallery_settings[property_features]" name="filterable_gallery_settings[property_features]" class="filterable_gallery-permastructure" value="<?=$property_features?>">
		</div>
		<div class="form-group">
			<label for="filterable_gallery_settings[property_types]">Property Types</label>
			<input type="text" id="filterable_gallery_settings[property_types]" name="filterable_gallery_settings[property_types]" class="filterable_gallery-permastructure" value="<?=$property_types?>">
		</div>
		<div class="form-group">
			<label for="filterable_gallery_settings[property_statuses]">Property Statuses</label>
			<input type="text" id="filterable_gallery_settings[property_statuses]" name="filterable_gallery_settings[property_statuses]" class="filterable_gallery-permastructure" value="<?=$property_statuses?>">
		</div>
		<div class="form-group">
			<label for="filterable_gallery_settings[property_neighborhoods]">Property Neighborhoods</label>
			<input type="text" id="filterable_gallery_settings[property_neighborhoods]" name="filterable_gallery_settings[property_neighborhoods]" class="filterable_gallery-permastructure" value="<?=$property_neighborhoods?>">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Advanced Search Options</span></p>
	</div>
	<div class="wpui-col-md-9">
		Test
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Form Schedule a Showing</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="filterable_gallery_settings[forms_schedule_showing_button]">Button Text</label>
			<input type="text" id="filterable_gallery_settings[forms_schedule_showing_button]" name="filterable_gallery_settings[forms_schedule_showing_button]" value="<?=$forms_schedule_showing_button?>">
		</div>
		<div class="form-group">
			<label for="filterable_gallery_settings[forms_schedule_showing_title]">Form Title</label>
			<input type="text" id="filterable_gallery_settings[forms_schedule_showing_title]" name="filterable_gallery_settings[forms_schedule_showing_title]" value="<?=$forms_schedule_showing_title?>">
		</div>
		<div class="form-group">
			<label for="filterable_gallery_settings[forms_schedule_showing]" class="float-left w-100">Form</label>
			<select name="filterable_gallery_settings[forms_schedule_showing]" id="forms_schedule_showing">
				<?php
					$forms = new WP_Query( array( 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1 ) );
					if ( $forms->have_posts() ) {
						while ( $forms->have_posts() ) {
							$forms->the_post();
							$id = get_the_ID();
							$title = get_the_title();
							echo '<option ' . ( ( $forms_schedule_showing == $id ) ? 'selected' : '' ) . ' value="' . $id . '">' . $title . '</option>';
						}
					}
					wp_reset_postdata();
				?>
			</select>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Form Request Information</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="filterable_gallery_settings[forms_request_information_button]">Button Text</label>
			<input type="text" id="filterable_gallery_settings[forms_request_information_button]" name="filterable_gallery_settings[forms_request_information_button]" value="<?=$forms_request_information_button?>">
		</div>
		<div class="form-group">
			<label for="filterable_gallery_settings[forms_request_information_title]">Title</label>
			<input type="text" id="filterable_gallery_settings[forms_request_information_title]" name="filterable_gallery_settings[forms_request_information_title]" value="<?=$forms_request_information_title?>">
		</div>
		<div class="form-group">
			<label for="filterable_gallery_settings[forms_request_information]" class="float-left w-100">Form</label>
			<select name="filterable_gallery_settings[forms_request_information]" id="forms_request_information">
				<?php
					$forms = new WP_Query( array( 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1 ) );
					if ( $forms->have_posts() ) {
						while ( $forms->have_posts() ) {
							$forms->the_post();
							$id 	= get_the_ID();
							$title 	= get_the_title();
							echo '<option ' . ( ( $forms_request_information == $id ) ? 'selected' : '' ) . ' value="' . $id . '">' . $title . '</option>';
						}
					}
					wp_reset_postdata();
				?>
			</select>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Form Interested in Listing</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<select name="filterable_gallery_settings[interested_listing]" id="interested_listing">
				<?php
					$forms = new WP_Query( array( 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1 ) );
					if ( $forms->have_posts() ) {
						while ( $forms->have_posts() ) {
							$forms->the_post();
							$id = get_the_ID();
							$title = get_the_title();
							echo '<option ' . ( ( $interested_listing == $id ) ? 'selected' : '' ) . ' value="' . $id . '">' . $title . '</option>';
						}
					}
					wp_reset_postdata();
				?>
			</select>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Google Map API</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="wpui-row">
			<div class="wpui-col-md-9">
				<div class="form-group">
					<label for="filterable_gallery_settings[google_map_key]">API Key(Leaflet will automatically Used)</label>
					<input type="text" id="filterable_gallery_settings[google_map_key]" name="filterable_gallery_settings[google_map_key]" value="<?=$google_map_key?>">
				</div>
			</div>
			<div class="wpui-col-md-3">
				<div class="form-group">
					<label for="filterable_gallery_settings[google_map_exclude_homepage]">&nbsp;</label>
					<div class="form-checkbox-group">
						<div class="form-checkbox">
							<label><input type="checkbox" id="filterable_gallery_settings[google_map_exclude_homepage]" name="filterable_gallery_settings[google_map_exclude_homepage]" value="1" <?=( $google_map_exclude_homepage == 1 ? 'checked="checked"' : '' )?>> Exclude Homepage?</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="wpui-row mt-3">
			<div class="wpui-col-md-2">
				<div class="form-group">
					<label for="google_map_type" class="float-left w-100">Map Type</label>
					<select name="filterable_gallery_settings[google_map_type]" id="google_map_type" class="w-100">
						<?php
							foreach ( Constant::google_map_type() as $key => $value ) echo '<option ' . ( ( $google_map_type == $key ) ? 'selected' : '' ) . ' value="' . $key . '">' . $value . '</option>';
						?>
					</select>
				</div>
			</div>
			<div class="wpui-col-md-2">
				<div class="form-group">
					<label for="google_map_zoom" class="float-left w-100">Map Zoom</label>
					<select name="filterable_gallery_settings[google_map_zoom]" id="google_map_zoom" class="w-100">
						<?php
							foreach ( Constant::google_map_zoom() as $key => $value ) echo '<option ' . ( ( $google_map_zoom == $key ) ? 'selected' : '' ) . ' value="' . $key . '">' . $value . '</option>';
						?>
					</select>
				</div>
			</div>
			<div class="wpui-col-md-8">
				<div class="form-group">
					<label for="filterable_gallery_settings[google_map_icon]">Map Icon</label>
					<input type="text" id="filterable_gallery_settings[google_map_icon]" name="filterable_gallery_settings[google_map_icon]" value="<?=$google_map_icon?>" placeholder="Icon URL">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Disable Google Map</span></p>
	</div>
	<div class="wpui-col-md-9">
        <div class="form-group">
            <div class="form-checkbox-group">
                <div class="form-checkbox">
                    <label><input type="checkbox" id="filterable_gallery_settings[disable_google_map]" name="filterable_gallery_settings[disable_google_map]" value="1" <?=( $disable_google_map == 1 ? 'checked="checked"' : '' )?>> Use Leaflet instead of Google Map?</label>
                </div>
            </div>
        </div>
	</div>
</div>
<!-- END: Row Box -->

<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase mt-0" value="Save Changes">
			<a id="filterable_gallery-generate-forms" class="wpui-default-button float-right text-uppercase mr-3">Regenerate Default Forms</a>
		</div>
	</div>
</div>