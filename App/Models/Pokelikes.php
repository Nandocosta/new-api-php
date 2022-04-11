<?php
    namespace App\Models;

    class Pokelikes
    {
        private static $table = 'pokelikes';

            private static function conn()
            {
                return new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
            }

                public static function fieldsRequireds()
            {
                return ['pokemon_id', 'user_id'];
            }

            public static function select($poke_id, $user_id)
            {
                $sql = 'SELECT * FROM '.self::$table.' WHERE pokemon_id = :poke and user_id = :user';
                $stmt = self::conn()->prepare($sql);
                $stmt->bindValue(':poke', $poke_id);
                $stmt->bindValue(':user', $user_id);
                $stmt->execute();    

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(\PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Nenhum pokemon encontrado!");
            }
        }

        public static function selectAll($user_id) {

            $sql = 'SELECT * FROM '.self::$table.'WHERE user_id =:user';
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(':user', $user_id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Nenhum pokemon encontrado!");
            }
        }

        public static function insert($data)
        {
            $sql = 'INSERT INTO '.self::$table.' (pokemon_id, user_id) VALUES (:pk, :us)';
            
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(':pk', $data['pokemon_id']);
            $stmt->bindValue(':us', $data['user_id']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'pokemon inserido com sucesso!';
            } else {
                throw new \Exception("Falha ao inserir pokemon!");
            }
        }

        public static function destroy($pokemon_id, $user_id)
        {
            $sql = 'DELETE FROM '.self::$table.'  WHERE pokemon_id = :poke and user_id = :user ';
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(':poke', $pokemon_id);
            $stmt->bindValue(':user', $user_id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'Pokemon deletado com sucesso!';
            } else {
                throw new \Exception("Falha ao inserir pokemon!");
            }
        }
    }