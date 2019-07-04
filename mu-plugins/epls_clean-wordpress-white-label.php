<?php 
/*
Plugin Name: EPLS Website set up
Plugin URI: https://epls.design
Description: This plugin cleans up the Wordpress header by removing unneccesary junk, adds white-label branding to the admin areas, applies some minor security fixes and creates a "Client Admin" user role.
Author: EPLS Design
Author URI: https://epls.design
Version: 1.0
*/
 
/***********************
 *
 * WHITE LABEL WORDPRESS
 *
 **********************/
 
/* WHITE LABEL ADMIN DASHBOARD: Change Admin Logo and background image */
add_action( 'login_head', 'epls_login_logo' );
function epls_login_logo() {
	echo '<style type="text/css">
    h1 a { background-image:url('.get_home_url().'/wp-content/uploads/developer/epls.svg) !important; background-size: 110px 110px !important;height: 110px !important; width: 110px !important; margin-bottom: 0 !important; padding-bottom: 0 !important; }
    .login form { margin-top: 20px !important; }
    body.login {background-image:url('.get_home_url().'/wp-content/uploads/developer/epls-mural.png); background-position: bottom right; background-repeat: no-repeat;background-size: 35%;}
    </style>';
}
 
/* WHITE LABEL ADMIN DASHBOARD: Replace Link URL */
add_filter( 'login_headerurl', 'epls_login_url' );
function epls_login_url(){
	return 'https://epls.design';
}
 
/* WHITE LABEL ADMIN DASHBOARD: Change login logo hover text */
add_filter( 'login_headertext', 'epls_login_logo_title' );
function epls_login_logo_title() {
  return 'Website designed and developed by epls.design';
}
 
/* WHITE LABEL ADMIN DASHBOARD: Modify the admin footer text */
add_filter( 'admin_footer_text', 'epls_modify_admin_footer' );
function epls_modify_admin_footer () {
  echo '<span id="footer-thankyou">Website designed and developed by <a href="https://epls.design" target="_blank">epls.design</a></span>';
}
 
/* WHITE LABEL ADMIN DASHBOARD: Replace logo in admin bar */
add_action('wp_before_admin_bar_render', 'epls_admin_bar_logo');
function epls_admin_bar_logo() {
  global $wp_admin_bar;
  echo '
    <style type="text/css">
      #wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
       background-image:url('.get_home_url().'/wp-content/uploads/developer/epls-mini.svg) !important;
      background-position: 0 0;
      color:rgba(0, 0, 0, 0);
      }
      #wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
      background-position: 0 0;
      }
    </style>
    ';
}
 
/* WHITE LABEL ADMIN DASHBOARD: Add contact info box onto Dashboard */
add_action('wp_dashboard_setup', 'epls_support_widget' );
function epls_support_widget() {
  wp_add_dashboard_widget('wp_dashboard_widget', 'Support Information', 'epls_support_info');
}
function epls_support_info() {
  echo "
  <h1>Website support</h1>
  <p>For website support, maintenance and further developments contact <strong>epls.design</strong> on the details below:</p>
  <ul><img src='".get_home_url()."/wp-content/uploads/developer/epls.svg' class='alignright' style='height:80px;width:80px;' alt='epls.design logo'>
  <li><strong>Website:</strong> <a href='https://epls.design'>epls.design</a></li>
  <li><strong>Email:</strong> <a href='mailto:support@epls.design'>support@epls.design</a></li>
  <li><strong>Telephone:</strong> <a href='tel:01962 795019'>01962 795019</a></li>
  </ul>";
}
 
/* WHITE LABEL ADMIN DASHBOARD: 'Remember Me' checked by default */
add_action( 'init', 'epls_login_checked_rememberme' );
function epls_login_checked_rememberme() {
  add_filter( 'login_footer', 'epls_check_rememberme' );
}
function epls_check_rememberme() {
  echo "<script>document.getElementById('rememberme').checked = true;</script>";
}
 
/***********************
 *
 * SECURITY
 *
 **********************/
 
/* If a user's login fails, don't tell them whether the username or password was incorrect */
add_filter ( 'login_errors', 'epls_failed_login' );
function epls_failed_login () {
  return 'Login failed because either your username or password is incorrect. Please try again.';
}
 
/***********************
 *
 * REMOVE HEADER JUNK
 *
 **********************/
 
/* Remove Emoji Junk from wp_head */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
 
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
 
/* Remove Wordpress version from wp_head */
remove_action('wp_head', 'wp_generator');
 
/* Remove XML-RPC Really Simple Discovery from wp_head */
remove_action('wp_head', 'rsd_link');
 
/* Remove Windows Live Writer link from wp_head */
remove_action('wp_head', 'wlwmanifest_link');
 
/* Remove Useless Post Relational links from wp_head */
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link');
 
/* Remove feed links from wp_head */
remove_action( 'wp_head', 'feed_links', 2 );
remove_action('wp_head', 'feed_links_extra', 3 );
 
/* Disable self pingbacks */
function disable_self_trackback( &$links ) {
    foreach ( $links as $l => $link )
    if ( 0 === strpos( $link, get_option( 'home' ) ) )
    unset($links[$l]);
}
add_action( 'pre_ping', 'disable_self_trackback' ); 
 
/***********************
 *
 * CREATE CLIENT ADMIN ROLE
 *
 **********************/

function epls_client_role() {
    global $wp_roles;
    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();
        
    // Add new "Client" role with restricted admin capabilities
    $wp_roles->add_role( 
        'client-admin', 
        'Admin', 
        array(
            'create_posts' => true,
            'create_users' => true,
            'delete_others_pages' => true,
            'delete_others_posts' => true,
            'delete_pages' => true,
            'delete_posts' => true,
            'delete_private_pages' => true,
            'delete_private_posts' => true,
            'delete_published_pages' => true,
            'delete_published_posts' => true,
            'delete_users' => true,
            'edit_dashboard' => true,
            'edit_others_pages' => true,
            'edit_others_posts' => true,
            'edit_pages' => true,
            'edit_posts' => true,
            'edit_private_pages' => true,
            'edit_private_posts' => true,
            'edit_published_pages' => true,
            'edit_published_posts' => true,
            'edit_theme_options' => false,
            'edit_users' => true,
            'level_0' => true,
            'level_1' => true,
            'level_2' => true,
            'level_3' => true,
            'level_4' => true,
            'level_5' => true,
            'level_6' => true,
            'level_7' => true,
            'list_users' => true,
            'manage_categories' => true,
            'manage_links' => true,
            'moderate_comments' => true,
            'promote_users' => true,
            'publish_pages' => true,
            'publish_posts' => true,
            'read' => true,
            'read_private_pages' => true,
            'read_private_posts' => true,
            'unfiltered_html' => true,
            'update_core' => true,
            'update_plugins' => true,
            'upload_files' => true
        )
    );
}
add_action( 'init', 'epls_client_role' );
?>