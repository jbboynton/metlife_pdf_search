<?php

namespace JB\MPS;

class MetaBox {

  private $post_types;
  private $pdf_text;

  public function __construct($post_types = array('pdf')) {
    $this->post_types = $post_types;
    add_action('post_edit_form_tag', array($this, 'add_enctype'));
    add_action('add_meta_boxes', array($this, 'add_meta_box'));
    add_action('save_post', array($this, 'save'));
    add_action('admin_notices', array($this, 'invalid'));
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
    if (!$this->is_pdf_post($post_id)) {
      return;
    }

    $pdf = new PDF($post_id);

    if ($pdf->save()) {
      $text = $pdf->get_pdf_text();

      remove_action('save_post', array($this, 'save'));

      wp_update_post(array(
        'ID' => $post_id,
        'post_content' => $text
      ));

      add_action('save_post', array($this, 'save'));
    } else {
      $this->create_save_error();
    }
  }

  private function is_pdf_post($id) {
    return (get_post_type($id) == 'pdf' ? true : false);
  }

  private function create_save_error() {
    $error = new \WP_Error('save_failed', $message);
    add_filter('redirect_post_location', function ($location) use ($error) {
      return add_query_arg('mps_error', $error->get_error_code(), $location);
    });
  }

  public function invalid() {
    if (array_key_exists('mps_error', $_GET)) {
      $message = "PDF could not be saved. Please make sure the file you are " .
        "trying to upload is a PDF document, and has a <code>.pdf</code> " .
        "extension.";
      ?>
        <div class="notice notice-error is-dismissible">
          <p><?php echo $message; ?></p>
        </div>
      <?php
    }
  }
}

