<?php
/*
Plugin Name: MapScrollPrevent
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
        protected $options = array();
        protected $settings = array(
          'selector' => array(
            'description' => 'Google Map Slector',
            'validator' => 'small-text',
            'default' => 'iframe[src*=\"google.com/maps\"]',
          )
        );

        public function __construct()
        {
            if ($options = get_option($this->tag)) {
                $this->options = $options;
            }

            if (is_admin()) {
                add_action('admin_init', array(&$this, 'settings'));
            }

            $this->enqueue();

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
                add_action('wp_head', array( &$this, 'custom_js'));
                // $options = array_merge(
                //     $this->options
                // );

                // wp_localize_script($this->tag, $this->tag, $options);
                // wp_enqueue_script($this->tag);
            }
        }

        public function custom_js()
        {
            echo '<script type="text/javascript">
            $(function() {
              var googleMapSelector = "'.$this->options['jQuerySelector'].'";
                $(googleMapSelector).mapScrollPrevent();
            });
            </script>';
        }

        public function settings()
        {
            $section = 'media';
            add_settings_section(
                $this->tag . '_settings_section',
                $this->name . ' Settings',
                function () {
                  echo '<p>Configuration options for the ' . esc_html($this->name) . ' plugin.</p>';
                },
                $section
            );
            foreach ($this->settings as $id => $options) {
                $options['id'] = $id;
                add_settings_field(
                    $this->tag . '_' . $id . '_settings',
                    $id,
                    array( &$this, 'settings_field' ),
                    $section,
                    $this->tag . '_settings_section',
                    $options
                );
            }
            register_setting(
                $section,
                $this->tag,
                array( &$this, 'settings_validate' )
            );
        }

        public function settings_field(array $options = array())
        {
            $atts = array(
              'id' => $this->tag . '_' . $options['id'],
              'name' => $this->tag . '[' . $options['id'] . ']',
              'type' => ( isset( $options['type'] ) ? $options['type'] : 'text' ),
              'class' => 'regular-text',
              'value' => (array_key_exists('default', $options) ? $options['default'] : null)
            );
            if (isset( $options['placeholder'])) {
                $atts['placeholder'] = $options['placeholder'];
            }

            array_walk($atts, function (&$item, $key) {
                $item = esc_attr($key) . '="' . esc_attr($item) . '"';
            });

            echo '<label for="'.$this->tag . '_' . $options['id'] .'">';
            if (array_key_exists('description', $options)) {
                esc_html_e($options['description']);
            }
            echo '</label>';
            echo '<input ' . implode(' ', $atts) .' />';
        }

        public function settings_validate($input)
        {
            $errors = array();
            foreach ($input as $key => $value) {
                if ($value == '') {
                    unset($input[$key]);
                    continue;
                }
                $validator = false;
                if (isset( $this->settings[$key]['validator'])) {
                    $validator = $this->settings[$key]['validator'];
                }
                switch ($validator) {
                    case 'numeric':
                        if (is_numeric($value)) {
                            $input[$key] = intval($value);
                        } else {
                            $errors[] = $key . ' must be a numeric value.';
                            unset( $input[$key] );
                        }
                        break;
                    default:
                          $input[$key] = strip_tags($value);
                        break;
                }
            }
            if (count($errors) > 0) {
                add_settings_error(
                    $this->tag,
                    $this->tag,
                    implode('<br />', $errors),
                    'error'
                );
            }
            return $input;
        }
    }

    new MapScrollPrevent;
}
