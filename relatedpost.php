<?php
function add_related_posts( $content ){

    global $post;

    $output = '';

    if (is_single()){
        $post_type = get_post_type();
        //$post_type_object = get_post_type_object(get_post_type());
        if($post_type) {
            if($post_type == "post"){
                $categories = get_the_category();
                //$related_post_name = $categories[0]->cat_name;
                $related_posts = get_posts(array('category__in' => array($categories[0]->cat_ID), 'exclude' => $post->ID, 'numberposts' => -1));
            }else{
                //$related_post_name = esc_html($post_type_object->labels->singular_name);
                $related_posts = get_posts(array('post_type' => $post_type, 'exclude' => $post->ID ,'numberposts' => -1));
            }
        }

        if($related_posts){
            $output .= "<ul class='related-posts'>";
            $output .= "<h2 class='related-posts__title'>関連記事はこちら</h2>";
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
                $output .= "<h2>関連ページはこちら</h2>";
                $output .= "<ul class='related-post-list'>".$children."</ul>";
            }
        }
    }

    $content .= $output;
    return $content;
}
add_filter( 'the_content', 'add_related_posts' );
