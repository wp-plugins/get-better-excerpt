=== Plugin Name ===
Contributors: christopherross
Plugin URI: http://www.thisismyurl.com/software/get-better-excerpt
Tags: wordpress,theme,excerpt,words, plugin, post, posts
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5962435
Requires at least: 2.0.0
Tested up to: 2.8.0
Stable tag: 1.0.0


The Get Better Excerpt plugin works almost identical to the built in get_the_excerpt() and the_excerpt() functions except it returns whole words instead of cutting off the excerpt as the existing function does.

== Description ==

The Get Better Excerpt plugin works almost identical to the built in get_the_excerpt() and the_excerpt() functions except it returns whole words instead of cutting off the excerpt as the existing function does.

== Installation ==

To install the plugin, please upload the folder to your plugins folder and active the plugin.

== Screenshots ==

== Updates ==
Updates to the plugin will be posted here, to [thisismyurl](http://www.thisismyurl.com/plugins/get-better-excerpt)

== Frequently Asked Questions ==

= How do I display the results? =

Insert the following code into your WordPress theme files: 

= General results =
ithout passing any parameters, the plugin will return ten results or fewer depending on how many posts you have.

 get_better_excerpt();


= Altering the before and after values =
By default the plugin wraps your code in list item (&lt;li&gt;) tags but you can specify how to format the results using the following code:

 get_better_excerpt('before=&lt;p&gt;&amp;after=&lt;/p&gt;');

= Adding a Link = 
If you'd like to link to the post (remember it's not live yet) you can do so by calling:

 get_better_excerpt('link=true'); 


= How many words? = 
You can specify the number of words returned using the option:

 get_better_excerpt('words=20'); 
 
 = Skip the excerpt? = 
If you would like to load the content directly, skipping the entered excerpt:

 get_better_excerpt('skipexcerpt=true'); 

 = Include a trailing character? = 
By default the plugin includes a ... after the excerpt, you can remove it or change it by altering:

 get_better_excerpt('trail= ...'); 

 = Return a whole sentence = 
If you would like to return whole sentences rather than words, you can control the number of sentences to return:

 get_better_excerpt('sentence=1'); 



= Echo vs. Return =
Finally, if you'd like to copy the results into a variable you can return the results as follows:

 get_better_excerpt('show=false'); 


== Donations ==
If you would like to donate to help support future development of this tool, please visit [thisismyurl](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5962435)


== Change Log ==

1.0.0 -
Official Release
Added Sentence options
