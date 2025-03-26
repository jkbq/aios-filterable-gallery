<?php
get_header();
$doctors = get_field( 'doctors' );


function getEmbedUrl($url) {
    // function for generating an embed link
    $finalUrl = '';

    if (strpos($url, 'facebook.com/') !== false) {
        // Facebook Video
        $finalUrl.='https://www.facebook.com/plugins/video.php?href='.rawurlencode($url).'&show_text=1&width=200';

    } else if(strpos($url, 'vimeo.com/') !== false) {
        // Vimeo video
        $videoId = isset(explode("vimeo.com/",$url)[1]) ? explode("vimeo.com/",$url)[1] : null;
        if (strpos($videoId, '&') !== false){
            $videoId = explode("&",$videoId)[0];
        }
        $finalUrl.='https://player.vimeo.com/video/'.$videoId;

    } else if (strpos($url, 'youtube.com/') !== false) {
        // Youtube video
        $videoId = isset(explode("v=",$url)[1]) ? explode("v=",$url)[1] : null;
        if (strpos($videoId, '&') !== false){
            $videoId = explode("&",$videoId)[0];
        }
        $finalUrl.='https://www.youtube.com/embed/'.$videoId;

    } else if(strpos($url, 'youtu.be/') !== false) {
        // Youtube  video
        $videoId = isset(explode("youtu.be/",$url)[1]) ? explode("youtu.be/",$url)[1] : null;
        if (strpos($videoId, '&') !== false) {
            $videoId = explode("&",$videoId)[0];
        }
        $finalUrl.='https://www.youtube.com/embed/'.$videoId;

    } else if (strpos($url, 'dailymotion.com/') !== false) {
        // Dailymotion Video
        $videoId = isset(explode("dailymotion.com/",$url)[1]) ? explode("dailymotion.com/",$url)[1] : null;
        if (strpos($videoId, '&') !== false) {
            $videoId = explode("&",$videoId)[0];
        }
        $finalUrl.='https://www.dailymotion.com/embed/'.$videoId;

    } else{
        $finalUrl.=$url;
    }

    return $finalUrl;
}

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
                                <a href="#" class="gallery-view-all">View All</a>
                                <?php
                                    foreach ($procedures as $procedure){
                                         if ($procedure->parent != 0) {

                                             echo ', <a href="#"  class="gallery-view-once" data-trigger="'.$procedure->slug.'">' . $procedure->name . '</a>';
                                         }
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



                            foreach ($group_fields as $group_field){


                                $html  = '';
                                if ($procedure->name  == $group_field->post_title){

                                    $fieldGroup = acf_get_field_group($group_field->ID);
                                    $fields = acf_get_fields_by_id($group_field->ID);

                                    $html .='<div class="aios-gallery-md-procedures '.$procedure->slug.'">';
                                        $html .='<div class="aios-gallery-md-procedures-slideshow">';
                                            foreach ($fields as $field){

                                                if ($field['label'] == 'Add Photos'){
                                                     $imgs = get_field($field['name'], $post_id);

                                                     foreach ($imgs as $img){
                                                        $imgBefore  =  $img['before']['ID'];
                                                        $imgAfter   = $img['after']['ID'];
                                                         $html .= '<div class="aios-gallery-image">';
                                                            if (empty($imgAfter)){
                                                                $html .= '<canvas width="442" height="329" style="background-image: url('.wp_get_attachment_url($imgBefore).')"></canvas>';
                                                            }elseif(empty($imgBefore)){
                                                                  $html .= '<canvas width="442" height="329" style="background-image: url('.wp_get_attachment_url($imgAfter).')"></canvas>';
                                                            }

                                                             if (!empty($imgBefore) && !empty($imgAfter)){
                                                                $html .= ' <div class="ba-wrap">
                                                                            <h2 class="hidden">Before and After</h2>
                                                                            
                                                                            <div class="ba-slider-wrap">
                                                                                <div class="ba-slider">
                                                                                    <div class="ba-col before">
                                                                                        <div class="ba-item">
                                                                                            <div class="global-lines ba-lines">
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                            </div>
                                                                                            <div class="ba-img">
                                                                                            <canvas width="442" height="329" style="background-image: url('.wp_get_attachment_url($imgBefore).')"></canvas>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="ba-col after">
                                                                                        <div class="ba-item">
                                                                                            <div class="global-lines ba-lines">
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                                <span></span>
                                                                                            </div>
                                                                                            <div class="ba-img">
                                                                                                <canvas width="442" height="329" style="background-image: url('.wp_get_attachment_url($imgAfter).')"></canvas>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="ba-range">
                                                                                    <input type="range" name="ba-range" min="0" max="100" value="50" aria-label="Before and After Handler">
                                                                                </div>
                                                                                <div class="ba-handler">
                                                                                    <span></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>';
                                                             }
                                                        $html .='</div>';
                                                     }
                                                }

                                            }
                                        $html .='</div><!-- end of slideshow -->';

                                        $procedure_primary  = get_term_by('id',  $procedure->parent, 'procedure' );

                                        $html .= '<h2>'.$procedure_primary->name.' - '.$procedure->name.'</h2>';

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
                                                $videos = get_field($field['name'], $post_id);
                                                $html .= '<div class="aios-gallery-video-wrap">';
                                                $html .= '<div class="aios-video-gallery-title">
                                                                <h3>PROCEDURE  VIDEO</h3>
                                                                <p>View the videos of the procedure by clicking on the thumbnails on the right</p>
                                                            </div>';
                                                $html .='<div class="aios-gallery-video-preview">';
                                                $html .='<canvas width="408" height="308"></canvas>';
                                                $html .= '<iframe src="'.getEmbedUrl( $videos[0]['url']).'" width="640" height="357" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
                                                $html .='</div>';
                                                $html .=' <div class="aios-gallery-video-thumbnails">';

                                                         foreach ( $videos as $video) {
                                                                $video_url = getEmbedUrl( $video['url'] ); ;
                                                                $url_pieces = explode('/', $video_url);
                                                                $video_type = '';

                                                                if ( $url_pieces[2] == 'player.vimeo.com' ) { // If Vimeo
                                                                    $video_type = 'vimeo';
                                                                    $id = $url_pieces[4];
                                                                    $hash = unserialize(file_get_contents(esc_html('http://vimeo.com/api/v2/video/' . $id . '.php')));
                                                                    $thumbnail = $hash[0]['thumbnail_large'];

                                                                } elseif ( $url_pieces[2] == 'www.youtube.com' ) { // If Youtube
                                                                     $video_type = 'youtube';
                                                                    $extract_id = explode('?', $url_pieces[4]);
                                                                    $id = $extract_id[0];
                                                                    $thumbnail = 'http://img.youtube.com/vi/' . $id . '/mqdefault.jpg';

                                                                }

                                                               $html .= '<div class="aios-video-thumb '.$video_type.' ">
                                                                <a href="'.$video_url.'?autoplay=1">
                                                                    <canvas width="179" height="95" style="background-image:url('.$thumbnail.')"></canvas>
                                                                </a>
                                                            </div>';


                                                        }


                                                $html .='</div>';


                                                $html .= '</div>';



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
                                                    <strong>Contact <?= get_field( 'first_name', $doctors[ 0 ][ 'doctors_name' ]->ID ) ?> <?= get_field( 'last_name', $doctors[ 0 ][ 'doctors_name' ]->ID ) ?></strong>
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