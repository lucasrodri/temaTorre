# Tema da Torre de Inovação

## Sistema de Cadastro
TODO
- [ ] Form de usuário
    - [X] Input type radio só pode escolher uma (não deixa desmarcar)
    - [X] Falta um outro input type radio (aberto quando é instituição privada)
    - [ ] Validação de todos os campos
    - [ ] Mostrar/esconder redes quando escolhidas (limpar rede escondida?) 
    - [ ] Mostrar/esconder campo de outros
- [ ] Salvar dados do form
- [ ] Avaliador


### Atualizações 08/06/2022
Mudanças feitas:

- mudei todos os ids para usar underline (_) em vez de hífen (-)
- criei uma função que descobre qual o painel ativo
- criei uma função que recebe o index do painel ativo e seta o tamanho da janela
- o "controle" do tamanho da janela agora é feito chamando essas funções
- na validação, se não existir o campo de label (onde escrevemos aquele erro "preenchimento obrigatório"), ele cria esse campo automaticamente (com jquery)


O que falta da validação:

- Corrigir ordem da validação (URL não está sendo checada corretamente)
- ~~Corrigir validação para input type radio~~
- Corrigir máscaras / validação de máscaras (nem testei)

O que falta geral:
- ~~Campo de input radio que falta na aba 2 (embaixo do Natureza jurídica da instituição)~~
- Continuar o render form das redes (falta a lógica da escolha do checkbox de redes)


- ao clicar para aparecer a rede: adicionar required aos itens mostrados
ao desclicar: remover os required

### Atualizações 14/06/2022
Mudanças feitas:
- Passei um formart document aí mudou altas coisas de formatação
- Mudei o value retornado do natureza_op, agora em vez de mostrar "natureza_op_1" ele fala "Instituição bla bla bla" (vai ficar mais fácil quando a gente for mostrar isso na tela)
- Fiz a mesma coisa pro porte_op
- o arrumaTamanhoJanela não tava legal pra página dos inputs, eu vi que tinha feito ligeiramente errado o código, aí arrumei (precisou de uma nova classe no html)
- Criei uma função para criar o role caso ele naõ exista (quando criei um usuário aqui pela primeira vez, ele veio com Função = "Nenhuma", quando a gente queria que fosse "Candidato", por isso essa nova função.
- Na função de criar usuário, se ele já existir, eu retorno o id dele

O que falta/Questionamentos
- [ ] salvar outro apenas se selecionado o "Outro"
- [ ] salvar porte_op apenas se selecionado o "natureza_op4/5"
- [ ] acrescentar loading no submit
- [ ] acrescentar aviso de algum erro na página (página muito grande, não fica claro que tem algo errado)
- [ ] o que acontece se o nome do candidato não tem espaços?
- [ ] o que acontece se o nome no email (usado para username) já existir?