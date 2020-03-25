<?php
/**
 * All option value are extracted in render.php 
 * Adding optins just make sure you the ff option name: tabs, tab, tabChild
 *
 * This will get all the templates for details page
 *
 * @since 1.0.0
 * @return void
 */
use AIOS\Gallery\Config;

$template_locations = Config::get_template_location( 'active-page' );

echo '<div class="wpui-row wpui-templates">';
	foreach ( $template_locations as $template_location ) {
		extract($template_location);
		?>
			<div class="wpui-col-md-6 my-3">
				<div class="wpui-template <?=$is_active?>">
					<canvas width="500" height="300" style="background-image: url( <?=$template_screenshot?> );"></canvas>
					<div class="wpui-details">
						<span><?=$template_name?></span>
						<?php
							if ( $is_active === 'active-template' ) {
								echo '<a href="" class="wpui-template-activator wpui-template-activated">Activated</a>';
							} else {
								echo '<a href="" class="wpui-template-activator" data-theme-name="gallery-active-page" data-theme-value="' . $template_fullname . '">Activate</a>';
							}
						?>
					</div>
				</div>
			</div>
		<?php
	}
echo '</div>';