<?php
/**
 * Divi Settings
 *
 * @package RSFV_Pro
 */

namespace RSFV\Compatibility\Plugins\Divi;

use RSFV\Plugin;
use RSFV\Settings\Settings_Page;
use RSFV\Settings\Admin_Settings;

if ( ! class_exists( '\RSFV\Settings\Admin_Settings' ) ) {
	return;
}

defined( 'ABSPATH' ) || exit;

/**
 * Integrations controls.
 */
class Settings extends Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'divi';
		$this->label = __( 'Divi', 'rsfv' );

		parent::__construct();
	}

	/**
	 * Get sections.
	 *
	 * @return array
	 */
	public function get_sections() {
		return apply_filters( 'rsfv_get_sections_' . $this->id, array() );
	}

	/**
	 * Get settings array.
	 *
	 * @param string $current_section Current section ID.
	 *
	 * @return array
	 */
	public function get_settings( $current_section = '' ) {
		global $current_section;

		$settings = array();

		if ( '' === $current_section ) {
			$settings = array();

			if ( ! Plugin::get_instance()->has_pro_active() ) {
				$settings = array_merge(
					$settings,
					array(
						array(
							'type' => 'title',
							'id'   => 'rsfv_pro_divi_woocommerce_title',
						),
						array(
							'title'   => __( 'Featured Video for Divi Woo Product Images', 'rsfv' ),
							'desc'    => __( 'When toggled on, it shows Featured Product Videos in Divi Woo Product Images Module/Widget. Turn it off if you\'re having problem with WooCommerce templates.', 'rsfv' ),
							'id'      => 'promo-has-divi-woo-featured_video',
							'default' => false,
							'type'    => 'promo-checkbox',
						),
						array(
							'type' => 'sectionend',
							'id'   => 'rsfv_pro_divi_woocommerce_title',
						),
					)
				);
			}

			$settings = apply_filters(
				'rsfv_' . $this->id . '_settings',
				$settings
			);
		}

		return apply_filters( 'rsfv_get_settings_' . $this->id, $settings );
	}

	/**
	 * Save settings.
	 */
	public function save() {
		global $current_section;

		$settings = $this->get_settings( $current_section );

		Admin_Settings::save_fields( $settings );
		if ( $current_section ) {
			do_action( 'rsfv_update_options_' . $this->id . '_' . $current_section );
		}
	}
}

return new Settings();
