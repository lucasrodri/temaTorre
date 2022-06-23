function carrega_avaliador() {
    jQuery(function ($) {
        $.ajax({
            type: "POST",
            url: my_ajax_object.ajax_url,
            data: {
                action: 'carrega_avaliador',
                //id: uf,
            },
            beforeSend: function () {
                $("#preloader").show();
                $('.preload-content').show();
            },
            success: function (html) {
                $('#tabMuni').html(html);
            },
            complete: function (data) {
                $("#preloader").hide();
                $('.preload-content').hide();
            }
        });
    });
}