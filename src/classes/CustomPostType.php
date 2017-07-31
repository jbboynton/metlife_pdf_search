<?php

namespace JB\MPS;

class CustomPostType {

  public static function init() {

    $labels = array(
      'name' => 'PDFs',
      'singular_name' => 'PDF',
      'menu_name' => 'PDFs',
      'name_admin_bar' => 'PDF',
      'add_new' => 'Add New',
      'add_new_item' => 'Add New PDF',
      'new_item' => 'New PDF',
      'edit_item' => 'Edit PDF',
      'view_item' => 'View PDF',
      'all_items' => 'All PDFs',
      'search_items' => 'Search PDFs',
      'parent_item_colon' => 'Parent PDFs:',
      'not_found' => 'No PDFs found.',
      'not_found_in_trash' => 'No testimonials found in Trash.'
    );

    $taxonomies = array(
      'applicable_products',
      'agent_channel',
      'appointed_state'
    );

    $supports = array(
      'title',
      'author',
      'thumbnail',
      'excerpt'
    );

    $args = array(
      'labels' => $labels,
      'public' => true,
      'exclude_from_search' => false,
      'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 12,
      'menu_icon' => 'dashicons-format-aside',
      'query_var' => true,
      'rewrite' => array('slug' => 'pdf'),
      'capability_type' => 'post',
      'taxonomies' => $taxonomies,
      'has_archive' => true,
      'heirarchical' => false,
      'supports' => $supports
    );

    register_post_type('pdf', $args);
  }
}

