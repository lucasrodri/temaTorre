<?php
function menu_temaTorre()
{
    add_options_page(
        'Configurações do TemaTorre',
        'Configurações do TemaTorre',
        10,
        'theme-temaTorre',
        'menu_temaTorre_conteudo'
    );
}
function menu_temaTorre_conteudo()
{
?>
    <div class="wrap">

        <div id="icon-themes" class="icon32"></div>

        <h2>
            <?php echo ('Configurações do Tema Torre'); ?>
        </h2>
        <form method="POST" action="options.php">
            <?php
            settings_fields("visao_settings_all");
            do_settings_sections("theme-torre-options");
            ?>
            <?php submit_button(); ?>
        </form>

    </div>
<?php
}
add_action('admin_menu', 'menu_temaTorre');

function temaTorre_conf_campos()
{
    add_settings_section(
        "section_visao",
        "Dados do Visão",
        'visao_config_mensagem',
        "theme-torre-options"
    );

    $args = array(
        'type' => 'input',
        'subtype' => 'url',
        'id' => 'visao_hostname_conf',
        'name' => 'visao_hostname_conf',
        'required' => 'true',
        'pattern' => ".*\S+.*",
        'placeholder' => 'http://visao.ibict.br',
        'size' => 70,
        'get_options_list' => '',
        'value_type' => 'normal',
        'wp_data' => 'option'
    );

    add_settings_field(
        'visao_hostname_conf',
        "Informe o host:",
        "renderizar_campos",
        "theme-torre-options",
        "section_visao",
        $args
    );
    register_setting("visao_settings_all", 'visao_hostname_conf');

    $args = array(
        'type' => 'input',
        'subtype' => 'text',
        'id' => 'visao_username_conf',
        'name' => 'visao_username_conf',
        'required' => 'true',
        'pattern' => ".*\S+.*",
        'placeholder' => 'username',
        'size' => 70,
        'get_options_list' => '',
        'value_type' => 'normal',
        'wp_data' => 'option'
    );

    add_settings_field(
        'visao_username_conf',
        "Informe o nome de usuário:",
        "renderizar_campos",
        "theme-torre-options",
        "section_visao",
        $args
    );
    register_setting("visao_settings_all", 'visao_username_conf');

    $args = array(
        'type' => 'input',
        'subtype' => 'password',
        'id' => 'visao_password_conf',
        'name' => 'visao_password_conf',
        'required' => 'true',
        'pattern' => ".*\S+.*",
        'placeholder' => '********',
        'size' => 70,
        'get_options_list' => '',
        'value_type' => 'normal',
        'wp_data' => 'option'
    );

    add_settings_field(
        'visao_password_conf',
        "Informe a senha do usuário:",
        "renderizar_campos",
        "theme-torre-options",
        "section_visao",
        $args
    );
    register_setting("visao_settings_all", 'visao_password_conf');

    add_settings_section(
        "section_google_secret_recaptcha",
        "Google reCAPTCHA",
        'recaptcha_config_mensagem',
        "theme-torre-options"
    );

    $args = array(
        'type' => 'input',
        'subtype' => 'text',
        'id' => 'recaptcha_site_key_conf',
        'name' => 'recaptcha_site_key_conf',
        'required' => 'true',
        'pattern' => ".*\S+.*",
        'placeholder' => 'Chave do Site',
        'size' => 70,
        'get_options_list' => '',
        'value_type' => 'normal',
        'wp_data' => 'option'
    );

    add_settings_field(
        'recaptcha_site_key_conf',
        "Chave do Site:",
        "renderizar_campos",
        "theme-torre-options",
        "section_google_secret_recaptcha",
        $args
    );
    register_setting("visao_settings_all", 'recaptcha_site_key_conf');

    $args = array(
        'type' => 'input',
        'subtype' => 'text',
        'id' => 'recaptcha_secret_key_conf',
        'name' => 'recaptcha_secret_key_conf',
        'required' => 'true',
        'pattern' => ".*\S+.*",
        'placeholder' => 'Chave Secreta',
        'size' => 70,
        'get_options_list' => '',
        'value_type' => 'normal',
        'wp_data' => 'option'
    );

    add_settings_field(
        'recaptcha_secret_key_conf',
        "Chave do Secreta:",
        "renderizar_campos",
        "theme-torre-options",
        "section_google_secret_recaptcha",
        $args
    );
    register_setting("visao_settings_all", 'recaptcha_secret_key_conf');

}
add_action('admin_init', 'temaTorre_conf_campos');

function visao_config_mensagem($args)
{
    echo '<p>';
    echo "Informe os dados de acesso do Visao:";
    echo '</p>';
}

function recaptcha_config_mensagem($args)
{
    echo '<p>';
    echo "Informe os dados do Google reCAPTCHA:";
    echo '</p>';
}

function renderizar_campos($args)
{
    if ($args['wp_data'] == 'option') {
        $wp_data_value = get_option($args['name']);
    } elseif ($args['wp_data'] == 'post_meta') {
        $wp_data_value = get_post_meta($args['post_id'], $args['name'], true);
    }

    switch ($args['type']) {

        case 'input':
            $value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;

            if ($args['subtype'] != 'checkbox') {

                $prependStart = (isset($args['prepend_value'])) ? '<div class="input-prepend"> <span class="add-on">' . $args['prepend_value'] . '</span>' : '';
                $prependEnd   = (isset($args['prepend_value'])) ? '</div>' : '';
                $step         = (isset($args['step'])) ? 'step="' . $args['step'] . '"' : '';
                $min          = (isset($args['min'])) ? 'min="' . $args['min'] . '"' : '';
                $max          = (isset($args['max'])) ? 'max="' . $args['max'] . '"' : '';

                if (isset($args['disabled'])) {
                    // hide the actual input bc if it was just a disabled input the info saved in the database would be wrong - bc it would pass empty values and wipe the actual information
                    echo $prependStart . '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '_disabled" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '_disabled" size="40" disabled value="' . esc_attr($value) . '" /><input type="hidden" id="' . $args['id'] . '" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '" size="40" value="' . esc_attr($value) . '" />' . $prependEnd;
                } else {
                    // The common input is rendered here

                    $pattern = $args['pattern'] ? ' "pattern="' .  $args['pattern'] : '';

                    echo $prependStart . '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '" required="' . $args['required'] . $pattern . '" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '" size="' . $args['size'] . '" placeholder="' . $args['placeholder'] . '" value="' . esc_attr($value) . '" />' . $prependEnd;
                }
            } else {
                $checked = ($value) ? 'checked' : '';
                echo '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '" "' . $args['required'] . '" name="' . $args['name'] . '" size="40" value="1" ' . $checked . ' />';
            }
            break;
        default:
            # code...

            break;
    }
}
