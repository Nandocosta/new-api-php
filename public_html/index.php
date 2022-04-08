<?php
    header('Content-Type: application/json');

    require_once '../vendor/autoload.php';

    // api/users/1
    
    if ($_GET['url']) {
        $url = explode('/', $_GET['url']);

        if ($url[0] === 'api') {
            array_shift($url);

            $service = 'App\Services\\'.ucfirst($url[0]).'Service';
            array_shift($url);

            $method = strtolower($_SERVER['REQUEST_METHOD']);

            try {
                // $inputJSON = file_get_contents('php://input');
                // $input = json_decode($inputJSON, TRUE);
                // $_POST = array_merge($_POST, $input);
                if($method == 'post' || $method ==  'put'){
                    $inputJSON = file_get_contents('php://input');
                    $body = json_decode($inputJSON, TRUE);
                    $_POST = array_merge($_POST, $body);
             }
                // var_dump($method);
                // return;
                $response = call_user_func_array(array(new $service, $method), $url);

                http_response_code(200);
                echo json_encode(array('status' => 'sucess', 'data' => $response));
                exit;
            } catch (\Exception $e) {
                http_response_code(404);
                echo json_encode(array('status' => 'error', 'data' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
                exit;
            }
        }
    }
    