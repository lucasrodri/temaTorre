<?php

/*
* Shortcode para renderizar o formulário de início
*/

add_shortcode('shortcode_form_usuario', 'cadastro_form_usuario');

function cadastro_form_usuario()
{
    cadastro_form_render();
}

function cadastro_form_render()
{
?>
    <form class="card" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <div id="cadastro_wizard" class="col-md-12 mb-5">
                <div class="br-wizard" collapsed="collapsed" step="1">
                    <div class="wizard-progress">
                        <button id="cadastro_wizard_b1" class="wizard-progress-btn" type="button" title="Termo de Declaração" active="active"><span class="info">Termo de Declaração</span></button>
                        <button id="cadastro_wizard_b2" class="wizard-progress-btn" type="button" title="Instituição" disabled="disabled"><span class="info">Instituição</span></button>
                        <button id="cadastro_wizard_b3" class="wizard-progress-btn" type="button" title="Redes" disabled="disabled"><span class="info">Redes</span></button>
                        <button id="cadastro_wizard_b4" class="wizard-progress-btn" type="button" title="Logo e Guia de Uso de Marca" disabled="disabled"><span class="info">Logo e Guia de Uso de Marca</span></button>
                        <button id="cadastro_wizard_b5" class="wizard-progress-btn" type="button" title="Finalização" active="active"><span class="info">Finalização</span></button>
                    </div>
                    <div class="wizard-form">
                        <div class="wizard-panel" active="active">
                            <div class="wizard-panel-content">
                                <div class="h3">Termo de Declaração</div>
                                <div class="text my-text-wizard" tabindex="0">
                                    Em observância à Lei nº. 13.709/18 – Lei Geral de Proteção de Dados Pessoais e demais normativas aplicáveis sobre proteção de Dados Pessoais, manifesto-me de forma informada, livre, expressa e consciente, no sentido de autorizar a tomada de decisão sobre tratamento de meus dados pessoais para as finalidades e de acordo com as condições aqui estabelecidas.

                                    Declaro também que as informações prestadas são de minha inteira responsabilidade, e que a falsidade nas informações fornecidas implicará nas penalidades cabíveis, no âmbito penal, cível e administrativo.
                                </div>
                                <div class="mt-3 mb-1" name="checkConcordo">
                                    <div class="br-checkbox">
                                        <input id="checkConcordo" name="checkConcordo" class="checkConcordo" type="checkbox" aria-label="Concordo com esses termos" onchange="changeErrorRadio(name)" />
                                        <label for="checkConcordo">Concordo com esses termos</label>
                                        <br>
                                    </div>

                                    <!-- <span id="checkConcordo_label" class="feedback danger" role="alert" style="display: none;"><i class="fas fa-times-circle" aria-hidden="true"></i>Preenchimento obrigatório</span> -->
                                </div>

                            </div>
                            <div class="wizard-panel-btn">
                                <div class="row">
                                    <div class="col-md-12 align-button-center">
                                        <button id="cadastro_btn_1" class="br-button primary wizard-btn" type="button">Avançar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-panel">
                            <div class="wizard-panel-content">
                                <div class="h3">TORRE MCTI</div>
                                <div class="text my-text-wizard" tabindex="0">
                                    <p>Este formulário tem por finalidade levantar informações sobre os serviços oferecidos, público-alvo e contato para compor as redes da Torre do MCTI. Destina-se aos responsáveis pela consolidação das informações do Ministério da Ciência, Tecnologia e Inovações (MCTI) e suas vinculadas, subordinadas e supervisionadas.</p>
                                    <h3>Instituição</h3>
                                    <div class="mb-3">
                                        <div class="br-input">
                                            <label for="nomeDaInstituicao">Nome<span class="field_required" style="color:#ee0000;">*</span></label>
                                            <input id="nomeDaInstituicao" name="nomeDaInstituicao" type="text" placeholder="Nome da Instituição" onchange="changeError(name)" required />
                                        </div>
                                    </div>

                                    <div class="br-textarea mb-3">
                                        <label for="descricaoDaInstituicao">Descrição da instituição<span class="field_required" style="color:#ee0000;">*</span></label>
                                        <textarea class="textarea-start-size" id="descricaoDaInstituicao" name="descricaoDaInstituicao" placeholder="Escreva a descrição de sua instituição" maxlength="800" onchange="changeError(name)" required></textarea>
                                        <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
                                    </div>

                                    <div class="mb-3 radio-master">
                                        <p class="label mb-3">Natureza jurídica da instituição<span class="field_required" style="color:#ee0000;">*</span></p>
                                        <div class="br-radio">
                                            <input id="natureza_op_1" type="radio" name="natureza_op" class="natureza_op" value="Instituição pública federal" onchange="changeErrorRadio(name)" />
                                            <label for="natureza_op_1">Instituição pública federal</label>
                                        </div>
                                        <div class="br-radio">
                                            <input id="natureza_op_2" type="radio" name="natureza_op" class="natureza_op" value="Instituição pública estadual" onchange="changeErrorRadio(name)" />
                                            <label for="natureza_op_2">Instituição pública estadual</label>
                                        </div>
                                        <div class="br-radio">
                                            <input id="natureza_op_3" type="radio" name="natureza_op" class="natureza_op" value="Instituição pública municipal" onchange="changeErrorRadio(name)" />
                                            <label for="natureza_op_3">Instituição pública municipal</label>
                                        </div>
                                        <div class="br-radio">
                                            <input id="natureza_op_4" type="radio" name="natureza_op" class="natureza_op" value="Instituição privada com fins lucrativos" onchange="changeErrorRadio(name)" />
                                            <label for="natureza_op_4">Instituição privada com fins lucrativos</label>
                                        </div>
                                        <div class="br-radio">
                                            <input id="natureza_op_5" type="radio" name="natureza_op" class="natureza_op" value="Instituição privada sem fins lucrativos" onchange="changeErrorRadio(name)" />
                                            <label for="natureza_op_5">Instituição privada sem fins lucrativos</label>
                                            <br>
                                        </div>
                                    </div>

                                    <div class="mb-3 radio-slave" style="display:none;" ;>
                                        <p class="label mb-3">Porte da instituição privada<span class="field_required" style="color:#ee0000;">*</span></p>
                                        <div class="br-radio">
                                            <input id="porte_op_1" type="radio" name="porte_op" class="porte_op" value="Porte I – Microempresa e Empresa de Pequeno Porte (EPP): Receita Operacional Bruta anual ou anualizada de até R$ 4,8 milhões" onchange="changeErrorRadio(name)" />
                                            <label for="porte_op_1">Porte I – Microempresa e Empresa de Pequeno Porte (EPP): Receita Operacional Bruta anual ou anualizada de até R$ 4,8 milhões</label>
                                        </div>
                                        <div class="br-radio">
                                            <input id="porte_op_2" type="radio" name="porte_op" class="porte_op" value="Porte II – Pequena Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 4,8 milhões e igual ou inferior a R$ 16,0 milhões" onchange="changeErrorRadio(name)" />
                                            <label for="porte_op_2">Porte II – Pequena Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 4,8 milhões e igual ou inferior a R$ 16,0 milhões</label>
                                        </div>
                                        <div class="br-radio">
                                            <input id="porte_op_3" type="radio" name="porte_op" class="porte_op" value="Porte III – Média Empresa I: Receita Operacional Bruta anual ou anualizada superior a R$ 16,0 milhões e igual ou inferior a R$ 90,0 milhões" onchange="changeErrorRadio(name)" />
                                            <label for="porte_op_3">Porte III – Média Empresa I: Receita Operacional Bruta anual ou anualizada superior a R$ 16,0 milhões e igual ou inferior a R$ 90,0 milhões</label>
                                        </div>
                                        <div class="br-radio">
                                            <input id="porte_op_4" type="radio" name="porte_op" class="porte_op" value="orte IV – Média Empresa II: Receita Operacional Bruta anual ou anualizada superior a R$ 90,0 milhões e igual ou inferior a R$ 300,0 milhões" onchange="changeErrorRadio(name)" />
                                            <label for="porte_op_4">Porte IV – Média Empresa II: Receita Operacional Bruta anual ou anualizada superior a R$ 90,0 milhões e igual ou inferior a R$ 300,0 milhões</label>
                                        </div>
                                        <div class="br-radio">
                                            <input id="porte_op_5" type="radio" name="porte_op" class="porte_op" value="Porte V – Grande Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 300,0 milhões" onchange="changeErrorRadio(name)" />
                                            <label for="porte_op_5">Porte V – Grande Empresa: Receita Operacional Bruta anual ou anualizada superior a R$ 300,0 milhões</label>
                                            <br>
                                        </div>
                                    </div>

                                    <div class="mt-3 mb-3">
                                        <div class="br-input">
                                            <label for="cnpjDaInstituicao">CNPJ<span class="field_required" style="color:#ee0000;">*</span></label>
                                            <input id="cnpjDaInstituicao" name="cnpjDaInstituicao" type="text" placeholder="99.999.999/9999-99" onchange="changeError(name)" onkeyup="validarEspecifico(name)" required />
                                        </div>
                                    </div>

                                    <div class="br-textarea mb-3">
                                        <label for="CNAEDaInstituicao">CNAE<span class="field_required" style="color:#ee0000;">*</span></label>
                                        <textarea class="textarea-start-size" id="CNAEDaInstituicao" name="CNAEDaInstituicao" placeholder="Escreva sobre o CNAE de sua instituição" maxlength="800" onchange="changeError(name)" required></textarea>
                                        <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
                                    </div>

                                    <div class="mt-3 mb-3">
                                        <div class="br-input">
                                            <label for="urlDaInstituicao">Página da internet<span class="field_required" style="color:#ee0000;">*</span></label>
                                            <input id="urlDaInstituicao" name="urlDaInstituicao" type="url" placeholder="http://minhainstituicao.com.br" onchange="changeError(name)" onkeyup="validarEspecifico(name)" required />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="wizard-panel-btn">
                                <div class="row">
                                    <div class="col-md-6 align-button-right">
                                        <button id="cadastro_btn_volta_1" class="br-button secondary wizard-btn-prev" type="button">Voltar
                                        </button>
                                    </div>
                                    <div class="col-md-6 align-button-left">
                                        <button id="cadastro_btn_2" class="br-button primary wizard-btn" type="button">Avançar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-panel">
                            <div class="wizard-panel-content">
                                <div class="h3">Redes</div>
                                <div class="text my-text-wizard" tabindex="0">Redes às quais pretende se cadastrar e informações para publicação</div>

                                <div class="mt-3 mb-1 check-master">
                                    <div class="br-checkbox">
                                        <input id="check_suporte" value="check_suporte" name="check_suporte" class="check_redes" type="checkbox" aria-label="Rede de Suporte" onchange="changeErrorCheck(name)" />
                                        <label for="check_suporte">Rede de Suporte - apoio aos atores do ecossistema de inovação e as atividades da Torre MCTI em todas as etapas do desenvolvimento de produtos e serviços inovadores</label>
                                    </div>
                                    <div class="br-checkbox">
                                        <input id="check_formacao" value="check_formacao" name="check_formacao" class="check_redes" type="checkbox" aria-label="Rede de Formação" onchange="changeErrorCheck(name)" />
                                        <label for="check_formacao">Rede de Formação Tecnológica - capacitação em ciência, tecnologia e inovação, com intuito de expandir e melhorar a formação profissional e tecnológica</label>
                                    </div>
                                    <div class="br-checkbox">
                                        <input id="check_pesquisa" value="check_pesquisa" name="check_pesquisa" class="check_redes" type="checkbox" aria-label="Rede de Pesquisa" onchange="changeErrorCheck(name)" />
                                        <label for="check_pesquisa">Rede de Pesquisa Aplicada - utilização do conhecimento científico gerado na pesquisa básica, para apoiar o desenvolvimento de inovações, produtos e serviços, por meio da concepção de aplicações e provas de conceito</label>
                                    </div>
                                    <div class="br-checkbox">
                                        <input id="check_inovacao" value="check_inovacao" name="check_inovacao" class="check_redes" type="checkbox" aria-label="Rede de inovacao" onchange="changeErrorCheck(name)" />
                                        <label for="check_inovacao">Rede de Inovação - transformação de ideias em protótipos, materializando o conhecimento científico validado em soluções concretas experimentais</label>
                                    </div>
                                    <div class="br-checkbox">
                                        <input id="check_tecnologia" value="check_tecnologia" name="check_tecnologia" class="check_redes" type="checkbox" aria-label="Rede de tecnologia" onchange="changeErrorCheck(name)" />
                                        <label for="check_tecnologia">Tecnologias Aplicadas - transformação de protótipos em produtos e riquezas, com o objetivo de aperfeiçoar soluções experimentais tornando-as aptas ao mercado, à geração de riqueza e à contribuição para a qualidade de vida dos brasileiros</label>
                                    </div>
                                </div>

                                <div id='redes_render_suporte' style="display:none;">
                                    <?php cadastro_redes_render('rede-de-suporte'); ?>
                                </div>
                                <div id='redes_render_formacao' style="display:none;">
                                    <?php cadastro_redes_render('rede-de-formacao'); ?>
                                </div>
                                <div id='redes_render_pesquisa' style="display:none;">
                                    <?php cadastro_redes_render('rede-de-pesquisa'); ?>
                                </div>
                                <div id='redes_render_inovacao' style="display:none;">
                                    <?php cadastro_redes_render('rede-de-inovacao'); ?>
                                </div>
                                <div id='redes_render_tecnologia' style="display:none;">
                                    <?php cadastro_redes_render('rede-de-tecnologia'); ?>
                                </div>

                            </div>
                            <div class="wizard-panel-btn">
                                <div class="row">
                                    <div class="col-md-6 align-button-right">
                                        <button class="br-button secondary wizard-btn-prev" type="button">Voltar
                                        </button>
                                    </div>
                                    <div class="col-md-6 align-button-left">
                                        <button id="cadastro_btn_3" class="br-button primary wizard-btn" type="button">Avançar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-panel">
                            <div class="wizard-panel-content">
                                <div class="h3">Logo e Guia de Uso de Marca</div>
                                <!-- <div class="text my-text-wizard" tabindex="0">Conteúdo aqui</div> -->
                                <div class="mt-3 mb-1 upload-inputs">
                                    <div class="br-upload">
                                        <label class="upload-label" for="logo_instituicao"><span>Logo<span class="field_required" style="color:#ee0000;">*</span></span></label>
                                        <input class="upload-input" id="logo_instituicao" name="logo_instituicao" type="file" accept=".jpg,.png,.jpeg" onchange="changeError(name)" required />
                                        <div class="upload-list"></div>
                                    </div>
                                    <p class="text-base mt-1">Insira a logomarca, de preferência de 450x250 pixels, no formato PNG ou JPG</p>

                                    <div class="br-upload">
                                        <label class="upload-label" for="guia_instituicao"><span>Guia de Uso da Marca<span class="field_required" style="color:#ee0000;">*</span></span></label>
                                        <input class="upload-input" id="guia_instituicao" name="guia_instituicao" type="file" accept=".pdf" onchange="changeError(name)" required />
                                        <div class="upload-list"></div>
                                    </div>
                                    <p class="text-base mt-1">Insira o guia de uso da marca no formato PDF de tamanho máximo 25MB</p>
                                </div>

                            </div>
                            <div class="wizard-panel-btn">
                                <div class="row">
                                    <div class="col-md-6 align-button-right">
                                        <button class="br-button secondary wizard-btn-prev" type="button">Voltar
                                        </button>
                                    </div>
                                    <div class="col-md-6 align-button-left">
                                        <button id="cadastro_btn_4" class="br-button primary wizard-btn" type="button">Avançar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-panel">
                            <div class="wizard-panel-content">
                                <div class="h3">Finalização</div>
                                <div class="text my-text-wizard" tabindex="0">
                                    <p>Agradecemos a submissão da candidatura da instituição.</p>
                                    <p>A instituição poderá ser solicitada a complementar e/ou ajustar as informações.</p>
                                    <p>A candidatura será analisada pelo Comitê Gestor da Torre MCTI.</p>
                                    <p>A homologação ou não do cadastro das instituições interessadas será enviada para o representante legal ou procurador eletrônico da instituição por e-mail. Em caso de homologação, o e-mail apresentará um link para assinatura do Termo de Adesão.</p>
                                </div>

                                <h4>Dados de contato</h4>
                                <p>Informe os dados de contato para receber a cópia dos dados registrados no cadastro das informações da instituição para publicação na Torre MCTI</p>

                                <div class="mb-3">
                                    <div class="br-input">
                                        <label for="nomeDoCandidato">Nome<span class="field_required" style="color:#ee0000;">*</span></label>
                                        <input id="nomeDoCandidato" name="nomeDoCandidato" type="text" placeholder="Nome completo" onchange="changeError(name)" required />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="br-input">
                                        <label for="emailDoCandidato">E-mail<span class="field_required" style="color:#ee0000;">*</span></label>
                                        <input id="emailDoCandidato" name="emailDoCandidato" type="email" placeholder="exemplo@exemplo.com" onchange="changeError(name)" onkeyup="validarEspecifico(name)" required />
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-panel-btn">
                                <div class="row">
                                    <div class="col-md-6 align-button-right">
                                        <button class="br-button secondary wizard-btn-prev" type="button">Voltar
                                        </button>
                                    </div>
                                    <div class="col-md-6 align-button-left">
                                        <input type="submit" class="br-button primary" value="Concluir" name="enviar">
                                        <!-- <div id='loading_submit' class="loading medium" style='display:none;'></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="action" value="cadastro_candidato">
    </form>
<?php
}


function cadastro_redes_render($rede_nome)
{
    $title = get_options($rede_nome)[0];
    $opcoes = get_options($rede_nome)[1];
    $publicos = get_options($rede_nome)[2];
    $abrangencia = get_options($rede_nome)[3];
?>
    <div class="h4"><?php echo $title; ?></div>

    <div class="br-textarea mb-3">
        <label for="urlServico-<?php echo $rede_nome; ?>">URL dos serviços relacionados na rede especificada<span class="field_required" style="color:#ee0000;">*</span></label>
        <textarea class="" id="urlServico-<?php echo $rede_nome; ?>" name="urlServico-<?php echo $rede_nome; ?>" placeholder="Escreva a URL dos serviços" rows="3" onchange="changeError(name)"></textarea>
    </div>

    <div class="br-textarea mb-3">
        <label for="produtoServicos-<?php echo $rede_nome; ?>">Produtos, serviços e/ou ferramentas de CT&I ofertados relacionados à rede selecionada - proposta de valor<span class="field_required" style="color:#ee0000;">*</span></label>
        <textarea class="" id="produtoServicos-<?php echo $rede_nome; ?>" name="produtoServicos-<?php echo $rede_nome; ?>" placeholder="Escreva a URL dos serviços" rows="3" onchange="changeError(name)"></textarea>
    </div>

    <label>Classificação<span class="field_required" style="color:#ee0000;">*</span></label>

    <div class="mt-3 mb-1">
        <?php foreach ($opcoes as $key => $value) { ?>
            <div class="br-checkbox">
                <input id="check_classificacao_<?php echo $key; ?>_<?php echo $rede_nome; ?>" name="check_classificacao_<?php echo $key; ?>_<?php echo $rede_nome; ?>" value="<?php echo $value; ?>" type="checkbox" aria-label="<?php echo $value; ?>" class="check_classificacao_<?php echo $rede_nome; ?>" onchange="changeErrorCheck(name)" <?php if ($key == count($opcoes) - 1) echo 'onclick="controleOutroClassificacao(id)"'; ?> />
                <label for="check_classificacao_<?php echo $key; ?>_<?php echo $rede_nome; ?>"><?php echo $value; ?></label>
                <?php if ($key == count($opcoes) - 1) echo '<br>'; ?>
            </div>
        <?php } ?>
    </div>


    <div class="mb-3">
        <div class="br-input" style="display:none;">
            <label for="outroClassificacao_<?php echo $rede_nome; ?>">Outro<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="outroClassificacao_<?php echo $rede_nome; ?>" name="outroClassificacao_<?php echo $rede_nome; ?>" type="text" placeholder="Outra classificação" onchange="changeError(name)" />
        </div>
    </div>

    <label>Público-Alvo<span class="field_required" style="color:#ee0000;">*</span></label>

    <div class="mt-3 mb-1">
        <?php foreach ($publicos as $key => $value) { ?>
            <div class="br-checkbox">
                <input id="check_publico_<?php echo $key; ?>_<?php echo $rede_nome; ?>" name="check_publico_<?php echo $key; ?>_<?php echo $rede_nome; ?>" value="<?php echo $value; ?>" type="checkbox" aria-label="<?php echo $value; ?>" class="check_publico_<?php echo $rede_nome; ?>" onchange="changeErrorCheck(name)" />
                <label for="check_publico_<?php echo $key; ?>_<?php echo $rede_nome; ?>"><?php echo $value; ?></label>
                <?php if ($key == count($publicos) - 1) echo '<br>'; ?>
            </div>
        <?php } ?>
    </div>

    <label>Abrangência<span class="field_required" style="color:#ee0000;">*</span></label>

    <div class="mt-3 mb-1">
        <?php foreach ($abrangencia as $key => $value) { ?>
            <div class="br-checkbox d-inline">
                <input id="check_abrangencia_<?php echo $key; ?>_<?php echo $rede_nome; ?>" name="check_abrangencia_<?php echo $key; ?>_<?php echo $rede_nome; ?>" value="<?php echo $value; ?>" type="checkbox" aria-label="<?php echo $value; ?>" class="check_abrangencia_<?php echo $rede_nome; ?>" onchange="changeErrorCheck(name)" />
                <label for="check_abrangencia_<?php echo $key; ?>_<?php echo $rede_nome; ?>"><?php echo $value; ?></label>
                <?php if ($key == count($abrangencia) - 1) echo '<br>'; ?>
            </div>
        <?php } ?>
    </div>


    <div class="h5"> Representante da instituição na <?php echo $title; ?></div>


    <div class="mb-3">
        <div class="br-input">
            <label for="nomeCompleto_<?php echo $rede_nome; ?>">Nome completo<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="nomeCompleto_<?php echo $rede_nome; ?>" name="nomeCompleto_<?php echo $rede_nome; ?>" type="text" placeholder="Nome completo" onchange="changeError(name)" />
        </div>
    </div>

    <div class="mb-3">
        <div class="br-input">
            <label for="emailRepresentante_<?php echo $rede_nome; ?>">E-mail<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="emailRepresentante_<?php echo $rede_nome; ?>" name="emailRepresentante_<?php echo $rede_nome; ?>" type="email" placeholder="exemplo@exemplo.com" onchange="changeError(name)" onkeyup="validarEspecifico(name)" />
        </div>
    </div>

    <div class="mb-3">
        <div class="br-input">
            <label for="telefoneRepresentante_<?php echo $rede_nome; ?>">Telefone<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="telefoneRepresentante_<?php echo $rede_nome; ?>" name="telefoneRepresentante_<?php echo $rede_nome; ?>" type="tel" placeholder="(99) 9999-9999" pattern="\(\d{2}\)[\s]?\d{4}[-\s]?\d{4,5}" onchange="changeError(name)" onkeyup="validarEspecifico(name)" />
        </div>
    </div>

<?php
}

function get_options($rede_nome)
{
    switch ($rede_nome) {
        case 'rede-de-suporte':
            $title = 'Rede de Suporte';
            $opcoes = array(
                "Bases de dados e informações", "Certificadora", "Gestão", "Infraestrutura de laboratórios", "Instrumentos financeiros", "Metrologia", "Políticas públicas", "Outro"
            );
            break;

        case 'rede-de-formacao':
            $title = 'Rede de Formação Tecnológica';
            $opcoes = array(
                "Graduação", "Pós-Graduação", "Promoção e popularização da Ciência", "Qualificação profissional", "Outro"
            );
            break;

        case 'rede-de-pesquisa':
            $title = 'Rede de Pesquisa Aplicada';
            $opcoes = array(
                "Bases de dados e informações", "Ciências Agrárias", "Ciências Biológicas", "Ciências da Saúde", "Ciências Exatas e da Terra", "Ciências Sociais Aplicadas", "Engenharias", "Outro"
            );
            break;

        case 'rede-de-inovacao':
            $title = 'Rede de Inovação';
            $opcoes = array(
                "Incubadora", "Núcleo de Inovação Tecnológica (NIT)", "Parque tecnológico", "Outro"
            );
            break;

        case 'rede-de-tecnologia':
            $title = 'Rede de Tecnologias Aplicadas';
            $opcoes = array(
                "Agricultura", "Coque, derivados de petróleo e de biocombustíveis", "Equipamentos de transporte, exceto veículos automotores", "Farmoquímicos e farmacêuticos", "Informação e Comunicação", "Química", "Outro"
            );
            break;
    }

    $publicos = array(
        "Startup",
        "MPE",
        "Média Empresa",
        "Empresa de grande porte",
        "Governo",
        "ICTs",
        "Investidor",
        "Pesquisador",
        "Terceiro Setor",
        "Pessoa física"
    );

    $abrangencia = array(
        "Local/Regional", "Nacional", "Internacional"
    );

    return array($title, $opcoes, $publicos, $abrangencia);
}

//Definitions
define('FORM_ID_GERAL', 'CF6297bfb727214');
define('FORM_ID_SUPORTE', 'CF6297eae06f088');
define('FORM_ID_FORMACAO', 'CF6298c3e77962a');
define('FORM_ID_PESQUISA', 'CF6298c6a36c130');
define('FORM_ID_INOVACAO', 'CF6298c80222811');
define('FORM_ID_TECNOLOGIA', 'CF6298c879c2353');

// Função para criar os roles necessário para o cadastro
function custom_roles_cadastro()
{
    if (get_option('custom_roles_version') < 1) {
        add_role('candidato', 'Candidato', array('read' => true, 'level_0' => true));
        update_option('custom_roles_version', 1);
    }
}
add_action('init', 'custom_roles_cadastro');

function cadastro_action_form()
{
    /*
	* Função action para uso do formulário de cadastro.
	* Após processado, o usuário solicitante deverá ser criado, um email deverá ser enviado ao mesmo contendo uma senha.
    * O usuário ficará como "Role" -> "candidado"
	* Os dados são gravados em vários forms caldera, (geral e N Redes)
    *
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

    if (isset($_POST['cnpjDaInstituicao'])) $cnpjDaInstituicao = ($_POST['cnpjDaInstituicao']);
    else $cnpjDaInstituicao = "";
    if (isset($_POST['CNAEDaInstituicao'])) $CNAEDaInstituicao = ($_POST['CNAEDaInstituicao']);
    else $CNAEDaInstituicao = "";
    if (isset($_POST['urlDaInstituicao'])) $urlDaInstituicao = ($_POST['urlDaInstituicao']);
    else $urlDaInstituicao = "";

    //Redes checkbox
    $redes = "";
    if (isset($_POST['check_suporte'])) $redes .= $_POST['check_suporte'] . ";";
    if (isset($_POST['check_formacao'])) $redes .= $_POST['check_formacao'] . ";";
    if (isset($_POST['check_pesquisa'])) $redes .= $_POST['check_pesquisa'] . ";";
    if (isset($_POST['check_inovacao'])) $redes .= $_POST['check_inovacao'] . ";";
    if (isset($_POST['check_tecnologia'])) $redes .= $_POST['check_tecnologia'] . ";";

    //Redes Específicas
    $dados_redes = array(
        "rede-de-suporte" => array(),
        "rede-de-formacao" => array(),
        "rede-de-pesquisa" => array(),
        "rede-de-inovacao" => array(),
        "rede-de-tecnologia" => array(),
    );

    foreach ($dados_redes as $key => $value) {
        $opcoes = get_options($key)[1];
        $publico = get_options($key)[2];
        $abrangencia = get_options($key)[3];

        if (isset($_POST['urlServico-' . $key])) $dados_redes[$key]["urlServico"] = ($_POST['urlServico-' . $key]);
        else $dados_redes[$key]["urlServico"] = "";
        if (isset($_POST['produtoServicos-' . $key])) $dados_redes[$key]["produtoServicos"] = ($_POST['produtoServicos-' . $key]);
        else $dados_redes[$key]["produtoServicos"] = "";

        //Pegando os checks das classificacoes
        $classificacoes = "";
        foreach ($opcoes as $i => $v) {
            if (isset($_POST['check_classificacao_' . $i . '_' . $key])) $classificacoes .= $_POST['check_classificacao_' . $i . '_' . $key] . ";";
        }
        $dados_redes[$key]['classificacoes'] = $classificacoes;

        if (isset($_POST['outroClassificacao_' . $key])) $dados_redes[$key]["outroClassificacao"] = ($_POST['outroClassificacao_' . $key]);
        else $dados_redes[$key]["outroClassificacao"] = "";

        //Pegando os checks do publico alvo
        $publicos = "";
        foreach ($publico as $i => $v) {
            if (isset($_POST['check_publico_' . $i . '_' . $key])) $publicos .= $_POST['check_publico_' . $i . '_' . $key] . ";";
        }
        $dados_redes[$key]['publicos'] = $publicos;

        //Pegando os checks da abrangencia
        $abrangencias = "";
        foreach ($abrangencia as $i => $v) {
            if (isset($_POST['check_abrangencia_' . $i . '_' . $key])) $abrangencias .= $_POST['check_abrangencia_' . $i . '_' . $key] . ";";
        }
        $dados_redes[$key]['abrangencias'] = $abrangencias;

        //dados do representante
        if (isset($_POST['nomeCompleto_' . $key])) $dados_redes[$key]["nomeCompleto"] = ($_POST['nomeCompleto_' . $key]);
        else $dados_redes[$key]["nomeCompleto"] = "";
        if (isset($_POST['emailRepresentante_' . $key])) $dados_redes[$key]["emailRepresentante"] = ($_POST['emailRepresentante_' . $key]);
        else $dados_redes[$key]["emailRepresentante"] = "";
        if (isset($_POST['telefoneRepresentante_' . $key])) $dados_redes[$key]["telefoneRepresentante"] = ($_POST['telefoneRepresentante_' . $key]);
        else $dados_redes[$key]["telefoneRepresentante"] = "";
    }

    //Arquivos
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

    //----------------------------submit
    if (isset($_POST["enviar"])) {
        // Tratamento dos arquivos
        if (!is_null($doc1Unidade)) {
            $doc1UnidadeUrl = upload_documento($doc1Unidade, $emailDoCandidato, "1");
        }
        if (!is_null($doc2Unidade)) {
            $doc2UnidadeUrl = upload_documento($doc2Unidade, $emailDoCandidato, "2");
        }

        // Criar o usuário
        $password = wp_generate_password();
        $username = explode("@", $emailDoCandidato)[0];
        $first_name = explode(" ", $nomeDoCandidato)[0];
        $last_name = implode(" ", array_slice(explode(" ", $nomeDoCandidato), 1));

        $usuario_id = create_new_user($username, $password, $emailDoCandidato, $first_name, $last_name, "candidato");

        //funcao para criar a entrada no Caldera (Form geral)
        insert_entrada_form("CF6297bfb727214", $nomeDaInstituicao, $descricaoDaInstituicao, $natureza_op, $porte_op, $cnpjDaInstituicao, $CNAEDaInstituicao, $urlDaInstituicao, $redes, $doc1UnidadeUrl, $doc2UnidadeUrl, $nomeDoCandidato, $emailDoCandidato, $usuario_id);

        //REMOVER ESSE RETURN QUANDO TERMINAR AS FUNCOES ABAIXO
        //return;

        //funcao para dá entrada no Caldera (Form especifico)
        // esse explode gera uma iteração a mais por conta do último ";"
        foreach (explode(";", $redes) as $key => $value) {
            switch ($value) {
                case "check_suporte":
                    insert_entrada_form_especifico("CF6297eae06f088", $dados_redes["rede-de-suporte"], $usuario_id);
                    break;
                case "check_formacao":
                    insert_entrada_form_especifico("CF6298c3e77962a", $dados_redes["rede-de-formacao"], $usuario_id);
                    break;
                case "check_pesquisa":
                    insert_entrada_form_especifico("CF6298c6a36c130", $dados_redes["rede-de-pesquisa"], $usuario_id);
                    break;
                case "check_inovacao":
                    insert_entrada_form_especifico("CF6298c80222811", $dados_redes["rede-de-inovacao"], $usuario_id);
                    break;
                case "check_tecnologia":
                    insert_entrada_form_especifico("CF6298c879c2353", $dados_redes["rede-de-tecnologia"], $usuario_id);
                    break;
            }
        }
    } //end do if de enviar
}
add_action('admin_post_nopriv_cadastro_candidato', 'cadastro_action_form');
add_action('admin_post_cadastro_candidato', 'cadastro_action_form');

function generateRandomString($length = 15)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function create_new_user($username, $password, $email_address, $first_name, $last_name, $role)
{
    $user_id = username_exists($username);
    if (!$user_id) {
        $userData = array(
            'user_login' => $username,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'user_pass' => $password,
            'user_email' => $email_address,
            'user_url' => '',
            'role' => $role
        );
        return wp_insert_user($userData);
        /*        
        $user_id = wp_create_user( $username, $password, $email_address );
		$user = new WP_User( $user_id );
		$user->set_role( $role );
        return $user_id;
        */
    }
    return $user_id;
}

function insert_entrada_form($idFormulario, $nomeDaInstituicao, $descricaoDaInstituicao, $natureza_op, $porte_op, $cnpjDaInstituicao, $CNAEDaInstituicao, $urlDaInstituicao, $redes, $doc1UnidadeUrl, $doc2UnidadeUrl, $nomeDoCandidato, $emailDoCandidato, $usuario_id = 0, $statusGeral = "pendente",  $status = "pendente", $parecer = "", $historico = "")
{
    /*
	* Função para inserir uma nova entrada em um Caldera Forms
    * Usado para o form Geral
	*/

    $form = Caldera_Forms_Forms::get_form($idFormulario);
    //Basic entry information
    $entryDetials = new Caldera_Forms_Entry_Entry();
    $entryDetials->form_id = $form['ID'];
    $entryDetials->user_id = $usuario_id;
    $entryDetials->datestamp = current_time('mysql');
    $entryDetials->status = 'pending';
    //Create entry object
    $entry = new Caldera_Forms_Entry($form, false, $entryDetials);

    //Add field to entry
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_266564', $nomeDaInstituicao));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_6461522', $descricaoDaInstituicao));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_5902421', $natureza_op));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_7125239', $porte_op));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_3000518', $cnpjDaInstituicao));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_2471360', $CNAEDaInstituicao));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_1962476', $urlDaInstituicao));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_4465776', $redes));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_5438248', $doc1UnidadeUrl));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_9588438', $doc2UnidadeUrl));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_1333267', $nomeDoCandidato));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_7868662', $emailDoCandidato));

    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_9748069', $statusGeral));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_4899711', $status));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_4416984', $historico));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_8529353', $parecer));

    //Save entry in database.
    $entryId = $entry->save();
    //Make entry active
    $entry->update_status('active');
    return $entryId;
}

function insert_entrada_form_especifico($idFormulario, $dados_redes, $usuario_id, $status = "pendente", $versao = 0)
{
    /*
	* Função para inserir uma nova entrada em um Caldera Forms
    * Usado para os forms específicos de cada rede 
	*/

    $form = Caldera_Forms_Forms::get_form($idFormulario);
    //Basic entry information
    $entryDetials = new Caldera_Forms_Entry_Entry();
    $entryDetials->form_id = $form['ID'];
    $entryDetials->user_id = $usuario_id;
    $entryDetials->datestamp = current_time('mysql');
    $entryDetials->status = 'pending';
    //Create entry object
    $entry = new Caldera_Forms_Entry($form, false, $entryDetials);

    //Add field to entry
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_605717', $dados_redes["urlServico"]));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_4486725', $dados_redes["produtoServicos"]));

    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_8777940', $dados_redes["classificacoes"]));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_6678080', $dados_redes["outroClassificacao"]));

    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_4665383', $dados_redes["publicos"]));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_2391778', $dados_redes["abrangencias"]));

    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_6140408', $dados_redes["nomeCompleto"]));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_7130000', $dados_redes["emailRepresentante"]));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_5051662', $dados_redes["telefoneRepresentante"]));

    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_3707629', $status));
    $entry->add_field(get_fieldEntryValue_customizada($form, 'fld_2402818', $versao));

    //Save entry in database.
    $entryId = $entry->save();
    //Make entry active
    $entry->update_status('active');
    return $entryId;
}

function get_fieldEntryValue_customizada($form, $field_id, $value)
{
    /*
	* Função para pegar o valor de um determinado campo de um Caldera Form
	*/

    //Get field to save value for
    $field = Caldera_Forms_Field_Util::get_field($field_id, $form);
    //Create field value object
    $fieldEntryValue = new Caldera_Forms_Entry_Field();
    //Associate it with this field
    $fieldEntryValue->field_id = $field['ID'];
    $fieldEntryValue->slug = $field['slug'];
    //Set the value to save.
    $fieldEntryValue->value = $value;
    return $fieldEntryValue;
}

function upload_documento($documento, $usuario, $n)
{
    /*
	* Função para upload de arquivo
	* Recebe uma variável $_FILES['value']
	* Retorna a url do arquivo enviado
	*/

    $upload = wp_upload_bits($documento['name'], null, file_get_contents($documento['tmp_name']));

    $wp_filetype = wp_check_filetype(basename($upload['file']), null);

    $wp_upload_dir = wp_upload_dir();

    $message = "Documento " . $n . " do usuário " . $usuario . ".";

    $attachment = array(
        'guid' => $wp_upload_dir['baseurl'] . _wp_relative_upload_path($upload['file']),
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => preg_replace('/\.[^.]+$/', '', basename($upload['file'])),
        'post_content' => $message,
        'post_status' => 'inherit'
    );

    $attach_id = wp_insert_attachment($attachment, $upload['file']);

    require_once(ABSPATH . 'wp-admin/includes/file.php');

    $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
    wp_update_attachment_metadata($attach_id, $attach_data);

    return wp_get_attachment_url($attach_id);
}
