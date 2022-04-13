<?php
    namespace App\Controllers;

    use App\Services\PokelikesService;
    use App\Models\Pokelikes;

    class PokelikesController
    {
        public function index($id = null) 
        {
            $response = [];
            $metodo = strtolower($_SERVER['REQUEST_METHOD']);

            if($metodo !== 'get'){
                throw new \Exception("metodo inválido", 422);
            }

            if ($id) {
                $response['data'] = PokelikeService::findById($id);
            } else {
                $response['data'] = PokelikesService::findAll();
            }
            $response['http'] = 200;
            return $response;
        }

        public function create() 
        {
            $response = [];
            $data = $_POST;
            $emptyValues = [];
            $metodo = strtolower($_SERVER['REQUEST_METHOD']);

            if($metodo !== 'post'){
                throw new \Exception("metodo inválido", 422);
            }

            foreach(Pokelikes::fieldsRequireds() as $field){
                if(empty($data[$field])){
                    array_push($emptyValues, $field);
                }
            }

            if(count($emptyValues)){
                $values = implode(", ", $emptyValues);
                throw new \Exception("Os parâmetros [$values] precisam ser preenchidos", 422);
            }

            $response['data'] =  PokelikesService::save($data);
            $response['http'] = 201;
            return  $response;
        }

        public function delete() 
        {
            $inputJSON = file_get_contents('php://input');
            $body = $_GET;
            if(!$body){
                throw new \Exception("campos vazios", 422);
            }

            $metodo = strtolower($_SERVER['REQUEST_METHOD']);

            if($metodo !== 'delete'){
                throw new \Exception("metodo inválido", 422);
            }
          
            if(!$body["pokemon_id"] || !$body["user_id"]){
                throw new \Exception('pokemon_id e user_id precisa ser informado', 422);
            }

            $response['data'] =  PokelikesService::delete($body["pokemon_id"],$body["user_id"]);
            $response['http'] = 201;
            return  $response;
        }
    }