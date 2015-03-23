<?php
/*
Plugin Name: MapScrollPrevent for wordpress (jQuery Google Maps Scroll Prevent Plugin)
Plugin URI: https://github.com/diazemiliano/mapScrollPrevent/tree/wordpress
Description: mapScrollPrevent is an easy solution to the problem of page scrolling with Google Maps.
Version: 0.1
Author: Emiliano Díaz https://github.com/diazemiliano/
Author URI: The MIT License (MIT) Copyright (c) 2015 Emiliano Díaz.
*/

namespace MapScrollPrevent;

defined('ABSPATH') or die('Plugin file cannot be accessed directly.');

if (!class_exists('MapScrollPrevent')) {
    class MapScrollPrevent
    {
        protected $tag = 'mapscrollprevent';
        protected $name = 'MapScrollPrevent';
        protected $version = '0.1';

        public function __construct()
        {
            $this->_enqueue();
        }

        protected function enqueue()
        {
            $plugin_path = plugin_dir_url(__FILE__);

            if (!wp_script_is($this->tag, 'enqueued')) {

                wp_enqueue_script('jquery');

                wp_enqueue_script(
                    'jquery-' . $this->tag,
                    'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js?ver=2.1.3',
                    array('jquery'),
                    '2.1.3'
                );

                wp_enqueue_script(
                    $this->tag,
                    'https://cdn.rawgit.com/diazemiliano/mapScrollPrevent/master/dist/mapScrollPrevent.js',
                    array('jquery-' . $this->tag),
                    $this->version
                );
            }
        }
    }

    new MapScrollPrevent;
}
