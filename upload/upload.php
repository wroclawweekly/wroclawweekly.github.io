
<?php
error_reporting(E_ALL);
print "jedziem";

$uploadDir = '/var/httpd/wroclawweekly.pl/upload/';
$uploadFile = $uploadDir . $_FILES['userfile']['name'];
print "$uploadFile"; print "$tmp_name";
?>

