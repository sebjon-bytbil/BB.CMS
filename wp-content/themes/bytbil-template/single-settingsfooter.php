<?php
get_header('clean');

while (have_posts()) : the_post();
    the_content();
endwhile;

get_footer('clean');
?>
