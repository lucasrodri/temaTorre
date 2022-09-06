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


//------------------------------------------------------------------------------ Funções da API
function visao_send($body, $endpoint, $id_token = "", $method = "")
{
    /*
    * Função para enviar a requisição post para o Visão
    */

    $url =  get_option('visao_hostname_conf') . $endpoint;

    $args = array(
        'method'     => 'POST',
        'body'      => json_encode($body),
        'sslverify' => false,
        'headers' => array(
            'content-type' => 'application/json;charset=UTF-8'
        ),
    );

    if ($id_token != "") {
        $args['headers']['Authorization'] = 'Bearer ' . $id_token;
    }

    // sobrepõe o method no caso de delete
    if ($method == "DELETE") {
        $args['method'] = 'DELETE';
    }

    //return wp_remote_post($url, $args);
    return wp_remote_request($url, $args);
}

function visao_auth()
{
    /*
    * Função para enviar a requisição de autenticação para o Visão e recuperar o token
    */

    $body = array();
    $body['username'] = get_option('visao_username_conf');
    $body['password'] = get_option('visao_password_conf');

    $endpoint = 'app/api/authenticate';

    $response = visao_send($body, $endpoint);

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        echo "Algo deu errado: " . $error_message;
        return false;
    } else {
        $responseArray = json_decode($response["body"], true);
        //echo $responseArray["id_token"];
        return $responseArray["id_token"];
    }
}


function visao_cria_ponto($estadoDaInstituicao, $cidadeDaInstituicao, $nomeDaInstituicao, $urlDaInstituicao, $rede)
{

    $id_token = visao_auth();

    if ($id_token) {

        /*---------------------------------------------------------------------
        // Latitude e longitude
        Formato = "[lat, lon]"
        ----------------------------------------------------------------------*/

        // pega a UF do estado
        $codigoUFDaInstituicao = retorna_uf($estadoDaInstituicao, true);
        $ufDaInstituicao = retorna_uf($estadoDaInstituicao);

        //chama funcao que procura Latitude e Longitude por UF/Cidade
        $latlong = retornaLatLon($codigoUFDaInstituicao, $cidadeDaInstituicao);

        /*---------------------------------------------------------------------
        // Descricao
        Descrições do Ponto deve seguir o formato abaixo:
        <b>Site: </b>https://www.gov.br/mcti/pt-br
        <b>Localização: </b> Brasília - DF </br>
        <b>E-mail: </b>a@a.com </br>

        //---------------------------------------------------------------------*/
        $descricao  = "";
        $descricao .= "<br><b>Site: </b><a href=" . $urlDaInstituicao . " target=\"_blank\">" . $urlDaInstituicao . "</a>";
        $descricao .= "<br><b>Localização: </b>" . $cidadeDaInstituicao . " - " . $ufDaInstituicao . "</br>";
        // $descricao .= "<b>E-mail: </b>" . $emailDaUnidade . "</br>";

        /*---------------------------------------------------------------------
        // Redes -> definem a cor do ponto no mapa
                                            type	        icon    cor
        REDE DE SUPORTE                     MARKER          -       Azul
        REDE DE FORMAÇÃO TECNOLÓGICA        CUSTOM_MARKER   4       Laranja
        REDE DE PESQUISA APLICADA           CUSTOM_MARKER   5       Verde Azulado
        REDE DE INOVAÇÃO                    CUSTOM_MARKER   6       Amarelo
        REDE DE TECNOLOGIAS APLICADAS       CUSTOM_MARKER   7       Vermelho

        Outra forma: definindo as camadas na interface      
        Id	 Nome	 Descrição	 Grande Área		
        264	Rede de Suporte	-	Tecnologia e Inovação
        265	Rede de Formação Tecnológica	-	Tecnologia e Inovação
        266	Rede de Pesquisa Aplicada	-	Tecnologia e Inovação
        267	Rede de Inovação	-	Tecnologia e Inovação
        268	Rede de Tecnologias Aplicadas	-	Tecnologia e Inovação
        ----------------------------------------------------------------------*/
        $type = "";
        $icon_id = "";
        $group_id = "";

        // lógica para escolher type, icon e id
        switch ($rede) {
            case "teste":
                $type = "MARKER";
                $icon_id = "";
                $group_id = "263";
                break;
            case "rede-de-suporte":
                $type = "MARKER";
                $icon_id = "";
                $group_id = "264";
                break;

            case "rede-de-formacao":
                $type = "CUSTOM_MARKER";
                $icon_id = "4";
                $group_id = "265";
                break;

            case "rede-de-pesquisa":
                $type = "CUSTOM_MARKER";
                $icon_id = "5";
                $group_id = "266";
                break;

            case "rede-de-inovacao":
                $type = "CUSTOM_MARKER";
                $icon_id = "6";
                $group_id = "267";
                break;

            case "rede-de-tecnologia":
                $type = "CUSTOM_MARKER";
                $icon_id = "7";
                $group_id = "268";
                break;
        }

        /*---------------------------------------------------------------------
        // Data
        Formato c	Data ISO 8601   2004-02-12T15:19:21+00:00
        porém com "Z"
        "dateChange":"2022-08-23T12:45:00.000Z",

        https: //stackoverflow.com/questions/17390784/how-to-format-an-utc-date-to-use-the-z-zulu-zone-designator-in-php

        Resultado 1: no final vamos usar apenas o formato de data "c" que a API do visão consegue tratar
        Atualização: Visão deu erro por conta do -03:00 adicionado por alguma das datas que a gente trata no código

        Resultado 2: usar outro tipo de formatação que mostra a data no formato 2022-09-05T14:57:49Z
        ----------------------------------------------------------------------*/

        //$date = date("c");        
        $data = new DateTime();
        $date = $data->format('Y-m-d\TH:i:s\Z');

        /*---------------------------------------------------------------------
        // Body
        criar $body para gerar um ponto
        {
            "name":"DDD",
            "geoJson":"[10.0,10.0]",
            "type":"MARKER",
            "description":"asdasda",
            "date":"2022-08-23T12:45:00.000Z",
            "source":"asdasdsad",
            "dateChange":"2022-08-23T12:45:00.000Z",
            "note":"id customizado",
            "group":{"id":263}
        }
        ----------------------------------------------------------------------*/

        $body = array();

        $body["name"] = $nomeDaInstituicao;
        $body["geoJson"] =  $latlong;
        $body["description"]  = $descricao;

        $body["type"] = $type;

        if ($icon_id) {
            //se não enviar icon_id, ele não manda isso no body 
            $body["icon"] = array();
            $body["icon"]["id"] = $icon_id;
        }

        $body["group"]  = array();
        $body["group"]["id"] = $group_id;

        $body["date"] = $date;
        $body["dateChange"]  = $date;
        $body["source"] = 'Sistema de Cadastros da Torre MCTI';
        $body["note"]  = '';

        // echo 'Enviando o $body <br>';
        // var_dump($body);
        // echo '<br>';

        $endpoint = 'app/api/layers';
        $response = visao_send($body, $endpoint, $id_token);

        // echo 'Resposta:<br>';
        // var_dump($response);
        // echo '<br>';

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            echo "Algo deu errado: " . $error_message;
        } else {
            $responseArray = json_decode($response["body"], true);
            //echo 'Ponto criado: ' . $responseArray["id"] . '<br>';
            // ID para salvar em um fld
            return $responseArray["id"];
        }
    }

    return;
}


function visao_deleta_ponto($id_ponto)
{

    $id_token = visao_auth();

    if ($id_token) {
        $endpoint = '/app/api/layers/' . $id_ponto;

        // mando body vazio, esse request manda o id no endpoint
        $response = visao_send([], $endpoint, $id_token, "DELETE");

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            echo "Algo deu errado: " . $error_message;
            return false;
        } else {
            // No caso do delete, ele só me retorna que o status foi 200
            if ($response['response']['code'] == 200) {
                //echo 'Ponto excluido' . $id_ponto;
                return true;
            } else {
                $responseArray = json_decode($response["body"], true);
                echo "Erro no request: " . $responseArray["title"];
            }
        }
    }

    return;
}


function retorna_uf($estadoDaInstituicao, $codigo = false)
{
    // Função para retornar a sigla UF ou o codigo UF do estado a partir do nome

    global $wpdb;

    $coluna =  $codigo ? "codigo_uf" : "uf";

    $sql = "SELECT " . $coluna . " FROM " . $wpdb->prefix . "tematorre_estados WHERE nome=\"" . $estadoDaInstituicao . "\" order by nome;";
    $estados = $wpdb->get_col($sql);

    if (!empty($estados)) {
        return $estados[0];
    }

    return;
}

function retornaLatLon($ufDaInstituicao, $cidadeDaInstituicao)
{
    /*
	* Função que retorna Latitude e Longitude a partir do endereço
	* Usa uma tabela local que contém nome da cidade, UF, latitude e longitude
	*/

    global $wpdb;
    $sql = "SELECT latitude, longitude FROM " . $wpdb->prefix . "tematorre_municipios WHERE codigo_uf=\"" . $ufDaInstituicao . "\" AND nome=\"" . $cidadeDaInstituicao . "\" order by nome limit 1;";
    $result = $wpdb->get_row($sql,  ARRAY_A); // return as alphabetical array

    if (null !== $result) {
        $lat = $result['latitude'];
        $lon = $result['longitude'];

        // retorna no formato do Visao
        return "[$lat, $lon]";
    } else {
        // no link found
        return new WP_Error('500', 'Endereço não encontrado');
    }
}


add_shortcode('shortcode_testar_visao', 'testar_visao');
function testar_visao()
{

    echo '<p><strong>';
    echo __('Currently, the saved host is: ', 'tematres-wp-integration');
    echo ' </strong>';
    echo get_option('visao_hostname_conf');
    echo '</p>';

    echo '<p><strong>';
    echo __('Currently, the saved username is: ', 'tematres-wp-integration');
    echo ' </strong>';
    echo get_option('visao_username_conf');
    echo '</p>';

    echo '<p><strong>';
    echo __('Currently, the saved password is: ', 'tematres-wp-integration');
    echo ' </strong>';
    echo get_option('visao_password_conf');
    echo '</p>';
?>

    <form class="card" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
        <div class="wizard-panel-content">
            <h4>Testar o Visão</h4>
            <p>Clique aqui para enviar o comando de teste</p>

            <div class="col-md-6 align-button-left">
                <input type="submit" class="br-button primary" value="Testar" name="enviar">
                <input type="hidden" name="action" value="visao_autentica">
            </div>
        </div>
    </form>

<?php
}

// Função de teste
function visao_autentica()
{
    //visao_auth();

    // pega a UF do estado
    //$ufDaInstituicao = retorna_uf("Acre");

    //chama funcao que procura Latitude e Longitude por UF/Cidade
    //echo retornaLatLon($ufDaInstituicao, "Acrelândia");

    visao_cria_ponto("Acre", "Acrelândia", "Teste Rebeca 4", "https://www.google.com/", "rede-de-suporte");
    // visao_cria_ponto("Acre", "Acrelândia", "Teste Rebeca 5", "https://www.google.com/", "rede-de-formacao");
    // visao_cria_ponto("Acre", "Acrelândia", "Teste Rebeca 6", "https://www.google.com/", "rede-de-pesquisa");
    // visao_cria_ponto("Acre", "Acrelândia", "Teste Rebeca 7", "https://www.google.com/", "rede-de-inovacao");
    // visao_cria_ponto("Acre", "Acrelândia", "Teste Rebeca 8", "https://www.google.com/", "rede-de-tecnologia");

    // visao_deleta_ponto(415276);
}
add_action('admin_post_nopriv_visao_autentica', 'visao_autentica');
add_action('admin_post_visao_autentica', 'visao_autentica');


function relaciona_link_visao($s)
{
    switch ($s) {
        case "rede-de-suporte":
            return "https://visao.ibict.br/app/#/visao?chart=1&grupCategory=220&l=264";
        case "rede-de-formacao":
            return "https://visao.ibict.br/app/#/visao?chart=1&grupCategory=220&l=265";
        case "rede-de-pesquisa":
            return "https://visao.ibict.br/app/#/visao?chart=1&grupCategory=220&l=266";
        case "rede-de-inovacao":
            return "https://visao.ibict.br/app/#/visao?chart=1&grupCategory=220&l=267";
        case "rede-de-tecnologia":
            return "https://visao.ibict.br/app/#/visao?chart=1&grupCategory=220&l=268";
    }
}
