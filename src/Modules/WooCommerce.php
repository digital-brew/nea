<?php

namespace Rafflex\Nea\Modules;

use Illuminate\Support\Facades\Config;
use Themosis\Support\Facades\Action;
use Themosis\Support\Facades\Filter;

class WooCommerce
{
    public function register()
    {
        // Disable WooCommerce Admin, Analytics tab, Notification bar
        if(Config::get('nea.woocommerce.disable_wc_admin') == true) {
            Filter::add('woocommerce_admin_disabled', '__return_true');
        }

        // Marketing Hub
        if(Config::get('nea.woocommerce.disable_marketing_hub') == true) {
            Filter::add('woocommerce_marketing_menu_items', '__return_empty_array');
            Filter::add('woocommerce_admin_features', [$this, 'disableFeatures']);
        }

        // Disable Password Strength Meter
        if(Config::get('nea.woocommerce.disable_password_strength_meter') == true) {
            Action::add('wp_print_scripts', [$this, 'disablePasswordStrengthMeter'], 100);
        }

        // Disable WooCommerce Scripts
        if(Config::get('nea.woocommerce.disable_wc_scripts') == true) {
            Action::add('wp_enqueue_scripts', [$this, 'disableWoocommerceScripts'], 99);
        }

        // Disable WooCommerce Cart Fragmentation
        if(Config::get('nea.woocommerce.disable_wc_cart_fragmentation') == true) {
            Action::add('wp_enqueue_scripts', [$this, 'disableWoocommerceCartFragmentation'], 99);
        }

        // Disable WooCommerce Status Meta Box
        if(Config::get('nea.woocommerce.disable_wc_status_metabox') == true) {
            Action::add('wp_dashboard_setup', [$this, 'disableWoocommerceStatus']);
        }

        // Disable WooCommerce Marketplace Suggestions
        if(Config::get('nea.woocommerce.disable_wc_marketplace_suggestions') == true) {
            Filter::add('woocommerce_allow_marketplace_suggestions', '__return_false', 999);
        }

        // Disable WooCommerce Widgets
        if(Config::get('nea.woocommerce.disable_wc_widget') == true) {
            Action::add('widgets_init', [$this, 'disableWoocommerceWidgets'], 99);
        }
    }

    public function disableFeatures($features)
    {
        $marketing = array_search('marketing', $features);
        unset($features[$marketing]);
        return $features;
    }

    public function disablePasswordStrengthMeter() {
        global $wp;

        $wp_check = isset($wp->query_vars['lost-password']) || (isset($_GET['action'])
                && $_GET['action'] === 'lostpassword') || is_page('lost_password');

        $wc_check = (class_exists('WooCommerce') && (is_account_page() || is_checkout()));

        if(!$wp_check && !$wc_check) {
            if(wp_script_is('zxcvbn-async', 'enqueued')) {
                wp_dequeue_script('zxcvbn-async');
            }

            if(wp_script_is('password-strength-meter', 'enqueued')) {
                wp_dequeue_script('password-strength-meter');
            }

            if(wp_script_is('wc-password-strength-meter', 'enqueued')) {
                wp_dequeue_script('wc-password-strength-meter');
            }
        }
    }

    public function disableWoocommerceScripts() {
        if(function_exists('is_woocommerce')) {
            if(!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page() && !is_product()
                && !is_product_category() && !is_shop()) {

                //Dequeue WooCommerce Styles
                wp_dequeue_style('woocommerce-general');
                wp_dequeue_style('woocommerce-layout');
                wp_dequeue_style('woocommerce-smallscreen');
                wp_dequeue_style('woocommerce_frontend_styles');
                wp_dequeue_style('woocommerce_fancybox_styles');
                wp_dequeue_style('woocommerce_chosen_styles');
                wp_dequeue_style('woocommerce_prettyPhoto_css');
                //Dequeue WooCommerce Scripts
                wp_dequeue_script('wc_price_slider');
                wp_dequeue_script('wc-single-product');
                wp_dequeue_script('wc-add-to-cart');
                wp_dequeue_script('wc-checkout');
                wp_dequeue_script('wc-add-to-cart-variation');
                wp_dequeue_script('wc-single-product');
                wp_dequeue_script('wc-cart');
                wp_dequeue_script('wc-chosen');
                wp_dequeue_script('woocommerce');
                wp_dequeue_script('prettyPhoto');
                wp_dequeue_script('prettyPhoto-init');
                wp_dequeue_script('jquery-blockui');
                wp_dequeue_script('jquery-placeholder');
                wp_dequeue_script('fancybox');
                wp_dequeue_script('jqueryui');
//                wp_dequeue_script('wc-cart-fragments');
            }
        }
    }

    public function disableWoocommerceCartFragmentation()
    {
        if(function_exists('is_woocommerce')) {
            wp_dequeue_script('wc-cart-fragments');
        }
    }

    public function disableWoocommerceStatus()
    {
        remove_meta_box('woocommerce_dashboard_status', 'dashboard', 'normal');
    }

    public function disableWoocommerceWidgets()
    {
        unregister_widget('WC_Widget_Products');
        unregister_widget('WC_Widget_Product_Categories');
        unregister_widget('WC_Widget_Product_Tag_Cloud');
        unregister_widget('WC_Widget_Cart');
        unregister_widget('WC_Widget_Layered_Nav');
        unregister_widget('WC_Widget_Layered_Nav_Filters');
        unregister_widget('WC_Widget_Price_Filter');
        unregister_widget('WC_Widget_Product_Search');
        unregister_widget('WC_Widget_Recently_Viewed');
        unregister_widget('WC_Widget_Recent_Reviews');
        unregister_widget('WC_Widget_Top_Rated_Products');
        unregister_widget('WC_Widget_Rating_Filter');
    }
}
