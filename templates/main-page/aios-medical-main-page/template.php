<?php get_header();
    $params = $_GET;

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
                <form action="<?= site_url()?>/gallery" method="get">
                    <input type="hidden" name="page" value="<?= $params['page'] ?>" id="paginate-value">
                    <input type="hidden" name="sorts" value="<?= $params['sorts'] ?>" id="sort">
                    <div class="aios-gallery-form-wrap">
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
                       <div class="aios-gallery-dropdown-filter">
                              <input type="text" name="procedure_types"  placeholder="Procedure" value="<?= $params['procedure_types'] ?>">
                              <ul>
                                <li>All</li>
                                <li>Rhinoplasty</li>
                                <li>Face</li>
                                <li>Liposuction</li>
                                <li>Breast Augmentation</li>
                              </ul>
                        </div><!-- end of gallery dropdown -->

                        <div class="aios-gallery-submit-bttn">
                            <input type="submit" value="Search">
                        </div><!-- end of aios gallery submit -->

                        <div class="aios-more-option">
                            <span>MORE <br>OPTIONS</span>
                        </div>

                    </div><!-- end of form wrap -->
                    <div class="aios-gallery-form-more-wrap">

                        <div class="aios-gallery-more-wrap breast-augmentation">

                            <div class="aios-gallery-dropdown-filter">
                                  <input type="text" name="breast_augmentation_cup_size_pre-op"  placeholder="CUP SIZE PRE-oP" value="">
                                  <ul>
                                    <li>All</li>
                                    <li>CUP A</li>
                                    <li>CUP A</li>
                                    <li>CUP A</li>
                                    <li>CUP DD/E</li>
                                  </ul>
                            </div><!-- end of gallery dropdown -->
                            <div class="aios-gallery-dropdown-filter">
                                  <input type="text" name="breast_augmentation_cup_size_post-op"  placeholder="CUP SIZE POST-OP" value="">
                                  <ul>
                                    <li>All</li>
                                    <li>CUP A</li>
                                    <li>CUP A</li>
                                    <li>CUP A</li>
                                    <li>CUP DD/E</li>
                                  </ul>
                            </div><!-- end of gallery dropdown -->
                            <div class="aios-gallery-dropdown-filter">
                                  <input type="text" name="breast_augmentation_implant_size_in_ml"  placeholder="IMPLANT SIZE IN ML" value="">
                                  <ul>
                                    <li>All</li>
                                    <li>50 ML</li>
                                    <li>100 ML</li>
                                    <li>150 ML</li>
                                    <li>200 ML</li>
                                  </ul>
                            </div><!-- end of gallery dropdown -->
                            <div class="aios-gallery-checkbox-filter">
                                <span>IMPLANT TYPE</span>
                                <div class="aios-checkbox-sets">
                                   <div class="form-group">
                                        <input class="styled-checkbox" name="breast_augmentation_implant_typeRadio" id="breast_augmentation_implant_typeRadio" type="checkbox" value="male">
                                        <label for="styled-checkbox-1">Saline</label>
                                    </div>
                                    <div class="form-group">
                                        <input class="styled-checkbox" name="breast_augmentation_implant_typeRadio" id="breast_augmentation_implant_typeRadio" type="checkbox" value="female">
                                        <label for="styled-checkbox-1">SIlicone</label>
                                    </div>
                                </div>
                            </div><!-- end of checkbox filter -->

                        </div><!-- end of gallery more wrap -->


                    </div><!-- end of form more wrap -->


                </form>
            </div><!-- end of form container -->
        </div><!-- end of wrapper container -->
    </div><!-- end of search filter -->

    <div class="aios-gallery-container">
            <div class="container container-wide">
                <h3><span>CASE</span>GALLERY</h3>
                <div class="aios-gallery-content-filter">
                    <form action="#" method="get">
                        <div class="aios-producedure-filter">

                             <div class="aios-gallery-checkbox-filter">
                                 <div class="aios-checkbox-sets">
                                    <div class="form-group">

                                        <input class="styled-checkbox" name="face" id="face" type="checkbox" value="" <?= ( $params['procedure_types'] == 'NULL' ? 'checked' : '' ) ?>>
                                        <label for="styled-checkbox-1">All</label>
                                    </div>
                                    <div class="form-group">
                                        <input class="styled-checkbox" name="face" id="face" type="checkbox" value="face" <?= ( $params['procedure_types'] == 'face' ? 'checked' : '' ) ?>>
                                        <label for="styled-checkbox-1">Face</label>
                                    </div>
                                    <div class="form-group">
                                        <input class="styled-checkbox" name="liposuction" id="liposuction" type="checkbox" value="liposuction" <?= ( $params['procedure_types'] == 'liposuction' ? 'checked' : '' ) ?>>
                                        <label for="styled-checkbox-1">Liposuction</label>
                                    </div>
                                    <div class="form-group">
                                        <input class="styled-checkbox" name="breastaugmentatio" id="breastaugmentation" type="checkbox" value="breastaugmentation" <?= ( $params['procedure_types'] == 'breastaugmentation' ? 'checked' : '' ) ?>>
                                        <label for="styled-checkbox-1">Breast Augmentation</label>
                                    </div>
                                    <div class="form-group">
                                        <input class="styled-checkbox" name="rhinoplasty" id="rhinoplasty" type="checkbox" value="rhinoplasty" <?= ( $params['procedure_types'] == 'rhinoplasty' ? 'checked' : '' ) ?>>
                                        <label for="styled-checkbox-1">Rhinoplasty</label>
                                    </div>
                                 </div>

                                 <div class="aios-sort-by">
                                     <select name="#" id="#">
                                         <option value="">All</option>
                                         <option value="ASC" <?= ( $params['sorts'] == 'ASC' ? 'selected' : '' ) ?>>ascending </option>
                                         <option value="DESC" <?= ( $params['sorts'] == 'DESC' ? 'selected' : '' ) ?>>descending </option>
                                     </select>
                                 </div>

                            </div><!-- end of checkbox filter -->

                        </div><!-- end of procedure filter -->
                    </form>

                </div><!-- end of container filter -->


                <div class="aios-gallery-lists">
                    <div class="row">
                        <?php

                            $meta_query = array(
                                'relation' => 'AND'
                            );


                            foreach ($params as $key => $param){
                                if ($key != 'page' && $key != 'sorts'){
                                    if ($param != 'Any' && $param != 'All' ){

                                        if ($key == 'age'){
                                            $ages = explode(",", $param);

                                            $meta_query[] = array(
                                                 'key'     => $key,
                                                 'value'   => $ages[0],
                                                 'compare' => '>=',
                                                 'type'    => 'NUMERIC',
                                            );
                                            $meta_query[] = array(
                                                 'key'     => $key,
                                                 'value'   => $ages[1],
                                                 'compare' => '<=',
                                                 'type'    => 'NUMERIC',
                                            );

                                        }else{
                                            $meta_query[] = array(
                                                'key'=> $key,
                                                'compare'=>'=',
                                                'value'=> $param
                                            );
                                        }
                                    }
                                }
                            }


                            //what pagination page are we on?
                            if(! empty($params['page']) && is_numeric($params['page']) ){
                                $paged = $params['page'];
                            }else{
                                $paged = 1;
                            }

                            $post_type = 'gallery';
                            $posts_per_page = (get_option('posts_per_page')) ? get_option('posts_per_page') : 2;

                            $CountArgs  = array(
                                'post_type' => $post_type,
                                'posts_per_page' => -1,
                                 'paged'        => $paged,
                            );

                            $all_posts = get_posts($CountArgs);

                            $post_count = count($all_posts);
                            $num_pages = ceil($post_count / $posts_per_page);

                            // args
                            $args = array(
                                'post_type' => $post_type,
                                'posts_per_page' => $posts_per_page,
                                 'paged'        => $paged,
                                'meta_query'=>$meta_query,
                                'orderby'          => 'date',
                                'order'            => $params['sorts'],
                            );

                            // query
                            $the_query = new WP_Query( $args );

                            ?>
                            <?php if( $the_query->have_posts() ): ?>
                                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                                <?php
                                    // Variables
                                    $case_number = get_field( 'case_number' );
                                    $procedure = get_field( 'procedure_types' );
                                    $gender = get_field( 'gender' );
                                    $age = get_field( 'age' );
                                    $ethnicity = get_field( 'ethnicity' );

                                    $slideshow = get_field( 'slideshow' );
                                    $before   = $slideshow[0]['before']['image']['ID'];
                                    $after   = $slideshow[0]['after']['image']['ID'];
                                ?>
                                   <div class="col-md-4 aios-gallery-list">
                                        <div class="aios-gallery-wrap">


                                            <div class="aios-gallery-image">
                                                <?php if(!empty($before)) : ?>
                                                <canvas width="442" height="329" style="background-image: url(<?=wp_get_attachment_url($before) ?>)"></canvas>
                                                <?php elseif( !empty($after)) : ?>
                                                <canvas width="442" height="329" style="background-image: url(<?=wp_get_attachment_url($after) ?>)"></canvas>

                                                <?php else : ?>
                                                 <canvas width="442" height="329" style="background-image: url(<?= get_stylesheet_directory_uri()?>/filterable-gallery-templates/main-page/aios-medical-main-page/assets/images/no-preview.jpg)"></canvas>

                                                <?php endif ?>
                                                <?php if ( !empty($after) && !empty($before) ) : ?>

                                                <div class="img-comp-container">
                                                    <div class="img-comp-img">
                                                    <canvas width="442" height="329" style="background-image: url(<?=wp_get_attachment_url($after) ?>)"></canvas>
                                                    </div>
                                                    <div class="img-comp-img img-comp-overlay">
                                                    <canvas width="442" height="329" style="background-image: url(<?=wp_get_attachment_url($before) ?>)"></canvas>
                                                    </div>
                                                </div>
                                                <?php endif ?>
                                            </div>


                                            <div class="aios-gallery-content">
                                                <a href="<?= the_permalink() ?>">
                                                    <span>CASE NO: <?= $case_number ?></span>
                                                    <h4><?= $procedure ?></h4>
                                                    <ul>
                                                        <li><strong>GENDER:</strong> <?= $gender ?></li>
                                                        <li><strong>AGE:</strong> <?= $age ?></li>
                                                        <li><strong>ETHNICITY:</strong> <?= $ethnicity ?></li>
                                                    </ul>
                                                    <em>View</em>
                                                </a>
                                            </div>
                                        </div>
                                    </div><!-- end of gallery list -->
                                <?php endwhile; ?>
                              <?php else: ?>
                                <?php echo '<div class="gallery-no-posts">no Case found</div>' ?>
                            <?php endif; ?>


                            <?php wp_reset_query();	 // Restore global post data stomped by the_post().
                        ?>
                </div><!-- end of row -->
                    
                <div class="aios-gallery-pagination">
                    <ul>
                        <?php

                            for($p = 1; $p <= $num_pages; $p++){

                                if ($params['page'] == $p ){
                                 echo '<li><a  class="active" href="'.$p.'" data-page="'.$p.'">'.$p.'</a></li>';
                                }else{
                                     echo '<li><a href="'.$p.'" data-page="'.$p.'">'.$p.'</a></li>';
                                }


                            }
                        ?>
                    </ul>

                </div>


            </div>


            </div><!-- end of container -->
    </div>
<?php get_footer(); ?>