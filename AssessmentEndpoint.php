<?php
	class AssessmentEndpoint{
        //based on https://stackoverflow.com/questions/8596311/how-to-make-a-post-request-without-curl
		
		function SendAndOutput($name, $email, $git) {
			require_once('RequestMaker.php');
			
			$connector = new RequestMaker();
			
			echo '<p>Instantiated</p>';
			
			$token = $connector->Request('https://corednacom.corewebdna.com/assessment-endpoint.php', 'OPTIONS');
			
			echo '<p>TOKEN:' . json_encode($token) . '</p>';
			
			$header = 'Authorization: Bearer ' . $token;
			
			$data = [
				'name'	=> $name,
				'email'	=> $email,
				'url'	=> $git
			];
			
			$response = $connector->Request('https://corednacom.corewebdna.com/assessment-endpoint.php', 'POST', $data);
			
			echo '<p>RESPONCE:' . json_encode($response) . '</p>';
			
			echo '<p>Done</p>';
		}
?>