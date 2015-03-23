<?php
/*
Plugin Name: mapScrollPrevent for wordpress (jQuery Google Maps Scroll Prevent Plugin)
Plugin URI: https://github.com/diazemiliano/mapScrollPrevent
Description: mapScrollPrevent is an easy solution to the problem of page scrolling with Google Maps.
Version: 0.1
Author: Emiliano Díaz https://github.com/diazemiliano/
Author URI: The MIT License (MIT) Copyright (c) 2015 Emiliano Díaz.
*/


defined('ABSPATH') or die('Plugin file cannot be accessed directly.');

if (!class_exists('mapScrollPrevent')) {
    class mapScrollPrevent
    {
        /**
         * Tag identifier used by file includes and selector attributes.
         * @var string
         */
        protected $tag = 'mapscrollprevent';

        /**
         * User friendly name used to identify the plugin.
         * @var string
         */
        protected $name = 'mapScrollPrevent';

        /**
         * Current version of the plugin.
         * @var string
         */
        protected $version = '0.1';
    }
    new mapScrollPrevent;
}
