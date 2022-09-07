<?php 
/* 
Plugin Name: My Custom Widgets
Plugin URI: http://www.janek-niefeldt.de/blog/mycustomwidget/ 
Description: Define your own widgets and include them into your theme.
Author: Janek Niefeldt 
Version: 1.4.1 
Author URI: http://www.janek-niefeldt.de/ 
*/ 

/*************************************************************/
/* Version History:					                                 */
/*************************************************************/
/*0.1 - widget definition needs to be hard-coded             */
/*0.2 - adding option screen, widget definition via textbox  */
/*0.3 - adding differentiation between HTML and PHP-code     */
/*0.4 - adding filter                                        */
/*0.5 - adding dropdown editing screen and singlesave option */  
/*0.6 - adding filter as parameters                          */
/*0.7 - modularize several tasks                             */
/*0.8 - adding configuration screen                          */
/*0.9 - adding widget-preview in development screen          */
/*1.0b - beta release                                        */
/*1.1b - fixing "apostrophe"-bug                             */
/*1.1 - adding option information                            */
/*1.2 - adding backup functionality and more help-buttons    */
/*1.2.1 - fixing "Jeffreys-use-case"-Bug                     */
/*1.2.2 - fixing stripslashes-bug in additional HTML-code    */
/*1.3 - redesign of code evaluation, adding debug-mode, filter bug */
/*1.3.1 - fixing global variable issue to work with other plugins */
/*1.4 - add AJAX components                                  */
/*1.4.1 - fix small coding bug (function: submit_form)       */  
/*************************************************************/

/*  
Copyright 2007  Janek Niefeldt (email: mail@janek-niefeldt.de)
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

/*********************************/
/***    constant parameters    ***/
/*********************************/
$mcw_plugin_folder = "mycustomwidget";
$mcw_widgetsoption = "mywidgets";
$mcw_prefix = "mcw_";
$mcw_configoption = "options";
$mcw_backup_postfix = "_backup";

$mcw_path = array( 'add'        => get_option('siteurl').'/wp-content/plugins/'.$mcw_plugin_folder.'/add.png',
                      'tool'       => get_option('siteurl').'/wp-content/plugins/'.$mcw_plugin_folder.'/tool.png', 
                      'edit'       => get_option('siteurl').'/wp-content/plugins/'.$mcw_plugin_folder.'/edit.png', 
                      'save'       => get_option('siteurl').'/wp-content/plugins/'.$mcw_plugin_folder.'/save.png', 
                      'remove'     => get_option('siteurl').'/wp-content/plugins/'.$mcw_plugin_folder.'/remove.png',
                      'preview'    => get_option('siteurl').'/wp-content/plugins/'.$mcw_plugin_folder.'/preview.png',
                      'info'       => get_option('siteurl').'/wp-content/plugins/'.$mcw_plugin_folder.'/info.png',
                      'style'      => '../wp-content/plugins/'.$mcw_plugin_folder.'/my_custom_widget_style.css',
                      'js_1'       => get_option('siteurl').'/wp-includes/js/scriptaculous/prototype.js',
                      'js_2'       => get_option('siteurl').'/wp-includes/js/scriptaculous/scriptaculous.js?load=effects');

/************************************/
/***    Start of Custom Widget    ***/
/************************************/
function MCW_plugin_init(){
  if ( !function_exists('register_sidebar_widget') )
		return;

/****************************/    
/*** start help-functions ***/
/****************************/  
  function MCW_get_url($param){
    global $mcw_path;
    return $mcw_path[$param];
  }
  
  function MCW_sort_my_elements($myelements, $primarykey = 0){
    // sorts your array after given primary key
    $liste = array();
    $erg = array();
    $max = count($myelements);
    for ( $i = 0; $i < $max; ++$i ) { 
      $liste[] = $myelements[$i][$primarykey];
    }
    //natcasesort($liste);
    sort($liste);
    //if (natcasesort($liste)) echo 'erfolgreich sortiert '.$primarykey.'<br>';
    //else 'nicht sortiert<br><br>';
    //print_r($liste);
    for ( $i = 0; $i < $max; ++$i ) {
      for ( $j = 0; $j < $max; ++$j ) {
        if ($myelements[$j][$primarykey] == $liste[$i]){
          $erg[] = $myelements[$j];
        }
      }
    }
    return $erg;
  }
  
  function MCW_get_widget_maintenance($MyWidget, $elements, $widgetindex = '', $fixheight = false){
    $data_widget_filter = $elements['filter'];
    $data_widget_kind = $elements['kind'];
    $data_widget_code = $elements['code'];
    $mcw_submit_trigger = $elements['submit'];
    
    $mcw_name = htmlspecialchars($MyWidget['name'], ENT_QUOTES);
		$mcw_kind = $MyWidget['kind'];
		$mcw_filter = $MyWidget['filter'];
		
	  echo '<div class="mcw-row-small"><nobr><label for="'.$data_widget_kind.$widgetindex.'_php"><input type="radio" id="'.$data_widget_kind.$widgetindex.'_php" name="'.$data_widget_kind.$widgetindex.'" value="php" checked="checked"> PHP</label></nobr>';
    echo '<nobr><label for="'.$data_widget_kind.$widgetindex.'_html"><input type="radio" id="'.$data_widget_kind.$widgetindex.'_html" name="'.$data_widget_kind.$widgetindex.'" value="html"'. mcw_check($mcw_kind,"html") .'> HTML</label></nobr></div>';
	  echo '<div class="mcw-row"><label for="mcw-code">'.MCW_get_codeinput($MyWidget, $data_widget_code, $widgetindex, $fixheight).'</label></div>';
	  echo '<div class="mcw-row-small">'.MCW_get_filters($data_widget_filter, $widgetindex, $mcw_filter).'</div>';
	  echo '<input type="hidden" name="'.$mcw_submit_trigger.$widgetindex.'" value="1" />';
  }
  	
  function MCW_get_codeinput($widget, $name, $widgetindex = '', $fixheight=false){
    $result='';
    if ($fixheight) {$maxheight = 180;}
    else {$maxheight=MCW_get_code_height();} 
    $mainheight=$maxheight;
    $subheight=0;
    $beforecode = trim(stripslashes($widget["beforecode"]));
    $showadd = ((MCW_add_html_allowed())||(!empty($beforecode)));
    if ($showadd) {
      $mainheight=0.7*$maxheight;
      $subheight=0.3*$maxheight;
    } else {
      $mainheight=$maxheight;
    }
    //cols="60" rows="5" 
    //overflow:hidden;
    $result=$result.'<div id="'.$name.$widgetindex.'_container_before'.'"><textarea cols="60" id="'.$name.$widgetindex.'_before'.'" name="'.$name.$widgetindex.'_before'.'" style="height:'.$subheight.'px;'; 
    if ($showadd) {$result=$result.'display:block;';} else {$result=$result.'display:none;';}
    $result=$result.' font-family:Courier, Monaco, monospace;">'.$beforecode.'</textarea></div>';
    
    $result= $result.'<textarea cols="60" name="'.$name.$widgetindex.'" style="height:'.$mainheight.'px; font-family:Courier, Monaco, monospace;">'.stripslashes($widget["code"]).'</textarea>';
    
    $result=$result.'<br>';
    return $result;
  }

  function MCW_add_html_allowed(){
    $option=MCW_get_options();
    return ($option['use_add_html']=='yes');
  }
  
  function MCW_allow_js(){
    $option=MCW_get_options();
    return ($option['allow_js']=='yes');
  }
  
  function MCW_std_kind(){
    $option=MCW_get_options();
    return $option['std_kind'];
  }
  
  function MCW_get_code_height(){
    $option=MCW_get_options();
    return $option['code_height'];
  }
  
  function MCW_get_filter_width(){
    $option=MCW_get_options();
    return $option['filter_width'];  
  }

  function MCW_get_mainfile_name(){
    return basename(__FILE__);
  }   
 
  function MCW_check($value1, $value2){
    if ($value1==$value2){
      return ' checked="checked"';
    }
  }
  
  function MCW_widget_allready_exist($name){
    $all_widgets = MCW_get_all_widgets(); 
    $max = count($all_widgets);
    $erg=false;
    for ( $i = 0; $i < $max && !$erg; ++$i ) {
      $erg = ($all_widgets[$i]['name'] == $name);
    }
    return $erg;
  }
  
  function MCW_filter_allready_exist($name){
    $all_filters = MCW_get_all_filters(); 
    $max = count($all_filters);
    $erg=false;
    for ( $i = 0; $i < $max && !$erg; ++$i ) {
      $erg = (trim($all_filters[$i][0]) == trim($name));
    }
    return $erg;
  }
   
  function MCW_checkshow($MyFilter){
  // checks whether the widget should be displayed on this screen or not
    $myfilteroptions = MCW_get_all_filters();
    $max = count($myfilteroptions);
    $erg = false;
    for ( $i = 0; $i < $max; ++$i ) {
      //$jntest = "if ((".stripslashes($myfilteroptions[$i][1]).") && (".isset($MyFilter[$myfilteroptions[$i][0]]).")) {\$erg = true;} <br>";
      //echo $jntest;
      eval("if ((".stripslashes($myfilteroptions[$i][1]).") && isset(\$MyFilter[\$myfilteroptions[\$i][0]])) {\$erg = true;}");
    }
    //echo "erg = ".$erg;     
    return $erg;
  }
  
  function MCW_code_plausibility_check($code, $kind='html'){
  // 0 if code is correct
  // error message if code is incorrect
    $res = false; // = 0 = ''
    $code = stripslashes($code);
    
    //check 1
    $code_a='<?php';
    $code_b='?'.'>';
    $code_a_count=substr_count($code, $code_a);
    $code_b_count=substr_count($code, $code_b);
    if ($code_a_count <> $code_b_count) 
      $res=$res.$code_a_count.' php-open-tag ("'.MCW_make_html_writeable($code_a).'") vs. '.$code_b_count.' php-close-tag ("'.MCW_make_html_writeable($code_b).'")';
    
    //check 2
    if ($kind=='html'){
      $code_a='?'.'>';
      $code_b='<?php';      
    } else {
      $code_a='<?php';
      $code_b='?'.'>';          
    }
    $code_a_pos=strpos($code, $code_a);
    $code_b_pos=strpos($code, $code_b);
    if ($code_a_pos < $code_b_pos){
      if ($res) $res=$res.',<br>';
      $res=$res.'You should not use "'.MCW_make_html_writeable($code_a).'" before "'.MCW_make_html_writeable($code_b).'" in '.$kind.'-code. Please start with '.$kind.'-code first.';
    }
      
    //return $res;
    return false;    
  }
  
  function MCW_make_html_writeable($code){
    $code = str_replace('<','&lt;',$code);
    $code = str_replace('>','&gt;',$code);
    return $code;
  }
  function MCW_make_php_writeable($code){
    $code = str_replace('<'.'?php','&lt;'.'?php', $code);
    $code = str_replace('?'.'>','?'.'&gt;', $code);
    return $code;
  }

/******************************/    
/*** start option-functions ***/
/******************************/  
  function MCW_get_options() {
    //returns plugin-options 
    global $mcw_prefix;
    global $mcw_configoption;
    return get_option($mcw_prefix.$mcw_configoption);
  }
  
  function MCW_set_options($myoptions) {
    global $mcw_prefix;
    global $mcw_configoption; 
    update_option($mcw_prefix.$mcw_configoption, $myoptions); 
  }  
	
 	function MCW_get_default_options() {
 	  // returns predefined default plugin-options
    $cache_filters = array(array('all',      'true'), 
                           array('home',     'is_home()'),
                           array('single',   'is_single()'),
                           array('page',     'is_page()'),
                           array('category', 'is_category()'), 
                           array('tag',      'is_tag()'),
                           array('archive',  'is_archive()'),
                           array('search',   'is_search()'));

    $cache_options = array('filters'      => $cache_filters, 
                           'use_add_html' => 'no', 
                           'allow_js'     => 'yes',
                           'std_kind'     => 'html', 
                           'code_height'  => 150,
                           'filter_width' => 75);      
		return $cache_options;    
 	}
 	
  function MCW_set_option_backup($myoptions) {
    global $mcw_prefix;
    global $mcw_configoption;
    global $mcw_backup_postfix; 
    update_option($mcw_prefix.$mcw_configoption.$mcw_backup_postfix, $myoptions); 
  }
  
  function MCW_get_option_backup(){
    global $mcw_prefix;
    global $mcw_configoption;
    global $mcw_backup_postfix;
    return get_option($mcw_prefix.$mcw_configoption.$mcw_backup_postfix);
  }
  
 	function MCW_get_all_filters(){
 	  $temp=MCW_get_options();
 	  $temp=MCW_sort_my_elements($temp['filters']);
 	  return $temp;
  }
  
  function MCW_get_filters($filtername, $widgetindex = '', $filtervalue = array('all' => 1)){
    $myfilteroptions = MCW_get_all_filters();
    $max = count($myfilteroptions);
    $result = '<div>';
    for ( $i = 0; $i < $max; ++$i ) {
        $result = $result.'<nobr><label for="'.$filtername.$widgetindex.'['.$myfilteroptions[$i][0].']"><input type="checkbox" id="'.$filtername.$widgetindex.'['.$myfilteroptions[$i][0].']" name="'.$filtername.$widgetindex.'['.$myfilteroptions[$i][0].']" value="1" '.MCW_check($filtervalue[$myfilteroptions[$i][0]],"1").'> '.$myfilteroptions[$i][0].' </label></nobr>';
    }
    $result = $result.'</div>';
    return $result;
  }
  
  function MCW_set_filters($myfilter) {
    global $mcw_prefix;
    global $mcw_configoption; 
    $myoption = MCW_get_options();
    $myoption['filters'] = $myfilter;
    update_option($mcw_prefix.$mcw_configoption, $myoption);  
  }
  
  function MCW_delete_filter($index) {
    $myfilter= MCW_get_all_filters();
    unset($myfilter[$index]);
    $myfilter= array_values($myfilter);
    MCW_set_filters($myfilter);
  }

/******************************/    
/*** start widget-functions ***/
/******************************/ 
  function MCW_get_max_widgets($widgets) {
		return count($widgets);    
 	}

  function MCW_get_all_widgets() {
    global $mcw_prefix;
    global $mcw_widgetsoption;
    $res = get_option($mcw_prefix.$mcw_widgetsoption);
    $res = MCW_sort_my_elements($res, 'name'); 
    return $res;    
  }
  
  function MCW_set_allwidgets($widgetcontent) {
    global $mcw_prefix;
    global $mcw_widgetsoption;
    update_option($mcw_prefix.$mcw_widgetsoption, $widgetcontent);
  }
    
  function MCW_get_mywidget($widgetindex) {
    $myWidgets = MCW_get_all_widgets();
    return $myWidgets[$widgetindex];
  }
  
  function MCW_set_mywidget($widgetindex, $widgetcontent) {
    $myWidgets = MCW_get_all_widgets();
    $myWidgets[$widgetindex] = $widgetcontent;
    MCW_set_allwidgets($myWidgets);
  }
  
  function MCW_add_mywidget($content) {
    $index = MCW_get_max_widgets(MCW_get_all_widgets());
    MCW_set_mywidget($index, $content);
  }
  
  function MCW_delete_mywidget($widgetindex) {
    $allwidgets = MCW_get_all_widgets();
    unset($allwidgets[$widgetindex]);
    $allwidgets= array_values($allwidgets);
    MCW_set_allwidgets($allwidgets);
  }

/**********************/    
/*** backup routine ***/
/**********************/ 
  function MCW_set_widget_backup($myWidgets) {
    global $mcw_prefix;
    global $mcw_widgetsoption;
    global $mcw_backup_postfix;
    update_option($mcw_prefix.$mcw_widgetsoption.$mcw_backup_postfix, $myWidgets);
  }
  
  function MCW_get_widget_backup() {
    global $mcw_prefix;
    global $mcw_widgetsoption;
    global $mcw_backup_postfix;
    $res = get_option($mcw_prefix.$mcw_widgetsoption.$mcw_backup_postfix);
    $res = MCW_sort_my_elements($res, 'name'); 
    return $res;    
  }


/******************************/    
/*** deinstallation routine ***/
/******************************/  
  function MCW_deinstall(){
    global $mcw_prefix;
    global $mcw_widgetsoption;
    global $mcw_configoption;
    global $mcw_backup_postfix;
    delete_option($mcw_prefix.$mcw_widgetsoption);
    delete_option($mcw_prefix.$mcw_configoption);
    delete_option($mcw_prefix.$mcw_widgetsoption.$mcw_backup_postfix);
    delete_option($mcw_prefix.$mcw_configoption.$mcw_backup_postfix);
  }
  
/*************************************/    
/***  start widget control dialog  ***/
/*************************************/    	
  function MCW_control_dialog($widgetindex) {
		$MyWidget = MCW_get_mywidget($widgetindex);
		$mcw_submit_trigger = 'mcw-submit_';
    $data_widget_code = 'mcw_new_widget_code';
    $data_widget_kind = 'mcw_new_widget_kind';
    $data_widget_filter = 'mcw_new_widget_filter';
    
		if ( !is_array($MyWidget)||empty($MyWidget) )
			return;
		if ( $_POST[$mcw_submit_trigger.$widgetindex] ) {
      $MyWidget['beforecode'] = $_POST[$data_widget_code.$widgetindex.'_before'];
      $MyWidget['code'] = $_POST[$data_widget_code.$widgetindex];
      $MyWidget['kind'] = $_POST[$data_widget_kind.$widgetindex];
      $MyWidget['filter'] = $_POST[$data_widget_filter.$widgetindex]; 
         
			MCW_set_mywidget($widgetindex, $MyWidget);
		}
		$mcw_elements = array ( 'code'   => $data_widget_code,
                            'kind'   => $data_widget_kind,
                            'filter' => $data_widget_filter,
                            'submit' => $mcw_submit_trigger);
                            
    include(MCW_get_url('style'));
    MCW_get_widget_maintenance($MyWidget, $mcw_elements, $widgetindex, true);
  }
  
/********************************/    
/*** start widget realization ***/
/********************************/ 
 function MCW_php_replace($match)
 {
  // replacing WPs strange PHP tag handling with a functioning tag pair
  $output = '<?php'. $match[2]. '?'.'>';
  return $output;
 }
    
  function MCW_eval_code($args){
    extract($args);
    if(!isset($i)) {
      $funcArgs = func_get_args();  // for wp2.2.1
      $i = $funcArgs[1];
    }    
    if(!isset($force_eval)) {
      $force_eval = $args['force_eval']; // for wp2.2.1
    }
    if(!isset($debug_mode)) {
      $debug_mode = $args['debug_mode']; // for wp2.2.1
    }

    
    $MyWidget = MCW_get_mywidget($i);
    $code = $MyWidget['code']; //html or php
    $precode = $MyWidget['beforecode']; //html
    
    if(isset($code)) {
      $code = stripslashes($code);
      $precode = stripslashes($precode);
      if (MCW_checkshow($MyWidget['filter']) || $force_eval) {
        if ($debug_mode==''){    
        //thanks to EXEC-PHP
        
          $pattern = '/'.
          '(<[\s]*\?php)'. // the opening of the <?php tag
          '(((([\'\"])([^\\\5]|\\.)*?\5)|(.*?))*)'. // ignore content of PHP quoted strings
          '(\?'.'>)'. // the closing ? > tag
          '/is';
          $code = preg_replace_callback($pattern, 'MCW_php_replace', $code);
          
          if ($force_eval) echo '<div class="mcw_debug"><pre><code>'.MCW_make_html_writeable($code).'</pre></code></div>';
          
          if ($MyWidget['kind']=="html"){
            $code = '?'.'> '.$code.'<'.'?php '; 
          } else {
            $code = $code.'?'.'>';
          } 
          
          // to be compatible with older PHP4 installations
          // don't use fancy ob_XXX shortcut functions       
          ob_start();
            eval($code);
            $output = ob_get_contents();
          ob_end_clean();
          
          $output = $precode.$output;
          
          echo MCW_make_php_writeable($output);    
        
        } else {   
        // true html-code
          if ($precode){ 
            echo '<br><div class="mcw_debug"><b>Precode:</b> '.MCW_make_html_writeable($precode).'</div>';
          }
          echo $precode;     
             
          if ($MyWidget['kind']=="html"){
            // html-code
            $true_html=substr_count($code, '<?php');
            if ($true_html == 0){
              //true html-code --> easy
              echo '<br><div class="mcw_debug"><b>HTML:</b> <pre><code>'.MCW_make_html_writeable($code).'</pre></code></div>';
              echo $code;
            } else {
              // html-php-mix --> this can be tricky
              $help_open_tag = '<?php';
              $help_close_tag = '?'.'>';
              
              echo MCW_code_plausibility_check($code);
/* NEW Code-evaluation */
              $i = substr_count($code, $help_open_tag);
              $counter = 1;
              while ($i > 0) {
              //split code into php- and html-pieces
                
                //GRAB HTML-CODE
                $temp_html = substr($code, 0, strpos($code,$help_open_tag));
                //remove leading php-open-tag
                $code = stristr($code, $help_open_tag);
                $code = substr($code, 5, strlen($code)-5); 
                
                //GRAB PHP-CODE
                //$temp_php = stristr($code_rest, $help_close_tag, true); // only with php 6.0.0 
                $temp_php = substr($code, 0, strpos($code,$help_close_tag));
                //remove leading php-close-tag                
                $code = stristr($code, $help_close_tag);
                $code = substr($code, 2, strlen($code)-2);
                
                $i = substr_count($code, $help_open_tag);

                echo '<br><div class="mcw_debug"><b>'.$counter.'. HTML:</b><pre><code> '.MCW_make_html_writeable($temp_html).'</pre></code></div>';
                echo $temp_html;
                echo '<br><div class="mcw_debug"><b>'.$counter.'. PHP:</b><pre><code> '.MCW_make_html_writeable($temp_php).'</pre></code></div>';
                eval($temp_php);
                $counter = $counter+1;
              }
              if (strlen($code)>0){ //HTML code left
                echo '<br><div class="mcw_debug"><b>'.$counter.'. HTML:</b><pre><code> '.MCW_make_html_writeable($code).'</pre></code></div>';
                echo $code;
              }       
            }
          } else {
            $help_open_tag = '<?php';
            $help_close_tag = '?'.'>';
            $true_php = substr_count($code, $help_close_tag);
            $true_php = ($true_php==0);
            if ($true_php){
              //true php-code --> high performance
              echo '<br><div class="mcw_debug"><b>PHP:</b> '.MCW_make_html_writeable($code).'</div>';
              eval($code);
            } else {
              echo MCW_code_plausibility_check($code, 'php');
/* NEW Code-evaluation */
              $i = substr_count($code, $help_close_tag);
              $counter = 1;
              while ($i > 0) {
              //split code into php- and html-pieces
                
              //GRAB PHP-CODE
                $temp_php = substr($code, 0, strpos($code,$help_close_tag));
              //remove leading php-close-tag
                $code = stristr($code, $help_close_tag);
                $code = substr($code, 2, strlen($code)-2); 
                
              //GRAB HTML-CODE
                $temp_html = substr($code, 0, strpos($code,$help_open_tag));
              //remove leading php-open-tag                
                $code = stristr($code, $help_open_tag);
                $code = substr($code, 5, strlen($code)-5);
                
                $i = substr_count($code, $help_close_tag);

                echo '<br><div class="mcw_debug"><b>'.$counter.'. PHP:</b><pre><code> '.MCW_make_html_writeable($temp_php).'</pre></code></div>';
                eval($temp_php);
                echo '<br><div class="mcw_debug"><b>'.$counter.'. HTML:</b><pre><code> '.MCW_make_html_writeable($temp_html).'</pre></code></div>';
                echo $temp_html;
                $counter = $counter+1;                
              }
              if (strlen($code)>0){ //PHP code left
                echo '<br><div class="mcw_debug"><b>'.$counter.'. PHP:</b><pre><code> '.MCW_make_html_writeable($code).'</pre></code></div>';
                eval($code);
              }       
            }
          }
        //if ($postcode){ 
        //  echo '<br><div class="mcw_debug"><b>Postcode:</b> '.MCW_make_html_writeable($postcode).'</div>';
        //}
        //echo $postcode;
        } 
      }
    }
  }
  
/************************************/
/***     initialize widgets       ***/
/************************************/
  $myWidgets_all = MCW_get_all_widgets();
  $maxindex = count($myWidgets_all);
  // Register widgets 
  if (!empty($myWidgets_all)){
    for ( $widgetindex = 0; $widgetindex < $maxindex; ++$widgetindex ) {
      $widget = MCW_get_mywidget($widgetindex);      
      //if ( function_exists('wp_register_sidebar_widget') ){ // fix for wordpress 2.2.1
      //  wp_register_sidebar_widget(sanitize_title($widget["name"]), $widget["name"], MCW_eval_code, array(), $i);
      //} else {
        register_sidebar_widget($widget["name"], MCW_eval_code, $widgetindex);
        register_widget_control($widget["name"], 'MCW_control_dialog', 400, 300, $widgetindex);
      //}
    }
  }    
}


/***********************************/
/***  create configuration page  ***/
/***********************************/

function MCW_add_pages() {
  add_theme_page("Administration of My Custom Widgets", "My Custom Widgets", 8, mcw_get_mainfile_name(), "MCW_include_theme_page");
  add_options_page("Configuration of My Custom Widgets", "My Custom Widgets", 8, mcw_get_mainfile_name(), "MCW_include_option_page"); 
}
function MCW_include_option_page() {
  global $mcw_prefix;
  global $mcw_configoption;
    $mcw_options = MCW_get_default_options();
    add_option($mcw_prefix.$mcw_configoption, $mcw_options, 'Options for My Custom Widgets - Plugin', true );
    include(MCW_get_url('style' ));
    //echo "<h2>My Custom Widget - Configuration</h2>";
    include( "my_custom_widget_configuration.php" ); 
}

function MCW_include_theme_page() {
  global $mcw_prefix;
  global $mcw_widgetsoption;
  add_option($mcw_prefix.$mcw_widgetsoption , array(), "IndexOption for MyCustomWidgets", true);
  include(MCW_get_url('style'));
  //echo "<h2>My Custom Widget</h2>";
  include( "my_custom_widget_options.php" );
}

/******************************/
/***  deactivation dialog  ***/
/*****************************/
function MCW_deactivate_plugin(){
  //echo "JANEK-TEST-PLUGIN-DEACTIVATION";
}


/**********************/
/***   wake up !!!  ***/
/**********************/
add_action("plugins_loaded", "MCW_plugin_init");
add_action("admin_menu", "MCW_add_pages");
register_deactivation_hook(__FILE__, 'MCW_deactivate_plugin')
 
?>