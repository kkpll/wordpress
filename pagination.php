<?php

//ページネーション設定
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
        $query->set( 'posts_per_page',get_option('posts_per_page'));
    }
}
add_action('pre_get_posts', 'change_posts_per_page' );

//ページネーション関数（シングル）
function single_pagination(){
    if(!is_single()) return;
    ?>
    <div class="pagination">
        <?php previous_post_link('%link', '«　前の記事へ移動する', TRUE, ''); ?>
        <?php next_post_link('%link', '次の記事へ移動する　»', TRUE, ''); ?>
    </div>
    <?php
}

//aタグにクラスを付ける
add_filter( 'previous_post_link', 'add_prev_post_link_class' );
function add_prev_post_link_class($output) {
    return str_replace('<a href=', '<a class="prev" href=', $output);
}
add_filter( 'next_post_link', 'add_next_post_link_class' );
function add_next_post_link_class($output) {
    return str_replace('<a href=', '<a class="next" href=', $output);
}

