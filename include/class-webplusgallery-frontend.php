<?php
Class WebplusGallery_Frontend
{
    private static $instanceAssets = false;

    public function __construct()
    {

    }

    public function render($attribites)
    {
        if(empty($attribites['id'])) {
            return;
        }

        if (!is_admin()) {
            self::assets();
        }

        $out = '<div class="webplusGalleryWrap">';
        $out .= '<div class="webplusGallery" data-type="' . esc_html($attribites['type']) . '">';
        $items = get_post_meta($attribites['id'], 'uploader_custom',true);
        foreach ($items as $key => $value) {
            if( $value ) {
                $thumb_attributes = wp_get_attachment_image_src( $value['image'], 'full');
                $image_attributes = wp_get_attachment_image_src( $value['image'], 'full');
                $image_src = wpthumb( $image_attributes[0], 'width=610&height=380&crop=1' );
                $thumb_src = wpthumb( $image_attributes[0], 'width=60&height=50&crop=1' );
                $image = $value['image'];
                $alt = $value['alt'];
                $out .= '<div data-thumb="' . $thumb_src . '" data-src="' . $image_src . '">
                                <img src="' . $image_src . '" alt="' . esc_html($alt) . '" />
                          </div>';
            }
        }
        $out .= '</div>';
        $out .= '</div>';
        return $out;
    }

    public static function assets()
    {
        if (static::$instanceAssets === false) {
			wp_enqueue_script("jquery");

            wp_register_style(
                'webplusgallery_plugin-lightslider-css', // Handle.
                plugins_url('js/lightslider/src/css/lightslider.css', dirname(__FILE__)), // Block editor CSS.
                array(), // Dependency to include the CSS after it.
                null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
            );
            wp_enqueue_style('webplusgallery_plugin-lightslider-css');

            wp_register_script(
                'webplusgallery_plugin-lightslider-js', // Handle.
                plugins_url('js/lightslider/src/js/lightslider.js', dirname(__FILE__)), // Block.build.js: We register the block here. Built with Webpack.
                array(), // Dependencies, defined above.
                null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
                true // Enqueue the script in the footer.
            );
            wp_enqueue_script('webplusgallery_plugin-lightslider-js');

            if (class_exists('WebplusLightGallery')) {
                WebplusLightGallery::assets();
            }

            wp_register_script(
                'webplusgallery_plugin-webplusgallery-js', // Handle.
                plugins_url('js/webplusgallery.js', dirname(__FILE__)), // Block.build.js: We register the block here. Built with Webpack.
                array(), // Dependencies, defined above.
                filemtime(plugin_dir_path(__DIR__) . 'js/webplusgallery.js'), // Version: filemtime — Gets file modification time.
                true // Enqueue the script in the footer.
            );
            wp_enqueue_script('webplusgallery_plugin-webplusgallery-js');

            static::$instanceAssets = true;
        }
    }


}
