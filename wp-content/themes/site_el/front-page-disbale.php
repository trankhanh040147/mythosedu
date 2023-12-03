<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
    <!-- Mainsite -->
    <main class="___main_home_page">

        <section class="banners">
        <?php
        if ( have_posts() ) :
            /* Start the Loop */
            while ( have_posts() ) :
                the_post();
                //echo get_the_ID();
                $rows = get_field('hero_banner');
                $home_sub_banner = get_field('home_sub_banner');
                if($rows)
                {
                    echo '<div class="___certificates_slick_lst hero-sliders animate fadeInUp ftco-animated">';

                    foreach($rows as $row)
                    {
                    ?>
                        <div class="___cert_item"><!-- item - 1 -->
                            <div class="___cert_item_img"><img src="<?php echo $row['image'];?>" alt=""></div>
                        </div>
                    
                    <?php
                    }
                    echo '</div>'; //<!-- ./ sliders -->
                }       
            endwhile;

        endif;
        ?>
        </section>

    
        <?php
        // display session logged
        if ( $___IS_LOGGED ) { 
            $__CURRENT_USER = wp_get_current_user();
           // var_dump($__CURRENT_USER->data->display_name);
            ?>
            <section class="logged __bg_white pt-5 pb-3 animate fadeInUp ftco-animated">
                <div class="highligh">
                    <div class="container">
                        <div class="row">
                            <p>Let's get started, <?php echo $__CURRENT_USER->data->display_name;?>!</p>
                        </div>
                    </div>
                </div>
            </section>
        <?php } ?>


        <!------ COURSESLIST -------->
        <?php ?>
        
        <section class="__bg_white pt-4 pb-3 ___cats_tabs_session animate fadeInUp ftco-animated">
            <div class="container">
                <div class="row">
                    <div class="cats">
                    <!-- Box 2 -->
                    <div class="___yl_content_box ___yl_certificates_box ___cats_tabs_box">
                        <!-- . -->
                        <div class="___yl_certificates_tab  __course_tabs">
                            <ul class="nav nav-pills mb-3" id="certificates_Tab" role="tablist">
                                <?php
                                $id = 1;
                                $args = array(
                                            'taxonomy' => 'course-category',
                                            'orderby' => 'name',
                                            'order'   => 'ASC'
                                        );

                                $cats = get_categories($args);

                                foreach($cats as $cat) {
                                    //echo get_category_link( $cat->term_id ) 
                                    //echo  $cat->term_id ."--";
                                    $__clsActive_head = "";
                                    if($id == 1) {
                                        $__clsActive_head = " active";
                                    }
                                ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php echo  $__clsActive_head; ?>" id="pills-<?php echo $cat->term_id; ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-<?php echo  $cat->term_id; ?>"
                                             type="button" role="tab" aria-controls="pills-<?php echo  $cat->term_id; ?>" >
                                             <?php echo $cat->name; ?>
                                        </button>
                                    </li>
                                <?php
                                    $id ++;
                                }
                                ?>
                            </ul>
                            <!------ Tab content -->
                            <div class="tab-content" id="certificates_TabContent">
                        
                                <?php
                                    $idx = 1;
                                    $__clsAct = "";
                                    foreach($cats as $cat) {
                                        //echo get_category_link( $cat->term_id )
                                        if($idx == 1) {
                                            $__clsAct = "show active";
                                        } else {
                                            $__clsAct = "";
                                        }
                                        
                                ?>

                                        <div class="tab-pane fade <?php echo  $__clsAct; ?> " id="pills-<?php echo  $cat->term_id; ?>" role="tabpanel" aria-labelledby="pills-<?php echo  $cat->term_id; ?>-tab">
                                        
                                        <div class="row pt-1 pb-2">
                                            <div class="col-md-6 ">
                                                <h6 class="text-bold"><?php echo $cat->name; ?></h6>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <a href="/courses?course-category=<?php echo $cat->slug; ?>&course-name=<?php echo $cat->name; ?>">View all</a>
                                            </div>
                                        </div>

                                        <div class="___ranking_table_wrap overflow-auto ___custom_scrollbar">
                                                <div class=" __course_slick __slick_slide ">
                                                        
                                                    
                                                            <?php
                                                            $___postsDat = get_posts(array(
                                                                'post_type' => 'courses',
                                                                'tax_query' => array(
                                                                    array(
                                                                    'taxonomy' => 'course-category',
                                                                    'field' => 'term_id',
                                                                    'terms' =>  $cat->term_id)
                                                                ),
																'meta_query'=>[
																	'relation' => 'OR',
																	[
																	  'key' => '_tutor_course_parent',
																	  'compare' => 'NOT EXISTS',
																	],
																	[
																	  'key' => '_tutor_course_parent',
																	  'compare' => '=',
																	  'value' => ''
																	]
																 ])
                                                            );
                                                            //echo $cat->term_id . "::" . count($___postsDat);
                                                            $cntPosts =  count($___postsDat);
                                                            //var_dump($___postsDat);

                                                            for($i=0; $i < $cntPosts; $i++) {
                                                                $url_img = wp_get_attachment_url( get_post_thumbnail_id($___postsDat[$i]->ID), 'thumbnail' ); 
																$courses_categories = get_the_terms($___postsDat[$i]->ID,'course-category');
																$courses_category_first = ($courses_categories && count($courses_categories))?$courses_categories[0]->name:'Uncategory';
																$_tutor_course_start_date = get_post_meta( $___postsDat[$i]->ID, '_tutor_course_start_date', true);
                                                            ?>

                                                                <?php
                                                                if($___postsDat[$i]->post_title != "Auto Draft") {
                                                                ?>
                                                                <!--- render course item -->
                                                               
                                                                <div class="___cert_item __cdetail __border_raiuds_6">
                                                                    
                                                                    <div class="__wishlist"><a href="#"><i class="__ic_heart"></i></a></div>
                                                                    <div class="___cert_item_img"><img src="<?php echo $url_img;?>" alt=""></div>
                                                                    <div class="tutor-d-flex">
																		<span class="__txt_blur"><?php echo $courses_category_first;?></span>
																		<?php
																			$children_ids = get_post_meta( $___postsDat[$i]->ID, '_tutor_course_children', true );
																			$children_ids_arr = array();
																			if($children_ids)
																				$children_ids_arr = explode(" ",trim($children_ids));
																			if (count($children_ids_arr)) {
																		?>
																			<div class="parent_course_icon" style="width:90%;text-align:right">
																				<span class="">
																					<i class="tutor-icon-layer-filled"></i>
																				</span>
																			</div>
																		<?php
																			}
																		?>
																	</div>
                                                                    <div class="___cert_item_title"><a href="/courses/<?php echo $___postsDat[$i]->post_name;?>"><?php echo $___postsDat[$i]->post_title;?></a></div>
                                                                    <div class="___course_date">
                                                                        <?php if($_tutor_course_start_date){?>
																		<i class="_ic_date"></i> <span><?php echo $_tutor_course_start_date;?></span>
																		<?php
																			}
																		?>


                                                                        <?php 
                                                                        $prices = array(
                                                                            'regular_price' => 0,
                                                                            'sale_price'    => 0,
                                                                        );

                                                                        $product_id = $___postsDat[$i]->ID;
                                                                        //echo $product_id;                                                     
                                                                        $price = get_post_meta( $product_id, 'edd_price', true);
                                                                        $price_sale = get_post_meta( $product_id, 'edd_price', true);
                                                                        //echo "--|".$price."--".$price_sale;
                                                                    ?>
                                                                    </div>
                                                                    
                                                                </div>

                                                                <?php
                                                                } // endif Auto Draft
                                                                ?>

                                                            <?php
                                                            }

                                                            
                                                            ?>



                                                </div>
                                            </div>
                                        </div>

                                <?php
                                        $idx ++;
                                    }
                                ?>

                                
                        </div>
                        </div>                                        
                        <!-- . -->
                    </div>
                    <!-- ./ Box 2 -->
                    </div>
                </div><!-- ./ row -->
            </div><!-- ./ container -->
        </section>

        <?php ?>

        
<?php
/*
        <section class="__bg_white pt-4 mt-5 pb-3 animate fadeInUp ftco-animated">
            <div class="container">
                <div class="row">
                    <h6 class="text-bold">SPECIAL COURSES</h6>
                </div>
                <div class="row __courses_grid">
                    <?php
                    //set tag slug
                    $tagSlug = "speacial-courses";
                    $tagName = "SPEACIAL COURSES";
                    use TUTOR\Input;
                    use \TUTOR_REPORT\Analytics;
                    global $wpdb;
$args = array(
  'post_type' => 'courses'
);					
//wpp_get_mostpopular($args);
                    $most_popular_courses	= tutor_utils()->most_popular_courses( $limit = 8 );
                    //var_dump($most_popular_courses);
                    ?>

                    <?php if ( is_array( $most_popular_courses ) && count( $most_popular_courses ) ) : ?>
                        <?php foreach ( $most_popular_courses as $course ) : 

                                $url_img = wp_get_attachment_url( get_post_thumbnail_id($course->ID), 'thumbnail' ); 
                                if($url_img == "") {
                                    $url_img = get_template_directory_uri() . "/dist/img/img_default.jpg";
                                }
								$courses_categories = get_the_terms($course->ID,'course-category');
								$courses_category_first = ($courses_categories && count($courses_categories))?$courses_categories[0]->name:'Uncategory';
								$_tutor_course_start_date = get_post_meta( $course->ID, '_tutor_course_start_date', true);
                        ?>
                        
                            <div class="col-md-3  __border_raiuds_6 __course_box">
                                                                
                                <div class="__wishlist"><a href="#"><i class="__ic_heart"></i></a></div>
                                <div class="___cert_item_img"><img src="<?php echo $url_img;?>" alt=""></div>
                                
                                <div class="tutor-d-flex">
									<span class="__txt_blur"><?php echo $courses_category_first;?></span>
									<?php
										$children_ids = get_post_meta( $course->ID, '_tutor_course_children', true );
										$children_ids_arr = array();
										if($children_ids)
											$children_ids_arr = explode(" ",trim($children_ids));
										if (count($children_ids_arr)) {
									?>
											<div class="parent_course_icon" style="width:90%;text-align:right">
												<span class="">
													<i class="tutor-icon-layer-filled"></i>
												</span>
											</div>
									<?php
										}
									?>
								</div>
                                <div class="___cert_item_title">
                                    <a href="/courses/<?php echo $course->post_name;?>">
                                        <?php echo esc_html( $course->post_title ); ?>
                                    </a>
                                </div>
                                <div class="___course_date">
                                    <?php if($_tutor_course_start_date){?>
																		<i class="_ic_date"></i> <span><?php echo $_tutor_course_start_date;?></span>
																		<?php
																			}
																		?>

                                    <?php 
                                    $prices = array(
                                        'regular_price' => 0,
                                        'sale_price'    => 0,
                                    );

                                    $product_id = $course->ID;
                                    //echo $product_id;                                                     
                                    $price = get_post_meta( $product_id, 'edd_price', true);
                                    $price_sale = get_post_meta( $product_id, 'edd_price', true);
                                    //echo "--|".$price."--".$price_sale;
                                ?>
                                </div>
                                
                            </div>
                            
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        */
        ?>

        <section class="__bg_white pt-4 mt-5 pb-3 animate fadeInUp ftco-animated">
            <div class="container __not_margin_padding">
                <div class="row">
                    <h6 class="text-bold __pl_15">WHY VUS</h6>
                </div>
                <div class="row _bg_grey">
                    <div class="col-md-4 __info_box">
                        <img src="<?php echo get_template_directory_uri() . '/dist/img/_icon_why.svg';?>" class="__max_60">
                        <p class="__txt_bold">Quality Courses from World-Renowned Universities</p>
                    </div>
                    <div class="col-md-4 __info_box">
                        <img src="<?php echo get_template_directory_uri() . '/dist/img/_icon_why.svg';?>" class="__max_60">
                        <p class="__txt_bold">A Life-long learning platform</p>
                    </div>
                    <div class="col-md-4 __info_box">
                        <img src="<?php echo get_template_directory_uri() . '/dist/img/_icon_why.svg';?>" class="__max_60">
                        <p class="__txt_bold">Develop Career Skills Training system</p>
                    </div>
                </div>
            </div>
        </section>

        <?php
        /*
        <section class="__bg_white mt-3 mb-4 pb-3 animate fadeInUp ftco-animated">
            <div class="container">
                <div class="row mb-5">
                    <h6 class="text-bold">HOW it works?</h6>
                </div>
                <div class="row ">
                    <div class="col-md-6">
                        <ul class="__list_circl">
                            <li>
                                <div class="__number">
                                    <span class="__number_item">1</span>
                                </div>
                                <p class="__title">Take online courses by industry experts</p>
                                <p class="__desc">Lessons are self-paced so you’ll never be late for class or miss a deadline.</p>
                            </li>
                            <li>
                                <div class="__number"><span class="__number_item">2</span></div>
                                <p class="__title">Get a Course Certificate</p>
                                <p class="__desc">Your answers are graded by experts, not machines. Get an industry-recognized Course Certificate to prove your skills.</p>
                            </li>
                            <li>
                                <div class="__number"><span class="__number_item">3</span></div>
                                <p class="__title">Advance your career</p>
                                <p class="__desc">Use your new skills in your existing job or to get a new job in UX design. Get help from our community.</p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                    <img src="<?php echo get_template_directory_uri() . '/dist/img/img_cerf.png';?>" class="_bor_rad_8">
                    </div>
                </div>
            </div>
        </section>
        */
        ?>

    </main>
    <!-- ./ Mainsite -->

<?php
get_footer();