<?php

namespace Rafflex\Nea\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Themosis\Support\Facades\Action;

class AdminBar
{
    public function register()
    {
        if((Config::get('nea.global.admin-bar.disable-menu-toggle') == true) ||
            (Config::get('nea.global.admin-bar.disable-wp-logo') == true) ||
            (Config::get('nea.global.admin-bar.disable-site-name') == true) ||
            (Config::get('nea.global.admin-bar.disable-widgets') == true) ||
            (Config::get('nea.global.admin-bar.disable-comments') == true) ||
            (Config::get('nea.global.admin-bar.disable-new-content') == true) ||
            (Config::get('nea.global.admin-bar.disable-my-account') == true)) {
            // Remove nodes from admin menu bar
            Action::add('admin_bar_menu', [$this, 'removeAdminBarNodes'], 999);
        }

        if((Config::get('nea.global.disable-admin-bar-on-frontend') == true)) {
            Action::add('after_setup_theme', [$this, 'removeAdminBarOnFrontEnd']);
        }
    }

    public function removeAdminBarNodes($wp_admin_bar)
    {
        if(Config::get('nea.global.admin-bar.disable-menu-toggle') == true) {
            $wp_admin_bar->remove_node('menu-toggle');
        }
        if(Config::get('nea.global.admin-bar.disable-wp-logo') == true) {
            $wp_admin_bar->remove_node('wp-logo');
        }
        if(Config::get('nea.global.admin-bar.disable-site-name') == true) {
            $wp_admin_bar->remove_node('site-name');
        }
        if(Config::get('nea.global.admin-bar.disable-widgets') == true) {
            $wp_admin_bar->remove_node('widgets');
        }
        if(Config::get('nea.global.admin-bar.disable-comments') == true) {
            $wp_admin_bar->remove_node('comments');
        }
        if(Config::get('nea.global.admin-bar.disable-new-content') == true) {
            $wp_admin_bar->remove_node('new-content');
        }
        if(Config::get('nea.global.admin-bar.disable-my-account') == true) {
            $wp_admin_bar->remove_node('my-account');
        }
    }

    public function removeAdminBarOnFrontEnd()
    {
        if((!wp_get_current_user()->user_email == 'rafal@burstofcode.com') && !is_admin() || App::environment(['staging', 'production'])) {
            show_admin_bar(false);
        }
    }
}
