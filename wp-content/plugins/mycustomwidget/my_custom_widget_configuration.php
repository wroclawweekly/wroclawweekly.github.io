<?php
/*
Author: Janek Niefeldt
Author URI: http://www.janek-niefeldt.de/
Description: Configuration of My Custom Widgets Plugin.
*/


  // external links
  $link_filter_tag = 'http://codex.wordpress.org/Conditional_Tags';
  
  // data elements
  $data_options_use_add_html = 'mcw_use_add_html';
  $data_options_allow_js = 'mcw_allow_js';
  $data_options_filter_name = 'mcw_filter_name';
  $data_options_filter_bool = 'mcw_filter_bool';
  $data_options_code_height = 'mcw_code_height';
  $data_options_filter_width = 'mcw_filter_width';
  $data_options_deinstall = 'mcw_deinstall_check';
  $data_options_reset = 'mcw_reset_check';
  $data_options_backup = 'mcw_backup_check';
  $data_options_std_kind = 'mcw_std_kind';

  // option information
  $option_help_text_addhtml = 'mcw_help_add_html';
  $option_help_text_java = 'mcw_help_allow_js';
  $option_help_text_reset = 'mcw_help_reset';
  $option_help_text_backup = 'mcw_help_backup';
  $option_help_text_deinstall = 'mcw_help_deinstall';
  $option_help_text_height = 'mcw_help_height';
  $option_help_text_width = 'mcw_help_width';
  $option_help_text_std_kind = 'mcw_help_std_kind';
  $description_add_html = 'Additional field for html code will be displayed in top of the main-code area. Here you can add any html-based code e.g. JavaScript.<br>(You can also use <b>&lt;?php</b> <i>php-content</i>; <b>?&gt;</b> or <b>echo "</b><i>html-content</i> <b>";</b> in the main-code area instead.)"';
  $description_allow_js = 'Activate JavaScript to enable image-buttons and comfortable edit-screen through <a href="'.get_option('siteurl').'/wp-admin/themes.php?page='.MCW_get_mainfile_name().'">widget-configuration</a>. (recommended)';
  $description_reset = 'Reset will restore default options and filters (Reset Settings will overwrite current settings. Maybe you want to create a backup.).';
  $description_backup = 'You can save or restore a backup of your current option settings. (Restore Backup will overwrite current settings.)';
  $description_deinstall = 'Deinstallation will delete all database records created with this plugin (even the backup records - use carefully).';
  $description_height = 'Here you can modify the standard height of the code-input-area available on <a href="'.get_option('siteurl').'/wp-admin/themes.php?page='.MCW_get_mainfile_name().'">widget-configuration-site</a>.';
  $description_width = 'Here you can modify the text-width for filter definition, as it will be displayed on <a href="'.get_option('siteurl').'/wp-admin/themes.php?page='.MCW_get_mainfile_name().'">widget-configuration-site</a> and <a href="'.get_option('siteurl').'/wp-admin/widgets.php">Wordpress widget-administration-site</a>.';
  $description_std_kind = 'Choose which standard-type of code should be used for new widgets.';

  //button name
  $button_name_submit = 'mcw_submit';
  $element_option_backup = 'mcw_backup_button';
  
  // button text
  $button_text_deinstall = 'Deinstall';
  $button_text_save_all = 'Save All';
  $button_text_reset = 'Reset';  
  $button_text_add = 'Add Filter';
  $button_text_remove = 'Remove';
  $button_text_set_backup = 'Create Backup';
  $button_text_get_backup = 'Restore Backup'; 
    
  //controll element  
  $cache_options = MCW_get_options();
  $backup_available = false;

  if ($_POST[$element_option_backup]==$button_text_set_backup) {
    if ( $_POST[ $data_options_backup ] != $data_options_backup ) {
      echo '<div id="message" class="updated fade"><p><strong> To save backup you have to check the Backup-Checkbox as well.</strong></p></div>';
    } else {
      MCW_set_option_backup($cache_options);
      echo '<div id="message" class="updated fade"><p><strong>Backup stored successfully.</strong></p></div>';
    }
  }
  
  $max_filters = count($cache_options['filters']);
  
  //initialize deletion-flag
  $help_deleted=false;
  $javascript_is_allowed = MCW_allow_js();
  
  $add_cache= array(trim($_POST[$data_options_filter_name]),trim($_POST[$data_options_filter_bool])); 
  
  for ( $i = 0; $i < $max_filters; ++$i ) {
    if ($_POST[$button_name_submit.$i]==$button_text_remove){
      //delete filter entry
      MCW_delete_filter($i);
      $help_deleted=true;
    }
  }
  if ($help_deleted){
    // print message
    ?>
    <div id="message" class="updated fade">
      <p>
        <strong>
          <?php echo 'Filter deleted'; ?>
        </strong>
      </p>
    </div>
    <?php
    $cache_options = MCW_get_options();
  } 

  if ($_POST[ $button_name_submit ] == $button_text_save_all) {
    //save options
    //read filter-options
    unset($cache_filters);
    for ( $i = 0; $i < $max_filters; ++$i ) {
      $cache_filters[] = array($_POST[ $data_options_filter_name.$i ], 
                               $_POST[ $data_options_filter_bool.$i ]);
    }
    $cache_options = array('filters'      => $cache_filters, 
                           'use_add_html' => $_POST[$data_options_use_add_html], 
                           'allow_js'     => $_POST[$data_options_allow_js],
                           'std_kind'     => $_POST[$data_options_std_kind], 
                           'code_height'  => $_POST[$data_options_code_height],
                           'filter_width' => $_POST[$data_options_filter_width]);
    MCW_set_options($cache_options);
    $javascript_is_allowed = ($_POST[$data_options_allow_js]=='yes');
    ?>
    <div id="message" class="updated fade">
      <p>
        <strong>
          <?php echo 'options have been saved'; ?>
        </strong>
      </p>
    </div>
    <?php      
  } else if ($_POST[ $button_name_submit ] == $button_text_reset) {
      if ( $_POST[ $data_options_reset ] != $data_options_reset ) {
        echo '<div id="message" class="updated fade"><p><strong> To reset you have to check the Reset-Checkbox as well.</strong></p></div>';
      } else {
        //load Default Settings
        $cache_options = MCW_get_default_options();
        if (empty($cache_options)) {
          ?>
          <div id="message" class="error fade"><p><strong><?php echo 'Settings have NOT been loaded.'; ?></strong></p></div>
          <?php
        } else {      
          MCW_set_options($cache_options);
          $javascript_is_allowed = ($cache_options['allow_js']=='yes');
          ?>
          <div id="message" class="updated fade">
            <p>
              <strong>
                <?php echo 'Settings have been loaded.'; ?>
              </strong>
            </p>
          </div>
          <?php
        } 
      }
    } else if ($_POST[$element_option_backup]==$button_text_get_backup){ 
      if ( $_POST[ $data_options_backup ] != $data_options_backup ) {
        echo '<div id="message" class="updated fade"><p><strong> To restore backup you have to check the Backup-Checkbox as well.</strong></p></div>';
      } else {
        //load Backup Settings
        $cache_options=MCW_get_option_backup();
        if (empty($cache_options)) {
          ?>
          <div id="message" class="error fade">
            <p>
              <strong>
                <?php echo 'Settings have NOT been loaded.'; ?>
              </strong>
            </p>
          </div>
          <?php
        } else {      
          MCW_set_options($cache_options);
          $javascript_is_allowed = ($cache_options['allow_js']=='yes');
          ?>
          <div id="message" class="updated fade">
            <p>
              <strong>
                <?php echo 'Settings have been loaded.'; ?>
              </strong>
            </p>
          </div>
          <?php
        }
      }
    } else if ($_POST[ $button_name_submit.'_add' ] == $button_text_add){
    //add filter
      $cache_filters = MCW_get_all_filters();
      if ($add_cache[0] == "" || $add_cache[1] == ""){
        echo '<div class="error"><p><b>Please enter a name and a check to create a new filter!</b></p></div>';
      } else {      
        if (MCW_filter_allready_exist($add_cache[0])){
          echo '<div class="error"><p><b>Filter "'.$add_cache[0].'" allready exists!</b></p></div>';
        } else {
          $cache_filters[] = $add_cache;
          MCW_set_filters($cache_filters);
          $cache_options = MCW_get_options();
          ?>
          <div id="message" class="updated fade">
            <p>
              <strong>
                <?php echo 'Filter "'.$add_cache[0].'" added'; ?>
              </strong>
            </p>
          </div>
          <?php
          $add_cache = array();
        }        
      }
    }

  $cache_filters = MCW_sort_my_elements($cache_options['filters']);
  $max_filters = count($cache_filters);
  
/**************************/    
/*** remove all widgets ***/
/*** remove all options ***/
/**************************/
  if ( $_POST[$button_name_submit] == $button_text_deinstall ) {
    if ( $_POST[ $data_options_deinstall ] != $data_options_deinstall ) {
      echo '<div id="message" class="updated fade"><p><strong> For Deinstallation you have to check the Deinstall-Checkbox.</strong></p></div>';
    } else {
      $max_widgets = MCW_get_max_widgets(MCW_get_all_widgets());
      MCW_deinstall();
      echo '<div id="message" class="updated fade"><p><b> All ' . $max_widgets . ' custom-widgets have been removed.</b> <br><b> All options for MyCustomWidgets have been removed.</b> <br>To to deactivate plugin click <a href=' . get_option('siteurl') . '/wp-admin/plugins.php >here &raquo;</a></p></div>';
    }
  }
  
$backup_available = MCW_get_option_backup();  
$backup_available = !(empty($backup_available));

/**************************/    
/*** Start of formular  ***/
/**************************/  
  ?>
  
<?php if ($javascript_is_allowed){ 
  echo '<script type="text/javascript" src="'.MCW_get_url('js_1').'"></script>';
  echo '<script type="text/javascript" src="'.MCW_get_url('js_2').'"></script>';
?>

<script language="JavaScript">
<!--
function submit_form(id, action){
  document.forms["form_mycustomwidget"].elements["<?php echo $button_name_submit; ?>"+id].value = action;
  document.forms["form_mycustomwidget"].submit();
}

//-->
</script>
<?php } ?> 
    
  <div class="wrap">
    <h2>My Custom Widget Plugin Configuration</h2>
    <fieldset class="options">
      <form name="form_mycustomwidget" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <legend> Filter definition </legend>
        <table class="mcw_config_filters" width="100%"  border="1" cellspacing="3" cellpadding="3">
          <tr valign="center">
				    <th align="left" width="0%">
              Name of filter (<?php echo $max_filters; ?>)
            </th>
            <th valign="center" align="left" width="100%">
              <nobr>
                <a href="<?php echo $link_filter_tag; ?>">PHP-code &raquo;</a>
              </nobr>
              <nobr>
                &nbsp;(must return <i>bool-value</i>  e.g. "is_page() || is_home()")
              </nobr>
            </th>
            <th valign="center" align="center" width="0%">
              Remove
            </th>
			    </tr>    
		      <?php
          for ( $i = 0; $i < $max_filters; ++$i ) {
          ?>
            <tr valign="center">
				      <td align="left" width="0%">
                <input type="text" name="<?php echo $data_options_filter_name.$i; ?>" value="<?php echo stripslashes($cache_filters[$i][0]); ?>" size="18">
              </td>
              <td align="left" width="100%">
                <?php 
                  $bool_code= stripslashes($cache_filters[$i][1]);
                  $bool_code= str_replace('"','&quot;',$bool_code); 
                ?>
                <input type="text" name="<?php echo $data_options_filter_bool.$i; ?>" value="<?php echo $bool_code; ?>" size="40">                 
              </td>
              <td align="center" width="0%">
				        <?php if ($javascript_is_allowed){ ?>
                  <a href="#" onClick="submit_form('<?php echo $i; ?>', '<?php echo $button_text_remove; ?>');return true;">
                    <img src="<?php echo MCW_get_url('remove'); ?>" alt="<?php echo $button_text_remove; ?>">
                  </a>
                  <input type="hidden" name="<?php echo $button_name_submit.$i; ?>" value="">
                <?php } else { ?>
                  <input type="submit" title="<?php echo $button_text_remove; ?>" alt="-" name="<?php echo $button_name_submit.$i; ?>"  value="<?php echo $button_text_remove; ?>" style="border:none">
                <?php } ?>       
              </td>
			      </tr>
		      <?php } ?>
          <tr valign="center">
				    <td align="left" width="0%">
              <input type="text" name="<?php echo $data_options_filter_name; ?>" value="<?php echo $add_cache[0]; ?>" size="18">
            </td>
            <td align="left" width="100%">
              <?php 
                $bool_code= stripslashes($add_cache[1]);
                $bool_code= str_replace('"','&quot;',$bool_code); 
              ?>
              <input type="text" name="<?php echo $data_options_filter_bool; ?>" value="<?php echo $bool_code; ?>" size="40" width="100%">                 
            </td>
				    <td align="center" width="0%">
				      <?php if ($javascript_is_allowed){ ?>
                <a href="#" onClick="submit_form('_add', '<?php echo $button_text_add; ?>');return true;">
                  <img src="<?php echo MCW_get_url('add'); ?>" alt="<?php echo $button_text_add; ?>">
                </a>
                <input type="hidden" name="<?php echo $button_name_submit; ?>_add" value="">
              <?php } else { ?>
                <input type="submit" title="<?php echo $button_text_add; ?>" alt="-" name="<?php echo $button_name_submit; ?>"  value="<?php echo $button_text_add; ?>" style="border:none"> 
              <?php } ?>
              <!-- <a href="<?php echo $link_filter_tag; ?>"><img src="<?php echo MCW_get_url('info'); ?>"></a> -->      
            </td>
			    </tr>
        </table>
        
        <p class="submit">
          <legend> Miscellaneous </legend>
          <table class="mcw_config_table" width="100%"  border="1" cellspacing="3" cellpadding="3">
            <!-- use additional html fields -->
            <tr>
				      <th valign="top" align="left" width="20%">
                Use additional HTML-code
              </th>
              <td align="left" width="80%">		
                <label for="<?php echo $data_options_use_add_html.'_yes'; ?>">
                  <input type="radio" id="<?php echo $data_options_use_add_html.'_yes'; ?>" name="<?php echo $data_options_use_add_html; ?>" value="yes" <?php echo mcw_check($cache_options['use_add_html'],'yes'); ?>> 
                  Yes
                </label>
                <label for="<?php echo $data_options_use_add_html.'_no'; ?>">
                  <input type="radio" id="<?php echo $data_options_use_add_html.'_no'; ?>" name="<?php echo $data_options_use_add_html; ?>" value="no"<?php echo mcw_check($cache_options['use_add_html'],'no'); ?>> 
                  No
                </label>
                <div id="<?php echo $option_help_text_addhtml; ?>" style="display:none;">
                  <br>
                  <div id="message" class="updated">
                    <p>
                      <b>
                        <?php echo $description_add_html; ?>
                      </b>
                    </p>
                  </div>
                </div>
              </td>
              <?php if ($javascript_is_allowed){ ?>
                <td valign="center" align="center" width="0%">  
                  <a href="#<?php echo $option_help_text_addhtml; ?>" title="Info">
                    <img src="<?php echo MCW_get_url('info'); ?>" onClick="Effect.toggle('<?php echo $option_help_text_addhtml; ?>', 'slide', {duration:0.5}); return false;">
                  </a>
                </td> 
              <?php } ?>
			      </tr>  
			     <!-- Standard Code -->
            <tr>
				      <th valign="top" align="left" width="20%">
                Standard Code Type
              </th>
              <td align="left" width="80%">
                <label for="<?php echo $data_options_std_kind.'_html'; ?>"><input type="radio" id="<?php echo $data_options_std_kind.'_html'; ?>" name="<?php echo $data_options_std_kind; ?>" value="html" <?php echo mcw_check($cache_options['std_kind'],'html'); ?>> HTML</label>
                <label for="<?php echo $data_options_std_kind.'_php'; ?>"><input type="radio" id="<?php echo $data_options_std_kind.'_php'; ?>" name="<?php echo $data_options_std_kind; ?>" value="php"<?php echo mcw_check($cache_options['std_kind'],'php'); ?>> PHP</label>
                <div id="<?php echo $option_help_text_std_kind; ?>" style="display:none;">
                  <br>
                  <div id="message" class="updated">
                    <p>
                      <b>
                        <?php echo $description_std_kind; ?>
                      </b>
                    </p>
                  </div>
                </div>
              </td>
              <?php if ($javascript_is_allowed){ ?>
                <td valign="center" align="center" width="0%">
                  <a href="#<?php echo $option_help_text_std_kind; ?>" title="Info">
                    <img src="<?php echo MCW_get_url('info'); ?>" onClick="Effect.toggle('<?php echo $option_help_text_std_kind; ?>', 'slide', {duration:0.5}); return false;">
                  </a>
                </td>
              <?php } ?>
			     </tr>
          </table> 
        </p>        
        
        <p class="submit">
          <legend> Layout </legend>
          <table class="mcw_config_table" width="100%"  border="1" cellspacing="3" cellpadding="3">
            <!-- Allow Java Script -->
            <tr>
				      <th valign="top" align="left" width="20%">
                Allow Java Script
              </th>
              <td align="left" width="80%">
                <label for="<?php echo $data_options_allow_js.'_yes'; ?>"><input type="radio" id="<?php echo $data_options_allow_js.'_yes'; ?>" name="<?php echo $data_options_allow_js; ?>" value="yes" <?php echo mcw_check($cache_options['allow_js'],'yes'); ?>> Yes</label>
                <label for="<?php echo $data_options_allow_js.'_no'; ?>"><input type="radio" id="<?php echo $data_options_allow_js.'_no'; ?>" name="<?php echo $data_options_allow_js; ?>" value="no"<?php echo mcw_check($cache_options['allow_js'],'no'); ?>> No</label>
                <div id="<?php echo $option_help_text_java; ?>" style="display:<?php if ($javascript_is_allowed){ echo 'none';} else { echo 'block';}?>;">
                  <br>
                  <div id="message" class="updated">
                    <p>
                      <b>
                        <?php echo $description_allow_js; ?>
                      </b>
                    </p>
                  </div>
                </div>
              </td>
              <?php if ($javascript_is_allowed){ ?>
                <td valign="center" align="center" width="0%">
                  <a href="#<?php echo $option_help_text_java; ?>" title="Info">
                    <img src="<?php echo MCW_get_url('info'); ?>" onClick="Effect.toggle('<?php echo $option_help_text_java; ?>', 'slide', {duration:0.5}); return false;">
                  </a>
                </td>
              <?php } ?>
			      </tr>
            <!-- Code Height --> 
            <tr>
              <th align="left" width="20%">
                code height
              </th>
              <td align="left" width="80%">
                <input type="text" name="<?php echo $data_options_code_height; ?>" value="<?php echo $cache_options['code_height']; ?>" size="10">  px
                <div id="<?php echo $option_help_text_height; ?>" style="display:none;">
                  <br>
                  <div id="message" class="updated">
                    <p>
                      <b>
                        <?php echo $description_height; ?>
                      </b>
                    </p>
                  </div>
                </div>
              </td>
              <?php if ($javascript_is_allowed){ ?>
                <td valign="center" align="center" width="0%">
                  <a href="#<?php echo $option_help_text_height; ?>" title="Info">
                    <img src="<?php echo MCW_get_url('info'); ?>" onClick="Effect.toggle('<?php echo $option_help_text_height; ?>', 'slide', {duration:0.5}); return false;">
                  </a>
                </td>
              <?php } ?>
            </tr>
            <!-- Filter Width --> 
            <tr>
              <th align="left" width="20%">
                filter width
              </th>
              <td align="left" width="80%">
                <input type="text" name="<?php echo $data_options_filter_width; ?>" value="<?php echo $cache_options['filter_width']; ?>" size="10">  px
                <div id="<?php echo $option_help_text_width; ?>" style="display:none;">
                  <br>
                  <div id="message" class="updated">
                    <p>
                      <b>
                        <?php echo $description_width; ?>
                      </b>
                    </p>
                  </div>
                </div>
              </td>
              <?php if ($javascript_is_allowed){ ?>
                <td valign="center" align="center" width="0%">
                  <a href="#<?php echo $option_help_text_width; ?>" title="Info">
                    <img src="<?php echo MCW_get_url('info'); ?>" onClick="Effect.toggle('<?php echo $option_help_text_width; ?>', 'slide', {duration:0.5}); return false;">
                  </a>
                </td>
              <?php } ?>
            </tr> 
          </table>
        </p>
      
        <!-- Save Options --> 
        <div align="left">
          <input type="submit" align="left" name="<?php echo $button_name_submit; ?>"  value="<?php echo $button_text_save_all; ?>">
        </div>  
        <br>
      
      
        <p class="submit">
          <legend>Administration</legend>
          <table class="mcw_config_table" width="100%"  border="1" cellspacing="3" cellpadding="3">
            <!-- Reset defaults -->
            <tr>
              <th align="left" width="20%">
                <label for="<?php echo $data_options_reset; ?>"><input type="checkbox" id="<?php echo $data_options_reset; ?>" name="<?php echo $data_options_reset; ?>" value="<?php echo $data_options_reset; ?>"> Reset defaults</label>
              </th>
              <td align="left" width="80%">
                <input type="submit" align="left" name="<?php echo $button_name_submit; ?>"  value="<?php echo $button_text_reset; ?>">
                <div id="<?php echo $option_help_text_reset; ?>" style="display:none;">
                  <div id="message" class="updated">
                    <p>
                      <b>
                        <?php echo $description_reset; ?>
                      </b>
                    </p>
                  </div>
                </div>
              </td>
              <?php if ($javascript_is_allowed){ ?>
                <td valign="center" align="center" width="0%">
                  <a href="#<?php echo $option_help_text_reset; ?>" title="Info">
                    <img src="<?php echo MCW_get_url('info'); ?>" onClick="Effect.toggle('<?php echo $option_help_text_reset; ?>', 'slide', {duration:0.5}); return false;">
                  </a>
                </td>
              <?php } ?>
            </tr>      
            <!-- Backup -->
            <tr>
              <th align="left" width="20%">
                <label for="<?php echo $data_options_backup; ?>"><input type="checkbox" id="<?php echo $data_options_backup; ?>" name="<?php echo $data_options_backup; ?>" value="<?php echo $data_options_backup; ?>"> Backup</label>
              </th>
              <td align="left" width="80%">
                <input type="submit" name="<?php echo $element_option_backup; ?>" value="<?php echo $button_text_set_backup; ?>">
                <?php if ($backup_available) { ?>
                  <input type="submit" name="<?php echo $element_option_backup; ?>" value="<?php echo $button_text_get_backup; ?>">
                <?php } ?>  
                <div id="<?php echo $option_help_text_backup; ?>" style="display:none;">
                  <div id="message" class="updated">
                    <p>
                      <b>
                        <?php echo $description_backup; ?>
                      </b>
                    </p>
                  </div>
                </div>
              </td>
              <?php if ($javascript_is_allowed){ ?>
                <td valign="center" align="center" width="0%">
                  <a href="#<?php echo $option_help_text_backup; ?>" title="Info">
                    <img src="<?php echo MCW_get_url('info'); ?>" onClick="Effect.toggle('<?php echo $option_help_text_backup; ?>', 'slide', {duration:0.5}); return false;">
                  </a>
                </td>
              <?php } ?>
            </tr> 
            <!-- Delete all widgets -->
            <tr>
              <th align="left" width="20%">
                <label for="<?php echo $data_options_deinstall; ?>"><input type="checkbox" id="<?php echo $data_options_deinstall; ?>" name="<?php echo $data_options_deinstall; ?>" value="<?php echo $data_options_deinstall; ?>"> Deinstall</label>
              </th>
              <td align="left" width="80%">
                <input align="right" type="submit" name="<?php echo $button_name_submit; ?>" "remove" value="<?php echo $button_text_deinstall; ?>">
                <div id="<?php echo $option_help_text_deinstall; ?>" style="display:none;">
                  <div id="message" class="updated">
                    <p>
                      <b>
                        <?php echo $description_deinstall; ?>
                      </b>
                    </p>
                  </div>
                </div>
              </td>
              <?php if ($javascript_is_allowed){ ?>
                <td valign="center" align="center" width="0%">
                  <a href="#<?php echo $option_help_text_deinstall; ?>" title="Info">
                    <img src="<?php echo MCW_get_url('info'); ?>" onClick="Effect.toggle('<?php echo $option_help_text_deinstall; ?>', 'slide', {duration:0.5}); return false;">
                  </a>
                </td>
              <?php } ?>
            </tr>
          </table> 
        </p>
      </form>
    </fieldset>
  <div width="100%" align="right">
    for widget configuration <a href="<?php echo get_option('siteurl'); ?>/wp-admin/themes.php?page=<?php echo MCW_get_mainfile_name(); ?>">click here &raquo;</a>
  </div>
  <br>
</div>   
