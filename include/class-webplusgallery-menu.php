<?php
Class WebplusGallery_Menu
{
    public $slug = 'edit.php?post_type=webplusgallery';

    public function __construct()
    {
        add_action('init', array($this, 'register_post_types'));

        add_action( 'admin_menu', array($this, 'register_admin_menu') );
    }

    public function register_post_types()
    {
        register_post_type('webplusgallery', [
            'label' => null,
            'labels' => array(
                'name' => __('Gallery WebPlus', 'webplusgallery'),
                'singular_name' => __('Gallery', 'webplusgallery'),
                'add_new' => __('Add Gallery', 'webplusgallery'),
                'add_new_item' => __('Add New Gallery', 'webplusgallery'),
                'edit_item' => __('Edit Gallery', 'webplusgallery'),
                'new_item' => __('New Gallery', 'webplusgallery'),
                'view_item' => __('View Gallery', 'webplusgallery'),
                'search_items' => __('Search Galleries', 'webplusgallery'),
                'not_found' => __('No Galleries found', 'webplusgallery'),
                'not_found_in_trash' => __('No Galleries found in Trash', 'webplusgallery'),
                'menu_name' => 'WebPlus Gallery',
                'all_items' => __('Galleries', 'webplusgallery')
            ),
            'hierarchical' => false,
            'public' => false,
            'rewrite' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'menu_icon' => 'dashicons-format-gallery',
            'supports' => array('title', 'thumbnail',),
        ]);
    }

    public function register_admin_menu(){
        add_menu_page( 'WebPlus Gallery', 'WebPlus Gallery', 'manage_options', $this->slug, false, 'dashicons-format-gallery', 16);
        add_submenu_page( $this->slug,'Create Gallery', 'Create Gallery', 'manage_options', 'post-new.php?post_type=webplusgallery', false, 1);
        if (!class_exists('WebplusLightGallery')) {
            add_submenu_page($this->slug, 'Pro version', 'Pro version', 'manage_options', 'pro-webplusgallery-version', array($this, 'page_pro'), 2);
        }
    }

    public function page_pro() {
        $html = '<h1>Pro version WebPlus Gallery</h1>';
        $html .= 'The PRO version includes an additional LightBox plugin that allows you to enlarge images from the gallery.<br />
            To connect to LightBox Gallery and order this plugin, write to me: <a href="mailto:pavel.borysenko@gmail.com">pavel.borysenko@gmail.com</a>';
        echo $html;
    }
}