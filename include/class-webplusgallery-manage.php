<?php

Class WebplusGallery_Manage {
    public function __construct()
    {
        add_filter('manage_webplusgallery_posts_columns', array($this, 'add_views_column'), 4);

        add_filter('manage_webplusgallery_posts_custom_column', array($this, 'fill_views_column'), 5, 2);

        add_action('admin_head', array($this, 'add_image_column_css'));
    }

    public function add_views_column( $columns ){
        $out = array();
        $i = 0;
        foreach($columns as $col=>$name){
            $i++;
            if($i==2) {
                $out['image'] = 'Image';
            }
            if($i==3) {
                $out['shortcode'] = 'Shortcode';
            }
            $out[$col] = $name;
        }

        return $out;
    }

    public function fill_views_column( $colname, $post_id ){
        if( $colname === 'image' ){
            $items = get_post_meta($post_id, 'uploader_custom',true);
            if(!empty($items)) {
                $item = array_shift($items);
                $image_attributes = wp_get_attachment_image_src($item['image'], array(100, 100));
                $src = $image_attributes[0];
                echo '<img src="' . $src . '" width="100" height="100" />';
            }
        }
        if( $colname === 'shortcode' ){
            echo '[webplusgallery id="' . $post_id . '" type="horizontal"]'.'<br />';
            echo '[webplusgallery id="' . $post_id . '" type="vertical"]';
        }
    }

    public function add_image_column_css(){
        if( get_current_screen()->base == 'edit')
            echo '<style type="text/css">.column-image{width:10%;}</style>';
    }
}