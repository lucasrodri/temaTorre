var wizard1_size = '600px';
var wizard2_size = '1600px';
var wizard3_size = '2500px';
var wizard4_size = '500px';
var wizard5_size = '500px';

function arrumaTamanhoJanela(index) {

  for (var j = 0; j < 10; j++) {

    // console.log( 'chamei arrumaTamanhoJanela ' + index );

    var wizard_sizes = {}
    var panelsContent = document.getElementsByClassName("wizard-panel-content");

    for (var i = 0; i < panelsContent.length; i++) {

      // if ( i == index ) {
      //   console.log( i + ' : ' + panelsContent[ i ].clientHeight );
      //   console.log( i + ' : ' + panelsContent[ i ].offsetHeight );
      //   console.log( i + ' : ' + panelsContent[ i ].scrollHeight );
      // }
      var altura = panelsContent[i].scrollHeight;

      //não sei pq tem que ser 300
      altura += 300;

      wizard_sizes[i] = altura;
    }

    // wizard_sizes = {
    //   0: '600px',
    //   1: '2000px',
    //   2: '2500px',
    //   3: '800px',
    //   4: '1000px',
    // }

    //console.log( wizard_sizes );
    //{0: 301, 1: 1384, 2: 2174, 3: 389, 4: 677}
    //console.log( "setando altura para: " + wizard_sizes[ index ] );

    document.getElementById('cadastro_wizard').style.height = wizard_sizes[index] + 'px';
  }
}

function retornaPainelAtivo() {
  panels = document.getElementsByClassName("wizard-panel");

  for (var i = 0; i < panels.length; i++) {

    ativo = panels[i].getAttribute("active");

    if (ativo === "") {
      return i;
    }
  }
}

jQuery(document).ready(function ($) {

  //colocando um if para não dar erros em outras páginas
  if (document.getElementById('cadastro_wizard')) {
    // começa chamando a primeira altura
    arrumaTamanhoJanela(0);
  }

  /**
   * Ajuste do tamanho da aba
   */

  $(".wizard-progress").find(":button").each(function (index) {
    // procura todos os botões dentro de wizard-progress e adiciona uma chamada a função de arrumar janela ao clicar
    $(this).click(function () {
      arrumaTamanhoJanela(index);
    });

  });


  $('.wizard-btn').click(function () {
    //console.log( 'cliquei no wizard btn' );
    index = retornaPainelAtivo();

    if (validaFormulario()) {

      $(this).addClass('wizard-btn-next');

      //console.log( 'cliquei no next btn ' + index );
      arrumaTamanhoJanela(index + 1);
      window.scrollTo(0, 0);

    } else {

      $(this).removeClass('wizard-btn-next');
      arrumaTamanhoJanela(index);
    }


  });


  $('.wizard-btn-prev').click(function () {

    index = retornaPainelAtivo();
    //console.log( 'cliquei no previous btn ' + index );
    arrumaTamanhoJanela(index - 1);
    window.scrollTo(0, 0);

  });

  /**
   * Máscaras
   */
  //$("#telefoneDoGestor").mask("(00) 0000-00009");
  //$("#celDoGestor").mask("(00) 0000-00009");
  //$("#telefoneDaUnidade").mask("(00) 0000-00009");
  //$("#celDaUnidade").mask("(00) 0000-00009");
  //$("#cpfDoGestor").mask("999.999.999-99");
  $("#cnpjDaInstituicao").mask("99.999.999/9999-99");
  $("#cepDaInstituicao").mask("00000-000");

  $("input[type='tel']").each(function (index) {
    $(this).mask("(00) 0000-00009");
  });

  $("#cpfRepresentante_rede-de-suporte").mask("999.999.999-99");
  $("#cpfRepresentante_rede-de-formacao").mask("999.999.999-99");
  $("#cpfRepresentante_rede-de-inovacao").mask("999.999.999-99");
  $("#cpfRepresentante_rede-de-pesquisa").mask("999.999.999-99");
  $("#cpfRepresentante_rede-de-tecnologia").mask("999.999.999-99");
  
  //colocando um if para não dar erros em outras páginas
  // if (document.getElementById('cadastro_wizard') || document.getElementById('radio_function')) {
  if (document.getElementById('cadastro_wizard') || document.getElementById('radio_function')) {

    /**
     * Controle do Input Radio no Passo 2
     */
    // https://stackoverflow.com/questions/68585868/radio-buttons-with-input-other-option
    const radioMaster = document.querySelector(".radio-master");
    const radioSlave = document.querySelector(".radio-slave");

    radioMaster.addEventListener("input", e => {
      const { type, name, id } = e.target;

      //console.log( 'clqiuei em ' + id );
      // if ( type === "radio" ) container.querySelectorAll( `input[type=text][name=${name}]` )
      //   .forEach( textField => textField.value = "" );
      // else if ( type === "text" ) container.querySelectorAll( `input[type=radio][name=${name}]` )
      //   .forEach( rad => rad.checked = false );

      if (id == "natureza_op_4" || id == "natureza_op_5") {
        //console.log( 'MOSTRA' );
        radioSlave.style = "display:inline;";
      } else {
        //console.log( 'nao mostra' );
        radioSlave.style = "display:none;";
      }
      if (document.getElementById('cadastro_wizard')) {
        arrumaTamanhoJanela(1);
      }

    });
  }

  if (document.getElementById('cadastro_wizard')) {

    /**
     * Controle do Input Checkbox no Passo 3
     */
    const checkMaster = document.querySelector(".check-master");

    checkMaster.addEventListener("input", e => {
      const { id, checked } = e.target;

      nomeRede = id.split('_')[1]; //pegar segundo nome
      checkSlave = document.getElementById('redes_render_' + nomeRede);
      //console.log( 'vou mostrar/esconder ' + nomeRede );

      if (checked) {
        checkSlave.style = "display:inline;";

        //Preciso pegar específicamente o input nomeCompleto para não mexer no outroClassificação
        nomeInputText = "nomeCompleto_rede-de-" + nomeRede;
        nomeInputCPF = "cpfRepresentante_rede-de-" + nomeRede;

        // Tenho que listar os inputs para não pegar checkbox
        checkSlave.querySelectorAll(`input[type=text][name=${nomeInputText}]`).forEach(input => input.required = "true");
        checkSlave.querySelectorAll(`input[type=text][name=${nomeInputCPF}]`).forEach(input => input.required = "true");
        checkSlave.querySelectorAll('input[type=email]').forEach(input => input.required = "true");
        checkSlave.querySelectorAll('input[type=tel]').forEach(input => input.required = "true");
        checkSlave.querySelectorAll('textarea').forEach(textarea => textarea.required = "true");

      } else {
        checkSlave.style = "display:none;";

        checkSlave.querySelectorAll('input').forEach(input => input.removeAttribute("required"));
        checkSlave.querySelectorAll('textarea').forEach(textarea => textarea.removeAttribute("required"));
      }

      arrumaTamanhoJanela(2);

    });

    /**
     * Controle do Input File no passo 4
     */
    const fileMaster = document.querySelector(".upload-inputs");
    //console.log( fileMaster );
    fileMaster.addEventListener("change", e => {
      //const { id } = e.target;
      //console.log( 'mudança em ' + id );
      if (document.getElementById('cadastro_wizard')) {
        arrumaTamanhoJanela(3);
      }

    });
  }

  /**
   * Validação do Email do Candidato no passo 5
   * Seta o disabled do botão de envio caso o email esteja inválido ou já exista na base
   */
  if (document.getElementById('cadastro_wizard')) {
    $("#emailDoCandidato").focusout(function () {
      //console.log('chamando focusout')

      element = $('#emailDoCandidato')[0];
      email = $('#emailDoCandidato').val(); //email

      if (IsEmail(email)) {

        $.ajax({
          type: "POST",
          dataType: 'json',
          url: my_ajax_object.ajax_url,
          data: {
            email: email,
            action: 'email_exists_check',
          }
        })
          .done(function (data) {
            if (data === true) {
              // mostra aviso de erro
              $(element.parentElement).append('<span id="' + element.name + '_label" class="feedback danger" role="alert"><i class="fas fa-times-circle" aria-hidden="true"></i>Esse e-mail já existe na base</span>');
              $("#btn_enviar")[0].setAttribute("disabled", "true");
            } else {
              $("#btn_enviar")[0].removeAttribute("disabled");
            }
          });

      } else {
        console.log('E-mail inválido');
        $("#btn_enviar")[0].setAttribute("disabled", "true");
      }

    });
  }

  /**
   * Inclusão de loading ao submeter
   */
  $(document).on("submit", "form.card", function (e) {

    //console.log('entrei no onSubmit ');

    var filterVal = 'blur(5px)';

    $('<div/>', {
      'class': 'loading medium',
      'style': 'display: contents;',
    }).insertAfter($('#cadastro_wizard'));

    $('#cadastro_wizard')
      .css('filter', filterVal)
      .css('webkitFilter', filterVal)
      .css('mozFilter', filterVal)
      .css('oFilter', filterVal)
      .css('msFilter', filterVal);

  });


});


/**
 * Controle do carregaCidade para a seleção de estados
 */

// selectAberto movido para geral-js

function carregaCidade(id) {

  // console.log("chamei com o id " + id);

  // var elementoSelect = document.getElementById('selectEstado'+id);
  // elementoSelect.style = "display: block;";

  if (selectAberto != id) {

    // esconde o select que estava aberto
    if (selectAberto != 0) {
      document.getElementById('selectEstado' + selectAberto).style = "display: none;";
      document.getElementById('cidadeDaInstituicao' + selectAberto).setAttribute("disabled", "true");
      document.getElementById('cidadeDaInstituicao' + selectAberto).removeAttribute("required");

    } else {
      // esconder o primeiro select criado
      document.getElementById('cidadeDaInstituicaoInicioDiv').style = "display: none;";
      document.getElementById('cidadeDaInstituicaoInicio').removeAttribute("required");
    }

    // mostra o novo select
    document.getElementById('selectEstado' + id).style = "display: block;";
    document.getElementById('cidadeDaInstituicao' + id).removeAttribute("disabled");
    document.getElementById('cidadeDaInstituicao' + id).setAttribute("required", "");

    //seta o novo valor de selectAberto
    selectAberto = id;
  }


  // jQuery(function ($) {
  //   $.ajax({
  //     type: "POST",
  //     url: my_ajax_object.ajax_url,
  //     data: {
  //       action: 'carrega_cidade',
  //       id: id
  //     },
  //     beforeSend: function () {
  //       $('#loading_cidade').css('display', 'contents');
  //       //console.log("entrei no before");
  //     },
  //     success: function (html) {
  //       //console.log("sucess!");
  //       $('#cidadeDaInstituicao')[0].removeAttribute("disabled");
  //       $('#cidadeDaInstituicaoButton')[0].removeAttribute("disabled");
  //       $('#cidadeDaInstituicaoOpcoes').html(html);
  //       $('#loading_cidade').css('display', 'none');
  //     }
  //   });
  // });
}

// Função chamada para setar o value do input hidden que vai guardar o valor da cidadeDaInstituicao
function setarValorCidade(value) {
  //console.log('chamei esse aqui com value ' + value);
  document.getElementById('cidadeDaInstituicao').value = value;
  //console.log(document.getElementById('cidadeDaInstituicao').value);
}

function controleOutroClassificacao(id) {

  //console.log( "cliquei em " + id );
  checkOutro = document.getElementById(id);

  //check_classificacao_3_rede-de-tecnologia
  nomeRede = id.split('_')[3]; //pegar nome da rede
  inputTextOutro = document.getElementById('outroClassificacao_' + nomeRede);

  if (checkOutro.checked) {
    //console.log( "ta clicado" )
    inputTextOutro.parentElement.style = "display: inline;";
    inputTextOutro.required = "true";


  } else {
    //console.log( "nao ta " )
    inputTextOutro.parentElement.style = "display: none;";
    inputTextOutro.removeAttribute("required");
  }

}

//Tentativa de calcular a soma total de todas as divs
//jQuery( document ).ready( function ( $ ) {
//   var totalHeight = 0;
//   //totalHeight = $('.br-wizard')[0].scrollHeight;
//   var totalHeight = $('#br-wizard').prop('scrollHeight');
//   console.log("Total height of all divs: " + totalHeight);
//   //$(".clonechild").height(totalHeight);

//   // var outerHeight = 0;
//   // $('.br-wizard').each(function() {

//   //   outerHeight += $(this).outerHeight();
//   // });
//   //$("#total-height").text(outerHeight + 'px');
//   //console.log(outerHeight);
//} );