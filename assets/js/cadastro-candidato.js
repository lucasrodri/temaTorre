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


async function atualizaRedeCandidatoGeral() {

  if (!confirm('Você tem certeza que quer enviar esses dados? Essa ação não poderá ser desfeita.')){
    return;
  }

  var entradaGeral = document.getElementById('entrada_geral').value;

  //https://wordpress.stackexchange.com/questions/280782/how-to-pass-both-action-and-formdata-in-wordpress-ajax
  var formData = new FormData(document.getElementById('tab_instituicao_form'));

  // tenho que enviar pelo FormData pq o jQuery ajax não aceita de outra forma
  formData.append("entrada", entradaGeral);

  await jQuery(function ($) {
    $.ajax({
      type: "POST",
      url: my_ajax_object.ajax_url,
      // data: {
      //   action: 'atualiza_geral_candidato',
      //   entrada: entradaGeral,
      //   elements: elements,
      // },
      data: formData,
      cache: false,
      processData: false,
      contentType: false,
      beforeSend: function () {
        $("#loading_carregar").css("display", "block");
        $('#tab_instituicao').html('');
      },
      success: function (html) {
        $('#tab_instituicao').html(html);
      },
      complete: function (data) {
        $("#loading_carregar").css("display", "none");
        //TODO enviar alerta de finalizado
        //TODO top of the page
      }
    });
  });

  await atualizaStatusGeral();
}


async function atualizaRedeCandidato(painel, redeArray, entrada) {

  if (!confirm('Você tem certeza que quer enviar esses dados? Essa ação não poderá ser desfeita.')){
    return;
  }
  
  var div = document.getElementById('tab_redes_' + painel);
  var myNodelist = div.querySelectorAll('input, select, textarea'); //retorna uma NodeList

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

  await jQuery(function ($) {
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
        //TODO enviar alerta de finalizado
        //TODO top of the page
      }
    });
  });

  await atualizaStatusGeral();
}

function atualizaStatusGeral(){
  //atualiza status geral
  jQuery(function ($) {
    $.ajax({
      type: "POST",
      url: my_ajax_object.ajax_url,
      data: {
        action: 'atualiza_status_geral',
      },
      beforeSend: function () {
        $("#loading_carregar_status").css("display", "block");
        $('#tdStatus').html('');
      },
      success: function (html) {
        $('#tdStatus').html(html);
      },
      complete: function () {
        // $("#loading_carregar_status").css("display", "none");
        // console.log('completo');
      }
    });
  });
}

function apagarAnexo(name) {
  if (confirm("Você está prestes a apagar o anexo! Essa ação não pode ser desfeita. Quer continuar?")) {

    //remover nome "anexo"
    var item = name.slice(6);

    //esconder div antiga
    var divAntiga = document.getElementById(item + '_old');
    divAntiga.style.display = "none";

    // mostrar div nova
    var divNova = document.getElementById(item + '_new');
    var pDivNova = document.getElementById(item + '_texto');

    divNova.style.display = "";
    pDivNova.style.display = "";

    // esconder o botão de apagar
    document.getElementById(name).style.display = "none";
  }
}