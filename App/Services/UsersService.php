<?php
    namespace App\Services;

    use App\Models\Users;

    class UsersService
    {
        public function get($id = null) 
        {
            if ($id) {
                return Users::select($id);
            } else {
                return Users::selectAll();
            }
        }

        public function post() 
        {
            $data = $_POST;
            
            if(empty($data['nome'])){
                throw new \Exception('nome não pode está vazio');
            }
            if(empty($data['email'])){
                throw new \Exception('email não pode está vazio');
            }
            if(empty($data['password'])){
                throw new \Exception('senha não pode está vazio');
            }
            return Users::insert($data);
            
        }

        public function update() 
        {
            
        }

        public function delete() 
        {
            
        }
    }