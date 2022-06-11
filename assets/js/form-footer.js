var wizard1_size = '600px';
var wizard2_size = '1600px';
var wizard3_size = '2500px';
var wizard4_size = '500px';
var wizard5_size = '500px';

function arrumaTamanhoJanela( index ) {

  // console.log( 'chamei arrumaTamanhoJanela ' + index );

  wizard_sizes = {
    0: '600px',
    1: '2000px',
    2: '2500px',
    3: '800px',
    4: '1000px',
  }

  // console.log( 'setando tamanho da janela em ' + index );
  document.getElementById( 'cadastro_wizard' ).style.height = wizard_sizes[ index ];
  //$( '#cadastro_wizard' ).css( "height", wizard_sizes[ index ] );

}

function retornaPainelAtivo( ) {
  panels = document.getElementsByClassName( "wizard-panel" );

  for ( var i = 0; i < panels.length; i++ ) {

    ativo = panels[ i ].getAttribute( "active" );

    if ( ativo === "" ) {
      return i;
    }
  }
}

jQuery( document ).ready( function ( $ ) {

  // começa chamando a primeira altura
  arrumaTamanhoJanela( 0 );

  /**
   * Ajuste do tamanho da aba
   */

  $( ".wizard-progress" ).find( ":button" ).each( function ( index ) {
    // procura todos os botões dentro de wizard-progress e adiciona uma chamada a função de arrumar janela ao clicar
    $( this ).click( function ( ) {
      arrumaTamanhoJanela( index );
    } );

  } );


  $( '.wizard-btn' ).click( function ( ) {
    console.log( 'cliquei no wizard btn' );

    if ( validaFormulario( ) ) {

      $( this ).addClass( 'wizard-btn-next' );

      index = retornaPainelAtivo( );
      //console.log( 'cliquei no next btn ' + index );
      arrumaTamanhoJanela( index + 1 );

    } else {

      $( this ).removeClass( 'wizard-btn-next' );

    }

  } );


  $( '.wizard-btn-prev' ).click( function ( ) {

    index = retornaPainelAtivo( );
    //console.log( 'cliquei no previous btn ' + index );
    arrumaTamanhoJanela( index - 1 );

  } );

  /**
   * Máscaras
   */
  //$("#telefoneDoGestor").mask("(00) 0000-00009");
  //$("#celDoGestor").mask("(00) 0000-00009");
  //$("#telefoneDaUnidade").mask("(00) 0000-00009");
  //$("#celDaUnidade").mask("(00) 0000-00009");
  //$("#cpfDoGestor").mask("999.999.999-99");
  $( "#cnpjDaInstituicao" ).mask( "99.999.999/9999-99" );
  //$("#cepDaUnidade").mask("00000-000");

  $( "input[type='tel']" ).each( function ( index ) {
    $( this ).mask( "(00) 0000-00009" );
  } );

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