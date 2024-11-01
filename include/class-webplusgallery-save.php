<?php

Class WebplusGallery_Save {
    public function __construct()
    {
        add_action( 'add_meta_boxes', array($this, 'register_meta_boxes') );
        //add_image_size( 'lightSliderThumb', 60, 50, true );
        //add_image_size( 'lightSlider', 610, 380, true );
        add_action( 'save_post', array($this, 'save_meta_box') );
        add_action( 'admin_enqueue_scripts', array($this, 'include_scripts') );

    }

    public function register_meta_boxes() {
        add_meta_box( 'webplusgallery', 'WebPlus Gallery', array($this, 'display_callback'), 'webplusgallery' );
    }

    public function display_callback( $post ) {
        echo '<ul id="sortable_items">';
        $key = 0;
        $this->true_image_uploader_field('uploader_custom', $key);
        $items = get_post_meta($post->ID, 'uploader_custom',true);
        if(!empty($items) && is_array($items)) {
        foreach ($items as $key => $value) {
            $this->true_image_uploader_field('uploader_custom', $key, $value);
        }
        }
        echo '</ul><div class="both"></div>';
        echo '<input type="hidden" name="key" id="key" value="' . ((!empty($items) && count($items)) ? max(array_keys($items)) : 0) . '" />';
        echo '<p class="center">
            <button type="submit" class="upload_image_button button-primary">Upload image</button>
            </p>';
    }

    private function true_image_uploader_field( $name, $key, $value = '', $w = 180, $h = 180) {
        if( $value ) {
            $image_attributes = wp_get_attachment_image_src( $value['image'], array($w, $h) );
            $src = $image_attributes[0];
            $image = $value['image'];
            $alt = $value['alt'];
        } else {
            $src = '';
            $alt = '';
            $image = '';
        }
        echo '
	<li class="';
        if($key == 0) {echo 'hidden';}
        echo' ui-state-default li-item-pic-box">
		<img src="' . $src . '" width="' . $w . 'px" height="' . $h . 'px" />
		<div>
		    <p>
		    <label for="alt">Alt:</label><input type="text" name="' . $name . '[' . $key . '][alt]" value="' . esc_html($alt) . '" size="10" />
		    </p>
			<input type="hidden" name="' . $name . '[' . $key . '][image]" value="' . esc_html($image) . '" />
			<button type="submit" class="one_upload_image_button button">Replace</button>
			<button type="submit" class="remove_image_button button">×</button>
		</div>
	</li>
	';
    }

    public function save_meta_box( $post_id ) {
        if(!empty($_POST['uploader_custom'])) {
            unset($_POST['uploader_custom'][0]);
            update_post_meta($post_id, 'uploader_custom', $this->recursive_sanitize_text_field($_POST['uploader_custom']));
        }
    }

    private function recursive_sanitize_text_field($array) {
        foreach ( $array as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = $this->recursive_sanitize_text_field($value);
            }
            else {
                $value = sanitize_text_field( $value );
            }
        }

        return $array;
    }

    public function include_scripts() {
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }
        wp_enqueue_style( 'jquery-ui', plugin_dir_url( __DIR__ ).'css/jquery-ui.css',false,'1.1','all');
        wp_enqueue_style( 'style', plugin_dir_url( __DIR__ ).'css/style.css',false,'1.1','all');

        wp_enqueue_script( 'upload', plugin_dir_url( __DIR__ ).'js/upload.js', array('jquery'), null, false );
    }
}
