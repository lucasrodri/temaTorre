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

  $to = "avaliador.torre@mcti.gov.br";

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

      // provavelmente não usado
    case 'apagar':
      $subject = 'Remoção de cadastro Torre MCTI';
      $message = msg_remocao_candidato($nomeDaInstituicao, $parecer);
      break;

    case 'publicado':
      $subject = 'Soluções publicadas na Torre MCTI';
      $message = msg_publicado_avaliador($nomeDaInstituicao);
      break;

    case 'despublicado':
      $subject = 'Soluções despublicadas na Torre MCTI';
      $message = msg_despublicado_avaliador($nomeDaInstituicao);
      break;

    default:
      # code...
      break;
  }

  //https://stackoverflow.com/a/41400815
  $headers[] = 'Content-Type: text/html; charset=UTF-8';
  //$headers[] = 'From: Me Myself <me@example.net>';
  //$headers[] = 'Cc: bcasamo@gmail.com';
  $headers[] = 'Bcc: bcasamo@yahoo.com.br';
  $headers[] = 'Bcc: lucasrc.rodri@gmail.com';

  wp_mail($to, $subject, $message, $headers);
}

function msg_candidatura_visualizar($nomeDaInstituicao)
{
  $message = '<p style="text-align: left;">Ol&aacute; Avaliador(a),</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">H&aacute; uma nova candidatura da institui&ccedil;&atilde;o ' . $nomeDaInstituicao . '.</p><p style="text-align: left;">Voc&ecirc; pode encontr&aacute;-la na p&aacute;gina de <a href="' . home_url() . '/visualizacao/" target="_blank" rel="noopener">Visualiza&ccedil;&atilde;o</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Aten&ccedil;&atilde;o: essa &eacute; uma mensagem autom&aacute;tica.</p>';
  return $message;
}

function msg_candidatura_avaliar($nomeDaInstituicao)
{
  $message = '<p style="text-align: left;">Ol&aacute; Avaliador(a),</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">A candidatura da institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ' est&aacute; &agrave; espera de an&aacute;lise em sua p&aacute;gina de <a href="' . home_url() . '/avaliador/" target="_blank" rel="noopener">Avalia&ccedil;&atilde;o</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Aten&ccedil;&atilde;o: essa &eacute; uma mensagem autom&aacute;tica.</p>';
  return $message;
}

function msg_avaliacao_enviada($nomeDaInstituicao, $status)
{
  $message = '<p style="text-align: left;">Ol&aacute; Avaliador(a),</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">A candidatura da institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ' foi avaliada com o status ' . $status . ' .</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Aten&ccedil;&atilde;o: essa &eacute; uma mensagem autom&aacute;tica.</p>';
  return $message;
}

function msg_desistencia_candidato($nomeDaInstituicao)
{
  $message = '<p style="text-align: left;">Ol&aacute; Avaliador(a),</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">A institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ' desistiu do processo de candidatura, n&atilde;o sendo necess&aacute;ria a an&aacute;lise de sua(s) solu&ccedil;&atilde;o(&ccedil;&otilde;es).</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Aten&ccedil;&atilde;o: essa &eacute; uma mensagem autom&aacute;tica.</p>';
  return $message;
}

// provavelmente não usado
function msg_remocao_candidato($nomeDaInstituicao, $parecer)
{
  $message = '<p style="text-align: left;">Ol&aacute; Avaliador(a),</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">A candidatura da institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ' foi removida do sistema com o seguinte parecer ' . $parecer . ' .</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Aten&ccedil;&atilde;o: essa &eacute; uma mensagem autom&aacute;tica.</p>';
  return $message;
}

function msg_publicado_avaliador($nomeDaInstituicao)
{
  $message = '<p style="text-align: left;">Ol&aacute; Avaliador(a),</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">A(s) solu&ccedil;&atilde;o(&otilde;es) &agrave; Torre MCTI da institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ' foi(foram) publicada(s).</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Aten&ccedil;&atilde;o: essa &eacute; uma mensagem autom&aacute;tica.</p>';
  return $message;
}

function msg_despublicado_avaliador($nomeDaInstituicao)
{
  $message = '<p style="text-align: left;">Ol&aacute; Avaliador(a),</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">A(s) solu&ccedil;&atilde;o(&otilde;es) &agrave; Torre MCTI da institui&ccedil;&atilde;o ' . $nomeDaInstituicao . ' foi(foram) despublicada(s).</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Aten&ccedil;&atilde;o: essa &eacute; uma mensagem autom&aacute;tica.</p>';
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

function envia_email($etapa, $nomeDaInstituicao, $emailDoCandidato, $rede = '', $username = '', $password = '', $resumo = '')
{

  $to = $emailDoCandidato;

  $subject = '';
  $message = '';

  switch ($etapa) {
    case 'cadastro':
      $subject = 'Recebemos sua candidatura à Torre MCTI';
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
      $subject = 'A solicitação de edição da(s) solução(ões) de sua instituição na Torre MCTI foi recebida';
      $message = msg_editar($nomeDaInstituicao);
      break;

    case 'homologado':
      $subject = 'Seu processo de candidatura à Torre MCTI foi homologado';
      $message = msg_homologado($nomeDaInstituicao, $resumo);
      break;

      /*
      // esse caso não será mais usado, agora enviaremos o 'resumo'
    case 'pendente':
      $subject = 'Seu processo de candidatura à Torre MCTI foi atualizado - adequações';
      $message = msg_pendente($nomeDaInstituicao, $parecer);
      break;

    case 'apagar':
      $subject = 'Seu processo de candidatura à Torre MCTI foi apagado';
      $message = msg_apagar($nomeDaInstituicao, $parecer);
      break;
    */

    case 'publicado':
      $subject = 'As soluções de sua instituição foram publicadas na Torre MCTI';
      $message = msg_publicado($nomeDaInstituicao, $rede, $resumo);
      break;

    case 'despublicado':
      $subject = 'As soluções de sua instituição foram despublicadas na Torre MCTI';
      $message = msg_despublicado($nomeDaInstituicao);
      break;

    case 'resumo':
      $subject = 'Seu processo de candidatura à Torre MCTI foi atualizado - adequações';
      $message = msg_resumo_avaliacao($nomeDaInstituicao, $resumo);
      break;

    case 'rede_adicionada':
      $subject = 'Seu processo de candidatura à Torre MCTI foi atualizado - nova solução enviada';
      $message = msg_reenviar($nomeDaInstituicao);
      break;

    case 'rede_excluida':
      $subject = 'Atualização de dados Torre MCTI - solução removida';
      $message = msg_rede_excluida($nomeDaInstituicao, $rede);
      break;

    default:
      # code...
      break;
  }

  //https://stackoverflow.com/a/41400815
  $headers[] = 'Content-Type: text/html; charset=UTF-8';
  //$headers[] = 'From: Me Myself <me@example.net>';
  //$headers[] = 'Cc: bcasamo@gmail.com';
  $headers[] = 'Bcc: bcasamo@yahoo.com.br';
  //$headers[] = 'Bcc: lucasrc.rodri@gmail.com';

  wp_mail($to, $subject, $message, $headers);
}


/*
* Mensagens enviadas para o Candidato
*/

function msg_cadastro($nomeDaInstituicao, $username, $password)
{

  $message = '<p style="text-align: left;">Ol&aacute;, respons&aacute;vel pelo cadastro da(o) ' . $nomeDaInstituicao . ' na Torre MCTI.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Recebemos a solicita&ccedil;&atilde;o de cadastro da sua institui&ccedil;&atilde;o na Torre MCTI.&nbsp;</p><p style="text-align: left;">Seu login de acesso &eacute; <strong>' . $username . '</strong> e sua senha &eacute; <strong>' . $password . '</strong></p><p style="text-align: left;">Voc&ecirc; pode acompanhar seu processo na p&aacute;gina de <a href="' . home_url() . '/acompanhamento/" target="_blank" rel="noopener">Acompanhamento</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">A Sexec/MCTI poder&aacute; entrar em contato para solicitar complementa&ccedil;&atilde;o de informa&ccedil;&otilde;es e/ou sugerir modifica&ccedil;&otilde;es nos dados registrados antes de envio para homologa&ccedil;&atilde;o do cadastro.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Agradecemos novamente o interesse em fazer parte da Torre MCTI!</p><p style="text-align: left;">Cordialmente,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  //$message = '<p style="text-align: left;">Ol&aacute;, respons&aacute;vel pelo cadastro da(o) ' . $nomeDaInstituicao . ' na Torre MCTI.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Recebemos a solicita&ccedil;&atilde;o de cadastro da sua institui&ccedil;&atilde;o na Torre MCTI.&nbsp;</p><p style="text-align: left;">A Sexec/MCTI poder&aacute; entrar em contato para solicitar complementa&ccedil;&atilde;o de informa&ccedil;&otilde;es e/ou sugerir modifica&ccedil;&otilde;es nos dados registrados antes de envio para homologa&ccedil;&atilde;o do cadastro.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Agradecemos novamente o interesse em fazer parte da Torre MCTI!</p><p style="text-align: left;">Cordialmente,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}

function msg_desistir($nomeDaInstituicao)
{

  $message = '<p style="text-align: left;">Ol&aacute;, respons&aacute;vel pelo cadastro da(o) ' . $nomeDaInstituicao . ' na Torre MCTI.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Informamos que atendemos ao seu pedido de cancelamento do processo de cadastro para se tornar membro da Torre MCTI.&nbsp;</p><p style="text-align: left;">Esperamos que tenha interesse em se tornar membro novamente no futuro. Se voc&ecirc; mudar de ideia &eacute; s&oacute; reiniciar o processo seguindo o passo a passo dispon&iacute;vel no portal da <a href="' . home_url() . '/orientacoes/" target="_blank" rel="noopener">Torre MCTI</a>.&nbsp;</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Cordialmente,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}

function msg_reenviar($nomeDaInstituicao)
{

  $message = '<p style="text-align: left;">Ol&aacute;, respons&aacute;vel pelo cadastro da(o) ' . $nomeDaInstituicao . ' na Torre MCTI.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Recebemos os dados atualizados da solicita&ccedil;&atilde;o de cadastro da sua institui&ccedil;&atilde;o na Torre MCTI. Voc&ecirc; pode acompanhar seu processo na p&aacute;gina de <a href="' . home_url() . '/acompanhamento/" target="_blank" rel="noopener">Acompanhamento</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Agradecemos novamente o seu interesse em fazer parte da Torre MCTI!</p><p style="text-align: left;">Cordialmente,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}

function msg_editar($nomeDaInstituicao)
{

  $message = '<p style="text-align: left;">Ol&aacute;, respons&aacute;vel pelo cadastro da(o) ' . $nomeDaInstituicao . ' na Torre MCTI.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Identificamos que alguma(s) solu&ccedil;&atilde;o(&otilde;es) foi(foram) modificada(s) no(s) cadastro(s) da sua institui&ccedil;&atilde;o na Torre MCTI. Voc&ecirc; pode acompanhar seu processo na p&aacute;gina de <a href="' . home_url() . '/acompanhamento/" target="_blank" rel="noopener">Acompanhamento</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">A Sexec/MCTI poder&aacute; entrar em contato para solicitar complementa&ccedil;&atilde;o de informa&ccedil;&otilde;es e/ou sugerir modifica&ccedil;&otilde;es nos dados j&aacute; homologados.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Cordialmente,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}


function msg_rede_excluida($nomeDaInstituicao, $rede)
{
  $message = '<p style="text-align: left;">Ol&aacute;, respons&aacute;vel pelo cadastro da(o) ' . $nomeDaInstituicao . ' na Torre MCTI.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Identificamos que a solu&ccedil;&atilde;o da Rede de ' . $rede . ' foi removida. Voc&ecirc; pode acompanhar seu processo na p&aacute;gina de <a href="' . home_url() . '/acompanhamento/" target="_blank" rel="noopener">Acompanhamento</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Agradecemos novamente o seu interesse em fazer parte da Torre MCTI!</p><p style="text-align: left;">Cordialmente,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}


/*
* Mensagens "automáticas" para o Avaliador
*/

function msg_homologado($nomeDaInstituicao, $resumo)
{

  $message = '<p style="text-align: left;">Ol&aacute;, respons&aacute;vel pelo cadastro da(o) ' . $nomeDaInstituicao . ' na Torre MCTI.</p><p style="text-align: left;">&nbsp;</p><p>Informamos que o cadastro da sua institui&ccedil;&atilde;o na Torre MCTI foi homologado na(s) rede(s):</p><p>' . $resumo . '</p><p>&nbsp;</p><p>Aguardamos a assinatura do Termo de Ades&atilde;o e, se for institui&ccedil;&atilde;o privada, tamb&eacute;m a Declara&ccedil;&atilde;o de atendimento &agrave;s condi&ccedil;&otilde;es espec&iacute;ficas.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Voc&ecirc; pode acompanhar seu processo na p&aacute;gina de <a href="' . home_url() . '/acompanhamento/" target="_blank" rel="noopener">Acompanhamento</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Cordialmente,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}

// provavelmente não usado
function msg_pendente($nomeDaInstituicao, $parecer)
{

  $message = '<p style="text-align: left;">Ol&aacute;, respons&aacute;vel pelo cadastro da(o) ' . $nomeDaInstituicao . ' na Torre MCTI.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Informamos que a equipe de avalia&ccedil;&atilde;o encontrou problemas no seu processo para se tornar membro da Torre MCTI. Para obter mais informa&ccedil;&otilde;es <a href="' . home_url() . '/acompanhamento/">clique aqui</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">O parecer de sua candidatura &eacute; o seguinte:<br />' . $parecer . '</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Cordialmente,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}

// provavelmente não usado
function msg_apagar($nomeDaInstituicao, $parecer)
{

  $message = '<p style="text-align: left;">Ol&aacute;, respons&aacute;vel pelo cadastro da(o) ' . $nomeDaInstituicao . ' na Torre MCTI.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Informamos que seu processo de candidatura &agrave; Torre MCTI foi removido por um de nossos Avaliadores.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">O parecer de sua candidatura &eacute; o seguinte:<br />' . $parecer . '</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Cordialmente,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}

function msg_publicado($nomeDaInstituicao, $rede, $classificacoes)
{

  $message = '<p style="text-align: left;">Ol&aacute;, respons&aacute;vel pelo cadastro da(o) ' . $nomeDaInstituicao . ' na Torre MCTI.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Informamos que a solu&ccedil;&atilde;o da Rede de ' . $rede . ' &agrave; Torre MCTI foi publicada nas seguintes classifica&ccedil;&otilde;es:</p><p style="text-align: left;">' . $classificacoes . '</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Voc&ecirc; pode acompanh&aacute;-la(s) no portal da <a href="' . home_url() . '" target="_blank" rel="noopener">Torre MCTI</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Cordialmente,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}


function msg_despublicado($nomeDaInstituicao)
{

  $message = '<p style="text-align: left;">Ol&aacute;, respons&aacute;vel pelo cadastro da(o) ' . $nomeDaInstituicao . ' na Torre MCTI.</p><p style="text-align: left;">&nbsp;</p><p>Informamos que a(s) solu&ccedil;&atilde;o(&otilde;es) &agrave; Torre MCTI foi(foram) despublicada(s) por um de nosso avaliadores.</p><p>Voc&ecirc; pode acompanh&aacute;-la(s) no portal da <a href="' . home_url() . '" target="_blank" rel="noopener">Torre MCTI</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Cordialmente,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}

function msg_resumo_avaliacao($nomeDaInstituicao, $resumo)
{

  $message = '<p style="text-align: left;">Ol&aacute;, respons&aacute;vel pelo cadastro da(o) ' . $nomeDaInstituicao . ' na Torre MCTI.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Segue o resumo da an&aacute;lise da candidatura:</p><p>' . $resumo . '</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Voc&ecirc; pode ajustar os dados, bem como acompanhar seu processo na p&aacute;gina de <a href="' . home_url() . '/acompanhamento/">Acompanhamento</a>.</p><p style="text-align: left;">&nbsp;</p><p style="text-align: left;">Aguardamos a realiza&ccedil;&atilde;o dos ajustes indicados para encaminhar os dados para homologa&ccedil;&atilde;o.</p><p style="text-align: left;">Cordialmente,</p><p style="text-align: left;">Equipe Torre MCTI.</p>';

  return $message;
}
