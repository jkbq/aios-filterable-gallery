<?php get_header();
    $params = $_GET;
    $procedures = get_terms( array(
        'taxonomy' => 'procedure',
        'hide_empty' => false
    ) );

?>
	<div id="aios-gallery-banner">
        <div class="aios-gallery-banner-wrap">
            <canvas width="1600" height="650"></canvas>
        </div>
        <div class="aios-gallery-title">
            <div class="container container-wide">
                <h1>Patient <br> <span>Gallery</span></h1>
            </div>
        </div>
    </div>

    <div class="aios-gallery-search-filters">
        <div class="container container-wide">
            <div class="aios-gallery-form">
                <form action="<?= site_url()?>/cases" method="get">
                    <input type="hidden" name="page" value="<?= $params['page'] ?>" id="paginate-value">
                    <input type="hidden" name="sorts" value="<?= $params['sorts'] ?>" id="sort">
                    <input type="hidden" name="case_number" value="<?= $params['case'] ?>" id="case-number">
                    <input type="hidden" name="procedure" value="" id="procedure-main">
                    <div class="aios-gallery-form-wrap">


                        <div class="aios-gallery-dropdown-procedure">
                             <input type="hidden" placeholder="Procedure">
                            <span>Procedure</span>
                        </div>

                        <div class="aios-gallery-checkbox-filter">
                            <span>Gender</span>
                            <div class="aios-checkbox-sets">
                               <div class="form-group">
                                    <input class="styled-checkbox" name="gender" id="gender" type="checkbox" value="male" <?= ( $params['gender'] == 'male' ? 'checked' : '' ) ?>>
                                    <label for="styled-checkbox-1">Male</label>
                                </div>
                                <div class="form-group">
                                    <input class="styled-checkbox" name="gender" id="gender" type="checkbox" value="female" <?= ( $params['gender'] == 'female' ? 'checked' : '' ) ?>>
                                    <label for="styled-checkbox-1">Female</label>
                                </div>
                                <div class="form-group">
                                    <input class="styled-checkbox" name="gender" id="gender" type="checkbox" value="transgender" <?= ( $params['gender'] == 'transgender' ? 'checked' : '' ) ?>>
                                    <label for="styled-checkbox-1">Transgender</label>
                                </div>
                            </div>
                        </div><!-- end of checkbox filter -->
                        <div class="aios-gallery-range-filter">
                            <?php
                                $ages  = explode(",", $params['age']);
                            ?>
                             <label for="age">Age</label>
                            <input type="hidden" id="age" name="age" value="<?= $params['age'] ?>">
                            <input type="text" class="js-range-slider" name="" value=""
                                data-type="double"
                                data-min="18"
                                data-max="99"
                                data-from="<?= $ages[0] ?>"
                                data-to="<?= $ages[1] ?>"
                            />
                        </div><!-- end of range filter -->
                        <div class="aios-gallery-dropdown-filter">
                            <input type="text" name="ethnicity"  placeholder="Ethnicity" value="<?= $params['ethnicity'] ?>">
                              <ul>
                                <li>Any</li>
                                <li>Caucasian</li>
                                <li>Black</li>
                                <li>Hispanic</li>
                                <li>Asian</li></li>
                                <li>Other</li>
                              </ul>
                        </div><!-- end of gallery dropdown -->


                        <div class="aios-gallery-submit-bttn">
                            <input type="submit" value="Search">
                        </div><!-- end of aios gallery submit -->

                    </div><!-- end of form wrap -->

                    <div class="aios-gallery-searc-second">
                        <div class="aios-gallery-form-second-level">
                            <?php
                                foreach ( $procedures as  $procedure){

                                    $html = '';

                                     if ($procedure->parent == 0){

                                        $html .= '<div class="aios-gallery-dropdown-filter-v2">';
                                            $html .= '<div class="aios-gallery-text-wrap">';
                                                $html .= '<span>'.$procedure->name.' <em></em></span>';
                                                $html .= '<input type="text"  placeholder="'.$procedure->name.'" value="" disable id="procedure-datas">';
                                            $html .= '</div>';
                                            $html .= '<ul>';
                                             foreach ( $procedures as $sub_procedure){

                                                   if ($sub_procedure->parent == $procedure->term_id) {
                                                       $html .= '<li data-slug="'.$sub_procedure->slug.'">' . $sub_procedure->name . '</li>';
                                                   }
                                             }
                                          $html .= '</ul>';
                                        $html .= '</div><!-- end of gallery dropdown -->';
                                    }


                                    echo $html;
                                }
                            ?>
                        </div><!-- end of procedure second level -->
                    </div>
                    <div class="aios-gallery-form-third-level">
                        <?php

                            $args = array(
                                'numberposts' => -1,
                                'post_type'   => 'acf-field-group'
                            );

                            $group_fields = get_posts( $args );



                            foreach ( $procedures as $key => $procedure ) {



                                if ($procedure->parent != 0) {


                                    $html  = '';

                                    $html  .= '<div class="aios-gallery-third-level-wrap '.$procedure->slug.'">';
                                        $html .= '<div class="aios-gallery-flex">';
                                        foreach ($group_fields as $group_field) {

                                            if ($procedure->name  == $group_field->post_title){
                                                $fieldGroup = acf_get_field_group($group_field->ID);
                                                $fields = acf_get_fields_by_id($group_field->ID);



                                                foreach ($fields as $field){

                                                    if ( $field['label'] != 'Add Photos' && $field['label'] != 'Description' && $field['label'] != 'Video') {
                                                        if ( !empty($field['choices'])){
                                                        $html .='  <div class="aios-gallery-dropdown-filter">';
                                                            $html .='  <input type="text" name="'.$field['name'].'"  placeholder="'.$field['label'].'" value="'.$params[$field['name']].'">';
                                                            $html .='<ul>';
                                                            foreach ($field['choices'] as $choice){
                                                                $html .= '<li>'.htmlentities($choice).'</li>';
                                                            }
                                                            $html .='</ul>';
                                                        $html .=' </div><!-- end of gallery dropdown -->';

                                                        }
                                                    }

                                                }
                                            }
                                        }

                                        $html .= '</div>';
                                    $html .= '</div>';
                                    echo  $html;

                                }

                            }

                        ?>
                    </div>


                </form>
            </div><!-- end of form container -->
        </div><!-- end of wrapper container -->
    </div><!-- end of search filter -->

    <div class="aios-gallery-container">
            <div class="container container-wide">
                <div class="aios-gallery-lists">
                    <div id="loader">
                        <div class="loader-spinner">
                            <div class="dot1"></div>
                            <div class="dot2"></div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- ajahx will append  html -->
                    </div><!-- end of row -->

                    <?php
                        $posts_per_page = (get_option('posts_per_page')) ? get_option('posts_per_page') : 2;

                        $CountArgs  = array(
                            'post_type' => $post_type,
                            'posts_per_page' => -1,
                            'paged'        => $paged,
                            'post_status' => 'publish',

                        );

                        $all_posts = get_posts($CountArgs);

                        $post_count = count($all_posts);
                        $num_pages = ceil($post_count / $posts_per_page);

                    ?>
                    <div class="aios-gallery-pagination <?= $num_pages > '1' ? '' : 'hide' ?>">
                        <ul>
                            <?php


                                for($p = 1; $p <= $num_pages; $p++){
                                    echo '<li><a href="'.$p.'" data-page="'.$p.'">'.$p.'</a></li>';
                                }
                            ?>
                        </ul>

                    </div>


            </div>


            </div><!-- end of container -->
    </div>
<?php get_footer(); ?>