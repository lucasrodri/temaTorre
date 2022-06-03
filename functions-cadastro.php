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

    //cadastro_enqueue_style_scripts();

    echo '<h4>Example heading <span class="badge badge-secondary">New</span></h4>';

    ?>
<div class="row">
                  <div class="col-sm">
                    <fieldset>
                      <legend>Nome Completo (Legend)</legend>
                      <div class="row">
                        <div class="col-md-7 mb-3">
                          <div class="br-input"><label for="name">Nome</label>
                            <input id="name" value="Fulano (input preenchido)" type="text" />
                          </div>
                        </div>
                        <div class="col-md-7 mb-3">
                          <div class="br-input">
                            <label for="surname">Sobrenome</label>
                            <input id="surname" type="text" placeholder="Placeholder"/>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-sm">
                    <fieldset>
                      <legend>Outros Dados (Legend)</legend>
                      <div class="row">
                        <div class="col-md-7 mb-3">
                          <div class="br-input">
                            <label for="cpf">CPF</label>
                            <input id="cpf" type="text" placeholder="Placeholder"/>
                          </div>
                        </div>
                        <div class="col-md-7 mb-3">
                          <div class="br-input input-button">
                            <label for="input-password">Senha</label>
                            <input id="input-password" type="password" placeholder="Digite sua senha"/>
                            <button class="br-button crumb" type="button" aria-label="Mostrar senha"><i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                </div>
<?php
}