<?php

namespace JB\MPS;

use \Smalot\PdfParser\Parser;
use \Smalot\PdfParser\Font;

class ParserManager {

  private $pdf_path;
  private $parser;
  private $parsed_text;

  public function __construct($attachment_id) {
    $this->pdf_path = get_attached_file($attachment_id);
    $this->parser = new \Smalot\PdfParser\Parser();
  }

  public function parse_pdf() {
    $pdf = $this->parser->parseFile($this->pdf_path);
    $this->parsed_text = $pdf->getText();
  }

  public function get_parsed_text() {
    return $this->parsed_text;
  }
}
