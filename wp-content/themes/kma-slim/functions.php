<?php
/**
 * @package KMA
 * @subpackage kmaslim
 * @since 1.0
 * @version 1.3
 */

use Includes\Modules\Team\Team;
use Includes\Modules\Leads\Leads;
use Includes\Modules\Helpers\CleanWP;
use Includes\Modules\Layouts\Layouts;
use Includes\Modules\Helpers\PageField;
use Includes\Modules\Slider\BulmaSlider;
use Includes\Modules\Leads\SimpleContact;
use Includes\Modules\Social\SocialSettingsPage;
use Includes\Modules\Leads\SubContractorSignup;

require('vendor/autoload.php');
// require('post-types/project.php');
// require('post-types/client.php');
// require('post-types/service.php');

new CleanWP();

$socialLinks = new SocialSettingsPage();
if(is_admin()) {
    $socialLinks->createPage();
}

$layouts = new Layouts();
$layouts->createPostType();
// $layouts->createDefaultFormats();
// $layouts->createLayout('two-column','two column page layout','twocol');

$subSignup = new SubContractorSignup();
$subSignup->setupAdmin();
$subSignup->setupShortcode();

// $slider = new BulmaSlider();
// $slider->createPostType();
// $slider->createAdminColumns();

// $team = new Team();
// $team->setupAdmin();

// PageField::addField('Sidebar Content',[
// 	'Title' => 'text',
// 	'html'  => 'wysiwyg'
// ]);

// PageField::addField('Contact Info',[
// 	'Phone number'    => 'text',
// 	'Fax number'      => 'text',
// 	'Mailing Address' => 'textarea',
// 	'Office Location' => 'textarea'
// ], 20);

if ( ! function_exists( 'kmaslim_setup' ) ) :

function kmaslim_setup() {

	load_theme_textdomain( 'kmaslim', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	register_nav_menus( array(
		'mobile-menu'    => esc_html__( 'Mobile Menu', 'kmaslim' ),
		'footer-menu'    => esc_html__( 'Footer Menu', 'kmaslim' ),
		'main-menu'      => esc_html__( 'Main Navigation', 'kmaslim' )
	) );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption'
	) );

	function kmaslim_inline() {?>
		<style type="text/css">
			<?php echo file_get_contents(get_template_directory() . '/style.css'); ?>
		</style>
	<?php }
	add_action( 'wp_head', 'kmaslim_inline' );
	wp_register_script( 'scripts', get_template_directory_uri() . '/app.js', array(), '0.0.1', true );

}
endif;
add_action( 'after_setup_theme', 'kmaslim_setup' );

function kmaslim_scripts() {
	wp_enqueue_script( 'scripts' );
}
add_action( 'wp_enqueue_scripts', 'kmaslim_scripts' );

function kmaslim_theme_customizer( $wp_customize ) {
    $wp_customize->add_section( 'kmaslim_logo_section' , array(
        'title'       => __( 'Logo', 'kmaslim' ),
        'priority'    => 30,
        'description' => 'Upload a logo to replace the default site name and description in the header',
    ) );

    $wp_customize->add_setting( 'kmaslim_logo' );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'kmaslim_logo', array(
        'label'    => __( 'Logo', 'kmaslim' ),
        'section'  => 'kmaslim_logo_section',
        'settings' => 'kmaslim_logo',
    ) ) );
}
add_action( 'customize_register', 'kmaslim_theme_customizer' );

function getProjectsForClient($client) {
	return get_posts(array(
		'post_type' => 'project',
		'numberposts' => -1,
		'tax_query' => array(
			array(
				'taxonomy' => 'client',
				'field' => 'id',
				'terms' => $client, // Where term_id of Term 1 is "1".
				'include_children' => false
			)
		)
	));
}