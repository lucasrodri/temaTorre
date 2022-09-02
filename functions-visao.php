<?php

function visao_send_post($body, $endpoint, $id_token = "")
{
    /*
	* Função para enviar a requisição post para o Visão
	*/

    $url =  get_option('tematorre_visao_host') . $endpoint;

    $args = array(
        'body'      => json_encode($body),
        'sslverify' => false,
        'headers' => array(
            'content-type' => 'application/json;charset=UTF-8'
        ),
    );

    if ($id_token != "") {
        $args['headers']['Authorization'] = 'Bearer ' . $id_token;
    }

    return wp_remote_post($url, $args);
}


function visao_auth()
{
    /*
	* Função para enviar a requisição de autenticação para o Visão e recuperar o token
	*/

    $body = array();
    $body['username'] = get_option('tematorre_visao_user');
    $body['password'] = get_option('tematorre_visao_pass');

    $endpoint = 'app/api/authenticate';

    $response = visao_send_post($body, $endpoint);

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        echo "Algo deu errado: " . $error_message;
        return false;
    } else {

        // Exemplo de resposta:
        // {"operacao":11,"handle":"123456789\/3","id":"17e45cdc-c681-4b91-b4ea-928ccc053a7a","status":0}
        $responseArray = json_decode($response["body"], true);
        echo $responseArray["id_token"];
        return $responseArray["id_token"];
    }
}


function visao_cria_ponto($estadoDaInstituicao, $cidadeDaInstituicao)
{

    $id_token = visao_auth();

    if ($id_token) {


        /*---------------------------------------------------------------------
        // Latitude e longitude
        Formato = "[lat, lon]"
	    ----------------------------------------------------------------------*/

        // pega a UF do estado
        $ufDaInstituicao = retornaUF($estadoDaInstituicao);

        //chama funcao que procura Latitude e Longitude por UF/Cidade
        $latlong = retornaLatLon($estadoDaInstituicao, $cidadeDaInstituicao);

        /*---------------------------------------------------------------------
	// Descricao
	Descrições da Unidade deve seguir o formato abaixo:
	</br><b>Local :</b> Brasília/DF </br>
	<b>Telefone: </b>(61) 3411.4366 </br>
	<b>Natureza Jurídica: </b>Secretaria</br></br><base href="http://ppsinajuve.ibict.br/jspui/handle/123456789/" target="_blank">
	<a href=96>Saiba Mais...</a>

	O link http://ppsinajuve.ibict.br/jspui/handle/123456789/ faz referência a subcomunidade criada no dspace-cris
	//---------------------------------------------------------------------*/
        $descricao     = "";

        // $descricao .= "</br><b>Local: </b>" . $cidadeDaInstituicao . "/" . $ufDaInstituicao . "</br>";
        // $descricao .= "<b>E-mail: </b>" . $emailDaUnidade . "</br>";
        // $descricao .= "</br><b>Responsável: </b>" . $nomeDoGestor . "</br>";
        // $descricao .= "</br><a href=" . $urlDspace . " target=\"_blank\">Saiba Mais...</a>";

        // recuperar lat,lon a partir do estado, cidade

        // criar $body para gerar um ponto

        /*
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

         */

        $body = array();


        $body["name"] = '';
        $body["geoJson"] = '';
        $body["type"] = "MARKER";
        $body["description"]  = '';
        $body["date"] = '';
        $body["source"] = '';
        $body["dateChange"]  = '';
        $body["note"]  = '';
        $body["group"]  = '{"id":263}';


        $endpoint = 'app/api/layers';

        $response = visao_send_post($body, $endpoint, $id_token);

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            echo "Algo deu errado: " . $error_message;
        } else {

            // Exemplo de resposta:
            $responseArray = json_decode($response["body"], true);
            return $responseArray["id_token"];
        }
    }

    return;
}

function conecta_visao($nomeUnidade, $telefoneUnidade, $estadoUnidade, $cidadeUnidade, $emailDaUnidade, $gestaoUnidade, $urlDspace, $nomeDoGestor, $emailDoGestor, $formulario, $flag)
{
    /*
	* Função que conecta com o banco do Visao e insere um marcador referente a uma unidade
	* Recebe as informações da unidade pelo formulário do sistema e a url gerada pelo dspace
	* Gera as variáveis '$latlong', '$marcador', '$descricao', '$datahoje', '$fonte', '$datahoje', '$notas', '$icone', '$grupo' para o insert no banco
	*   $latlong precisa de $estadoUnidade e $cidadeUnidade
	*   $marcador e $grupo precisam de $gestaoUnidade
	*   $descricao precisa de $telefoneUnidade, $naturezaUnidade e $urlDspace
	*   $notas precisa de $emailSolicitante 
	*/

    /*---------------------------------------------------------------------
	// Latitude e longitude
	Formato = "[lat, lon]"
	----------------------------------------------------------------------*/

    //chama funcao que procura Latitude e Longitude por Estado/Cidade
    $latlong = retornaLatLon($estadoUnidade, $cidadeUnidade);

    /*---------------------------------------------------------------------
	// Descricao
	Descrições da Unidade deve seguir o formato abaixo:
	</br><b>Local :</b> Brasília/DF </br>
	<b>Telefone: </b>(61) 3411.4366 </br>
	<b>Natureza Jurídica: </b>Secretaria</br></br><base href="http://ppsinajuve.ibict.br/jspui/handle/123456789/" target="_blank">
	<a href=96>Saiba Mais...</a>

	O link http://ppsinajuve.ibict.br/jspui/handle/123456789/ faz referência a subcomunidade criada no dspace-cris
	//---------------------------------------------------------------------*/
    $descricao     = "";

    //tratar telefone
    $descricao .= "</br><b>Local: </b>" . $cidadeUnidade . "/" . $estadoUnidade . "</br>";
    $descricao .= "<b>Telefone: </b>" . $telefoneUnidade . "</br>";
    $descricao .= "<b>E-mail: </b>" . $emailDaUnidade . "</br>";
    $descricao .= "</br><b>Responsável: </b>" . $nomeDoGestor . "</br>";
    $descricao .= "</br><a href=" . $urlDspace . " target=\"_blank\">Saiba Mais...</a>";

    /*---------------------------------------------------------------------
	// Gestao
	Gestao: Federal, Estadual, Municipal
				MARKER	group_id
	Federal		"POLYGON" 	3
	Estadual	"MARKER" 	4
	Municipal	"CIRCLE"	5
	----------------------------------------------------------------------*/
    switch ($formulario) {
        case "OG":
            switch ($gestaoUnidade) {
                case "Estadual":
                    $marcador = "MARKER";
                    $grupo = 10;
                    break;
                case "Municipal":
                    $marcador = "CIRCLE";
                    $grupo = 11;
                    break;
            }
            break;

        case "CJ":
            switch ($gestaoUnidade) {
                case "Federal":
                    $marcador = "POLYGON";
                    $grupo = 12;
                    break;
                case "Distrital":
                    $marcador = "MARKER";
                    $grupo = 13;
                    break;
                case "Estadual":
                    $marcador = "MARKER";
                    $grupo = 14;
                    break;
                case "Municipal":
                    $marcador = "CIRCLE";
                    $grupo = 15;
                    break;
            }
            break;

        case "OSC":
            $marcador = "CIRCLE";
            $grupo = 16;
            break;
    }
    /*---------------------------------------------------------------------
	// Data
	Formato: ano-mês-dia
	---------------------------------------------------------------------*/
    $datahoje = date("Y-m-d");

    //---------------------------------------------------------------------
    // Outros
    //---------------------------------------------------------------------
    $fonte = "Portal Sinajuve";
    $notas = $emailDoGestor; //para recuperar o registro depois
    $icone = 1; //restrição do banco

    //---------------------------------------------------------------------
    // manda requisicao
    //---------------------------------------------------------------------

    return "sucesso<br>";
}


function retornaUF($estadoDaInstituicao)
{
    return;
}

function retornaLatLon($estadoUnidade, $cidadeUnidade)
{
    /*
	* Função que retorna Latitude e Longitude a partir do endereço
	* Usa uma tabela local que contém nome da cidade, UF, latitude e longitude
	*/

    global $wpdb;

    $sql = "SELECT latitude, longitude FROM wp_municipios WHERE uf=\"" . $estadoUnidade . "\" AND nome=\"" . $cidadeUnidade . "\" order by nome limit 1;";

    $result = $wpdb->get_row($sql,  ARRAY_A); #return as alphabetical array

    if (null !== $result) {
        $lat = $result['latitude'];
        $lon = $result['longitude'];

        #retorna no formato do Visao
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
    echo get_option('tematorre_visao_host');
    echo '</p>';

    echo '<p><strong>';
    echo __('Currently, the saved username is: ', 'tematres-wp-integration');
    echo ' </strong>';
    echo get_option('tematorre_visao_user');
    echo '</p>';

    echo '<p><strong>';
    echo __('Currently, the saved password is: ', 'tematres-wp-integration');
    echo ' </strong>';
    echo get_option('tematorre_visao_pass');
    echo '</p>';
?>

    <form class="card" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
        <div class="wizard-panel-content">
            <h4>Pegar Token do Visão</h4>
            <p>Clique aqui para pegar um token do Visão</p>

            <div class="col-md-6 align-button-left">
                <input type="submit" class="br-button primary" value="Token" name="enviar">
                <input type="hidden" name="action" value="visao_autentica">
            </div>
        </div>
    </form>

<?php

}

// Deleta todas as entradas de todos os forms
function visao_autentica()
{
    visao_auth();
}
add_action('admin_post_nopriv_visao_autentica', 'visao_autentica');
add_action('admin_post_visao_autentica', 'visao_autentica');
