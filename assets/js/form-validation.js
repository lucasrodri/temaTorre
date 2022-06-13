function determinaPainelAtivo( panels ) {

  //panels = document.getElementsByClassName( "wizard-panel" );

  for ( var i = 0; i < panels.length; i++ ) {

    ativo = panels[ i ].getAttribute( "active" );

    if ( ativo === "" ) {
      return i;
    }

  }

}

// Element é o input, preciso pegar a div "pai" para setar o valido/invalido
function setarInvalido( element ) {
  element.parentElement.removeAttribute( "valid" );
  element.parentElement.classList.remove( "success" );

  element.parentElement.setAttribute( "invalid", "invalid" );
  element.parentElement.className += " danger";

  if ( element.type == 'checkbox' ) {
    classe = element.classList.item( 0 ); //pegar a classe -> ex: check_redes

    if ( document.getElementById( classe + "_label" ) ) {
      // 1a diferença: cria o label com o nome da classe, em vez do name do elemento
      document.getElementById( classe + "_label" ).style = "";
    } else {
      // 2a diferença: cria o label no pai do elemento pai kkk
      element.parentElement.parentElement.insertAdjacentHTML( "beforeend",
        '<span id="' + classe + '_label" class="feedback danger" role="alert"><i class="fas fa-times-circle" aria-hidden="true"></i>Preenchimento obrigatório</span>' );
    }

  } else {
    if ( document.getElementById( element.name + "_label" ) ) {

      document.getElementById( element.name + "_label" ).style = "";

    } else {

      element.parentElement.insertAdjacentHTML( "beforeend",
        '<span id="' + element.name + '_label" class="feedback danger" role="alert"><i class="fas fa-times-circle" aria-hidden="true"></i>Preenchimento obrigatório</span>' );

    }
  }
}

function setarValido( element ) {
  element.parentElement.removeAttribute( "invalid" );
  element.parentElement.classList.remove( "danger" );

  if ( !element.classList.contains( 'warning' ) ) {

    element.parentElement.setAttribute( "valid", "valid" );
    element.parentElement.className += " success";

  }

  if ( document.getElementById( element.name + "_label" ) ) {
    document.getElementById( element.name + "_label" ).style = "display: none;";
  }

  if ( element.type == 'checkbox' ) {
    classe = element.classList.item( 0 ); //pegar a classe -> ex: check_redes
    if ( document.getElementById( classe + "_label" ) ) {
      document.getElementById( classe + "_label" ).style = "display: none;";
    }
  }
}

function mostrarAvisoValidacao( element, nome = '' ) {
  element.parentElement.removeAttribute( "valid" );
  element.parentElement.classList.remove( "success" );

  element.parentElement.className += " warning";

  if ( document.getElementById( element.name + "_warning" ) ) {

    document.getElementById( element.name + "_warning" ).style = "";

  } else {

    element.parentElement.insertAdjacentHTML( "beforeend",
      '<span id="' + element.name + '_warning" class="feedback warning" role="alert"><i class="fas fa-times-circle" aria-hidden="true"></i>Insira um ' + nome + ' válido</span>' );

  }
}

function ocultarAvisoValidacao( element ) {
  if ( document.getElementById( element.name + "_warning" ) ) {
    document.getElementById( element.name + "_warning" ).style = "display: none;";
  }

  element.parentElement.classList.remove( "warning" );
  element.parentElement.setAttribute( "valid", "valid" );
  element.parentElement.className += " success"

}

/*
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

      console.log( "--------validando " + y[ i ].name );

      if ( y[ i ].type == "email" ) {

        console.log( "email" );

        if ( !IsEmail( y[ i ].value ) ) {
          y[ i ].className += " invalid";
          document.getElementById( y[ i ].name + "_label" ).style = "";
          valid = false;
        }

      } else if ( y[ i ].type == "file" ) {

        return valid = true;
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

          if ( y[ i ].name == "cnpjDaInstituicao" ) {

            console.log( "cnpjDaInstituicao" );

            if ( !IsCNPJ( y[ i ].value ) ) {
              setarInvalido( y[ i ] );
              valid = false;
            }

          } else {

            console.log( "outros required" );

            // If a field is required
            if ( typeof y[ i ].attributes[ 'required' ] != 'undefined' ) {

              console.log( "outros required" );

              //testar required
              //if (y[ i ].getAttribute( "required" ) !== '')

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

    valid = validaFormularioRadio( x, "natureza-op", valid );

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
*/

function validaFormulario( ) {

  var x, y, t, currentTab, valid = true;

  x = document.getElementsByClassName( "wizard-panel" );

  currentTab = determinaPainelAtivo( x );

  y = x[ currentTab ].getElementsByTagName( "input" );
  //s = x[ currentTab ].getElementsByTagName( "select" );
  t = x[ currentTab ].getElementsByTagName( "textarea" );

  //console.log( "tamanho de y (input) " + y.length );
  //console.log( "tamanho de s (select) " + s.length );
  //console.log( "tamanho de t (textarea) " + t.length );

  /**
   * Checar Input (y)
   */

  var checarRadio = [ ];
  var checarCheckbox = [ ];

  for ( i = 0; i < y.length; i++ ) {

    requirido = y[ i ].getAttribute( "required" );
    flagRequirido = false;

    // Checa apenas se o campo for requerido
    if ( requirido === "" ) {
      flagRequirido = true;
    }

    switch ( y[ i ].type ) {
      case "text":
        //console.log( "text" );

        //console.log( "--------validando " + y[ i ].name );
        //console.log( "flagRequirido: " + flagRequirido );
        //console.log( "valor: " + y[ i ].value );
        //console.log( 'validade ' + y[ i ].checkValidity( ) );

        if ( flagRequirido && ( y[ i ].value == "" ) ) {
          setarInvalido( y[ i ] );
          valid = false;
        }

        break;

      case "email":
        //console.log( "email" );

        if ( flagRequirido && ( y[ i ].value == "" ) ) {
          setarInvalido( y[ i ] );
          valid = false;
        }

        break;

      case "file":
        //console.log( "file" );

        var extensoesPermitidas = {
          'logo_instituicao': [ 'jpg', 'png', 'jpeg' ],
          'guia_instituicao': [ 'pdf' ],
        }

        var tamanhoPermitido = {
          'logo_instituicao': 5242880,
          'guia_instituicao': 26214400,
        }

        if ( flagRequirido || ( y[ i ].value != "" ) ) {

          //checar extensão
          var nomeArquivo = y[ i ].value.split( "." );
          var extensao = nomeArquivo[ nomeArquivo.length - 1 ].toLowerCase( );

          // console.log( "nomeArquivo: " + nomeArquivo );
          // console.log( "extensao: " + extensao );
          // console.log( "verificacao: " + extensoesPermitidas[ y[ i ].name ].includes( extensao ) );

          if ( !extensoesPermitidas[ y[ i ].name ].includes( extensao ) || y[ i ].files.length == 0 ) {
            setarInvalido( y[ i ] );
            valid = false;
          }

          if ( y[ i ].files.length > 0 ) {
            var tamanho = y[ i ].files[ 0 ].size;
            //console.log( "tamanho: " + tamanho );

            if ( tamanho > tamanhoPermitido[ y[ i ].name ] ) {
              //setarInvalido( y[ i ] );
              //valid = false;
              mostrarAvisoValidacao( document.getElementById( y[ i ].name ), 'Arquivo' );
              valid = false;
            } else {
              ocultarAvisoValidacao( document.getElementById( y[ i ].name ) );
            }
          }


        }
        break;

      case "url":
        //console.log( "url" );

        if ( flagRequirido && ( y[ i ].value == "" ) ) {
          setarInvalido( y[ i ] );
          valid = false;
        }

        break;

      case "tel":
        //console.log( "tel" );

        // console.log( "--------validando " + y[ i ].name );
        // console.log( "flagRequirido: " + flagRequirido );
        // console.log( "valor: " + y[ i ].value );
        // console.log( 'validade ' + y[ i ].checkValidity( ) );

        // esse tem uma validação diferente
        if ( flagRequirido && ( !y[ i ].checkValidity( ) ) ) {
          setarInvalido( y[ i ] );
          valid = false;
        }

        break;

      case "radio":
        //console.log( "radio" );

        /*
        //pega todas as classes
        //console.log( y[ i ].classList.item( 0 ) )
        classe = y[ i ].classList.item( 0 ); //geralmente é a única classe

        if ( !checarRadio.includes( classe ) ) {
          //console.log( "inserindo classe " + classe )
          checarRadio.push( classe );
        }
        */

        classe = y[ i ].classList.item( 0 );
        // If específico para natureza_op
        if ( classe == 'natureza_op' ) {
          if ( !checarRadio.includes( classe ) ) {
            checarRadio.push( classe );
          }
        }

        // Se o natureza_op for igual 4 ou 5 (instituição privada), inclui o outro radio para validação
        if ( y[ i ].checked == true && ( y[ i ].id == "natureza_op_4" || y[ i ].id == "natureza_op_5" ) ) {
          console.log( 'entrei na validação dos op4 e op5' );
          checarRadio.push( 'porte_op' );
        }

        break;

      case "checkbox":
        //console.log( "checkbox" );
        //console.log( "--------validando " + y[ i ].name );

        classe = y[ i ].classList.item( 0 );

        if ( classe == 'checkConcordo' ) {
          if ( y[ i ].checked == false ) {
            setarInvalido( y[ i ] );
            valid = false;
          }
        }

        // If específico para check_redes
        if ( classe == 'check_redes' ) {

          if ( !checarCheckbox.includes( classe ) ) {
            checarCheckbox.push( classe );
          }

          // Se algum dos check de check_redes estiver marcado, os outros dele estarão abertos
          if ( y[ i ].checked == true ) {

            //console.log( 'entrei na validação do ' + y[ i ].id );
            nomeRede = y[ i ].id.split( '_' )[ 1 ]; //pegar segundo nome

            checkClassificacao = 'check_classificacao_rede-de-' + nomeRede;
            checkPublico = 'check_publico_rede-de-' + nomeRede;
            checkAbrangencia = 'check_abrangencia_rede-de-' + nomeRede;

            // console.log( checkClassificacao );
            // console.log( checkPublico );
            // console.log( checkAbrangencia );

            if ( !checarCheckbox.includes( checkClassificacao ) ) {
              checarCheckbox.push( checkClassificacao );
              checarCheckbox.push( checkPublico );
              checarCheckbox.push( checkAbrangencia );
            }
          }
        }

        break;

      default:
        console.log( "default" );
        console.log( y[ i ].type );
        // code block
        break;

    }

    // if ( y[ i ].type != 'checkbox' ) {
    //   console.log( valid + " VALID depois da input: " + y[ i ].name );
    // }
  }

  //console.log( 'checarCheckbox' );
  //console.log( checarCheckbox );
  for ( c = 0; c < checarRadio.length; c++ ) {
    valid = validaFormularioRadio( x, currentTab, checarRadio[ c ], valid );
  }

  for ( c = 0; c < checarCheckbox.length; c++ ) {
    valid = validaFormularioCheckbox( x, currentTab, checarCheckbox[ c ], valid );
  }

  //console.log( "VALID depois da validaFormularioRadio: " + valid );


  /**
   * Checar Textarea (t)
   */
  for ( i = 0; i < t.length; i++ ) {

    requirido = t[ i ].getAttribute( "required" );
    flagRequirido = false;

    // mesma lógica do ativo
    if ( requirido === "" ) {
      flagRequirido = true;
    }

    if ( flagRequirido ) {
      if ( t[ i ].value == "" ) {
        setarInvalido( t[ i ] );
        valid = false;
      }
    }

    // console.log( valid + " VALID depois da textarea: " + t[ i ].name );
  }

  console.log( "VALID: " + valid );
  //return false;
  return valid;
}

function validarEspecifico( name ) {
  element = document.getElementById( name );

  if ( name == "cnpjDaInstituicao" ) {

    //console.log( "validar text cnpjDaInstituicao" );
    //console.log( IsCNPJ( element.value ) );

    if ( !IsCNPJ( element.value ) ) {
      mostrarAvisoValidacao( element, 'CNPJ' );
    } else {
      ocultarAvisoValidacao( element );
    }

  }

  if ( name == "urlDaInstituicao" ) {

    //console.log( "validar text urlDaInstituicao" );
    //.log( IsURL( element.value ) );

    if ( !IsURL( element.value ) ) {
      mostrarAvisoValidacao( element, 'URL' );
    } else {
      ocultarAvisoValidacao( element );
    }

  }

  if ( element.type == "email" ) {

    if ( !IsEmail( element.value ) ) {
      mostrarAvisoValidacao( element, 'E-mail' );
    } else {
      ocultarAvisoValidacao( element );
    }

  }


}

function validaFormularioRadio( x, currentTab, classe, valid ) {

  console.log( "checando classe " + classe )
  var r, flag = false;
  r = x[ currentTab ].getElementsByClassName( classe );

  console.log( "tamanho de r (radio) " + r.length );

  if ( r.length > 0 ) {

    flag = false;

    for ( i = 0; i < r.length; i++ ) {
      if ( r[ i ].checked ) {
        flag = true;
      }
    }

    if ( !flag ) {

      //setarInvalido( r[ 0 ] );

      //for ( i = 0; i < r.length; i++ ) {
      // rodar o for ao inverso
      for ( i = r.length - 1; i >= 0; i-- ) {
        setarInvalido( r[ i ] );
      }

      //r[ 0 ].className += " invalid";
      //document.getElementById( r[ 0 ].name + "_label" ).style = "";
      valid = false;
    }

  }
  return valid;
}


function validaFormularioCheckbox( x, currentTab, classe, valid ) {

  //console.log( "checando classe " + classe )
  var r, flag = false;
  r = x[ currentTab ].getElementsByClassName( classe );

  //console.log( "tamanho de r (checkbox) " + r.length );

  if ( r.length > 0 ) {

    flag = false;

    for ( i = 0; i < r.length; i++ ) {
      if ( r[ i ].checked ) {
        flag = true;
      }
    }

    if ( !flag ) {

      for ( i = 0; i < r.length; i++ ) {
        setarInvalido( r[ i ] );
      }

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
  setarValido( document.getElementById( name ) );
}


function changeErrorRadio( name ) {
  r = document.getElementsByClassName( name );

  if ( r.length > 0 ) {

    for ( i = 0; i < r.length; i++ ) {
      setarValido( r[ i ] );
    }

  }

  // if ( document.getElementById( name + "_label" ) ) {
  //   document.getElementById( name + "_label" ).style = "display: none;";
  // }
}

function changeErrorCheck( name ) {

  //uso um element para pegar a classe
  element = document.getElementById( name );
  classe = element.classList.item( 0 ); //pegar a classe -> check_redes
  console.log( classe );

  //agora sim, uso a classe pra fazer o que precis
  r = document.getElementsByClassName( classe );

  if ( r.length > 0 ) {

    for ( i = 0; i < r.length; i++ ) {
      setarValido( r[ i ] );
    }

  }
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
  if ( email == "" ) {
    return true;
  }
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test( email );
}

function IsURL( url ) {
  if ( url == "" ) {
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