<?php

/*
* Shortcode para renderizar o formulário de início
*/

add_shortcode('shortcode_candidato_view', 'candidato_view');

function candidato_view()
{

    require_once(CFCORE_PATH . 'classes/admin.php');
    $form_ids = array(FORM_ID_GERAL, FORM_ID_SUPORTE, FORM_ID_FORMACAO, FORM_ID_PESQUISA, FORM_ID_INOVACAO, FORM_ID_TECNOLOGIA);
    $current_user = wp_get_current_user();
    $usuario_id = $current_user->ID;
    // para teste estou usando um usuário meu aqui
    $usuario_id = 11;
    $usuario_login = $current_user->user_login;

    $entradas = array();

    foreach ($form_ids as $form_id) {
        $data = Caldera_Forms_Admin::get_entries($form_id, 1, 9999999);
        $ativos = $data['active'];

        if ($ativos > 0) {
            $todasEntradas = $data['entries'];

            foreach ($todasEntradas as $umaEntrada) {
                $user_id = $umaEntrada['user']['ID'];

                if ($user_id == $usuario_id) {

                    $entrada = $umaEntrada['_entry_id'];
                    $form = Caldera_Forms_Forms::get_form($form_id);
                    $entradas[$form_id] = new Caldera_Forms_Entry($form, $entrada);
                    $entradas["date"] = $umaEntrada['_date'];
                    break;
                }
            }
        }
    }
    $date = date('M d, Y', strtotime($entradas["date"]));
    $redes = valida($entradas[FORM_ID_GERAL], 'fld_4891375');
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
                <tr class="noHover">
                    <td data-th="Data"><?php echo $date; ?></td>
                    <td data-th="Nome"><?php echo valida($entradas[FORM_ID_GERAL], 'fld_266564'); ?></td>
                    <td data-th="Status">
                        <?php render_status(valida($entradas[FORM_ID_GERAL], 'fld_4899711')); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Rodapé -->
    </div>
    <div id="edit-form-div-button" class="row mt-5 mb-5">
        <div class="col-md-12 align-button-right mr-4">
            <!-- O botão tera um onclick que removerá a div 'edit-form-div-button' e aparecerá a div 'edit-form-div' -->
            <button class="br-button success mr-sm-3" type="button" onclick="edit_candidato()">Edite Seu Formulário
            </button>
        </div>
    </div>

    <div id="edit-form-div" class="br-tab mt-5" style="display: none;">
        <nav class="tab-nav font-tab-torre">
            <ul>
                <li class="tab-item active">
                    <button type="button" data-panel="panel-1"><span class="name">Instituição</span></button>
                </li>
                <?php for ($i = 2; $i < count(explode(";", $redes)) + 1; $i++) : ?>
                    <li class="tab-item">
                        <button type="button" data-panel="panel-<?php echo $i; ?>"><span class="name"><?php echo relaciona(explode(";", $redes)[$i - 2])[2] ?></span></button>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <div class="tab-content mt-4">
            <div class="tab-panel active" id="panel-1">
                <?php render_geral_data($entradas[FORM_ID_GERAL]); ?>
            </div>
            <?php for ($i = 2; $i < count(explode(";", $redes)) + 1; $i++) : ?>
                <div class="tab-panel" id="panel-<?php echo $i; ?>">
                    <form class="card" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
                        <?php cadastro_redes_render(relaciona(explode(";", $redes)[$i - 2])[0], $entradas[relaciona(explode(";", $redes)[$i - 2])[1]]); ?>
                        <div class="row mt-5">
                            <div class="col-md-12 text-center">
                                <input type="submit" class="br-button primary" value="Atualizar Dados" name="enviar">
                            </div>
                        </div>
                        <input type="hidden" name="action" value="atualiza_<?php echo relaciona(explode(";", $redes)[$i - 2]); ?>">
                    </form>
                </div>
            <?php endfor; ?>
        </div>
    </div>
<?php
}


function render_geral_data($entrada)
{
?>
    <form class="card" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
        <p id="radio_function" style="display: none;"></p>
        <h3>Instituição</h3>
        <div class="mb-3">
            <div class="br-input">
                <label for="nomeDaInstituicao">Nome<span class="field_required" style="color:#ee0000;">*</span></label>
                <input id="nomeDaInstituicao" name="nomeDaInstituicao" type="text" placeholder="Nome da Instituição" onchange="changeError(name)" required value="<?php echo valida($entrada, 'fld_266564'); ?>" <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
            </div>
        </div>

        <div class="br-textarea mb-3">
            <label for="descricaoDaInstituicao">Descrição da instituição<span class="field_required" style="color:#ee0000;">*</span></label>
            <textarea class="textarea-start-size" id="descricaoDaInstituicao" name="descricaoDaInstituicao" placeholder="Escreva a descrição de sua instituição" maxlength="800" onchange="changeError(name)" required value="<?php echo valida($entrada, 'fld_6461522'); ?>" <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?>><?php echo valida($entrada, 'fld_6461522'); ?></textarea>
            <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
        </div>

        <div class="mb-3 radio-master">
            <p class="label mb-3">Natureza jurídica da instituição<span class="field_required" style="color:#ee0000;">*</span></p>
            <div class="br-radio">
                <input id="natureza_op_1" type="radio" name="natureza_op" class="natureza_op" value="Instituição pública federal" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_5902421'), "Instituição pública federal")) echo "checked"; ?> <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
                <label for="natureza_op_1">Instituição pública federal</label>
            </div>
            <div class="br-radio">
                <input id="natureza_op_2" type="radio" name="natureza_op" class="natureza_op" value="Instituição pública estadual" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_5902421'), "Instituição pública estadual")) echo "checked"; ?> <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
                <label for="natureza_op_2">Instituição pública estadual</label>
            </div>
            <div class="br-radio">
                <input id="natureza_op_3" type="radio" name="natureza_op" class="natureza_op" value="Instituição pública municipal" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_5902421'), "Instituição pública municipal")) echo "checked"; ?> <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
                <label for="natureza_op_3">Instituição pública municipal</label>
            </div>
            <div class="br-radio">
                <input id="natureza_op_4" type="radio" name="natureza_op" class="natureza_op" value="Instituição privada com fins lucrativos" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_5902421'), "Instituição privada com fins lucrativos")) echo "checked"; ?> <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
                <label for="natureza_op_4">Instituição privada com fins lucrativos</label>
            </div>
            <div class="br-radio">
                <input id="natureza_op_5" type="radio" name="natureza_op" class="natureza_op" value="Instituição privada sem fins lucrativos" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_5902421'), "Instituição privada sem fins lucrativos")) echo "checked"; ?> <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
                <label for="natureza_op_5">Instituição privada sem fins lucrativos</label>
                <br>
            </div>
        </div>

        <div class="mb-3 radio-slave" <?php if (valida($entrada, 'fld_7125239') == "") echo 'style="display:none;"' ?>>
            <p class="label mb-3">Porte da instituição privada<span class="field_required" style="color:#ee0000;">*</span></p>
            <div class="br-radio">
                <input id="porte_op_1" type="radio" name="porte_op" class="porte_op" value="Porte I – Microempresa e Empresa de Pequeno Porte (EPP): Receita Operacional Bruta anual ou anualizada de até R$ 4,8 milhões" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_7125239'), "Porte I – Microempresa e Empresa de Pequeno Porte (EPP): Receita Operacional Bruta anual ou anualizada de até R$ 4,8 milhões")) echo "checked"; ?> <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
                <label for="porte_op_1">Porte I – Microempresa e Empresa de Pequeno Porte (EPP): Receita Operacional Bruta anual ou anualizada de até R$ 4,8 milhões</label>
            </div>
            <div class="br-radio">
                <input id="porte_op_2" type="radio" name="porte_op" class="porte_op" value="Porte II – Pequena Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 4,8 milhões e igual ou inferior a R$ 16,0 milhões" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_7125239'), "Porte II – Pequena Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 4,8 milhões e igual ou inferior a R$ 16,0 milhões")) echo "checked"; ?> <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
                <label for="porte_op_2">Porte II – Pequena Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 4,8 milhões e igual ou inferior a R$ 16,0 milhões</label>
            </div>
            <div class="br-radio">
                <input id="porte_op_3" type="radio" name="porte_op" class="porte_op" value="Porte III – Média Empresa I: Receita Operacional Bruta anual ou anualizada superior a R$ 16,0 milhões e igual ou inferior a R$ 90,0 milhões" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_7125239'), "Porte III – Média Empresa I: Receita Operacional Bruta anual ou anualizada superior a R$ 16,0 milhões e igual ou inferior a R$ 90,0 milhões")) echo "checked"; ?> <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
                <label for="porte_op_3">Porte III – Média Empresa I: Receita Operacional Bruta anual ou anualizada superior a R$ 16,0 milhões e igual ou inferior a R$ 90,0 milhões</label>
            </div>
            <div class="br-radio">
                <input id="porte_op_4" type="radio" name="porte_op" class="porte_op" value="Porte IV – Média Empresa II: Receita Operacional Bruta anual ou anualizada superior a R$ 90,0 milhões e igual ou inferior a R$ 300,0 milhões" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_7125239'), "Porte IV – Média Empresa II: Receita Operacional Bruta anual ou anualizada superior a R$ 90,0 milhões e igual ou inferior a R$ 300,0 milhões")) echo "checked"; ?> <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
                <label for="porte_op_4">Porte IV – Média Empresa II: Receita Operacional Bruta anual ou anualizada superior a R$ 90,0 milhões e igual ou inferior a R$ 300,0 milhões</label>
            </div>
            <div class="br-radio">
                <input id="porte_op_5" type="radio" name="porte_op" class="porte_op" value="Porte V – Grande Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 300,0 milhões" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_7125239'), "Porte V – Grande Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 300,0 milhões")) echo "checked"; ?> <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
                <label for="porte_op_5">Porte V – Grande Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 300,0 milhões</label>
                <br>
            </div>
        </div>

        <div class="mt-3 mb-3">
            <div class="br-input">
                <label for="cnpjDaInstituicao">CNPJ<span class="field_required" style="color:#ee0000;">*</span></label>
                <input id="cnpjDaInstituicao" name="cnpjDaInstituicao" type="text" placeholder="99.999.999/9999-99" onchange="changeError(name)" onkeyup="validarEspecifico(name)" required value="<?php echo valida($entrada, 'fld_3000518'); ?>" <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
            </div>
        </div>

        <div class="br-textarea mb-3">
            <label for="CNAEDaInstituicao">CNAE<span class="field_required" style="color:#ee0000;">*</span></label>
            <textarea class="textarea-start-size" id="CNAEDaInstituicao" name="CNAEDaInstituicao" placeholder="Escreva sobre o CNAE de sua instituição" maxlength="800" onchange="changeError(name)" required value="<?php echo valida($entrada, 'fld_2471360'); ?>" <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?>><?php echo valida($entrada, 'fld_2471360'); ?></textarea>
            <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
        </div>

        <div class="mt-3 mb-3">
            <div class="br-input">
                <label for="urlDaInstituicao">Página da internet<span class="field_required" style="color:#ee0000;">*</span></label>
                <input id="urlDaInstituicao" name="urlDaInstituicao" type="url" placeholder="http://minhainstituicao.com.br" onchange="changeError(name)" onkeyup="validarEspecifico(name)" required value="<?php echo valida($entrada, 'fld_1962476'); ?>" <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
            </div>
        </div>


        <h4>Endereço</h4>
        <div class="mb-3">
            <div class="br-input">
                <label for="enderecoDaInstituicao">Endereço<span class="field_required" style="color:#ee0000;">*</span></label>
                <input id="enderecoDaInstituicao" name="enderecoDaInstituicao" type="text" placeholder="Endereço da Instituição" onchange="changeError(name)" required value="<?php echo valida($entrada, 'fld_3971477'); ?>" <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
            </div>

            <div class="br-input">
                <label for="complementoDaInstituicao">Complemento</label>
                <input id="complementoDaInstituicao" name="complementoDaInstituicao" type="text" placeholder="Complemento do endereço da Instituição" onchange="changeError(name)" value="<?php echo valida($entrada, 'fld_937636'); ?>" <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
            </div>

            <div class="br-input">
                <label for="estadoDaInstituicao">Estado</label>
                <input id="estadoDaInstituicao" name="estadoDaInstituicao" type="text" placeholder="Selecione o estado" onfocus="changeError(name)" required value="<?php echo valida($entrada, 'fld_1588802'); ?>" <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
            </div>

            <div class="br-input">
                <label for="cidadeDaInstituicao">Cidade</label>
                <input id="cidadeDaInstituicao" name="cidadeDaInstituicao" type="text" placeholder="Selecione a cidade" onfocus="changeError(name)" required value="<?php echo valida($entrada, 'fld_2343542'); ?>" <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
            </div>

            <div class="br-input">
                <label for="cepDaInstituicao">CEP<span class="field_required" style="color:#ee0000;">*</span></label>
                <input id="cepDaInstituicao" name="cepDaInstituicao" type="text" maxlength="9" pattern="\d{2}[.\s]?\d{3}[-.\s]?\d{3}" placeholder="CEP da Instituição" onchange="changeError(name)" onkeyup="validarEspecifico(name)" required value="<?php echo valida($entrada, 'fld_1936573'); ?>" <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
            </div>
        </div>


        <!-- Marca e Uploads -->
        <div class="h3">Logo e Guia de Uso de Marca</div>
        <!-- <div class="text my-text-wizard" tabindex="0">Conteúdo aqui</div> -->
        <div class="mt-3 mb-3">
            <div class="br-input">
                <label for="urlDaInstituicao">Logo<span class="field_required" style="color:#ee0000;">*</span></label><br>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="br-card">
                        <div class="card-content"><img src="<?php echo valida($entrada, 'fld_5438248') ?>" alt="Logo" /></div>
                    </div>
                </div>

                <a href="<?php echo valida($entrada, 'fld_5438248') ?>" target="_blank"><?php echo valida($entrada, 'fld_5438248') ?></a>
                <p class="text-base mt-1">Insira a logomarca, de preferência de 450x250 pixels, no formato PNG ou JPG</p>
            </div>
        </div>
        <div class="mt-3 mb-3">
            <div class="br-input">
                <label for="urlDaInstituicao">Guia de Uso da Marca<span class="field_required" style="color:#ee0000;">*</span></label><br>
                <a href="<?php echo valida($entrada, 'fld_9588438') ?>" target="_blank"><?php echo valida($entrada, 'fld_9588438') ?></a>
                <p class="text-base mt-1">Insira o guia de uso da marca no formato PDF de tamanho máximo 25MB</p>
            </div>
        </div>


        <!-- Dados de contato -->
        <h4>Dados de contato</h4>
        <p>Informe os dados de contato para receber a cópia dos dados registrados no cadastro das informações da instituição para publicação na Torre MCTI</p>

        <div class="mb-3">
            <div class="br-input">
                <label for="nomeDoCandidato">Nome<span class="field_required" style="color:#ee0000;">*</span></label>
                <input id="nomeDoCandidato" name="nomeDoCandidato" type="text" placeholder="Nome completo" onchange="changeError(name)" required value="<?php echo valida($entrada, 'fld_1333267'); ?>" <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
            </div>
        </div>

        <div class="mb-3">
            <div class="br-input">
                <label for="emailDoCandidato">E-mail<span class="field_required" style="color:#ee0000;">*</span></label>
                <input id="emailDoCandidato" name="emailDoCandidato" type="email" placeholder="exemplo@exemplo.com" onchange="changeError(name)" onkeyup="validarEspecifico(name)" required value="<?php echo valida($entrada, 'fld_7868662'); ?>" <?php if (valida($entrada, 'fld_4899711') == "avaliacao") echo "disabled"; ?> />
            </div>
        </div>
        <div class="row mt-5">
            <?php if (valida($entrada, 'fld_4899711') == "avaliacao") : ?>
                <!-- if só para não mostrar esse botão na apresentaçao -->
                <?php if (!current_user_can('administrator')) : ?>
                    <div class="col-md-12 text-center">
                        <input type="submit" class="br-button danger" value="Desistir do Processo" name="enviar">
                    </div>
                    <input type="hidden" name="action" value="desistir_candidato">
                <?php endif; ?>
            <?php else : ?>
                <div class="col-md-12 text-center">
                    <input type="submit" class="br-button primary" value="Atualizar Dados" name="enviar">
                </div>
                <input type="hidden" name="action" value="atualiza_candidato">
            <?php endif; ?>
        </div>
    </form>
<?php
}

function valida($entrada, $campo)
{
    /*
     * Função para validar uma entrada do formulário do Caldera Forms
     * Caso o campo seja nulo, ela retorna vazio
     */

    if ($entrada == "") {
        return "";
    }
    if (!is_null($entrada->get_field($campo))) {
        return $entrada->get_field($campo)->value;
    } else {
        return "";
    }
}

function contem($areas, $item)
{
    /*
     * Função para retornar os itens selecionados em um input checkbox
     * O input vem no formato de texto separado por ";"
     * Esta funçao checa se o valor de item está contido na texto da input
     */

    $pieces = explode(";", $areas);

    foreach ($pieces as $key) {
        if (strcmp($key, $item) == 0) {
            return true;
        }
    }
    return false;
}

function relaciona($s)
{
    switch ($s) {
        case "check_suporte":
            return array("rede-de-suporte", FORM_ID_SUPORTE, "Suporte");
        case "check_formacao":
            return array("rede-de-formacao", FORM_ID_FORMACAO, "Formação Tecnológica");
        case "check_pesquisa":
            return array("rede-de-pesquisa", FORM_ID_PESQUISA, "Pesquisa Aplicada");
        case "check_inovacao":
            return array("rede-de-inovacao", FORM_ID_INOVACAO, "Inovação");
        case "check_tecnologia":
            return array("rede-de-tecnologia", FORM_ID_TECNOLOGIA, "Tecnologias Aplicadas");
    }
}

function render_status($status)
{
    switch ($status) {
        case 'homologado':
            echo '<button class="br-button success small mt-3 mt-sm-0 noHover" type="button">Homologado</button>';
            break;
        case 'avaliacao':
            echo '<button class="br-button warning small mt-3 mt-sm-0 noHover" type="button">Em Análise</button>';
            break;
        case 'pendente':
            echo '<button class="br-button danger small mt-3 mt-sm-0 noHover" type="button">Ajustes Necessários</button>';
            break;
    }
}
