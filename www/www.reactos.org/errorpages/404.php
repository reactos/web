<?php

function dec2hex($dec, $digits=false) {

        $hex =  '';
        $sign = $dec < 0 ? false : true;

        // Converts the decimal number into hexadecimal ignoring the sign for now.
        while ($dec) {
            // Calculates the modulus, converts it to hexadecimal and adds it to the result.
            $hex .= dechex(abs(bcmod($dec, '16')));
            // Divises the decimal number by 16 and loop.
            $dec = bcdiv($dec, '16', 0);
        }

        // Adds some padding to get the required number of digits if specified.
        if ($digits) {
            while (strlen($hex) < $digits) { $hex .= '0'; }
        }

        // If the decimal number was positive, we're done.
        if ($sign) {
            // The result has to be reversed because of the way it was computed.
            return strrev($hex);
        }

        // The decimal number was negative so first we need to flip each digit individually.
        for ($i = 0; isset($hex[$i]); $i++) { $hex[$i] = dechex(15 - hexdec($hex[$i])); }

        // Now we need to add 1 to the result.
        // This handles the carry so 'f' becomes '0' until we reach a digit that isn't 'f'.
        for ($i = 0; isset($hex[$i]) && $hex[$i] == 'f'; $i++) { $hex[$i] = '0'; }
        // Finally unless all the digits were f's, we add one to the latest digit that wasn't.
        if (isset($hex[$i])) { $hex[$i] = dechex(hexdec($hex[$i]) + 1); }

        // All done! Again, we need to reverse the result.
        return strrev($hex);

    } 

function ip_address_to_number($IPaddress) 
{ 
    if ($IPaddress == "") { 
        return 0; 
    } else { 
        $ips = split ("\.", "$IPaddress"); 
        return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256); 
    } 
} 

$url .= "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
$page .= $_SERVER["REQUEST_URI"];
$server .= $_SERVER["SERVER_NAME"];
if ($_SERVER["HTTP_REFERER"] != "")
  $ref .= " base at " . $_SERVER["HTTP_REFERER"];
$datestamp = dec2hex(date("U"), 8);
$r_port = "0x" . dec2hex($_SERVER["REMOTE_PORT"], 8);
$r_ip = "0x" . dec2hex(ip_address_to_number($_SERVER["REMOTE_ADDR"]),8);
$s_port = "0x" . dec2hex($_SERVER["SERVER_PORT"], 8);
$s_ip = "0x" . dec2hex(ip_address_to_number($_SERVER["SERVER_ADDR"]),8);

echo "
<html>

<body bgcolor=\"#000099\">
<font color=\"white\" face=\"Lucida Console\" size=\"2\">

A problem has been detected and RosCMS has been shut down to prevent damage to your computer.<p>

PAGE_FAULT_IN_NONPAGED_AREA<p>

If this is the first time you have seen this error screen,<br>
restart your browser. If this screen appears again, follow<br>
these steps:<p>

Check to make sure the page you requested is spelled properly.<br> If this is the case press F5 for advanced reload options.<p>

If problems continue, drop an email to ros-web@reactos.org<p>

Technical information:<p>

*** STOP: 0x00000404 ($r_ip, $r_port, $s_ip, $s_port)<p></br>

***&nbsp;&nbsp;&nbsp;$page - Address $server$ref, DateStamp $datestamp

</font>
</body>

</html>"
?>
