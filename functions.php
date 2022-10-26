<?php
define('LHF_PATH', get_stylesheet_directory());
define('LHF_URL', get_stylesheet_directory_uri());


// Include Jupiter X.
require_once(get_template_directory() . '/lib/init.php');

/**
 * Enqueue assets.
 *
 * Add custom style and script.
 */
jupiterx_add_smart_action('wp_enqueue_scripts', 'jupiterx_child_enqueue_scripts', 8);

function jupiterx_child_enqueue_scripts()
{
	// Add custom script.
	wp_enqueue_style(
		'jupiterx-child',
		get_stylesheet_directory_uri() . '/assets/css/style.css'
	);
	wp_enqueue_style(
		'lhf-toolkit-css',
		get_stylesheet_directory_uri() . '/assets/css/lhftoolkit.css', '', '1.0.5'
	);

	// Add custom script.
	wp_enqueue_script(
		'jupiterx-child',
		get_stylesheet_directory_uri() . '/assets/js/script.js',
		['jquery'],
		false,
		true
	);
	wp_enqueue_style('lhft_bootstrap_css', LHF_URL . "/assets/css/bootstrap.min.css", 'jupiterx-child');
	wp_enqueue_script('lhft_bootstrap_js', LHF_URL . "/assets/js/bootstrap.bundle.min.js");
	wp_enqueue_style('lhft_bootstrap_icons', LHF_URL . "/assets/bootstrap-icons/bootstrap-icons.css");
}

/**
 * Example 1
 *
 * Modify markups and attributes.
 */
// jupiterx_add_smart_action( 'wp', 'jupiterx_setup_document' );

function jupiterx_setup_document()
{

	// Header
	jupiterx_add_attribute('jupiterx_header', 'class', 'jupiterx-child-header');

	// Breadcrumb
	jupiterx_remove_action('jupiterx_breadcrumb');

	// Post image
	jupiterx_modify_action_hook('jupiterx_post_image', 'jupiterx_post_header_before_markup');

	// Post read more
	jupiterx_replace_attribute('jupiterx_post_more_link', 'class', 'btn-outline-secondary', 'btn-danger');

	// Post related
	jupiterx_modify_action_priority('jupiterx_post_related', 11);

}

/**
 * Example 2
 *
 * Modify the sub footer credit text.
 */
// jupiterx_add_smart_action( 'jupiterx_subfooter_credit_text_output', 'jupiterx_child_modify_subfooter_credit' );

function jupiterx_child_modify_subfooter_credit()
{ ?>

<a href="https//jupiterx.com" target="_blank">Jupiter X Child</a> theme for <a href="http://wordpress.org"
	target="_blank">WordPress</a>

<?php
}

/* TOOLS AT HOME */
function add_elementor_widget_categories_lh_foundation($elements_manager)
{
	$elements_manager->add_category(
		'lhfoundation',
		[
			'title' => esc_html__('LHFoundation', 'lhfoundation'),
			'icon' => 'fa fa-plug'

		]
	);

}
add_action('elementor/elements/categories_registered', 'add_elementor_widget_categories_lh_foundation');



function register_lhfoundation_widget_elementor($widgets_manager)
{
	include_once(LHF_PATH . '/lib/elementor/homecats.php');
	include_once(LHF_PATH . '/lib/elementor/catslists.php');
	include_once(LHF_PATH . '/lib/elementor/lhftcatslist.php');
	include_once(LHF_PATH . '/lib/elementor/lhftsinglebody.php');
	include_once(LHF_PATH . '/lib/elementor/lhftfavorites.php');
	include_once(LHF_PATH . '/lib/elementor/mainpost.php');
	$widgets_manager->register(new \LHFT_cats_grid());
	$widgets_manager->register(new \LHFT_cats_list());
	$widgets_manager->register(new \LHFT_cats_menu());
	$widgets_manager->register(new \LHFT_single_card());
	$widgets_manager->register(new \LHFT_favorites_bar());
	$widgets_manager->register(new \LHFT_main_post_list());
}
add_action('elementor/widgets/register', 'register_lhfoundation_widget_elementor');

function my_cptui_add_post_types_to_archives($query)
{
	// We do not want unintended consequences.
	if (is_admin() || !$query->is_main_query()) {
		return;
	}

	if (is_category() || is_tag() && empty($query->query_vars['suppress_filters'])) {
		$cptui_post_types = cptui_get_post_type_slugs();

		$query->set(
			'post_type',
			array_merge(
					array('post'),
				$cptui_post_types
			)
		);
	}
}
add_filter('pre_get_posts', 'my_cptui_add_post_types_to_archives');
add_filter('jupiterx_new_search_subtitle_text_output', function () {
	return 'Try another search.';
}
);