<?php

/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> <?php twentytwentyone_the_html_classes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <div id="page" class="site template-base">

    <nav class="br-skiplink">
      <a class="br-item" href="#main-content" accesskey="1">Ir para o conteúdo (1/4) <span class="br-tag text ml-1">1</span></a>
      <a class="br-item" href="#header-navigation" accesskey="2">Ir para o menu (2/4) <span class="br-tag text ml-1">2</span></a>
      <a class="br-item" href="#main-searchbox" accesskey="3">Ir para a busca (3/4) <span class="br-tag text ml-1">3</span></a>
      <a class="br-item" href="#footer" accesskey="4">Ir para o rodapé (4/4) <span class="br-tag text ml-1">4</span></a>
    </nav>

    <header class="br-header mb-4" id="header" data-sticky="data-sticky">
      <div class="container-lg">
        <div class="header-top">
          <div class="header-logo">
            <img src="<?php echo (esc_url(get_template_directory_uri()) . '/assets/images/govbr-logo-large.png') ?>" alt="logo" />
            <!-- <span class="br-divider vertical mx-half mx-sm-1"></span> -->
            <div class="header-sign">Ministério da Ciência, Tecnologia e Inovações</div>
          </div>
          <div class="header-actions">
            <div class="header-links dropdown">
              <button class="br-button circle small" type="button" data-toggle="dropdown" aria-label="Abrir Acesso Rápido"><i class="fas fa-ellipsis-v" aria-hidden="true"></i>
              </button>
              <div class="br-list">
                <div class="header">
                  <div class="title">Acesso Rápido</div>
                </div>
                <a class="br-item br-item-accessiblity" href="https://www.gov.br/pt-br/orgaos-do-governo">Órgãos do Governo</a>
                <a class="br-item br-item-accessiblity" href="http://www.acessoainformacao.gov.br/">Acesso à Informação</a>
                <a class="br-item br-item-accessiblity" href="http://www4.planalto.gov.br/legislacao">Legislação</a>
                <a class="br-item br-item-accessiblity" href="https://www.gov.br/governodigital/pt-br/acessibilidade-digital">Acessibilidade</a>
              </div>
            </div>
            <span class="vertical mx-half mx-sm-1"></span>
            <div class="header-functions dropdown">
              <button class="br-button circle small" type="button" data-toggle="dropdown" aria-label="Abrir Funcionalidades do Sistema"><i class="fas fa-th" aria-hidden="true"></i>
              </button>
              <div class="br-list">
                <div class="header">
                  <div class="title">Funcionalidades do Sistema</div>
                </div>
                <div class="align-items-center br-item">
                  <button id="increase-font" class="br-button circle small" type="button" accesskey="1"><b>A+</b><span class="text">Aumentar Fonte</span>
                  </button>
                </div>
                <div class="align-items-center br-item">
                  <button id="decrease-font" class="br-button circle small" type="button" accesskey="2"><b>A-</b><span class="text">Diminuir Fonte</span>
                  </button>
                </div>
                <div class="align-items-center br-item">
                  <button class="br-button circle small" type="button" accesskey="3" onclick="window.toggleContrast()" onkeydown="window.toggleContrast()"><i class="fas fa-adjust" aria-hidden="true"></i><span class="text">Alto contraste</span>
                  </button>
                </div>
              </div>
            </div>
            <span class="vertical mx-half mx-sm-1"></span>
            <div class="header-search-trigger">
              <button class="br-button circle" type="button" aria-label="Abrir Busca" data-toggle="search" data-target=".header-search"><i class="fas fa-search" aria-hidden="true"></i>
              </button>
            </div>
            <div class="header-login">
              <div class="header-sign-in">
                <!-- Para abrir o menu do usuário use data-trigger="login" -->
                <button class="br-sign-in small" type="button" onclick="myFunctionEntrar()"><i class="fas fa-user" aria-hidden="true"></i><span class="d-sm-inline">Entrar</span>
                </button>
              </div>
              <div class="header-avatar d-none">
                <div class="avatar dropdown"><span class="br-avatar" title="Fulano da Silva"><span class="image"><img src="https://picsum.photos/id/823/400" alt="Avatar" /></span></span>
                  <button class="br-button circle small" type="button" aria-label="Abrir Menu de usuário" data-toggle="dropdown"><i class="fas fa-angle-down" aria-hidden="true"></i>
                  </button>
                  <div class="br-notification">
                    <div class="notification-header">
                      <div class="row">
                        <div class="col-10"><span class="text-bold">Fulano da Silva</span><br /><small>nome.sobrenome@dominio.gov</small></div>
                        <div class="col-2">
                          <div class="close text-right">
                            <button class="br-button circle small" type="button" aria-label="Fechar"><i class="fas fa-times" aria-hidden="true"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="notification-body">
                      <div class="br-tab">
                        <nav class="tab-nav">
                          <ul>
                            <li class="tab-item notification-tooltip" data-tooltip-text="Alertas">
                              <button type="button" aria-label="Alertas" data-panel="notification-panel-1-79227"><span class="name"><i class="fas fa-bell" aria-hidden="true"></i></span></button>
                            </li>
                            <li class="tab-item notification-tooltip active" data-tooltip-text="Mensagens">
                              <button type="button" aria-label="Mensagens" data-panel="notification-panel-2-79227"><span class="name"><i class="fas fa-envelope" aria-hidden="true"></i></span></button>
                            </li>
                          </ul>
                        </nav>
                        <div class="tab-content">
                          <div class="tab-panel" id="notification-panel-1-79227">
                            <div class="br-list">
                              <button class="br-item" type="button"><i class="fas fa-heartbeat" aria-hidden="true"></i>Link de Acesso
                              </button>
                              <button class="br-item" type="button"><i class="fas fa-heartbeat" aria-hidden="true"></i>Link de Acesso
                              </button>
                              <button class="br-item" type="button"><i class="fas fa-heartbeat" aria-hidden="true"></i>Link de Acesso
                              </button>
                            </div>
                          </div>
                          <div class="tab-panel active" id="notification-panel-2-79227">
                            <div class="br-list">
                              <button class="br-item" type="button"><span class="br-tag status small warning"></span><span class="text-bold">Título</span><span class="text-medium mb-2">25 de out</span><span>Nostrud consequat culpa ex mollit aute. Ex ex veniam ea labore laboris duis duis elit. Ex aute dolor enim aute Lorem dolor. Duis labore ad anim culpa. Non aliqua excepteur sunt eiusmod ex consectetur ex esse laborum velit ut aute.</span>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="header-bottom">
          <div class="header-menu align-header-menu">
            <div class="header-menu-trigger" id="header-navigation">
              <button class="br-button small circle" type="button" aria-label="Menu" data-toggle="menu" data-target="#main-navigation" id="navigation"><i class="fas fa-bars" aria-hidden="true"></i>
              </button>
            </div>
            <div class="header-info">
              <div class="header-title"><a class="linkTitulo" href="/">Torre MCTI</a></div>
              <!-- <div class="header-subtitle">Subtítulo do Header</div> -->
            </div>
          </div>
          <div class="header-search" id="main-searchbox">
            <div class="br-input has-icon">
              <label for="searchbox">Texto da pesquisa</label>
              <input id="searchbox" type="text" placeholder="O que você procura?" data-swplive="true" />
              <button class="br-button circle small" type="button" aria-label="Pesquisar" onclick="myFunctionBusca()"><i class="fas fa-search" aria-hidden="true"></i>
              </button>
            </div>
            <button class="br-button circle search-close ml-1" type="button" aria-label="Fechar Busca" data-dismiss="search"><i class="fas fa-times" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>
    </header>
    <!-- <div class="br-cookiebar default d-none" tabindex="-1"></div> -->
    <!-- </div> -->


    <?php //get_template_part( 'template-parts/header/site-header' ); 
    ?>

    <main class="d-flex flex-fill mb-5" id="main">
      <div class="container-lg d-flex">
        <div class="row">
          <div class="br-menu" id="main-navigation">
            <div class="menu-container">
              <div class="menu-panel">
                <div class="menu-header">
                  <div class="menu-title"><img src="<?php echo (esc_url(get_template_directory_uri()) . '/assets/images/govbr-logo-large.png') ?>" alt="Logo do Governo" /></div>
                  <div class="menu-close">
                    <button class="br-button circle" type="button" aria-label="Fechar o menu" data-dismiss="menu"><i class="fas fa-times" aria-hidden="true"></i>
                    </button>
                  </div>
                </div>
                <nav class="menu-body menu-body-border">
                  <div><a class="menu-item" href="/">
                      <span class="content">Início</span></a>
                  </div>

                  <div class="menu-folder"><a class="menu-item" href="javascript: void(0)"><span class="content">A Torre MCTI</span></a>
                    <ul>
                      <li><a class="menu-item" href="/sobre-a-torre-mcti/"><span class="content">Sobre a Torre MCTI</span></a></li>
                      <li><a class="menu-item" href="/#conheca"><span class="content">Conheça as instituições cadastradas</span></a></li>
                      <li><a class="menu-item" href="/orientacoes"><span class="content">Orientações para cadastro</span></a></li>
                    </ul>
                  </div>

                  <div class="menu-folder"><a class="menu-item" href="javascript: void(0)"><span class="content">Comitês</span></a>
                    <ul>
                      <li><a class="menu-item" href="/comite-gestor"><span class="content">Comitê Gestor</span></a></li>
                      <li><a class="menu-item" href="/comite-de-especialistas"><span class="content">Comitês de Especialistas</span></a></li>
                      <li><a class="menu-item" href="/comite-de-implementacao"><span class="content">Comitê de Implantação e Manutenção Operacional</span></a></li>
                    </ul>
                  </div>

                  <div><a class="menu-item" href="/beneficios-da-implantacao-da-torre-mcti">
                      <span class="content">Benefícios da implantação da Torre MCTI</span></a>
                  </div>

                  <div><a class="menu-item" href="/faq">
                      <span class="content">FAQ</span></a>
                  </div>

                  <div><a class="menu-item" href="/busca">
                      <span class="content">Busca Avançada</span></a>
                  </div>

                  <div><a class="menu-item" href="/#contato">
                      <span class="content">Contato</span></a>
                  </div>
                </nav>
                <div class="menu-footer">
                  <div class="menu-links">
                    <a href="https://www.gov.br/pt-br/orgaos-do-governo">Órgãos do Governo&nbsp;<i class="fas fa-external-link-square-alt" aria-hidden="true"></i></a>
                    <a href="http://www4.planalto.gov.br/legislacao">Legislação&nbsp;<i class="fas fa-external-link-square-alt" aria-hidden="true"></i></a>
                  </div>

                  <div class="menu-social">
                    <div class="text-semi-bold mb-1">Redes Sociais</div>
                    <div class="sharegroup">
                      <div class="share"><a class="br-button circle" href="https://www.twitter.com/mcti" aria-label="Twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                      </div>
                      <div class="share"><a class="br-button circle" href="https://www.youtube.com/mcti" aria-label="Youtube"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                      </div>
                      <div class="share"><a class="br-button circle" href="https://www.facebook.com/mcti" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                      </div>
                      <div class="share"><a class="br-button circle" href="https://www.flickr.com/SintonizeMCTI" aria-label="Flicker"><i class="fab fa-flickr" aria-hidden="true"></i></a>
                      </div>
                      <div class="share"><a class="br-button circle" href="https://www.instagram.com/mcti" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                      </div>
                      <div class="share"><a class="br-button circle" href="https://soundcloud.com/mcti" aria-label="Soundcloud"><i class="fab fa-soundcloud" aria-hidden="true"></i></a>
                      </div>
                    </div>
                  </div>
                  <div class="menu-info">
                    <div class="text-center text-down-01">Todo o conteúdo deste site está publicado sob a licença <strong>Creative Commons Atribuição-SemDerivações 3.0</strong></div>
                  </div>
                </div>
              </div>
              <div class="menu-scrim" data-dismiss="menu" tabindex="0"></div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <div id="content" class="site-content">
      <div id="primary" class="content-area">
        <!-- <main id="main" class="site-main d-block" role="main"> -->