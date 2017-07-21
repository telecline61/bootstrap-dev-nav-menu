<?php
/**
 * Plugin Name: Bootstrap Nav Menu
 * Description: Simple Bootstrap walker and nav setup for dev-ing stuff
 * Version: 0.1
 * Author: Chris Cline
 * Author URI: http://www.christiancline.com
 */

// Exit if this wasn't accessed via WordPress (aka via direct access)
if (!defined('ABSPATH')) exit;

//load bootstrap walker
require_once( plugin_dir_path( __FILE__ ) . 'lib/bootstrap_nav_walker.php');

class BootstrapNav {
    public function __construct() {
        // Add Custom CSS
        add_action('wp_enqueue_scripts', array($this,'enqueue'));

        //register our nav
        add_action( 'after_setup_theme', array($this,'register'));

        //add the bootstrap nav template shortcode
        add_shortcode('bootstrap_nav', array($this,'shortcode'));

    }
    // register nav/loaction
    public function register() {
        register_nav_menu(  'bs-navigation', __( 'Bootstrap Menu', 'Bootstrap Nav Menu' ));
    }

    // render nav shortcode function
    public function shortcode(){
        //bootstrap markup
        $output = '';
        //check for location
        if ( has_nav_menu( 'bs-navigation' )){
            return $output . '
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="fusion-row">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false" data-parent="accordian-4">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                    </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="navbar-collapse">
                            <!-- wp_nav_menu -->
                            ' .
                                wp_nav_menu( array(
                                  'theme_location' => 'bs-navigation',
                                  'container' => false,
                                  'menu_class' => 'nav navbar-nav navbar-right',
                                  'menu_id' => 'bootstrap-nav',
                                  'walker' => new bootstrap_nav_Walker(),
                                  'echo' =>  false
                                ))
                             .'
                        </div><!-- /.navbar-collapse -->
                    </div>
                </div>
            </nav>
            <div class="clearfix"></div>';
        }
    }

    // styles and scripts
    public function enqueue() {
        // nav styles
        wp_enqueue_style('custom-styles', plugins_url('css/boostrap-nav-custom-styles.css', __FILE__), null, '1.0');
        // nav js
        wp_enqueue_script('custom-js', plugins_url('js/bootstrap-nav-custom-js.js', __FILE__), array('jquery'), '1.0', true);
    }

}
// Let's do this thing!
$bsNav = new BootstrapNav();
