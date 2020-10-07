<?php
/**
 * Plugin Name:  EZPZ Wordpress Starter
 * Plugin URI:   https://github.com/epls-design/ezpz-cleanup/
 * Description:  Removes clutter and unnecessary junk from Wordpress. Applies some minor security fixes. Adds white-label branding to admin areas and creates a "Client Admin" user role. For more info see the README file. Some code forked from https://github.com/chuckreynolds/Selfish-Fresh-Start.
 * Version:      1.0.1
 * Author:       EPLS Design
 * Author URI:   https://epls.design
 * License:      GPL-2.0+
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:  ezpz-starter
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class. Does all the things.
 *
 * @since       1.0.0
 * @package     Ezpz_Wordpress_Starter
 * @author      EPLS Design <support@epls.design>
 */
class Ezpz_Wordpress_Starter {

	/**
	 * Construct for Ezpz_Wordpress_Starter class
	 *
	 * @return void
	 */
	public function __construct() {

    add_action( 'init', array( $this, 'ezpz_init' ) );
    add_action( 'after_setup_theme', array( $this, 'ezpz_after_theme_setup' ) );

	}

	/**
	 * Functions called at the init action
	 *
	 * @return void
	 */
	public function ezpz_init() {

    $this->ezpz_file_edit();
    $this->ezpz_restrict_post_revisions();
    $this->ezpz_trackbacks_smilies();
    $this->ezpz_client_role();
    $this->ezpz_login_white_label();
		$this->ezpz_admin_branding();

  }

	/**
	 * Removes theme and plugin editor links if not defined already
	 *
	 * @return void
	 */
	public function ezpz_file_edit() {

		if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
			define( 'DISALLOW_FILE_EDIT', 'true' );
		}

  }
  
	/**
	 * Restrict number of post revisions
	 *
	 * @return void
	 */
	public function ezpz_restrict_post_revisions() {
    // Restricts the amount of post revisions to 20, to reduce database bloat from trigger-happy editors
		if ( ! defined( 'WP_POST_REVISIONS' ) ) {
			define( 'WP_POST_REVISIONS', 20 );
		}

	}  

	/**
	 * Sets db options table flags
	 *
	 * @return string Closed: Disallow pingbacks and trackbacks from other blogs
	 * @return int    No: Attempt to notify any blogs linked to from the article
	 * @return int    No: Convert emoticons like :-) and :P to graphics when displayed
	 */
	public function ezpz_trackbacks_smilies() {

		$options = array(
			'default_ping_status'   => 'closed',
			'default_pingback_flag'	=> 0,
			'use_smilies'           => 0
		);

		foreach( $options as $key => $value ) {

			$current = get_option( $key );

			if ( $current != $value ) {
				update_option( $key, $value );
			}

		}

  }
  
  /**
   * Creates a client user role 'client-admin' with restricted admin capabilities. Use a plugin such as "User Role Editor" to manage capabilities further
   *
   * @return void
   */
  public function ezpz_client_role() {
    global $wp_roles;
    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();
        
    $wp_roles->add_role( 
        'client-admin', 
        'Client', 
        array(
					'assign_product_terms' => true,
					'assign_shop_coupon_terms' => true,
					'assign_shop_order_terms' => true,
					'create_posts' => true,
					'create_users' => true,
					'delete_others_pages' => true,
					'delete_others_posts' => true,
					'delete_others_products' => true,
					'delete_others_shop_coupons' => true,
					'delete_others_shop_orders' => true,
					'delete_pages' => true,
					'delete_posts' => true,
					'delete_private_pages' => true,
					'delete_private_posts' => true,
					'delete_private_products' => true,
					'delete_private_shop_coupons' => true,
					'delete_private_shop_orders' => true,
					'delete_product' => true,
					'delete_product_terms' => true,
					'delete_products' => true,
					'delete_published_pages' => true,
					'delete_published_posts' => true,
					'delete_published_products' => true,
					'delete_published_shop_coupons' => true,
					'delete_published_shop_orders' => true,
					'delete_shop_coupon' => true,
					'delete_shop_coupon_terms' => true,
					'delete_shop_coupons' => true,
					'delete_shop_order' => true,
					'delete_shop_order_terms' => true,
					'delete_shop_orders' => true,
					'delete_users' => true,
					'edit_dashboard' => true,
					'edit_others_pages' => true,
					'edit_others_posts' => true,
					'edit_others_products' => true,
					'edit_others_shop_coupons' => true,
					'edit_others_shop_orders' => true,
					'edit_pages' => true,
					'edit_posts' => true,
					'edit_private_pages' => true,
					'edit_private_posts' => true,
					'edit_private_products' => true,
					'edit_private_shop_coupons' => true,
					'edit_private_shop_orders' => true,
					'edit_product' => true,
					'edit_product_terms' => true,
					'edit_products' => true,
					'edit_published_pages' => true,
					'edit_published_posts' => true,
					'edit_published_products' => true,
					'edit_published_shop_coupons' => true,
					'edit_published_shop_orders' => true,
					'edit_shop_coupon' => true,
					'edit_shop_coupon_terms' => true,
					'edit_shop_coupons' => true,
					'edit_shop_order' => true,
					'edit_shop_order_terms' => true,
					'edit_shop_orders' => true,
					'edit_theme_options' => true,
					'edit_users' => true,
					'list_users' => true,
					'manage_categories' => true,
					'manage_links' => true,
					'manage_product_terms' => true,
					'manage_shop_coupon_terms' => true,
					'manage_shop_order_terms' => true,
					'manage_woocommerce' => true,
					'moderate_comments' => true,
					'promote_users' => true,
					'publish_pages' => true,
					'publish_posts' => true,
					'publish_products' => true,
					'publish_shop_coupons' => true,
					'publish_shop_orders' => true,
					'read' => true,
					'read_private_pages' => true,
					'read_private_posts' => true,
					'read_private_products' => true,
					'read_private_shop_coupons' => true,
					'read_private_shop_orders' => true,
					'read_product' => true,
					'read_shop_coupon' => true,
					'read_shop_order' => true,
					'remove_users' => true,
					'unfiltered_html' => true,
					'update_core' => true,
					'update_plugins' => true,
					'update_themes' => true,
					'upload_files' => true,
					'view_woocommerce_reports' => true,
					'wf2fa_activate_2fa_self' => true,
        )
    );
  }

  /**
   * Applies White Label branding and enhancements to the login screen
   *
   * @return void
   */
  public function ezpz_login_white_label() {
    /* WHITE LABEL ADMIN DASHBOARD: Change Admin Logo and background image */
    function ezpz_login_logo() {
      echo '<style type="text/css">
        h1 a { background-image:url("'.esc_url( plugins_url( '/img/epls.svg', __FILE__ ) ).'") !important; background-size: 110px 110px !important;height: 110px !important; width: 110px !important; margin-bottom: 20px !important; padding-bottom: 0 !important; }
        body.login {background-image:url('.esc_url( plugins_url( '/img/epls-mural.png', __FILE__ ) ).'); background-position: bottom right; background-repeat: no-repeat;background-size: 35%;}
        </style>';
    }
    add_action( 'login_head', 'ezpz_login_logo' );

    /* SELECTS THE 'REMEMBER ME' OPTION BY DEFAULT */
    function ezpz_check_rememberme() {
      echo "<script>document.getElementById('rememberme').checked = true;</script>";
    } 
    add_filter( 'login_footer', 'ezpz_check_rememberme' );

    /* WHITE LABEL ADMIN DASHBOARD: Replace Link URL */
    function ezpz_login_url(){
      return 'https://epls.design';
    }
    add_filter( 'login_headerurl', 'ezpz_login_url' );
  
    /* WHITE LABEL ADMIN DASHBOARD: Change login logo hover text */
    function ezpz_login_logo_title() {
      return 'Website designed and developed by epls.design';
    }
    add_filter( 'login_headertext', 'ezpz_login_logo_title' );

    /* IF A USER LOGIN FAILS DON'T TELL THEM WHAT ITEM WAS INCORRECT (USERNAME/PASSWORD) */
    function ezpz_failed_login () {
      return 'Login failed because either your username or password was incorrect. Please try again.';
    }
    add_filter ( 'login_errors', 'ezpz_failed_login' );
  }

  /**
	 * Applies White Label branding and enhancements to the admin area
	 *
	 * @return void
	 */
	public function ezpz_admin_branding() {
    /* WHITE LABEL ADMIN DASHBOARD: Change Footer Thankyou Text */
    function ezpz_modify_admin_footer () {
      echo '<span id="footer-thankyou">Website designed and developed by <a href="https://epls.design" target="_blank">epls.design</a></span>';
    }
    add_filter( 'admin_footer_text', 'ezpz_modify_admin_footer' );
  
    /* WHITE LABEL ADMIN DASHBOARD: Replace logo in admin bar */
    function ezpz_admin_bar_logo() {
      global $wp_admin_bar;
      echo '
        <style type="text/css">
          #wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
          background-image:url('.esc_url( plugins_url( '/img/epls-mini.svg', __FILE__ ) ).') !important;
          background-position: 0 0;
          color:rgba(0, 0, 0, 0);
          }
          #wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
          background-position: 0 0;
          }
        </style>
        ';
    }
    add_action('wp_before_admin_bar_render', 'ezpz_admin_bar_logo');

    /* WHITE LABEL ADMIN DASHBOARD: Add contact info box onto Dashboard */
    function ezpz_support_widget() {
      wp_add_dashboard_widget('wp_dashboard_widget', 'Support Information', 'ezpz_support_info');
    }
    function ezpz_support_info() {
      echo '
      <h1>Website support</h1>
      <p>For website support, maintenance and further developments contact <strong>epls.design</strong> on the details below:</p>
      <ul>
      <img src="' . esc_url( plugins_url( '/img/epls.svg', __FILE__ ) ) . '"  class="alignright" style="height:80px;width:80px;" alt="epls.design logo">
      <li><strong>Website:</strong> <a href="https://epls.design">epls.design</a></li>
      <li><strong>Email:</strong> <a href="mailto:support@epls.design">support@epls.design</a></li>
      <li><strong>Telephone:</strong> <a href="tel:01962 795019">01962 795019</a></li>
      </ul>';
    }
    add_action('wp_dashboard_setup', 'ezpz_support_widget' );

	}

	/**
	 * Functions called after the after_setup_theme action
	 *
	 * @return void
	 */
	public function ezpz_after_theme_setup() {

    /* Remove Emoji Junk from wp_head */
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );

    /* Remove Wordpress version from wp_head */
    remove_action( 'wp_head', 'wp_generator' );
    
    /* Remove XML-RPC Really Simple Discovery from wp_head */
    remove_action( 'wp_head', 'rsd_link' );
    
    /* Remove Windows Live Writer link from wp_head */
    remove_action( 'wp_head', 'wlwmanifest_link' );

    /* Remove Useless Post Relational links from wp_head */
    remove_action( 'wp_head', 'index_rel_link' ); // remove link to index page
    remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // remove random post link
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // remove parent post link
    remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // remove the next and previous post links
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );

    /* Remove Wordpress Welcome Panel */
		remove_action( 'welcome_panel', 'wp_welcome_panel' );

    /* Remove feed links from wp_head */
    remove_action( 'wp_head', 'feed_links', 2 );
    remove_action( 'wp_head', 'feed_links_extra', 3 );

    /* Metaboxes */
		add_action( 'wp_dashboard_setup',    array( $this, 'ezpz_dashboard_metaboxes' ) ); // Remove Wordpress widgets
		add_action( 'do_meta_boxes',         array( $this, 'ezpz_plugin_metaboxes' ) ); // Remove annoying plugin specific widgets
		add_action( 'admin_menu',            array( $this, 'ezpz_post_metaboxes' ) );
		add_action( 'admin_menu',            array( $this, 'ezpz_page_metaboxes' ) );

		/* Restricted Admin Menus */
		add_action( 'admin_menu', 					 array( $this, 'ezpz_remove_admin_pages'), 99 ); // Removes oft-used admin pages from the menu
		add_action( 'admin_init', 					 array( $this, 'ezpz_admin_redirect') ); // Redirects any access to restricted pages

    /* Prevents Non-Admins being nagged to update */
    add_action( 'admin_head',            array( $this, 'ezpz_update_notification_non_admins' ), 1 );

    /* Disables Self-Trackbacks */
    add_action( 'pre_ping',              array( $this, 'ezpz_self_pings' ) );

    /* Removes Hellodolly if it exists */
    add_action( 'admin_init',            array( $this, 'ezpz_hello_dolly' ) );
    
    /* Modifies #more link to not use hashtag anchor */
    add_filter( 'the_content_more_link', array( $this, 'ezpz_more_jump_link_anchor' ) );
    
    /* Fixes curly quotes and badly formatted characters */
		add_filter( 'content_save_pre',      array( $this, 'ezpz_curly_other_chars' ) );
		add_filter( 'title_save_pre',        array( $this, 'ezpz_curly_other_chars' ) );

    // Remove the REST API lines from the HTML Header
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

    // Remove the REST API endpoint.
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );    
	}


	/**
	 * Removes some dashboard widgets
	 *
	 * @return void
	 */
	public function ezpz_dashboard_metaboxes() {

		#remove_meta_box( 'dashboard_right_now',      'dashboard', 'normal' );  // At a Glance
		#remove_meta_box( 'network_dashboard_right_now', 'dashboard', 'normal' ); // Network Right Now
		remove_meta_box( 'dashboard_activity',       'dashboard', 'normal' );  // Activity
		remove_meta_box( 'dashboard_quick_press',    'dashboard', 'side' );   // Quick Draft / Your Recent Drafts
		remove_meta_box( 'dashboard_primary',        'dashboard', 'side' );   // WordPress Events and News

	}

	/**
	 * Removes oft-used admin pages from the menu
	 *
	 * @return void
	 */
	public function ezpz_remove_admin_pages() {
		global $current_user;
    get_currentuserinfo();

    // If Administrator remove some unnecessary submenus
    if (current_user_can( 'administrator' ) ) {	
			remove_submenu_page( 'tools.php', 'export.php'  ); // Export 
			remove_submenu_page( 'tools.php', 'import.php'  ); // Import
			remove_submenu_page( 'tools.php', 'tools.php'  ); // Available Tools
			// Note: Pages still available at direct URLs
		}
		else {
			// Otherwise remove all of these...
			remove_menu_page('tools.php');
			remove_menu_page('options-general.php');
			remove_menu_page('edit.php?post_type=acf-field-group'); // ACF
		}
	}

	public function ezpz_admin_redirect() {
		global $pagenow;
		// Todo: $pagenow just returns the root and not any queries - so edit.php?post_type=acf-field-group does not work. Better to check against actual URL? Sub pages eg. options-media.php are also not captured below...
		$restricted_urls = array(
			'tools.php',
			'options-general.php',
			'edit.php?post_type=acf-field-group'
		);

		if(in_array($pagenow,$restricted_urls) && !current_user_can( 'administrator' ) ) {	
			// User not authorized to access page, redirect to dashboard
      wp_redirect( admin_url( 'index.php' ) ); 
		}

	}	

	/**
	 * Removes some plugin dashboard widgets.
	 * Yup I'm goin there. Sorry not sorry.
	 *
	 * @return void
	 */
	public function ezpz_plugin_metaboxes() {

		remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' ); // yoast seo overview
		remove_meta_box( 'aw_dashboard',             'dashboard', 'normal' ); // wp socializer box
		remove_meta_box( 'w3tc_latest',              'dashboard', 'normal' ); // w3 total cache news box
		remove_meta_box( 'rg_forms_dashboard',       'dashboard', 'normal' ); // gravity forms
		remove_meta_box( 'bbp-dashboard-right-now',  'dashboard', 'normal' ); // bbpress right now in forums
		remove_meta_box( 'jetpack_summary_widget',   'dashboard', 'normal' ); // jetpack
		remove_meta_box( 'tribe_dashboard_widget',   'dashboard', 'normal' ); // modern tribe rss widget

	}

	/**
	 * Removes some meta boxes from default posts screen
	 *
	 * @return void
	 */
	public function ezpz_post_metaboxes() {

		remove_meta_box( 'trackbacksdiv',      'post', 'normal' ); // trackbacks metabox
		#remove_meta_box( 'postcustom',       'post', 'normal' ); // custom fields metabox
		#remove_meta_box( 'postexcerpt',      'post', 'normal' ); // excerpt metabox
		#remove_meta_box( 'commentstatusdiv', 'post', 'normal' ); // comments metabox
		#remove_meta_box( 'slugdiv',          'post', 'normal' ); // slug metabox (breaks edit permalink update)
		#remove_meta_box( 'authordiv',        'post', 'normal' ); // author metabox
		#remove_meta_box( 'revisionsdiv',     'post', 'normal' ); // revisions metabox
		#remove_meta_box( 'tagsdiv-post_tag', 'post', 'normal' ); // tags metabox
		#remove_meta_box( 'categorydiv',      'post', 'normal' ); // comments metabox

	}

	/**
	 * Removes some meta boxes from default pages screen
	 *
	 * @return void
	 */
	public function ezpz_page_metaboxes() {

		remove_meta_box( 'commentstatusdiv', 'page', 'normal' ); // discussion metabox
		remove_meta_box( 'commentsdiv',      'page', 'normal' ); // comments metabox
		#remove_meta_box( 'postcustom',     'page', 'normal' ); // custom fields metabox
		#remove_meta_box( 'slugdiv',        'page', 'normal' ); // slug metabox (breaks edit permalink update)
		#remove_meta_box( 'authordiv',      'page', 'normal' ); // author metabox
		#remove_meta_box( 'revisionsdiv',   'page', 'normal' ); // revisions metabox
		#remove_meta_box( 'postimagediv',   'page', 'side' );   // featured image metabox

	}

	/**
	 * Removes update notifications for everybody except admin users
	 *
	 * @return void
	 */
	public function ezpz_update_notification_non_admins() {

		if ( ! current_user_can( 'update_core' ) ) {
			remove_action( 'admin_notices', 'update_nag', 3 );
		}

	}

	/**
	 * Disables potential to self-trackback
	 *
	 * @return void
	 */
	public function ezpz_self_pings(&$links) {

		foreach ( $links as $l => $link ) {
			if ( 0 === strpos( $link, get_option( 'home' ) ) ) {
				unset( $links[$l] );
			}
		}

	}

	/**
	 * Removes hellodolly plugin if it exists. sorry @photomatt
	 *
	 * @return void
	 */
	public function ezpz_hello_dolly() {

		if ( file_exists( WP_PLUGIN_DIR . '/hello.php' ) ) {
			delete_plugins( array( 'hello.php' ) );
		}

	}

	/**
	 * Modifies #more link to not use hashtag anchor
	 *
	 * @return void
	 */
	public function ezpz_more_jump_link_anchor( $link ) {

		$offset = strpos( $link, '#more-' );

		if ( $offset ) {
			$end = strpos( $link, '"', $offset );
		}

		if ( $end ) {
			$link = substr_replace( $link, '', $offset, $end-$offset );
		}

		return $link;

	}

	/**
	 * Fixes curly quotes and badly formatted characters. One of my bigger pet peeves is curly quotes from word pastes
	 *
	 * @return string clean formated characters
	 */
	public function ezpz_curly_other_chars( $fixChars ) {

		$fixChars = str_replace(
			array("\xe2\x80\x98", "\xe2\x80\x99", "\xe2\x80\x9c", "\xe2\x80\x9d", "\xe2\x80\x93", "\xe2\x80\x94", "\xe2\x80\xa6"),
			array("'", "'", '"', '"', '-', '&mdash;', '&hellip;' ), $fixChars);

		$fixChars = str_replace(
			array(chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(133)),
			array("'", "'", '"', '"', '-', '&mdash;', '&hellip;' ), $fixChars);

		$fixChars = str_replace(
			array( 'â„¢', 'Â©', 'Â®' ),
			array( '&trade;', '&copy;', '&reg;' ), $fixChars);

		return $fixChars;

  }

}

/**
 * Begins execution of the plugin
 *
 * @since       1.1.0
 */
function run_Ezpz_Wordpress_Starter() {

	$plugin = new Ezpz_Wordpress_Starter();

}
run_Ezpz_Wordpress_Starter();
