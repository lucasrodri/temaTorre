function carrega_candidato() {
  document.getElementById('carrega-form-btn').style.display = 'none';
  document.getElementById('edit-form-div').style.display = 'inline';
  document.getElementById('esconde-form-btn').style.display = 'inline';
}


function esconderFormulario() {
  document.getElementById('carrega-form-btn').style.display = 'inline';
  document.getElementById('edit-form-div').style.display = 'none';
  document.getElementById('esconde-form-btn').style.display = 'none';
}


function botaoRecurso() {
  var div = document.getElementById("recurso-div");
  var botao = document.getElementById("recurso-btn");

  div.style.display = "inline";
  botao.style.display = "none";
}


function atualizaRedeCandidatoGeral() {
  //jquery para atualizar tab 1 de instituição
  //   await jQuery(function ($) {
  //     $.ajax({
  //         type: "POST",
  //         url: my_ajax_object.ajax_url,
  //         data: {
  //             action: 'atualiza_geral_candidato',
  //             usuario_id: user_id,
  //         },
  //         beforeSend: function () {
  //             $("#loading_carregar").css("display", "block");
  //             $('#tab_instituicao').html('');
  //         },
  //         success: function (html) {
  //             $('#tab_instituicao').html(html);
  //         },
  //         complete: function (data) {
  //             $("#loading_carregar").css("display", "none");
  //         }
  //     });
  // });
}

//chama_carrega_rede(painel, redesArray[j], user_id);
function atualizaRedeCandidato(painel, redeArray, entrada) {

  // console.log(painel);
  // console.log(redeArray);
  // console.log(entrada);

  var div = document.getElementById('tab_redes_' + painel);
  var myNodelist = div.querySelectorAll('input, select, textarea'); //retorna uma NodeList
  // console.log({ myNodelist });

  // transformo a NodeList em um array que o php entenda
  var elements = {};

  for (let i = 0; i < myNodelist.length; i++) {

    //se for checkbox ou radio, pega apenas se está checked
    if (myNodelist[i].type == 'checkbox' || myNodelist[i].type == 'radio') {
      if (myNodelist[i].checked) {
        elements[myNodelist[i].name] = myNodelist[i].value;
      }
    } else {
      elements[myNodelist[i].name] = myNodelist[i].value;
    }
  }

  // console.log({ elements });

  jQuery(function ($) {
    $.ajax({
      type: "POST",
      url: my_ajax_object.ajax_url,
      data: {
        action: 'atualiza_rede_candidato',
        entrada: entrada,
        rede: redeArray,
        elements: elements,
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