<?php

error_reporting(E_ALL);
print "chmod";
if (chmod("busybox.static", 0755)) print " OK";
else print " DUPA";

?>