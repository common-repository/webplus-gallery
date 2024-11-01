<?php
/*
 * Plugin Name: WebPlus Gallery
 * Description: Plugin gallery
 * Version: 1.5.2
 * Author: Pavel Borysenko
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

if(!class_exists('WP_Thumb')) {
	require_once plugin_dir_path(__FILE__) . 'include/WPThumb/wpthumb.php';
}

require_once plugin_dir_path(__FILE__) . 'src/init.php';
require_once plugin_dir_path(__FILE__) . 'include/class-webplusgallery-menu.php';
require_once plugin_dir_path(__FILE__) . 'include/class-webplusgallery-manage.php';
require_once plugin_dir_path(__FILE__) . 'include/class-webplusgallery-save.php';
require_once plugin_dir_path(__FILE__) . 'include/class-webplusgallery-ajax.php';
require_once plugin_dir_path(__FILE__) . 'include/class-webplusgallery-frontend.php';
require_once plugin_dir_path(__FILE__) . 'include/class-webplusgallery-shortcode.php';

new WebplusGallery_Menu();
new WebplusGallery_Manage();
new WebplusGallery_Save();
new WebplusGallery_Ajax();
new WebplusGallery_Shortcode();
