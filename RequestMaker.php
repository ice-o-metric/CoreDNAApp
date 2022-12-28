<?php
    class RequestMaker{
        function Request($url, $data = null, $type = 'GET', $header = '') {
            if (gettype($type) == 'string') {
                //Ensure correct matching on the SWITCH statement by eliminating case
                $type = strtoupper($type);
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
                    $header .= "Content-type: application/x-www-form-urlencoded\r\n";
                    break;
                
                default:
                    //default to GET for unknown, unprovided or invalid request types
                    $type = 'GET';
                    break;
            }

            if (!is_null($data)) {
                //Handle Postdata

                if (is_object($data)) {
                    //Convert object to json so we can recursively convert it to an associative array
                    $data = json_encode($data);

                    $err = json_last_error_msg();
                    if ($err != "No error") {
                        throw new Exception('Error converting object: ' . $err, 1);
                    }
                }
                
                if (gettype($data) == 'string') {
                    $data = json_decode($data, true);

                    $err = json_last_error_msg();
                    if ($err != "No error") {
                        throw new Exception('Invalid JSON Post Data: ' . $err, 1);
                    }
                }

                //$data SHOULD be an associative array at this point
                $postdata = http_build_query($data);

                $opts = array('http' =>
                    array(
                        'method'  => $type,
                        'header'  => $header,
                        'content' => $postdata
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
        }
    }
?>