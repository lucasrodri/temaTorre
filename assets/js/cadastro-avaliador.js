function voltarListaEntradas() {
    document.getElementById('lista-entradas-div').style.display = 'inline';
    document.getElementById('entrada-form-div').style.display = 'none';
    document.getElementById('entrada-voltar-btn').style.display = 'none';
}

var redesArrayGlobal;

async function carrega_avaliador(user_id, redes, nomeInstituicao = '') {

    //console.log("recebi user_id " + user_id);
    //console.log("recebi redes " + redes);

    // mostrar div do conteúdo do form
    document.getElementById('lista-entradas-div').style.display = 'none';
    document.getElementById('entrada-form-div').style.display = 'inline';
    document.getElementById('entrada-voltar-btn').style.display = 'inline';

    document.getElementById('span-header-accordion').innerHTML = 'Instituição: ' + nomeInstituicao;

    document.getElementById('action-avaliador-input').value = 'Finalizar Avaliação de ' + nomeInstituicao;
    // não posso trocar o hidden pq tenho que associá-lo na function admin_post
    //document.getElementById('hidden-avaliador-input').value = 'atualiza_avaliador_' + user_id;

    // Preciso desse for em todos os tab-item para apága-los ao chamar de novo
    for (var i = 0; i < 6; i++) {
        if (document.getElementById('tab-item-' + (i + 2))) {
            document.getElementById('tab-item-' + (i + 2)).style.display = 'none';
        }
    }

    // limpar as entradas já preenchidas
    //limparFormAvaliador();

    // Removo o active das outras abas
    for (var i = 2; i <= 6; i++) {
        document.getElementById("tab-item-" + i).classList.remove("active");
        document.getElementById('panel-' + (i)).classList.remove("active");
    }

    // Preciso setar a primeira tab como ativa na primeira vez que chama
    document.getElementById("tab-item-1").className += " active";
    document.getElementById('panel-1').className += " active";

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
    redesArrayGlobal = redesArray;
    // crio novo array que relacion as redes com o número do painel
    var redesPainel = Array();
    for (var i = 0; i < redesArray.length - 1; i++) {
        redesPainel[i] = relaciona_painel(redesArray[i]);
    }

    for (var j = 0; j < redesPainel.length; j++) {
        painel = redesPainel[j]; //pego o número do painel

        document.getElementById('tab-item-' + painel).style.display = 'inline';

        await chama_carrega_rede(painel, redesArray[j], user_id);

    }
}


function chama_carrega_rede(painel, redeArray, user_id) {

    jQuery(function ($) {
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
                //console.log("Sucesso " + painel);
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

function relaciona_nome($s) {
    switch ($s) {
        case "check_suporte":
            return "Suporte";
        case "check_formacao":
            return "Formação Tecnológica";
        case "check_pesquisa":
            return "Pesquisa Aplicada";
        case "check_inovacao":
            return "Inovação";
        case "check_tecnologia":
            return "Tecnologias Aplicadas";
        case "geral":
            return "Instituição";
    }
}

// Função que realiza a validação para liberar o botão de enviar do Avaliador
function validacaoAvaliador() {
    var divResumo = document.getElementById('resumo-avaliador');

    if (divResumo.style.display == 'none') {
        divResumo.style.display = 'inline';
    }

    divResumo.innerHTML = '';
    var divs = ['geral'];
    var valid = [false]; // vetor para guardar o valor das validações

    // uso uma variável global (redesArrayGlobal) pra saber quais redes são usadas
    for (var i = 0; i < redesArrayGlobal.length - 1; i++) {
        divs.push(redesArrayGlobal[i]);
        valid.push(false);
    }

    // Percorro os itens nas divs (redes) usadas e procuro os valores do parecer e situação 
    for (var i = 0; i < divs.length; i++) {
        redeArray = divs[i];

        var parecer = document.getElementById('parecerAvaliador_' + redeArray);
        var pendente = document.getElementById('avaliador_' + redeArray + '_op_1');
        var homologado = document.getElementById('avaliador_' + redeArray + '_op_2');

        // validar parecer
        if (parecer.value == '') {
            setarInvalido(parecer);
            valid[i] = false;
        } else {
            //divResumo.innerHTML += '<i class="fas fa-check"></i> Parecer da aba ' + relaciona_nome(redeArray) + ' preenchido <br>';
            divResumo.innerHTML += '<span class="feedback success mb-1" role="alert"><i class="fas fa-check-circle" aria-hidden="true"></i> Parecer da aba ' + relaciona_nome(redeArray) + ' preenchido</span><br>';
            valid[i] = true;
        }

        // validar input radio
        if (!pendente.checked && !homologado.checked) {
            setarInvalido(homologado);
            setarInvalido(pendente);
            valid[i] = false;
        } else {
            //divResumo.innerHTML += '<i class="fas fa-check"></i> Situação da aba ' + relaciona_nome(redeArray) + ' selecionada <br>';
            divResumo.innerHTML += '<span class="feedback success mb-1" role="alert"><i class="fas fa-check-circle" aria-hidden="true"></i> Situação da aba ' + relaciona_nome(redeArray) + ' selecionada</span><br>';
            valid[i] = true;
        }
    }

    var botaoAvaliador = document.getElementById('action-avaliador-input');
    var spanAvaliador = document.getElementById('span-avaliador-input');

    // se há algum falso, o botão fica disabled
    if (valid.includes(false)) {
        botaoAvaliador.setAttribute("disabled", "");
        spanAvaliador.style.display = 'inline';
    } else {
        botaoAvaliador.removeAttribute("disabled");
        spanAvaliador.style.display = 'none';
    }
}

/*
Função para limpar o Form.
Sem uso no momento, decidimos utilizar uma tag <a> para voltar a seleção de instituicoes para avaliacao
*/
function limparFormAvaliador() {
    return;
    var divs = ['div_geral', 'div_check_suporte', 'div_check_formacao', 'div_check_pesquisa', 'div_check_inovacao', 'div_check_tecnologia'];

    for (var i = 0; i < 6; i++) {
        var div = document.getElementById(divs[i]);
        var elements = div.querySelectorAll('input, select, textarea');

        for (el of elements) {
            // limpar valor
            el.value = '';

            // if (el.type == 'select-multiple') {
            //     // limpar entradas do select2
            //     $(el).val(null).empty();
            // }

            if (el.type == 'radio') {
                el.checked = false;
            }

            el.parentElement.removeAttribute("valid");
            el.parentElement.classList.remove("success");
        }
    }

    // Limpar div de resumo
    document.getElementById('resumo-avaliador').innerHTML = '';
    // Desabilitar o botão por precaução
    document.getElementById('action-avaliador-input').setAttribute("disabled", "");
    // Mostrar aviso de preenchimento
    document.getElementById('span-avaliador-input').style.display = 'inline';
}