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

<?php
}
