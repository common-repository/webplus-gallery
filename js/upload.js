jQuery(function ($) {
    $("#sortable_items").sortable();
    $("#sortable_items").disableSelection();
    /*
     * действие при нажатии на кнопку загрузки изображения
     * вы также можете привязать это действие к клику по самому изображению
     */
    $('.one_upload_image_button').click(function () {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);
        wp.media.editor.send.attachment = function (props, attachment) {
            $(button).parent().prev().attr('src', attachment.url);
            $(button).prev('input[type=hidden]').val(attachment.id);
            wp.media.editor.send.attachment = send_attachment_bkp;
        }
        wp.media.editor.open(button);
        return false;
    });

    $('.upload_image_button').click(open_media_window);

    function open_media_window() {
        if (this.window === undefined) {
            this.window = wp.media({
                title: 'Select images',
                library: {type: 'image'},
                multiple: true,
                button: {text: 'Insert'}
            });

            var self = this; // Needed to retrieve our variable in the anonymous function below

            //WHEN THE MAGIC STARTS
            this.window.on('select', function () {

                var attachments = self.window.state().get('selection').map(
                    function (attachment) {
                        attachment.toJSON();
                        return attachment;
                    });

                $.each(attachments, function (i, attachment) {
                    var child = $('#sortable_items li:nth-child(1)').clone(true).prependTo("#sortable_items");
                    $(child).find('img').attr('src', attachment.attributes.url);
                    var key = $('#key').val();
                    key++;
                    //alert(key);
                    $('#key').val(key);
                    $(child).find('input').each(function (index) {
                        var nameInput = $(this).attr('name').replace(/\d+/, key);
                        $(this).attr('name', nameInput);
                        //alert(nameInput);
                    });
                    $(child).find('input[type=hidden]').val(attachment.attributes.id);
                    $(child).find('input[type=text]').val('');
                    $(child).show();
                });
            });
            //WHEN THE MAGIC ENDS
        }

        this.window.open();
        return false;
    }

    /*
     * удаляем значение произвольного поля
     * если быть точным, то мы просто удаляем value у input type="hidden"
     */
    $('.remove_image_button').click(function () {
        var r = confirm("Delete?");
        if (r == true) {
            $(this).parent().parent().remove();
        }
        return false;
    });
});