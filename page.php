<?php
/**
 * The template for displaying all pages
 *
 * @package Ripper_Sports
 */

get_header();

get_template_part( 'template-parts/content', 'page' );

if ( comments_open() || get_comments_number() ) {
	comments_template();
}

get_footer();
