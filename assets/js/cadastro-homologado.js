function publicaRede(painel, redeArray, entradaRedeId) {
    let text = "Você tem certeza que quer publicar esta rede? Essa ação publicará um novo post no Torre MCTI.";
    if (confirm(text) == true) {
      if (document.getElementById('entrada_geral')) {
        var entradaInstituicaoId = document.getElementById('entrada_geral').value;
      }
      alert("Painel:"+painel+" redeArray:"+redeArray+" entradaRedeId:"+entradaRedeId+ " entradaInstituicaoId:"+entradaInstituicaoId);
      //TODO REBECA!
    } else {
      return;
    }
}

function despublicaRede(painel, redeArray, entradaRedeId) {
    let text = "Você tem certeza que quer publicar esta rede? Essa ação publicará um novo post no Torre MCTI.";
    if (confirm(text) == true) {
      if (document.getElementById('entrada_geral')) {
        var entradaInstituicaoId = document.getElementById('entrada_geral').value;
      }
      alert("Painel:"+painel+" redeArray:"+redeArray+" entradaRedeId:"+entradaRedeId+ " entradaInstituicaoId:"+entradaInstituicaoId);
      //TODO REBECA!
    } else {
      return;
    }
}