var wizard1_size = '600px';
var wizard2_size = '1600px';
var wizard3_size = '2500px';
var wizard4_size = '500px';
var wizard5_size = '500px';

jQuery( document ).ready( function ( $ ) {

  // começa chamando a primeira altura
  $( '#cadastro-wizard' ).css( "height", wizard1_size );

  /**
   * Ajuste do tamanho da aba
   */

  $( '#cadastro-wizard-b1' ).click( function ( ) {
    $( '#cadastro-wizard' ).css( "height", wizard1_size );
  } );

  $( '#cadastro-wizard-b2' ).click( function ( ) {
    $( '#cadastro-wizard' ).css( "height", wizard2_size );
  } );

  $( '#cadastro-wizard-b3' ).click( function ( ) {
    $( '#cadastro-wizard' ).css( "height", wizard3_size );
  } );

  $( '#cadastro-wizard-b4' ).click( function ( ) {
    $( '#cadastro-wizard' ).css( "height", wizard4_size );
  } );

  $( '#cadastro-wizard-b5' ).click( function ( ) {
    $( '#cadastro-wizard' ).css( "height", wizard5_size );
  } );




  $( '#check_concordo' ).change( function ( ) {
    if ( this.checked ) {
      $( '#cadastro-btn-1' ).removeClass( 'wizard-btn' )
      $( '#cadastro-btn-1' ).addClass( 'wizard-btn-next' )
      $( '#check_concordo' ).val( this.checked );
    } else {
      $( '#cadastro-btn-1' ).removeClass( 'wizard-btn-next' )
      $( '#cadastro-btn-1' ).addClass( 'wizard-btn' )
      $( '#check_concordo' ).val( "" );
    }
    $( '#span-concordo' ).css( "display", "none" );
  } );

  $( '#cadastro-btn-1' ).click( function ( ) {
    if ( $( '#check_concordo' ).checked ) {
      $( '#span-concordo' ).css( "display", "none" );
    } else {
      if ( $( '#cadastro-btn-1' ).hasClass( 'wizard-btn' ) ) {
        $( '#span-concordo' ).css( "display", "inline" );
      }
    }
    if ( $( '#cadastro-btn-1' ).hasClass( 'wizard-btn-next' ) ) {
      $( '#cadastro-wizard' ).css( "height", wizard2_size );
    }
  } );



  $( '#cadastro-btn-volta-1' ).click( function ( ) {
    $( '#cadastro-wizard' ).css( "height", wizard1_size );
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