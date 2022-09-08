function publicaRede(painel, redeArray, entradaRedeId) {
  let text= "Você tem certeza que quer publicar as soluções dessa rede?\r\nAo clicar em Ok, as informações serão publicadas no website da Torre MCTI.\r\nVerifique se a instituição assinou o Termo de adesão e, se for privada, a Declaração específica para instituições privadas.";

  if (!confirm(text)) {
    return;
  }

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
        $('#tab_redes_' + painel).html('');
        window.scrollTo(0, 0);
      },
      success: function (html) {
        //console.log("Sucesso " + painel);
        $('#tab_redes_' + painel).html(html);
      },
      complete: function () {
        $("#loading_carregar").css("display", "none");
        // if (document.getElementById('div_' + redeArray)) {
        //   var historico = document.getElementById('div_' + redeArray);
        //   var titulo = historico.nextSibling;
        //   while (titulo && titulo.nodeType != 1) {
        //     titulo = titulo.nextSibling;
        //   }
        //   if (historico && titulo) {
        //     historico.before(titulo);
        //   }
        // }
        alert('Post publicado!');
      }
    });
  });

}

function despublicaRede(painel, redeArray, entradaRedeId) {
  let text = "Você tem certeza que quer despublicar esta rede? Essa ação transformará o post existente como rascunho no Torre MCTI.";

  if (!confirm(text)) {
    return;
  }

  if (document.getElementById('entrada_geral')) {
    var entradaInstituicaoId = document.getElementById('entrada_geral').value;
  }

  if (document.getElementById('usuario_id')) {
    var usuario_id = document.getElementById('usuario_id').value;
  }

  //alert("Painel:" + painel + "\nredeArray:" + redeArray + "\nentradaRedeId:" + entradaRedeId + "\nentradaInstituicaoId:" + entradaInstituicaoId + "\nusuario_id:" + usuario_id);

  jQuery(function ($) {
    $.ajax({
      type: "POST",
      url: my_ajax_object.ajax_url,
      data: {
        action: 'despublica_rede',
        usuario_id: usuario_id,
        rede: redeArray,
        entradaRedeId: entradaRedeId,
        entradaInstituicaoId: entradaInstituicaoId
      },
      beforeSend: function () {
        $("#loading_carregar").css("display", "block");
        $('#tab_redes_' + painel).html('');
        window.scrollTo(0, 0);
      },
      success: function (html) {
        //console.log("Sucesso " + painel);
        $('#tab_redes_' + painel).html(html);
      },
      complete: function () {
        $("#loading_carregar").css("display", "none");
        // if (document.getElementById('div_' + redeArray)) {
        //   var historico = document.getElementById('div_' + redeArray);
        //   var titulo = historico.nextSibling;
        //   while (titulo && titulo.nodeType != 1) {
        //     titulo = titulo.nextSibling;
        //   }
        //   if (historico && titulo) {
        //     historico.before(titulo);
        //   }
        // }
        alert('Post despublicado!');
      }
    });
  });

}