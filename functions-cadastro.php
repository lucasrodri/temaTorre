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
            <div id="cadastro-wizard" class="col-md-12 mb-5" style="height: 500px;">
                <div class="br-wizard" collapsed="collapsed" step="1">
                    <div class="wizard-progress">
                        <button id="cadastro-wizard-b1" class="wizard-progress-btn" type="button" title="Termo de Declaração"><span class="info">Termo de Declaração</span></button>
                        <button id="cadastro-wizard-b2" class="wizard-progress-btn" type="button" title="Instituição" active="active"><span class="info">Instituição</span></button>
                        <button id="cadastro-wizard-b3" class="wizard-progress-btn" type="button" title="Redes" active="active"><span class="info">Redes</span></button>
                        <button id="cadastro-wizard-b4" class="wizard-progress-btn" type="button" title="Logo e Guia de Uso de Marca" active="active"><span class="info">Logo e Guia de Uso de Marca</span></button>
                        <button id="cadastro-wizard-b5" class="wizard-progress-btn" type="button" title="Finalização" disabled="disabled"><span class="info">Finalização</span></button>
                    </div>
                    <div class="wizard-form">
                        <div class="wizard-panel" active="active">
                            <div class="wizard-panel-content">
                                <div class="h3">Termo de Declaração</div>
                                <div class="text my-text-wizard" tabindex="0">
                                    Em observância à Lei nº. 13.709/18 – Lei Geral de Proteção de Dados Pessoais e demais normativas aplicáveis sobre proteção de Dados Pessoais, manifesto-me de forma informada, livre, expressa e consciente, no sentido de autorizar a tomada de decisão sobre tratamento de meus dados pessoais para as finalidades e de acordo com as condições aqui estabelecidas.

                                    Declaro também que as informações prestadas são de minha inteira responsabilidade, e que a falsidade nas informações fornecidas implicará nas penalidades cabíveis, no âmbito penal, cível e administrativo.
                                    <div class="mt-3 mb-1">
                                        <div class="br-checkbox">
                                            <input id="check-concordo" name="check-concordo" type="checkbox" aria-label="Concordo com esses termos" required />
                                            <label for="check-concordo">Concordo com esses termos</label>
                                        </div>
                                    </div>
                                    <span id="spam-concordo" class="feedback danger" role="alert" style="display: none;"><i class="fas fa-times-circle" aria-hidden="true"></i>Preenchimento Obrigatório</span>
                                </div>
                            </div>
                            <div class="wizard-panel-btn">
                                <div class="row">
                                    <div class="col-md-12 align-button-center">
                                        <button id="cadastro-btn-1" class="br-button primary wizard-btn" type="button">Avançar
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
                                            <input id="nomeDaInstituicao" name="nomeDaInstituicao" type="text" placeholder="Nome da Instituição" required />
                                        </div>
                                    </div>

                                    <div class="br-textarea mb-3">
                                        <label for="descricaoDaInstituicao">Descrição da instituição<span class="field_required" style="color:#ee0000;">*</span></label>
                                        <textarea class="textarea-start-size" id="descricaoDaInstituicao" name="descricaoDaInstituicao" placeholder="Escreva a descrição de sua instituição" maxlength="800"></textarea>
                                        <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
                                    </div>

                                    <p class="label mb-3">Natureza jurídica da instituição<span class="field_required" style="color:#ee0000;">*</span></p>
                                    <div class="br-radio">
                                        <input id="natureza-op-1" type="radio" name="natureza-op-1" value="natureza-op-1" />
                                        <label for="natureza-op-1">Instituição pública federal </label>
                                    </div>
                                    <div class="br-radio">
                                        <input id="natureza-op-2" type="radio" name="natureza-op-2" value="natureza-op-2" />
                                        <label for="natureza-op-2">Instituição pública estadual</label>
                                    </div>
                                    <div class="br-radio">
                                        <input id="natureza-op-3" type="radio" name="natureza-op-3" value="natureza-op-3" />
                                        <label for="natureza-op-3">Instituição pública municipal</label>
                                    </div>
                                    <div class="br-radio">
                                        <input id="op-4" type="radio" name="natureza-op-4" value="natureza-op-4" />
                                        <label for="op-4">Instituição privada com fins lucrativos</label>
                                    </div>
                                    <div class="br-radio">
                                        <input id="natureza-op-5" type="radio" name="natureza-op-5" value="natureza-op-5" />
                                        <label for="natureza-op-5">Instituição privada sem fins lucrativos</label>
                                    </div>

                                    <div class="mt-3 mb-3">
                                        <div class="br-input">
                                            <label for="cnpjDaInstituicao">CNPJ<span class="field_required" style="color:#ee0000;">*</span></label>
                                            <input id="cnpjDaInstituicao" name="cnpjDaInstituicao" type="text" placeholder="99.999.999/9999-99" required />
                                        </div>
                                    </div>

                                    <div class="br-textarea mb-3">
                                        <label for="CNAEDaInstituicao">CNAE<span class="field_required" style="color:#ee0000;">*</span></label>
                                        <textarea class="textarea-start-size" id="CNAEDaInstituicao" name="CNAEDaInstituicao" placeholder="Escreva sobre o CNAE de sua instituição" maxlength="800"></textarea>
                                        <div class="text-base mt-1"><span class="limit">Limite máximo de <strong>800</strong> caracteres</span><span class="current"></span></div>
                                    </div>

                                    <div class="mt-3 mb-3">
                                        <div class="br-input">
                                            <label for="urlDaInstituicao">Página da internet<span class="field_required" style="color:#ee0000;">*</span></label>
                                            <input id="urlDaInstituicao" name="urlDaInstituicao" type="url" placeholder="http://minhainstituicao.com.br" required />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="wizard-panel-btn">
                                <div class="row">
                                    <div class="col-md-6 align-button-right">
                                        <button id="cadastro-btn-volta-1" class="br-button secondary wizard-btn-prev" type="button">Voltar
                                        </button>
                                    </div>
                                    <div class="col-md-6 align-button-left">
                                        <button id="cadastro-btn-2" class="br-button primary wizard-btn-next" type="button">Avançar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-panel">
                            <div class="wizard-panel-content">
                                <div class="h3">Redes</div>
                                <div class="text my-text-wizard" tabindex="0">Conteúdo aqui</div>
                            </div>
                            <div class="wizard-panel-btn">
                                <div class="row">
                                    <div class="col-md-6 align-button-right">
                                        <button class="br-button secondary wizard-btn-prev" type="button">Voltar
                                        </button>
                                    </div>
                                    <div class="col-md-6 align-button-left">
                                        <button class="br-button primary wizard-btn-next" type="button">Avançar
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
                                        <button class="br-button primary wizard-btn-next" type="button">Avançar
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
