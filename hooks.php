<?php

/*
 *
 * functions.phpで読み込むこと
 *
 */


//ページネーション設定（WP-PageNavi用）
function change_posts_per_page($query) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    $taxonomies = get_taxonomies(array('_builtin'=>false));
    $my_taxonomies = array();
    foreach($taxonomies as $taxonomy){
        array_push($my_taxonomies,$taxonomy);
    }

    $categories = get_categories();
    $my_categories = array();
    foreach($categories as $category){
        array_push($my_categories,$category->slug);
    }

    $posttypes = get_post_types(array('_builtin'=>false));
    $my_posttypes = array();
    foreach($posttypes as $posttype){
        array_push($my_posttypes,$posttype);
    }

    if( $query->is_category($my_categories) || $query->is_tax($my_taxonomies) || $query->is_post_type_archive($my_posttypes)){
        $query->set('posts_per_page',get_option('posts_per_page'));
    }
}
add_action('pre_get_posts', 'change_posts_per_page' );

//関連ページ出力
function add_related_posts( $content ){

    global $post;

    $output = '';

    if (is_single()){
        $post_type = get_post_type();
        $post_type_object = get_post_type_object(get_post_type());
        if($post_type) {
            if($post_type == "post"){
                $categories = get_the_category();
                $related_post_name = $categories[0]->cat_name;
                $related_posts = get_posts(array('category__in' => array($categories[0]->cat_ID), 'exclude' => $post->ID, 'numberposts' => -1));
            }else{
                $related_post_name = esc_html($post_type_object->labels->singular_name);
                $related_posts = get_posts(array('post_type' => $post_type, 'exclude' => $post->ID ,'numberposts' => -1));
            }
        }

        if($related_posts){
            $output .= "<ul class='related-posts'>";
            $output .= "<h2 class='related-posts__title'>「".$related_post_name."」の関連記事はこちら</h2>";
            foreach($related_posts as $related_post){
                $output .= "<li><a href='".get_permalink($related_post->ID)."'>".$related_post->post_title."</a></li>";
            }
            $output .= "</ul>";
        }
    }elseif(is_page()){
        if(!is_page('contact') && !is_page('confirm') && !is_page('thanks')){
            if($post->post_parent ){
                $children = wp_list_pages( "title_li=&child_of=".$post->post_parent."&echo=0&exclude=".$post->ID);
            }else{
                $children = wp_list_pages( "title_li=&child_of=".$post->ID."&echo=0&exclude=".$post->ID );
            }
            if($children){
                $output .= "<ul class='related-posts'><h2>「".$post->post_title."」の関連ページはこちら</h2>".$children."</ul>";
            }
        }
    }

    $content .= $output;
    return $content;
}
add_filter( 'the_content', 'add_related_posts' );




