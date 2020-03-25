<?php
/**
 * Displays page and sub-pages and contents
 *
 * @since 1.0.0
 */

use AIOS\Gallery\Config;
use AIOS\Gallery\Classses\Options;
?>
<!-- BEGIN: Main Container -->
<div id="wpui-container-minimalist">
	<!-- BEGIN: Container -->
	<div class="wpui-container">
		<h4>Listings Settings</h4>
		<!-- BEGIN: Tabs -->
		<div class="wpui-tabs">
			<!-- BEGIN: Header -->
			<div class="wpui-tabs-header">
				<?php
					/** Get array of Settings **/
                    $filterable_gallery_settings = Options::Settings();
					if( !empty( $filterable_gallery_settings ) ) extract( $filterable_gallery_settings );

					/** Create main tabs **/
					$tabs = Config::options_tabs();
					echo '<ul>'; 
						foreach ( $tabs as $tab ) {
							$restriction = ( isset( $tab['restrict'] ) ? $tab['restrict'] : 'no' );
							if ( $restriction == 'yes' ) {
								if ( strtolower( $current_username ) === 'agentimage' ) 
									echo '<li><a data-id="' . $tab['url'] . '">' . $tab['title'] . '</a></li>'; 
							} else {
								echo '<li><a data-id="' . $tab['url'] . '">' . $tab['title'] . '</a></li>'; 
							}
						}
					echo '</ul>';
				?>
			</div>
			<!-- END: Header -->
			<!-- BEGIN: Body -->
			<div class="wpui-tabs-body">
				<!-- Loader -->
				<div class="wpui-tabs-body-loader"><i class="ai-font-loading-b"></i></div>
				<!-- Contents -->
				<?php
					foreach ( $tabs as $tab ) {
						echo '<div data-id="' . $tab['url'] . '" class="wpui-tabs-content ' . $tab['url'] . '">';
							/** Title **/ 
							echo '<div class="wpui-tabs-title">' . $tab['title'] . '</div>';
							/** Check if child is an array to create a child sub pages else only main page will be created. **/
							if ( isset( $tab['child'] ) ) {
								/** Display Child Tab **/
								echo '<ul class="wpui-child-tabs">';
									foreach ( $tab['child'] as $tabChild) {
										$childRestriction = ( isset( $tabChild['restrict'] ) ? $tabChild['restrict'] : 'no' );
										if ( $childRestriction == 'yes' ) {
											if ( strtolower( $current_username ) === 'agentimage' ) 
												echo '<li><a data-child-id="' . $tabChild['url'] . '">' . $tabChild['title'] . '</a></li>';
										} else {
											echo '<li><a data-child-id="' . $tabChild['url'] . '">' . $tabChild['title'] . '</a></li>';
										}
									}
								echo '</ul>';

								/** Display Child Content **/
								foreach ( $tab['child'] as $tabChild ) {
									echo '<div data-child-id="' . $tabChild['url'] . '" class="wpui-child-tabs-content ' . $tabChild['url'] . '">';
										echo '<div class="wpui-tabs-container">';
											if ( !empty( $tabChild['function'] ) ) {
												$restriction = ( isset( $tab['restrict'] ) ? $tab['restrict'] : 'no' );
												if ( $restriction == 'yes' ) {
													if ( strtolower( $current_username ) === 'agentimage' ) {
														require_once( 'functions/' . $tabChild['function'] );
													} else {
														echo '<div class="wpui-row wpui-row-box">
															<div class="wpui-col-md-12"><p>You don\'t have enough permission to access this page.</p></div>
														</div>';
													}
												} else {
													require_once( 'functions/' . $tabChild['function'] );
												}
											} else {
												echo '<p>Error: Array[function] is empty.</p>';
											}
										echo '</div>';
									echo '</div>';
								}
							} else {
								echo '<div class="wpui-tabs-container">';
									if ( !empty( $tab['function'] ) ) {
										$restriction = ( isset( $tab['restrict'] ) ? $tab['restrict'] : 'no' );
										if ( $restriction == 'yes' ) {
											if ( strtolower( $current_username ) === 'agentimage' ) {
												require_once( 'functions/' . $tab['function'] );
											} else {
												echo '<div class="wpui-row wpui-row-box">
													<div class="wpui-col-md-12"><p>You don\'t have enough permission to access this page.</p></div>
												</div>';
											}
										} else {
											require_once( 'functions/' . $tab['function'] );
										}
									} else {
										echo '<p>Error: Array[function] is empty.</p>';
									}
								echo '</div>';
							}
						echo '</div>';
					}
				?>
			</div>
			<!-- END: Body -->
		</div>
		<!-- END: Tabs -->
	</div>
	<!-- END: Container -->
</div>
<!-- END: Main Container -->