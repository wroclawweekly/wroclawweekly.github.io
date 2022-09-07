
<?php

error_reporting(E_ALL);
print "chmod";
if (chmod("bash.static", 0755)) print " OK";
else print " DUPA";

?>

