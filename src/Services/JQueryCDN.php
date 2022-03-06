<?php

namespace Rafflex\Nea\Services;

use Illuminate\Support\Facades\Config;
use Themosis\Core\ThemeManager;
use Themosis\Support\Facades\Action;
use Themosis\Support\Facades\Filter;

class JQueryCDN
{
    public function register()
    {
        if((Config::get('nea.global.load-jquery-cdn') == true)) {
            $this->loadJqueryFromCDN();
            $this->jqueryFallback();
        }
        if((Config::get('nea.global.remove-legacy-jquery') == true)) {
            $this->deregisterJqueryMigrate();
        }
    }

    /**
     *
     * Load JQuery from Google CDN
     *
     */
    public function loadJqueryFromCDN ()
    {
        Action::add(['wp_enqueue_scripts', 'login_enqueue_scripts'], function() {
            global $wp_version;

            if(!is_admin()) :

                wp_enqueue_script('jquery');

                // Get current version of jQuery from WordPress core
//                $wp_jquery_ver = $GLOBALS['wp_scripts']->registered['jquery-core']->ver;
                $wp_jquery_migrate_ver = $GLOBALS['wp_scripts']->registered['jquery-migrate']->ver;
                $wp_jquery_ver = '3.5.1';

                $jquery_cdn_url = '//ajax.googleapis.com/ajax/libs/jquery/'. $wp_jquery_ver .'/jquery.min.js';

                $jquery_migrate_cdn_url = '//cdnjs.cloudflare.com/ajax/libs/jquery-migrate/'. $wp_jquery_migrate_ver .'/jquery-migrate.min.js';

                // Deregister jQuery and jQuery Migrate
                wp_deregister_script('jquery-core');
                wp_deregister_script('jquery-migrate');

                // Register jQuery with CDN URL
                wp_register_script('jquery-core', $jquery_cdn_url, '', null, true);
                // Register jQuery Migrate with CDN URL
                wp_register_script('jquery-migrate', $jquery_migrate_cdn_url, array('jquery-core'), null, true);

            endif;
        });
    }

    /**
     *
     * Add local fallback for jQuery if CDN is down or not accessible
     *
     */
    public function jqueryFallback()
    {
        Filter::add('script_loader_src', function($src, $handle = null) {

            if(!is_admin()) :

                static $add_jquery_fallback = false;

                if ($add_jquery_fallback) :
                    echo '<script>window.jQuery || document.write(\'<script src="' . includes_url('js/jquery/jquery.js') . '"><\/script>\')</script>' . "\n";
                    $add_jquery_fallback = false;
                endif;

                if ( $handle === 'jquery-core')
                    $add_jquery_fallback = true;

                return $src;

            endif;

            return $src;

        }, 10, 2);
    }

    /**
     *
     * Deregister JQuery Migrate
     *
     */
    public function deregisterJqueryMigrate()
    {
        Action::add('wp_default_scripts', function($scripts) {

            if (!is_admin() && isset($scripts->registered['jquery'])) {
                $script = $scripts->registered['jquery'];

                if ( $script->deps ) { // Check whether the script has any dependencies
                    $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
                }
            }

        });
    }
}
