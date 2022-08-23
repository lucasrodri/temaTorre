<?php
/*
* Shortcode para renderizar o formulário do gerente
*/
add_shortcode('shortcode_gerente_view', 'gerente_view');

function gerente_view()
{
    require_once(CFCORE_PATH . 'classes/admin.php');

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
            $entradas[$user_id] = array();
            $entradas[$user_id][] = new Caldera_Forms_Entry($form, $entrada);
            $entradas[$user_id][] = $umaEntrada['_date'];
        }
    }
    $todas_redes = "check_suporte;check_formacao;check_pesquisa;check_inovacao;check_tecnologia;";
    $arrayRedes = explode(";", $todas_redes);
?>
    <?php if (!$entradas) : ?>
        <div class="mb-5" id="lista-entradas-div">
            <p>Não há candidaturas para visualização.</p>
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
                        <tr onclick="carrega_avaliador('<?php echo $key; ?>','<?php echo $redes; ?>', '<?php echo valida($entrada[0], 'fld_266564'); ?>','true');">
                            <td data-th="Data"><?php echo date_i18n('M d, Y', strtotime($entrada[1])); ?></td>
                            <td data-th="Nome"><?php echo valida($entrada[0], 'fld_266564'); ?></td>
                            <td data-th="Status"><?php render_status(valida($entrada[0], 'fld_9748069')); ?></td>
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

                <div class="col-md-12 text-center">

                </div>

            </div>
        </div>
    </form>

    <div class="row mt-5">
        <div id="entrada-voltar-btn" class="col-md-12 text-center" style="display: none;">
            <a href="<?php echo home_url(); ?>/visualizacao/" class="br-button secondary">Voltar para lista de Instituições</a>
            <!-- <button class="br-button secondary" type="button" onclick="voltarListaEntradas();">Voltar para lista de Instituições
            </button> -->
        </div>
    </div>

<?php
}


function gerente_action_form()
{
    $todas_redes = "check_suporte;check_formacao;check_pesquisa;check_inovacao;check_tecnologia;";
    $arrayRedes = explode(";", $todas_redes);

    $historicoParecer_rede = array();
    $parecerAvaliador_rede = array();
    $situacaoAvaliador_rede = array();
    $tags_rede = array();
    $entrada_rede = array();

    //Campos do Geral
    if (isset($_POST['historicoParecer_geral'])) $historicoParecer_geral = (trim($_POST['historicoParecer_geral']));
    else $historicoParecer_geral = "";
    if (isset($_POST['parecerAvaliador_geral'])) $parecerAvaliador_geral = (trim($_POST['parecerAvaliador_geral']));
    else $parecerAvaliador_geral = "";
    if (isset($_POST['situacaoAvaliador_geral'])) $situacaoAvaliador_geral = (trim($_POST['situacaoAvaliador_geral']));
    else $situacaoAvaliador_geral = "";

    //entry_id da instituicao
    if (isset($_POST['entrada_geral'])) $entrada_geral = ($_POST['entrada_geral']);
    else $entrada_geral = "";

    //Adicionando o parecer ao histórico:
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('d/m/Y h:i:sa', time());

    // se já houver alguma coisa, acrescenta um \n
    if (strlen($historicoParecer_geral) > 1)
        $historicoParecer_geral .= "\n\n";

    $historicoParecer_geral .= "Avaliação em " . $date . ":\n" . $parecerAvaliador_geral;

    //Campos das redes
    foreach ($arrayRedes as $rede) {
        if (isset($_POST['historicoParecer_' . $rede])) $historicoParecer_rede[$rede] = (trim($_POST['historicoParecer_' . $rede]));
        else $historicoParecer_rede[$rede] = "";
        if (isset($_POST['parecerAvaliador_' . $rede])) $parecerAvaliador_rede[$rede] = (trim($_POST['parecerAvaliador_' . $rede]));
        else $parecerAvaliador_rede[$rede] = "";
        if (isset($_POST['situacaoAvaliador_' . $rede])) $situacaoAvaliador_rede[$rede] = (trim($_POST['situacaoAvaliador_' . $rede]));
        else $situacaoAvaliador_rede[$rede] = "";

        //Pegando as Tags
        if (isset($_POST['escolha_tags_' . $rede])) {
            $optionArray = $_POST['escolha_tags_' . $rede];
            $tags_rede[$rede] = "";
            for ($i = 0; $i < count($optionArray); $i++) {
                $tags_rede[$rede] .= $optionArray[$i] . ";";
            }
        } else {
            $tags_rede[$rede] = "";
        }

        //entry_id de cada rede
        if (isset($_POST['entrada_' . $rede])) $entrada_rede[$rede] = ($_POST['entrada_' . $rede]);
        else $entrada_rede[$rede] = "";

        // se já houver alguma coisa, acrescenta um \n
        if (strlen($historicoParecer_rede[$rede]) > 1)
            $historicoParecer_rede[$rede] .= "\n\n";

        //Adicionando o parecer ao histórico:
        $historicoParecer_rede[$rede] .= "Avaliação em " . $date . ":\n" . $parecerAvaliador_rede[$rede];
    }

    //casos de status: [avaliacao, pendente, homologado, publicado]

    //----------------------------submit
    if (isset($_POST["enviar"])) {
        //update
        update_entrada_avaliador($historicoParecer_geral, $parecerAvaliador_geral, $situacaoAvaliador_geral, $entrada_geral, $historicoParecer_rede, $parecerAvaliador_rede, $situacaoAvaliador_rede, $tags_rede, $entrada_rede);

        //enviar email: validar situação geral
        $form = Caldera_Forms_Forms::get_form(FORM_ID_GERAL);
        $entry = new Caldera_Forms_Entry($form, $entrada_geral);

        $statusGeral = valida($entry, 'fld_9748069');
        $nomeDaInstituicao  = valida($entry, 'fld_266564');
        $emailDoCandidato  = valida($entry, 'fld_7868662');

        // if ($statusGeral == 'pendente') {
        //     envia_email('pendente', $nomeDaInstituicao, $emailDoCandidato, $parecerAvaliador_geral);
        // } else if ($statusGeral == 'homologado') {
        //     envia_email('homologado', $nomeDaInstituicao, $emailDoCandidato, $parecerAvaliador_geral);
        // }

        // redirecionar para a página de avaliacao
        wp_redirect(esc_url(home_url('/avaliador')));
        exit;
    }
    /*
    //caso pendente
    o form geral
    os forms das redes
    marcado como ajustes 
    status é pendente

    //caso homologado
    status => homologado
    assinar o termo

    //caso publicado <---- como fazer os posts
    // vamos criar uma nova função de visualização function avaliador_view_publico() -> form apenas para os homologados
    */
}
add_action('admin_post_nopriv_avaliador_action', 'avaliador_action_form');
add_action('admin_post_avaliador_action', 'avaliador_action_form');
