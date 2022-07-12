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
    $usuario_id = 36;
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
                    //TODO levar em consideração versionamento
                    break;
                }
            }
        }
    }

    $date = date('M d, Y', strtotime($entradas["date"]));
    $redes = valida($entradas[FORM_ID_GERAL], 'fld_4891375');

    /**
     * "fld_9748069" "status_geral_instituicao -> status de todos os forms
     * "fld_4899711" "status_instituicao"
     */

    $statusFormInstituicao = valida($entradas[FORM_ID_GERAL], 'fld_4899711');
    //$statusFormInstituicao = 'pendente';
    $arrayRedes = explode(";", $redes);
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
                        <?php render_status(valida($entradas[FORM_ID_GERAL], 'fld_9748069')); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Rodapé -->
    </div>
    <div class="row mt-5 mb-5">

        <div class="col-md-12 align-button-right mr-4">
            <!-- O botão tera um onclick que removerá a div 'edit-form-div-button' e aparecerá a div 'edit-form-div' -->
            <button id="carrega-form-btn" class="br-button success mr-sm-3" type="button" onclick="carrega_candidato()">
                <?php if ($statusFormInstituicao == "pendente") : ?>
                    Edite seu formulário
                <?php else : ?>
                    Veja seu formulário
                <?php endif; ?>
            </button>

            <button id="esconde-form-btn" class="br-button secondary" type="button" onclick="esconderFormulario();" style="display: none;">
                Fechar formulário
            </button>
        </div>
    </div>

    <div id="edit-form-div" class="br-tab mt-5" style="display: none;">
        <nav class="tab-nav font-tab-torre">
            <ul>
                <li class="tab-item active">
                    <button type="button" data-panel="panel-1"><span class="name">Instituição</span></button>
                </li>
                <?php for ($i = 2; $i < count($arrayRedes) + 1; $i++) : ?>
                    <li class="tab-item">
                        <button type="button" data-panel="panel-<?php echo $i; ?>"><span class="name"><?php echo relaciona($arrayRedes[$i - 2])[2] ?></span></button>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <div class="tab-content mt-4">
            <div class="tab-panel active" id="panel-1">
                <?php render_geral_form($entradas[FORM_ID_GERAL]); ?>
            </div>
            <?php for ($i = 2; $i < count($arrayRedes) + 1; $i++) : ?>
                <div class="tab-panel" id="panel-<?php echo $i; ?>">
                    <form class="cardCandidato" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
                        <?php
                        $nomeRede = relaciona($arrayRedes[$i - 2])[0];
                        $entrada = $entradas[relaciona($arrayRedes[$i - 2])[1]];
                        $statusRede = valida($entrada, 'fld_3707629');
                        //$statusRede = 'pendente';
                        ?>

                        <?php render_rede_avaliacao_data($rede_nome, $entrada); ?>
                        <?php cadastro_redes_render($nomeRede, $entrada); ?>

                        <?php if ($statusRede == "pendente") : ?>
                            <div class="row mt-5">
                                <div class="col-md-12 text-center">
                                    <input type="submit" class="br-button primary" value="Atualizar Dados" name="enviar">
                                    <input type="hidden" name="action" value="atualiza_<?php echo $arrayRedes[$i - 2]; ?>">
                                </div>
                            </div>
                        <?php endif; ?>

                    </form>
                </div>
            <?php endfor; ?>
        </div>
    </div>
<?php
}


function render_geral_form($entrada)
{
    $statusFormInstituicao = valida($entrada, 'fld_4899711');
    //$statusFormInstituicao = 'pendente';
?>
    <form class="card" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">

        <!-- basta checar se tem algo no parecer (sempre vai ter se tiver sido avaliado) -->
        <?php if (strlen(valida($entrada, 'fld_8529353')) > 1) : ?>
            <div class="col-md-12">

                <div class="br-textarea mb-3">
                    <label for="historicoParecer">Histórico do parecer</label>
                    <textarea class="textarea-start-size" name="historicoParecer" value="<?php echo valida($entrada, 'fld_4416984'); ?>" disabled><?php echo valida($entrada, 'fld_4416984'); ?></textarea>
                </div>
                <div class="br-textarea mb-3">
                    <label for="parecerAvaliador">Parecer do Avaliador</label>
                    <textarea class="textarea-start-size" name="parecerAvaliador" value="<?php echo valida($entrada, 'fld_8529353'); ?>" disabled><?php echo valida($entrada, 'fld_8529353'); ?></textarea>
                </div>

            </div>
        <?php endif; ?>

        <?php render_geral_data($entrada) ?>

        <div class="row mt-5">
            <?php if ($statusFormInstituicao == "avaliacao") : ?>
                <div class="col-md-12 text-center">
                    <input type="submit" class="br-button danger" value="Desistir do Processo" name="enviar">
                </div>
                <input type="hidden" name="action" value="desistir_candidato">
            <?php elseif ($statusFormInstituicao == "pendente") : ?>
                <div class="col-md-12 text-center">
                    <input type="submit" class="br-button primary" value="Atualizar Dados" name="enviar">
                </div>
                <input type="hidden" name="action" value="atualiza_candidato">
            <?php endif; ?>

            <input type="hidden" name="entrada" value="<?php $entrada ?>">
        </div>

    </form>
<?php
}


function render_geral_data($entrada)
{
    $statusFormInstituicao = valida($entrada, 'fld_4899711');
    //$statusFormInstituicao = 'pendente';

    // se o status for avaliacao ou homologado, não permite edição
    $disabled =  (($statusFormInstituicao == "avaliacao") || ($statusFormInstituicao == "homologado")) ?
        'disabled'
        : '';

?>
    <p id="radio_function" style="display: none;"></p>
    <!-- <h3>Instituição </h3> -->

    <div class="h4">Instituição
        <?php render_status($statusFormInstituicao); ?>
    </div>

    <div class="mb-3">
        <div class="br-input">
            <label for="nomeDaInstituicao">Nome<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="nomeDaInstituicao" name="nomeDaInstituicao" type="text" placeholder="Nome da Instituição" onchange="changeError(name)" required value="<?php echo valida($entrada, 'fld_266564'); ?>" <?php echo $disabled ?> />
        </div>
    </div>

    <div class="br-textarea mb-3">
        <label for="descricaoDaInstituicao">Descrição da instituição<span class="field_required" style="color:#ee0000;">*</span></label>
        <textarea class="textarea-start-size" id="descricaoDaInstituicao" name="descricaoDaInstituicao" placeholder="Escreva a descrição de sua instituição" maxlength="800" onchange="changeError(name)" required value="<?php echo valida($entrada, 'fld_6461522'); ?>" <?php echo $disabled ?>><?php echo valida($entrada, 'fld_6461522'); ?></textarea>
        <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
    </div>

    <div class="mb-3 radio-master">
        <p class="label mb-3">Natureza jurídica da instituição<span class="field_required" style="color:#ee0000;">*</span></p>
        <div class="br-radio">
            <input id="natureza_op_1" type="radio" name="natureza_op" class="natureza_op" value="Instituição pública federal" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_5902421'), "Instituição pública federal")) echo "checked"; ?> <?php echo $disabled ?> />
            <label for="natureza_op_1">Instituição pública federal</label>
        </div>
        <div class="br-radio">
            <input id="natureza_op_2" type="radio" name="natureza_op" class="natureza_op" value="Instituição pública estadual" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_5902421'), "Instituição pública estadual")) echo "checked"; ?> <?php echo $disabled ?> />
            <label for="natureza_op_2">Instituição pública estadual</label>
        </div>
        <div class="br-radio">
            <input id="natureza_op_3" type="radio" name="natureza_op" class="natureza_op" value="Instituição pública municipal" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_5902421'), "Instituição pública municipal")) echo "checked"; ?> <?php echo $disabled ?> />
            <label for="natureza_op_3">Instituição pública municipal</label>
        </div>
        <div class="br-radio">
            <input id="natureza_op_4" type="radio" name="natureza_op" class="natureza_op" value="Instituição privada com fins lucrativos" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_5902421'), "Instituição privada com fins lucrativos")) echo "checked"; ?> <?php echo $disabled ?> />
            <label for="natureza_op_4">Instituição privada com fins lucrativos</label>
        </div>
        <div class="br-radio">
            <input id="natureza_op_5" type="radio" name="natureza_op" class="natureza_op" value="Instituição privada sem fins lucrativos" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_5902421'), "Instituição privada sem fins lucrativos")) echo "checked"; ?> <?php echo $disabled ?> />
            <label for="natureza_op_5">Instituição privada sem fins lucrativos</label>
            <br>
        </div>
    </div>

    <div class="mb-3 radio-slave" <?php if (valida($entrada, 'fld_7125239') == "") echo 'style="display:none;"' ?>>
        <p class="label mb-3">Porte da instituição privada<span class="field_required" style="color:#ee0000;">*</span></p>
        <div class="br-radio">
            <input id="porte_op_1" type="radio" name="porte_op" class="porte_op" value="Porte I – Microempresa e Empresa de Pequeno Porte (EPP): Receita Operacional Bruta anual ou anualizada de até R$ 4,8 milhões" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_7125239'), "Porte I – Microempresa e Empresa de Pequeno Porte (EPP): Receita Operacional Bruta anual ou anualizada de até R$ 4,8 milhões")) echo "checked"; ?> <?php echo $disabled ?> />
            <label for="porte_op_1">Porte I – Microempresa e Empresa de Pequeno Porte (EPP): Receita Operacional Bruta anual ou anualizada de até R$ 4,8 milhões</label>
        </div>
        <div class="br-radio">
            <input id="porte_op_2" type="radio" name="porte_op" class="porte_op" value="Porte II – Pequena Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 4,8 milhões e igual ou inferior a R$ 16,0 milhões" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_7125239'), "Porte II – Pequena Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 4,8 milhões e igual ou inferior a R$ 16,0 milhões")) echo "checked"; ?> <?php echo $disabled ?> />
            <label for="porte_op_2">Porte II – Pequena Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 4,8 milhões e igual ou inferior a R$ 16,0 milhões</label>
        </div>
        <div class="br-radio">
            <input id="porte_op_3" type="radio" name="porte_op" class="porte_op" value="Porte III – Média Empresa I: Receita Operacional Bruta anual ou anualizada superior a R$ 16,0 milhões e igual ou inferior a R$ 90,0 milhões" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_7125239'), "Porte III – Média Empresa I: Receita Operacional Bruta anual ou anualizada superior a R$ 16,0 milhões e igual ou inferior a R$ 90,0 milhões")) echo "checked"; ?> <?php echo $disabled ?> />
            <label for="porte_op_3">Porte III – Média Empresa I: Receita Operacional Bruta anual ou anualizada superior a R$ 16,0 milhões e igual ou inferior a R$ 90,0 milhões</label>
        </div>
        <div class="br-radio">
            <input id="porte_op_4" type="radio" name="porte_op" class="porte_op" value="Porte IV – Média Empresa II: Receita Operacional Bruta anual ou anualizada superior a R$ 90,0 milhões e igual ou inferior a R$ 300,0 milhões" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_7125239'), "Porte IV – Média Empresa II: Receita Operacional Bruta anual ou anualizada superior a R$ 90,0 milhões e igual ou inferior a R$ 300,0 milhões")) echo "checked"; ?> <?php echo $disabled ?> />
            <label for="porte_op_4">Porte IV – Média Empresa II: Receita Operacional Bruta anual ou anualizada superior a R$ 90,0 milhões e igual ou inferior a R$ 300,0 milhões</label>
        </div>
        <div class="br-radio">
            <input id="porte_op_5" type="radio" name="porte_op" class="porte_op" value="Porte V – Grande Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 300,0 milhões" onchange="changeErrorRadio(name)" <?php if (contem(valida($entrada, 'fld_7125239'), "Porte V – Grande Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 300,0 milhões")) echo "checked"; ?> <?php echo $disabled ?> />
            <label for="porte_op_5">Porte V – Grande Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 300,0 milhões</label>
            <br>
        </div>
    </div>

    <div class="mt-3 mb-3">
        <div class="br-input">
            <label for="cnpjDaInstituicao">CNPJ<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="cnpjDaInstituicao" name="cnpjDaInstituicao" type="text" placeholder="99.999.999/9999-99" onchange="changeError(name)" onkeyup="validarEspecifico(name)" required value="<?php echo valida($entrada, 'fld_3000518'); ?>" <?php echo $disabled ?> />
        </div>
    </div>

    <div class="br-textarea mb-3">
        <label for="CNAEDaInstituicao">CNAE<span class="field_required" style="color:#ee0000;">*</span></label>
        <textarea class="textarea-start-size" id="CNAEDaInstituicao" name="CNAEDaInstituicao" placeholder="Escreva sobre o CNAE de sua instituição" maxlength="800" onchange="changeError(name)" required value="<?php echo valida($entrada, 'fld_2471360'); ?>" <?php echo $disabled ?>><?php echo valida($entrada, 'fld_2471360'); ?></textarea>
        <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
    </div>

    <div class="mt-3 mb-3">
        <div class="br-input">
            <label for="urlDaInstituicao">Página da internet<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="urlDaInstituicao" name="urlDaInstituicao" type="url" placeholder="http://minhainstituicao.com.br" onchange="changeError(name)" onkeyup="validarEspecifico(name)" required value="<?php echo valida($entrada, 'fld_1962476'); ?>" <?php echo $disabled ?> />
        </div>
    </div>


    <h4>Endereço</h4>
    <div class="mb-3">
        <div class="br-input">
            <label for="enderecoDaInstituicao">Endereço<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="enderecoDaInstituicao" name="enderecoDaInstituicao" type="text" placeholder="Endereço da Instituição" onchange="changeError(name)" required value="<?php echo valida($entrada, 'fld_3971477'); ?>" <?php echo $disabled ?> />
        </div>

        <div class="br-input">
            <label for="complementoDaInstituicao">Complemento</label>
            <input id="complementoDaInstituicao" name="complementoDaInstituicao" type="text" placeholder="Complemento do endereço da Instituição" onchange="changeError(name)" value="<?php echo valida($entrada, 'fld_937636'); ?>" <?php echo $disabled ?> />
        </div>

        <div class="br-input">
            <label for="estadoDaInstituicao">Estado</label>
            <input id="estadoDaInstituicao" name="estadoDaInstituicao" type="text" placeholder="Selecione o estado" onfocus="changeError(name)" required value="<?php echo valida($entrada, 'fld_1588802'); ?>" <?php echo $disabled ?> />
        </div>

        <div class="br-input">
            <label for="cidadeDaInstituicao">Cidade</label>
            <input id="cidadeDaInstituicao" name="cidadeDaInstituicao" type="text" placeholder="Selecione a cidade" onfocus="changeError(name)" required value="<?php echo valida($entrada, 'fld_2343542'); ?>" <?php echo $disabled ?> />
        </div>

        <div class="br-input">
            <label for="cepDaInstituicao">CEP<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="cepDaInstituicao" name="cepDaInstituicao" type="text" maxlength="9" pattern="\d{2}[.\s]?\d{3}[-.\s]?\d{3}" placeholder="CEP da Instituição" onchange="changeError(name)" onkeyup="validarEspecifico(name)" required value="<?php echo valida($entrada, 'fld_1936573'); ?>" <?php echo $disabled ?> />
        </div>
    </div>


    <!-- Marca e Uploads -->
    <div class="h3">Logo e Guia de Uso de Marca</div>
    <div class="mt-3 mb-3">
        <div class="br-input">
            <label for="logo_instituicao">Logo<span class="field_required" style="color:#ee0000;">*</span></label><br>

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
            <label for="guia_instituicao">Guia de Uso da Marca<span class="field_required" style="color:#ee0000;">*</span></label><br>
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
            <input id="nomeDoCandidato" name="nomeDoCandidato" type="text" placeholder="Nome completo" onchange="changeError(name)" required value="<?php echo valida($entrada, 'fld_1333267'); ?>" <?php echo $disabled ?> />
        </div>
    </div>

    <div class="mb-3">
        <div class="br-input">
            <label for="emailDoCandidato">E-mail<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="emailDoCandidato" name="emailDoCandidato" type="email" placeholder="exemplo@exemplo.com" onchange="changeError(name)" onkeyup="validarEspecifico(name)" required value="<?php echo valida($entrada, 'fld_7868662'); ?>" <?php echo $disabled ?> />
        </div>
    </div>

    <!-- Se estiver pendente e não tiver enviado recurso ainda -->
    <?php if (($statusFormInstituicao == "pendente") && (strlen(valida($entrada, 'fld_223413')) < 1)) : ?>
        <button id="recurso-btn" class="br-button secondary" type="button" onclick="botaoRecurso();">
            Entrar com recurso?
        </button>

        <div id="recurso-div" class="br-textarea mb-3" style="display:none">
            <label for="recursoInstituicao">Insira o recurso para enviar ao Avaliador</label>
            <textarea class="textarea-start-size" name="recursoInstituicao"></textarea>
            <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
        </div>
    <?php endif; ?>

    <!-- Se já tiver apresentado recurso -->
    <?php if (strlen(valida($entrada, 'fld_223413')) > 1) : ?>
        <div class="br-textarea mb-3">
            <label for="recursoInstituicao">Recurso para o avaliador</label>
            <textarea class="textarea-start-size" id="recursoInstituicao" name="recursoInstituicao" placeholder="Recurso" maxlength="800" value="<?php echo valida($entrada, 'fld_223413'); ?>" <?php echo $disabled ?>><?php echo valida($entrada, 'fld_223413'); ?></textarea>
            <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
        </div>
    <?php endif; ?>
<?php
}


function render_rede_avaliacao_data($rede_nome, $entrada)
{
?>
    <!-- basta checar se tem algo no parecer (sempre vai ter se tiver sido avaliado) -->
    <?php if (strlen(valida($entrada, 'fld_5960872')) > 1) : ?>
        <div class="col-md-12">
            <div class="br-textarea mb-3">
                <label for="historicoParecer_<?php echo $rede_nome; ?>">Histórico do parecer da rede</label>
                <textarea class="textarea-start-size" name="historicoParecer_<?php echo $rede_nome; ?>" value="<?php echo valida($entrada, 'fld_6135036'); ?>" disabled><?php echo valida($entrada, 'fld_6135036'); ?></textarea>
            </div>

            <div class="br-textarea mb-3">
                <label for="parecerAvaliador_<?php echo $rede_nome; ?>">Parecer do Avaliador</label>
                <textarea class="textarea-start-size" name="parecerAvaliador_<?php echo $rede_nome; ?>" value="<?php echo valida($entrada, 'fld_5960872'); ?>" disabled><?php echo valida($entrada, 'fld_5960872'); ?></textarea>
            </div>
            <!-- Acrescentar tags se for homologado!!!! -->
        </div>
    <?php endif; ?>
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
        case "geral":
            return array("instituicao", FORM_ID_GERAL, "Instituição");
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

// Função possivelmente não usada, já que será feito por ajax
function candidato_action_form()
{
    /*
	* Função action para uso do formulário de candidato (envio quando penden).
	* Função chamada pelo formulário "cadastro_form_usuario"
	*/

    if (isset($_POST['nomeDaInstituicao'])) $nomeDaInstituicao = ($_POST['nomeDaInstituicao']);
    else $nomeDaInstituicao = "";
    if (isset($_POST['descricaoDaInstituicao'])) $descricaoDaInstituicao = ($_POST['descricaoDaInstituicao']);
    else $descricaoDaInstituicao = "";
    if (isset($_POST['natureza_op'])) $natureza_op = ($_POST['natureza_op']);
    else $natureza_op = "";
    if (isset($_POST['porte_op'])) $porte_op = ($_POST['porte_op']);
    else $porte_op = "";

    if (($natureza_op != "Instituição privada com fins lucrativos") && ($natureza_op != "Instituição privada sem fins lucrativos")) {
        $porte_op = "";
    }

    if (isset($_POST['cnpjDaInstituicao'])) $cnpjDaInstituicao = ($_POST['cnpjDaInstituicao']);
    else $cnpjDaInstituicao = "";
    if (isset($_POST['CNAEDaInstituicao'])) $CNAEDaInstituicao = ($_POST['CNAEDaInstituicao']);
    else $CNAEDaInstituicao = "";
    if (isset($_POST['urlDaInstituicao'])) $urlDaInstituicao = ($_POST['urlDaInstituicao']);
    else $urlDaInstituicao = "";

    if (isset($_POST['enderecoDaInstituicao'])) $enderecoDaInstituicao = ($_POST['enderecoDaInstituicao']);
    else $enderecoDaInstituicao = "";
    if (isset($_POST['complementoDaInstituicao'])) $complementoDaInstituicao = ($_POST['complementoDaInstituicao']);
    else $complementoDaInstituicao = "";
    if (isset($_POST['estadoDaInstituicao'])) $estadoDaInstituicao = ($_POST['estadoDaInstituicao']);
    else $estadoDaInstituicao = "";
    if (isset($_POST['cidadeDaInstituicao'])) $cidadeDaInstituicao = ($_POST['cidadeDaInstituicao']);
    else $cidadeDaInstituicao = "";
    if (isset($_POST['cepDaInstituicao'])) $cepDaInstituicao = ($_POST['cepDaInstituicao']);
    else $cepDaInstituicao = "";

    //Arquivos
    //doc1
    if (isset($_FILES['logo_instituicao']) && strlen($_FILES['logo_instituicao']['name']) > 0) {
        $doc1Unidade = $_FILES['logo_instituicao'];
    }
    //doc2
    if (isset($_FILES['guia_instituicao']) && strlen($_FILES['guia_instituicao']['name']) > 0) {
        $doc2Unidade = $_FILES['guia_instituicao'];
    }

    //pegar redes

    //Nome e email do candidato
    if (isset($_POST['nomeDoCandidato'])) $nomeDoCandidato = ($_POST['nomeDoCandidato']);
    else $nomeDoCandidato = "";
    if (isset($_POST['emailDoCandidato'])) $emailDoCandidato = ($_POST['emailDoCandidato']);
    else $emailDoCandidato = "";

    //----------------------------submit
    if (isset($_POST["enviar"])) {

        $entrada = '';
        $redes = '';$statusGeral = ''; $status = ''; $parecer = ''; $historico = '';

        // Tratamento dos arquivos
        if (!is_null($doc1Unidade)) {
            $doc1UnidadeUrl = upload_documento($doc1Unidade, $emailDoCandidato, "1");
        }
        if (!is_null($doc2Unidade)) {
            $doc2UnidadeUrl = upload_documento($doc2Unidade, $emailDoCandidato, "2");
        }

        //funcao para criar a entrada no Caldera (Form geral)
        update_entrada_form_candidato($entrada, $nomeDaInstituicao, $descricaoDaInstituicao, $natureza_op, $porte_op, $cnpjDaInstituicao, $CNAEDaInstituicao, $urlDaInstituicao, $enderecoDaInstituicao, $complementoDaInstituicao, $estadoDaInstituicao, $cidadeDaInstituicao, $cepDaInstituicao, $redes, $doc1UnidadeUrl, $doc2UnidadeUrl, $nomeDoCandidato, $emailDoCandidato, $statusGeral, $status, $parecer, $historico);


        envia_email('reenviar', $nomeDaInstituicao, $emailDoCandidato);

        // redirecionar para a página de sucesso
        wp_redirect(esc_url(home_url('/sucesso')));
        //wp_redirect(get_permalink( 13832 ));
        exit;
    } //end do if de enviar
}
add_action('admin_post_nopriv_atualiza_candidato', 'candidato_action_form');
add_action('admin_post_atualiza_candidato', 'candidato_action_form');

function update_entrada_form_candidato($entrada, $nomeDaInstituicao, $descricaoDaInstituicao, $natureza_op, $porte_op, $cnpjDaInstituicao, $CNAEDaInstituicao, $urlDaInstituicao, $enderecoDaInstituicao, $complementoDaInstituicao, $estadoDaInstituicao, $cidadeDaInstituicao, $cepDaInstituicao, $redes, $doc1UnidadeUrl, $doc2UnidadeUrl, $nomeDoCandidato, $emailDoCandidato, $status = "avaliacao")
{
    /*
	* Função para atualizar uma nova entrada em um Caldera Forms
    * Usado para o form Geral
	*/

    Caldera_Forms_Entry_Update::update_field_value('fld_266564', $entrada, $nomeDaInstituicao);
    Caldera_Forms_Entry_Update::update_field_value('fld_6461522', $entrada, $descricaoDaInstituicao);
    Caldera_Forms_Entry_Update::update_field_value('fld_5902421', $entrada, $natureza_op);
    Caldera_Forms_Entry_Update::update_field_value('fld_7125239', $entrada, $porte_op);
    Caldera_Forms_Entry_Update::update_field_value('fld_3000518', $entrada, $cnpjDaInstituicao);
    Caldera_Forms_Entry_Update::update_field_value('fld_2471360', $entrada, $CNAEDaInstituicao);
    Caldera_Forms_Entry_Update::update_field_value('fld_1962476', $entrada, $urlDaInstituicao);

    Caldera_Forms_Entry_Update::update_field_value('fld_3971477', $entrada, $enderecoDaInstituicao);
    Caldera_Forms_Entry_Update::update_field_value('fld_937636',  $entrada, $complementoDaInstituicao);
    Caldera_Forms_Entry_Update::update_field_value('fld_1588802', $entrada, $estadoDaInstituicao);
    Caldera_Forms_Entry_Update::update_field_value('fld_2343542', $entrada, $cidadeDaInstituicao);
    Caldera_Forms_Entry_Update::update_field_value('fld_1936573', $entrada, $cepDaInstituicao);

    Caldera_Forms_Entry_Update::update_field_value('fld_4891375', $entrada, $redes);

    Caldera_Forms_Entry_Update::update_field_value('fld_5438248', $entrada, $doc1UnidadeUrl);
    Caldera_Forms_Entry_Update::update_field_value('fld_9588438', $entrada, $doc2UnidadeUrl);
    Caldera_Forms_Entry_Update::update_field_value('fld_1333267', $entrada, $nomeDoCandidato);
    Caldera_Forms_Entry_Update::update_field_value('fld_7868662', $entrada, $emailDoCandidato);

    // Caldera_Forms_Entry_Update::update_field_value('fld_9748069', $entrada, $statusGeral);
    Caldera_Forms_Entry_Update::update_field_value('fld_4899711', $entrada, $status);
    // Caldera_Forms_Entry_Update::update_field_value('fld_4416984', $entrada, $historico);
    // Caldera_Forms_Entry_Update::update_field_value('fld_8529353', $entrada, $parecer);
}

function update_entrada_form_especifico_candidato($entrada, $dados_redes, $status = "avaliacao", $versao = 0)
{
    /*
	* Função para atualizar uma nova entrada em um Caldera Forms
    * Usado para os forms específicos de cada rede 
	*/

    Caldera_Forms_Entry_Update::update_field_value('fld_605717', $entrada, $dados_redes["urlServico"]);
    Caldera_Forms_Entry_Update::update_field_value('fld_4486725', $entrada, $dados_redes["produtoServicos"]);

    Caldera_Forms_Entry_Update::update_field_value('fld_8777940', $entrada, $dados_redes["classificacoes"]);
    Caldera_Forms_Entry_Update::update_field_value('fld_6678080', $entrada, $dados_redes["outroClassificacao"]);

    Caldera_Forms_Entry_Update::update_field_value('fld_4665383', $entrada, $dados_redes["publicos"]);
    Caldera_Forms_Entry_Update::update_field_value('fld_2391778', $entrada, $dados_redes["abrangencias"]);

    Caldera_Forms_Entry_Update::update_field_value('fld_6140408', $entrada, $dados_redes["nomeCompleto"]);
    Caldera_Forms_Entry_Update::update_field_value('fld_7130000', $entrada, $dados_redes["emailRepresentante"]);
    Caldera_Forms_Entry_Update::update_field_value('fld_5051662', $entrada, $dados_redes["telefoneRepresentante"]);

    Caldera_Forms_Entry_Update::update_field_value('fld_3707629', $entrada, $status);

    //$versaoOld = valida($entrada, 'fld_2402818');
    Caldera_Forms_Entry_Update::update_field_value('fld_2402818', $entrada, $versao);
}


function atualiza_rede_candidato_ajax()
{
    return;
}
add_action('wp_ajax_atualiza_rede_candidato', 'atualiza_rede_candidato_ajax');
add_action('wp_ajax_nopriv_atualiza_rede_candidato', 'atualiza_rede_candidato_ajax');
