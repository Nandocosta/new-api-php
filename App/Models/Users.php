<?php
    namespace App\Models;

    class Users
    {
        private static $table = 'users';

            private static function conn()
            {
                return new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
            }

                public static function fieldsRequireds()
            {
                return ['nome', 'email', 'password'];
            }

            public static function select($field, $value) 
            {
                $sql = 'SELECT * FROM '.self::$table.' WHERE ' .$field. ' = :field';
                $stmt = self::conn()->prepare($sql);
                $stmt->bindValue(':field', $value);
                $stmt->execute();    

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(\PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Nenhum usuário encontrado!");
            }
        }

        public static function selectAll() {
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

            $sql = 'SELECT * FROM '.self::$table;
            $stmt = self::conn()->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Nenhum usuário encontrado!");
            }
        }

        public static function insert($data)
        {
            $sql = 'INSERT INTO '.self::$table.' (email, password, nome) VALUES (:em, :pa, :na)';
            
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(':em', $data['email']);
            $stmt->bindValue(':pa', $data['password']);
            $stmt->bindValue(':na', $data['nome']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'Usuário(a) inserido com sucesso!';
            } else {
                throw new \Exception("Falha ao inserir usuário(a)!");
            }
        }

        public static function update($id ,$data)
        {
            $sql = 'UPDATE '.self::$table.' SET email= :em, password= :pa , nome= :na  WHERE id =:id';
            $stmt = self::conn()->prepare($sql);
            
            $stmt->bindValue(':em', $data['email']);
            $stmt->bindValue(':pa', $data['password']);
            $stmt->bindValue(':na', $data['nome']);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'Usuário(a) alterado com sucesso!';
            } else {
                throw new \Exception("Falha ao alterar usuário(a)!");
            }
        }

        public static function destroy($id)
        {
            $sql = 'DELETE FROM '.self::$table.' WHERE id = :__id ';
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(':__id', $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'Usuário deletado com sucesso!';
            } else {
                throw new \Exception("Falha ao deletar usuário(a)!");
            }
        }

        public static function logar($email, $password) 
            {
                $sql = 'SELECT id, nome, email FROM '.self::$table.' WHERE email =:em and password =:pa';
                $stmt = self::conn()->prepare($sql);
                $stmt->bindValue(':em', $email);
                $stmt->bindValue(':pa', $password);
                $stmt->execute();    

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(\PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Nenhum usuário encontrado!");
            }
        }
    }