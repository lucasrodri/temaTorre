<?php

/*
* Shortcode para renderizar o formulário de início
*/

add_shortcode('shortcode_candidato_view', 'candidato_view');

function candidato_view()
{
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
                    <th scope="col">Data</th>
                    <th scope="col">Nome da Instituição</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="noHover">
                    <td data-th="Data">Jan 6, 2022</td>
                    <td data-th="Nome">Nome da Instituição</td>
                    <td data-th="Status">
                        <button class="br-button success small mt-3 mt-sm-0" type="button">Homologado
                        </button>
                    </td>
                </tr>
                <!-- apenas para teste de visualizacao, somenete uma tr sera apresentada -->
                <tr class="noHover">
                    <td data-th="Data">Jan 6, 2022</td>
                    <td data-th="Nome">Nome da Instituição</td>
                    <td data-th="Status">
                        <button class="br-button warning small mt-3 mt-sm-0" type="button">Em Análise
                        </button>
                    </td>
                </tr>
                <tr class="noHover">
                    <td data-th="Data">Jan 6, 2022</td>
                    <td data-th="Nome">Nome da Instituição</td>
                    <td data-th="Status">
                        <button class="br-button danger small mt-3 mt-sm-0" type="button">Ajustes Necessários
                        </button>
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
                <li class="tab-item">
                    <button type="button" data-panel="panel-2"><span class="name">Suporte</span></button>
                </li>
                <li class="tab-item">
                    <button type="button" data-panel="panel-3"><span class="name">Formação Tecnológica</span></button>
                </li>
                <li class="tab-item">
                    <button type="button" data-panel="panel-4"><span class="name">Pesquisa Aplicada</span></button>
                </li>
                <li class="tab-item">
                    <button type="button" data-panel="panel-5"><span class="name">Inovação</span></button>
                </li>
                <li class="tab-item">
                    <button type="button" data-panel="panel-6"><span class="name">Tecnologias Aplicadas</span></button>
                </li>
            </ul>
        </nav>
        <div class="tab-content mt-4">
            <div class="tab-panel active" id="panel-1">
                <?php render_geral_data(); ?>
            </div>
            <div class="tab-panel" id="panel-2">
                <form class="card" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
                    <?php cadastro_redes_render('rede-de-suporte'); ?>
                    <div class="row mt-5">
                        <div class="col-md-12 text-center">
                            <input type="submit" class="br-button primary" value="Atualizar Dados" name="enviar">
                            <!-- <div id='loading_submit' class="loading medium" style='display:none;'></div> -->
                        </div>
                    </div>
                    <input type="hidden" name="action" value="cadastro_candidato">
                </form>
            </div>
            <div class="tab-panel" id="panel-3">
                <form class="card" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
                    <?php cadastro_redes_render('rede-de-formacao'); ?>
                    <div class="row mt-5">
                        <div class="col-md-12 text-center">
                            <input type="submit" class="br-button primary" value="Atualizar Dados" name="enviar">
                            <!-- <div id='loading_submit' class="loading medium" style='display:none;'></div> -->
                        </div>
                    </div>
                    <input type="hidden" name="action" value="cadastro_candidato">
                </form>
            </div>
            <div class="tab-panel" id="panel-4">
                <form class="card" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
                    <?php cadastro_redes_render('rede-de-pesquisa'); ?>
                    <div class="row mt-5">
                        <div class="col-md-12 text-center">
                            <input type="submit" class="br-button primary" value="Atualizar Dados" name="enviar">
                            <!-- <div id='loading_submit' class="loading medium" style='display:none;'></div> -->
                        </div>
                    </div>
                    <input type="hidden" name="action" value="cadastro_candidato">
                </form>
            </div>
            <div class="tab-panel" id="panel-5">
                <form class="card" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
                    <?php cadastro_redes_render('rede-de-inovacao'); ?>
                    <div class="row mt-5">
                        <div class="col-md-12 text-center">
                            <input type="submit" class="br-button primary" value="Atualizar Dados" name="enviar">
                            <!-- <div id='loading_submit' class="loading medium" style='display:none;'></div> -->
                        </div>
                    </div>
                    <input type="hidden" name="action" value="cadastro_candidato">
                </form>
            </div>
            <div class="tab-panel" id="panel-6">
                <form class="card" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
                    <?php cadastro_redes_render('rede-de-tecnologia'); ?>
                    <div class="row mt-5">
                        <div class="col-md-12 text-center">
                            <input type="submit" class="br-button primary" value="Atualizar Dados" name="enviar">
                            <!-- <div id='loading_submit' class="loading medium" style='display:none;'></div> -->
                        </div>
                    </div>
                    <input type="hidden" name="action" value="cadastro_candidato">
                </form>
            </div>
        </div>
    </div>
<?php
}


function render_geral_data()
{
?>
    <form class="card" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
        <p id="radio_function" style="display: none;"></p>
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
        <!-- Marca e Uploads -->
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
        <!-- Dados de contato -->
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
        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <input type="submit" class="br-button primary" value="Atualizar Dados" name="enviar">
                <!-- <div id='loading_submit' class="loading medium" style='display:none;'></div> -->
            </div>
        </div>
        <input type="hidden" name="action" value="cadastro_candidato">
    </form>
<?php
}
