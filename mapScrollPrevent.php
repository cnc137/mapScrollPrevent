<?php
/*
Plugin Name:
Plugin URI:
Description:
Version: 0.1
Author:
Author URI:
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
