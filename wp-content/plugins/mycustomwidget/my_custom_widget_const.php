<?php

///not used yet
//overall

//for widget-configuration screen
  // technical elements
  define('hidden_field_submit', 'mcw_submit_hidden');
  define('element_widget_container', 'mcw_edit_container');
  define('element_widget_show_add_html', 'mcw_show add_html');
  // data-elements in formular
  define('data_widget_name', 'mcw_new_widget_name');
  define('data_widget_code', 'mcw_new_widget_code');
  define('data_widget_kind', 'mcw_new_widget_kind');
  define('data_widget_filter', 'mcw_new_widget_filter');
  define('data_widget_backup', 'mcw_backup_check');
  define('data_debug_activate', 'mcw_debug_preview');
  // button-elements in formular
  define('element_widget_submit', 'mcw_submit_button');
  define('element_widget_warning', 'mcw_warning_message');
  define('element_widget_backup', 'mcw_backup_button');
  // button-text
  define('button_text_delete_single', 'Delete');
  define('button_text_save_all', 'Save All');
  define('button_text_new_single', 'New');
  define('button_text_preview_single', 'Preview');
  define('button_text_save_single', 'Save');
  define('button_text_set_backup', 'Create Backup');
  define('button_text_get_backup', 'Restore Backup');
  //backup Additions
  define('element_help_text_backup', 'mcw_backup_helptext');
  define('element_help_text_debug', 'mcw_debug_helptext');
  define('description_backup', 'You can save or restore a backup of your widgets. ("'.button_text_get_backup.'" will overwrite current Widgets.)');
  define('description_debug', 'Beta-Feature:<br> After activating the Debug-checkbox you will be able to see your widget splitted into code pieces, when using the preview functionality (<img src="'.MCW_get_url('preview').'">).<br>This can help to find mistakes inside of your code. A split will be done whenever html-code changes to php-code and vice versa.<br><br>Known issues: <ul><li>Currently it is not possible to handle "if" statements in combination with HTML-code.</li>');


//for plugin-configuration screen

?>