function determinaPainelAtivo( panels ) {

  //panels = document.getElementsByClassName( "wizard-panel" );

  for ( var i = 0; i < panels.length; i++ ) {
    //console.log( panels[ i ] );
    //console.log( i );
    //console.log( panels[ i ].getAttribute( "active" ) );

    ativo = panels[ i ].getAttribute( "active" );

    if ( ativo === "" ) {
      //console.log( i + ' esse é o painel ativo' );
      return i;
    }

  }

}

// Element é o input, preciso pegar a div "pai" para setar o valido/invalido
function setarInvalido( element ) {
  element.parentElement.removeAttribute( "valid" );
  element.parentElement.setAttribute( "invalid", "invalid" );

  if ( document.getElementById( element.name + "_label" ) ) {

    document.getElementById( element.name + "_label" ).style = "";

  } else {

    $( element.parentElement ).append( '<span id="' + element.name + '_label" class="feedback danger" role="alert"><i class="fas fa-times-circle" aria-hidden="true"></i>Preenchimento obrigatório</span>' );

  }
}

function setarValido( element ) {

  // se estiver inválido, torna válido
  if ( element.parentElement.getAttribute( "invalid" ) ) {
    element.parentElement.removeAttribute( "invalid" );
    element.parentElement.setAttribute( "valid", "valid" );
  } else {
    element.parentElement.removeAttribute( "valid" );
  }

}

function validaFormulario( ) {
  // This function deals with validation of the form fields
  var x, y, i, s, r, t,
    valid = true,
    flag = false;

  //x = document.getElementsByClassName( "tab" );
  x = document.getElementsByClassName( "wizard-panel" );

  currentTab = determinaPainelAtivo( x );

  //console.log( "estou na tab " + currentTab );

  if ( currentTab == 0 ) {

    // Não funciona pegar element by ID
    //y = x[ currentTab ].getElementByID( "checkConcordo" );

    y = x[ currentTab ].getElementsByTagName( "input" );

    if ( y[ 0 ].checked == false ) {
      setarInvalido( y[ 0 ] );
      valid = false;
    }

    /*
    // como era feito no sinajuve para comaração
    y = x[ currentTab ].getElementsByClassName( "requisitos" );
    for ( i = 0; i < y.length; i++ ) {
      // If a field is required
      if ( y[ i ].checked == false ) {
        // add an "invalid" class to the field:
        y[ i ].className += " invalid";
        //console.log(y[i].name + "_label");
        document.getElementById( y[ i ].name + "_label" ).style = "";
        // and set the current valid status to false
        valid = false;
      }
    }
    */
  } else {

    console.log( "estou no else " );


    y = x[ currentTab ].getElementsByTagName( "input" );
    s = x[ currentTab ].getElementsByTagName( "select" );
    t = x[ currentTab ].getElementsByTagName( "textarea" );

    console.log( "tamanho de y (input) " + y.length );
    console.log( "tamanho de s (select) " + s.length );
    console.log( "tamanho de t (textarea) " + t.length );


    // A loop that checks every input field in the current tab:

    for ( i = 0; i < y.length; i++ ) {

      console.log( y[ i ].name );

      if ( y[ i ].type == "email" ) {

        console.log( "email" );

        if ( !IsEmail( y[ i ].value ) ) {
          y[ i ].className += " invalid";
          document.getElementById( y[ i ].name + "_label" ).style = "";
          valid = false;
        }

      } else if ( y[ i ].type == "file" ) {

        console.log( "file" );

        if ( ( typeof y[ i ].attributes[ 'required' ] != 'undefined' ) || ( y[ i ].value != "" ) ) {
          var nome = y[ i ].value.split( "." );
          if ( nome[ nome.length - 1 ].toLowerCase( ) != "pdf" ) {
            y[ i ].className += " invalid";
            document.getElementById( y[ i ].name + "_label" ).style = "";
            valid = false;
          }
        }

      } else {

        console.log( "outros" );

        if ( y[ i ].type == "url" ) {

          console.log( "url" );

          if ( !IsURL( y[ i ].value ) ) {

            console.log( "entrei no !IsURL( y[ i ].value" );

            setarInvalido( y[ i ] );

            //y[ i ].className += " invalid";
            //document.getElementById( y[ i ].name + "_label" ).style = "";
            valid = false;
          } else {
            console.log( "entrei no else " );
          }

        } else {

          if ( y[ i ].name == "cpfDoGestor" ) {

            console.log( "cpfDoGestor" );

            if ( !IsCPF( y[ i ].value ) ) {
              y[ i ].className += " invalid";
              document.getElementById( y[ i ].name + "_label" ).style = "";
              valid = false;
            }

          } else {

            if ( y[ i ].name == "cnpjDaUnidade" ) {

              console.log( "cnpjDaUnidade" );

              if ( !IsCNPJ( y[ i ].value ) ) {
                y[ i ].className += " invalid";
                document.getElementById( y[ i ].name + "_label" ).style = "";
                valid = false;
              }
            } else {

              console.log( "outros required" );

              // If a field is required
              if ( typeof y[ i ].attributes[ 'required' ] != 'undefined' ) {

                console.log( "outros required" );

                if ( y[ i ].value == "" ) {

                  setarInvalido( y[ i ] );

                  // add an "invalid" class to the field:
                  // y[ i ].className += " invalid";
                  // document.getElementById( y[ i ].name + "_label" ).style = "";
                  // and set the current valid status to false
                  valid = false;
                }

              }
            }
          }
        }
      }
    }
    for ( i = 0; i < s.length; i++ ) {
      // If a field is required
      if ( typeof s[ i ].attributes[ 'required' ] != 'undefined' ) {
        if ( s[ i ].value == "" ) {
          // add an "invalid" class to the field:
          s[ i ].className += " invalid";
          document.getElementById( s[ i ].name + "_label" ).style = "";
          // and set the current valid status to false
          valid = false;
        }
      }
    }
    for ( i = 0; i < t.length; i++ ) {
      // If a field is required
      if ( typeof t[ i ].attributes[ 'required' ] != 'undefined' ) {
        if ( t[ i ].value == "" ) {

          setarInvalido( t[ i ] );

          // add an "invalid" class to the field:
          //t[ i ].className += " invalid";
          //document.getElementById( t[ i ].name + "_label" ).style = "";
          // and set the current valid status to false
          valid = false;
        }
      }
    }

    // valid = validaFormularioRadio( x, "requisitos", valid );

    // valid = validaFormularioRadio( x, "generoDoGestor", valid );
    // valid = validaFormularioRadio( x, "concursoDoGestor", valid );
    // valid = validaFormularioRadio( x, "esferaDaUnidade", valid );
    // valid = validaFormularioRadio( x, "espacoFisico", valid );
    // valid = validaFormularioRadio( x, "recursosDaUnidade", valid );

    // valid = validaFormularioGeral( x, "cepDaUnidade", true, valid );
    // valid = validaFormularioGeral( x, "cepDoPrefeito", true, valid );

    // valid = validaFormularioGeral( x, "telefoneDoPrefeito", true, valid );
    // valid = validaFormularioGeral( x, "telefoneDoGestor", true, valid );
    // valid = validaFormularioGeral( x, "telefoneDaUnidade", true, valid );
    // valid = validaFormularioGeral( x, "faxDoPrefeito", false, valid );
    // valid = validaFormularioGeral( x, "celDoGestor", false, valid );
    // valid = validaFormularioGeral( x, "celDaUnidade", false, valid );

  }
  return valid; // return the valid status
}

function validaFormularioRadio( x, classe, valid ) {
  var r, flag = false;
  r = x[ currentTab ].getElementsByClassName( classe );
  if ( r.length > 0 ) {
    flag = false;
    for ( i = 0; i < r.length; i++ ) {
      if ( r[ i ].checked ) {
        flag = true;
      }
    }
    if ( !flag ) {
      r[ 0 ].className += " invalid";
      document.getElementById( r[ 0 ].name + "_label" ).style = "";
      valid = false;
    }
  }
  return valid;
}

function validaFormularioGeral( x, nome, flag, valid ) {
  var r, y;
  y = x[ currentTab ].getElementsByTagName( "input" );
  for ( i = 0; i < y.length; i++ ) {
    if ( y[ i ].name == nome ) {
      if ( flag ) {
        if ( !y[ i ].checkValidity( ) ) {
          y[ i ].className += " invalid";
          document.getElementById( y[ i ].name + "_label" ).style = "";
          valid = false;
        }
      } else {
        if ( y[ i ].value != "" ) {
          if ( !y[ i ].checkValidity( ) ) {
            y[ i ].className += " invalid";
            document.getElementById( y[ i ].name + "_label" ).style = "";
            valid = false;
          }
        }
      }
    }
  }
  return valid;
}

function getValueRadio( radioElement ) {
  if ( radioElement.length > 0 ) {
    for ( i = 0; i < radioElement.length; i++ ) {
      if ( radioElement[ i ].checked ) {
        return radioElement[ i ].value;
      }
    }
  }
  return "";
}

function changeError( name ) {
  if ( document.getElementById( name + "_label" ) ) {
    document.getElementById( name + "_label" ).style = "display: none;";
  }
  //document.getElementById( name ).classList.remove( "invalid" );
  setarValido( document.getElementById( name ) );
}

function changeSelect( name ) {
  if ( document.getElementById( name ).value == "Outro" ) {
    document.getElementById( name + "outro" ).disabled = false;
    document.getElementById( name + "outro" ).required = true;
    document.getElementById( name + "outro" ).style = "";
    document.getElementById( name + "outro" + "div" ).style = "";
  } else {
    document.getElementById( name + "outro" ).disabled = true;
    document.getElementById( name + "outro" ).required = false;
    document.getElementById( name + "outro" ).style = "background-color: #bbbbbb;";
    document.getElementById( name + "outro" ).value = "";
    document.getElementById( name + "outro" + "div" ).style = "display: none;";
    changeError( name + "outro" );
  }
  if ( document.getElementById( name + "_label" ) ) {
    changeError( name )
  }
}

function changeCheck( name ) {
  if ( document.getElementById( name + "number" ).hasAttribute( "disabled" ) ) {
    document.getElementById( name + "number" ).disabled = false;
    document.getElementById( name + "number" ).required = true;
    document.getElementById( name + "number" ).style = "";

    if ( document.getElementById( name + "outro" + "div" ) ) {
      document.getElementById( name + "outro" + "div" ).style = "";
    }
  } else {
    document.getElementById( name + "number" ).disabled = true;
    document.getElementById( name + "number" ).required = false;
    document.getElementById( name + "number" ).style = "background-color: #bbbbbb;";
    document.getElementById( name + "number" ).value = "";

    if ( document.getElementById( name + "outro" + "div" ) ) {
      document.getElementById( name + "outro" + "div" ).style = "display: none;";
    }
  }
  if ( document.getElementById( name + "_label" ) ) {
    changeError( name )
  }
  if ( document.getElementById( name + "number_label" ) ) {
    changeError( name + "number" )
  }
}

function changeRadio( name ) {
  if ( strcmp( getValueRadio( document.getElementsByName( name ) ), "Próprio" ) ) {
    document.getElementById( name + "outro" ).disabled = false;
    document.getElementById( name + "outro" ).required = true;
    document.getElementById( name + "outro" ).style = "";
    document.getElementById( name + "outro" + "div" ).style = "";
  } else {
    document.getElementById( name + "outro" ).disabled = true;
    document.getElementById( name + "outro" ).required = false;
    document.getElementById( name + "outro" ).style = "background-color: #bbbbbb;";
    document.getElementById( name + "outro" ).value = "";
    document.getElementById( name + "outro" + "div" ).style = "display: none;";
    changeError( name + "outro" );
  }
  if ( document.getElementById( name + "_label" ) ) {
    changeError( name )
  }
}

function changeRadio2( name ) {
  if ( strcmp( getValueRadio( document.getElementsByName( name ) ), "Outro" ) ) {
    document.getElementById( name + "outro" ).disabled = true;
    document.getElementById( name + "outro" ).required = false;
    document.getElementById( name + "outro" ).style = "background-color: #bbbbbb;";
    document.getElementById( name + "outro" ).value = "";
    document.getElementById( name + "outro" + "div" ).style = "display: none;";
    changeError( name + "outro" );
  } else {
    document.getElementById( name + "outro" ).disabled = false;
    document.getElementById( name + "outro" ).required = true;
    document.getElementById( name + "outro" ).style = "";
    document.getElementById( name + "outro" + "div" ).style = "";
  }
  if ( document.getElementById( name + "_label" ) ) {
    changeError( name )
  }
}

function strcmp( a, b ) {
  a = a.toString( ), b = b.toString( );
  for ( var i = 0, n = Math.max( a.length, b.length ); i < n && a.charAt( i ) === b.charAt( i ); ++i )
  ;
  if ( i === n )
    return 0;
  return a.charAt( i ) > b.charAt( i ) ? -1 : 1;
}

function changeNumber( name ) {
  var valor, min, max;

  valor = parseInt( document.getElementById( name ).value );
  min = parseInt( document.getElementById( name ).min );
  max = parseInt( document.getElementById( name ).max );

  if ( valor ) {
    //para pegar só a parte inteira
    document.getElementById( name ).value = valor;

    if ( valor < min ) {
      document.getElementById( name ).value = min;
    } else if ( valor > max ) {
      document.getElementById( name ).value = max;
    }
  }

  if ( document.getElementById( name + "_label" ) ) {
    changeError( name )

    //document.getElementById(name + "_label").style = "display: none;";
    //document.getElementById(name).classList.remove("invalid");
  }
}

function IsEmail( email ) {
  if ( email === "" ) {
    return false;
  }
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test( email );
}

function IsURL( url ) {
  if ( url === "" ) {
    return true;
  } else {
    if ( url.indexOf( "http://" ) == 0 || url.indexOf( "https://" ) == 0 ) {
      return true;
    } else {
      return false;
    }
  }
}

function IsCPF( cpf ) {
  cpf = cpf.replace( /[^\d]+/g, '' );
  if ( cpf == '' )
    return false;
  // Elimina CPFs invalidos conhecidos    
  if ( cpf.length != 11 ||
    cpf == "00000000000" ||
    cpf == "11111111111" ||
    cpf == "22222222222" ||
    cpf == "33333333333" ||
    cpf == "44444444444" ||
    cpf == "55555555555" ||
    cpf == "66666666666" ||
    cpf == "77777777777" ||
    cpf == "88888888888" ||
    cpf == "99999999999" )
    return false;
  // Valida 1o digito 
  add = 0;
  for ( i = 0; i < 9; i++ )
    add += parseInt( cpf.charAt( i ) ) * ( 10 - i );
  rev = 11 - ( add % 11 );
  if ( rev == 10 || rev == 11 )
    rev = 0;
  if ( rev != parseInt( cpf.charAt( 9 ) ) )
    return false;
  // Valida 2o digito 
  add = 0;
  for ( i = 0; i < 10; i++ )
    add += parseInt( cpf.charAt( i ) ) * ( 11 - i );
  rev = 11 - ( add % 11 );
  if ( rev == 10 || rev == 11 )
    rev = 0;
  if ( rev != parseInt( cpf.charAt( 10 ) ) )
    return false;
  return true;
}

function IsCNPJ( cnpj ) {
  cnpj = cnpj.replace( /[^\d]+/g, '' );

  if ( cnpj == '' )
    return false;

  if ( cnpj.length != 14 )
    return false;

  // Elimina CNPJs invalidos conhecidos
  if ( cnpj == "00000000000000" ||
    cnpj == "11111111111111" ||
    cnpj == "22222222222222" ||
    cnpj == "33333333333333" ||
    cnpj == "44444444444444" ||
    cnpj == "55555555555555" ||
    cnpj == "66666666666666" ||
    cnpj == "77777777777777" ||
    cnpj == "88888888888888" ||
    cnpj == "99999999999999" )
    return false;

  // Valida DVs
  tamanho = cnpj.length - 2
  numeros = cnpj.substring( 0, tamanho );
  digitos = cnpj.substring( tamanho );
  soma = 0;
  pos = tamanho - 7;
  for ( i = tamanho; i >= 1; i-- ) {
    soma += numeros.charAt( tamanho - i ) * pos--;
    if ( pos < 2 )
      pos = 9;
  }
  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
  if ( resultado != digitos.charAt( 0 ) )
    return false;

  tamanho = tamanho + 1;
  numeros = cnpj.substring( 0, tamanho );
  soma = 0;
  pos = tamanho - 7;
  for ( i = tamanho; i >= 1; i-- ) {
    soma += numeros.charAt( tamanho - i ) * pos--;
    if ( pos < 2 )
      pos = 9;
  }
  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
  if ( resultado != digitos.charAt( 1 ) )
    return false;

  return true;
}