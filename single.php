<?php
/**
 * The template for displaying all single posts
 *
 * @package Ripper_Sports
 */

get_header();

get_template_part( 'template-parts/content', 'single' );

if ( comments_open() || get_comments_number() ) {
	comments_template();
}

get_footer();
