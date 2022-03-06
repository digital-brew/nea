<?php

namespace Rafflex\Nea\Modules;

use Illuminate\Support\Facades\Config;
use Themosis\Support\Facades\Action;

class Dashboard
{
    public function register()
    {
        if((Config::get('nea.global.remove-default=widgets') == true)) {
            Action::add('admin_init', [$this, 'removeDefaultWidgets']);
        }
    }

    /**
     * Remove JSON API capabilities
     */
    public function removeDefaultWidgets () {
        // Remove the 'Welcome' panel
        Action::remove( 'welcome_panel', 'wp_welcome_panel' );

        // Remove 'Site health' metabox
        remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );

        // Remove the 'At a Glance' metabox
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );

        // Remove the 'Activity' metabox
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );

        // Remove the 'WordPress News' metabox
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );

        // Remove the 'Quick Draft' metabox
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );

        // Remove widgets related to YITH plugins
        remove_meta_box( 'yith_dashboard_products_news', 'dashboard', 'normal' );
        remove_meta_box( 'yith_dashboard_blog_news', 'dashboard', 'normal' );
    }
}
