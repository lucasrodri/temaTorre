<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

/* Start the Loop */
while (have_posts()) :
	the_post();

	$rede_slug = "rede-de-suporte";
	$rede_name = nome_da_rede($rede_slug);
	$categoria_rede = "suporte_categoria_nova";

	dsgov_breadcrumb_extra_classificacao($rede_slug, $rede_name, $categoria_rede);

	get_template_part('template-parts/redes/redes-single');


endwhile; // End of the loop.

get_footer();
