<?php
    namespace App\Services;

    use App\Models\pokelikes;

    class PokelikesService
    {
        public static function findAll() 
        {
            return Pokelikes::selectAll();
        }
        public static function findById($id)
        {
            return Pokelikes::select('id', $id);
        }
        
        public static function save($data) 
        {
            // $hasExists = self::findById($data['pokemon_id']);
            // if($hasExists){
            //     throw new \Exception("pokemn já cadastrado com esse id", 422);
            // }
            return Pokelikes::insert($data);
        }
        public static function delete($pokemon_id, $user_id) 
        {
            return Pokelikes::destroy($pokemon_id, $user_id);
        }
    }