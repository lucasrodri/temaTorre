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

    //$date = date('M d, Y', strtotime($entradas["date"]));
    //$redes = valida($entradas[FORM_ID_GERAL], 'fld_4891375');
?>

    <div class="br-table mb-3">
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
                <tr>
                    <td data-th="Data">sds</td>
                    <td data-th="Nome">dsds</td>
                    <td data-th="Status">sdds</td>
                </tr>
                <tr>
                    <td data-th="Data">sds</td>
                    <td data-th="Nome">dsds</td>
                    <td data-th="Status">sdds</td>
                </tr>
                <tr>
                    <td data-th="Data">sds</td>
                    <td data-th="Nome">dsds</td>
                    <td data-th="Status">sdds</td>
                </tr>
            </tbody>
        </table>
        <!-- Rodapé -->
    </div>



    <div id="edit-form-div-button" class="row mt-5 mb-5">
        <div class="col-md-12 mr-4">
            <!-- O botão tera um onclick que removerá a div 'edit-form-div-button' e aparecerá a div 'edit-form-div' -->
            <button class="br-button success mr-sm-3" type="button" onclick="carrega_avaliador()">Teste Ajax
            </button>
        </div>
    </div>
    <div id="edit-form-div" class="br-tab mt-5" style="">
        <nav class="tab-nav font-tab-torre">
            <ul>
                <li class="tab-item active">
                    <button type="button" data-panel="panel-1"><span class="name">Instituição</span></button>
                </li>
                <?php for ($i = 2; $i < 6; $i++) : ?>
                    <li class="tab-item">
                        <button type="button" data-panel="panel-<?php echo $i; ?>"><span class="name">TESTE</span></button>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <div class="tab-content mt-4">
            <div class="tab-panel active" id="panel-1">
                <div id="tab_instituicao"></div>
            </div>
            <?php for ($i = 2; $i < 6; $i++) : ?>
                <div class="tab-panel" id="panel-<?php echo $i; ?>">
                    <div id="tab_redes_<?php echo $i; ?>"></div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
<?php
}



function ajaxCarregaAvaliador()
{
    // candidato_view();

    die();
}
add_action('wp_ajax_carrega_avaliador', 'ajaxCarregaAvaliador');
