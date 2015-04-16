<?php
	header("HTTP/1.0 404 Not Found");
	
	function ip_to_number($address) 
	{
		$ips = explode('.', $address);
		return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
	}
	
	$url = 'http://' . $_SERVER["SERVER_NAME"];
	$address = $_SERVER["SERVER_NAME"];
	if(isset($_SERVER["HTTP_REFERER"]) and !empty($_SERVER["HTTP_REFERER"]))
  		$address .= ' base at ' . $_SERVER["HTTP_REFERER"];
?>
<!DOCTYPE html>
<html>
<head>
	<title>404 - Page Not found | ReactOS</title>
	<link href='https://fonts.googleapis.com/css?family=VT323' rel='stylesheet' type='text/css'>
</head>
<body>
<style type="text/css">
	body
	{	background: #000099;
		color: white;
		font-family:'VT323', Lucida Console, monospace;
		font-size: 22px;
	}
	a{	color: yellow !important;
		font-weight: bold;
		text-decoration: none;
	}
	
</style>
<div id="bsod">
	<p>A problem has been detected and the ReactOS website has been shut down to prevent damage to your computer.</p>

	<p>404 - Not Found</p>

	<p>If this is the first time you have seen this error screen,<br />
	restart your browser. If this screen appears again, follow<br />
	these steps:</p>

	<p>Make sure that the page you requested is spelled properly.<br />
	If this is the case, press F5 for advanced reload options.</p>

	<p>If problems continue, drop an email to ros-web@reactos.org</p>

	<p>Technical information:</p>

	<p><?php printf('*** STOP: 0x00000%u (0x%08x, 0x%08x, 0x%08x, 0x%08x)', $http_error, ip_to_number($_SERVER["REMOTE_ADDR"]), $_SERVER["REMOTE_PORT"], ip_to_number($_SERVER["SERVER_ADDR"]), $_SERVER["SERVER_PORT"]); ?></p>


	<p><br />***&nbsp;&nbsp;&nbsp;<?php printf('Address %s at %s, DateStamp %08x', $_SERVER["REQUEST_URI"], $address, date("U")); ?></p>
	
	<p><a href="<?php echo $url; ?>">&raquo; back to our homepage</a></p>
</div>
</body>
