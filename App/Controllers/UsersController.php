<?php
    namespace App\Controllers;

    use App\Services\UsersService;
    use App\Models\Users;

    class UsersController
    {
        public function index($id = null) 
        {
            $response = [];
            $metodo = strtolower($_SERVER['REQUEST_METHOD']);

            if($metodo !== 'get'){
                throw new \Exception("metodo inválido", 422);
            }

            if ($id) {
                $response['data'] = UsersService::findById($id);
            } else {
                $response['data'] = UsersService::findAll();
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

            foreach(Users::fieldsRequireds() as $field){
                if(empty($data[$field])){
                    array_push($emptyValues, $field);
                }
            }

            if(count($emptyValues)){
                $values = implode(", ", $emptyValues);
                throw new \Exception("Os parâmetros [$values] precisam ser preenchidos", 422);
            }

            $response['data'] =  UsersService::save($data);
            $response['http'] = 201;
            return  $response;
        }

        public function edit($id) 
        {
            $response = [];
            $data = $_POST;
            $metodo = strtolower($_SERVER['REQUEST_METHOD']);

            if($metodo != 'put' && $metodo != 'patch'){
                throw new \Exception("$metodo - metodo inválido", 422);
            }

            if(!$id){
                throw new \Exception('id precisa ser informado', 422);
            }

            $response['data'] =  UsersService::update($id, $data);
            $response['http'] = 201;
            return  $response;

        }

        public function delete($id) 
        {
            $metodo = strtolower($_SERVER['REQUEST_METHOD']);

            if($metodo !== 'delete'){
                throw new \Exception("metodo inválido", 422);
            }

            if(!$id){
                throw new \Exception('id precisa ser informado', 422);
            }

            $response['data'] =  UsersService::delete($id);
            $response['http'] = 201;
            return  $response;
        }
    }