<?php

namespace JB\MPS;

class PDF {

  private $post_id;
  private $pdf_text;

  public function __construct($post_id) {
    $this->post_id = $post_id;
  }

  public function get_pdf_text() {
    return $this->pdf_text;
  }

  public function save() {
    if (!$this->files_present()) {
      /* No files were uploaded, so just continue normally with the save. */
      $saved = true;
    }

    if ($this->is_valid()) {
      $this->upload_pdf();
      $this->update_post_meta();
      $saved = true;
    }

    return $saved;
  }

  private function build_metabox() {
    new MetaBox();
  }

  private function upload_pdf() {
    $uploader = new Uploader($this->post_id);
    $this->pdf_text = $uploader->upload();
  }

  private function update_post_meta() {
    update_post_meta($this->post_id, 'pdf_contents', $this->pdf_text);
  }

  private function is_valid() {
    $valid = false;

    $nonce_verified = $this->verify_nonce();
    $not_autosaving = $this->not_autosaving();
    $files_present = $this->files_present();
    $is_pdf = $this->verify_filetype();

    if ($nonce_verified && $not_autosaving && $files_present && $is_pdf) {
      $valid = true;
    }

    return $valid;
  }

  private function verify_nonce() {
    $nonce = $_POST['mps_nonce'];

    return wp_verify_nonce($nonce, 'save_pdf');
  }

  private function not_autosaving() {
    $flag = true;

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			$flag = false;
    }

    return $flag;
  }

  private function files_present() {
		return (!empty($_FILES['mps_pdf_uploader']['name']));
  }

  private function verify_filetype() {
    $flag = false;
    $permitted_filetype = 'application/pdf';
    $uploaded_filetype = $_FILES['mps_pdf_uploader']['type'];

    if ($permitted_filetype == $uploaded_filetype) {
      $flag = true;
    }

    return $flag;
  }
}

