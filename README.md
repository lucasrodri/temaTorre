# Tema da Torre de Inovação

## Sistema de Cadastro
TODO
- [ ] Form de usuário
    - [X] Input type radio só pode escolher uma (não deixa desmarcar)
    - [ ] Falta um outro input type radio (aberto quando é instituição privada)
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
- Corrigir validação para input type radio
- Corrigir máscaras / validação de máscaras (nem testei)

O que falta geral:
- Campo de input radio que falta na aba 2 (embaixo do Natureza jurídica da instituição)
- Continuar o render form das redes (falta a lógica da escolha do checkbox de redes)