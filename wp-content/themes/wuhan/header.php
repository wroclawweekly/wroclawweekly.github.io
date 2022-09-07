<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> <?php } ?> <?php wp_title(); ?></title>
	
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<?php if (eregi("MSIE",getenv("HTTP_USER_AGENT")) ||
       eregi("Internet Explorer",getenv("HTTP_USER_AGENT"))) { ?><link rel=stylesheet type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/style-ie.css" />
<?php } else { ?>
<link rel=stylesheet type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/style.css" />
<?php } ?>

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<style type="text/css" media="screen"></style>
	

	<?php wp_get_archives('type=monthly&format=link'); ?>

	<?php wp_head(); ?>
</head>
<body>
	<div id="topbar">
	<div class="searchform"><?php include (TEMPLATEPATH . '/searchform.php'); ?></div>
	<div class="nav"><a href="<?php echo get_settings('home'); ?>">Home</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="<?php echo get_settings('home'); ?>/index.php/about-us/">About Us</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="<?php echo get_settings('home'); ?>/index.php/what-is-podcast/">What is Podcast?</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="<?php echo get_settings('home'); ?>/index.php/how-to-join/">How to Join</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="<?php echo get_settings('home'); ?>/index.php/contact/">Contact</a>&nbsp;&nbsp;|&nbsp;&nbsp;
</div>

	
	</div>
	<div id="headerimg"></div>
	
	
<div id="page-top"><div id="page-bottom"><div id="page">