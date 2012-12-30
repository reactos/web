<?php
	function ip_address_to_number($address) 
	{
		$ips = explode('.', $address);
		return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
	}
	
	function bsod($http_error, $code)
	{
		$url = 'http://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		
		$address = $_SERVER["SERVER_NAME"];
		if(array_key_exists('HTTP_REFERER', $_SERVER))
  		$address .= ' base at ' . $_SERVER["HTTP_REFERER"];

/*	<title><?php echo $http_error; ?> - <?php echo $code; ?></title>  	*/
?>

	<style type="text/css">
		body
		{
			background: #000099;
			color: white;
			font-family: Lucida Console;
			font-size: 10pt;
		}
	</style>
</head>
<div id="bsod">
	<p>A problem has been detected and RosCMS has been shut down to prevent damage to your computer.</p>

	<p><?php echo $code; ?></p>

	<p>If this is the first time you have seen this error screen,<br />
	restart your browser. If this screen appears again, follow<br />
	these steps:</p>

	<p>Make sure that the page you requested is spelled properly.<br />
	If this is the case, press F5 for advanced reload options.</p>

	<p>If problems continue, drop an email to ros-web@reactos.org</p>

	<p>Technical information:</p>

	<p><?php printf('*** STOP: 0x00000%u (0x%08x, 0x%08x, 0x%08x, 0x%08x)', $http_error, ip_address_to_number($_SERVER["REMOTE_ADDR"]), $_SERVER["REMOTE_PORT"], ip_address_to_number($_SERVER["SERVER_ADDR"]), $_SERVER["SERVER_PORT"]); ?></p>


	<p><br />***&nbsp;&nbsp;&nbsp;<?php printf('%s - Address %s, DateStamp %08x', $_SERVER["REQUEST_URI"], $address, date("U")); ?></p>
</div>
<?php
	}
