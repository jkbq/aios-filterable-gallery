<?php
	/** Note: **/
	/** prefix for option name **/
	$template_name = 'filterable_gallery-main-page-default';
?>
<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Label Name</span> Label Description</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="duplicate-this-menu-name">Input Label</label>
			<input type="text" id="" placeholder="">
		</div>
	</div>
</div>
<!-- END: Row Box -->
<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Label Name</span> Label Description</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<label for="duplicate-this-menu-name">Input Label</label>
			<input type="text" class="aios-color-picker" data-alpha="true" name="<?=$template_name?>-header-color" data-default-color="#444444" value="<?php echo get_option( $template_name . '-header-color' ) !== false ? get_option( $template_name . '-header-color' ) : '#444444'; ?>">
		</div>
	</div>
</div>
<!-- END: Row Box -->
<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
		</div>
	</div>
</div>
<!-- END: Row Box -->