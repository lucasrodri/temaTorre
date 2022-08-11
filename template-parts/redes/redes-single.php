<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>

<article id="redes-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container-lg container-rcc-post">
		<header class="entry-header alignwide">
			<?php the_title('<h1 class="entry-title titulo-post">', '</h1>'); ?>
			<div class="row">
				<div class="col-md-6">

					<?php
					// função com "Postado em"
					//funcao_publicado_em();
					?>
				</div>
				<div class="col-md-6 social-media-rcc">
					<?php
					// Ícones de compartilhamento
					echo do_shortcode('[shortcode_social_links]'); ?>
				</div>
			</div>
		</header><!-- .entry-header -->

		<div class="entry-content-rcc entry-content">

			<?php
			$image = get_field('logomarca');
			if( $image ):
				// Image variables.
				$url = $image['url'];
				$title = $image['title'];
				$alt = $image['alt'];

				// Thumbnail size attributes.
				$size = 'thumbnail_redes_retangular';
				$thumb = $image['sizes'][ $size ];
				$width = $image['sizes'][ $size . '-width' ];
				$height = $image['sizes'][ $size . '-height' ];
				?>

				<div class="mt-3 mb-3" style="display: flex; justify-content: center;">
					<img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($alt); ?>" />
				</div>
			<?php endif; ?>
			
			<?php if (get_field('visao')) { ?>
				<div class="mt-3 mb-3">
					<div class="visao-texto">
						<p>Veja no mapa as unidades:</p>
						<a href="<?php the_field('visao'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/visao.png" alt="Visão" style="width: 50px;"> </a>
					</div>
				</div>
			<?php } ?>

			<?php
			//the_content();
			//the_field('texto');
			?>

			<?php if (get_field('texto')) { ?>
				<div class="mt-3 mb-3">
					<p class="font-weight-bold">Descrição da instituição</p>
					<p><?php the_field('texto'); ?></p>
				</div>
			<?php } ?>

			<?php if (get_field('solucao')) { ?>
				<div class="mt-3 mb-3">
					<p class="font-weight-bold">Solução em CTI</p>
					<p><?php the_field('solucao'); ?></p>
				</div>
			<?php } ?>

			<?php if (get_field('url')) { ?>
				<div class="mt-3 mb-3">
					<p class="font-weight-bold">URL</p>
					<a href="<?php the_field('url'); ?>" target="_blank"><?php the_field('url'); ?></a>
				</div>
			<?php } ?>

			<?php if (get_field('publico-alvo')) { ?>
				<div class="mt-3 mb-3">
						<p class="font-weight-bold">Público-alvo</p>
						<p><?php the_field('publico-alvo'); ?></p>
				</div>
			<?php } ?>

			<?php if (get_field('abrangencia')) { ?>
				<div class="mt-3 mb-3">
						<p class="font-weight-bold">Abrangência</p>
						<p><?php the_field('abrangencia'); ?></p>
				</div>
			<?php } ?>

<?php if (get_field('natureza_juridica')) { ?>
				<div class="mt-3 mb-3">
						<p class="font-weight-bold">Natureza jurídica da instituição</p>
						<p><?php the_field('natureza_juridica'); ?></p>
				</div>
			<?php } ?>

			<?php if(current_user_can('administrator') || current_user_can('editor')) { ?>
    		<!-- Stuff here for administrators -->
				<h3>Informações de Contato</h3>

				<?php if (get_field('responsavel')) { ?>
					<div class="mt-3 mb-3">
							<p class="font-weight-bold">Responsável</p>
							<p><?php the_field('responsavel'); ?></p>
					</div>
				<?php } ?>

				<?php if (get_field('e-mail')) { ?>
					<div class="mt-3 mb-3">
							<p class="font-weight-bold">E-mail</p>
							<p><?php the_field('e-mail'); ?></p>
					</div>
				<?php } ?>

				<?php if (get_field('telefone')) { ?>
					<div class="mt-3 mb-3">
							<p class="font-weight-bold">Telefone</p>
							<p><?php the_field('telefone'); ?></p>
					</div>
				<?php } ?>

			<?php } ?>

		</div><!-- .entry-content -->

		<!-- Mostra o meta do post -->
		<footer class="entry-footer default-max-width mb-5">
			<?php //twenty_twenty_one_entry_meta_footer(); 
			?>

			<?php
			// função com Categorias, Tags e Editar
			funcao_post_footer();
			?>

			<div class="row">
				<div class="col-md-12 texto-disclaimer">
					<span>As informações apresentadas nas redes foram providas pelas instituições e não são de responsabilidade da equipe da Torre MCTI</span>
				</div>
				<div class="col-md-6">

					<?php
					// função com "like em"
					echo do_shortcode('[posts_like_dislike id=' . get_the_ID() . ']'); ?>
				</div>
				<div class="col-md-6 social-media-rcc">
					<?php
					// Ícones de compartilhamento
					echo do_shortcode('[shortcode_social_links]'); ?>
				</div>
			</div>

		</footer><!-- .entry-footer -->

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
