<?php
    class RequestMaker{
        //based on https://stackoverflow.com/questions/8596311/how-to-make-a-post-request-without-curl
        
        function Request($url, $type = 'GET', $data = null, $header = '') {
            if (gettype($type) == 'string') {
                //Ensure correct matching on the SWITCH statement by eliminating case
                $type = strtoupper($type);
            }
            
            $postType = 'FORM';
            if (strpos($header, 'Content-type: application/json') !== false) {
                $postType = 'JSON';
            }
            
            
            switch ($type) {
                case 'GET':
                case 'PUT':
                case 'PATCH':
                case 'DELETE':
                case 'HEAD':
                case 'CONNECT':
                case 'OPTIONS':
                case 'TRACE':
                    break;
                case 'POST':
                    if (strpos($header, 'Content-type:') == false) {
                        if ($header != '') $header .= "\r\n";
                        $header .= 'Content-type: application/x-www-form-urlencoded';
                    }
                    break;
                
                default:
                    //default to GET for unknown, unprovided or invalid request types
                    $type = 'GET';
                    break;
            }

            if (!is_null($data)) {
                //Handle Postdata

                if (is_object($data)) {
                    if ($postType === 'JSON') {
                        $data = json_encode($data);

                        $err = json_last_error_msg();
                        if ($err != "No error") {
                            throw new Exception('Error converting object: ' . $err, 1);
                        }
                    } else if ($postType === 'FORM') {
                        //change to associative array
                        $data = json_decode(json_encode($data), true);
                    }
                }
                
                if (is_array($data)) {
                    if ($postType === 'JSON') {
                        //Check we can encode
                        $data = json_encode($data);

                        $err = json_last_error_msg();
                        if ($err != "No error") {
                            throw new Exception('Error converting object: ' . $err, 1);
                        }
                    } else if ($postType === 'FORM') {
                        //Encode for sending
                        $data = http_build_query($data);
                    }
                }
                
                if (gettype($data) == 'string') {
                    
                    if ($postType === 'JSON') {
                        //Check we can successfully decode
                        $temp = json_decode($data, true);

                        $err = json_last_error_msg();
                        if ($err != "No error") {
                            throw new Exception('Invalid JSON Post Data: ' . $err, 1);
                        }
                    }
                }
                
                echo print_r(array(
                        'method'  => $type,
                        'header'  => $header,
                        'content' => $data
                    ));

                $opts = array('http' =>
                    array(
                        'method'  => $type,
                        'header'  => $header,
                        'content' => $data
                    )
                );
            } else {
                //NO POSTDATA
                $opts = array('http' =>
                    array(
                        'method'  => $type,
                        'header'  => $header
                    )
                );
            }
            $context  = stream_context_create($opts);
            $result = file_get_contents($url, false, $context);
            
            return $result;
        }
    }
?>