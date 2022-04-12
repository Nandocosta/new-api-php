<?php
    namespace App\Services;

    use App\Models\Users;

    class UsersService
    {
        public static function findAll() 
        {
            return Users::selectAll();
        }
        public static function findById($id)
        {
            return Users::select('id', $id);
        }
        public static function findByEmail($email) 
        {
            return Users::select('email', $email);
        }
        public static function save($data) 
        {
            // $hasExists = self::findByEmail($data['email']);
            // if($hasExists){
            //     throw new \Exception("Usuario já cadastrado com esse email", 422);
            // }
            return Users::insert($data);
        }

        public static function update($id, $data) 
        {
            $user = self::findById($id);
            $format_data = array_merge($user, $data);
            return Users::update($id, $format_data);
        }

        public static function delete($id) 
        {
            return Users::destroy($id);
        }
    }