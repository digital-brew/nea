<?php

namespace Rafflex\Nea\Providers;

use Rafflex\Nea\Modules\AdminBar;
use Rafflex\Nea\Modules\AdminMenu;
use Rafflex\Nea\Modules\Dashboard;
use Rafflex\Nea\Modules\UnregisterPosts;
use Rafflex\Nea\Modules\WooCommerce;
use Rafflex\ThemosisDirectives\Directives\ACF;
use Rafflex\ThemosisDirectives\Directives\Helpers;
use Rafflex\ThemosisDirectives\Directives\WordPress;
use Themosis\Core\Support\Providers\RouteServiceProvider as ServiceProvider;
use Rafflex\Nea\Services\JQueryCDN;
use Themosis\Support\Facades\Asset;

class NeaServiceProvider extends ServiceProvider
{
    public function boot() {
        (new AdminMenu)->start();
        (new AdminBar)->register();
        (new UnregisterPosts)->register();
        (new WooCommerce)->register();
        (new Dashboard())->register();
    }

    public function register() {
//        (new JQueryCDN)->register();

        // Register assets
        Asset::add('admin_script', 'admin/scripts/admin.js', ['jquery'], '1.0')
            ->to('admin');
        Asset::add('admin_style', 'admin/styles/admin.css', ['wp-jquery-ui-dialog'], '1.1')->to('admin');



//        if(current_user_can('administrator')) {
//            Asset::add('front_style', 'admin/styles/front.css', [], '1.0')->to('front');
//        }
    }
}