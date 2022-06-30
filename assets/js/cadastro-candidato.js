function carrega_candidato() {
  document.getElementById('carrega-form-btn').style.display = 'none';
  document.getElementById('edit-form-div').style.display = 'inline';
  document.getElementById('esconde-form-btn').style.display = 'inline';
}


function esconderFormulario() {
  document.getElementById('carrega-form-btn').style.display = 'inline';
  document.getElementById('edit-form-div').style.display = 'none';
  document.getElementById('esconde-form-btn').style.display = 'none';
}


function botaoRecurso() {
  var div = document.getElementById("recurso-div");
  var botao = document.getElementById("recurso-btn");

  div.style.display = "inline";
  botao.style.display = "none";
}