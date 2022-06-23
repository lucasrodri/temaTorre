function carrega_avaliador(user_id, redes) {
    document.getElementById('edit-form-div').style.display = 'inline';
    jQuery(function ($) {
        $.ajax({
            type: "POST",
            url: my_ajax_object.ajax_url,
            data: {
                action: 'carrega_instituicao',
                usuario_id: user_id,
            },
            beforeSend: function () {
                $("#preloader").show();
                $('.preload-content').show();
            },
            success: function (html) {
                $('#tab_instituicao').html(html);
            },
            complete: function (data) {
                $("#preloader").hide();
                $('.preload-content').hide();
            }
        });
    });
    var redesArray = redes.split(";");
    for (var i = 0; i < redesArray.length - 1; i++) {
        document.getElementById('tab-item-'+(i+2)).style.display = 'inline';
        document.getElementById('panel-'+(i+2)).style.display = 'inline';
        //Aqui tá o erro... ele não roda essa função i vezes, ele roda apenas a ultima vez??
        console.log(redesArray[i]);
        jQuery(function ($) {
            console.log("Carrega"+(i+2));
            console.log(redesArray[i]);
            $.ajax({
                type: "POST",
                url: my_ajax_object.ajax_url,
                data: {
                    action: 'carrega_rede',
                    usuario_id: user_id,
                    rede: redesArray[i],
                },
                beforeSend: function () {
                    $("#preloader").show();
                    $('.preload-content').show();
                },
                success: function (html) {
                    console.log("Sucesso"+(i+2));
                    $('#tab_redes_'+(i+2)).html(html);
                },
                complete: function (data) {
                    $("#preloader").hide();
                    $('.preload-content').hide();
                }
            });
        });
    }
}