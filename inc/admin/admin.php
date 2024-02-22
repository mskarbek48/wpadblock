<?php
/**
 * AdBlockProof Admin Dashboard
 *
 * Class for admin dashboard
 *
 * @package mskarbek\wpabp
 * @version 1.0.0
 */
namespace mskarbek\wpabp;

defined( 'ABSPATH' ) or exit;

class Admin {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		add_action('admin_menu', array($this, 'adminPanelMenuAdd'));
		add_action('admin_init', array($this, 'adminSettings'));
	}


	/**
	 * adminSettings
	 *
	 * Prepare settings for admin
	 *
	 * @return void
	 */
	public function adminSettings(): void
	{
		add_settings_section(
			"abp-main",
			"Main settings",
			array($this, "renderSectionView"),
			"abp-settings"
		);


		add_settings_field(
			"abp-box-html",
			__("Set the message in HTML", "abp-box-html-message"),
			array($this, "renderBoxMessage"),
			"abp-settings",
			"abp-main",
			array("abp-box-html", __("Modal, when someone using adblock", "abp-adblock-default-text"))
		);

		register_setting('abp-settings', "abp-box-html");

	}



	public function renderSectionView($args): void
	{

	}

	/**
	 * renderBoxMessage
	 *
	 * Render WP editor used to edit modal box
	 *
	 * @param $args
	 *
	 * @return void
	 */
	public function renderBoxMessage($args): void
	{
		$content = get_option($args[0]);
		wp_editor( $content, $args[0], array(
			'textarea_name' => $args[0],
			'media_buttons' => true,
		) );
	}


	/**
	 * adminPanelMenuAdd
	 *
	 * Adding menu to admin panel
	 *
	 * @return void
	 */
	public function adminPanelMenuAdd(): void
	{
		add_menu_page(
			__("AdBlockProof", "adblock-proof"),
			__("AdBlockProof", "adblock-proof"),
			"edit_plugins",
			__("AdBlockProof", "adblock-proof"),
			array($this, "renderAdminView"),
			"dashicons-admin-generic"
		);
	}

	/**
	 * renderAdminView
	 *
	 * Rendering frontend of admin panel
	 *
	 * @return void
	 */
	public function renderAdminView()
	{
		echo '<div class="wrap"><h1 class="wp-heading-inline">'.__("AdBlockProof", "adblock-proof").' - '.__("Settings", "settings").'</h1><form action="options.php" method="post">';
		settings_fields('abp-settings');
		do_settings_sections('abp-settings');
		submit_button();
		echo '</div></form>';
	}

}
