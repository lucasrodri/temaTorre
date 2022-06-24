async function carrega_avaliador(user_id, redes) {

    console.log("recebi user_id " + user_id);
    console.log("recebi redes " + redes);

    // mostrar div do conteúdo do form
    document.getElementById('edit-form-div').style.display = 'inline';

    // Preciso desse for em todos os tab-item para apága-los ao chamar de novo
    for (var i = 0; i < 6; i++) {
        if (document.getElementById('tab-item-' + (i + 2))) {
            document.getElementById('tab-item-' + (i + 2)).style.display = 'none';
            document.getElementById('panel-' + (i + 2)).style.display = 'none';
        }
    }

    // // Removo o active das outras abas
    // for (var i = 1; i < 6; i++) {
    //     document.getElementById("tab-item-"+i).classList.remove("active");
    // }
    // // Preciso setar a primeira tab como ativa na primeira vez que chama
    // document.getElementById("tab-item-1").className += " active";

    //jquery para mostrar tab 1 de instituição
    await jQuery(function ($) {
        $.ajax({
            type: "POST",
            url: my_ajax_object.ajax_url,
            data: {
                action: 'carrega_instituicao',
                usuario_id: user_id,
            },
            beforeSend: function () {
                $("#loading_carregar").css("display", "block");
                $('#tab_instituicao').html('');
                // $('.tab-panel').each(function () {
                //     $(this).css("display", "none");
                //   });
            },
            success: function (html) {
                $('#tab_instituicao').html(html);
            },
            complete: function (data) {
                $("#loading_carregar").css("display", "none");
            }
        });
    });

    // mostrar redes
    var redesArray = redes.split(";");
    // crio novo array que relacion as redes com o número do painel
    var redesPainel = Array();
    for (var i = 0; i < redesArray.length - 1; i++) {
        redesPainel[i] = relaciona_painel(redesArray[i]);
    }
    console.log({ redesPainel });
    console.log({ redesArray });


    for (var j = 0; j < redesPainel.length; j++) {
        painel = redesPainel[j]; //pego o número do painel

        document.getElementById('tab-item-' + painel).style.display = 'inline';
        document.getElementById('panel-' + painel).style.display = 'inline';

        console.log('mostra tab-item-' + painel);
        console.log('mostra panel-item-' + painel);

        console.log('renderizando ' + redesArray[j] + " do user " + user_id);
        
        await chama_carrega_rede(painel, redesArray[j], user_id);

    }

    /*
    for (var i = 0; i < redesArray.length - 1; i++) {
        document.getElementById('tab-item-' + (i + 2)).style.display = 'inline';
        document.getElementById('panel-' + (i + 2)).style.display = 'inline';

        console.log('mostra tab-item-' + (i + 2));
        console.log('mostra panel-item-' + (i + 2));

        //Aqui tá o erro... ele não roda essa função i vezes, ele roda apenas a ultima vez??
        console.log(redesArray[i]);

        jQuery(function ($) {
            console.log("Carrega " + (i + 2));
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
                    console.log("Sucesso " + (i + 2));
                    $('#tab_redes_' + (i + 2)).html(html);
                },
                complete: function (data) {
                    $("#preloader").hide();
                    $('.preload-content').hide();
                }
            });
        });
    }
    */
}


function chama_carrega_rede(painel, redeArray, user_id) {

    jQuery(function ($) {
        console.log("Carrega " + painel);
        console.log(redeArray);
        $.ajax({
            type: "POST",
            url: my_ajax_object.ajax_url,
            data: {
                action: 'carrega_rede',
                usuario_id: user_id,
                rede: redeArray,
            },
            beforeSend: function () {
                $("#loading_carregar").css("display", "block");
                $('#tab_redes_' + painel).html('');
            },
            success: function (html) {
                console.log("Sucesso " + painel);
                $('#tab_redes_' + painel).html(html);
                
            },
            complete: function () {
                $("#loading_carregar").css("display", "none");
            }
        });
    });
}

function relaciona_painel($s) {
    switch ($s) {
        case "check_suporte":
            return 2;
        case "check_formacao":
            return 3;
        case "check_pesquisa":
            return 4;
        case "check_inovacao":
            return 5;
        case "check_tecnologia":
            return 6;
    }
}