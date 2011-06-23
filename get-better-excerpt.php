<?php
/*
Plugin Name: Get Better Excerpt 
Plugin URI: http://thisismyurl.com/software/web-based/wordpress-plugins/get-better-excerpt-plugin-for-wordpress/
Description: An easy to use WordPress function to add scheduled posts to any theme.
Author: Christopher Ross
Tags: future, upcoming posts, upcoming post, upcoming, draft, Post, scheduled, preview
Author URI: http://thisismyurl.com
Version: 1.5
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

function thisismyurl_get_better_excerpt($options='') {

	$ns_options = array(
                    "sentence" => false,
                    "words" => "20",
                    "before"  => "",
                    "after" => "",
					"show" => false,
					"skipexcerpt" => true,
					"link" => false,
					"trail" => " &#8230;",
                   );

	$options = explode("&",$options);
	
	foreach ($options as $option) {
	
		$parts = explode("=",$option);
		$ns_options[$parts[0]] = $parts[1];
	
	}
	
	if ($ns_options['skipexcerpt']) {
		if ($ns_options['sentence']) {
			$excerpt = explode('.', strip_tags(get_the_content()), $ns_options['sentence']+1);
		} else {
			$excerpt = explode(' ', strip_tags(get_the_content()), $ns_options['words']+1);
		}
	} else {
		if ($ns_options['sentence']) {
			$excerpt = explode('.', strip_tags(get_the_excerpt()), $ns_options['sentence']+1);
		} else {
			$excerpt = explode(' ', strip_tags(get_the_excerpt()), $ns_options['words']+1);
		}	
	}
	
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt);
	$excerpt = $excerpt.$ns_options['trail'];
	
	if ($link) {
		$link = get_permalink();
		$title = get_the_title();
		$excerpt = "<a href='$link' title='$title'>".$excerpt."</a>";
	}
	
	$excerpt = $ns_options['before'].$excerpt.$ns_options['after'];

	if ($show) {echo $excerpt;} else {return $excerpt;}
	
}
?>