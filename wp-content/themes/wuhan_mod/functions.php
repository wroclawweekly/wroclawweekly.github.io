<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '',
        'after_widget' => '<li><div class="hr"></div></li>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));
?>