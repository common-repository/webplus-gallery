<?php
Class WebplusGallery_Ajax {
    public function __construct() {

        add_action( 'wp_ajax_gutenbergwebplusgallery', array($this, 'gallery') );

        add_action( 'wp_ajax_gutenbergwebplusgalleryitems', array($this, 'galleryitems') );
    }

    public function gallery() {
        $posts = get_posts( array(
            'orderby'     => 'date',
            'order'       => 'DESC',
            'post_type'   => 'webplusgallery',
        ) );

        echo json_encode(array('items' =>$posts));
        die;
    }

    public function galleryitems() {
        $images = array();
        $items = get_post_meta(sanitize_text_field($_GET['galleryID']), 'uploader_custom',true);
        if(!empty($items) && is_array($items)) {
        foreach ($items as $key => $value) {
            if( $value ) {
				$thumb_attributes = wp_get_attachment_image_src( $value['image'], 'full');
				$image_attributes = wp_get_attachment_image_src( $value['image'], 'full');
				$image_src = wpthumb( $image_attributes[0], 'width=610&height=380&crop=1' );
				$thumb_src = wpthumb( $image_attributes[0], 'width=60&height=50&crop=1' );
                $image = $value['image'];
                $alt = $value['alt'];
                $images[] = array('src' => $image_src, 'thumb' => $thumb_src);
            }

        }
        }
        echo json_encode(array('items' =>$images));
        die;
    }
}
