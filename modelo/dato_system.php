<?php
function getBrowser() { 
	$u_agent = $_SERVER['HTTP_USER_AGENT']; 
	$bname = 'Unknown';
	$platform = 'Unknown';
	$version= "";


	// Next get the name of the useragent yes seperately and for good reason
	if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) { 
		$bname = 'Internet Explorer'; 
		$ub = "MSIE"; 
	} 
	elseif(preg_match('/Firefox/i',$u_agent)){ 
		$bname = 'Mozilla Firefox'; 
		$ub = "Firefox"; 
	} 
	elseif(preg_match('/Chrome/i',$u_agent)){ 
		$bname = 'Google Chrome'; 
		$ub = "Chrome"; 
	} 
	elseif(preg_match('/Safari/i',$u_agent)){ 
		$bname = 'Apple Safari'; 
		$ub = "Safari"; 
	} 
	elseif(preg_match('/Opera/i',$u_agent)){ 
		$bname = 'Opera'; 
		$ub = "Opera"; 
	} 
	elseif(preg_match('/Netscape/i',$u_agent)){ 
		$bname = 'Netscape'; 
		$ub = "Netscape"; 
	} 

	// finally get the correct version number
	$known = array('Version', $ub, 'other');
	$pattern = '#(?<browser>' . join('|', $known) .
	')[/]+(?<version>[0-9.|a-zA-Z.]*)#';
	if (!preg_match_all($pattern, $u_agent, $matches)) {
	// we have no matching number just continue
	}

	// see how many we have
	$i = count($matches['browser']);
	if ($i != 1) {
		//we will have two since we are not using 'other' argument yet
		//see if version is before or after the name
		if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
			$version= $matches['version'][0];
		}
		else {
			$version= $matches['version'][1];
		}
	}
	else {
		$version= $matches['version'][0];
	}

	// check if we have a number
	if ($version==null || $version=="") {$version="?";}

	return array(
	'userAgent' => $u_agent,
	'name' => $bname,
	'version' => $version,
	'pattern' => $pattern
	);
} 



function getOs() {
	$useragent= strtolower($_SERVER['HTTP_USER_AGENT']);

	//winxp
	if (strpos($useragent, 'windows nt 5.1') !== FALSE) {
		return 'Windows XP';
	}
	elseif (strpos($useragent, 'windows nt 6.1') !== FALSE) {
		return 'Windows 7';
	}
	elseif (strpos($useragent, 'windows nt 6.0') !== FALSE) {
		return 'Windows Vista';
	}
	elseif (strpos($useragent, 'windows 98') !== FALSE) {
		return 'Windows 98';
	}
	elseif (strpos($useragent, 'windows nt 5.0') !== FALSE) {
		return 'Windows 2000';
	}
	elseif (strpos($useragent, 'windows nt 5.2') !== FALSE) {
		return 'Windows 2003 Server';
	}
	elseif (strpos($useragent, 'windows nt') !== FALSE) {
		return 'Windows 8/NT';
	}
	elseif (strpos($useragent, 'win 9x 4.90') !== FALSE && strpos($useragent, 'win me')) {
		return 'Windows ME';
	}
	elseif (strpos($useragent, 'win ce') !== FALSE) {
		return 'Windows CE';
	}
	elseif (strpos($useragent, 'win 9x 4.90') !== FALSE) {
		return 'Windows ME';
	}
	elseif (strpos($useragent, 'windows phone') !== FALSE) {
		return 'Windows Phone';
	}
	elseif (strpos($useragent, 'iphone') !== FALSE) {
		return 'iPhone';
	}
	// experimental
	elseif (strpos($useragent, 'ipad') !== FALSE) {
		return 'iPad';
	}
	elseif (strpos($useragent, 'webos') !== FALSE) {
		return 'webOS';
	}
	elseif (strpos($useragent, 'symbian') !== FALSE) {
		return 'Symbian';
	}
	elseif (strpos($useragent, 'android') !== FALSE) {
		return 'Android';
	}
	elseif (strpos($useragent, 'blackberry') !== FALSE) {
		return 'Blackberry';
	}
	elseif (strpos($useragent, 'mac os x') !== FALSE) {
		return 'Mac OS X';
	}
	elseif (strpos($useragent, 'macintosh') !== FALSE) {
		return 'Macintosh';
	}
	elseif (strpos($useragent, 'linux') !== FALSE) {
		return 'Linux';
	}
	elseif (strpos($useragent, 'freebsd') !== FALSE) {
		return 'Free BSD';
	}
	elseif (strpos($useragent, 'symbian') !== FALSE) {
		return 'Symbian';
	}
	else 
	{
		return 'Desconocido';
	}
}

function getMacAddress() {
	// This code is under the GNU Public Licence
	// Written by michael_stankiewicz {don\'t spam} at yahoo {no spam} dot com
	// Tested only on linux, please report bugs

	// WARNING: the commands \'which\' and \'arp\' should be executable
	// by the apache user; on most linux boxes the default configuration
	// should work fine

	// Get the arp executable path
	$location = `which arp`;
	// Execute the arp command and store the output in $arpTable
	$arpTable = `arp -a`;
	// Split the output so every line is an entry of the $arpSplitted array
	$arpSplitted = split("\n",$arpTable);
	// Get the remote ip address (the ip address of the client, the browser)
	$remoteIp = getenv('REMOTE_ADDR');
	// Cicle the array to find the match with the remote ip address
	foreach ($arpSplitted as $value) {
		// Split every arp line, this is done in case the format of the arp
		// command output is a bit different than expected
		$valueSplitted = split(" ",$value);
		foreach ($valueSplitted as $spLine) {
			if (preg_match("/$remoteIp/",$spLine)) {
				$ipFound = true;
			}
			// The ip address has been found, now rescan all the string
			// to get the mac address
			if ($ipFound) {
				// Rescan all the string, in case the mac address, in the string
				// returned by arp, comes before the ip address
				// (you know, Murphy\'s laws)
				reset($valueSplitted);
				foreach ($valueSplitted as $spLine) {
					if (preg_match("/[0-9a-f][0-9a-f][:-]".
					"[0-9a-f][0-9a-f][:-]".
					"[0-9a-f][0-9a-f][:-]".
					"[0-9a-f][0-9a-f][:-]".
					"[0-9a-f][0-9a-f][:-]".
					"[0-9a-f][0-9a-f]/i",$spLine)) {
						return $spLine;
					}
				}
			}
			$ipFound = false;
		}
	}
	return false;
}
?>