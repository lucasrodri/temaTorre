<?php

// Deleta todas as entradas de um form específico
function deletar_entradas_form($form_id)
{
    $data = Caldera_Forms_Admin::get_entries($form_id, 1, 9999999);
    $todasEntradas = $data['entries'];
    foreach ($todasEntradas as $umaEntrada) {
        $entrada = $umaEntrada['_entry_id'];
        Caldera_Forms_Entry_Bulk::delete_entries(array($entrada));
    }

    wp_redirect(home_url('/cadastro-admin'));
}
//add_action('admin_post_nopriv_deletar_entradas_form', 'deletar_entradas_form');
//add_action('admin_post_deletar_entradas_forms', 'deletar_entradas_form');

// Deleta todas as entradas de todos os forms
function deletar_todas_entradas()
{
    $form_ids = array(FORM_ID_GERAL, FORM_ID_SUPORTE, FORM_ID_FORMACAO, FORM_ID_PESQUISA, FORM_ID_INOVACAO, FORM_ID_TECNOLOGIA);

    foreach ($form_ids as $form_id) {
        deletar_entradas_form($form_id);
    }
}
add_action('admin_post_nopriv_deletar_todas_entradas', 'deletar_todas_entradas');
add_action('admin_post_deletar_todas_entradas', 'deletar_todas_entradas');

/*
* Shortcode para renderizar o formulário do avaliador
*/
add_shortcode('shortcode_admin_view', 'admin_view');

function admin_view()
{
    require_once(CFCORE_PATH . 'classes/admin.php');

?>
    <form class="card" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">

        <div class="wizard-panel-content">
            <div class="h3">Admin</div>
            <div class="text my-text-wizard" tabindex="0">
                <p>Início de página do admin.</p>
            </div>

            <h4>Deletar entradas</h4>
            <p>Clique aqui para apagar todas as entradas de todos os forms caldera</p>

            <div class="col-md-6 align-button-left">
                <input type="submit" class="br-button primary" value="Deletar" name="enviar">
                <input type="hidden" name="action" value="deletar_todas_entradas">
            </div>
        </div>
    </form>
    <br>
    <form class="card" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
        <div class="wizard-panel-content">
            <h4>Criar entradas vazias</h4>
            <p>Clique aqui para criar as entradas de todos os forms caldera</p>

            <div class="col-md-6 align-button-left">
                <input type="submit" class="br-button primary" value="Criar" name="enviar">
                <input type="hidden" name="action" value="criar_forms_vazios">
            </div>
        </div>
    </form>

<?php
}

add_shortcode('shortcode_criar_forms_vazios', 'criar_forms_vazios');
function criar_forms_vazios()
{
    require_once(CFCORE_PATH . 'classes/admin.php');

    $form_ids = array(FORM_ID_SUPORTE, FORM_ID_FORMACAO, FORM_ID_PESQUISA, FORM_ID_INOVACAO, FORM_ID_TECNOLOGIA);

    // vou checar todos os existentes a partir do form geral
    $data = Caldera_Forms_Admin::get_entries(FORM_ID_GERAL, 1, 9999999);
    $ativos = $data['active'];

    if ($ativos > 0) {
        $todasEntradasGeral = $data['entries'];

        foreach ($todasEntradasGeral as $umaEntradaGeral) {
            $userIdGeral = $umaEntradaGeral['user']['ID'];
            //echo '<br><br>Estou analisando o ' . $userIdGeral . '<br>';

            foreach ($form_ids as $form_id) {
                $dataForm = Caldera_Forms_Admin::get_entries($form_id, 1, 9999999);
                $ativosForm = $dataForm['active'];

                if ($ativosForm > 0) {
                    $todasEntradasForm = $dataForm['entries'];
                    $flag = false;

                    //echo 'Estou analisando o ' . $form_id . 'do cara ' . $userIdGeral . '<br>';

                    foreach ($todasEntradasForm as $umaEntradaForm) {
                        $userIdForm = $umaEntradaForm['user']['ID'];

                        if ($userIdGeral == $userIdForm) {
                            $entrada = $umaEntradaForm['_entry_id'];
                            //echo 'O' . $userIdGeral . ' possui entrada no ' . $form_id . ' de numero ' . $entrada . '<br>';

                            $form1 = Caldera_Forms_Forms::get_form($form_id);
                            $entry = new Caldera_Forms_Entry($form1, $entrada);

                            //update campo4  para true
                            if (valida($entry, 'fld_605717') == "") {
                                Caldera_Forms_Entry_Update::update_field_value('fld_4663810', $entrada, 'false');
                            } else {
                                Caldera_Forms_Entry_Update::update_field_value('fld_4663810', $entrada, 'true');
                            }

                            $flag = true;
                            break;
                        }
                    }

                    // se ele não tive entrada nesse form eu vou criar uma
                    if ($flag == false) {
                        //echo 'O' . $userIdGeral . ' NAO possui entrada no ' . $form_id . '<br>';

                        //criar o form e inserir como false

                        $dados_redes = array();
                        $dados_redes["urlServico"] = "";
                        $dados_redes["produtoServicos"] = "";
                        $dados_redes["classificacoes"] = "";
                        $dados_redes["outroClassificacao"] = "";
                        $dados_redes["publicos"] = "";
                        $dados_redes["abrangencias"] = "";
                        $dados_redes["nomeCompleto"] = "";
                        $dados_redes["cpfRepresentante"] = "";
                        $dados_redes["emailRepresentante"] = "";
                        $dados_redes["telefoneRepresentante"] = "";

                        insert_entrada_form_especifico($form_id, $dados_redes, $userIdGeral, false);
                    }
                }
            }
        }
    }

    wp_redirect(home_url('/cadastro-admin'));
}
add_action('admin_post_nopriv_criar_forms_vazios', 'criar_forms_vazios');
add_action('admin_post_criar_forms_vazios', 'criar_forms_vazios');
