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

  //colocando um if para não dá erros em outras páginas
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
  //$("#cepDaUnidade").mask("00000-000");

  $("input[type='tel']").each(function (index) {
    $(this).mask("(00) 0000-00009");
  });

  //colocando um if para não dá erros em outras páginas
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
        // Tenho que listar os inputs para não pegar checkbox
        checkSlave.querySelectorAll(`input[type=text][name=${nomeInputText}]`).forEach(input => input.required = "true");
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
  }

});


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