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
            $form = Caldera_Forms_Forms::get_form($form_id);
            $entradas[$user_id] = array();
            $entradas[$user_id][] = new Caldera_Forms_Entry($form, $entrada);
            $entradas[$user_id][] = $umaEntrada['_date'];
        }
    }
    $todas_redes = "check_suporte;check_formacao;check_pesquisa;check_inovacao;check_tecnologia;";
    $arrayRedes = explode(";", $todas_redes);
?>
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

                                <?php campos_avaliador_redes($arrayRedes[$i - 2], $i); ?>

                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="col-md-12 text-center">
                    <div id="resumo-avaliador" style="display:none;"></div>
                    <input id="action-avaliador-input" type="submit" class="br-button primary" value="Finalizar Avaliação desta Instituição" name="enviar">
                    <input type="hidden" name="avalia_usuario" value=<?php echo $user_id ?>>
                    <input id="hidden-avaliador-input" type="hidden" name="action" value="atualiza_avaliador">
                </div>

            </div>
        </div>
    </form>

    <div class="row mt-5">
        <div id="entrada-voltar-btn" class="col-md-12 text-center" style="display: none;">
            <button class="br-button secondary" type="button" onclick="voltarListaEntradas();">Voltar para lista de Instituições
            </button>
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
                $form = Caldera_Forms_Forms::get_form($form_id);
                $entradas[FORM_ID_GERAL] = new Caldera_Forms_Entry($form, $entrada);
                $entradas["date"] = $umaEntrada['_date'];
                break;
            }
        }
    }
    //$date = date('M d, Y', strtotime($entradas["date"]));

    // função alterada para não retornar um form
    render_geral_data($entradas[FORM_ID_GERAL]);
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
    die();
}
add_action('wp_ajax_carrega_rede', 'ajaxCarregaRede');

function campos_avaliador_redes($rede = "geral")
{
    if ($rede == "geral") {
        echo "<h3>Avaliação da Instituição</h3>";
        $placeholder = "Escreva o parecer sobre os dados da Instituição";
    } else {
        echo "<h3>Avaliação da Rede de " . relaciona($rede)[2] . "</h3>";
        $placeholder = "Escreva o parecer sobre os dados da Rede de" . relaciona($rede)[2];
    }
?>
    <div class="br-textarea mb-3">
        <label for="historicoParecer">Histórico do parecer<span class="field_required" style="color:#ee0000;">*</span></label>
        <textarea class="textarea-start-size" id="historicoParecer_<?php echo $rede ?>" name="historicoParecer_<?php echo $rede ?>" placeholder="Não há histórico do parecer" disabled></textarea>
    </div>

    <div class="br-textarea mb-3">
        <label for="parecerAvaliador">Insira o parecer<span class="field_required" style="color:#ee0000;">*</span></label>
        <textarea class="textarea-start-size" id="parecerAvaliador_<?php echo $rede ?>" name="parecerAvaliador_<?php echo $rede ?>" placeholder="<?php echo $placeholder; ?>" maxlength="800" onchange="changeError(name)" onfocus="mostrarResumo()" required></textarea>
    </div>

    <!-- <div class="br-switch medium mt-2 mb-5">
        <input id="switch-label-02" name="parecerAvaliadorCheck_<?php //echo $rede ?>" type="checkbox" />
        <label for="switch-label-02">Insira a situação<span class="field_required" style="color:#ee0000;">*</span></label>
        <div class="switch-data" data-enabled="Homologado" data-disabled="Pendente"></div>
    </div> -->

    <div class="mb-3 radio-avaliador">
        <p class="label mb-3">Escolha a situação<span class="field_required" style="color:#ee0000;">*</span></p>
        <div class="br-radio">
            <input id="avaliador_<?php echo $rede ?>_op_1" type="radio" name="situacaoAvaliador_<?php echo $rede ?>" class="situacaoAvaliador_<?php echo $rede ?>" value="pendente" onchange="changeErrorRadio(name)" onfocus="mostrarResumo()" />
            <label for="avaliador_<?php echo $rede ?>_op_1">Ajustes necessários</label>
        </div>
        <div class="br-radio">
            <input id="avaliador_<?php echo $rede ?>_op_2" type="radio" name="situacaoAvaliador_<?php echo $rede ?>" class="situacaoAvaliador_<?php echo $rede ?>" value="homologado" onchange="changeErrorRadio(name)" onfocus="mostrarResumo()" />
            <label for="avaliador_<?php echo $rede ?>_op_2">Homologado</label>
        </div>
    </div>

    <!-- TODO: mostrar um resumo das avaliações e pareceres escritos por rede com JS -->
<?php
}
