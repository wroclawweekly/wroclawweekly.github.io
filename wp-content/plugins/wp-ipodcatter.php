<?php
/*
Plugin Name: WP-iPodCatter
Version: 14-February-2007
Plugin URI: http://www.garrickvanburen.com/wpipodcatter/
Description: WP-iPodCatter gets your podcast ready for iTunes' Podcast directory. Set it up in <a href="options-general.php?page=wp-ipodcatter.php">'Options'-> WP-iPodCatter</a>. If you this plugin works for you, <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=garrick%40podcastmn%2ecom&item_name=WP%2diPodCatter%20Plugin&amount=15%2e00&no_shipping=0&no_note=1&tax=0&currency_code=USD&bn=PP%2dDonationsBF&charset=UTF%2d8">support its development</a>.
Author: Garrick Van Buren
Author URI: http://garrickvanburen.com/
*/

if(is_plugin_page()) { 
	wp_ipodcatter_config(); 
} else {

/* Check for / Initialize basic settings */
if (!(get_option('wp_ipodcatter_version'))) {
	add_option('wp_ipodcatter_version');
}





function wp_ipodcatter_process() {

	if(isset($_POST['itunesAdminName'])) { update_option('itunesAdminName', $_POST['itunesAdminName']); }
	if(isset($_POST['itunesAdminEmail'])) { update_option('itunesAdminEmail', $_POST['itunesAdminEmail']); }
	if(isset($_POST['itunesSubtitle'])) { update_option('itunesSubtitle', $_POST['itunesSubtitle']); }
	if(isset($_POST['itunesUseKeyword'])) { update_option('itunesUseKeyword', $_POST['itunesUseKeyword']); }
	if(isset($_POST['channelCat'])) { update_option('channelCat', $_POST['channelCat']); }
	if(isset($_POST['itunesDefaultCategories'])) { update_option('itunesDefaultCategories',  $_POST['itunesDefaultCategories']); }
	if(isset($_POST['itunesLocalPath'])) { update_option('itunesLocalPath', $_POST['itunesLocalPath']); }
	if(isset($_POST['itunesImageBig'])) { update_option('itunesImageBig', $_POST['itunesImageBig']); }
	if(isset($_POST['itunesImageSmall'])) { update_option('itunesImageSmall', $_POST['itunesImageSmall']); } 	
	
	$commentcast = isset( $_POST['itunesCommentCast'] ) ?
				   $_POST['itunesCommentCast'] :
				   array();
				   
	if(count($commentcast) > 0) { 
		update_option('itunesCommentCast', 'yes'); 
	} else {
		update_option('itunesCommentCast', 'no');	 
	}
	
	$explicit = isset( $_POST['itunesDefaultExplicit'] ) ?
				   $_POST['itunesDefaultExplicit'] :
				   array();
				   
	if(count($explicit) > 0) { 
		update_option('itunesDefaultExplicit', 'yes'); 
	} else {
		update_option('itunesDefaultExplicit', 'no');	 
	}
	
	$location = get_option('siteurl') . '/wp-admin/admin.php?page=wp-ipodcatter.php';
	header('Location: '.$location);
	
}

if(isset($_POST['submitted'])) { wp_ipodcatter_process(); }

	




/*
Function: Output HTML to render Config page
Parameters: None
Run by: wp-ipodcatter.php
*/
function wp_ipodcatter_config() {
	
	$itunesAdminName = get_option('itunesAdminName');
	$itunesAdminEmail  = get_option('itunesAdminEmail');
	$itunesSubtitle = get_option('itunesSubtitle');
	$itunesDefaultExplicit  = get_option('itunesDefaultExplicit');
	$itunesDefaultCategories = get_option('itunesDefaultCategories');
	$itunesUseKeyword  = get_option('itunesUseKeyword');
	$itunesLocalPath  = get_option('itunesLocalPath');
	$itunesImageBig  = get_option('itunesImageBig');
	$itunesImageSmall  = get_option('itunesImageSmall');  
	$channelCat  = get_option('channelCat');  
		 
	if ($itunesCommentCast == "yes") {
		$itunesCommentCast = 'checked="checked"';
	}
	
	if ($itunesDefaultExplicit == "yes") {
		$itunesDefaultExplicit = 'checked="checked"';
	}
	
		$itunesAdminName = get_option('itunesAdminName');
	$itunesAdminEmail  = get_option('itunesAdminEmail');
	$itunesSubtitle = get_option('itunesSubtitle');
	$itunesDefaultExplicit  = get_option('itunesDefaultExplicit');
	$itunesDefaultCategories = get_option('itunesDefaultCategories');
	$itunesUseKeyword  = get_option('itunesUseKeyword');
	$itunesLocalPath  = get_option('itunesLocalPath');
	$itunesImageBig  = get_option('itunesImageBig');
	$itunesImageSmall  = get_option('itunesImageSmall');  
	$channelCat  = get_option('channelCat');  
		 
	if ($itunesCommentCast == "yes") {
		$itunesCommentCast = 'checked="checked"';
	}
	
	if ($itunesDefaultExplicit == "yes") {

		$itunesDefaultExplicit = 'checked="checked"';
	}
	
	
?>
<div class="wrap">
	<h2>Configure for iTunes Podcast</h2>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

	<table width="100%" cellspacing="2" cellpadding="5" class="editform">
	<tr valign="top"> 
	<th width="33%" scope="row">iTunes:Subtitle</th> 
	<td><textarea type="text" name="itunesSubtitle" max="255" id="itunesSubtitle" rows="4" cols="40"><?php echo stripslashes( $itunesSubtitle ); ?></textarea><br />(255 characters)</td></tr>
 
	<tr valign="top"> 
	<th width="33%" scope="row">iTunes:Keywords</th> 
	<td><fieldset style="width:60%"><legend>Set:</legend>
	
		   <label><input name="itunesUseKeyword"  type="radio" value="0" <?php if (!$itunesUseKeyword) { echo 'checked="checked"'; } ?> /> Using WordPress Categories</label><br />
		   <label><input name="itunesUseKeyword" type="radio" value="1" <?php if ($itunesUseKeyword) { echo 'checked="checked"'; } ?> /> By hand</label></fieldset>

	<tr valign="top"> 
	<th width="33%" scope="row">iTunes:Explicit</th> 
	<td><input type="checkbox" name="itunesDefaultExplicit" id="itunesDefaultExplicit" <?php echo $itunesDefaultExplicit; ?>/> Yes, default all podcasts to Explicit.</td></tr> 
	</table>
	<br />
	<a name="selcatlist"></a> 
	<fieldset class="options">
	<legend>Categories</legend>
	<table width="100%" cellspacing="2" cellpadding="5" class="editform">
	<tr valign="top"> 
	<th width="33%" scope="row">Channel Category</th> 
	<td><input name="channelCat" type="text" id="channelCat" value="<?php echo $channelCat; ?>" size="45%" /><br />Anything you want. This is for everyone except iTunes.</td></tr>

	<tr valign="top">
	<th width="33%" scope="row"><a href="#itunescategories">iTunes:Categories</a></th> 
	<td><input type="text" name="itunesDefaultCategories" value="<?php echo $itunesDefaultCategories; ?>" size="45%"><br />
		enter up to 3 and separate multiples with commas. Indicate subcategories with colons.
		<em>i.e. Cat1, Cat2:SubCatA</em></td>
	</tr>
	</table>
	</fieldset>
	<br />
	<fieldset class="options">
	<legend>iTunes:Owner - Visible in the RSS feed</legend>
	<table width="100%" cellspacing="2" cellpadding="5" class="editform">
	<tr valign="top"> 
		<th width="33%" scope="row">Name:</th> 
		<td><input name="itunesAdminName" type="text" id="itunesAdminName" value="<?php echo stripslashes($itunesAdminName); ?>" size="40" /></td> 
	  </tr>

	  <tr valign="top"> 
		<th width="33%" scope="row">E-mail address:</th> 
		<td><input name="itunesAdminEmail" type="text" id="itunesAdminEmail" value="<?php if ($itunesAdminEmail) { echo $itunesAdminEmail; } else { form_option('admin_email'); } ?>" size="40" /></td> 
	  </tr>
	</table>
	</fieldset>
	<br />


	<fieldset class="options">
	<legend>Podcast Cover Image URLs</legend>
	<table width="100%" cellspacing="2" cellpadding="5" class="editform">
	<tr valign="top"> 
	<th width="33%" scope="row">Big (300*300 pixels)</th> 
	<td>
	<input type="text" name="itunesImageBig" value="<?php if ($itunesImageBig) { echo $itunesImageBig; } else { echo get_settings('siteurl'); } ?>" size="40" />
	<?php if ($itunesImageBig) { ?><br /><img src="<?php echo $itunesImageBig; ?>" width="300" height="300" alt="Podcast Image - Big"/><?php } ?>
	</td></tr>
	
	<tr valign="top"> 
	<th width="33%" scope="row">Small (144*144 pixels)</th> 
	<td>
	<input type="text" name="itunesImageSmall" value="<?php if ($itunesImageSmall) { echo $itunesImageSmall; } else { echo get_settings('siteurl'); } ?>" size="40" />
	<?php if ($itunesImageSmall) { ?><br /><img src="<?php echo $itunesImageSmall; ?>" width="144" height="144" alt="Podcast Image - Small"/><?php } ?>
	</td></tr>
	</table>
	</fieldset>
	<br />
	<table>
	<tr valign="top">
	<th width="33%" scope="row">Comments Feed Podcast</th> 
	<td><input type="checkbox" name="itunesCommentCast" id="itunesCommentCast" <?php echo $itunesCommentCast; ?> /> Yeah, I'm comment-casting. <em>(Use the replacement wp-commentsrss2.php file)</em></td>
	</tr> 
	
	<!--//<tr valign="top"> 
	<th width="33%" scope="row">Local path to audio files</th> 
	<td><input type="text" name="itunesLocalPath" size="40" id="itunesLocalPath" value="<?php if ($itunesLocalPath) { echo $itunesLocalPath; } else { echo ABSPATH; } ?>" />
	<br />This is for automatically detecting duration.<br />Only set if the audio files are on the same server as WordPress.</td></tr>//-->
	</table>
		
	<input type="hidden" name="submitted" value="submitted" />
	<p class="submit"> 
	<input type="submit" name="Submit" value="Update Options &raquo;" /> 
	</p> 
	</form> 

	<fieldset class="options">
		<legend>Helpful Things</legend>
		<p>The itunes:author and dc:creator tags get their values from the post's author's first and last name, set in User's profile.</p>
	<p>Additional thanks to: Bruce Moyle, Ashley Bartlett, <a href="http://www.haystack.co.uk">Christian Wach</a></p>
	<?php wp_iTunesCategoryList(); ?>
	</fieldset>

</div>
</body>
</html> 

<?php
}







function wp_ipodcatter_form() {

   	global $wpdb, $month, $postdata;
	
	if (($_GET['action'] == 'edit')) {
	
		$post_id = $_GET['post'];
		
		$itunesKeywords = $wpdb->get_var(
			"SELECT meta_value FROM $wpdb->postmeta ".
			"WHERE meta_key = 'itunes:keywords' ".
			"AND post_id = '$post_id'"
		);
		
		$itunesKeywords = stripslashes($itunesKeywords);
		
		$itunesDur = $wpdb->get_var(
			"SELECT meta_value FROM $wpdb->postmeta ".
			"WHERE meta_key = 'itunes:duration' ".
			"AND post_id = '$post_id'"
		);
		
		$itunesExplicit = $wpdb->get_var(
			"SELECT meta_value FROM $wpdb->postmeta ".
			"WHERE meta_key = 'itunes:explicit' ".
			"AND post_id = '$post_id'"
		);
		
		if (!$itunesExplicit) {
			$itunesExplicit = "no";
		} else {
			$itunesExplicit = 'checked="checked"';
		}
		
		$itunesBlock = $wpdb->get_var(
			"SELECT meta_value FROM $wpdb->postmeta ".
			"WHERE meta_key = 'itunes:block' ".
			"AND post_id = '$post_id'"
		);
		
		if ($itunesBlock == "yes") {
			$itunesBlock = 'checked="checked"';
		}
		
	}

		?>
			<div class="dbx-box-wrapper">
			<fieldset id="postexcerpt" class="dbx-box">
			<div class="dbx-handle-wrapper">
			<h3 class="dbx-handle">iTunes Podcast Tags</h3>
			</div>
			<div class="dbx-content-wrapper">
			<div class="dbx-content">

		<?php if (get_option('itunesUseKeyword')) { ?>
			<p>
			<label><strong>Keywords</strong>: Separate multiples with commas</label><br />
			<textarea name="itunesKeywords" rows="4" cols="40" max="254"><?php echo $itunesKeywords; ?></textarea>
			</p>
	   <?php } ?>


			<p>
			<label><strong>Duration</strong> (hh:mm:ss)</label><br />
			<input type="text" name="itunesDur" value="<?php echo $itunesDur; ?>" size="10">
			</p>

			<?php if (!$itunesExplicit && (get_option('itunesDefaultExplicit') == "yes")) { $itunesExplicit = 'checked="checked"'; } ?>

			<p>
			<label><strong>Explicit</strong></label><br />
			<input type="checkbox" name="itunesExplicit" <?php echo $itunesExplicit; ?>> Yes, Headphones Required
			</p>
			<p>
			<label><strong>Block</strong></label><br />
			 <input type="checkbox" name="itunesBlock" <?php echo $itunesBlock; ?>> Hide from iTunes
			</p>
			</div>
			</div>
			</fieldset>
			</div>
			<?php
}







function return_itunes_defaultCats() {

	$AllCats = get_option('itunesDefaultCategories');
	$Icategories = explode("," , $AllCats);
	
	foreach ($Icategories as $Icategory) { 
		if (stristr($Icategory, ":")) {		   
			$allcats = $allcats . return_itunes_subcats($Icategory);
		} else {
			$allcats = $allcats . '<itunes:category text="'. str_replace("&", "&amp;", trim($Icategory)) .'" />'."\n";
		}
	}
	
	echo $allcats;
}




function return_itunes_cats($post_id) {

	global $wpdb;	
	
	$value = $wpdb->get_var(
		"SELECT meta_value FROM $wpdb->postmeta ".
		"WHERE post_ID = '$post_id' ".
		"AND meta_key = 'itunes:category'"
	);
	
	$Icategories = explode("," , $value);
	
	if ($value) {
		$allcats = "";
		foreach ($Icategories as $Icategory) {
			if (stristr($Icategory, ":")) {		   
				$allcats = $allcats . return_itunes_subcats($Icategory);
			} else {
				$allcats = $allcats . '<itunes:category text="'. str_replace("&", "&amp;", trim($Icategory)).'" />'."\n"; 
			}
		}
	 
		echo $allcats;
		
	}
	
}





function return_itunes_subcats($AllCats) {

		$subCats = explode(":", $AllCats);
		$topCat = $subCats[0];
		$subCats = array_slice($subCats, 1);
				
		foreach ($subCats as $subCat) {
			$subCatTags = $subCatTags . '<itunes:category text="'. str_replace("&", "&amp;", trim($subCat)).'" />'."\n"; 
		}
			 
		return '<itunes:category text="'. str_replace("&", "&amp;", trim($topCat)) .'" >'. $subCatTags . '</itunes:category>'."\n";
}





function return_itunes_keywords($post_id) {

	global $wpdb;	
	
	if (get_option('itunesUseKeyword')) {
		$value = $wpdb->get_var(
			"SELECT meta_value FROM $wpdb->postmeta ".
			"WHERE post_ID = '$post_id' ".
			"AND meta_key = 'itunes:keywords'"
		);
		
		$allkeys = $value;
		
	} else {
	
		$categories = get_the_category();
		
		foreach ($categories as $category) {
			$category->cat_name = convert_chars($category->cat_name);
			$allkeys = $allkeys . $category->cat_name . ",";			
		}
		
		$allkeys = trim($allkeys);
		
	}
	
	// write
	echo "<itunes:keywords>" . $allkeys ."</itunes:keywords>"."\n";
	
}





function return_itunes_explicit($post_id) {

	global $wpdb;	
	
	$value = $wpdb->get_var(
		"SELECT meta_value FROM $wpdb->postmeta ".
		"WHERE post_ID = '$post_id' ".
		"AND meta_key = 'itunes:explicit'"
	);
	
	if ($value) {
		echo "<itunes:explicit>Yes</itunes:explicit>"."\n";
	} else {
		echo "<itunes:explicit>No</itunes:explicit>"."\n";
	}
	
}





function return_itunes_block($post_id) {

	global $wpdb;	
	
	$value = $wpdb->get_var(
		"SELECT meta_value FROM $wpdb->postmeta ".
		"WHERE post_ID = '$post_id' ".
		"AND meta_key = 'itunes:block'"
	);	
	
	if ($value) {
		echo "<itunes:block>Yes</itunes:block>"."\n";
	} else {
		echo "<itunes:block>No</itunes:block>"."\n";
	}
	
}






function return_itunes_dur($post_id) {
	global $wpdb;	
	
	$theDur = "";
    $hasDur = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta ". "WHERE post_ID = '$post_id' ". "AND meta_key = 'itunes:duration'" );	
	
    // test for empty
    if ( $hasDur AND $hasDur != '' AND isset( $hasDur ) ) { $theDur = "<itunes:duration>".$hasDur."</itunes:duration>"."\n"; } 	
    echo $theDur;
}






function return_itunes_content_rss($more_link_text='(more...)', $stripteaser=0, $more_file='', $cut = 0, $encode_html = 0) {
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = apply_filters('the_content_rss', $content);
	if ($cut && !$encode_html) {
		$encode_html = 2;
	}
	if ($encode_html == 1) {
		$content = wp_specialchars($content);
		$cut = 0;
	} elseif ($encode_html == 0) {
		$content = make_url_footnote($content);
	} elseif ($encode_html == 2) {
		$content = strip_tags($content);
	}
	if ($cut) {
		$blah = explode(' ', $content);
		if (count($blah) > $cut) {
			$k = $cut;
			$use_dotdotdot = 1;
		} else {
			$k = count($blah);
			$use_dotdotdot = 0;
		}
		for ($i=0; $i<$k; $i++) {
			$excerpt .= $blah[$i].' ';
		}
		$excerpt .= ($use_dotdotdot) ? '...' : '';
		$content = $excerpt;
	}
	$content = str_replace(']]>', ']]&gt;', $content);
	
	echo str_replace("&", "%26", substr($content, 0, 4000));
}





function return_itunes_excerpt_rss() {
	$output = get_the_excerpt(true);
	echo substr(str_replace("&", "%26", apply_filters('the_excerpt_rss', $output)), 0, 254);
}






function wp_ipodcatter_save_post($post_id) {  

	if ($_POST['itunesExplicit']) { $itunesExplicit = "yes"; } else { $itunesExplicit = "no";  }
	if ($_POST['itunesBlock']) { $itunesBlock = "yes"; } else { $itunesBlock = "no";  }   
	if ($_POST['itunesDur']) { $itunesDur = $_POST['itunesDur']; }
	if ($_POST['itunesKeywords']) { $itunesKeywords = $_POST['itunesKeywords']; }
	if ($_POST['itunesCat']) { $itunesCat = $_POST['itunesCat']; }
			
	 //mail(get_settings('admin_email'), $itunesCat . " " . $itunesExplicit . " " . $itunesDur, "" . $itunesKeywords . " " . $itunesBlock);

	wp_ipodcatter_meta_update(
		$post_id, $itunesCat, $itunesExplicit, $itunesDur, $itunesKeywords, $itunesBlock
	);
	
}


function wp_ipodcatter_meta_update(
	$post_id, $itunesCat, $itunesExplicit, $itunesDur, $itunesKeywords, $itunesBlock
) { //-->

	global $wpdb;
	
	/// EXPLICIT
	if ($itunesExplicit) {
	
		if ($itunesExplicit == "no") { $itunesExplicit = ""; }

		$oldExCheck = $wpdb->get_var(
			"SELECT meta_value FROM $wpdb->postmeta ".
			"WHERE meta_key = 'itunes:explicit' ".
			"AND post_id = '$post_id'"
		);

		if ($oldExCheck AND !$itunesExplicit) {
			$result = $wpdb->query(
				"DELETE FROM $wpdb->postmeta ".
				"WHERE post_id = $post_id ".
				"AND meta_key = 'itunes:explicit'"
			);
			
			//mail(get_settings('admin_email'), "itunes:explicit updated = ".  $result, "");
			
		} 
		
		if ($itunesExplicit AND !$oldExCheck) {
		
			$result = $wpdb->query(
				"INSERT INTO $wpdb->postmeta (".
					"post_id, meta_key, meta_value".
				") VALUES (".
					"'$post_id','itunes:explicit','$itunesExplicit'".
				")"
			);
			
			//mail(get_settings('admin_email'), "itunes:explicit inserted = ".  $result, "");
			
		}

	}
	///
	
	
	
	/// BLOCK
	if ($itunesBlock) {
		
		if ($itunesBlock == "no") { $itunesBlock = ""; }
		
		$oldBlCheck = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta "."WHERE meta_key = 'itunes:block' "."AND post_id = '$post_id'" );

		if ($oldBlCheck && !$itunesBlock) { 
		  $result = $wpdb->query("DELETE FROM $wpdb->postmeta "."WHERE post_id = $post_id "."AND meta_key = 'itunes:block'"); 
        }
		
		if ($itunesBlock && !$oldBlCheck)  {
		  $result = $wpdb->query("INSERT INTO $wpdb->postmeta ("."post_id, meta_key, meta_value".") VALUES ("."'$post_id','itunes:block','$itunesBlock'". ")");
		}

	}
	///
	

	/// DURATION --> must be set and not empty
	if ($itunesDur) {

		// get current value
		$oldDurCheck = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta ". "WHERE meta_key = 'itunes:duration' ". "AND post_id = '$post_id'");

		// if we have one, update...
		if ($oldDurCheck) {
			$result = $wpdb->query("UPDATE $wpdb->postmeta ". "SET meta_value = '$itunesDur' ". "WHERE post_id = $post_id ". "AND meta_key = 'itunes:duration'");
		
		// otherwise insert new
		} else {
			$result = $wpdb->query("INSERT INTO $wpdb->postmeta (". "post_id, meta_key, meta_value". ") VALUES (". "'$post_id','itunes:duration','$itunesDur'". ")");
    	}
		
	}

	////



	 /// KEYWORDS
	if ($itunesKeywords) {
		
		$oldKeyCheck = $wpdb->get_var(
			"SELECT meta_value FROM $wpdb->postmeta ".
			"WHERE meta_key = 'itunes:keywords' ".
			"AND post_id = '$post_id'"
		);
	
		if ($oldKeyCheck) {
		
			$result = $wpdb->query(
				"UPDATE $wpdb->postmeta ".
				"SET meta_value = '$itunesKeywords' ".
				"WHERE post_id = '$post_id' ".
				"AND meta_key = 'itunes:keywords'"
			);
			
		} else {
		
			$result = $wpdb->query(
				"INSERT INTO $wpdb->postmeta (".
					"post_id, meta_key, meta_value".
				") VALUES (".
					"'".$post_id."','itunes:keywords','$itunesKeywords'".
				")"
			);
			
		}
		
	}
	/// 
	

}






///// THIS IS FOR ENABLING COMMENT-PODCASTS ////
function wp_ipodder_comment_do_enclose($comment_ID) {

	global $wp_version, $wpdb;

	$comment = $wpdb->get_var(
		"SELECT comment_content FROM $wpdb->comments ".
		"WHERE comment_ID = '$comment_ID'"
	);
	
	$post_ID = $wpdb->get_var(
		"SELECT comment_post_ID FROM $wpdb->comments ".
		"WHERE comment_ID = '$comment_ID'"
	);
		
	include_once (ABSPATH . WPINC . '/class-IXR.php');

	$log = debug_fopen(ABSPATH . '/enclosures.log', 'a');
	$post_links = array();
	debug_fwrite($log, 'BEGIN '.date('YmdHis', time())."\n");

	$pung = wp_ipodder_comment_get_enclosed($comment_ID, $post_ID);

	$ltrs = '\w';
	$gunk = '/#~:.?+=&%@!\-';
	$punc = '.:?\-';
	$any = $ltrs . $gunk . $punc;

	preg_match_all("{\b http : [$any] +? (?= [$punc] * [^$any] | $)}x", $comment, $comment_links_temp);

	debug_fwrite($log, 'Comment contents:');
	debug_fwrite($log, $commentInfo->comment_content."\n");

	foreach($comment_links_temp[0] as $link_test) :
	
		if ( !in_array($link_test, $pung) ) : // If we haven't pung it already
			$test = parse_url($link_test);
			if (isset($test['query']))
				$comment_links[] = $link_test;
			elseif(($test['path'] != '/') && ($test['path'] != ''))
				$comment_links[] = $link_test;
		endif;

	endforeach;

	foreach ($comment_links as $url) :
	
		if ( $url != '' && !$wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE post_id = '$post_ID' AND meta_key = 'com-enclosure' AND meta_value LIKE ('$url%')") ) {
		
			if ( $headers = wp_get_http_headers( $url) ) {
			
				$len  = (int) $headers['content-length'];
				$type = addslashes( $headers['content-type'] );
				$allowed_types = array( 'video', 'audio' );
				
				if( in_array( substr( $type, 0, strpos( $type, "/" ) ), $allowed_types ) ) {
					$meta_value = "$comment_ID\n$url\n$len\n$type\n";
					
					$wpdb->query( "INSERT INTO `$wpdb->postmeta` ( `post_id` , `meta_key` , `meta_value` )
					VALUES ( '$post_ID', 'com-enclosure' , '$meta_value')" );
				}
				
			}
			
		}
		
	endforeach;
	
}





// Get enclosures already enclosed for a comment
function wp_ipodder_comment_get_enclosed(

	$comment_id, $post_id
	
) { //-->

	global $wpdb;
	
	$custom_fields = get_post_custom( $post_id );
	$pung = array();
	
	if( is_array( $custom_fields ) ) {
		while( list( $key, $val ) = each( $custom_fields ) ) { 
			if( $key == 'com-enclosure' ) {
				if (is_array($val)) {
					foreach($val as $enc) {
						$enclosure = split( "\n", $enc );
						if (trim($enclosure[0]) == $comment_id) {
						  $pung[] = trim( $enclosure[0] );
						}
					}
				}
			}
		}
	}
	
	// --<
	return $pung;
	
}





// Get enclosures already enclosed for a comment
function return_comment_enclosure(

	$comment_ID, $post_ID

) { //-->

	global $wpdb;
	
	$custom_fields = get_post_custom( $post_ID );
	$pung = array();
	
	if( is_array( $custom_fields ) ) {
	
		while( list( $key, $val ) = each( $custom_fields ) ) { 
			if( $key == 'com-enclosure' ) {
				if (is_array($val)) {
					foreach($val as $enc) {
						$enclosure = split( "\n", $enc );
						if (trim($enclosure[0]) == $comment_ID) {
						  $enclosureTag = '<enclosure url="'.$enclosure[1].'" length="'.$enclosure[2].'" type="'.$enclosure[3].'" />';
						}
					}
				}
			}
		}
	}

	echo $enclosureTag;
	
}






function wp_iTunesCategoryList() {
?>
	<p><form><a name="itunescategories"></a>iTunes Categories (<a href="<?php if ($_SERVER['HTTP_REFERER'] == "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) { echo "#selcatlist"; } else { echo $_SERVER['HTTP_REFERER']; } ?>">Return</a>)<br /><textarea rows="30" cols="30">
Arts
:Design
:Fashion & Beauty
:Food
:Literature
:Performing Art
:Visual Arts

Business
:Business News
:Careers
:Investing
:Management & Marketing
:Shopping

Comedy,

Education
:Education Technology
:K-12
:Higher Ed
:Language Courses
:Training

Games & Hobbies
:Automotive
:Aviation
:Hobbies
:Other Games
:Video Games

Government & Organizations
:Local
:National
:Non-Profit
:Regional

Health
:Alternative Health
:Fitness & Nutrition
:Self-Help
:Sexuality

Kids & Family,

Music,

News & Politics,

Religion & Spirituality
:Buddhism
:Christianity
:Hinduism
:Islam
:Judaism
:Other
:Spirituality

Science & Medicine
:Medicine
:Natural Sciences
:Social Sciences

Society & Culture
:History
:Personal Journals
:Philosophy
:Places & Travel

Sports & Recreation
:Amateur
:College & High School
:Outdoor
:Professional

Technology
:Gadgets
:IT News
:Podcasting
:Software How-To

TV & Film,

</textarea></form></p>
<?php
}






////////////////////////////////////////////////

/* Add WP-iPodCatter Tab to Options Menu */
function wp_ipodcatter_add_options_page() {
	if (function_exists('add_options_page')) { 
		add_options_page('WP-iPodCatter Configuration', 'WP-iPodCatter', 5, basename(__FILE__)); 
	}
}

/* If this is an admin page, run the function to Add WP-iPodCatter Tab to Options Menu */
add_action('admin_head', 'wp_ipodcatter_add_options_page');

// IF NOT, RUN EVERYTHING ELSE
add_action('simple_edit_form','wp_ipodcatter_form');	// DISPLAYS THE FORM IN THE SIMPLE FORM
add_action('edit_form_advanced','wp_ipodcatter_form');	// DISPLAYS THE FORM IN THE ADVANCED FORM
add_action('save_post','wp_ipodcatter_save_post');		// UPDATES AND SAVES THE POST
add_action('edit_post','wp_ipodcatter_save_post');		// UPDATES AND SAVES THE POST

if (get_option('itunesCommentCast') == "yes") {
	add_action('comment_post','wp_ipodder_comment_do_enclose');  // CHECKS THE COMMENT FOR ENCLOSURES
	add_action('edit_comment','wp_ipodder_comment_do_enclose');	 // CHECKS AN UPDATED COMMENT FOR ENCLOSURES
}

////////////////////////////////////////////////



}




?>
