function voltarListaEntradas() {
    document.getElementById('lista-entradas-div').style.display = 'inline';
    document.getElementById('entrada-form-div').style.display = 'none';
    document.getElementById('entrada-voltar-btn').style.display = 'none';
}

var redesArrayGlobal;

async function carrega_avaliador(user_id, redes, nomeInstituicao = '', flag_gerente = 'false', flag_homologado = 'false') {

    // mostrar div do conteúdo do form
    document.getElementById('lista-entradas-div').style.display = 'none';
    document.getElementById('entrada-form-div').style.display = 'inline';
    document.getElementById('entrada-voltar-btn').style.display = 'inline';

    document.getElementById('span-header-accordion').innerHTML = 'Instituição: ' + nomeInstituicao;

    // Preciso desse for em todos os tab-item para apága-los ao chamar de novo
    for (var i = 0; i < 6; i++) {
        if (document.getElementById('tab-item-' + (i + 2))) {
            document.getElementById('tab-item-' + (i + 2)).style.display = 'none';
        }
    }

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
                flag: flag_gerente,
                flag_homologado: flag_homologado
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

                if (flag_gerente == 'false' && document.getElementById('action-avaliador-input')) {
                    document.getElementById('action-avaliador-input').value = 'Finalizar Avaliação de ' + nomeInstituicao;
                }
                if (document.getElementById('div_geral')) {
                    var historico = document.getElementById('div_geral');
                    var titulo = historico.nextSibling;
                    while (titulo && titulo.nodeType != 1) {
                        titulo = titulo.nextSibling;
                    }
                    if (historico && titulo && titulo.id != "posts-publicados") {
                        historico.before(titulo);
                    }
                }
            }
        });
    });

    // mostrar redes
    var redesArray = redes.split(";");
    redesArrayGlobal = redesArray;
    // crio novo array que relacion as redes com o número do painel
    var redesPainel = Array();
    for (var i = 0; i < redesArray.length - 1; i++) {
        redesPainel[i] = relaciona(redesArray[i])[2];
    }

    for (var j = 0; j < redesPainel.length; j++) {
        painel = redesPainel[j]; //pego o número do painel

        document.getElementById('tab-item-' + painel).style.display = 'inline';

        await chama_carrega_rede(painel, redesArray[j], user_id, flag_gerente, flag_homologado);

    }
}


function chama_carrega_rede(painel, redeArray, user_id, flag_gerente, flag_homologado) {

    jQuery(function ($) {
        $.ajax({
            type: "POST",
            url: my_ajax_object.ajax_url,
            data: {
                action: 'carrega_rede',
                usuario_id: user_id,
                rede: redeArray,
                flag_gerente: flag_gerente,
                flag_homologado: flag_homologado
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
                if (document.getElementById('div_' + redeArray)) {
                    var historico = document.getElementById('div_' + redeArray);
                    var titulo = historico.nextSibling;
                    while (titulo && titulo.nodeType != 1) {
                        titulo = titulo.nextSibling;
                    }
                    if (historico && titulo && titulo.id != "posts-publicados") {
                        historico.before(titulo);
                    }
                }
            }
        });
    });
}


function relaciona($s) {
    //retorna slug da rede, nome da rede e painel
    switch ($s) {
        case "check_suporte":
            return ["rede-de-suporte", "Suporte", 2];
        case "check_formacao":
            return ["rede-de-formacao", "Formação Tecnológica", 3];
        case "check_pesquisa":
            return ["rede-de-pesquisa", "Pesquisa Aplicada", 4];
        case "check_inovacao":
            return ["rede-de-inovacao", "Inovação", 5];
        case "check_tecnologia":
            return ["rede-de-tecnologia", "Tecnologias Aplicadas", 6];
        case "geral":
            return ["instituicao", "Instituição", 0];
    }
}

// Função auxiliar para chamar o changeError e a validação
function changeErrorValidacao(name) {
    changeError(name);
    validacaoAvaliador();
}

// Função auxiliar para chamar o changeErrorRadio e a validação
function changeErrorRadioValidacao(name) {
    changeErrorRadio(name);
    validacaoAvaliador();
}


// Função que realiza a validação para liberar o botão de enviar do Avaliador
function validacaoAvaliador() {
    var divResumo = document.getElementById('resumo-avaliador');

    if (divResumo.style.display == 'none') {
        divResumo.style.display = 'block';
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

        if (document.getElementById('parecerAvaliador_' + redeArray)) {
            var parecer = document.getElementById('parecerAvaliador_' + redeArray);
            var pendente = document.getElementById('avaliador_' + redeArray + '_op_1');
            var homologado = document.getElementById('avaliador_' + redeArray + '_op_2');
            var tagsDiv = document.getElementById('tags_' + redeArray);

            // validar parecer apenas se não for homologado
            if (!homologado.checked && parecer.value == '') {
                setarInvalido(parecer);
                valid[i] = false;
            } else {
                divResumo.innerHTML += '<span class="feedback success mb-1" role="alert"><i class="fas fa-check-circle" aria-hidden="true"></i> Parecer da aba ' + relaciona(redeArray)[1] + ' válido</span><br>';
                setarValido(parecer);
                valid[i] = true;
            }

            // validar input radio
            if (!pendente.checked && !homologado.checked) {
                setarInvalido(homologado);
                setarInvalido(pendente);
                valid[i] = false;
            } else {
                divResumo.innerHTML += '<span class="feedback success mb-1" role="alert"><i class="fas fa-check-circle" aria-hidden="true"></i> Situação da aba ' + relaciona(redeArray)[1] + ' selecionada</span><br>';
                valid[i] = true;
            }

            // mostra as tags caso homologado
            if (tagsDiv) {
                if (homologado.checked) {
                    tagsDiv.style.display = 'block';
                } else {
                    tagsDiv.style.display = 'none';
                }
            }
        } else {
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
