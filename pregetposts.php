<?php

function change_posts_per_page($query) {
    if ( is_admin() || ! $query->is_main_query() ){
        return;
    }

    /* カテゴリーページの表示件数を5件にする */
    if ($query->is_category()){

        $query->set( 'posts_per_page', '5' );
        return;
    }

}
add_action( 'pre_get_posts', 'change_posts_per_page' );