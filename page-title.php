<?php

function archive_page_title(){

    $id = '';
    $tax_slug = '';
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


