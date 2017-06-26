<?php

namespace JB\MPS;

use JB\MPS\Uploader;

class MetaBox {
  private $post_types = array();
  private $pdf_text = '';

  public function __construct($post_types = array('pdf')) {
    $this->post_types = $post_types;
    add_action('post_edit_form_tag', array($this, 'add_enctype'));
    add_action('add_meta_boxes', array($this, 'add_meta_box'));
    add_action('save_post', array($this, 'save'));
  }

  public function add_enctype() {
    echo ' enctype="multipart/form-data"';
  }

  public function add_meta_box($post_types) {
    add_meta_box(
      'mps_pdf_uploader',
      'Upload a PDF',
      array($this, 'callback'),
      $this->post_types,
      'normal',
      'high'
    );
  }

  public function callback() {
    ob_start();
    include(plugin_dir_path(dirname(__FILE__)) . 'templates/metabox.php');
    $output = ob_get_contents();
    ob_end_clean();

    echo $output;
  }

  public function save($post_id) {
    $uploader = new Uploader($post_id);
    $pdf_text = $uploader->save();
    update_post_meta($post_id, 'pdf_contents', $pdf_text);
    remove_action('save_post', array($this, 'save'));
    wp_update_post(array(
      'ID' => $post_id,
      'post_content' => $pdf_text
    ));
    add_action('save_post', array($this, 'save'));
  }
}
