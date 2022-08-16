function publicaRede(painel, redeArray, entradaRedeId) {
  let text = "Você tem certeza que quer publicar esta rede? Essa ação publicará um novo post no Torre MCTI.";
  
  if (confirm(text) == true) {
    if (document.getElementById('entrada_geral')) {
      var entradaInstituicaoId = document.getElementById('entrada_geral').value;
    }

    if (document.getElementById('usuario_id')) {
      var usuario_id = document.getElementById('usuario_id').value;
    }

    //alert("Painel:" + painel + "\nredeArray:" + redeArray + "\nentradaRedeId:" + entradaRedeId + "\nentradaInstituicaoId:" + entradaInstituicaoId +"\nusuario_id:" +usuario_id);

    jQuery(function ($) {
      $.ajax({
          type: "POST",
          url: my_ajax_object.ajax_url,
          data: {
              action: 'publica_rede',
              usuario_id: usuario_id,
              rede: redeArray,
              entradaRedeId: entradaRedeId,
              entradaInstituicaoId: entradaInstituicaoId
          },
          beforeSend: function () {
              $("#loading_carregar").css("display", "block");
              //em vez de recarregar os dados, recarrego apenas o botão
              $('#divPublicado' + painel).html('');
          },
          success: function (html) {
              //console.log("Sucesso " + painel);
              $('#divPublicado_' + painel).html(html);
          },
          complete: function () {
              $("#loading_carregar").css("display", "none");
          }
      });
  });

  } else {
    return;
  }
}

function despublicaRede(painel, redeArray, entradaRedeId) {
  let text = "Você tem certeza que quer despublicar esta rede? Essa ação transformará o post existente como rascunho no Torre MCTI.";
  
  if (confirm(text) == true) {
    if (document.getElementById('entrada_geral')) {
      var entradaInstituicaoId = document.getElementById('entrada_geral').value;
    }

    if (document.getElementById('usuario_id')) {
      var usuario_id = document.getElementById('usuario_id').value;
    }

    alert("Painel:" + painel + "\nredeArray:" + redeArray + "\nentradaRedeId:" + entradaRedeId + "\nentradaInstituicaoId:" + entradaInstituicaoId +"\nusuario_id:" +usuario_id);
    //TODO REBECA!
  } else {
    return;
  }
}