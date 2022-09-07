<?php
/*
Plugin Name: KG-EnclosureFlex
Version: .5
Plugin URI: http://www.15framespersecond.com/enclosureflex/
Description: KG-EnclosureFlex gives you the flexibility to choose which files you want to enclose in your RSS feed, and allows you to suppress all enclosures if you want.
Author: Kyle Gilman
Author URI: http://www.kylegilman.net
*/

function kg_EnclosureFlex_BreakEnclose() { //Breaks the automatic Wordpress enclosure function

	global $wp_version, $wpdb;

	$result = $wpdb->query(
		"DELETE FROM $wpdb->postmeta ".
		"WHERE meta_key = '_encloseme' "
	);

}

function kg_enc_makelist()	{ //Makes a list of all links in the post.

	global $wp_version, $wpdb;
	
	$post_ID = $_GET['post'];
	
	$content = $wpdb->get_var(
		"SELECT post_content FROM $wpdb->posts ".
		"WHERE ID = '$post_ID'"
	);
	
	$post_links = array();

	$ltrs = '\w';
	$gunk = '/#~:.?+=&%@!\-';
	$punc = '.:?\-';
	$any = $ltrs . $gunk . $punc;

	preg_match_all("{\b http : [$any] +? (?= [$punc] * [^$any] | $)}x", $content, $content_links_temp);

	foreach($content_links_temp[0] as $url) :
		echo '<option value="'.$url.'"/>'.$url.'</option/>';
	endforeach;

}

function kg_EnclosureFlex_form() { //Adds enclosure options to the edit form

	?>
	
	<fieldset style="width:100%">
	<legend><strong>Enclosure Options</strong></legend>
	<select name="kg_EnclosureLink" size="1">
	<option value="">No Enclosure</option>
	<?php kg_enc_makelist(); ?>
	</select> Select Link to Enclose.
	</fieldset>
	<?php
}

function kg_EnclosureFlex_Write_Enclosures($post_ID) { //Writes enclosure to the database

	global $wp_version, $wpdb;

	if ($_POST['kg_EnclosureLink']) { $url = $_POST['kg_EnclosureLink']; }

	if ( $url != '' ) {
		if ( $headers = wp_get_http_headers( $url) ) {
			$len = (int) $headers['content-length'];
			$type = $wpdb->escape( $headers['content-type'] );
			$meta_value = "$url\n$len\n$type\n";
			$wpdb->query( "INSERT INTO `$wpdb->postmeta` ( `post_id` , `meta_key` , `meta_value` )
			VALUES ( '$post_ID', 'enclosure' , '$meta_value')" );
			
		}
	}
}

////////////////////////////////////////////////

add_action('edit_form_advanced','kg_EnclosureFlex_form'); //Add options to advanced edit page
add_action('simple_edit_form','kg_EnclosureFlex_form'); //Add options to simple edit page

add_action('save_post','kg_EnclosureFlex_Write_Enclosures'); //Writes enclosure to database

add_action('shutdown','kg_EnclosureFlex_BreakEnclose'); //Breaks the default WordPress enclosure process

////////////////////////////////////////////////

?>