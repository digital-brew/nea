<?php

namespace Rafflex\Nea\Modules;

use Illuminate\Support\Facades\Config;
use Themosis\Support\Facades\Action;

class UnregisterPosts
{
    public function register()
    {
        if(Config::get('nea.global.unregister-posts') == true) {
            Action::add('init', [$this, 'unregisterPostType']);
            Action::add('init', [$this, 'unregisterCategories']);
            Action::add('init', [$this, 'unregisterTags']);
            Action::add('init', [$this, 'unregisterWidget']);
        }
    }

    public function unregisterPostType()
    {
        register_post_type('post', []);
    }

    public function unregisterCategories()
    {
        register_taxonomy('category', []);
    }

    public function unregisterTags()
    {
        register_taxonomy('post_tag', []);
    }

    public function unregisterWidget()
    {
        unregister_widget('WP_Widget_Categories');
    }
}
