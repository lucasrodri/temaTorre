var buscaCX = document.getElementById( "searchbox" );
buscaCX.addEventListener( "keyup", function ( event ) {
  if ( event.keyCode === 13 ) {
    event.preventDefault( );
    var termo = document.getElementById( "searchbox" ).value;
    //console.log(termo)
    window.location.href = "/?s=" + termo;
  }
} );

if ( document.getElementById( 'increase-font' ) && document.getElementById( 'decrease-font' ) ) {
  window.onload = function ( ) {
    var elementBody = document.querySelector( 'body' );
    var elementBtnIncreaseFont = document.getElementById( 'increase-font' );
    var elementBtnDecreaseFont = document.getElementById( 'decrease-font' );
    // Padrão de tamanho, equivale a 100% do valor definido no Body
    var fontSize = 100;
    // Valor de incremento ou decremento, equivale a 10% do valor do Body
    var increaseDecrease = 5;

    // Evento de click para aumentar a fonte
    elementBtnIncreaseFont.addEventListener( 'click', function ( event ) {
      fontSize = fontSize + increaseDecrease;
      elementBody.style.fontSize = fontSize + '%';
    } );

    // Evento de click para diminuir a fonte
    elementBtnDecreaseFont.addEventListener( 'click', function ( event ) {
      fontSize = fontSize - increaseDecrease;
      elementBody.style.fontSize = fontSize + '%';
    } );
  }
}

/* Olha esse site depois: https://stackoverflow.com/questions/49131980/how-do-i-disable-or-hide-the-unwanted-disqus-ads-on-my-website */
jQuery( document ).ready( function ( $ ) {

  const disqus = $( '#disqus_thread' );

  disqus.ready( function ( ) {
    setTimeout( function ( ) {
      if ( disqus.children( ).length >= 3 ) {
        const comments = disqus.find( 'iframe:nth-child(2)' ).detach( );
        disqus.empty( ).append( comments );
      }
    }, 2000 );
  } );

} );

var wizard1_size = '500px';
var wizard2_size = '1450px';
var wizard3_size = '500px';
var wizard4_size = '500px';
var wizard5_size = '500px';

jQuery( document ).ready( function ( $ ) {

  $('#cadastro-wizard-b1').click(function() {
    $('#cadastro-wizard').css("height", wizard1_size);
  });

  $('#cadastro-wizard-b2').click(function() {
    $('#cadastro-wizard').css("height", wizard2_size);
  });

  $('#cadastro-wizard-b3').click(function() {
    $('#cadastro-wizard').css("height", wizard3_size);
  });

  $('#cadastro-wizard-b4').click(function() {
    $('#cadastro-wizard').css("height", wizard4_size);
  });

  $('#cadastro-wizard-b5').click(function() {
    $('#cadastro-wizard').css("height", wizard5_size);
  });

  $('#check-concordo').change(function() {
    if(this.checked) {
        $('#cadastro-btn-1').removeClass('wizard-btn')
        $('#cadastro-btn-1').addClass('wizard-btn-next')
        $('#check-concordo').val(this.checked);   
    } else {
        $('#cadastro-btn-1').removeClass('wizard-btn-next')
        $('#cadastro-btn-1').addClass('wizard-btn')
        $('#check-concordo').val(""); 
    }
    $('#spam-concordo').css("display", "none"); 
  });

  $('#cadastro-btn-1').click(function() {
     if ($('#check-concordo').checked) {
        $('#spam-concordo').css("display", "none");
     } else {
        if ($('#cadastro-btn-1').hasClass('wizard-btn')) {
          $('#spam-concordo').css("display", "inline");
        }
     }
     if ($('#cadastro-btn-1').hasClass('wizard-btn-next')) {
        $('#cadastro-wizard').css("height", wizard2_size);
     }
  });

  $('#cadastro-btn-volta-1').click(function() {
      $('#cadastro-wizard').css("height", wizard1_size);
  });

  //$("#telefoneDoGestor").mask("(00) 0000-00009");
  //$("#celDoGestor").mask("(00) 0000-00009");
  //$("#telefoneDaUnidade").mask("(00) 0000-00009");
  //$("#celDaUnidade").mask("(00) 0000-00009");

  //$("#cpfDoGestor").mask("999.999.999-99");
  
  
  $("#cnpjDaInstituicao").mask("99.999.999/9999-99");
  

  //$("#cepDaUnidade").mask("00000-000");
    
} );
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




/* Textos de mouse over nas redes principais */
var rede_de_suporte = document.getElementById( 'rede_de_suporte' );
var rede_de_formacao = document.getElementById( 'rede_de_formacao' );
var rede_de_pesquisa = document.getElementById( 'rede_de_pesquisa' );
var rede_de_inovacao = document.getElementById( 'rede_de_inovacao' );
var rede_de_produtos = document.getElementById( 'rede_de_produtos' ); // na verdade é a de tecnologia

if ( rede_de_suporte ) {
  rede_de_suporte.title = 'Apoio aos atores do ecossistema de inovação e as atividades da Torre MCTI em todas as etapas do desenvolvimento de produtos e serviços inovadores.';
}

if ( rede_de_formacao ) {
  rede_de_formacao.title = 'Capacitação em ciência, tecnologia e inovação, com intuito de expandir e melhorar a formação profissional e tecnológica.';
}

if ( rede_de_pesquisa ) {
  rede_de_pesquisa.title = 'Utilização do conhecimento científico gerado na pesquisa básica, para apoiar o desenvolvimento de inovações, produtos e serviços, por meio da concepção de aplicações e provas de conceito.';
}

if ( rede_de_inovacao ) {
  rede_de_inovacao.title = 'Transformação de ideias em protótipos, materializando o conhecimento científico validado em soluções concretas experimentais.';
}

if ( rede_de_produtos ) {
  rede_de_produtos.title = 'Transformação de protótipos em produtos e riquezas, com o objetivo de aperfeiçoar soluções experimentais tornando-as aptas ao mercado, à geração de riqueza e à contribuição para a qualidade de vida dos brasileiros.';
}