(function ($) {
    $.fn.webplusGallery = function (type) {
        if(type === 'vertical') {
            jQuery(this).lightSlider({
                gallery:true,
                item:1,
                loop:true,
                vertical:true,
                verticalHeight:330,
                vThumbWidth:50,
                thumbItem:8,
                thumbMargin:4,
                slideMargin:0,
                enableDrag: false,
                currentPagerPosition:'left',
                onSliderLoad: function(el) {
                    if ($.isFunction($.fn.lightGallery)) {
                        el.lightGallery({
                            selector: ".lslide"
                        });
                    }
                }
            });
        } else {
            jQuery(this).lightSlider({
                gallery: true,
                item: 1,
                loop: true,
                thumbItem: 9,
                slideMargin: 0,
                enableDrag: false,
                currentPagerPosition: 'left',
                onSliderLoad: function (el) {
                    if ($.isFunction($.fn.lightGallery)) {
                        el.lightGallery({
                            selector: ".lslide"
                        });
                    }
                }
            });
        }
    };

    $(".webplusGallery").each(function (index) {
        var type = $(this).data('type');
        $(this).webplusGallery(type);
    });
}(jQuery));