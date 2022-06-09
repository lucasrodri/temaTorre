var wizard1_size = '600px';
var wizard2_size = '1600px';
var wizard3_size = '2500px';
var wizard4_size = '500px';
var wizard5_size = '500px';

function arrumaTamanhoJanela( index ) {

  // console.log( 'chamei arrumaTamanhoJanela ' + index );

  wizard_sizes = {
    0: '600px',
    1: '1700px',
    2: '2500px',
    3: '800px',
    4: '1000px',
  }

  // console.log( 'setando tamanho da janela em ' + index );

  $( '#cadastro_wizard' ).css( "height", wizard_sizes[ index ] );

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

  // $( '#checkConcordo' ).change( function ( ) {
  //   if ( this.checked ) {
  //     $( '#cadastro_btn_1' ).removeClass( 'wizard-btn' )
  //     $( '#cadastro_btn_1' ).addClass( 'wizard-btn-next' )
  //     $( '#checkConcordo' ).val( this.checked );
  //   } else {
  //     $( '#cadastro_btn_1' ).removeClass( 'wizard-btn-next' )
  //     $( '#cadastro_btn_1' ).addClass( 'wizard-btn' )
  //     $( '#checkConcordo' ).val( "" );
  //   }
  //   $( '#span-concordo' ).css( "display", "none" );
  // } );

  // $( '#cadastro_btn_1' ).click( function ( ) {
  //   if ( $( '#checkConcordo' ).checked ) {
  //     $( '#span-concordo' ).css( "display", "none" );
  //   } else {
  //     if ( $( '#cadastro_btn_1' ).hasClass( 'wizard-btn' ) ) {
  //       $( '#span-concordo' ).css( "display", "inline" );
  //     }
  //   }
  //   if ( $( '#cadastro_btn_1' ).hasClass( 'wizard-btn-next' ) ) {
  //     $( '#cadastro_wizard' ).css( "height", wizard2_size );
  //   }
  // } );

  $( '.wizard-btn' ).click( function ( ) {
    console.log( 'cliquei no wizard btn' );

    if ( validaFormulario( ) ) {

      $( this ).addClass( 'wizard-btn-next' );

      // console.log( $( this ) );
      // console.log( this.id );
      // console.log( this.id.slice( -1 ) );

      // pega número do painel ativo pelo id do botão clicado
      //arrumaTamanhoJanela( this.id.slice( -1 ) );

      // ainda não pensei numa forma melhor pra isso aqui
      // if ( $( '#cadastro_btn_1' ).hasClass( 'wizard-btn-next' ) ) {
      //   //$( '#cadastro_wizard' ).css( "height", wizard2_size );
      //   arrumaTamanhoJanela( 1 );
      // }


      panels = document.getElementsByClassName( "wizard-panel" );

      for ( var i = 0; i < panels.length; i++ ) {

        ativo = panels[ i ].getAttribute( "active" );

        if ( ativo === "" ) {
          index = i;
        }

      }

      console.log( 'cliquei no next btn ' + index );

      arrumaTamanhoJanela( index + 1 );

    } else {

      $( this ).removeClass( 'wizard-btn-next' );

    }

  } );


  $( '.wizard-btn-prev' ).click( function ( ) {

    // não quero chamar essa funçaõ aqui pq ela é definida só na parte de validação
    //index = determinaPainelAtivo( document.getElementsByClassName( "wizard-panel" ) );

    panels = document.getElementsByClassName( "wizard-panel" );

    for ( var i = 0; i < panels.length; i++ ) {

      ativo = panels[ i ].getAttribute( "active" );

      if ( ativo === "" ) {
        index = i;
      }

    }

    console.log( 'cliquei no previous btn ' + index );

    arrumaTamanhoJanela( index - 1 );

  } );


  // $( '#cadastro_btn_volta_1' ).click( function ( ) {
  //   $( '#cadastro_wizard' ).css( "height", wizard1_size );
  // } );

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