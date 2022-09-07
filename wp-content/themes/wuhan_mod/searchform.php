<form name="searchform" method="get" id="searchform" action="<?php echo get_settings('home'); ?>/">
<div><input class="search-box" type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
<input type="hidden" id="searchsubmit" value="Search" />
<a href="javascript:  document.searchform.submit();">Search</a>
</div>
</form>