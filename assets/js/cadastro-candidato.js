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

  if (!validacaoRedeCandidato('tab_instituicao_form')) {
    alert("Há campos inválidos!");
    return;
  }

  if (!confirm('Você tem certeza que quer enviar esses dados? Essa ação não poderá ser desfeita.')) {
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
        window.scrollTo(0, 0);
      },
      success: function (html) {
        $('#tab_instituicao').html(html);
        $('#titulo-status-cadastro_' + redeArray).remove();
      },
      complete: function (data) {
        $("#loading_carregar").css("display", "none");
        alert('Dados enviados!');
        atualizaStatusGeral();
      }
    });
  });
}

async function atualizaRedeCandidato(painel, redeArray, entrada) {

  // console.log('tab_redes_' + painel);
  if (!validacaoRedeCandidato('tab_redes_' + painel)) {
    alert("Há campos inválidos!");
    return;
  }

  if (!confirm('Você tem certeza que quer enviar esses dados? Essa ação não poderá ser desfeita.')) {
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
        window.scrollTo(0, 0);
      },
      success: function (html) {
        //console.log("Sucesso " + painel);
        $('#tab_redes_' + painel).html(html);

        var primeiro = $('#titulo-status-cadastro_' + redeArray);
        var segundo = $('#titulo-status-cadastro2_' + redeArray);
        primeiro.insertAfter(segundo);

        //$('#titulo-status-cadastro_' + redeArray).insertBefore($('#titulo-status-cadastro2_' + redeArray))
        $('#titulo-status-cadastro_' + redeArray).remove();
        //$('#titulo-status-cadastro2_' + redeArray).remove();
      },
      complete: function () {
        $("#loading_carregar").css("display", "none");
        alert('Dados enviados!');

        //mostrar div do botão de atualizar
        var divBotaoExcluir = document.getElementById("botaoExcluir_" + painel);
        divBotaoExcluir.style.display = 'inline';
        divBotaoExcluir.className = 'col-md-12';

        //mudar posicao do botão
        var divExcluir = divBotaoExcluir.querySelectorAll('div')[0]; //retorna uma NodeList
        divExcluir.className = 'text-center';

        $("#botaoAdicionar_" + painel).css("display", "none");
        $("#botaoAtualizar_" + painel).css("display", "none");
        atualizaStatusGeral();
      }
    });
  });
}


function atualizaStatusGeral() {
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

    //colocar elemento de upload como required
    var upload = document.getElementById(item);
    upload.setAttribute("required", "");

    // esconder o botão de apagar
    document.getElementById(name).style.display = "none";
  }
}


function validacaoRedeCandidato(painel) {
  // console.log('chamei validação');

  var div = document.getElementById(painel);
  var y = div.querySelectorAll('input, textarea'); //retorna uma NodeList

  // valid = true;

  var valid = true;
  var checarRadio = [];
  var checarCheckbox = [];
  var pular = ['estados-simples', 'cidades-simples'];


  var flag_tab = painel.includes('redes') ? true : false;

  for (i = 0; i < y.length; i++) {

    if (pular.includes(y[i].name)) {
      //pulando os selects 'estados-simples', 'cidades-simples'
      continue;
    }

    [checarRadio, checarCheckbox, valid] = validaInput(y[i], checarRadio, checarCheckbox, valid, flag_tab);

  }

  // console.log({checarRadio});
  // console.log({checarCheckbox});

  for (c = 0; c < checarRadio.length; c++) {
    valid = validaInputRadio(div, checarRadio[c], valid);
  }

  for (c = 0; c < checarCheckbox.length; c++) {
    valid = validaInputRadio(div, checarCheckbox[c], valid);
  }

  // console.log("VALID " + valid);
  return valid;
}


function validaInput(element, checarRadio, checarCheckbox, valid, flag_tab = false) {
  requirido = element.getAttribute("required");
  flagRequirido = false;

  // Checa apenas se o campo for requerido
  if ((requirido === "") || (flag_tab)) {
    flagRequirido = true;
  }

  switch (element.type) {
    case "textarea":

      if (flagRequirido && (element.value == "")) {
        setarInvalido(element);
        valid = false;
      }
      break;

    case "text":

      //pular o outroClassificacao, ele só é checado no check
      if (!element.name.includes("outroClassificacao")) {

        if (flagRequirido && (element.value == "")) {
          setarInvalido(element);
          valid = false;
        }

        if (element.name == "cnpjDaInstituicao") {
          if (!IsCNPJ(element.value)) {
            mostrarAvisoValidacao(element, 'CNPJ');
            valid = false;
          } else {
            ocultarAvisoValidacao(element);
          }
        }

        if (element.name.includes("cpfRepresentante_")) {
          if (!IsCPF(element.value)) {
            mostrarAvisoValidacao(element, 'CPF');
            valid = false;
          } else {
            ocultarAvisoValidacao(element);
          }
        }

        if (element.name == "cepDaInstituicao") {
          if (!element.checkValidity()) {
            valid = false;
            mostrarAvisoValidacao(element, 'CEP');
          } else {
            ocultarAvisoValidacao(element);
          }
        }
      }

      break;

    case "email":

      if (flagRequirido && (element.value == "")) {
        setarInvalido(element);
        valid = false;
      }

      if (!IsEmail(element.value)) {
        mostrarAvisoValidacao(element, 'E-mail');
        valid = false;
      } else {
        ocultarAvisoValidacao(element);
      }

      break;

    case "file":

      var extensoesPermitidas = {
        'logo_instituicao': ['jpg', 'png', 'jpeg'],
        'guia_instituicao': ['pdf'],
      }

      var tamanhoPermitido = {
        'logo_instituicao': 5242880,
        'guia_instituicao': 26214400,
      }

      if (flagRequirido || (element.value != "")) {

        //checar extensão
        var nomeArquivo = element.value.split(".");
        var extensao = nomeArquivo[nomeArquivo.length - 1].toLowerCase();

        if (!extensoesPermitidas[element.name].includes(extensao) || element.files.length == 0) {
          setarInvalido(element);
          valid = false;
        }

        if (element.files.length > 0) {
          var tamanho = element.files[0].size;

          if (tamanho > tamanhoPermitido[element.name]) {
            mostrarAvisoValidacao(document.getElementById(element.name), 'Arquivo');
            valid = false;
          } else {
            ocultarAvisoValidacao(document.getElementById(element.name));
          }
        }

      }
      break;

    case "url":

      if (flagRequirido && (element.value == "")) {
        setarInvalido(element);
        valid = false;
      }

      if (element.name == "urlDaInstituicao") {
        if (!IsURL(element.value)) {
          mostrarAvisoValidacao(element, 'URL');
          valid = false;
        } else {
          ocultarAvisoValidacao(element);
        }
      }

      break;

    case "tel":

      if (flagRequirido && (element.value == "")) {
        setarInvalido(element);
        valid = false;
      }

      if (!element.checkValidity()) {
        valid = false;
        mostrarAvisoValidacao(element, 'Telefone');
      } else {
        ocultarAvisoValidacao(element);
      }

      break;

    case "radio":

      classe = element.classList.item(0);
      // If específico para natureza_op
      if (classe == 'natureza_op') {
        if (!checarRadio.includes(classe)) {
          checarRadio.push(classe);
        }
      }

      // Se o natureza_op for igual 4 ou 5 (instituição privada), inclui o outro radio para validação
      if (element.checked == true && (element.id == "natureza_op_4" || element.id == "natureza_op_5")) {
        //console.log( 'entrei na validação dos op4 e op5' );
        checarRadio.push('porte_op');
      }

      break;

    case "checkbox":

      classe = element.classList.item(0);

      if (!checarCheckbox.includes(classe)) {
        checarCheckbox.push(classe);
      }

      break;

    // default:
    //   console.log("default");
    //   console.log(element.type);
    //   console.log(element.name);
    //   // code block
    //   break;

  }

  return [checarRadio, checarCheckbox, valid];
}

function validaInputRadio(div, classe, valid) {

  // console.log("checando classe " + classe)
  var r, flag = false;
  r = div.getElementsByClassName(classe);

  // console.log("tamanho de r (radio) " + r.length);

  if (r.length > 0) {

    flag = false;

    for (i = 0; i < r.length; i++) {
      if (r[i].checked) {
        flag = true;

        //adiciona verificação para outro
        if (r[i].value == "Outro") {
          // check_classificacao_3_rede-de-inovacao
          nomeRede = r[i].name.split("_");
          //outroClassificacao_rede-de-inovacao
          nomeOutro = 'outroClassificacao_' + nomeRede[nomeRede.length - 1];

          outroElement = document.getElementById(nomeOutro);

          if (outroElement.value == "") {
            setarInvalido(outroElement);
          }

        }
      }
    }

    if (!flag) {

      for (i = r.length - 1; i >= 0; i--) {
        setarInvalido(r[i]);
      }

      valid = false;
    }

  }
  return valid;
}

function criarRedeCandidato(painel, redeArray) {
  //mostrar a div dentro do cadastro render
  document.getElementById(relaciona(redeArray)[0]).style.display = 'inline';

  //apagar o botão qeu a chamou 
  document.getElementById("botaoAdicionar_" + painel).style.display = 'none';

  //mostrar div do botão de atualizar
  var divBotaoAtualizar = document.getElementById("botaoAtualizar_" + painel);
  divBotaoAtualizar.style.display = 'inline';
  divBotaoAtualizar.className = 'col-md-12';

  //mudar posicao do botão
  var divAtualizar = divBotaoAtualizar.querySelectorAll('div')[0]; //retorna uma NodeList
  divAtualizar.className = 'text-center';

  //renomear botão
  var botaoAtualizar = divBotaoAtualizar.querySelectorAll('button')[0]; //retorna uma NodeList
  botaoAtualizar.innerHTML = 'Enviar nova submissão!';
}

async function excluirRedeCandidato(painel, redeArray, entrada) {

  if (!confirm('Você tem certeza que quer excluir a entrada nesta rede? Essa ação não poderá ser desfeita.')) {
    return;
  }

  await jQuery(function ($) {
    $.ajax({
      type: "POST",
      url: my_ajax_object.ajax_url,
      data: {
        action: 'exclui_rede_candidato',
        entrada: entrada,
        rede: redeArray,
      },
      beforeSend: function () {
        $("#loading_carregar").css("display", "block");
        $('#tab_redes_' + painel).html('');
        window.scrollTo(0, 0);
      },
      success: function (html) {
        //console.log("Sucesso " + painel);
        $('#tab_redes_' + painel).html(html);
        $("#botaoEdita_"+painel).css("display", "none");
        $('#titulo-status-cadastro_' + redeArray).remove();
        $('#historico-status-cadastro_' + redeArray).remove();
      },
      complete: function () {
        $("#loading_carregar").css("display", "none");
        alert('Dados enviados!');
        $("#botaoAdicionar_" + painel).css("display", "inline");
        $("#botaoExcluir_" + painel).css("display", "none");
        atualizaStatusGeral();

        //Para fazer voltar funcionar a mascara:
        $("input[type='tel']").each(function (index) {
          $(this).mask("(00) 0000-00009");
        });
        $("#cpfRepresentante_rede-de-suporte").mask("999.999.999-99");
        $("#cpfRepresentante_rede-de-formacao").mask("999.999.999-99");
        $("#cpfRepresentante_rede-de-inovacao").mask("999.999.999-99");
        $("#cpfRepresentante_rede-de-pesquisa").mask("999.999.999-99");
        $("#cpfRepresentante_rede-de-tecnologia").mask("999.999.999-99");
      }
    });
  });
}

function editaRedeCandidato(painel, redeArray, entrada) {
  document.getElementById("botaoEdita_" + painel).style.display = 'none';
  document.getElementById("botaoAtualizar_" + painel).style.display = '';
  document.getElementById("botaoAtualizar_" + painel).className = "mt-5 col-md-12";
  document.getElementById("botaoAtualizar_" + painel).children[0].className = "text-center";

  //Liberar os campos para edição
  var div = document.getElementById('tab_redes_' + painel);
  var y = div.querySelectorAll('input, textarea'); //retorna uma NodeList

  for (i = 0; i < y.length; i++) {
    element = y[i];
    disabled = element.getAttribute("disabled");

    if (disabled === "") {
      element.removeAttribute("disabled");
    }
  }
}