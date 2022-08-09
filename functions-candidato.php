<?php

/*
* Shortcode para renderizar o formulário de início
*/

define('USER_TESTE', 26);

add_shortcode('shortcode_candidato_view', 'candidato_view');

function candidato_view()
{
    require_once(CFCORE_PATH . 'classes/admin.php');

    $form_ids = array(FORM_ID_GERAL, FORM_ID_SUPORTE, FORM_ID_FORMACAO, FORM_ID_PESQUISA, FORM_ID_INOVACAO, FORM_ID_TECNOLOGIA);
    $current_user = wp_get_current_user();
    $usuario_id = $current_user->ID;
    // para teste estou usando um usuário meu aqui
    $usuario_id = USER_TESTE;
    $usuario_login = $current_user->user_login;

    $entradas = array();
    $entradas_id = array();

    foreach ($form_ids as $form_id) {
        $data = Caldera_Forms_Admin::get_entries($form_id, 1, 9999999);
        $ativos = $data['active'];

        if ($ativos > 0) {
            $todasEntradas = $data['entries'];

            foreach ($todasEntradas as $umaEntrada) {
                $user_id = $umaEntrada['user']['ID'];

                if ($user_id == $usuario_id) {

                    $entrada = $umaEntrada['_entry_id'];
                    $entradas_id[$form_id] = $entrada; //novo array para guardar as entry_id
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
    $todas_redes = "check_suporte;check_formacao;check_pesquisa;check_inovacao;check_tecnologia;";
    $arrayRedes = explode(";", $todas_redes);

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
                    <td data-th="Status" id="tdStatus">
                        <div id='loading_carregar_status' class="loading small" style='display:none;'></div>
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

            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
                <input type="submit" onClick="return confirm('Você tem certeza que quer apagar sua candidatura? Essa ação não poderá ser desfeita.')" class="br-button danger mr-3" value="Desistir do Processo" name="enviar">
                <input type="hidden" name="usuario_id" value="<?php echo $user_id; ?>">
                <input type="hidden" name="action" value="desistir_candidato">
            </form>

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
            <div id='loading_carregar' class="loading medium" style='display:none;'></div>
            <div class="tab-panel active" id="panel-1">
                <?php render_geral_form($entradas[FORM_ID_GERAL]); ?>

                <input type="hidden" id="entrada_geral" name="entrada_geral" value="<?php echo $entradas_id[FORM_ID_GERAL]; ?>">
            </div>
            <?php for ($i = 2; $i < count($arrayRedes) + 1; $i++) : ?>
                <div class="tab-panel" id="panel-<?php echo $i; ?>">
                    <?php
                    $nomeRede = relaciona($arrayRedes[$i - 2])[0];
                    $form_id = relaciona($arrayRedes[$i - 2])[1];
                    $entrada = $entradas[$form_id];
                    $statusRede = valida($entrada, 'fld_3707629');
                    $redeAtiva = valida($entrada, 'fld_4663810');
                    $styleRedeAtiva = $redeAtiva == "true" ? '' : 'display:none;';
                    $styleAtualizaAtiva = $redeAtiva == "true" && $statusRede == "pendente" ? '' : 'display:none;';
                    ?>

                    <?php candidato_avaliacao_redes_render($nomeRede, $entrada); ?>

                    <div id="tab_redes_<?php echo $i; ?>">
                        <?php cadastro_redes_render($nomeRede, $entrada); ?>

                        <input type="hidden" name="entrada_<?php echo $arrayRedes[$i - 2]; ?>" value="<?php echo $entradas_id[$form_id]; ?>">
                    </div>
                    <div>
                        <div class="row">

                            <div id="botaoAdicionar_<?php echo $i; ?>" class="mt-5 col-md-12" style="display: <?php if ($redeAtiva == "false") {
                                                                                                                    echo "";
                                                                                                                } else {
                                                                                                                    echo "none";
                                                                                                                } ?>;">
                                <div class="text-center">
                                    <button class="br-button primary" type="button" onclick="criarRedeCandidato('<?php echo $i; ?>', '<?php echo $arrayRedes[$i - 2]; ?>');">Adicionar nova entrada nesta rede</button>
                                </div>
                            </div>

                            <div id="botaoExcluir_<?php echo $i; ?>" class="mt-5 col-md-<?php if ($statusRede == "pendente") {
                                                                                            echo "6";
                                                                                        } else {
                                                                                            echo "12";
                                                                                        } ?>" style="<?php echo $styleRedeAtiva; ?>">
                                <div class="text-<?php if ($statusRede == "pendente") {
                                                        echo "right";
                                                    } else {
                                                        echo "center";
                                                    } ?>">
                                    <button class="br-button danger" type="button" onclick="excluirRedeCandidato('<?php echo $i; ?>', '<?php echo $arrayRedes[$i - 2]; ?>','<?php echo $entradas_id[$form_id]; ?>');">Excluir entrada desta rede</button>
                                    <input type="hidden" name="action" value="excluir_<?php echo $arrayRedes[$i - 2]; ?>">
                                </div>
                            </div>

                            <div id="botaoAtualizar_<?php echo $i; ?>" class="mt-5 col-md-6" style="<?php echo $styleAtualizaAtiva; ?>">
                                <div class="text-left">
                                    <button class="br-button primary" type="button" onclick="atualizaRedeCandidato('<?php echo $i; ?>', '<?php echo $arrayRedes[$i - 2]; ?>','<?php echo $entradas_id[$form_id]; ?>');">Atualizar Dados</button>
                                    <input type="hidden" name="action" value="atualiza_<?php echo $arrayRedes[$i - 2]; ?>">
                                </div>
                            </div>

                        </div>
                    </div>
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

    <div id="tab_instituicao">
        <form id="tab_instituicao_form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
            <?php render_geral_data($entrada) ?>

            <div class="row mt-5">
                <?php if ($statusFormInstituicao == "pendente") : ?>
                    <div class="col-md-12 text-center">
                        <button class="br-button primary" type="button" onclick="atualizaRedeCandidatoGeral();">Atualizar Dados</button>
                    </div>
                    <input type="hidden" name="action" value="atualiza_geral_candidato">
                <?php endif; ?>
            </div>
        </form>
    </div>
<?php
}


function render_geral_data($entrada, $flag_view = 'false')
{
    $statusFormInstituicao = valida($entrada, 'fld_4899711');
    //$statusFormInstituicao = 'pendente';

    // se o status for avaliacao ou homologado, não permite edição
    $disabled =  (($statusFormInstituicao == "avaliacao") || ($statusFormInstituicao == "homologado") || $flag_view == 'true') ?
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
        <?php if ($statusFormInstituicao == "pendente") : ?>
            <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
        <?php endif; ?>
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
        <?php if ($statusFormInstituicao == "pendente") : ?>
            <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
        <?php endif; ?>
    </div>

    <div class="mt-3 mb-3">
        <div class="br-input">
            <label for="urlDaInstituicao">Página da internet<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="urlDaInstituicao" name="urlDaInstituicao" type="url" placeholder="http://minhainstituicao.com.br" onchange="changeError(name)" onkeyup="validarEspecifico(name)" required value="<?php echo valida($entrada, 'fld_1962476'); ?>" <?php echo $disabled ?> />
        </div>
    </div>

    <h4>Endereço</h4>
    <div class="mb-3">
        <!--se for pendente, o usuário pode editar: mostra selects  -->
        <?php if ($statusFormInstituicao == "pendente") : ?>
            <?php echo carrega_estado_cidade_selecionado(valida($entrada, 'fld_1588802'), valida($entrada, 'fld_2343542')) ?>
        <?php else : ?>
            <div class="br-input">
                <label for="estadoDaInstituicao">Estado</label>
                <input id="estadoDaInstituicao" name="estadoDaInstituicao" type="text" placeholder="Selecione o estado" onfocus="changeError(name)" required value="<?php echo valida($entrada, 'fld_1588802'); ?>" <?php echo $disabled ?> />
            </div>

            <div class="br-input">
                <label for="cidadeDaInstituicao">Cidade</label>
                <input id="cidadeDaInstituicao" name="cidadeDaInstituicao" type="text" placeholder="Selecione a cidade" onfocus="changeError(name)" required value="<?php echo valida($entrada, 'fld_2343542'); ?>" <?php echo $disabled ?> />
            </div>
        <?php endif; ?>

        <div class="br-input">
            <label for="enderecoDaInstituicao">Endereço<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="enderecoDaInstituicao" name="enderecoDaInstituicao" type="text" placeholder="Endereço da Instituição" onchange="changeError(name)" required value="<?php echo valida($entrada, 'fld_3971477'); ?>" <?php echo $disabled ?> />
        </div>

        <div class="br-input">
            <label for="complementoDaInstituicao">Complemento</label>
            <input id="complementoDaInstituicao" name="complementoDaInstituicao" type="text" placeholder="Complemento do endereço da Instituição" onchange="changeError(name)" value="<?php echo valida($entrada, 'fld_937636'); ?>" <?php echo $disabled ?> />
        </div>

        <div class="br-input">
            <label for="cepDaInstituicao">CEP<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="cepDaInstituicao" name="cepDaInstituicao" type="text" maxlength="9" pattern="\d{2}[.\s]?\d{3}[-.\s]?\d{3}" placeholder="CEP da Instituição" onchange="changeError(name)" onkeyup="validarEspecifico(name)" required value="<?php echo valida($entrada, 'fld_1936573'); ?>" <?php echo $disabled ?> />
        </div>
    </div>


    <!-- Marca e Uploads -->
    <div class="h3">Logo e Guia de Uso de Marca</div>
    <div class="mt-3 mb-3">
        <div id="logo_instituicao_old" class="br-input">
            <label>Logo<span class="field_required" style="color:#ee0000;">*</span></label><br>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="br-card">
                    <div class="card-content"><img src="<?php echo valida($entrada, 'fld_5438248') ?>" alt="Logo" /></div>
                </div>
            </div>

            <a href="<?php echo valida($entrada, 'fld_5438248') ?>" target="_blank"><?php echo valida($entrada, 'fld_5438248') ?></a>
            <input type="hidden" id="doc1" name="doc1" value="<?php echo valida($entrada, 'fld_5438248'); ?>">
            <!-- <p class="text-base mt-1">Insira a logomarca, de preferência de 450x250 pixels, no formato PNG ou JPG</p> -->
        </div>

        <?php if ($statusFormInstituicao == "pendente") : ?>

            <button type="button" class="br-button secondary" id="anexo_logo_instituicao" name="anexo_logo_instituicao" onclick="apagarAnexo(name)">Apagar logo</button>

            <div id="logo_instituicao_new" class="br-upload" style="display:none;">
                <label class="upload-label" for="logo_instituicao"><span>Logo<span class="field_required" style="color:#ee0000;">*</span></span></label>
                <input class="upload-input" id="logo_instituicao" name="logo_instituicao" type="file" accept=".jpg,.png,.jpeg" onchange="changeError(name)" />
                <div class="upload-list"></div>
            </div>
            <p id="logo_instituicao_texto" class="text-base mt-1" style="display:none;">Insira a logomarca, de preferência de 450x250 pixels, no formato PNG ou JPG</p>

        <?php endif; ?>
    </div>
    <div class="mt-3 mb-3">

        <div id="guia_instituicao_old" class="br-input">
            <label>Guia de Uso da Marca<span class="field_required" style="color:#ee0000;">*</span></label><br>
            <a href="<?php echo valida($entrada, 'fld_9588438') ?>" target="_blank"><?php echo valida($entrada, 'fld_9588438') ?></a>
            <input type="hidden" id="doc2" name="doc2" value="<?php echo valida($entrada, 'fld_9588438'); ?>">
            <!-- <p class="text-base mt-1">Insira o guia de uso da marca no formato PDF de tamanho máximo 25MB</p> -->
        </div>

        <?php if ($statusFormInstituicao == "pendente") : ?>

            <button type="button" class="br-button secondary" id="anexo_guia_instituicao" name="anexo_guia_instituicao" onclick="apagarAnexo(name)">Apagar documento</button>

            <div id="guia_instituicao_new" class="br-upload" style="display:none;">
                <label class="upload-label" for="guia_instituicao"><span>Guia de Uso da Marca<span class="field_required" style="color:#ee0000;">*</span></span></label>
                <input class="upload-input" id="guia_instituicao" name="guia_instituicao" type="file" accept=".pdf" onchange="changeError(name)" />
                <div class="upload-list"></div>
            </div>

            <p id="guia_instituicao_texto" class="text-base mt-1" style="display:none;">Insira o guia de uso da marca no formato PDF de tamanho máximo 25MB</p>

        <?php endif; ?>

    </div>


    <!-- Dados de contato -->
    <h4>Dados de contato</h4>
    <!-- <p>Informe os dados de contato para receber a cópia dos dados registrados no cadastro das informações da instituição para publicação na Torre MCTI</p> -->

    <div class="mb-3">
        <div class="br-input">
            <label for="nomeDoCandidato">Nome<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="nomeDoCandidato" name="nomeDoCandidato" type="text" placeholder="Nome completo" onchange="changeError(name)" required value="<?php echo valida($entrada, 'fld_1333267'); ?>" <?php echo $disabled ?> />
        </div>
    </div>

    <div class="mb-3">
        <div class="br-input">
            <label for="emailDoCandidato">E-mail<span class="field_required" style="color:#ee0000;">*</span></label>
            <input class="disabled" id="emailDoCandidato" name="emailDoCandidato" type="email" placeholder="exemplo@exemplo.com" onchange="changeError(name)" onkeyup="validarEspecifico(name)" required value="<?php echo valida($entrada, 'fld_7868662'); ?>" readonly />
            <!-- deixando esse campo desabilitado para edição, se quiser mudar é necessário um novo cadastro -->
        </div>
    </div>

    <!-- Se estiver pendente e não tiver enviado recurso ainda -->
    <?php if (($statusFormInstituicao == "pendente") && (strlen(valida($entrada, 'fld_223413')) < 1)) : ?>
        <button id="recurso-btn" class="br-button secondary" type="button" onclick="botaoRecurso();">
            Enviar mensagem para Avaliador?
        </button>

        <div id="recurso-div" class="br-textarea mb-3" style="display:none">
            <label for="recursoInstituicao">Insira a mensagem para enviar ao Avaliador</label>
            <textarea class="textarea-start-size" name="recursoInstituicao" placeholder="Mensagem para enviar ao Avaliador" maxlength="800"></textarea>
            <?php if ($statusFormInstituicao == "pendente") : ?>
                <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Se já tiver apresentado recurso -->
    <?php if (strlen(valida($entrada, 'fld_223413')) > 1) : ?>

        <h4>Mensagem para Avaliador</h4>

        <div class="br-textarea mb-3">
            <label for="historicoRecursoInstituicao">Histórico da mensagem</label>
            <textarea class="textarea-start-size disabled" id="historicoRecursoInstituicao" name="historicoRecursoInstituicao" placeholder="Não há histórico da mensagem" readonly value="<?php echo valida($entrada, 'fld_299311'); ?>"><?php echo valida($entrada, 'fld_299311'); ?></textarea>
        </div>

        <div class="br-textarea mb-3">
            <label for="recursoInstituicao">Mensagem</label>
            <textarea class="textarea-start-size" id="recursoInstituicao" name="recursoInstituicao" placeholder="Mensagem para enviar ao Avaliador" maxlength="800" value="<?php echo valida($entrada, 'fld_223413'); ?>" <?php echo $disabled ?>><?php echo valida($entrada, 'fld_223413'); ?></textarea>
            <?php if ($statusFormInstituicao == "pendente") : ?>
                <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php
}


function candidato_avaliacao_redes_render($rede_nome, $entrada)
{
?>
    <!-- condição falsa só pra guardar esse código -->
    <?php if (false) : ?>
        <div class="collapse-example">
            <div class="br-list" role="list" data-sub="data-sub">
                <div class="align-items-center br-item" role="listitem" tabindex="0" data-toggle="collapse" data-target="c-l1">
                    <div class="content">
                        <div class="flex-fill"><label>Histórico do parecer da rede</label></div><i class="fas fa-angle-down" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="br-list" id="c-l1" role="list" hidden="hidden" data-sub="data-sub">
                    <div class="br-textarea mb-3">
                        <textarea class="textarea-start-size" name="historicoParecer_<?php echo $rede_nome; ?>" value="<?php echo valida($entrada, 'fld_6135036'); ?>" disabled><?php echo valida($entrada, 'fld_6135036'); ?></textarea>
                    </div>
                </div>
                <div class="align-items-center br-item" role="listitem" tabindex="0" data-toggle="collapse" data-target="c-l2">
                    <div class="content">
                        <div class="flex-fill"><label>Parecer da rede</label></div><i class="fas fa-angle-down" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="br-list" id="c-l2" role="list" hidden="hidden" data-sub="data-sub">
                    <div class="br-textarea mb-3">
                        <textarea class="textarea-start-size" name="parecerAvaliador_<?php echo $rede_nome; ?>" value="<?php echo valida($entrada, 'fld_5960872'); ?>" disabled><?php echo valida($entrada, 'fld_5960872'); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

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

function relaciona_status($s)
{
    switch ($s) {
        case "pendente":
            return 'Ajustes necessários';
        case "homologado":
            return 'Homologado';
    }
}


function update_entrada_form_candidato($entrada, $nomeDaInstituicao, $descricaoDaInstituicao, $natureza_op, $porte_op, $cnpjDaInstituicao, $CNAEDaInstituicao, $urlDaInstituicao, $enderecoDaInstituicao, $complementoDaInstituicao, $estadoDaInstituicao, $cidadeDaInstituicao, $cepDaInstituicao, $doc1UnidadeUrl, $doc2UnidadeUrl, $nomeDoCandidato, $recursoInstituicao, $historicoRecursoInstituicao, $status = "avaliacao")
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

    // Caldera_Forms_Entry_Update::update_field_value('fld_4891375', $entrada, $redes);

    Caldera_Forms_Entry_Update::update_field_value('fld_5438248', $entrada, $doc1UnidadeUrl);
    Caldera_Forms_Entry_Update::update_field_value('fld_9588438', $entrada, $doc2UnidadeUrl);

    Caldera_Forms_Entry_Update::update_field_value('fld_1333267', $entrada, $nomeDoCandidato);
    //Caldera_Forms_Entry_Update::update_field_value('fld_7868662', $entrada, $emailDoCandidato);

    Caldera_Forms_Entry_Update::update_field_value('fld_4899711', $entrada, $status);

    Caldera_Forms_Entry_Update::update_field_value('fld_223413', $entrada, $recursoInstituicao);
    //Campo: campo_extra1
    Caldera_Forms_Entry_Update::update_field_value('fld_299311', $entrada, $historicoRecursoInstituicao);
}

function update_entrada_form_especifico_candidato($entrada, $dados_redes, $flag = "true", $status = "avaliacao")
{
    /*
	* Função para atualizar uma nova entrada em um Caldera Forms
    * Usado para os forms específicos de cada rede 
	*/

    if ($flag == "false") {
        foreach ($dados_redes as $key => $value) {
            $dados_redes[$key] = "";
        }
        $status = "pendente";
    }

    Caldera_Forms_Entry_Update::update_field_value('fld_605717', $entrada, $dados_redes["urlServico"]);
    Caldera_Forms_Entry_Update::update_field_value('fld_4486725', $entrada, $dados_redes["produtoServicos"]);

    Caldera_Forms_Entry_Update::update_field_value('fld_8777940', $entrada, $dados_redes["classificacoes"]);
    Caldera_Forms_Entry_Update::update_field_value('fld_6678080', $entrada, $dados_redes["outroClassificacao"]);

    Caldera_Forms_Entry_Update::update_field_value('fld_4665383', $entrada, $dados_redes["publicos"]);
    Caldera_Forms_Entry_Update::update_field_value('fld_2391778', $entrada, $dados_redes["abrangencias"]);

    Caldera_Forms_Entry_Update::update_field_value('fld_6140408', $entrada, $dados_redes["nomeCompleto"]);
    // campo_extra3
    Caldera_Forms_Entry_Update::update_field_value('fld_2025685', $entrada, $dados_redes["cpfRepresentante"]);
    Caldera_Forms_Entry_Update::update_field_value('fld_7130000', $entrada, $dados_redes["emailRepresentante"]);
    Caldera_Forms_Entry_Update::update_field_value('fld_5051662', $entrada, $dados_redes["telefoneRepresentante"]);

    Caldera_Forms_Entry_Update::update_field_value('fld_3707629', $entrada, $status);

    // campo_extra4
    Caldera_Forms_Entry_Update::update_field_value('fld_4663810', $entrada, $flag);

    //$versaoOld = valida($entrada, 'fld_2402818');
    //Caldera_Forms_Entry_Update::update_field_value('fld_2402818', $entrada, $versao);
}

function atualiza_geral_candidato_ajax()
{
    // $usuario_id = (isset($_POST['usuario_id'])) ? $_POST['usuario_id'] : '';
    $entrada = (isset($_POST['entrada'])) ? $_POST['entrada'] : '';

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

    //pego o valor para mandar apagar
    if (isset($_POST['doc1'])) $doc1UnidadeUrl = ($_POST['doc1']);
    else $doc1UnidadeUrl = "";
    if (isset($_POST['doc2'])) $doc2UnidadeUrl = ($_POST['doc2']);
    else $doc2UnidadeUrl = "";

    //doc1
    if (isset($_FILES['logo_instituicao']) && strlen($_FILES['logo_instituicao']['name']) > 0) {
        $doc1Unidade = $_FILES['logo_instituicao'];
    }
    //doc2
    if (isset($_FILES['guia_instituicao']) && strlen($_FILES['guia_instituicao']['name']) > 0) {
        $doc2Unidade = $_FILES['guia_instituicao'];
    }

    //Nome e email do candidato
    if (isset($_POST['nomeDoCandidato'])) $nomeDoCandidato = ($_POST['nomeDoCandidato']);
    else $nomeDoCandidato = "";
    if (isset($_POST['emailDoCandidato'])) $emailDoCandidato = ($_POST['emailDoCandidato']);
    else $emailDoCandidato = "";

    if (!is_null($doc1Unidade)) {
        $id = attachment_url_to_postid($doc1UnidadeUrl);
        wp_delete_attachment($id);
        $doc1UnidadeUrl = upload_documento($doc1Unidade, $emailDoCandidato, "1");
    }
    if (!is_null($doc2Unidade)) {
        $id = attachment_url_to_postid($doc2UnidadeUrl);
        wp_delete_attachment($id);
        $doc2UnidadeUrl = upload_documento($doc2Unidade, $emailDoCandidato, "2");
    }

    //Histórico do recurso
    if (isset($_POST['historicoRecursoInstituicao'])) $historicoRecursoInstituicao = (trim($_POST['historicoRecursoInstituicao']));
    else $historicoRecursoInstituicao = "";

    if (isset($_POST['recursoInstituicao'])) $recursoInstituicao = ($_POST['recursoInstituicao']);
    else $recursoInstituicao = "";

    // apenas se tiver recurso escrito
    if (strlen($recursoInstituicao) > 1) {
        //Adicionando o recurso ao histórico:
        date_default_timezone_set('America/Sao_Paulo');
        $date = date('d/m/Y h:i:sa', time());

        // se já houver alguma coisa, acrescenta um \n
        if (strlen($historicoRecursoInstituicao) > 1)
            $historicoRecursoInstituicao .= "\n\n";

        $historicoRecursoInstituicao .= "Mensagem enviada em " . $date . ":\n" . $recursoInstituicao;
    }

    //funcao para criar a entrada no Caldera (Form geral)
    update_entrada_form_candidato($entrada, $nomeDaInstituicao, $descricaoDaInstituicao, $natureza_op, $porte_op, $cnpjDaInstituicao, $CNAEDaInstituicao, $urlDaInstituicao, $enderecoDaInstituicao, $complementoDaInstituicao, $estadoDaInstituicao, $cidadeDaInstituicao, $cepDaInstituicao, $doc1UnidadeUrl, $doc2UnidadeUrl, $nomeDoCandidato, $recursoInstituicao, $historicoRecursoInstituicao, "avaliacao");

    //TODO envia email de update

    $form = Caldera_Forms_Forms::get_form(FORM_ID_GERAL);
    $entry =  new Caldera_Forms_Entry($form, $entrada);

    // renderiza novamente para o candidato
    render_geral_data($entry);

    die();
}
add_action('wp_ajax_atualiza_geral_candidato', 'atualiza_geral_candidato_ajax');
add_action('wp_ajax_nopriv_atualiza_geral_candidato', 'atualiza_geral_candidato_ajax');


function atualiza_rede_candidato_ajax()
{
    // $usuario_id = (isset($_POST['usuario_id'])) ? $_POST['usuario_id'] : '';
    $entrada = (isset($_POST['entrada'])) ? $_POST['entrada'] : '';
    $rede = (isset($_POST['rede'])) ? $_POST['rede'] : '';
    $elements = (isset($_POST['elements'])) ? $_POST['elements'] : '';

    //crio o array apenas para a rede que eu quero
    $dados_redes = array(relaciona($rede)[0] => array());

    foreach ($dados_redes as $key => $value) {
        $opcoes = get_options($key)[1];
        $publico = get_options($key)[2];
        $abrangencia = get_options($key)[3];

        if (isset($elements['urlServico-' . $key])) $dados_redes[$key]["urlServico"] = ($elements['urlServico-' . $key]);
        else $dados_redes[$key]["urlServico"] = "";
        if (isset($elements['produtoServicos-' . $key])) $dados_redes[$key]["produtoServicos"] = ($elements['produtoServicos-' . $key]);
        else $dados_redes[$key]["produtoServicos"] = "";

        //Pegando os checks das classificacoes
        $classificacoes = "";
        foreach ($opcoes as $i => $v) {
            if (isset($elements['check_classificacao_' . $i . '_' . $key])) $classificacoes .= $elements['check_classificacao_' . $i . '_' . $key] . ";";
        }
        $dados_redes[$key]['classificacoes'] = $classificacoes;

        if (isset($elements['outroClassificacao_' . $key])) $dados_redes[$key]["outroClassificacao"] = ($elements['outroClassificacao_' . $key]);
        else $dados_redes[$key]["outroClassificacao"] = "";


        if (!str_contains($classificacoes, 'Outro;')) {
            $dados_redes[$key]["outroClassificacao"] = '';
        }

        //Pegando os checks do publico alvo
        $publicos = "";
        foreach ($publico as $i => $v) {
            if (isset($elements['check_publico_' . $i . '_' . $key])) $publicos .= $elements['check_publico_' . $i . '_' . $key] . ";";
        }
        $dados_redes[$key]['publicos'] = $publicos;

        //Pegando os checks da abrangencia
        $abrangencias = "";
        foreach ($abrangencia as $i => $v) {
            if (isset($elements['check_abrangencia_' . $i . '_' . $key])) $abrangencias .= $elements['check_abrangencia_' . $i . '_' . $key] . ";";
        }
        $dados_redes[$key]['abrangencias'] = $abrangencias;

        //dados do representante
        if (isset($elements['nomeCompleto_' . $key])) $dados_redes[$key]["nomeCompleto"] = ($elements['nomeCompleto_' . $key]);
        else $dados_redes[$key]["nomeCompleto"] = "";
        if (isset($elements['cpfRepresentante_' . $key])) $dados_redes[$key]["cpfRepresentante"] = ($elements['cpfRepresentante_' . $key]);
        else $dados_redes[$key]["cpfRepresentante"] = "";
        if (isset($elements['emailRepresentante_' . $key])) $dados_redes[$key]["emailRepresentante"] = ($elements['emailRepresentante_' . $key]);
        else $dados_redes[$key]["emailRepresentante"] = "";
        if (isset($elements['telefoneRepresentante_' . $key])) $dados_redes[$key]["telefoneRepresentante"] = ($elements['telefoneRepresentante_' . $key]);
        else $dados_redes[$key]["telefoneRepresentante"] = "";
    }

    // faz o update dos dados no caldera
    update_entrada_form_especifico_candidato($entrada, $dados_redes[relaciona($rede)[0]], "true", "avaliacao");

    //TODO envia email de update

    $form_id = relaciona($rede)[1];
    $form = Caldera_Forms_Forms::get_form($form_id);
    $entry =  new Caldera_Forms_Entry($form, $entrada);

    // renderiza novamente para o candidato
    cadastro_redes_render(relaciona($rede)[0], $entry);

    die();
}
add_action('wp_ajax_atualiza_rede_candidato', 'atualiza_rede_candidato_ajax');
add_action('wp_ajax_nopriv_atualiza_rede_candidato', 'atualiza_rede_candidato_ajax');


function carrega_estado_cidade_selecionado($estadoSelecionado = '', $cidadeSelecionada = '')
{
    global $wpdb;
    $sql = "SELECT codigo_uf, nome FROM " . $wpdb->prefix . "tematorre_estados order by nome;";
    $estados = $wpdb->get_results($sql);

    $checked = "";
    $codigoEstadoSelecionado = "";

    echo '<div class="row">';
    echo '<div class="col-md-6">';
    echo '<div class="br-select max-width-torre">';
    echo '<div class="br-input">';
    echo '<label for="estadoDaInstituicao">Estado<span class="field_required" style="color:#ee0000;">*</span></label>';
    echo '<input id="estadoDaInstituicao" name="estadoDaInstituicao" type="text" placeholder="Selecione o estado" onfocus="changeError(name)" required />';
    echo '<button class="br-button" type="button" aria-label="Exibir lista" tabindex="-1" data-trigger="data-trigger"><i class="fas fa-angle-down" aria-hidden="true"></i>';
    echo '</button>';
    echo '</div>';

    echo '<div class="br-list" tabindex="0">';

    if (!empty($estados)) {
        foreach ($estados as $item) {

            if ($item->nome == $estadoSelecionado) {
                $checked = "checked";
                $codigoEstadoSelecionado = $item->codigo_uf;
            } else {
                $checked = "";
            }

            echo '<div class="br-item" tabindex="-1">';
            echo '<div class="br-radio">';
            echo '<input id="' . $item->codigo_uf . '" type="radio" name="estados-simples" onchange="carregaCidade(id)" value="' . $item->nome . '" ' . $checked . '/>';
            echo '<label for="' . $item->codigo_uf . '">' . $item->nome . '</label>';
            echo '</div></div>';
        }
    } else {
        echo '<option value="">Estado não disponível</option>';
    }
    echo '</div>';
    echo '</div>'; // div br-select
    echo '</div>'; // div col-md-6

    echo '<div class="col-md-6">';
    echo carrega_selects_cidades($codigoEstadoSelecionado, $cidadeSelecionada);

    //Esse input que realmente guarda o valor da cidadeDaInstituicao
    echo '<div class="br-input">';
    echo '<input id="cidadeDaInstituicao" name="cidadeDaInstituicao" value="' . $cidadeSelecionada . '" type="hidden" />';
    echo '</div>';
    echo '</div>'; // div col-md-6
    echo '</div>'; // div row
}


function atualiza_status_geral_ajax()
{

    $form_ids = array(FORM_ID_GERAL, FORM_ID_SUPORTE, FORM_ID_FORMACAO, FORM_ID_PESQUISA, FORM_ID_INOVACAO, FORM_ID_TECNOLOGIA);
    $current_user = wp_get_current_user();
    $usuario_id = $current_user->ID;

    // para teste estou usando um usuário meu aqui
    $usuario_id = USER_TESTE;

    $entradas = array();
    $entradas_id = array();

    foreach ($form_ids as $form_id) {
        $data = Caldera_Forms_Admin::get_entries($form_id, 1, 9999999);
        $ativos = $data['active'];

        if ($ativos > 0) {
            $todasEntradas = $data['entries'];

            foreach ($todasEntradas as $umaEntrada) {
                $user_id = $umaEntrada['user']['ID'];

                if ($user_id == $usuario_id) {
                    $entrada = $umaEntrada['_entry_id'];
                    $entradas_id[$form_id] = $entrada; //novo array para guardar as entry_id
                    $form = Caldera_Forms_Forms::get_form($form_id);
                    $entradas[$form_id] = new Caldera_Forms_Entry($form, $entrada);
                    break;
                }
            }
        }
    }

    //$redes = valida($entradas[FORM_ID_GERAL], 'fld_4891375');
    //$arrayRedes = explode(";", $redes);
    $todas_redes = "check_suporte;check_formacao;check_pesquisa;check_inovacao;check_tecnologia;";
    $arrayRedes = explode(";", $todas_redes);

    // guardar todos os status e aí ver no final 
    $status = array();
    $redes = "";

    // pega status aba instituição
    $status[] = valida($entradas[FORM_ID_GERAL], 'fld_4899711');
    //echo '$situacaoGeral '. valida($entradas[FORM_ID_GERAL], 'fld_4899711') .'<br>';

    foreach ($arrayRedes as $rede) {
        if (valida($entradas[relaciona($rede)[1]], 'fld_4663810') == "true") {
            $status[] = valida($entradas[relaciona($rede)[1]], 'fld_3707629');
            //echo '$statusRede '. valida($entradas[relaciona($rede)[1]], 'fld_3707629') .'<br>';
            $redes .= $rede . ";";
        } 
    }

    $situacaoGeral = '';
    if (in_array("pendente", $status)) {
        $situacaoGeral = "pendente";
    } else if (in_array("avaliacao", $status)) {
        $situacaoGeral = "avaliacao";
    } else {
        $situacaoGeral = "homologado";
    }

    // Chama o update no campo geral de stats
    Caldera_Forms_Entry_Update::update_field_value('fld_9748069', $entradas_id[FORM_ID_GERAL], $situacaoGeral);
    Caldera_Forms_Entry_Update::update_field_value('fld_4891375', $entradas_id[FORM_ID_GERAL], $redes);

    // Chama a função de renderizar
    render_status($situacaoGeral);

    die();
}
add_action('wp_ajax_atualiza_status_geral', 'atualiza_status_geral_ajax');
add_action('wp_ajax_nopriv_atualiza_status_geral', 'atualiza_status_geral_ajax');

function exclui_rede_candidato_ajax()
{
    // $usuario_id = (isset($_POST['usuario_id'])) ? $_POST['usuario_id'] : '';
    $entrada = (isset($_POST['entrada'])) ? $_POST['entrada'] : '';
    $rede = (isset($_POST['rede'])) ? $_POST['rede'] : '';

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

    // faz o update dos dados no caldera
    update_entrada_form_especifico_candidato($entrada, $dados_redes, "false");

    //TODO envia email de update

    $form_id = relaciona($rede)[1];
    $form = Caldera_Forms_Forms::get_form($form_id);
    $entry =  new Caldera_Forms_Entry($form, $entrada);

    // renderiza novamente para o candidato
    cadastro_redes_render(relaciona($rede)[0], $entry);

    die();
}
add_action('wp_ajax_exclui_rede_candidato', 'exclui_rede_candidato_ajax');
add_action('wp_ajax_nopriv_exclui_rede_candidato', 'exclui_rede_candidato_ajax');


function desistir_candidato()
{
    $usuario_id = (isset($_POST['usuario_id'])) ? $_POST['usuario_id'] : '';

    //Fazer o for dos forms
    $form_ids = array(FORM_ID_GERAL, FORM_ID_SUPORTE, FORM_ID_FORMACAO, FORM_ID_PESQUISA, FORM_ID_INOVACAO, FORM_ID_TECNOLOGIA);
    //para guardar as entradas para depois pegar com o valida alguns dados
    $entradas = array();
    //para usar no delete
    $entradas_id = array();

    foreach ($form_ids as $form_id) {
        $data = Caldera_Forms_Admin::get_entries($form_id, 1, 9999999);
        $ativos = $data['active'];

        if ($ativos > 0) {
            $todasEntradas = $data['entries'];

            foreach ($todasEntradas as $umaEntrada) {
                $user_id = $umaEntrada['user']['ID'];

                if ($user_id == $usuario_id) {

                    $entrada = $umaEntrada['_entry_id'];
                    $entradas_id[$form_id] = $entrada; //novo array para guardar as entry_id
                    $form = Caldera_Forms_Forms::get_form($form_id);
                    $entradas[$form_id] = new Caldera_Forms_Entry($form, $entrada);
                    break;
                }
            }
        }
    }
    //coletando os dados da instituição e do candidato para uso no email:
    $nomeInstituição = valida($entradas[FORM_ID_GERAL], 'fld_266564');
    $nomeDoCandidato = valida($entradas[FORM_ID_GERAL], 'fld_1333267');
    $emailDoCandidato = valida($entradas[FORM_ID_GERAL], 'fld_7868662');
    $doc1UnidadeUrl = valida($entradas[FORM_ID_GERAL], 'fld_5438248');
    $doc2UnidadeUrl = valida($entradas[FORM_ID_GERAL], 'fld_9588438');

    //Apagando as entradas:
    foreach ($entradas_id as $key => $value) {
        Caldera_Forms_Entry_Bulk::delete_entries(array($value));
    }

    //Mandar apagar anexos
    if ($doc1UnidadeUrl != "") {
        $id = attachment_url_to_postid($doc1UnidadeUrl);
        wp_delete_attachment($id);
    }
    if ($doc2UnidadeUrl != "") {
        $id = attachment_url_to_postid($doc2UnidadeUrl);
        wp_delete_attachment($id);
    }
    //Apagar usuário

    //$user = get_user_by('id', $usuario_id);
    //$user_info = get_userdata($usuario_id);
    //$user_name = $user_info->display_name;
    //$user_email = $user_info->user_email;
    wp_delete_user($usuario_id);
    wp_logout(); //TODO testar o delete com usuário realmente logado

    //Enviar um email que o usuário foi apagado
    envia_email('desistir', $nomeInstituição, $emailDoCandidato);
    //TODO email para o avaliador

    //Enviando pra index
    wp_redirect(home_url());
}
add_action('admin_post_nopriv_desistir_candidato', 'desistir_candidato');
add_action('admin_post_desistir_candidato', 'desistir_candidato');
