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

  public function upload() {
    $this->attachment_id =
      media_handle_upload('mps_pdf_uploader', $this->post_id);

    if (is_wp_error($this->attachment_id)) {
      wp_die('There was an error uploading your file.');
    }

    return $this->parse();
  }

  private function parse() {
    $parser = new ParserManager($this->attachment_id);
    return $parser->parse_pdf();
  }
}

