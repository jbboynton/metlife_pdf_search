<?php
/**
 * Plugin Name: MetLife PDF Search
 * Description: Creates a PDF post type for better searchability.
 * Version: 1.0
 * Author: James Boynton
 */

include 'vendor/autoload.php';

require_once plugin_dir_path(__FILE__) . 'src/classes/Activation.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/CustomPostType.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/MetaBox.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/ParserManager.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/PDF.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Uploader.php';

use JB\MPS;
use JB\MPS\Activation;
use JB\MPS\CustomPostType;
use JB\MPS\MetaBox;
use JB\MPS\ParserManager;
use JB\MPS\PDF;
use JB\MPS\Uploader;

use Smalot\PdfParser;

add_action('init', function() {
  CustomPostType::init();
});

register_activation_hook(__FILE__, function() {
	Activation::init();
  flush_rewrite_rules();
});

new Metabox();

