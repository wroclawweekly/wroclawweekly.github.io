<div id="sidebar">
		<ul><li><h2><a href="<?php echo get_settings('home'); ?>" title="Main Page">Main Page</a></h2>
		</li>
		<li><h2><a href="http://www.wroclawweekly.pl/gallery/" title="Photo Gallery">Gallery</a></h2>
		</li>			
			<div class="hr"></div>
		<?php wp_list_pages('title_li=<h2>' . __('<a href="http://www.wroclawweekly.pl/wp-rss2.php?pages" title="Get the RSS feed!">This Week</a>') . '</h2>' ); ?>
		</li>
				<div class="hr"></div>
				
					<li><h2>Festival</h2>
					<ul><li><a href="<?php echo get_settings('home'); ?>/festivals/s0607/em2006.php" title="Enjoy Mondays 01.10.2006 - 18.12.2006">Enjoy Mondays</a></li></ul>
			</li>
			<li><h2>- Archive</h2>
					<ul><li><a href="http://www.wroclawweekly.pl/festivals/s0506/season0506.php" >Season 2005-2006</a></li></ul>
			</li>
			<div class="hr"></div>

				
				<li><h2><?php _e('Entries'); ?></h2>
				<ul><?php list_cats(0, '', 'name', 'asc', '', 1, 0, 1, 1, 1, 1, 0,'','','','','') ?></ul>
			</li>
			<div class="hr"></div>
			
					
		<?php get_links_list(); ?>
		<li>Syndicate us!<ul><li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>">
 <img src="<?php echo get_settings('home'); ?>/images/rssfeed.gif" alt="RSS Feed" title="RSS Feed" />
 </a></li>
 <li><a href="<?php echo get_settings('home'); ?>?feed=rss2&category_name=podcasts">
 <img src="<?php echo get_settings('home'); ?>/images/rsspodcast.gif" alt="Podcast" title="Podcast" />
 </a></li>
 </ul></li>
 <li>Get JUICE and subscribe to our Podcast! Available for Windows, Mac and Linux
 <ul><li><!-- start link to us code, for http://juicereceiver.sourceforge.net -->
<a href='http://juicereceiver.sourceforge.net/#download' title='Download Juice, the cross-platform podcast receiver' target='_blank'><img src="<?php echo get_settings('home'); ?>/images/badge_juice.gif" alt='Download Juice, the cross-platform podcast receiver' border='0' /></a><br />
<!-- end link to us code -->
</li></ul></li>
<li>This site is optimized for Firefox
<ul><li><a href="http://www.spreadfirefox.com/?q=affiliates&id=147088&t=82"><img border="0" alt="Get Firefox!" title="Get Firefox!" src="<?php echo get_settings('home'); ?>/images/spreadfirefox.gif"/></a>
</li></ul></li>
			<div class="hr"></div>
				<li><h2><?php _e(''); ?></h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional'); ?>"><?php _e('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>'); ?></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>
				


			
		</ul>
	</div>

