<?php
/*
Plugin Name: Get Better Excerpt 
Plugin URI: http://thisismyurl.com/plugins/get-better-excerpt
Description: An easy to use WordPress function to add scheduled posts to any theme.
Author: Christopher Ross
Tags: future, upcoming posts, upcoming post, upcoming, draft, Post, scheduled, preview
Author URI: http://thisismyurl.com
Version: 0.1.3
*/

/*  Copyright 2008  Christopher Ross  (email : info@thisismyurl.com)

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



add_action('admin_menu', 'Easyget_better_excerpt_menu');

function Easyget_better_excerpt_menu() {
  add_options_page('Get Better Excerpt', 'Get Better Excerpt', 10,'Easyget_better_excerpt.php', 'Easyget_better_excerpt_options');
}

function Easyget_better_excerpt_options() {

?>
<div class="wrap">
    <div id="icon-options-general" class="icon32"><br /></div>
    <h2>Get Better Excerpt Settings</h2>
    
    
    
    <div id="poststuff" class="metabox-holder">
    <div class="inner-sidebar">
    <div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position:relative;">
    
    <div id="sm_pnres" class="postbox">
    <h3 class="hndle"><span>About this Plugin:</span></h3>
    <div class="inside">
    <ul class='options'>
    <style>.options a {text-decoration:none;}</style>
    <li><a href="http://www.thisismyurl.com/free-downloads/get-better-excerpt/">Plugin Homepage</a></li>
    <li><a href="http://wordpress.org/extend/plugins/get-better-excerpt/">Vote for this Plugin</a></li>
    <li><a href="http://forums.thisismyurl.com/">Support Forum</a></li>
    <li><a href="http://support.thisismyurl.com/">Report a Bug</a></li>
    <li><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5962435">Donate with PayPal</a></li>
    </ul>
    </div>
    </div>
 <?php  
	if (function_exists(zip_open)) {
	$file = "get-better-excerpt";
			$lastupdate = get_option($file."-update");
		if (strlen($lastupdate )==0 || date("U")-$lastupdate > $lastupdate) {
			$pluginUpdate = file_get_contents('http://downloads.wordpress.org/plugin/'.$file.'.zip');
			$myFile = "../wp-content/uploads/cache-".$file.".zip";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$stringData = $pluginUpdate;
			fwrite($fh, $stringData);
			fclose($fh);
			
			$zip = zip_open($myFile);
			while ($zip_entry = zip_read($zip)) {
				if (zip_entry_name($zip_entry) == $file."/".$file.".php") {$size = zip_entry_filesize($zip_entry);}
			}
			zip_close($zip);
			unlink($myFile);
			
			if ($size != filesize("../wp-content/plugins/".$file."/".$file.".php")) {?>    
			<div id="sm_pnres" class="postbox">
				<h3 class="hndle"><span>Plugin Status</span></h3>
				<div class="inside">
				<ul class='options'>
				<style>.options a {text-decoration:none;}</style>
				<li>This plugin is out of date. <a href='http://downloads.wordpress.org/plugin/<?php echo $file;?>.zip'>Please <strong>download</strong> the latest version.</a></li>
				</ul>
				</div>
				</div>
	<?php
		} 
		update_option($file."-update", date('U'));
    }}
	?>

    </div>
    </div>
    
    <div class="has-sidebar sm-padded" >
    
    <div id="post-body-content" class="has-sidebar-content">
    
    <div class="meta-box-sortabless">
    
    <!-- Rebuild Area -->
    <!-- Basic Options -->
    <div id="sm_basic_options" class="postbox">
    <h3 class="hndle"><span>Basic Options</span></h3>
    <div class="inside">
    <p class="hndle">This plugin has no Administation level settings. </p>
    </div>
    </div>
    
    <div id="sm_basic_options2" class="postbox">
      <h3 class="hndle"><span>Read Me File Contents</span></h3>
    <div class="inside">
      <?php 
	  $contents = file_get_contents('../wp-content/plugins/get-better-excerpt/readme.txt');
	  $contents = str_replace("\n","<br>",$contents);
	  echo $contents;
	  ?>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
</div>
<?php
}










function get_better_excerpt($options='') {
    global $post, $wpdb;
	
	$ns_options = array(
                    "words" => "20",
                    "before"  => "",
                    "after" => "",
					"show" => false,
					"skipexcerpt" => true,
					"link" => false,
					"trail" => "&#8230;",
                   );

	$options = explode("&",$options);
	
	foreach ($options as $option) {
	
		$parts = explode("=",$option);
		$options[$parts[0]] = $parts[1];
	
	}
	
	if ($options['words']) {$ns_options['words'] = $options['words'];}
	if ($options['before']) {$ns_options['before'] = $options['before'];}
	if ($options['after']) {$ns_options['after'] = $options['after'];}
	if ($options['show']) {$ns_options['show'] = $options['show'];}
	if ($options['skipexcerpt']) {$ns_options['skipexcerpt'] = $options['skipexcerpt'];}
	if ($options['link']) {$ns_options['link'] = $options['link'];}
	if ($options['trail']) {$ns_options['trail'] = $options['trail'];}
	
	global $more;
	$more = 1;
	
	if ($ns_options['skipexcerpt']) {
		$excerpt = explode(' ', strip_tags(get_the_content()), $ns_options['words']+1);
	} else {
		$excerpt = explode(' ', strip_tags(get_the_excerpt()), $ns_options['words']+1);
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