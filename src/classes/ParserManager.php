<?php

namespace JB\MPS;

class ParserManager {

  private $pdf_path;
  private $parser;

  public function __construct($attachment_id) {
    $this->pdf_path = get_attached_file($attachment_id);
    $this->parser = new \Smalot\PdfParser\Parser();
  }

  public function parse_pdf() {
    $pdf = $this->parser->parseFile($this->pdf_path);

    return $pdf->getText();
  }
}
