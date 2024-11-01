<?php
Class WebplusGallery_Shortcode
{
    public function __construct()
    {
        add_shortcode( 'webplusgallery', array($this, 'render') );
    }

    public function render($attribites)
    {
        $frontend = new WebplusGallery_Frontend();
        return $frontend->render($attribites);
    }

}