<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function webplusgallery_register_block_type()
{
    register_block_type(
        'webplusplugin/webplus-gallery', array(
            'attributes' => array(
                'id' => array(
                    'type' => 'number',
                    'default' => 0
                ),
                'type' => array(
                    'type' => 'string',
                    'default' => 'horizontal'
                ),
                'className' => array(
                    'type' => 'string'
                ),
            ),
            'render_callback' => array(new WebplusGallery_Frontend, 'render'),
        )
    );
}

// Hook: Block assets.
add_action('init', 'webplusgallery_register_block_type');

if (is_admin()) {
    function webplusgallery_gutenberg_assets()
    {
        wp_register_script(
            'webplusgallery-cgb-block-js', // Handle.
            plugins_url('/dist/blocks.build.js', dirname(__FILE__)), // Block.build.js: We register the block here. Built with Webpack.
            array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), // Dependencies, defined above.
            filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
            true // Enqueue the script in the footer.
        );
        wp_enqueue_script('webplusgallery-cgb-block-js');
        // Register block editor styles for backend.
        wp_register_style(
            'webplusgallery-cgb-block-editor-css', // Handle.
            plugins_url('dist/blocks.editor.build.css', dirname(__FILE__)), // Block editor CSS.
            array('wp-edit-blocks'), // Dependency to include the CSS after it.
            filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
        );
        wp_enqueue_style('webplusgallery-cgb-block-editor-css');

        wp_register_style(
            'webplusgallery-cgb-style-css', // Handle.
            plugins_url('dist/blocks.style.build.css', dirname(__FILE__)), // Block style CSS.
            is_admin() ? array('wp-editor') : null, // Dependency to include the CSS after it.
            filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
        );
        wp_enqueue_style('webplusgallery-cgb-style-css');

        WebplusGallery_Frontend::assets();

    }

    add_action('enqueue_block_editor_assets', 'webplusgallery_gutenberg_assets');
}
