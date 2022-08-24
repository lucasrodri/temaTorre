<?php
/*
* Shortcode para renderizar o formulário dos homologados
*/
add_shortcode('shortcode_homologado_view', 'homologado_view');

function homologado_view()
{
    require_once(CFCORE_PATH . 'classes/admin.php');

    $current_user = wp_get_current_user();
    $usuario_id = $current_user->ID;
    $usuario_login = $current_user->user_login;

    $entradas = array();

    $data = Caldera_Forms_Admin::get_entries(FORM_ID_GERAL, 1, 9999999);
    $ativos = $data['active'];

    if ($ativos > 0) {
        $todasEntradas = $data['entries'];

        foreach ($todasEntradas as $umaEntrada) {
            $user_id = $umaEntrada['user']['ID'];
            $entrada = $umaEntrada['_entry_id'];
            $form = Caldera_Forms_Forms::get_form(FORM_ID_GERAL);
            // adicionar check da situação da rede geral fld_9748069
            $entry = new Caldera_Forms_Entry($form, $entrada);
            $statusIstituicao = valida($entry, 'fld_4899711');

            if ($statusIstituicao == 'homologado') {
                $entradas[$user_id] = array();
                $entradas[$user_id][] = $entry;
                $entradas[$user_id][] = $umaEntrada['_date'];
            }
        }
    }
    $todas_redes = "check_suporte;check_formacao;check_pesquisa;check_inovacao;check_tecnologia;";
    $arrayRedes = explode(";", $todas_redes);
?>
    <?php if (!$entradas) : ?>
        <div class="mb-5" id="lista-entradas-div">
            <p>Não há candidaturas para publicação.</p>
        </div>
    <?php else : ?>
        <div class="br-table mb-5" id="lista-entradas-div">
            <div class="table-header"></div>
            <table>
                <colgroup>
                    <col class="col-2">
                    <col class="col-7">
                    <col class="col-3">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">Data de submissão</th>
                        <th scope="col">Nome da Instituição</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entradas as $key => $entrada) : ?>
                        <?php $redes = valida($entrada[0], 'fld_4891375'); ?>
                        <tr onclick="carrega_avaliador('<?php echo $key; ?>','<?php echo $redes; ?>', '<?php echo valida($entrada[0], 'fld_266564'); ?>','true','true');">
                            <td data-th="Data"><?php echo date_i18n('M d, Y', strtotime($entrada[1])); ?></td>
                            <td data-th="Nome"><?php echo valida($entrada[0], 'fld_266564'); ?></td>
                            <td data-th="Status"><?php render_status(valida($entrada[0], 'fld_4899711')); ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>

    <form class="cardAvaliador" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
        <div id="entrada-form-div" class="br-accordion" id="accordion1" style="display: none;">
            <div class="item">
                <button class="header" type="button" aria-controls="id9"><span class="icon"><i class="fas fa-angle-down" aria-hidden="true"></i></span><span id='span-header-accordion' class="title">Instituição selecionada</span></button>
            </div>
            <div class="content" id="id9">

                <div class="br-tab mt-5">
                    <nav class="tab-nav font-tab-torre">
                        <ul>
                            <li class="tab-item active" id="tab-item-1">
                                <button type="button" data-panel="panel-1"><span class="name">Instituição</span></button>
                            </li>
                            <?php for ($i = 2; $i < count($arrayRedes) + 1; $i++) : ?>
                                <li class="tab-item" id="tab-item-<?php echo $i; ?>" style="display: none;">
                                    <button type="button" data-panel="panel-<?php echo $i; ?>"><span class="name"><?php echo relaciona($arrayRedes[$i - 2])[2] ?></span></button>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                    <div class="tab-content mt-4">
                        <div id='loading_carregar' class="loading medium" style='display:none;'></div>
                        <div class="tab-panel active" id="panel-1">
                            <div id="tab_instituicao"></div>
                        </div>
                        <?php for ($i = 2; $i < count($arrayRedes) + 1; $i++) : ?>
                            <div class="tab-panel" id="panel-<?php echo $i; ?>">
                                <div id="tab_redes_<?php echo $i; ?>"></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row mt-5">
        <div id="entrada-voltar-btn" class="col-md-12 text-center" style="display: none;">
            <a href="<?php echo home_url(); ?>/homologados/" class="br-button secondary">Voltar para lista de Instituições</a>
        </div>
    </div>

<?php
}


function botao_publicado_render($entry, $entrada_id, $rede)
{
    $todas_redes = "check_suporte;check_formacao;check_pesquisa;check_inovacao;check_tecnologia;";
    $arrayRedes = explode(";", $todas_redes);

    $nomeRede = "Rede de " . relaciona($rede)[2];
    $fld_status = "fld_3707629";
    $status = valida($entry, $fld_status);
    $i = array_search($rede, $arrayRedes) + 2;
?>
    <div id="divPublicado_<?php echo $i; ?>">
        <div class="row">
            <?php if ($status == "homologado") : ?>
                <div id="botaoPublicar_<?php echo $i; ?>" class="mt-5 col-md-12">
                    <div class="text-center">
                        <button class="br-button primary" type="button" onclick="publicaRede('<?php echo $i; ?>', '<?php echo $arrayRedes[$i - 2]; ?>', '<?php echo $entrada_id; ?>');">Publicar <?php echo $nomeRede; ?></button>
                    </div>
                </div>
            <?php elseif ($status == "publicado") : ?>
                <div id="botaoDespublicar_<?php echo $i; ?>" class="mt-5 col-md-12">
                    <div class="text-center">
                        <button class="br-button danger" type="button" onclick="despublicaRede('<?php echo $i; ?>', '<?php echo $arrayRedes[$i - 2]; ?>', '<?php echo $entrada_id; ?>');">Despublicar <?php echo $nomeRede; ?></button>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
<?php
}

function homologado_action_form()
{
    $usuario_id = (isset($_POST['usuario_id'])) ? $_POST['usuario_id'] : '';
    $rede = (isset($_POST['rede'])) ? $_POST['rede'] : '';
    $entradaInstituicaoId = (isset($_POST['entradaInstituicaoId'])) ? $_POST['entradaInstituicaoId'] : '';
    $entradaRedeId = (isset($_POST['entradaRedeId'])) ? $_POST['entradaRedeId'] : '';
    require_once(CFCORE_PATH . 'classes/admin.php');

    //-------------------------------------------------------- pegar os dados para o post
    // aba instituicao
    $formGeral = Caldera_Forms_Forms::get_form(FORM_ID_GERAL);
    $entryGeral = new Caldera_Forms_Entry($formGeral, $entradaInstituicaoId);

    $nomeDaInstituicao = valida($entryGeral, 'fld_266564');
    $emailDoCandidato = valida($entryGeral, 'fld_7868662');
    $descricaoDaInstituicao = valida($entryGeral, 'fld_6461522');
    $natureza_op = valida($entryGeral, 'fld_5902421');
    $doc1UnidadeUrl = valida($entryGeral, 'fld_5438248');
    $urlDaInstituicao = valida($entryGeral, 'fld_1962476');
    $enderecoDaInstituicao = valida($entryGeral, 'fld_3971477');
    $complementoDaInstituicao = valida($entryGeral, 'fld_937636');
    $estadoDaInstituicao = valida($entryGeral, 'fld_1588802');
    $cidadeDaInstituicao = valida($entryGeral, 'fld_2343542');
    $cepDaInstituicao = valida($entryGeral, 'fld_1936573');

    // aba da rede
    $form_id = relaciona($rede)[1];
    $form = Caldera_Forms_Forms::get_form($form_id);
    $entryRede = new Caldera_Forms_Entry($form, $entradaRedeId);

    $urlServico = valida($entryRede, 'fld_605717');
    $produtoServicos = valida($entryRede, 'fld_4486725');
    $publicos = valida($entryRede, 'fld_4665383');
    $abrangencias = valida($entryRede, 'fld_2391778');
    $nomeCompleto = valida($entryRede, 'fld_6140408');
    $cpfRepresentante = valida($entryRede, 'fld_2025685');
    $emailRepresentante = valida($entryRede, 'fld_7130000');
    $telefoneRepresentante = valida($entryRede, 'fld_5051662');

    $classificacoes = valida($entryRede, 'fld_8777940');
    //$outroClassificacao = valida($entryRede, 'fld_6678080'); //---- TODO: talvez inserir concatenar no solucao
    $tags_rede = valida($entryRede, 'fld_7938112');

    $historicoParecer = valida($entryRede, 'fld_6135036');

    //-------------------------------------------------------- criar o post
    //https://wordpress.stackexchange.com/questions/106973/wp-insert-post-or-similar-for-custom-post-type
    //https://wordpress.stackexchange.com/questions/244221/check-if-author-or-current-user-has-posts-published

    $post_type = relaciona($rede)[0];

    //--- deletando
    deleta_todos_posts($post_type, $usuario_id);

    //---- criacao do post
    $titulo = $nomeDaInstituicao;

    $post_id = wp_insert_post(array(
        'post_author' => $usuario_id,
        'post_type' => $post_type,
        'post_title' => $titulo,
        'post_content' => '', //content é vazio
        'post_status' => 'publish',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
    ));

    /*
    Título: Nome da Instituição
    Texto de mouseover: Nome da Instituição
    Logo:  Logo da Instituição
    Descrição: Descrição da Instituição
    Solução em CTI: Concat de URL dos Serviços + Produtos, serviço da Rede
    Url : Página da Internet da Instituição
    Público Alvo:  Público Alvo da Rede
    Abrangência: Abrangência da Rede
    Representante: Nome, CPF, Email e Telefone da Rede
    Endereço: Endereço da Instituição
    */

    $texto_hover = $nomeDaInstituicao;
    $texto = $descricaoDaInstituicao; //descricao
    $solucao = '<p>URL dos serviços relacionados na rede especificada:</p><p>' . $urlServico . '</p><p>Produtos, serviços e/ou ferramentas de CT&I ofertados relacionados à rede selecionada:</p><p>' . $produtoServicos . '</p>';
    $url = $urlDaInstituicao;

    $publico_alvo = str_replace(";", ", ",  rtrim($publicos, ";"));
    $abrangencia = str_replace(";", ", ", rtrim($abrangencias, ";"));
    $natureza_juridica = str_replace(";", ", ", rtrim($natureza_op, ";"));

    $responsavel = $nomeCompleto;
    $cpf = $cpfRepresentante;
    $email = $emailRepresentante;
    $telefone = $telefoneRepresentante;

    $estado = $estadoDaInstituicao;
    $cidade = $cidadeDaInstituicao;
    $endereco = $enderecoDaInstituicao;
    $complemento = $complementoDaInstituicao;
    $cep = $cepDaInstituicao;

    if ($post_id) {
        add_post_meta($post_id, 'texto_hover', $texto_hover);
        add_post_meta($post_id, 'texto', $texto);
        add_post_meta($post_id, 'solucao', $solucao);
        add_post_meta($post_id, 'url', $url);

        add_post_meta($post_id, 'publico-alvo', $publico_alvo);
        add_post_meta($post_id, 'abrangencia', $abrangencia);
        add_post_meta($post_id, 'natureza_juridica', $natureza_juridica);

        add_post_meta($post_id, 'responsavel', $responsavel);
        add_post_meta($post_id, 'e-mail', $email);
        add_post_meta($post_id, 'telefone', $telefone);
        add_post_meta($post_id, 'cpf', $cpf);

        add_post_meta($post_id, 'estado', $estado);
        add_post_meta($post_id, 'cidade', $cidade);
        add_post_meta($post_id, 'endereco', $endereco);
        add_post_meta($post_id, 'complemento', $complemento);
        add_post_meta($post_id, 'cep', $cep);

        add_post_meta($post_id, 'logomarca', ''); //começar logomarca como empty
        $doc1UnidadeId = attachment_url_to_postid($doc1UnidadeUrl);
        // funcão do ACF para atualizar imagem
        update_field('logomarca', $doc1UnidadeId, $post_id);
    }

    //setar categorias
    if ($classificacoes) {
        $categoria_slug = getCategoryNameRede($post_type);
        $nomesCategoria = explode(";",  rtrim($classificacoes, ";"));

        foreach ($nomesCategoria as $nomeCategoria) {
            $categoriaId = retorna_ou_cria_categoria($categoria_slug, $nomeCategoria);
            // true para dar append nas categorias
            wp_set_post_terms($post_id, $categoriaId, $categoria_slug, true);
        }
    }

    //setar tags
    if ($tags_rede) {
        //false para setar todas as tags como tematres_wp
        wp_set_post_terms($post_id, str_replace(";", ",", $tags_rede), 'tematres_wp', false);
    }


    //-------------------------------------------------------- atualizar status da rede como publicado

    //Adicionando o parecer ao histórico:
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('d/m/Y h:i:sa', time());

    // se já houver alguma coisa, acrescenta um \n
    if (strlen($historicoParecer) > 1)
        $historicoParecer .= "\n\n";

    $parecerAvaliador = "Post da Rede publicado: " . esc_url(get_permalink($post_id)) . " .";
    $historicoParecer .= "Atualização em " . $date . ":\n" . $parecerAvaliador;
    $status = 'publicado';

    update_entrada_rede_homologado($historicoParecer, $parecerAvaliador, $status, $entradaRedeId);

    //-------------------------------------------------------- envia emails
    $nomeRede = relaciona($rede)[2];

    $nomesCategoria = explode(";",  rtrim($classificacoes, ";"));
    $resumo = '';
    $resumo .= '<ul>';
    foreach ($nomesCategoria as $nomeCategoria) {
        $resumo .= "<li>" . $nomeCategoria . ";</li>";
    }
    $resumo .= '</ul>';

    envia_email('publicado', $nomeDaInstituicao, $emailDoCandidato, $nomeRede, '', '', $resumo);
    envia_email_avaliador('publicado', $nomeDaInstituicao);

    // Renderizar aba da rede (preciso recarregar a rede)
    $entryRede = new Caldera_Forms_Entry($form, $entradaRedeId);
    historico_parecer_readonly($entryRede, $rede);
    cadastro_redes_render(relaciona($rede)[0], $entryRede, 'true');
    echo '<input type="hidden" name="entrada_' . $rede . '" value="' . $entradaRedeId . '">';
    botao_publicado_render($entryRede, $entradaRedeId, $rede);

    posts_publicado_render($usuario_id);

    die();
}
add_action('wp_ajax_publica_rede', 'homologado_action_form');


function retorna_ou_cria_categoria($r_tax, $nomeCategoria)
{
    $category = get_term_by('name', $nomeCategoria, $r_tax);

    if ($category->term_id) {
        //echo 'cat existe: ' . $nomeCategoria . '<br>';
        return $category->term_id;
    } else {
        //echo 'criando nova cat: ' . $nomeCategoria . ' na slug ' . $r_tax . '<br>';
        return wp_insert_term($nomeCategoria, $r_tax, array());
    }
}


function homologado_despublica_rede()
{
    $usuario_id = (isset($_POST['usuario_id'])) ? $_POST['usuario_id'] : '';
    $rede = (isset($_POST['rede'])) ? $_POST['rede'] : '';
    $entradaInstituicaoId = (isset($_POST['entradaInstituicaoId'])) ? $_POST['entradaInstituicaoId'] : '';
    $entradaRedeId = (isset($_POST['entradaRedeId'])) ? $_POST['entradaRedeId'] : '';

    // aba instituicao
    $formGeral = Caldera_Forms_Forms::get_form(FORM_ID_GERAL);
    $entryGeral = new Caldera_Forms_Entry($formGeral, $entradaInstituicaoId);
    $nomeDaInstituicao = valida($entryGeral, 'fld_266564');
    $emailDoCandidato = valida($entryGeral, 'fld_7868662');

    // aba da rede
    $form_id = relaciona($rede)[1];
    $form = Caldera_Forms_Forms::get_form($form_id);
    $entryRede = new Caldera_Forms_Entry($form, $entradaRedeId);

    $historicoParecer = valida($entryRede, 'fld_6135036');

    //-------------------------------------------------------- deleta os posts
    $post_type = relaciona($rede)[0];
    deleta_todos_posts($post_type, $usuario_id);

    //-------------------------------------------------------- atualizar status da rede como despublicado

    //Adicionando o parecer ao histórico:
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('d/m/Y h:i:sa', time());

    // se já houver alguma coisa, acrescenta um \n
    if (strlen($historicoParecer) > 1)
        $historicoParecer .= "\n\n";

    $parecerAvaliador = "Post da Rede despublicado.";
    $historicoParecer .= "Atualização em " . $date . ":\n" . $parecerAvaliador;
    $status = 'homologado';

    update_entrada_rede_homologado($historicoParecer, $parecerAvaliador, $status, $entradaRedeId);

    //-------------------------------------------------------- envia emails
    envia_email('despublicado', $nomeDaInstituicao, $emailDoCandidato);
    envia_email_avaliador('despublicado', $nomeDaInstituicao);

    // Renderizar aba da rede (preciso recarregar a rede)
    $entryRede = new Caldera_Forms_Entry($form, $entradaRedeId);
    historico_parecer_readonly($entryRede, $rede);
    cadastro_redes_render(relaciona($rede)[0], $entryRede, 'true');
    echo '<input type="hidden" name="entrada_' . $rede . '" value="' . $entradaRedeId . '">';
    botao_publicado_render($entryRede, $entradaRedeId, $rede);
    posts_publicado_render($usuario_id);

    die();
}
add_action('wp_ajax_despublica_rede', 'homologado_despublica_rede');

function deleta_todos_posts($post_type, $usuario_id)
{
    $args = array(
        'numberposts' => -1,
        'post_type' => $post_type,
        'author' => $usuario_id,
        'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash')
    );

    $user_posts = get_posts($args);

    if (!empty($user_posts)) {

        foreach ($user_posts as $user_post) {
            wp_delete_post($user_post->ID, true);
        }
    }
}

function update_entrada_rede_homologado($historicoParecer, $parecerAvaliador, $status, $entrada_rede)
{
    //Campo: status_*
    Caldera_Forms_Entry_Update::update_field_value('fld_3707629', $entrada_rede, $status);
    //Campo: campo_extra2
    Caldera_Forms_Entry_Update::update_field_value('fld_6135036', $entrada_rede, $historicoParecer);
    //Campo: campo_extra1
    Caldera_Forms_Entry_Update::update_field_value('fld_5960872', $entrada_rede, $parecerAvaliador);
}

function historico_parecer_readonly($entry, $rede = "geral")
{
    if ($rede == "geral") {
        $fld_historico = "fld_4416984";
        $fld_parecer = "fld_8529353";
    } else {
        $fld_historico = "fld_6135036";
        $fld_parecer = "fld_5960872";
    }
?>

    <div id="div_<?php echo $rede ?>">

        <div class="br-textarea mb-3">
            <label for="historicoParecer_<?php echo $rede ?>">Histórico do parecer</label>
            <textarea class="textarea-start-size disabled" id="historicoParecer_<?php echo $rede ?>" name="historicoParecer_<?php echo $rede ?>" placeholder="Não há histórico do parecer" readonly value="<?php echo valida($entry, $fld_historico); ?>"><?php echo valida($entry, $fld_historico); ?></textarea>
        </div>

        <div class="br-textarea mb-3">
            <label for="parecerAvaliador_<?php echo $rede ?>">Último parecer</span></label>
            <textarea class="textarea-start-size disabled" id="parecerAvaliador_<?php echo $rede ?>" name="parecerAvaliador_<?php echo $rede ?>" placeholder="Não há último parecer" maxlength="800" readonly value="<?php echo valida($entry, $fld_parecer); ?>"><?php echo valida($entry, $fld_parecer); ?></textarea>
        </div>
    </div>

<?php
}
