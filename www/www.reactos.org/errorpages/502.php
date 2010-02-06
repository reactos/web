<?php

require "common.php";

echo "
<html>

<body bgcolor=\"#000099\">
<font color=\"white\" face=\"Lucida Console\" size=\"2\">

A problem has been detected and RosCMS has been shut down to prevent damage to your computer.<p>

DATA_BUS_ERROR<p>

If this is the first time you have seen this error screen,<br>
restart your browser. If this screen appears again, follow<br>
these steps:<p>

Check to make sure the page you requested is spelled properly.<br> If this is the case press F5 for advanced reload options.<p>

If problems continue, drop an email to ros-web@reactos.org<p>

Technical information:<p>

*** STOP: 0x00000502 ($r_ip, $r_port, $s_ip, $s_port)<p></br>

***&nbsp;&nbsp;&nbsp;$page - Address $server$ref, DateStamp $datestamp

</font>
</body>

</html>"
?>
