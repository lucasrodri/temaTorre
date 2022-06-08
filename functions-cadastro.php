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
    <form class="card" action="" method="post">
        <div class="row">
            <div id="cadastro_wizard" class="col-md-12 mb-5">
                <div class="br-wizard" collapsed="collapsed" step="1">
                    <div class="wizard-progress">
                        <button id="cadastro_wizard_b1" class="wizard-progress-btn" type="button" title="Termo de Declaração" active="active"><span class="info">Termo de Declaração</span></button>
                        <button id="cadastro_wizard_b2" class="wizard-progress-btn" type="button" title="Instituição" active="active"><span class="info">Instituição</span></button>
                        <button id="cadastro_wizard_b3" class="wizard-progress-btn" type="button" title="Redes" active="active"><span class="info">Redes</span></button>
                        <button id="cadastro_wizard_b4" class="wizard-progress-btn" type="button" title="Logo e Guia de Uso de Marca" active="active"><span class="info">Logo e Guia de Uso de Marca</span></button>
                        <button id="cadastro_wizard_b5" class="wizard-progress-btn" type="button" title="Finalização" disabled="disabled"><span class="info">Finalização</span></button>
                    </div>
                    <div class="wizard-form">
                        <div class="wizard-panel" active="active">
                            <div class="wizard-panel-content">
                                <div class="h3">Termo de Declaração</div>
                                <div class="text my-text-wizard" tabindex="0">
                                    Em observância à Lei nº. 13.709/18 – Lei Geral de Proteção de Dados Pessoais e demais normativas aplicáveis sobre proteção de Dados Pessoais, manifesto-me de forma informada, livre, expressa e consciente, no sentido de autorizar a tomada de decisão sobre tratamento de meus dados pessoais para as finalidades e de acordo com as condições aqui estabelecidas.

                                    Declaro também que as informações prestadas são de minha inteira responsabilidade, e que a falsidade nas informações fornecidas implicará nas penalidades cabíveis, no âmbito penal, cível e administrativo.
                                </div>
                                <div class="mt-3 mb-1">
                                    <div class="br-checkbox">
                                        <input id="checkConcordo" name="checkConcordo" type="checkbox" aria-label="Concordo com esses termos" onchange="changeError(name)" />
                                        <label for="checkConcordo">Concordo com esses termos</label>
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
                                        <textarea class="textarea-start-size" id="descricaoDaInstituicao" name="descricaoDaInstituicao" placeholder="Escreva a descrição de sua instituição" maxlength="800" onchange="changeError(name)" required ></textarea>
                                        <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
                                    </div>

                                    <p class="label mb-3">Natureza jurídica da instituição<span class="field_required" style="color:#ee0000;">*</span></p>
                                    <div class="br-radio">
                                        <input id="natureza-op-1" type="radio" name="natureza-op" value="natureza-op-1" />
                                        <label for="natureza-op-1">Instituição pública federal </label>
                                    </div>
                                    <div class="br-radio">
                                        <input id="natureza-op-2" type="radio" name="natureza-op" value="natureza-op-2" />
                                        <label for="natureza-op-2">Instituição pública estadual</label>
                                    </div>
                                    <div class="br-radio">
                                        <input id="natureza-op-3" type="radio" name="natureza-op" value="natureza-op-3" />
                                        <label for="natureza-op-3">Instituição pública municipal</label>
                                    </div>
                                    <div class="br-radio">
                                        <input id="op-4" type="radio" name="natureza-op" value="natureza-op-4" />
                                        <label for="op-4">Instituição privada com fins lucrativos</label>
                                    </div>
                                    <div class="br-radio">
                                        <input id="natureza-op-5" type="radio" name="natureza-op" value="natureza-op-5" />
                                        <label for="natureza-op-5">Instituição privada sem fins lucrativos</label>
                                    </div>

                                    <div class="mt-3 mb-3">
                                        <div class="br-input">
                                            <label for="cnpjDaInstituicao">CNPJ<span class="field_required" style="color:#ee0000;">*</span></label>
                                            <input id="cnpjDaInstituicao" name="cnpjDaInstituicao" type="text" placeholder="99.999.999/9999-99" onchange="changeError(name)" required />
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
                                            <input id="urlDaInstituicao" name="urlDaInstituicao" type="url" placeholder="http://minhainstituicao.com.br" onchange="changeError(name)" required />
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

                                <div class="mt-3 mb-1">
                                    <div class="br-checkbox">
                                        <input id="check_suporte" name="check_suporte" type="checkbox" aria-label="Rede de Suporte" />
                                        <label for="check_suporte">Rede de Suporte - apoio aos atores do ecossistema de inovação e as atividades da Torre MCTI em todas as etapas do desenvolvimento de produtos e serviços inovadores</label>
                                    </div>
                                    <div class="br-checkbox">
                                        <input id="check_formacao" name="check_formacao" type="checkbox" aria-label="Rede de Formação" />
                                        <label for="check_formacao">Rede de Formação Tecnológica - capacitação em ciência, tecnologia e inovação, com intuito de expandir e melhorar a formação profissional e tecnológica</label>
                                    </div>
                                    <div class="br-checkbox">
                                        <input id="check_pesquisa" name="check_pesquisa" type="checkbox" aria-label="Rede de Pesquisa" />
                                        <label for="check_pesquisa">Rede de Pesquisa Aplicada - utilização do conhecimento científico gerado na pesquisa básica, para apoiar o desenvolvimento de inovações, produtos e serviços, por meio da concepção de aplicações e provas de conceito</label>
                                    </div>
                                    <div class="br-checkbox">
                                        <input id="check_inovacao" name="check_inovacao" type="checkbox" aria-label="Rede de inovacao" />
                                        <label for="check_inovacao">Rede de Inovação - transformação de ideias em protótipos, materializando o conhecimento científico validado em soluções concretas experimentais</label>
                                    </div>
                                    <div class="br-checkbox">
                                        <input id="check_tecnologia" name="check_tecnologia" type="checkbox" aria-label="Rede de tecnologia" />
                                        <label for="check_tecnologia">Tecnologias Aplicadas - transformação de protótipos em produtos e riquezas, com o objetivo de aperfeiçoar soluções experimentais tornando-as aptas ao mercado, à geração de riqueza e à contribuição para a qualidade de vida dos brasileiros</label>
                                    </div>
                                </div>

                                <div id='redes_render_suporte' style="display:inline;">
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
                                <div class="text my-text-wizard" tabindex="0">Conteúdo aqui</div>
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
                                <div class="text my-text-wizard" tabindex="0">Conteúdo aqui</div>
                            </div>
                            <div class="wizard-panel-btn">
                                <div class="row">
                                    <div class="col-md-6 align-button-right">
                                        <button class="br-button secondary wizard-btn-prev" type="button">Voltar
                                        </button>
                                    </div>
                                    <div class="col-md-6 align-button-left">
                                        <button class="br-button primary wizard-btn" type="button">Concluir
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php
}


function cadastro_redes_render($rede_nome)
{

    switch ($rede_nome) {
        case 'rede-de-suporte':
            $title = 'Rede de Suporte';
            $opcoes = array(
                "Bases de dados e informações", "Certificadora", "Gestão", "Infraestrutura de laboratórios", "Instrumentos financeiros", "Metrologia", "Políticas públicas", "Outro"
            );
            break;

        case 'rede-de-formacao':
            $title = 'Rede de Formação';
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

?>
    <div class="h4"><?php echo $title; ?></div>

    <div class="br-textarea mb-3">
        <label for="urlServico-<?php echo $rede_nome; ?>">URL dos serviços relacionados na rede especificada<span class="field_required" style="color:#ee0000;">*</span></label>
        <textarea class="" id="urlServico-<?php echo $rede_nome; ?>" name="urlServico-<?php echo $rede_nome; ?>" placeholder="Escreva a URL dos serviços" rows="3"></textarea>
    </div>

    <div class="br-textarea mb-3">
        <label for="produtoServicos-<?php echo $rede_nome; ?>">Produtos, serviços e/ou ferramentas de CT&I ofertados relacionados à rede selecionada - proposta de valor<span class="field_required" style="color:#ee0000;">*</span></label>
        <textarea class="" id="produtoServicos-<?php echo $rede_nome; ?>" name="produtoServicos-<?php echo $rede_nome; ?>" placeholder="Escreva a URL dos serviços" rows="3"></textarea>
    </div>

    <label>Classificação<span class="field_required" style="color:#ee0000;">*</span></label>

    <div class="mt-3 mb-1">
        <?php foreach ($opcoes as $key => $value) { ?>
            <div class="br-checkbox">
                <input id="check_classificacao_<?php echo $key; ?>_<?php echo $rede_nome; ?>" name="check_classificacao_<?php echo $key; ?>_<?php echo $rede_nome; ?>" type="checkbox" aria-label="<?php echo $value; ?>" />
                <label for="check_classificacao_<?php echo $key; ?>_<?php echo $rede_nome; ?>"><?php echo $value; ?></label>
            </div>
        <?php } ?>
    </div>


    <div class="mb-3">
        <div class="br-input">
            <label for="outroClassificacao_<?php echo $rede_nome; ?>">Outro<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="outroClassificacao_<?php echo $rede_nome; ?>" name="outroClassificacao_<?php echo $rede_nome; ?>" type="text" placeholder="Outra classificação" required />
        </div>
    </div>

    <label>Público-Alvo<span class="field_required" style="color:#ee0000;">*</span></label>

    <div class="mt-3 mb-1">
        <?php foreach ($publicos as $key => $value) { ?>
            <div class="br-checkbox">
                <input id="check_publico_<?php echo $key; ?>_<?php echo $rede_nome; ?>" name="check_publico_<?php echo $key; ?>_<?php echo $rede_nome; ?>" type="checkbox" aria-label="<?php echo $value; ?>" />
                <label for="check_publico_<?php echo $key; ?>_<?php echo $rede_nome; ?>"><?php echo $value; ?></label>
            </div>
        <?php } ?>
    </div>

    <label>Abrangência<span class="field_required" style="color:#ee0000;">*</span></label>

    <div class="mt-3 mb-1">
        <?php foreach ($abrangencia as $key => $value) { ?>
            <div class="br-checkbox d-inline">
                <input id="check_abrangencia_<?php echo $key; ?>_<?php echo $rede_nome; ?>" name="check_abrangencia_<?php echo $key; ?>_<?php echo $rede_nome; ?>" type="checkbox" aria-label="<?php echo $value; ?>" />
                <label for="check_abrangencia_<?php echo $key; ?>_<?php echo $rede_nome; ?>"><?php echo $value; ?></label>
            </div>
        <?php } ?>
    </div>


    <div class="h5"> Representante da instituição na <?php echo $title; ?></div>


    <div class="mb-3">
        <div class="br-input">
            <label for="nomeCompleto_<?php echo $rede_nome; ?>">Nome completo<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="nomeCompleto_<?php echo $rede_nome; ?>" name="nomeCompleto_<?php echo $rede_nome; ?>" type="text" placeholder="Nome completo" required />
        </div>
    </div>

    <div class="mb-3">
        <div class="br-input">
            <label for="emailRepresentante_<?php echo $rede_nome; ?>">E-mail<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="emailRepresentante_<?php echo $rede_nome; ?>" name="emailRepresentante_<?php echo $rede_nome; ?>" type="email" placeholder="exemplo@exemplo.com" required />
        </div>
    </div>

    <div class="mb-3">
        <div class="br-input">
            <label for="telefoneRepresentante_<?php echo $rede_nome; ?>">Telefone<span class="field_required" style="color:#ee0000;">*</span></label>
            <input id="telefoneRepresentante_<?php echo $rede_nome; ?>" name="telefoneRepresentante_<?php echo $rede_nome; ?>" type="tel" placeholder="(99) 9999-9999" required />
        </div>
    </div>

<?php
}
