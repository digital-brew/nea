<?php

namespace Rafflex\Nea\Modules;

use Illuminate\Support\Facades\Config;
use Themosis\Support\Facades\Action;
use Themosis\Support\Facades\Filter;

class Api
{
    public function register()
    {
        if((Config::get('nea.global.api.remove-json-api') == true)) {
            Action::add('after_setup_theme', [$this, 'removeJsonApi']);
        }

        if((Config::get('nea.global.api.disable-json-api') == true)) {
            Action::add('after_setup_theme', [$this, 'disableJsonApi']);
        }
    }

    /**
     * Remove JSON API capabilities
     */
    public function removeJsonApi()
    {
        // Remove the REST API lines from the HTML Header
        Action::remove('wp_head', 'rest_output_link_wp_head', 10);
        Action::remove('wp_head', 'wp_oembed_add_discovery_links', 10);

        // Remove the REST API endpoint.
        Action::remove('rest_api_init', 'wp_oembed_register_route');

        // Turn off oEmbed auto discovery.
       Filter::add('embed_oembed_discover', '__return_false');

        // Don't filter oEmbed results.
        Filter::remove('oembed_dataparse', 'wp_filter_oembed_result', 10);

        // Remove oEmbed discovery links.
        Action::remove('wp_head', 'wp_oembed_add_discovery_links');

        // Remove oEmbed-specific JavaScript from the front-end and back-end.
        Action::remove('wp_head', 'wp_oembed_add_host_js');
    }

    /**
     * Completely disable JSON API
     */
    public function disableJsonApi()
    {
        // Filters for WP-API version 1.x
        Filter::add('json_enabled', '__return_false');
        Filter::add('json_jsonp_enabled', '__return_false');

        // Filters for WP-API version 2.x
        Filter::add('rest_enabled', '__return_false');
        Filter::add('rest_jsonp_enabled', '__return_false');
    }
}
