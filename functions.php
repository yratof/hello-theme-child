<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {

	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		HELLO_ELEMENTOR_CHILD_VERSION
	);

}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );




/** Custom login styles */
/** Custom login styles */
/** Custom login styles */
/** Custom login styles */

function dashboard_looking_fine() {
    ?>
    <style>

		.loginwrap {
			/* Use the SVG as a mask */
/* 			-webkit-mask-image: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/mask.svg' ); ?>');
			mask-image: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/mask.svg' ); ?>');
			-webkit-mask-size: contain;
			mask-size: contain;
			-webkit-mask-repeat: no-repeat;
			mask-repeat: no-repeat;
			-webkit-mask-position: center;
			mask-position: center; */

			background: white; /* semi-transparent white for see-through effect */
			flex-direction: column;
			width: 100%;
			max-width: 600px;
			min-width: 350px;
			display: flex;
			align-items: center;
			justify-content: center;
			height: 100%;
			margin-top: 0px;
			margin-right: auto;
			margin-bottom: 0px;
			margin-left: auto;
			position: absolute;
			left: 2rem;
		}

		.login form {
			box-shadow: none;
			border: 0;
			background-color: white;
		}
		
		#login {
			margin: 0 auto;
			width: 320px;
			background-color: transparent;
			padding-top: 0;
			padding-right: 0;
			padding-bottom: 0;
			padding-left: 0;
		}

		body.login {
			background: url(<?php echo esc_url( get_stylesheet_directory_uri() . '/login-splash.jpg' ); ?>) no-repeat center center fixed;
			background-color: black;
			background-size: cover;
			display: flex;
			flex-wrap: wrap;
			flex-direction: column;
			margin-right: auto;
			align-items: stretch;
			align-content: flex-start;
			background-position: 100% 100%;
			text-align: center;
		}  

		#login h1 a {
			margin: 0 auto 25px auto;
		}

		#login h1 a {
			background: transparent url(<?php echo esc_url( get_stylesheet_directory_uri() . '/logo.svg' ); ?>) no-repeat 50% 5%;
			background-size: contain;
			margin: 0px auto;
			overflow: hidden;
			text-indent: -9999px;
			height: 100px;
			width: 100%;
		}

		.login input[type="text"], 
		.login input[type="password"] {
			border-radius: 10rem;
			text-align: center;
		}

    </style>
    <?php
}
add_action('login_head', 'dashboard_looking_fine');

function login_title() {
    return 'WELCOME BACK';
}
add_filter('login_headertext', 'login_title');

/**
 * Wrap the login form in a div with class 'loginwrap'
 */
function wrap_login_form() {
    // Start output buffering
    ob_start();
}
add_action('login_head', 'wrap_login_form', 999);

function end_login_wrap() {
    // Get the buffered content
    $content = ob_get_clean();
    
    // Find the #login div and wrap it in our loginwrap div
    $content = preg_replace('/<div id="login"/', '<div class="loginwrap"><div id="login"', $content, 1);
    $content = str_replace('</body>', '</div></body>', $content);
    
    // Output the modified content
    echo $content;
    
    // Exit to prevent WordPress from outputting the page again
    exit;
}
add_action('login_footer', 'end_login_wrap', 999);



/** REMOVE ALL COMMENTS */
/** REMOVE ALL COMMENTS */
/** REMOVE ALL COMMENTS */
/** REMOVE ALL COMMENTS */


add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
    
    if ($pagenow === 'edit-comments.php' || $pagenow === 'options-discussion.php') {
        wp_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page and option page in menu 
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
    remove_submenu_page('options-general.php', 'options-discussion.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});


