<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $pagenow;

function gostudy_welcome_page(){
   require_once 'rt-welcome.php';
}

function gostudy_theme_active_page(){
   require_once 'rt-theme-active.php';
}

// function gostudy_theme_plugins_page(){
//    require_once 'rt-theme-plugins.php';
// }

function gostudy_help_center_page(){
   require_once 'rt-help-center.php';
}

function gostudy_requirements_page(){
   require_once 'rt-requirements.php';
}

function gostudy_admin_menu(){
    if ( current_user_can( 'edit_theme_options' ) ) {

        add_menu_page( 'Gostudy', 'Gostudy', 'administrator', 'gostudy-admin-menu', 'gostudy_welcome_page', 'data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAwAAAASCAYAAABvqT8MAAABMUlEQVQokd2TPUjDUBSFv5cqLWIRCiKK2LWDgyJYUNQUBEERrGMGpQg6qENB904KZhAXh0J1K50cOpVIHRSHgJBNcAiIQ3FwEc0imMgLrcQfgl096z3fvffxzhWEyEM7AW6BQ0H5XTo7Pu2mNQmsABdAjfToM5AAdCDjoWUF5Tcl0L8XWAcqwCOmlQvU5oGiP8E11BEgonzdLAYkvy276qGVpM8CSmFvCWhT+aOxpal2gYF2Af47MATs+b/+CxABboCCTJWfO8gJc3f7LplQAbsFCNdQZVHqFbgG6kfR6ct8LDsDbAEP1Z2zjcUruw70SeA+MDHeTKjUeUPp0QfjBZm1ucbC8UH/k1P7cQ+uocrgpYBxaQScpa6102rn8JiX1lOhB9Rs0A0s70dn7Yn8i/MBS0RLHzldG3UAAAAASUVORK5CYII=', 2 );

        add_submenu_page( 'gostudy-admin-menu', 'gostudy', esc_html__('Welcome','gostudy'), 'administrator', 'gostudy-admin-menu', 'gostudy_welcome_page' );

        add_submenu_page( 'gostudy-admin-menu', 'gostudy', esc_html__('Activate Theme','gostudy'), 'administrator', 'gostudy-theme-active', 'gostudy_theme_active_page' );

        add_submenu_page('gostudy-admin-menu', '', 'Theme Options', 'manage_options', 'admin.php?page=rt-theme-options-panel' );

        if (class_exists('OCDI_Plugin')):
           add_submenu_page( 'gostudy-admin-menu', esc_html__( 'Demo Import', 'gostudy' ), esc_html__( 'Demo Import', 'gostudy' ), 'administrator', 'demo_install', 'demo_install_function' );
       endif;
      // add_submenu_page( 'gostudy-admin-menu', 'gostudy', esc_html__('Theme Plugins','gostudy'), 'administrator', 'gostudy-theme-plugins', 'gostudy_theme_plugins_page' );      

      add_submenu_page( 'gostudy-admin-menu', 'gostudy', esc_html__('Requirements','gostudy'), 'administrator', 'gostudy-requirements', 'gostudy_requirements_page' );

      add_submenu_page( 'gostudy-admin-menu', 'gostudy', esc_html__('Help Center','gostudy'), 'administrator', 'gostudy-help-center', 'gostudy_help_center_page' );

   }

}

add_action( 'admin_menu', 'gostudy_admin_menu' );

function demo_install_function(){
    ?>
    <script>location.href='<?php echo esc_url(admin_url().'themes.php?page=pt-one-click-demo-import');?>';</script>
    <?php
}

if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

  wp_redirect(admin_url("admin.php?page=gostudy-admin-menu"));
  
}









