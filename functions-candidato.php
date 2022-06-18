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
    <div class="row mt-5 mb-5">
        <div class="col-md-12 align-button-right mr-4">
            <button class="br-button success wizard-btn mr-sm-3" type="button">Edite Seu Formulário
            </button>
        </div>
    </div>



<?php
}
