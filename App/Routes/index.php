<?php
    header('Content-Type: application/json');

    require_once '../../vendor/autoload.php';

    if ($_GET['url']) {
        $url = explode('/', $_GET['url']);
        $needInput = ['post', 'put', 'patch'];
        $metodo = strtolower($_SERVER['REQUEST_METHOD']);
        $methodNeedInput = in_array($metodo, $needInput);

        if ($url[0] === 'api' && !empty($url[1])) {
            $controller = 'App\Controllers\\'.ucfirst($url[1]).'Controller';
            $has_after_controller = count($url) > 2;
            $is_index_method = !$has_after_controller || !$url[2] || is_numeric($url[2]);
            $params = $has_after_controller ? ($is_index_method ? array_slice($url, 2) : array_slice($url, 3)) : [];
            $action = $is_index_method ? 'index' : $url[2];

            // salvar no banco de dados request maps para validar os metodos http e url
            try {
                if($methodNeedInput){
                    $inputJSON = file_get_contents('php://input');
                    $body = json_decode($inputJSON, TRUE);
                    if(!$body){
                        throw new \Exception("campos vazios", 422);
                    }
                    $_POST = array_merge($_POST, $body);
                }

                if(!method_exists(new $controller, $action)){
                    throw new \Exception("NOT_FOUND", 404);
                }

                $response = call_user_func_array(array(new $controller, $action), $params);

                http_response_code($response['http']);
                echo json_encode(array('status' => 'Success' , 'data' => $response['data']));
                exit;
            } catch (\Exception $e) {
                http_response_code($e->getCode());
                echo json_encode(array('status' => 'error', 'message' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
                exit;
            } 
        } else {
            http_response_code(404);
            echo json_encode(array('status' => 'error', 'data' => "NOT_FOUND"), JSON_UNESCAPED_UNICODE);
            exit;
        }
    }