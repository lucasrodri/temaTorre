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
