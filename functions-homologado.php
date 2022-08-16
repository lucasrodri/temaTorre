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
                            <td data-th="Data"><?php echo date('M d, Y', strtotime($entrada[1])); ?></td>
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
            <a href="/homologados/" class="br-button secondary">Voltar para lista de Instituições</a>
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
    $form = Caldera_Forms_Forms::get_form(FORM_ID_GERAL);
    $entryGeral = new Caldera_Forms_Entry($form, $entradaInstituicaoId);

    $nomeDaInstituicao = valida($entryGeral, 'fld_266564');
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
    //$outroClassificacao = valida($entryRede, 'fld_6678080'); //---- PERGUNTA: vamos incluir isso em algum lugar?
    $tags_rede = valida($entryRede, 'fld_7938112');

    //-------------------------------------------------------- criar o post
    //https://wordpress.stackexchange.com/questions/106973/wp-insert-post-or-similar-for-custom-post-type
    //https://wordpress.stackexchange.com/questions/244221/check-if-author-or-current-user-has-posts-published

    $post_type = relaciona($rede)[0];

    $posts = count_user_posts($usuario_id, $post_type); //count user's posts
    if ($posts > 0) {
        //user has posts

        $args = array(
            'numberposts' => -1,
            'post_type' => $post_type,
            'author' => $usuario_id
        );
        // get all posts by this user: posts, pages, attachments, etc..
        $user_posts = get_posts($args);

        if (empty($user_posts)) return;

        // delete all the user posts
        foreach ($user_posts as $user_post) {
            echo 'estou deletand o post ' . $user_post->ID . '<br>';
            wp_delete_post($user_post->ID, true);
        }
    }

    $titulo = $nomeDaInstituicao;
    $conteudo = ''; //content é vazio

    $post_id = wp_insert_post(array(
        'post_author' => $usuario_id,
        'post_type' => $post_type,
        'post_title' => $titulo,
        'post_content' => $conteudo,
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
    $solucao = 'URL dos serviços relacionados na rede especificada:\n' . $urlServico . '\nProdutos, serviços e/ou ferramentas de CT&I ofertados relacionados à rede selecionada:' . $produtoServicos;
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

    //setar tags
    if ($classificacoes) {
        $categoria_slug = getCategoryNameRede($post_type);
        $nomesCategoria = explode(";",  rtrim($classificacoes, ";"));

        foreach ($nomesCategoria as $nomeCategoria) {
            
            $categoriaId = retorna_ou_cria_categoria($categoria_slug, $nomeCategoria);
            
            //---- PERGUNTA:vamos fazer append ou criar novos posts???
            wp_set_post_terms($post_id, $categoriaId, $categoria_slug, true);
        }
    }


    //setar tags
    if ($tags_rede) {
        wp_set_post_terms($post_id, str_replace(";", ",", $tags_rede), 'tematres_wp', false);
    }


    //-------------------------------------------------------- atualizar status da rede como publicado

    echo 'post publicado' . $post_id . '<br>';
    echo 'Veja o novo post em: <a href="' . esc_url(get_permalink($post_id)) . '"> Link </a>';

    // renderiza novamente o botão
    botao_publicado_render($entryRede, $entradaRedeId, $rede);

    die();
}
add_action('wp_ajax_publica_rede', 'homologado_action_form');


function retorna_ou_cria_categoria($r_tax, $nomeCategoria)
{
    $category = get_term_by('name', $nomeCategoria, $r_tax);

    //var_dump($category);

    if ($category->term_id) {
        //checa se categoria já existe
        echo 'cat existe: ' . $nomeCategoria . '<br>';
        return $category->term_id;
    } else {
        //senão a cria
        echo 'criando nova cat: ' . $nomeCategoria . ' na slug ' . $r_tax . '<br>';
        return wp_insert_term($nomeCategoria, $r_tax, array());
    }
}
