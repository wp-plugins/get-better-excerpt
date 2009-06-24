<?php
/*
Plugin Name: Get Better Excerpt 
Plugin URI: http://www.thisismyurl.com/software/get-better-excerpt
Description: An easy to use WordPress function to add scheduled posts to any theme.
Author: Christopher Ross
Tags: future, upcoming posts, upcoming post, upcoming, draft, Post, scheduled, preview
Author URI: http://www.thisismyurl.com
Version: 1.0.0
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



	/* Page Start */
	echo "
<div class='wrap'>
  <div id='icon-options-general' class='icon32'><br />
  </div>
  <h2>Get Better Excerpt Settings</h2>
  <form name='addlink' id='addlink' method='post' action='https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5962435'>
    <div id='poststuff' class='metabox-holder has-right-sidebar'>
      <div id='side-info-column' class='inner-sidebar'>
        <div id='side-sortables' class='meta-box-sortables'>
          <div id='linksubmitdiv' class='postbox ' >
            <div class='handlediv' title='Click to toggle'><br />
            </div>
            <h3 class='hndle'><span>Plugin Details</span></h3>
            <div class='inside'>
              <div class='submitbox' id='submitlink'>
                <div id='minor-publishing'>
                  <div style='display:none;'>
                    <input type='submit' name='save' value='Save' />
                  </div>
                  <div id='minor-publishing-actions'>
                    <div id='preview-action'> </div>
                    <div class='clear'></div>
                  </div>
                  <div id='misc-publishing-actions'>
                    <div class='misc-pub-section misc-pub-section-last'>
                          <ul class='options' style='padding-left: 20px;'>
							<style>.options a {text-decoration:none;}</style>
							<li><a href='http://www.thisismyurl.com/software/get-better-excerpt/'>Plugin Homepage</a></li>
							<li><a href='http://wordpress.org/extend/plugins/get-better-excerpt/'>Vote for this Plugin</a></li>
							<li><a href='http://forums.thisismyurl.com/'>Support Forum</a></li>
							<li><a href='http://support.thisismyurl.com/'>Report a Bug</a></li>";
							
							
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
	
				<li>This plugin is out of date. <a href='http://downloads.wordpress.org/plugin/<?php echo $file;?>.zip'>Please <strong>download</strong> the latest version.</a></li>
	
	<?php
		} 
		update_option($file."-update", date('U'));
}}
							
					echo "		</ul>
                    </div>
                  </div>
                </div>
                <div id='major-publishing-actions'>
                  <div id='delete-action'> </div>
                  <div id='publishing-action'>
                    <input name='save' type='submit' class='button-primary' id='publish' tabindex='4' accesskey='p' value='Donate' />
                  </div>
                  <div class='clear'></div>
                </div>
                <div class='clear'></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id='post-body'>
        <div id='post-body-content'>
          <div id='namediv' class='stuffbox'>
            <h3>
              <label for='link_name'>Settings</label>
            </h3>
            <div class='inside'><span class='hndle'>This plugin has no Administation level settings. To include excerpts in your themes, please follow the readme.txt instructions below.</span></div>
          </div>
          <div id='addressdiv' class='stuffbox'>
            <h3>
              <label for='link_url'>Readme File</label>
            </h3>
            <div class='inside'>
				  <pre>";
				  echo wordwrap(file_get_contents('../wp-content/plugins/get-better-excerpt/readme.txt'), 80, "\n",true);;
				  echo "</pre>
            </div>
          </div>
          <div id='normal-sortables' class='meta-box-sortables'></div>
          <div id='advanced-sortables' class='meta-box-sortables'> </div>
        </div>
      </div>
    </div>
  </form>
</div>
	";


}











function get_better_excerpt($options='') {
    global $post, $wpdb;
	
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
		$options[$parts[0]] = $parts[1];
	
	}
	
	if ($options['sentence']) {$ns_options['sentence'] = $options['sentence'];}
	if ($options['words']) {$ns_options['words'] = $options['words'];}
	if ($options['before']) {$ns_options['before'] = $options['before'];}
	if ($options['after']) {$ns_options['after'] = $options['after'];}
	if ($options['show']) {$ns_options['show'] = $options['show'];}
	if ($options['skipexcerpt']) {$ns_options['skipexcerpt'] = $options['skipexcerpt'];}
	if ($options['link']) {$ns_options['link'] = $options['link'];}
	if (isset($options['trail'])) {$ns_options['trail'] = $options['trail'];}
	
	global $more;
	$more = 1;
	
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