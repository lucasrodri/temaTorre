<?php

/**
 * Tratar os redirecionamento
 * Não logado -> Redireciona pra index (com aviso de email de acesso)
 * Logado mas já preencheu form -> Redireciona para index
 * Página de acompanhamento: /acompanhamento
 * 
 * Função que checa se o shortcode está na página para adicionar o hook de redirecionamento antes da página carregar
 * 
 * add_shortcode('shortcode_form_usuario', 'cadastro_form_usuario');
 * current user is candidato -- não pode checar se está logado
 *  * 
 * add_shortcode('shortcode_avaliador_view', 'avaliador_view');
 * current user is avaliador + checar se está logado
 * 
 * add_shortcode('shortcode_admin_view', 'admin_view'); ???
 * current user is admin  + checar se está logado
 * 
 * add_shortcode('shortcode_candidato_view', 'candidato_view');
 * current user is candidato  + checar se está logado
 * 
 */

function usuario_tem_role($user, $role)
{
    /*
	* Função que retorna true caso o usuário tenha o papel (role) informado
	*/

    return in_array($role, (array) $user->roles);
}

//https://wordpress.stackexchange.com/questions/101498/redirect-function-inside-a-shortcode
function pre_process_shortcode()
{
    if (!is_singular()) return;

    global $post;

    if (!empty($post->post_content)) {
        $regex = get_shortcode_regex();
        preg_match_all('/' . $regex . '/', $post->post_content, $matches);
        if (!empty($matches[2])) { //checa se tem shortcode na página

            $current_user = wp_get_current_user();

            if (in_array('shortcode_form_usuario', $matches[2])) {

                // se o usuário logado já for candidato, deve ser redirecionado para home
                if (usuario_tem_role($current_user, 'candidato') && is_user_logged_in()) {
                    wp_redirect(home_url());
                }
            } else if (in_array('shortcode_admin_view', $matches[2])) {

                // se o usuário logado não for admin, deve ser redirecionado para home
                if (!is_user_logged_in()) {
                    wp_redirect(wp_login_url());
                } else if (!current_user_can('administrator')) {
                    wp_redirect(home_url());
                }
            } else if (in_array('shortcode_avaliador_view', $matches[2])) {

                // se o usuário logado não for avaliador, deve ser redirecionado para home
                if (!is_user_logged_in()) {
                    wp_redirect(wp_login_url() . "?redirect_to=" . home_url() . "/avaliador");
                } else if (!usuario_tem_role($current_user, 'avaliador') && !current_user_can('administrator')) {
                    wp_redirect(home_url());
                }
            } else if (in_array('shortcode_homologado_view', $matches[2])) {

                // se o usuário logado não for publicador, deve ser redirecionado para home
                if (!is_user_logged_in()) {
                    wp_redirect(wp_login_url() . "?redirect_to=" . home_url() . "/homologados");
                } else if (!usuario_tem_role($current_user, 'publicador') && !current_user_can('administrator')) {
                    wp_redirect(home_url());
                }
            } else if (in_array('shortcode_gerente_view', $matches[2])) {

                // se o usuário logado não for visualizador, deve ser redirecionado para home
                if (!is_user_logged_in()) {
                    wp_redirect(wp_login_url() . "?redirect_to=" . home_url() . "/visualizacao");
                } else if (!usuario_tem_role($current_user, 'visualizador') && !current_user_can('administrator')) {
                    wp_redirect(home_url());
                }
            } else if (in_array('shortcode_candidato_view', $matches[2])) {

                // se o usuário logado não for candidato, deve ser redirecionado para home
                if (!is_user_logged_in()) {
                    wp_redirect(wp_login_url() . "?redirect_to=" . home_url() . "/acompanhamento");
                } else if (!usuario_tem_role($current_user, 'candidato') && !current_user_can('administrator')) {
                    wp_redirect(home_url());
                }
            }
        }
    }
}
add_action('template_redirect', 'pre_process_shortcode', 1);


// Remover barra do adming para candidato
function remove_admin_bar()
{
    // if (!current_user_can('administrator') && !is_admin()) {
    //     show_admin_bar(false);
    // }
    $current_user = wp_get_current_user();

    if (usuario_tem_role($current_user, 'candidato') && is_user_logged_in()) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'remove_admin_bar');
