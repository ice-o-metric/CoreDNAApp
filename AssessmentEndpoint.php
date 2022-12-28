<?php
		/**
		* AssessmentEndpoint performs the request described in the CoreDNA coding test
		* 
		* AssessmentEndpoint uses RequestMaker to handle the request described in the CoreDNA coding test
		*/
    class AssessmentEndpoint{
        
        
        /**
		 * SendAndOutput takes the 3 arguments described by the CoreDNA coding test and sends them to their proscribed URI, outputting feedback
		 *
		 * @param string $name
		 * @param string $email
		 * @param string $git
		 * @access public
		 */
		public function SendAndOutput($name, $email, $git) {
            require_once('RequestMaker.php');
            
            $connector = new RequestMaker();
            
            echo '<p>Instantiated</p>';
            
            $token = $connector->Request('https://corednacom.corewebdna.com/assessment-endpoint.php', 'OPTIONS');
            
            echo '<p>TOKEN:' . json_encode($token) . '</p>';
            
            $header  = 'Authorization: Bearer ' . $token . "\r\n";
            $header .= 'Content-type: application/json';
            
            $data = [
                'name'   => $name,
                'email'  => $email,
                'url'    => $git
            ];
            
            $response = $connector->Request('https://corednacom.corewebdna.com/assessment-endpoint.php', 'POST', $data, $header);
            
            echo '<p>RESPONSE:' . json_encode($response) . '</p>';
            
            echo '<p>Done</p>';
        }
    }
?>