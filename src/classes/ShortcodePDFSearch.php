<?php

namespace JB\Plugin;

class ShortcodePDFSearch {
	public static function init() {
		add_shortcode('mps_search', array('JB\Plugin\ShortcodePDFSearch', 'render'));
	}

	public static function render($args, $content = "") {
		ob_start();
		include_once(plugin_dir_path(dirname(__FILE__)) . 'templates/shortcode_pdf_search.php');
		$output = ob_get_clean();
		ob_end_clean();

		// output the results
		return force_balance_tags($output);
	}
}
