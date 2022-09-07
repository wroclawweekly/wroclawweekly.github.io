<div id="sidebar">
		<ul><li><h2><a href="<?php echo get_settings('home'); ?>" title="Main Page">Main Page</a></h2>
		</li>
		<li><h2><a href="http://www.youtube.com/WroclawWeekly" title="Our YouTube Page" target="_blank">YouTube</a> | <a href="http://itunes.apple.com/WebObjects/MZStore.woa/wa/viewPodcast?id=328578097" title="Subscribe to Our Podcast on iTunes!">Podcast on iTunes</a>
		<!--<a href="http://www.wroclawweekly.pl/gallery/" title="Photo Gallery" target="_blank">Gallery</a>-->
		</h2>
		</li>			
			<li><div class="hr"></div></li>
			
			
			
			
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
			
			
			
			
			
			
		<?php wp_list_pages('title_li=<h2>' . __('<a href="http://www.wroclawweekly.pl/index.php/feed/" title="Get the RSS feed!"><span style="font-family: Arial Black, Arial; font-size:12px;">This Week</span></a>') . '</h2>' ); ?>
		
			<li><div class="hr"></div></li>
				
					<li><h2>Festivals: 2008-2009</h2>
					&nbsp;» Coming Soon
					<!--<ul><li><a href="http://www.wroclawweekly.pl/index.php/czyli-wroclaw-artistic-festival/" title="18.05-21.05.2008 &amp; 27.05-29.05.2008">Czyli Wrocław</a></li></ul>
					<ul><li><a href="http://www.wroclawweekly.pl/index.php/mandala2008/" title="25.04.2008–27.04.2008">Mandala Performance Festival 2008</a></li></ul>
					<ul><li><a href="http://www.wroclawweekly.pl/index.php/harpsichord-days-4/" title="26.03.2008-30.03.2008">Harpsichord Music Days 2008</a></li></ul>
					<ul><li><a href="http://alliance.wroclaw.pl/jf/" title="07.03.2008-16.03.2008">Journ&eacute;es de la Francophonie 2008</a></li></ul>
					<ul><li><a href="http://www.wroclawweekly.pl/index.php/enjoy-mondays-2/" title="08.10.2007-17.12.2007">Enjoy Mondays 2</a></li></ul> -->
			</li>
			<li><h2>・Archive</h2>
					<ul><li><a href="http://www.wroclawweekly.pl/festivals/s0708/season0708.php" ><em>Season 2007-2008</em></a></li></ul>
					<ul><li><a href="http://www.wroclawweekly.pl/festivals/s0607/season0607.php" ><em>Season 2006-2007</em></a></li></ul>
					<ul><li><a href="http://www.wroclawweekly.pl/festivals/s0506/season0506.php" ><em>Season 2005-2006</em></a></li></ul>
			</li>
			<li><div class="hr"></div></li>

				
				<li><h2><?php _e('Entries'); ?></h2>
				<ul><?php list_cats(0, '', 'name', 'asc', '', 1, 0, 1, 1, 1, 1, 0,'','','','','') ?></ul>
			</li>
			<li><div class="hr"></div></li>
			
					
		<?php get_links_list(); ?>
		
		<?php endif; ?>
		
		<a name="podcast"></a>
		<li>Syndicate us!
		<ul><li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>">
 <img src="<?php echo get_settings('home'); ?>/images/rssfeed.gif" alt="RSS Feed" title="RSS Feed" />
 </a></li>
 <li><a href="http://feeds.feedburner.com/WroclawWeeklyPodcasts">
 <img src="<?php echo get_settings('home'); ?>/images/rsspodcast.png" alt="Podcast" title="Get Our Podcast URL" />
 </a></li>
 </ul></li>

<li>This site is optimized for Firefox
<ul><li><a href="http://www.spreadfirefox.com/?q=affiliates&amp;id=147088&amp;t=82"><img border="0" alt="Get Firefox!" title="Get Firefox!" src="<?php echo get_settings('home'); ?>/images/spreadfirefox.gif"/></a>
</li></ul></li>
			<li><div class="hr"></div></li>
				<li><h2><?php _e(''); ?></h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional'); ?>"><?php _e('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>'); ?></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>
				<li><ul>
				<!--<li>
    <a href="http://validator.w3.org/check?uri=referer">
    <img src="<?php echo get_settings('home'); ?>/images/valid-xhtml10.gif" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
  </li>
  -->
  <li><a href="http://jigsaw.w3.org/css-validator/check/referer">
  <img style="border:0;width:88px;height:31px" src="<?php echo get_settings('home'); ?>/images/vcss.gif" alt="Valid CSS!" /></a>
 	</li></ul></li>
<li align="right"><a href="http://www.simplicity.org.pl" title="We will make your life in Wrocław simple"><img src="http://www.wroclawweekly.pl/images/simplelogo_EN.jpg"  alt="The Simplicity Foundation"  title="We will make your life in Wrocław simple" /></a></li>

			
		</ul>
		 
  
	</div>

