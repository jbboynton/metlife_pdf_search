<?php

namespace JB\MPS;

use JB\MPS\ParserManager;
use JB\MPS\Helpers;

class Uploader {
  private $post_id;
  private $attachment_id;

  public function __construct($post_id) {
    $this->post_id = $post_id;
  }

  public function save() {
    if ($this->validate()) {
      $this->upload_file();
      return $this->parse();
    }
  }

  private function validate() {
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
    $uploaded_file = $_FILES['mps_pdf_uploader']['name'];

    $filetype_info = wp_check_filetype(basename($uploaded_file));
    $type_of_file = $filetype_info['type'];

    if ($type_of_file == $permitted_filetype) {
      $flag = true;
    }

    return $flag;
  }

  private function upload_file() {
    $this->attachment_id =
      media_handle_upload('mps_pdf_uploader', $this->post_id);

    if (is_wp_error($this->attachment_id)) {
      wp_die('There was an error uploading your file.');
    }
  }

  private function parse() {
    $parser = new ParserManager($this->attachment_id);
    $parser->parse_pdf();
    return $parser->get_parsed_text();
  }
}

