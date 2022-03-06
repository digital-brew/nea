<?php

return [
    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views.
    |
    */
    'adminmenu' => [
        'first-item' => false
    ],
    /*
    |--------------------------------------------------------------------------
    | Disable WooCommerce Bloat Settings
    |--------------------------------------------------------------------------
    |
    | Below you will find four sections with settings which will speed up your shop.
    | Decide which unnecessary features should be disabled.
    | Disable bloatware features introduced in WooCommerce 4.0 and 4.1.
    | Remove different WooCommerce additional features that are slowing your page down.
    |
    */
    'woocommerce' => [
        /**
         * WooCommerce Admin
         *
         * This option will completely disable WooCommerce Admin, Analytics tab and Notification bar.
         * Home screen feature will also be disabled.
         */
        'disable_wc_admin' => false,
        /**
         * Marketing Hub
         *
         * This option will completely disable WooCommerce Marketing Hub. Coupon menu entry will stay
         * accessible the old way (WooCommerce -> Coupons).
         */
        'disable_marketing_hub' => false,
        /**
         * Password Strength Meter
         *
         * Removes the WordPress and WooCommerce password strength meter scripts (over 400 KB) from non-essential pages.
         */
        'disable_password_strength_meter' => false,
        /**
         * WooCommerce scripts and styles
         *
         * Use this option to disable WooCommerce scripts and styles everywhere except on product, cart
         * and checkout pages.
         */
        'disable_wc_scripts' => false,
        /**
         * WooCommerce Cart Fragmentation
         *
         * The cart fragments feature is used to update the cart total without refreshing the page.
         * Disabling it will speed up your store, but may result in wrong calculations in mini cart.
         * Use with caution.
         */
        'disable_wc_cart_fragmentation' => false,
        /**
         * WooCommerce Status Meta Box
         *
         * Enabling this option will remove WooCommerce Status Meta Box from WordPress Dashboard.
         */
        'disable_wc_status_metabox' => false,
        /**
         * Marketplace Suggestions
         *
         * Disable WooCommerce Marketplace Suggestions.
         */
        'disable_wc_marketplace_suggestions' => false,
        /**
         * WooCommerce Widgets
         *
         * WooCommerce by default comes with a lot of widgets installed. They often are not used at all,
         * but can add backend load and front-end load. Use this option to disable the WooCommerce widgets.
         */
        'disable_wc_widgets' => false
    ],
];
