<?php
/*
* Shortcode para renderizar o formulário do avaliador
*/
add_shortcode('shortcode_avaliador_view', 'avaliador_view');

function avaliador_view()
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
            $entradas[$user_id] = array();
            $entradas[$user_id][] = new Caldera_Forms_Entry($form, $entrada);
            $entradas[$user_id][] = $umaEntrada['_date'];
        }
    }
    $todas_redes = "check_suporte;check_formacao;check_pesquisa;check_inovacao;check_tecnologia;";
    $arrayRedes = explode(";", $todas_redes);
?>
    <?php if (!$entradas) : ?>
        <div class="br-table mb-5" id="lista-entradas-div">
            <p>Não há cadastros para serem avaliados.</p>
        </div>
    <?php else: ?>
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
                        <tr onclick="carrega_avaliador('<?php echo $key; ?>','<?php echo $redes; ?>', '<?php echo valida($entrada[0], 'fld_266564'); ?>');">
                            <td data-th="Data"><?php echo date('M d, Y', strtotime($entrada[1])); ?></td>
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

                            <?php campos_avaliador_redes(); ?>

                        </div>
                        <?php for ($i = 2; $i < count($arrayRedes) + 1; $i++) : ?>
                            <div class="tab-panel" id="panel-<?php echo $i; ?>">
                                <div id="tab_redes_<?php echo $i; ?>"></div>

                                <?php campos_avaliador_redes($arrayRedes[$i - 2]); ?>

                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="col-md-12 text-center">
                    <div id="resumo-avaliador" style="display:none;"></div>

                    <div class="div-botao-avaliador">
                        <input id="action-avaliador-input" type="submit" class="br-button primary" value="Finalizar Avaliação desta Instituição" name="enviar" disabled>
                        <span id="span-avaliador-input" class="feedback warning" role="alert"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i>Atenção: existem campos não preenchidos!</span>
                    </div>
                    <input id="hidden-avaliador-input" type="hidden" name="action" value="avaliador_action">
                </div>

            </div>
        </div>
    </form>

    <div class="row mt-5">
        <div id="entrada-voltar-btn" class="col-md-12 text-center" style="display: none;">
            <a href="/avaliador/" class="br-button secondary">Voltar para lista de Instituições</a>
            <!-- <button class="br-button secondary" type="button" onclick="voltarListaEntradas();">Voltar para lista de Instituições
            </button> -->
        </div>
    </div>

<?php
}


function ajaxCarregaInstituicao()
{
    $usuario_id = (isset($_POST['usuario_id'])) ? $_POST['usuario_id'] : '';
    require_once(CFCORE_PATH . 'classes/admin.php');
    $entradas = array();


    $data = Caldera_Forms_Admin::get_entries(FORM_ID_GERAL, 1, 9999999);
    $ativos = $data['active'];

    if ($ativos > 0) {
        $todasEntradas = $data['entries'];

        foreach ($todasEntradas as $umaEntrada) {
            $user_id = $umaEntrada['user']['ID'];

            if ($user_id == $usuario_id) {

                $entrada = $umaEntrada['_entry_id'];
                $form = Caldera_Forms_Forms::get_form($FORM_ID_GERAL);
                $entradas[FORM_ID_GERAL] = new Caldera_Forms_Entry($form, $entrada);
                $entradas["date"] = $umaEntrada['_date'];
                break;
            }
        }
    }
    //$date = date('M d, Y', strtotime($entradas["date"]));

    // função alterada para não retornar um form
    render_geral_data($entradas[FORM_ID_GERAL]);
    echo '<input type="hidden" name="entrada_geral" value="'.$entrada.'">';
    die();
}
add_action('wp_ajax_carrega_instituicao', 'ajaxCarregaInstituicao');

function ajaxCarregaRede()
{
    $usuario_id = (isset($_POST['usuario_id'])) ? $_POST['usuario_id'] : '';
    $rede = (isset($_POST['rede'])) ? $_POST['rede'] : '';
    require_once(CFCORE_PATH . 'classes/admin.php');
    $entradas = array();

    $form_id = relaciona($rede)[1];

    $data = Caldera_Forms_Admin::get_entries($form_id, 1, 9999999);
    $ativos = $data['active'];

    if ($ativos > 0) {
        $todasEntradas = $data['entries'];

        foreach ($todasEntradas as $umaEntrada) {
            $user_id = $umaEntrada['user']['ID'];

            if ($user_id == $usuario_id) {

                $entrada = $umaEntrada['_entry_id'];
                $form = Caldera_Forms_Forms::get_form($form_id);
                $entradas[$form_id] = new Caldera_Forms_Entry($form, $entrada);
                $entradas["date"] = $umaEntrada['_date'];
                break;
            }
        }
    }
    //$date = date('M d, Y', strtotime($entradas["date"]));

    cadastro_redes_render(relaciona($rede)[0], $entradas[relaciona($rede)[1]]);
    echo '<input type="hidden" name="entrada_'.$rede.'" value="'.$entrada.'">';
    die();
}
add_action('wp_ajax_carrega_rede', 'ajaxCarregaRede');

function campos_avaliador_redes($rede = "geral")
{
    if ($rede == "geral") {
        echo "<h3>Avaliação da Instituição</h3>";
        $placeholder = "Escreva o parecer sobre os dados da Instituição";
        $required = 'required';
    } else {
        echo "<h3>Avaliação da Rede de " . relaciona($rede)[2] . "</h3>";
        $placeholder = "Escreva o parecer sobre os dados da Rede de" . relaciona($rede)[2];
        $required = '';
    }
?>
    <div id="div_<?php echo $rede ?>">

        <div class="br-textarea mb-3">
            <label for="historicoParecer_<?php echo $rede ?>">Histórico do parecer<span class="field_required" style="color:#ee0000;">*</span></label>
            <textarea class="textarea-start-size" id="historicoParecer_<?php echo $rede ?>" name="historicoParecer_<?php echo $rede ?>" placeholder="Não há histórico do parecer" disabled></textarea>
        </div>

        <div class="br-textarea mb-3">
            <label for="parecerAvaliador_<?php echo $rede ?>">Insira o parecer<span class="field_required" style="color:#ee0000;">*</span></label>
            <textarea class="textarea-start-size" id="parecerAvaliador_<?php echo $rede ?>" name="parecerAvaliador_<?php echo $rede ?>" placeholder="<?php echo $placeholder; ?>" maxlength="800" onchange="changeError(name)" onfocusout="validacaoAvaliador()" <?php echo $required ?>></textarea>
            <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
        </div>

        <?php
        if ($rede != "geral") {
            echo '<div class="mb-3">';
            echo '<p class="label mb-3">Insira as Tags para o post<span class="field_required" style="color:#ee0000;">*</span></p>';
            echo do_shortcode('[tmwpi_shortcode_campo_seletor_tags div_id="taxonomy-' . $rede . '" select_id="escolha_tags_' . $rede . '"]');
            echo '</div>';
        }
        ?>

        <div class="mb-3 radio-avaliador">
            <p class="label mb-3">Escolha a situação<span class="field_required" style="color:#ee0000;">*</span></p>
            <div class="br-radio">
                <input id="avaliador_<?php echo $rede ?>_op_1" type="radio" name="situacaoAvaliador_<?php echo $rede ?>" class="situacaoAvaliador_<?php echo $rede ?>" value="pendente" onchange="changeErrorRadio(name)" onfocusout="validacaoAvaliador()" />
                <label for="avaliador_<?php echo $rede ?>_op_1">Ajustes necessários</label>
            </div>
            <div class="br-radio">
                <input id="avaliador_<?php echo $rede ?>_op_2" type="radio" name="situacaoAvaliador_<?php echo $rede ?>" class="situacaoAvaliador_<?php echo $rede ?>" value="homologado" onchange="changeErrorRadio(name)" onfocusout="validacaoAvaliador()" />
                <label for="avaliador_<?php echo $rede ?>_op_2">Homologado</label>
                <br>
            </div>
        </div>
    </div>

    <!-- TODO: mostrar um resumo das avaliações e pareceres escritos por rede com JS -->
<?php
}


function avaliador_action_form()
{
    $todas_redes = "check_suporte;check_formacao;check_pesquisa;check_inovacao;check_tecnologia;";
    $arrayRedes = explode(";", $todas_redes);
    $historicoParecer_rede = array();
    $parecerAvaliador_rede = array();
    $situacaoAvaliador_rede = array();
    $entrada_rede = array();
    //Campos do Geral
    if (isset($_POST['historicoParecer_geral'])) $historicoParecer_geral = ($_POST['historicoParecer_geral']);
    else $historicoParecer_geral = "";
    if (isset($_POST['parecerAvaliador_geral'])) $parecerAvaliador_geral = ($_POST['parecerAvaliador_geral']);
    else $parecerAvaliador_geral = "";
    if (isset($_POST['situacaoAvaliador_geral'])) $situacaoAvaliador_geral = ($_POST['situacaoAvaliador_geral']);
    else $situacaoAvaliador_geral = "";
    //entry_id da instituicao
    if (isset($_POST['entrada_geral'])) $entrada_geral = ($_POST['entrada_geral']);
    else $entrada_geral = "";
    //Campos das redes
    foreach ($arrayRedes as $rede) {
        if (isset($_POST['historicoParecer_'.$rede])) $historicoParecer_rede[$rede] = ($_POST['historicoParecer_'.$rede]);
        else $historicoParecer_rede[$rede] = "";
        if (isset($_POST['parecerAvaliador_'.$rede])) $parecerAvaliador_rede[$rede] = ($_POST['parecerAvaliador_'.$rede]);
        else $parecerAvaliador_rede[$rede] = "";
        if (isset($_POST['situacaoAvaliador_'.$rede])) $situacaoAvaliador_rede[$rede] = ($_POST['situacaoAvaliador_'.$rede]);
        else $situacaoAvaliador_rede[$rede] = "";   
        //entry_id de cada rede
        if (isset($_POST['entrada_'.$rede])) $entrada_rede[$rede] = ($_POST['entrada_'.$rede]);
        else $entrada_rede[$rede] = "";     
    }
    //Adicionando o parecer ao histórico:
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('d/m/Y h:i:sa', time());
    $historicoParecer_geral = $historicoParecer_geral."Avaliação em ".$date.":<br>".$parecerAvaliador_geral.":<br><br>";
    
    //casos de status: [avaliacao, pendente, homologado, publicado]

    //----------------------------submit
    if (isset($_POST["enviar"])) {
        //update
        update_entrada_avaliador($historicoParecer_geral, $parecerAvaliador_geral, $situacaoAvaliador_geral, $entrada_geral, $historicoParecer_rede, $parecerAvaliador_rede, $situacaoAvaliador_rede, $entrada_rede);
        //enviar email


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

function update_entrada_avaliador($historicoParecer_geral, $parecerAvaliador_geral, $situacaoAvaliador_geral, $entrada_geral, $historicoParecer_rede, $parecerAvaliador_rede, $situacaoAvaliador_rede, $entrada_rede) {
    
    //Form Geral
    //Campo: historico_parecer_instituicao
    Caldera_Forms_Entry_Update::update_field_value('fld_4416984', $entrada_geral, $historicoParecer_geral); 
    //Campo: parecer_instituicao
    Caldera_Forms_Entry_Update::update_field_value('fld_8529353', $entrada_geral, $parecerAvaliador_geral); 
    //Campo: status_instituicao
    Caldera_Forms_Entry_Update::update_field_value('fld_4899711', $entrada_geral, $situacaoAvaliador_geral); 

    //Form Redes
    $todas_redes = "check_suporte;check_formacao;check_pesquisa;check_inovacao;check_tecnologia;";
    $arrayRedes = explode(";", $todas_redes);
    foreach ($arrayRedes as $rede) {
        //Campo: campo_extra2
        Caldera_Forms_Entry_Update::update_field_value('fld_6135036', $entrada_rede[$rede], $historicoParecer_rede[$rede]); 
        //Campo: campo_extra1
        Caldera_Forms_Entry_Update::update_field_value('fld_5960872', $entrada_rede[$rede], $parecerAvaliador_rede[$rede]); 
        //Campo: status_*
        Caldera_Forms_Entry_Update::update_field_value('fld_3707629', $entrada_rede[$rede], $situacaoAvaliador_rede[$rede]);
    }

    //Situacao Geral:
    //casos de status: [avaliacao, pendente, homologado, publicado]
    
    if ($situacaoAvaliador_geral == "pendente") {
        $situacaoGeral = "pendente";
    }
    foreach ($arrayRedes as $rede) {
        if ($situacaoAvaliador_rede[$rede] == "pendente") {
            $situacaoGeral = "pendente";
        }
    }
    //Campo: status_geral_instituicao
    Caldera_Forms_Entry_Update::update_field_value('fld_9748069', $entrada_geral, $situacaoGeral); 

}

function avaliador_view_homologado()
{

    //cópia do avaliador_view() mas só mostra homologados
    return;
}
