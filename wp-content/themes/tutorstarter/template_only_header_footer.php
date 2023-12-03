<?php 
/* 
** Template Name: template_only_header-footer
*/ 
get_header("iframe");
?>

<?php

/* Start the Loop */
while ( have_posts() ) :
  the_post();

  the_content();

endwhile; // End of the loop.
?>
<?php
get_footer("iframe");