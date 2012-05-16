<?php
/*
Plugin Name: Get Better Excerpt
Plugin URI: http://thisismyurl.com/downloads/wordpress-plugins/get-better-excerpt
Description: Returns the excerpt using whole words instead of partial
Author: Christopher Ross
Tags: future, upcoming posts, upcoming post, upcoming, draft, Post, scheduled, preview
Author URI: http://thisismyurl.com
Version: 2.0.0
*/

/*  Copyright 2011  Christopher Ross  (email : info@christopherross.ca)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function thisismyurl_get_better_excerpt( $args = NULL ) {

	$defaults = 	array(
						'sentence' => false,
						'words' => '20',
						'before'  => '',
						'after' => '',
						'show' => false,
						'skipexcerpt' => true,
						'link' => false,
						'trail' => ' &#8230;',
					);
	$option = wp_parse_args( $args, $defaults );


	/** check to see this is at least WordPress 3.3 **/
	if ( function_exists( 'wp_trim_words' ) ) {

		if ( $option['skipexcerpt'] ) {

			if ( $option['sentence'] )
				$excerpt_array = explode( '.', strip_tags( get_the_content() ), $option['sentence']+1 );
			else
				$excerpt = wp_trim_words( get_the_content(), $option['words'], $option['trail'] );

		} else {

			if ( $option['sentence'] )
				$excerpt_array = explode( '.', strip_tags( get_the_excerpt() ), $option['sentence']+1 );
			else
				$excerpt = wp_trim_words( get_the_excerpt(), $option['words'], $option['trail'] );

		}

		if ( $excerpt_array )
			$excerpt = $excerpt_array[0] . ' ' . $option['trail'] ;


		if ( $option['link'] )
			$excerpt = '<a href="' . get_permalink() . '" title="' . esc_attr( get_the_title() ) . '">'.$excerpt.'</a>';

		$excerpt = $option['before'] . $excerpt . $option['after'];

		if ( $option['show'] )
			echo $excerpt;
		else
			return $excerpt;

	} else {

		/** the wp_trim_words() function doesn't exist **/

		if ( $option['show'] )
			echo get_the_excerpt();
		else
			return get_the_excerpt();

	}
}
