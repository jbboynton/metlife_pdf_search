<?php

/**
 * Plugin Name: MetLife PDF Search 
 * Description: Creates a PDF post type for better searchability.
 * Version: 0.1
 * Author: James Boynton
 * License: GPL2
 */

require_once plugin_dir_path(__FILE__) . 'src/classes/Config.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Helpers.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Activation.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/JsonManifest.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Assets.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/ShortcodePDFSearch.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Updater.php';

use JB\Plugin;
use JB\Plugin\JsonManifest;
use JB\Plugin\Config;
use JB\Plugin\Assets;
use JB\Plugin\Activation;
use JB\Plugin\ShortcodePDFSearch;

add_action('init', function () {
	$paths = [
		'dir.plugin' => plugin_dir_path(__FILE__),
		'uri.plugin' => plugins_url(null, __FILE__)
	];

	$manifest = new JsonManifest("{$paths['dir.plugin']}dist/assets.json", "{$paths['uri.plugin']}/dist");
	Config::setManifest($manifest);

	Assets::init($manifest);
	ShortcodePDFSearch::init();

	define('WP_GITHUB_FORCE_UPDATE', true);

	if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin
		$config = array(
			'slug' => plugin_basename(__FILE__),
			'proper_folder_name' => 'metlife_pdf_search',
			'api_url' => 'https://api.github.com/repos/jbboynton/metlife_pdf_search',
			'raw_url' => 'https://raw.github.com/jbboynton/metlife_pdf_search/master',
			'github_url' => 'https://github.com/jbboynton/metlife_pdf_search',
			'zip_url' => 'https://github.com/jbboynton/metlife_pdf_search/archive/master.zip',
			'sslverify' => true,
			'requires' => '3.0', //version of wordpress that is required
			'tested' => '3.3', //version of wordpress udated to
			'readme' => 'README.md', //readme file
			'access_token' => '',
		);
		new GithubUpdater($config);
	}
});

register_activation_hook(__FILE__, function () {
	Activation::init();
});
 
