<?php

//PODS FRAMEWORK
function my_date($input_date) {
    return date("Y年m月d日", strtotime($input_date));
}

function my_homeurl(){
    return home_url();
}

function my_themeurl(){
    return get_template_directory_uri();
}

function my_post_content($content){
    return mb_substr(wp_strip_all_tags($content),0,150)."...";
}