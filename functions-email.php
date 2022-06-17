<?php

/*
* Mensagens e funções de email
*/

function enderecos_email($emailDoCandidato) {
	$to = $emailDoCandidato . ", torre@mcti.gov.br"; //adicionar outros e-mails
	return $to;
}


// exemplo no cadastro
//envia_email('cadastro', $nomeDaInstituicao, $emailDoCandidato, $parecer='', $username, $password);
//envia_email('desistir', $nomeDaInstituicao, $emailDoCandidato)
//envia_email('reenviar', $nomeDaInstituicao, $emailDoCandidato)
//envia_email('editar',   $nomeDaInstituicao, $emailDoCandidato)
//envia_email('aprovado', $nomeDaInstituicao, $emailDoCandidato, $parecer)
//envia_email('pendente', $nomeDaInstituicao, $emailDoCandidato, $parecer)
//envia_email('apagar',   $nomeDaInstituicao, $emailDoCandidato, $parecer)


function envia_email($etapa, $nomeDaInstituicao, $emailDoCandidato, $parecer='', $username='', $password='') {
  
  $to = enderecos_email($emailDoCandidato);

  $subject ='';
  $message = '';
  
  switch ($etapa) {
    case 'cadastro':
      $subject = 'Seu processo de candidatura à Torre MCTI foi recebido';
      $message = msg_cadastro($nomeDaInstituicao, $username, $password);
      break;

    case 'desistir':
      $subject = 'Sua desistência do processo de candidatura à Torre MCTI foi recebida';
      $message = msg_desistir($nomeDaInstituicao);
      break;

    case 'reenviar':
      $subject = 'Seu processo de candidatura à Torre MCTI foi reenviado';
      $message = msg_reenviar($nomeDaInstituicao);
      break;

    case 'editar':
      $subject = 'A edição da sua candidatura à Torre MCTI foi recebida';
      $message = msg_editar($nomeDaInstituicao);
      break;

    case 'aprovado':
      $subject = 'Seu processo de candidatura à Torre MCTI foi homologado';
      $message = msg_aprovado($nomeDaInstituicao, $parecer);
      break;

    case 'pendente':
      $subject = 'Seu processo de candidatura à Torre MCTI foi atualizado';
      $message = msg_pendente($nomeDaInstituicao, $parecer);
      break;

    case 'apagar':
      $subject = 'Seu processo de candidatura à Torre MCTI foi apagado';
      $message = msg_apagar($nomeDaInstituicao, $parecer);
      break;
    
      default:
      # code...
      break;
  }

  $headers = array('Content-Type: text/html; charset=UTF-8');

  wp_mail( $to, $subject, $message, $headers );

}


/*
* Mensagens "automáticas" para o Candidato
*/

function msg_cadastro($nomeDaInstituicao, $username, $password) {
	/*
	* Chamada pela função ???? do functions.php
	*/

	$message = '<<p style="text-align: center;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o '.$nomeDaInstituicao.',</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">Recebemos os dados da sua candidatura e a partir de agora falta pouco para concluir o seu processo de cadastro e se tornar membro da Torre MCTI.&nbsp;</p><p style="text-align: center;">Seu login de acesso &eacute; "'.$username.'" e sua senha &eacute; "'.$password.'" (sem aspas). Voc&ecirc; pode acompanhar seu processo na p&aacute;gina de <a href="https://torre.mcti.gov.br/analise/" target="_blank" rel="noopener">An&aacute;lise</a>.</p><p style="text-align: center;">Isso por que todos os cadastros que recebemos passam por uma an&aacute;lise pelos membros do Comit&ecirc; Gestor, como descrito no passo a passo.</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">Agradecemos novamente o seu interesse em fazer parte da Torre MCTI!</p><p style="text-align: center;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: center;">Equipe Torre MCTI.</p>';

	return $message;
}

function msg_desistir($nomeDaInstituicao) {
	/*
	* Chamada pela função ????? do functions.php
	*/

	$message = '<p style="text-align: center;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o '.$nomeDaInstituicao.',</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">Informamos que atendemos ao seu pedido de cancelamento do processo de cadastro para se tornar membro da Torre MCTI.&nbsp;</p><p style="text-align: center;">Esperamos que tenha interesse em se tornar membro novamente no futuro. Se voc&ecirc; mudar de ideia &eacute; s&oacute; reiniciar o processo seguindo o passo a passo dispon&iacute;vel no portal da <a href="https://torre.mcti.gov.br/orientacoes/" target="_blank" rel="noopener">Torre MCTI</a>.&nbsp;</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: center;">Equipe Torre MCTI.</p>';

	return $message;
}

function msg_reenviar($nomeDaInstituicao) {
	/*
	* Chamada pela função ??? do functions.php
	*/

	$message = '<p style="text-align: center;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o '.$nomeDaInstituicao.',</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">Recebemos os dados atualizados da sua candidatura e a partir de agora falta pouco para concluir o seu processo de cadastro e se tornar membro da Torre MCTI.&nbsp;</p><p style="text-align: center;">Voc&ecirc; pode acompanhar seu processo na p&aacute;gina de <a href="https://torre.mcti.gov.br/analise/" target="_blank" rel="noopener">An&aacute;lise</a>.</p><p style="text-align: center;">Isso por que todos os cadastros que recebemos passam por uma an&aacute;lise pelos membros do Comit&ecirc; Gestor, como descrito no passo a passo.</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">Agradecemos novamente o seu interesse em fazer parte da Torre MCTI!</p><p style="text-align: center;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: center;">Equipe Torre MCTI.</p>';

	return $message;
}

function msg_editar($nomeDaInstituicao) {
	/*
	* Chamada pela função ??? do functions.php
	*/

	$message = '<p style="text-align: center;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o '.$nomeDaInstituicao.',</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">Os dados da sua candidatura na Torre MCTI foram editados!</p><p style="text-align: center;">Voc&ecirc; pode acompanhar seu processo na p&aacute;gina de <a href="https://torre.mcti.gov.br/analise/" target="_blank" rel="noopener">An&aacute;lise</a>.</p><p style="text-align: center;">Isso por que todos as edi&ccedil;&otilde;es que recebemos passam por uma an&aacute;lise pelos membros do Comit&ecirc; Gestor.</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: center;">Equipe Torre MCTI.</p>';

	return $message;
}


/*
* Mensagens enviadas pelo Avaliador
*/

function msg_aprovado($nomeDaInstituicao, $parecer) {
	/*
	* Chamada pela função ???? do carregaform.php
	*/

	$message = '<p style="text-align: center;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o '.$nomeDaInstituicao.',</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">Ficamos felizes em dizer que seu processo de cadastro na Torre MCTI foi homologado.</p><p style="text-align: center;">Agora, voc&ecirc; deve assinar o termo de Ades&atilde;o (ou declara&ccedil;&atilde;o de atendimento &agrave;s condi&ccedil;&otilde;es espec&iacute;ficas).</p><p style="text-align: center;">Voc&ecirc; pode acompanhar seu processo na p&aacute;gina de <a href="https://torre.mcti.gov.br/analise/" target="_blank" rel="noopener">Acompanhamento</a>.</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">O parecer de sua candidatura &eacute; o seguinte:<br />'.$parecer.'</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: center;">Equipe Torre MCTI.</p>';

	return $message;
}

function msg_pendente($nomeDaInstituicao, $parecer) {
	/*
	* Chamada pela função ??? do carregaform.php
	*/

	$message = '<p style="text-align: center;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o '.$nomeDaInstituicao.',</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">Informamos que a equipe de avalia&ccedil;&atilde;o encontrou problemas no seu processo de ades&atilde;o. Para obter mais informa&ccedil;&otilde;es <a href="https://torre.mcti.gov.br/analise/">clique aqui</a>.</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">O parecer de sua candidatura &eacute; o seguinte:<br />'.$parecer.'</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: center;">Equipe Torre MCTI.</p>';

	return $message;
}

function msg_apagar($nomeDaInstituicao, $parecer) {
	/*
	* Chamada pela função ??? do functions.php
	*/

	$message = '<p style="text-align: center;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o '.$nomeDaInstituicao.',</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">Informamos que seu processo de candidatura &agrave; Torre MCTI foi removido por um de nossos Avaliadores.</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">O parecer de sua candidatura &eacute; o seguinte:<br />'.$parecer.'</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;">Esperamos que tenha interesse em se candidatar novamente no futuro.</p><p style="text-align: center;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: center;">Equipe Torre MCTI.</p>';

	return $message;
}