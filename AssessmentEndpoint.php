<?php
	require_once('RequestMaker.php');
	
	$connector = new RequestMaker();
	
	echo '<p>Instantiated</p>';
	
	$token = $connector->Request('https://corednacom.corewebdna.com/assessment-endpoint.php', 'OPTIONS');
	
	echo '<p>TOKEN:' . json_encode($token) . '</p>';
	
	$header = 'Authorization: Bearer ' . $token;
	
	$data = [
		'name'	=> 'Daniel Vida',
		'email'	=> 'receive.attachments@gmail.com',
		'url'	=> 'https://github.com/ice-o-metric/CoreDNAApp'
	];
	
	echo '<p>Done</p>';
?>