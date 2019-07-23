<?php

/*
 *
 * FOR PODS FRAMEWORK
 *
 */

function my_date($input_date,$format){
    return date($format, strtotime($input_date));
}

function my_homeurl(){
    return home_url();
}

function my_themeurl(){
    return get_template_directory_uri();
}

function my_post_content($content,$length,$after){
    return mb_substr(wp_strip_all_tags($content),0,$length).$after;
}

