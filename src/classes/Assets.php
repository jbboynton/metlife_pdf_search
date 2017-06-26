<?php

namespace JB\MPS;

use JB\MPS\Config;
use JB\MPS\Helpers;

class Assets {
	public static function init() {
		add_action('wp_enqueue_scripts', array('JB\MPS\Assets', 'registerAssets'), 100);
		add_action('admin_enqueue_scripts', array('JB\MPS\Assets', 'registerAdminAssets'), 100);
	}

	public static function registerAssets() {
		self::registerMainStyles();
		self::registerMainScript();
	}

	public static function registerAdminAssets() {
		wp_enqueue_script('jquery-effects-core');

		self::registerMainStyles();
		self::registerMainScript();
	}

	private static function registerMainStyles() {
		if (Config::assetExists('styles/main.css')) {
			wp_enqueue_style('mps/main.css', Config::assetPath('styles/main.css'), false, null);
		}
	}

	private static function registerMainScript() {
		wp_register_script('mps/main.js', Config::assetPath('scripts/main.js'), ['jquery'], null, true);
		$translation_array = array(
			'ajaxUrl' => admin_url('admin-ajax.php')
		);
		wp_localize_script('mps/main.js', 'METLIFE_PDF_SEARCH', $translation_array);
		wp_enqueue_script('mps/main.js');
	}
}
