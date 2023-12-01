<?php
/**
 * The template for displaying all single page
 * @since 1.0.0
 */
get_header();
?>

    <main id="main" class="site-main page">
        <div class="container">
            <div class="row pt-5 pb-5 pl-3 pr-3 center sign_in">
                
                <h1><?php echo _e('Sign up');?></h1>
                <p class="__logsub">Please fill your information below</p>
                <?php

                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();
                ?>
                
                
                <?php
                    the_content();

                endwhile; // End of the loop.
                ?>
            </div>
        </div>
    </main><!-- #main -->

<?php
get_footer();
