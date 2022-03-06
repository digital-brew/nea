<?php

namespace Rafflex\Nea\Services;

use Illuminate\Support\Facades\Config;
use Themosis\Support\Facades\Action;

class AdminMenu
{
    public function register()
    {
        if((Config::get('nea.global.recreate-dashboard') == true)) {
            $this->recreateDashboard();
        }

        if((Config::get('nea.woocommerce.wishlist-enabled') == true)) {
            $this->wishlistMenuItem();
        }
    }

    public function recreateDashboard()
    {
        Action::add('admin_menu', function() {
            // Remove default dashboard with updates page
            remove_menu_page('index.php');
            remove_submenu_page('index.php', 'update-core.php');
            // Re-register dashboard under Home name
            add_menu_page('Home', 'Home', 'read', 'index.php');
        });
    }

    public function wishlistMenuItem()
    {
        Action::add('admin_menu', function() {
            remove_menu_page('yith_plugin_panel');
            add_submenu_page('woocommerce', 'Wishlist', 'Wishlist', 'manage_options',
                'admin.php?page=yith_wcwl_panel');
        });
    }
}
