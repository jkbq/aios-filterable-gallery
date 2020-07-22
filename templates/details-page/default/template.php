<?php
get_header();
$doctors = get_field( 'doctors' );

?>
<?php if(have_posts()) : ?>

	<?php while(have_posts()) : the_post(); ?>

        <?php
            $post_id            = get_the_ID();
            $case_number        = get_field('case_number', $post_id);
            $procedures = wp_get_post_terms( $post_id, 'procedure',  array( 'orderby' => 'parent', 'order' => 'ASC' ) );
            $gender = get_field( 'gender', $post_id);
            $age = get_field( 'age', $post_id);
            $ethnicity = get_field( 'ethnicity', $post_id);


            $args = array(
                'numberposts' => -1,
                'post_type'   => 'acf-field-group'
            );

            $group_fields = get_posts( $args );

        ?>
        <div id="aios-md-gallery-wrapper">
            <div class="container">
                    <div class="aios-md-gallery-header">
                        <div class="aios-md-case-number">
                            <h1>CASE NO: <span><?= $case_number ?></span></h1>

                            <div class="aios-procedures-labels">
                                <a href="#">View All</a>
                                <?php
                                    foreach ($procedures as $procedure){
                                        echo ', <a href="#">'.$procedure->name.'</a>';
                                    }
                                ?>
                            </div>


                        </div>
                        <div class="aios-md-case-details">

                            <div>
                                <span>GENDER</span> <strong><?= $gender ?></strong>
                            </div>
                            <div>
                                <span>AGE </span><strong><?= $age ?></strong>
                            </div>
                            <div>
                                <span>Ethnicity </span><strong><?=$ethnicity ?></strong>
                            </div>

                        </div>
                    </div><!-- end of md gallery header -->


                    <?php
                        foreach ($procedures as $key =>$procedure){

                            if ($key == 0) {
                                $procedure_primary = $procedure->name;
                            }


                            foreach ($group_fields as $group_field){


                                $html  = '';
                                if ($procedure->name  == $group_field->post_title){



                                    $fieldGroup = acf_get_field_group($group_field->ID);
                                    $fields = acf_get_fields_by_id($group_field->ID);

                                    $html .='<div class="aios-gallery-md-procedures">';
                                        $html .='<div class="aios-gallery-md-procedures-slideshow">';
                                            foreach ($fields as $field){

                                                if ($field['label'] == 'Add Photos'){
                                                     $imgs = get_field($field['name'], $post_id);

                                                     foreach ($imgs as $img){
                                                        $imgBefore  =  $img['before']['ID'];
                                                        $imgAfter   = $img['after']['ID'];
                                                         $html .= '<div class="aios-gallery-image">';
                                                            $html .= '<canvas width="442" height="329"></canvas>';
                                                            $html .= ' <div class="img-comp-container">
                                                                <div class="img-comp-img">
                                                                    <canvas width="442" height="329" style="background-image: url('.wp_get_attachment_url($imgAfter).')"></canvas>
                                                                </div>
                                                                <div class="img-comp-img img-comp-overlay">
                                                                    <canvas width="442" height="329" style="background-image: url('.wp_get_attachment_url($imgBefore).')"></canvas>
                                                                </div>
                                                            </div>';
                                                        $html .='</div>';
                                                     }
                                                }

                                            }
                                        $html .='</div><!-- end of slideshow -->';

                                        $html .= '<h2>'.$procedure_primary.' - '.$procedure->name.'</h2>';

                                        $html .= '<div class="aios-gallery-md-procedures-method">';
                                            foreach ($fields as $field) {

                                                $field_post_value = get_field($field['name'], $post_id);

                                                if ( $field['label'] != 'Add Photos' && $field['label'] != 'Description' && $field['label'] != 'Video'){

                                                    $html .='<div>
                                                        <h3>'.$field_post_value.'</h3>
                                                        <span>'.$field['label'].'</span>
                                                    </div>';
                                                }



                                            }
                                        $html .='</div><!-- produre methods -->';

                                        foreach ($fields as $field) {
                                            if ( $field['label'] == 'Description') {
                                                 $descriptions = get_field($field['name'], $post_id);
                                                 $html .= '<div class="aios-gallery-md-description">';
                                                    $html .= wpautop($descriptions);
                                                 $html .= '</div>';
                                            }

                                            if ( $field['label'] == 'Video') {
                                                $video = get_field($field['name'], $post_id);
                                                $html .= '<a target="_blank" href="'.$video['url'].'" class="aios-video-popup aios-gallery-popup-button">click here to view video</a>';
                                            }


                                        }

                                    $html .='</div><!-- end of gallery contents -->';

                                }
                                echo  $html;

                            }

                        }

                    ?>

            </div><!-- end of container -->

            <div class="aios-filterable-testimonails">
                    <div class="container">
                        <div class="aios-filterable-testi-header">
                            <h2>
                                <span>client</span>
                                testimonials
                            </h2>
                            <div class="aios-filterable-case-control">
                                <div class="aios-gallery-prev">
                                    <span class="ai-font-arrow-g-p"></span>
                                </div>
                                <div class="aios-gallery-next">
                                    <span class="ai-font-arrow-g-n"></span>
                                </div>
                            </div>
                        </div>
                        <div class="aios-filterable-testi-wrap">

                            <div class="aios-filterable-testi-lists">
                                <a href="#">
                                    <p>I just wanted you to know how much I appreciate your genius. Truly you have a gift and I thank you for sharing it with me and others… your staff is very kind and considerate, and all that helps when someone is a little nervous.</p>
                                    <p>
I just wanted them to know too that I appreciate their kindness.</p>
                                    <span>Esther Howard</span>
                                </a>
                            </div>
                            <div class="aios-filterable-testi-lists">
                                <a href="#">
                                    <p>Just a note of thanks to you and your entire staff in making my rhinoplasty a success without any complications… I had surgery, in your facility, on Wednesday and started a new job the following Tuesday without anyone realizing I had surgery the previous week…</p>
                                    <p>It was amazing.</p>
                                    <span>Josie Carroll</span>
                                </a>
                            </div>
                            <div class="aios-filterable-testi-lists">
                                <a href="#">
                                    <p>I cannot find words to thank you for all you did for me and for how kind and sweet you’ve been together with your staff. </p>
                                    <p>
Thank you for giving me my self-esteem back. You’re a very exceptional person.</p>
                                    <span>Carrie Walter</span>
                                </a>
                            </div>
    <div class="aios-filterable-testi-lists">
                                <a href="#">
                                    <p>I just wanted you to know how much I appreciate your genius. Truly you have a gift and I thank you for sharing it with me and others… your staff is very kind and considerate, and all that helps when someone is a little nervous.</p>
                                    <p>
I just wanted them to know too that I appreciate their kindness.</p>
                                    <span>Esther Howard</span>
                                </a>
                            </div>
                        </div>

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

	<?php endwhile; ?>

<?php endif; ?>






<?php get_footer(); ?>