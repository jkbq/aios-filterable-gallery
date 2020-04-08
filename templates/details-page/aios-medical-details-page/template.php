<?php 
get_header();

/**
* 
* Variables
* 
**/

// Slideshow
$slideshow = get_field( 'slideshow' );

// Case Number
$case_number = get_field( 'case_number' );

// Gender
$gender = get_field( 'gender' );

// Age
$age = get_field( 'age' );

// Description
$description = get_field( 'description' );

// Video Area
$video_area = get_field( 'video_area' );
$video_url = $video_area[ 'url' ];
$video_poster = $video_area[ 'poster' ][ 'url' ];

//$video_description = $video_area[ 'description' ];
$video_button_url = $video_area[ 'button' ][ 'url' ];
$video_button_label = $video_area[ 'button' ][ 'label' ];

// Case Details
$case_details = get_field( 'case_details' );
$case_details_description = $case_details[ 'description' ];
$case_details_list = $case_details[ 'list' ];

// Doctors
$doctors = get_field( 'doctors' );

echo '<pre style="display: none;">';
var_dump( $doctors );
echo '</pre>';

// Procedure
$procedure = get_field( 'procedure_types' );
$procedure_name = strtolower( preg_replace( '/\W/', '_', $procedure ) );
$procedure_group = get_field( 'procedure_' . $procedure_name );

switch ( $procedure ) {
    // Rhinoplasty
    case 'Rhinoplasty' :
        $procedure_details = [
            [
                'label' => 'Implant Type',
                'value' => $procedure_group[ $procedure_name . '_implant_type' ]
            ]
        ];
        break;
        
    // Face
    case 'Face' :
        $procedure_details = [
            [
                'label' => 'Procedure Type',
                'value' => $procedure_group[ $procedure_name . '_procedure_type' ]
            ]
        ];
        break;
        
    // Liposuction
    case 'Liposuction' :
        $procedure_details = [
            [
                'label' => 'Area',
                'value' => $procedure_group[ $procedure_name . '_area' ]
            ],
            [
                'label' => 'Measurement Before',
                'value' => $procedure_group[ $procedure_name . '_measurement' ][ $procedure_name . '_measurement_before' ]
            ],
            [
                'label' => 'Measurement After',
                'value' => $procedure_group[ $procedure_name . '_measurement' ][ $procedure_name . '_measurement_after' ]
            ],
            
        ];
        break;
        
    // Breast Augmentation
    case 'Breast Augmentation' :
        $procedure_details = [
            [
                'label' => 'Implant Type',
                'value' => $procedure_group[ $procedure_name . '_implant' ][ $procedure_name . '_implant_type' ]
            ],
            [
                'label' => 'Cup Size Pre-OP',
                'value' => $procedure_group[ $procedure_name . '_cup_size' ][ $procedure_name . '_cup_size_pre-op' ]
            ],
            [
                'label' => 'Cup Size Post-OP',
                'value' => $procedure_group[ $procedure_name . '_cup_size' ][ $procedure_name . '_cup_size_post-op' ]
            ],
            [
                'label' => 'Implant Size in ML',
                'value' => $procedure_group[ $procedure_name . '_implant' ][ $procedure_name . 'implant_size_in_ml' ]
            ]
        ];
        break;
    
    default :
        $procedure_details = false;
}

echo '<pre style="display: none;">';
var_dump( $procedure_name );
echo '</pre>';
?>
   
    
<div id="<?php echo ai_starter_theme_get_content_id('content-full') ?>">
	<article id="content" class="hfeed">
		
		<?php do_action('aios_starter_theme_before_inner_page_content') ?>
       
        <?php if(have_posts()) : ?>

            <?php while(have_posts()) : the_post(); ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php 
                        $aios_metaboxes_banner_title_layout = get_option( 'aios-metaboxes-banner-title-layout', '' );
                        if ( ! is_custom_field_banner( get_queried_object() ) || $aios_metaboxes_banner_title_layout != 'Inside Banner' ) {
                            $aioscm_used_custom_title   = get_post_meta( get_the_ID(), 'aioscm_used_custom_title', true );
                            $aioscm_main_title          = get_post_meta( get_the_ID(), 'aioscm_main_title', true );
                            $aioscm_sub_title           = get_post_meta( get_the_ID(), 'aioscm_sub_title', true );
                            $aioscm_title               = $aioscm_used_custom_title == 1 ? $aioscm_main_title . '<span>' . $aioscm_sub_title . '</span>' : get_the_title();
                            echo '<h1 class="entry-title">' . $aioscm_title . '</h1>';
                        }
                    ?>

                    <?php do_action('aios_starter_theme_before_entry_content') ?>

                    <div class="entry entry-content">	
                        
                        <div id="aios-filterable-details" class="aios-filterable-details">
                            <div class="aios-filterable-hero">
                                
                                <?php if ( $slideshow ) : ?>
                                   
                                    <div class="aios-filterable-hero-slider">
                                        <?php foreach ( $slideshow as $slide ) : ?>
                                        <div class="aios-filterable-hero-slider-item">
                                            <div class="aios-filterable-hero-beer aios-gallery-image">
                                                <?php 
                                                    // before image
                                                    $slideBeforeImage = $slide[ 'before' ][ 'image' ][ 'url' ];
                                                
                                                    // after image
                                                    $slideAfterImage = $slide[ 'after' ][ 'image' ][ 'url' ];
                                                    
                                                    // checks if either before or after image exist
                                                    $slideSingleImage = '';
                                                    $slideSingleImageClass = '';
                                                    if (
                                                        ( $slideBeforeImage && ! $slideAfterImage ) ||
                                                        ( ! $slideBeforeImage && $slideAfterImage )
                                                    ) {
                                                        if ( $slideBeforeImage ) {
                                                            $slideSingleImage = 'style="background-image: url(' . $slideBeforeImage . ');"';
                                                        }
                                                        else {
                                                            $slideSingleImage = 'style="background-image: url(' . $slideAfterImage . ');"';
                                                        }
                                                        $slideSingleImageClass = 'single-image';
                                                    }
                                                ?>
                                                <canvas width="1600" height="800" class="<?= $slideSingleImageClass ?>" <?= $slideSingleImage ?>></canvas>
                                                
                                                <?php if ( ! $slideSingleImage ) : ?>
                                                <div class="img-comp-container">
                                                    <div class="img-comp-img">
                                                        <canvas width="1600" height="800" style="background-image: url(<?= $slideAfterImage ?>);"></canvas>
                                                    </div>
                                                    <div class="img-comp-img img-comp-overlay">
                                                        <canvas width="1600" height="800" style="background-image: url(<?= $slideBeforeImage ?>);"></canvas>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <?php if ( count( $slideshow ) > 1 ) : ?>
                                        <div class="aios-filterable-hero-thumbnail">
                                            <?php 
                                                foreach ( $slideshow as $slide ) :
                                            
                                                // before image
                                                $slideBeforeImage = $slide[ 'before' ][ 'image' ][ 'url' ];

                                                // after image
                                                $slideAfterImage = $slide[ 'after' ][ 'image' ][ 'url' ];
                                            ?>
                                                <div class="aios-filterable-hero-thumbnail-item">
                                                    <div class="aios-filterable-hero-thumbnail-img">
                                                        <?= do_shortcode( '[aios_element]<canvas width="211" height="131" style="background-image: url(' . ( $slideAfterImage ? $slideAfterImage : $slideBeforeImage ) . ');"></canvas>[/aios_element]' ); ?>
                                                    </div>
                                                </div>
                                            <?php 
                                                endforeach; 
                                            ?>
                                        </div>
                                        <div class="aios-filterable-hero-control">
                                            <div class="aios-filterable-hero-arrow aios-filterable-hero-prev">
                                                <span class="ai-font-arrow-b-p"></span>
                                            </div>
                                            <div class="aios-filterable-hero-arrow aios-filterable-hero-next">
                                                <span class="ai-font-arrow-b-n"></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                <?php endif; ?>
                            </div>
                            <div class="aios-filterable-main">
                                <div class="container">
                                    <?php if ( $case_number || $procedure ) : ?>
                                    <div class="aios-filterable-title">
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <?php if ( $case_number ) : ?>
                                                    <span>Case NO: <?= $case_number ?></span>
                                                <?php endif; ?>
                                                
                                                <?php if ( $procedure ) : ?>
                                                    <strong><?= $procedure ?></strong>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="aios-filterable-infos">
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1">
                                                <ul>
                                                    <?php if ( $age ) : ?>
                                                        <li>
                                                            <strong><?= $age ?></strong>
                                                            <span>Age</span>
                                                        </li>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ( $gender ) : ?>
                                                        <li>
                                                            <strong><?= $gender ?></strong>
                                                            <span>Gender</span>
                                                        </li>
                                                    <?php endif; ?>
                                                    
                                                    <?php 
                                                        if ( $procedure_details ) : 
                                                            foreach ( $procedure_details as $key => $procedure_detail ) :
                                                                if ( $key > 4 ) {
                                                                    break;
                                                                }
                                                            
                                                                $procedure_label = $procedure_detail[ 'label' ];
                                                                $procedure_value = $procedure_detail[ 'value' ];
                                                    
                                                                if ( $procedure_value ) :
                                                    ?>
                                                                <li>
                                                                    <strong><?= $procedure_value ?></strong>
                                                                    <span><?= $procedure_label ?></span>
                                                                </li>
                                                    <?php 
                                                                endif;
                                                            endforeach; 
                                                        endif; 
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php if ( $description ) : ?>
                                        <div class="aios-filterable-description">
                                            <?= $description ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="aios-filterable-video">
                                        <?php 
                                            // class for full width if one of them doesn't exist
                                            $full_width_class = '';
                                            
                                            // if video player exist and not video info
                                            if ( $video_url && ( ! $video_description && ! $video_button_label ) ) {
                                                $full_width_class = 'full-width';
                                            }
                                        
                                            // if video info exist and not video player
                                            if ( ! $video_url && ( $video_description && $video_button_label ) ) {
                                                $full_width_class = 'full-width';
                                            }
                                        ?>
                                       
                                        <?php if ( $video_url ) : ?>
                                            <div class="aios-filterable-video-player <?= $full_width_class ?>">
                                                <?php 
                                                    echo do_shortcode( '
                                                        [aios_element]
                                                            <video poster="' . $video_poster . '" playsinline controls>
                                                                <source src="' . $video_url . '" type="video/mp4" />
                                                            </video>
                                                        [/aios_element]
                                                    ' );
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ( $video_description || ( $video_button_url || $video_button_label ) ) : ?>
                                            <div class="aios-filterable-video-info <?= $full_width_class ?>">
                                                <div class="aios-filterable-video-title">
                                                    <span>Case NO: <?= $case_number ?></span>
                                                    <strong>Video</strong>
                                                </div>

                                                <?php if ( $video_description ) : ?>
                                                    <div class="aios-filterable-video-list">
                                                        <?= $video_description ?>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <?php 
                                                    if ( $procedure_details ) :
                                                ?>
                                                    <div class="aios-filterable-video-list">
                                                        <ul>
                                                <?php
                                                        foreach ( $procedure_details as $key => $procedure_detail ) :
                                                            if ( $key <= 4 ) {
                                                                continue;
                                                            }

                                                            $procedure_label = $procedure_detail[ 'label' ];
                                                            $procedure_value = $procedure_detail[ 'value' ];

                                                            if ( $procedure_value ) :
                                                ?>
                                                            <li>
                                                                <strong><?= $procedure_value ?></strong>
                                                                <span><?= $procedure_label ?></span>
                                                            </li>
                                                <?php 
                                                            endif;
                                                        endforeach; 
                                                ?>
                                                        </ul>
                                                    </div>
                                                <?php
                                                    endif; 
                                                ?>

                                                <?php if ( $video_button_url || $video_button_label ) : ?>
                                                    <a href="<?= $video_button_url ? $video_button_url : '#' ?>" class="aios-filterable-video-button"><?= $video_button_label ?></a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if ( $case_details_description || ! empty( $case_details_list ) ) : ?>
                                        <div class="aios-filterable-case">
                                            <div class="aios-filterable-case-main">
                                                <div class="aios-filterable-case-title">
                                                    <span>Case</span>
                                                    <strong>Details</strong>
                                                </div>
                                                <div class="aios-filterable-case-control">
                                                    <div class="aios-filterable-case-arrow aios-filterable-case-prev">
                                                        <span class="ai-font-arrow-g-p"></span>
                                                    </div>
                                                    <div class="aios-filterable-case-arrow aios-filterable-case-next">
                                                        <span class="ai-font-arrow-g-n"></span>
                                                    </div>
                                                </div>
                                                <div class="aios-filterable-case-description">
                                                    <?= $case_details_description ?>
                                                </div>
                                                <div class="aios-filterable-case-slider">
                                                    <?php foreach ( $case_details_list as $key => $case_detail_item ) : ?>
                                                        <div class="aios-filterable-case-col">
                                                            <div class="aios-filterable-case-item">
                                                                <div class="aios-filterable-case-number"><?= $key + 1 ?></div>
                                                                <div class="aios-filterable-case-details">
                                                                    <strong><?= $case_detail_item[ 'title' ] ?></strong>
                                                                    <p><?= $case_detail_item[ 'description' ] ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="aios-filterable-contact">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <div class="aios-filterable-contact-title">
                                                <?php if ( count( $doctors ) == 1 ) : ?>
                                                    <strong>Contact <?= get_field( 'last_name', $doctors[ 0 ][ 'doctors_name' ]->ID ) ?></strong>
                                                <?php else : ?>
                                                    <strong>Contact US</strong>
                                                <?php endif; ?>
                                            </div>
                                            <div class="aios-filterable-contact-form">
                                                <?php 
                                                    $form_name = 'AIOS Filterable Gallery Contact';
                                                    $form_data = get_page_by_title( $form_name, '', 'wpcf7_contact_form' );

                                                    if ( $form_data ) {
                                                        echo do_shortcode( '[contact-form-7 id="' . $form_data->ID . '" title="' . $form_name . '" html_class="use-floating-validation-tip"]' );
                                                    }
                                                ?>
                                                
                                                <?php 
                                                    if ( $doctors ) : 
                                                        $send_to_doctors_email = '';
                                                        foreach ( $doctors as $key => $doctor ) {
                                                            if ( $key != 0 ) {
                                                                $send_to_doctors_email .= ',';
                                                            }
                                                            
                                                            $send_to_doctors_email .= get_field( 'email', $doctor[ 'doctors_name' ]->ID );
                                                        }
                                                ?>
                                                    <script>
                                                        (function ( $ ) {

                                                            $(document).ready(function () {
                                                                var $sendTo = $('#aios-filterable-sendto');
                                                                
                                                                $sendTo.val("<?= $send_to_doctors_email ?>");
                                                            });

                                                        })( jQuery );
                                                    </script>
                                                <?php 
                                                    endif; 
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <?php do_action('aios_starter_theme_after_entry_content') ?>

                </div>

            <?php endwhile; ?>

            <div class="navigation">
                <?php wp_link_pages(); ?>
            </div>

        <?php endif; ?>
		
		<?php do_action('aios_starter_theme_after_inner_page_content') ?>
		
    </article><!-- end #content -->
</div><!-- end #content-full -->

<?php get_footer(); ?>