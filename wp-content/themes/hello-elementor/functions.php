<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '2.4.1' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_load_textdomain', [ true ], '2.0', 'hello_elementor_load_textdomain' );
		if ( apply_filters( 'hello_elementor_load_textdomain', $hook_result ) ) {
			load_theme_textdomain( 'hello-elementor', get_template_directory() . '/languages' );
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_register_menus', [ true ], '2.0', 'hello_elementor_register_menus' );
		if ( apply_filters( 'hello_elementor_register_menus', $hook_result ) ) {
			register_nav_menus( [ 'menu-1' => __( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => __( 'Footer', 'hello-elementor' ) ] );
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_add_theme_support', [ true ], '2.0', 'hello_elementor_add_theme_support' );
		if ( apply_filters( 'hello_elementor_add_theme_support', $hook_result ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style( 'classic-editor.css' );

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support( 'align-wide' );

			/*
			 * WooCommerce.
			 */
			$hook_result = apply_filters_deprecated( 'elementor_hello_theme_add_woocommerce_support', [ true ], '2.0', 'hello_elementor_add_woocommerce_support' );
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', $hook_result ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		$enqueue_basic_style = apply_filters_deprecated( 'elementor_hello_theme_enqueue_style', [ true ], '2.0', 'hello_elementor_enqueue_style' );
		$min_suffix          = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( apply_filters( 'hello_elementor_enqueue_style', $enqueue_basic_style ) ) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_register_elementor_locations', [ true ], '2.0', 'hello_elementor_register_elementor_locations' );
		if ( apply_filters( 'hello_elementor_register_elementor_locations', $hook_result ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( is_admin() ) {
	require get_template_directory() . '/includes/admin-functions.php';
}

/**
 * If Elementor is installed and active, we can load the Elementor-specific Settings & Features
*/

// Allow active/inactive via the Experiments
require get_template_directory() . '/includes/elementor-functions.php';

/**
 * Include customizer registration functions
*/
function hello_register_customizer_functions() {
	if ( hello_header_footer_experiment_active() && is_customize_preview() ) {
		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_register_customizer_functions' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check hide title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * Wrapper function to deal with backwards compatibility.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		} else {
			do_action( 'wp_body_open' );
		}
	}
}
 
/*
 * EXAMPLE OF CHANGING ANY TEXT (STRING) IN THE EVENTS CALENDAR
 * See the codex to learn more about WP text domains:
 * http://codex.wordpress.org/Translating_WordPress#Localization_Technology
 * Example Tribe domains: 'tribe-events-calendar', 'tribe-events-calendar-pro'...
 */
 
/**
 * Put your custom text here in a key => value pair
 * Example: 'Text you want to change' => 'This is what it will be changed to'.
 * The text you want to change is the key, and it is case-sensitive.
 * The text you want to change it to is the value.
 * You can freely add or remove key => values, but make sure to separate them with a comma.
 * This example changes the label "Venue" to "Location", "Related Events" to "Similar Events", and "(Now or date) onwards" to "Calendar - you can discard the dynamic portion of the text as well if desired.
*/
function tribe_replace_strings() {
  $custom_text = [
	'Search for events' => 'Search for trainings',  
    'Venue' => 'Location',
    'Related %s' => 'Similar %s',
    '%s onwards' => 'Calendar',
	'Events'=> 'Trainings',
	'%s Events'=> '%s Trainings',
	'tickets' => 'seats',
	'Tickets' => 'Seats',
	'Tickets are no longer available'=>'Registeration is closed',
	'Get tickets'=>'Register',
	'Log in to purchase' => 'Please login or register to continue',
	'Log in before purchasing'=>'Please login or register to continue',
	'Purchase'=>'Register',
	'back to event'=>'back to training',
	
  ];
 
  return $custom_text;
}
 
 
 
function tribe_custom_theme_text ( $translation, $text, $domain ) {
  // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
  if ( ! check_if_tec_domains( $domain ) ) {
    return $translation;
  }
 
  // String replacement.
  $custom_text = tribe_replace_strings();
 
  // If we don't have replacement text in our array, return the original (translated) text.
  if ( empty( $custom_text[$translation] ) ) {
    return $translation;
  }
 
  return $custom_text[$translation];
}
 
 
 
function tribe_custom_theme_text_plurals ( $translation, $single, $plural, $number, $domain ) {
  // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
  if ( ! check_if_tec_domains( $domain ) ) {
    return $translation;
  }
 
  /** If you want to use the number in your logic, this is where you'd do it.
   * Make sure you return as part of this, so you don't call the function at the end and undo your changes!
   */
 
  // If we're not doing any logic up above, just make sure your desired changes are in the $custom_text array above (in the `tribe_custom_theme_text` filter. )
  if ( 1 === $number ) {
    return tribe_custom_theme_text ( $translation, $single, $domain );
  } else {
    return tribe_custom_theme_text ( $translation, $plural, $domain );
  }
}
 
 
 
function tribe_custom_theme_text_with_context ( $translation, $text, $context, $domain ) {
  // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
  if ( ! check_if_tec_domains( $domain ) ) {
    return $translation;
  }
 
  /** If you want to use the context in your logic, this is where you'd do it.
   * Make sure you return as part of this, so you don't call the function at the end and undo your changes!
   * Example (here, we don't want to do anything when the context is "edit", but if it's "view" we want to change it to "Tribe"):
   * if ( 'edit' === strtolower( $context ) ) {
   *    return $translation;
   * } elseif( 'view' === strtolower( $context ) ) {
   *    return "Tribe";
   * }
   *
   * Feel free to use the same logic we use in tribe_custom_theme_text() above for key => value pairs for this logic.
   */
 
  // If we're not doing any logic up above, just make sure your desired changes are in the $custom_text array above (in the `tribe_custom_theme_text` filter. )
  return tribe_custom_theme_text ( $translation, $text, $domain );
}
 
 
 
function tribe_custom_theme_text_plurals_with_context ( $translation, $single, $plural, $number, $context, $domain ) {
  // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
  if ( ! check_if_tec_domains( $domain ) ) {
    return $translation;
  }
 
  /**
   * If you want to use the context in your logic, this is where you'd do it.
   * Make sure you return as part of this, so you don't call the function at the end and undo your changes!
   * Example (here, we don't want to do anything when the context is "edit", but if it's "view" we want to change it to "Tribe"):
   * if ( 'edit' === strtolower( $context ) ) {
   *    return $translation;
   * } elseif( 'view' === strtolower( $context ) ) {
   *    return "cat";
   * }
   *
   * You'd do something as well here for singular/plural. This could get complicated quickly if it has to interact with context as well.
   * Example:
   * if ( 1 === $number ) {
   *    return "cat";
   * } else {
   *    return "cats";
   * }
   * Feel free to use the same logic we use in tribe_custom_theme_text() above for key => value pairs for this logic.
   */
 
  // If we're not doing any logic up above, just make sure your desired changes are in the $custom_text array above (in the `tribe_custom_theme_text` filter. )
  if ( 1 === $number ) {
    return tribe_custom_theme_text ( $translation, $single, $domain );
  } else {
    return tribe_custom_theme_text ( $translation, $plural, $domain );
  }
}
 
function check_if_tec_domains( $domain ) {
  $is_tribe_domain = strpos( $domain, 'tribe-' ) === 0;
  $is_tec_domain   = strpos( $domain, 'the-events-' ) === 0;
  $is_event_domain = strpos( $domain, 'event-' ) === 0;
 
  // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
  if ( ! $is_tribe_domain && ! $is_tec_domain && ! $is_event_domain ) {
    return false;
  }
 
  return true;
}
 
// Base.
add_filter( 'gettext', 'tribe_custom_theme_text', 20, 3 );
// Plural-aware translations.
add_filter( 'ngettext', 'tribe_custom_theme_text_plurals', 20, 5 );
// Translations with context.
add_filter( 'gettext_with_context', 'tribe_custom_theme_text_with_context', 20, 4 );
// Plural-aware translations with context.
add_filter( 'ngettext_with_context', 'tribe_custom_theme_text_plurals_with_context', 20, 6 );