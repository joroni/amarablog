<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
   
}




function wpdocs_custom_excerpt_length( $length ) {
    return 10;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

add_action( 'admin_footer-post.php', 'only_allow_one_checkbox' );
add_action( 'admin_footer-post-new.php', 'only_allow_one_checkbox' );

function only_allow_one_checkbox()
{
    global $post_type;

    if ( 'post' != $post_type )
        return;
    ?>
        <script type="text/javascript">
            $('#categorychecklist>li>label input').change(function() {
                if(this.checked) {
                    $('#categorychecklist>li>label input').prop("checked", false);
                    $(this).prop("checked", true);
                }
            });
        </script>
    <?php
}
// Changing excerpt length
/* function new_excerpt_length($length) {
   return 20;
   }
   add_filter('excerpt_length', 'new_excerpt_length');
     */



     