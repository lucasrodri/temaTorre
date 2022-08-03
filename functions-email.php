<?php

/*
* Mensagens e funções de email
*/

// exemplos para avaliador
//envia_email_avaliador('cadastro',   // novo cadastro de candidato -> formulário para avaliar
//envia_email_avaliador('desistir',   // aviso de desistência de candidatura -> ??
//envia_email_avaliador('reenviar',   // reenvio de cadastro de candidato -> formulário para avaliar
//envia_email_avaliador('editar',     // edição de cadastro de candidato -> formulário para avaliar
//envia_email_avaliador('homologado', // status de avaliação  -> ??
//envia_email_avaliador('pendente',   // status de avaliação  -> ??
//envia_email_avaliador('apagar',     // ação do avaliador de apagar -> ??
//envia_email_avaliador('publicado',  // status de avaliação  -> ??

function envia_email_avaliador($etapa, $nomeDaInstituicao, $parecer = '')
{

  // $to = "torre@mcti.gov.br, "; //adicionar outros e-mails
  $to = "bcasamo+torre@gmail.com";

  $subject = '';
  $message = '';

  switch ($etapa) {
    case 'cadastro':
      $subject = 'Cadastro Torre MCTI';
      $message = msg_candidatura_avaliar($nomeDaInstituicao);
      break;

    case 'desistir':
      $subject = 'Desistência de cadastro Torre MCTI';
      $message = msg_desistencia_candidato($nomeDaInstituicao);
      break;

    case 'reenviar':
      $subject = 'Atualização de cadastro Torre MCTI';
      $message = msg_candidatura_avaliar($nomeDaInstituicao);
      break;

    case 'editar':
      $subject = 'Requisição de atualização de cadastro Torre MCTI';
      $message = msg_candidatura_avaliar($nomeDaInstituicao);
      break;

    case 'homologado':
      $subject = 'Avaliação enviada';
      $message = msg_avaliacao_enviada($nomeDaInstituicao, 'Homologado');
      break;

    case 'pendente':
      $subject = 'Avaliação enviada';
      $message = msg_avaliacao_enviada($nomeDaInstituicao, 'Ajustes Necessários');
      break;

    case 'apagar':
      $subject = 'Remoção de cadastro Torre MCTI';
      $message = msg_remocao_candidato($nomeDaInstituicao, $parecer);
      break;

    case 'publicado':
      $subject = 'Avaliação enviada';
      $message = msg_avaliacao_enviada($nomeDaInstituicao, 'Publicado');
      break;

    default:
      # code...
      break;
  }

  $headers = array('Content-Type: text/html; charset=UTF-8');

  //wp_mail($to, $subject, $message, $headers);
}

function msg_candidatura_avaliar($nomeDaInstituicao)
{
  $message = '<p style="text-align: left;">Ol&aacute; Avaliador(es),</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">A candidatura da institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ' est&aacute; &agrave; espera de avalia&ccedil;&atilde;o.</p><p style="text-align: left;">Voc&ecirc; pode encontr&aacute;-la na p&aacute;gina de <a href="https://torre.mcti.gov.br/avaliador/" target="_blank" rel="noopener">Avalia&ccedil;&atilde;o</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Aten&ccedil;&atilde;o: essa &eacute; uma mensagem autom&aacute;tica do sistema de candidatura da Torre MCTI.</p>';
  return $message;
}

function msg_avaliacao_enviada($nomeDaInstituicao, $status)
{
  $message = '<p style="text-align: left;">Ol&aacute; Avaliador(es),</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">A candidatura da institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ' foi avaliada com o status ' . $status . ' .</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Aten&ccedil;&atilde;o: essa &eacute; uma mensagem autom&aacute;tica do sistema de candidatura da Torre MCTI.</p>';
  return $message;
}

function msg_desistencia_candidato($nomeDaInstituicao)
{
  $message = '<p style="text-align: left;">Ol&aacute; Avaliador(es),</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">A institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ' desistiu do processo de candidatura.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Aten&ccedil;&atilde;o: essa &eacute; uma mensagem autom&aacute;tica do sistema de candidatura da Torre MCTI.</p>';
  return $message;
}

function msg_remocao_candidato($nomeDaInstituicao, $parecer)
{
  $message = '<p style="text-align: left;">Ol&aacute; Avaliador(es),</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">A candidatura da institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ' foi removida do sistema com o seguinte parecer ' . $parecer . ' .</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Aten&ccedil;&atilde;o: essa &eacute; uma mensagem autom&aacute;tica do sistema de candidatura da Torre MCTI.</p>';
  return $message;
}


// exemplos para candidato
//envia_email('cadastro', $nomeDaInstituicao, $emailDoCandidato, '', $username, $password);
//envia_email('desistir', $nomeDaInstituicao, $emailDoCandidato)
//envia_email('reenviar', $nomeDaInstituicao, $emailDoCandidato)
//envia_email('editar',   $nomeDaInstituicao, $emailDoCandidato)
//envia_email('homologado', $nomeDaInstituicao, $emailDoCandidato, $parecer)
//envia_email('pendente', $nomeDaInstituicao, $emailDoCandidato, $parecer)
//envia_email('apagar',   $nomeDaInstituicao, $emailDoCandidato, $parecer)
//envia_email('publicado', $nomeDaInstituicao, $emailDoCandidato)
//envia_email('resumo', $nomeDaInstituicao, $emailDoCandidato, '', '', '', $resumo)

function envia_email($etapa, $nomeDaInstituicao, $emailDoCandidato, $parecer = '', $username = '', $password = '', $resumo = '')
{

  #$to = $emailDoCandidato . ", bcasamo+torre@gmail.com";
  $to = "lucasrc.rodri@gmail.com, bcasamo+torre@gmail.com";

  $subject = '';
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

    case 'homologado':
      $subject = 'Seu processo de candidatura à Torre MCTI foi homologado';
      $message = msg_homologado($nomeDaInstituicao, $parecer);
      break;

    case 'pendente':
      $subject = 'Seu processo de candidatura à Torre MCTI foi atualizado';
      $message = msg_pendente($nomeDaInstituicao, $parecer);
      break;

    case 'apagar':
      $subject = 'Seu processo de candidatura à Torre MCTI foi apagado';
      $message = msg_apagar($nomeDaInstituicao, $parecer);
      break;

    case 'publicado':
      $subject = 'Sua candidatura à Torre MCTI foi publicada';
      $message = msg_publicado($nomeDaInstituicao);
      break;

    case 'resumo':
      $subject =  'Seu processo de candidatura à Torre MCTI foi atualizado - adequações';
      $message = msg_resumo_avaliacao($nomeDaInstituicao, $resumo);
      break;

    default:
      # code...
      break;
  }

  $headers = array('Content-Type: text/html; charset=UTF-8');

  //wp_mail($to, $subject, $message, $headers);
}


/*
* Mensagens enviadas para o Candidato
*/

function msg_cadastro($nomeDaInstituicao, $username, $password)
{

  $message = '<p style="text-align: left;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ',</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Recebemos os dados da sua candidatura e a partir de agora falta pouco para concluir o seu processo de cadastro e se tornar membro da Torre MCTI.&nbsp;</p><p style="text-align: left;">Seu login de acesso &eacute; <strong>' . $username . '</strong> e sua senha &eacute; <strong>' . $password . '</strong>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Voc&ecirc; pode acompanhar seu processo na p&aacute;gina de <a href="https://torre.mcti.gov.br/acompanhamento/" target="_blank" rel="noopener">Acompanhamento</a>.</p><p style="text-align: left;">Isso porque todos os cadastros que recebemos passam por uma Acompanhamento pelos membros do Comit&ecirc; Gestor, como descrito no passo a passo.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Agradecemos novamente o seu interesse em fazer parte da Torre MCTI!</p><p style="text-align: left;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}

function msg_desistir($nomeDaInstituicao)
{

  $message = '<p style="text-align: left;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ',</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Informamos que atendemos ao seu pedido de cancelamento do processo de cadastro para se tornar membro da Torre MCTI.&nbsp;</p><p style="text-align: left;">Esperamos que tenha interesse em se tornar membro novamente no futuro. Se voc&ecirc; mudar de ideia &eacute; s&oacute; reiniciar o processo seguindo o passo a passo dispon&iacute;vel no portal da <a href="https://torre.mcti.gov.br/orientacoes/" target="_blank" rel="noopener">Torre MCTI</a>.&nbsp;</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}

function msg_reenviar($nomeDaInstituicao)
{

  $message = '<p style="text-align: left;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ',</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Recebemos os dados atualizados da sua candidatura e a partir de agora falta pouco para concluir o seu processo de cadastro e se tornar membro da Torre MCTI.&nbsp;</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Voc&ecirc; pode acompanhar seu processo na p&aacute;gina de <a href="https://torre.mcti.gov.br/acompanhamento/" target="_blank" rel="noopener">Acompanhamento</a>.</p><p style="text-align: left;">Isso porque todos os cadastros que recebemos passam por uma Acompanhamento pelos membros do Comit&ecirc; Gestor, como descrito no passo a passo.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Agradecemos novamente o seu interesse em fazer parte da Torre MCTI!</p><p style="text-align: left;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}

function msg_editar($nomeDaInstituicao)
{

  $message = '<p style="text-align: left;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ',</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Os dados da sua candidatura na Torre MCTI foram editados!</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Voc&ecirc; pode acompanhar seu processo na p&aacute;gina de <a href="https://torre.mcti.gov.br/acompanhamento/" target="_blank" rel="noopener">Acompanhamento</a>.</p><p style="text-align: left;">Isso porque todas as edi&ccedil;&otilde;es que recebemos passam por uma Acompanhamento pelos membros do Comit&ecirc; Gestor.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}


/*
* Mensagens "automáticas" para o Avaliador
*/

function msg_homologado($nomeDaInstituicao, $parecer)
{

  $message = '<p style="text-align: left;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ',</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Ficamos felizes em dizer que seu processo de cadastro na Torre MCTI foi homologado.</p><p style="text-align: left;">Agora, voc&ecirc; deve assinar o termo de Ades&atilde;o (ou declara&ccedil;&atilde;o de atendimento &agrave;s condi&ccedil;&otilde;es espec&iacute;ficas).</p><p style="text-align: left;">Voc&ecirc; pode acompanhar seu processo na p&aacute;gina de <a href="https://torre.mcti.gov.br/acompanhamento/" target="_blank" rel="noopener">Acompanhamento</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">O parecer de sua candidatura &eacute; o seguinte:<br />' . $parecer . '</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}

function msg_pendente($nomeDaInstituicao, $parecer)
{

  $message = '<p style="text-align: left;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ',</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Informamos que a equipe de avalia&ccedil;&atilde;o encontrou problemas no seu processo para se tornar membro da Torre MCTI. Para obter mais informa&ccedil;&otilde;es <a href="https://torre.mcti.gov.br/acompanhamento/">clique aqui</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">O parecer de sua candidatura &eacute; o seguinte:<br />' . $parecer . '</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}

function msg_apagar($nomeDaInstituicao, $parecer)
{

  $message = '<p style="text-align: left;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ',</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Informamos que seu processo de candidatura &agrave; Torre MCTI foi removido por um de nossos Avaliadores.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">O parecer de sua candidatura &eacute; o seguinte:<br />' . $parecer . '</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Esperamos que tenha interesse em se candidatar novamente no futuro.</p><p style="text-align: left;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}

function msg_publicado($nomeDaInstituicao)
{

  $message = '<p style="text-align: left;">Ol&aacute; caro respons&aacute;vel pela institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ',</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Ficamos felizes em dizer que sua candidatura &agrave; Torre MCTI foi publicada.</p><p style="text-align: left;">Voc&ecirc; pode acompanhar as publica&ccedil;&otilde;es na p&aacute;gina de <a href="https://torre.mcti.gov.br/acompanhamento/" target="_blank" rel="noopener">Acompanhamento</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Estamos &agrave; disposi&ccedil;&atilde;o,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}

function msg_resumo_avaliacao($nomeDaInstituicao, $resumo)
{

  $message = '<p style="text-align: left;">Ol&aacute; respons&aacute;vel pelo cadastro da(o) ' . $nomeDaInstituicao . ' na Torre MCTI.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Segue o resumo da an&aacute;lise da candidatura:</p>' . $resumo . '<p style="text-align: left;">Voc&ecirc; pode ajustar os dados, bem como acompanhar seu processo na p&aacute;gina de <a href="https://torre.mcti.gov.br/acompanhamento/">Acompanhamento</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Aguardamos a realiza&ccedil;&atilde;o dos ajustes indicados para encaminhar os dados para homologa&ccedil;&atilde;o.</p><p style="text-align: left;">Cordialmente,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}
