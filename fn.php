<?php

//親カテゴリーIDから全ての子カテゴリーIDを取得
function get_category_id($parent_id){
    $parent_cat_id = $parent_id;
    $categories = get_term_children($parent_cat_id, 'category');
    array_push($categories, $parent_cat_id);
    asort($categories);
    $arg_categories = implode(",", $categories);
    return $arg_categories;
}

//個別ページネーション
function single_pagination($before_text,$next_text){
    if(!is_single()) return;
    ?>
    <div class="pagination">
        <?php previous_post_link('%link', $before_text, TRUE, ''); ?>
        <?php next_post_link('%link', $next_text, TRUE, ''); ?>
    </div>
    <?php
}

//一覧ページ大見出し
function page_title(){

    $id;
    $tax_slug;
    $page_title = '';

    if(is_category()){
        $tax_slug = "category";
        $id = get_query_var('cat');
        $category = get_term($id,$tax_slug);
        $page_title .= $category->name;
        $parent_id = $category->parent;
        if($parent_id){
            $category = get_term($parent_id,$tax_slug);
            $page_title .= "(".$category->name.")";
        }
    }else if(is_tag()){
        $tax_slug = "post_tag";
        $id = get_query_var('tag_id');
        $tag = get_term($id,$tax_slug);
        $page_title = $tag->name;
    }else if(is_tax()){
        $tax_slug = get_query_var('taxonomy');
        $term_slug = get_query_var('term');
        $term = get_term_by("slug",$term_slug,$tax_slug);
        $id = $term->term_id;
        $taxonomy = get_term($id,$tax_slug);
        $page_title = $taxonomy->name;
    }

    return $page_title;

}











