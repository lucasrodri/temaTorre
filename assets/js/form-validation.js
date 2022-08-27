function determinaPainelAtivo(panels) {

  //panels = document.getElementsByClassName( "wizard-panel" );

  for (var i = 0; i < panels.length; i++) {

    ativo = panels[i].getAttribute("active");

    if (ativo === "") {
      return i;
    }

  }

}

// Element é o input, preciso pegar a div "pai" para setar o valido/invalido
function setarInvalido(element) {
  element.parentElement.removeAttribute("valid");
  element.parentElement.classList.remove("success");

  element.parentElement.setAttribute("invalid", "invalid");
  element.parentElement.className += " danger";

  if (element.type == 'checkbox') {
    classe = element.classList.item(0); //pegar a classe -> ex: check_redes

    if (document.getElementById(classe + "_label")) {
      // 1a diferença: cria o label com o nome da classe, em vez do name do elemento
      document.getElementById(classe + "_label").style = "";
    } else {
      // 2a diferença: cria o label no pai do elemento pai kkk
      element.parentElement.parentElement.insertAdjacentHTML("beforeend",
        '<span id="' + classe + '_label" class="feedback danger" role="alert"><i class="fas fa-times-circle" aria-hidden="true"></i>Preenchimento obrigatório</span>');
    }

  } else {
    if (document.getElementById(element.name + "_label")) {

      document.getElementById(element.name + "_label").style = "";

    } else {

      element.parentElement.insertAdjacentHTML("beforeend",
        '<span id="' + element.name + '_label" class="feedback danger" role="alert"><i class="fas fa-times-circle" aria-hidden="true"></i>Preenchimento obrigatório</span>');

    }
  }
}

function setarValido(element) {
  element.parentElement.removeAttribute("invalid");
  element.parentElement.classList.remove("danger");

  if (!element.classList.contains('warning')) {

    element.parentElement.setAttribute("valid", "valid");
    element.parentElement.className += " success";

  }

  if (document.getElementById(element.name + "_label")) {
    document.getElementById(element.name + "_label").style = "display: none;";
  }

  if (element.type == 'checkbox') {
    classe = element.classList.item(0); //pegar a classe -> ex: check_redes
    if (document.getElementById(classe + "_label")) {
      document.getElementById(classe + "_label").style = "display: none;";
    }
  }
}

function mostrarAvisoValidacao(element, nome = '') {
  element.parentElement.removeAttribute("valid");
  element.parentElement.classList.remove("success");

  element.parentElement.className += " warning";

  if (document.getElementById(element.name + "_warning")) {

    document.getElementById(element.name + "_warning").style = "";

  } else {

    element.parentElement.insertAdjacentHTML("beforeend",
      '<span id="' + element.name + '_warning" class="feedback warning" role="alert"><i class="fas fa-times-circle" aria-hidden="true"></i>Insira um ' + nome + ' válido</span>');

  }
}

function ocultarAvisoValidacao(element) {
  if (document.getElementById(element.name + "_warning")) {
    document.getElementById(element.name + "_warning").style = "display: none;";
  }

  element.parentElement.classList.remove("warning");
  element.parentElement.setAttribute("valid", "valid");
  element.parentElement.className += " success"

}

function validaFormulario() {

  var x, y, t, currentTab, valid = true;

  x = document.getElementsByClassName("wizard-panel");

  currentTab = determinaPainelAtivo(x);

  y = x[currentTab].getElementsByTagName("input");
  //s = x[ currentTab ].getElementsByTagName( "select" );
  t = x[currentTab].getElementsByTagName("textarea");

  //console.log( "tamanho de y (input) " + y.length );
  //console.log( "tamanho de s (select) " + s.length );
  //console.log( "tamanho de t (textarea) " + t.length );

  /**
   * Checar Input (y)
   */

  var checarRadio = [];
  var checarCheckbox = [];

  for (i = 0; i < y.length; i++) {

    requirido = y[i].getAttribute("required");
    flagRequirido = false;

    // Checa apenas se o campo for requerido
    if (requirido === "") {
      flagRequirido = true;
    }

    switch (y[i].type) {
      case "text":
        //console.log( "text" );

        //console.log( "--------validando " + y[ i ].name );
        //console.log( "flagRequirido: " + flagRequirido );
        //console.log( "valor: " + y[ i ].value );
        //console.log( 'validade ' + y[ i ].checkValidity( ) );

        if (flagRequirido && (y[i].value == "")) {
          setarInvalido(y[i]);
          valid = false;
        }

        if (y[i].name == "cnpjDaInstituicao") {

          if (!IsCNPJ(y[i].value)) {
            mostrarAvisoValidacao(y[i], 'CNPJ');
            valid = false;
          } else {
            ocultarAvisoValidacao(y[i]);
          }
        }


        if (y[i].name == "cepDaInstituicao") {

          if (!y[i].checkValidity()) {
            valid = false;
            mostrarAvisoValidacao(y[i], 'CEP');
          } else {
            ocultarAvisoValidacao(y[i]);
          }
        }

        //preciso da flag de requirido pq esse elemento existe em todos as redes
        if (flagRequirido && y[i].name.includes("cpfRepresentante_")) {

          if (!IsCPF(y[i].value)) {
            mostrarAvisoValidacao(y[i], 'CPF');
            valid = false;
          } else {
            ocultarAvisoValidacao(y[i]);
          }
        }

        break;

      case "email":
        //console.log( "email" );

        if (flagRequirido && (y[i].value == "")) {
          setarInvalido(y[i]);
          valid = false;
        }

        if (!IsEmail(y[i].value)) {
          mostrarAvisoValidacao(y[i], 'E-mail');
          valid = false;
        } else {
          ocultarAvisoValidacao(y[i]);
        }

        break;

      case "file":
        //console.log( "file" );

        var extensoesPermitidas = {
          'logo_instituicao': ['jpg', 'png', 'jpeg'],
          'guia_instituicao': ['pdf'],
        }

        var tamanhoPermitido = {
          'logo_instituicao': 5242880,
          'guia_instituicao': 26214400,
        }

        if (flagRequirido || (y[i].value != "")) {

          //checar extensão
          var nomeArquivo = y[i].value.split(".");
          var extensao = nomeArquivo[nomeArquivo.length - 1].toLowerCase();

          // console.log( "nomeArquivo: " + nomeArquivo );
          // console.log( "extensao: " + extensao );
          // console.log( "verificacao: " + extensoesPermitidas[ y[ i ].name ].includes( extensao ) );

          if (!extensoesPermitidas[y[i].name].includes(extensao) || y[i].files.length == 0) {
            setarInvalido(y[i]);
            valid = false;
          }

          if (y[i].files.length > 0) {
            var tamanho = y[i].files[0].size;
            //console.log( "tamanho: " + tamanho );

            if (tamanho > tamanhoPermitido[y[i].name]) {
              //setarInvalido( y[ i ] );
              //valid = false;
              mostrarAvisoValidacao(document.getElementById(y[i].name), 'Arquivo');
              valid = false;
            } else {
              ocultarAvisoValidacao(document.getElementById(y[i].name));
            }
          }


        }
        break;

      case "url":
        //console.log( "url" );

        if (flagRequirido && (y[i].value == "")) {
          setarInvalido(y[i]);
          valid = false;
        }

        if (y[i].name == "urlDaInstituicao") {
          if (!IsURL(y[i].value)) {
            mostrarAvisoValidacao(y[i], 'URL');
            valid = false;
          } else {
            ocultarAvisoValidacao(y[i]);
          }

        }

        break;

      case "tel":
        //console.log( "tel" );

        // console.log( "--------validando " + y[ i ].name );
        // console.log( "flagRequirido: " + flagRequirido );
        // console.log( "valor: " + y[ i ].value );
        // console.log( 'validade ' + y[ i ].checkValidity( ) );

        // esse tem uma validação diferente
        // if ( flagRequirido && ( !y[ i ].checkValidity( ) ) ) {
        //   setarInvalido( y[ i ] );
        //   valid = false;
        // }

        if (flagRequirido && (y[i].value == "")) {
          setarInvalido(y[i]);
          valid = false;
        }

        if (!y[i].checkValidity()) {
          valid = false;
          mostrarAvisoValidacao(y[i], 'Telefone');
        } else {
          ocultarAvisoValidacao(y[i]);
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

        classe = y[i].classList.item(0);
        // If específico para natureza_op
        if (classe == 'natureza_op') {
          if (!checarRadio.includes(classe)) {
            checarRadio.push(classe);
          }
        }

        // Se o natureza_op for igual 4 ou 5 (instituição privada), inclui o outro radio para validação
        if (y[i].checked == true && (y[i].id == "natureza_op_4" || y[i].id == "natureza_op_5")) {
          //console.log( 'entrei na validação dos op4 e op5' );
          checarRadio.push('porte_op');
        }

        break;

      case "checkbox":
        //console.log( "checkbox" );
        //console.log( "--------validando " + y[ i ].name );

        classe = y[i].classList.item(0);

        if (classe == 'checkConcordo') {
          if (y[i].checked == false) {
            setarInvalido(y[i]);
            valid = false;
          }
        }

        // If específico para check_redes
        if (classe == 'check_redes') {

          if (!checarCheckbox.includes(classe)) {
            checarCheckbox.push(classe);
          }

          // Se algum dos check de check_redes estiver marcado, os outros dele estarão abertos
          if (y[i].checked == true) {

            //console.log( 'entrei na validação do ' + y[ i ].id );
            nomeRede = y[i].id.split('_')[1]; //pegar segundo nome

            checkClassificacao = 'check_classificacao_rede-de-' + nomeRede;
            checkPublico = 'check_publico_rede-de-' + nomeRede;
            checkAbrangencia = 'check_abrangencia_rede-de-' + nomeRede;

            // console.log( checkClassificacao );
            // console.log( checkPublico );
            // console.log( checkAbrangencia );

            if (!checarCheckbox.includes(checkClassificacao)) {
              checarCheckbox.push(checkClassificacao);
              checarCheckbox.push(checkPublico);
              checarCheckbox.push(checkAbrangencia);
            }
          }
        }

        break;

      default:
        console.log("default");
        console.log(y[i].type);
        // code block
        break;

    }

    // if ( y[ i ].type != 'checkbox' ) {
    //   console.log( valid + " VALID depois da input: " + y[ i ].name );
    // }
  }

  //console.log( 'checarCheckbox' );
  //console.log( checarCheckbox );
  for (c = 0; c < checarRadio.length; c++) {
    valid = validaFormularioRadio(x, currentTab, checarRadio[c], valid);
  }

  for (c = 0; c < checarCheckbox.length; c++) {
    valid = validaFormularioCheckbox(x, currentTab, checarCheckbox[c], valid);
  }

  //console.log( "VALID depois da validaFormularioRadio: " + valid );


  /**
   * Checar Textarea (t)
   */
  for (i = 0; i < t.length; i++) {

    requirido = t[i].getAttribute("required");
    flagRequirido = false;

    // mesma lógica do ativo
    if (requirido === "") {
      flagRequirido = true;
    }

    if (flagRequirido) {
      if (t[i].value == "") {
        setarInvalido(t[i]);
        valid = false;
      }
    }

    // console.log( valid + " VALID depois da textarea: " + t[ i ].name );
  }

  //console.log( "VALID: " + valid );
  //return false;
  return valid;
}

function validarEspecifico(name) {
  element = document.getElementById(name);

  if (name == "cnpjDaInstituicao") {

    if (!IsCNPJ(element.value)) {
      mostrarAvisoValidacao(element, 'CNPJ');
    } else {
      ocultarAvisoValidacao(element);
    }

  }

  if (name == "urlDaInstituicao") {

    if (!IsURL(element.value)) {
      mostrarAvisoValidacao(element, 'URL');
    } else {
      ocultarAvisoValidacao(element);
    }

  }

  if (name == "cepDaInstituicao") {

    if (!element.checkValidity()) {
      mostrarAvisoValidacao(element, 'CEP');
    } else {
      ocultarAvisoValidacao(element);
    }
  }

  if (name.includes("cpfRepresentante_")) {

    // console.log("validar text cpfRepresentante_");
    //console.log(IsCPF(element.value));

    if (!IsCPF(element.value)) {
      mostrarAvisoValidacao(element, 'CPF');
    } else {
      ocultarAvisoValidacao(element);
    }

  }

  if (element.type == "email") {

    if (!IsEmail(element.value)) {
      mostrarAvisoValidacao(element, 'E-mail');
    } else {
      ocultarAvisoValidacao(element);
    }

  }

  if (element.type == "tel") {

    if (!element.checkValidity()) {
      mostrarAvisoValidacao(element, 'Telefone');
    } else {
      ocultarAvisoValidacao(element);
    }
  }


}

function validaFormularioRadio(x, currentTab, classe, valid) {

  //console.log( "checando classe " + classe )
  var r, flag = false;
  r = x[currentTab].getElementsByClassName(classe);

  //console.log( "tamanho de r (radio) " + r.length );

  if (r.length > 0) {

    flag = false;

    for (i = 0; i < r.length; i++) {
      if (r[i].checked) {
        flag = true;
      }
    }

    if (!flag) {

      //setarInvalido( r[ 0 ] );

      //for ( i = 0; i < r.length; i++ ) {
      // rodar o for ao inverso
      for (i = r.length - 1; i >= 0; i--) {
        setarInvalido(r[i]);
      }

      //r[ 0 ].className += " invalid";
      //document.getElementById( r[ 0 ].name + "_label" ).style = "";
      valid = false;
    }

  }
  return valid;
}


function validaFormularioCheckbox(x, currentTab, classe, valid) {

  //console.log( "checando classe " + classe )
  var r, flag = false;
  r = x[currentTab].getElementsByClassName(classe);

  //console.log( "tamanho de r (checkbox) " + r.length );

  if (r.length > 0) {

    flag = false;

    for (i = 0; i < r.length; i++) {
      if (r[i].checked) {
        flag = true;
      }
    }

    if (!flag) {

      for (i = 0; i < r.length; i++) {
        setarInvalido(r[i]);
      }

      valid = false;
    }

  }
  return valid;
}

function validaFormularioGeral(x, nome, flag, valid) {
  var r, y;
  y = x[currentTab].getElementsByTagName("input");
  for (i = 0; i < y.length; i++) {
    if (y[i].name == nome) {
      if (flag) {
        if (!y[i].checkValidity()) {
          y[i].className += " invalid";
          document.getElementById(y[i].name + "_label").style = "";
          valid = false;
        }
      } else {
        if (y[i].value != "") {
          if (!y[i].checkValidity()) {
            y[i].className += " invalid";
            document.getElementById(y[i].name + "_label").style = "";
            valid = false;
          }
        }
      }
    }
  }
  return valid;
}

function getValueRadio(radioElement) {
  if (radioElement.length > 0) {
    for (i = 0; i < radioElement.length; i++) {
      if (radioElement[i].checked) {
        return radioElement[i].value;
      }
    }
  }
  return "";
}


var alteradosArrayGlobal = [];

function changeError(name) {
  //incluo no array global qual item foi alterado
  if (!alteradosArrayGlobal.includes(name)) {
    alteradosArrayGlobal.push(name);
    //console.log({ alteradosArrayGlobal });
  }

  setarValido(document.getElementById(name));
}


function changeErrorRadio(name) {
  r = document.getElementsByClassName(name);

  if (r.length > 0) {

    for (i = 0; i < r.length; i++) {
      setarValido(r[i]);

      if (r[i].checked == true) {
        //incluo no array global qual item foi alterado
        if (!alteradosArrayGlobal.includes(r[i].id)) {
          alteradosArrayGlobal.push(r[i].id);
          //console.log({ alteradosArrayGlobal });
        }
      }
    }
  }
}

function changeErrorCheck(name) {
  if (!alteradosArrayGlobal.includes(name)) {
    alteradosArrayGlobal.push(name);
    //console.log({ alteradosArrayGlobal });
  } else {
    //check só deve salvar na primeira vez que for alterado
    alteradosArrayGlobal.pop(name);
  }

  //uso um element para pegar a classe
  element = document.getElementById(name);
  classe = element.classList.item(0); //pegar a classe -> check_redes
  //console.log( classe );

  //agora sim, uso a classe pra fazer o que precis
  r = document.getElementsByClassName(classe);

  if (r.length > 0) {

    for (i = 0; i < r.length; i++) {
      setarValido(r[i]);
    }

  }
}

function IsEmail(email) {
  if (email == "") {
    return true;
  }
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function IsURL(url) {
  if (url == "") {
    return true;
  } else {
    if (url.indexOf("http://") == 0 || url.indexOf("https://") == 0) {
      return true;
    } else {
      return false;
    }
  }
}

function IsCPF(cpf) {
  cpf = cpf.replace(/\D/g, '');
  if (cpf.toString().length != 11 || /^(\d)\1{10}$/.test(cpf)) return false;
  var result = true;
  [9, 10].forEach(function (j) {
    var soma = 0, r;
    cpf.split(/(?=)/).splice(0, j).forEach(function (e, i) {
      soma += parseInt(e) * ((j + 2) - (i + 1));
    });
    r = soma % 11;
    r = (r < 2) ? 0 : 11 - r;
    if (r != cpf.substring(j, j + 1)) result = false;
  });
  return result;
}

// https://gist.github.com/alexbruno/6623b5afa847f891de9cb6f704d86d02
function IsCNPJ(value) {
  if (!value) return false

  // Aceita receber o valor como string, número ou array com todos os dígitos
  const isString = typeof value === 'string'
  const validTypes = isString || Number.isInteger(value) || Array.isArray(value)

  // Elimina valor em formato inválido
  if (!validTypes) return false

  // Filtro inicial para entradas do tipo string
  if (isString) {
    // Limita ao máximo de 18 caracteres, para CNPJ formatado
    if (value.length > 18) return false

    // Teste Regex para veificar se é uma string apenas dígitos válida
    const digitsOnly = /^\d{14}$/.test(value)
    // Teste Regex para verificar se é uma string formatada válida
    const validFormat = /^\d{2}.\d{3}.\d{3}\/\d{4}-\d{2}$/.test(value)

    // Se o formato é válido, usa um truque para seguir o fluxo da validação
    if (digitsOnly || validFormat) true
    // Se não, retorna inválido
    else return false
  }

  // Guarda um array com todos os dígitos do valor
  const match = value.toString().match(/\d/g)
  const numbers = Array.isArray(match) ? match.map(Number) : []

  // Valida a quantidade de dígitos
  if (numbers.length !== 14) return false

  // Elimina inválidos com todos os dígitos iguais
  const items = [...new Set(numbers)]
  if (items.length === 1) return false

  // Cálculo validador
  const calc = (x) => {
    const slice = numbers.slice(0, x)
    let factor = x - 7
    let sum = 0

    for (let i = x; i >= 1; i--) {
      const n = slice[x - i]
      sum += n * factor--
      if (factor < 2) factor = 9
    }

    const result = 11 - (sum % 11)

    return result > 9 ? 0 : result
  }

  // Separa os 2 últimos dígitos de verificadores
  const digits = numbers.slice(12)

  // Valida 1o. dígito verificador
  const digit0 = calc(12)
  if (digit0 !== digits[0]) return false

  // Valida 2o. dígito verificador
  const digit1 = calc(13)
  return digit1 === digits[1]
}