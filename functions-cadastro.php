<?php


/*
* Registro e Enqueue dos styles e scripts
*/
function cadastro_register_style_script() {
	
    $ver = time();

	wp_register_style( 'cadastro_bootstrap_css', "https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css", false, $ver );
   
    wp_register_script( 'cadastro_jquery_js', 'https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js' , array(''), $ver, false );
    wp_register_script( 'cadastro_boostrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js' , array(''), $ver, false );

}
add_action( 'wp_enqueue_scripts', 'cadastro_register_style_script' );

function cadastro_enqueue_style_scripts(){
    wp_enqueue_style ( 'cadastro_bootstrap_css' );
    wp_enqueue_script( 'cadastro_jquery_js' );
    wp_enqueue_script( 'cadastro_boostrap_js' );
}


/*
* Shortcode para renderizar o formulário de início
*/

add_shortcode('shortcode_form_usuario', 'cadastro_form_usuario');

function cadastro_form_usuario() {

    cadastro_enqueue_style_scripts();

    echo '<h4>Example heading <span class="badge badge-secondary">New</span></h4>';
	
}