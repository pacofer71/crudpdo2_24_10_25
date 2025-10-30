<?php

namespace App\Bbdd;

use \PDOException;
use \PDO;

class Usuario extends Conexion
{
    private int $id;
    private string $email;
    private string $password;

    private static function executeQuery(string $q, array $parametros = [], bool $devolverAlgo = false)
    {
        $stmt = self::getConexion()->prepare($q);
        try {
            count($parametros) ? $stmt->execute($parametros) : $stmt->execute();
        } catch (PDOException $ex) {
            die("error: " . $ex->getMessage());
        }
        if ($devolverAlgo) return $stmt;
    }
    public function create()
    {
        $q = "insert into Usuario(email, password) values(:e, :p)";
        self::executeQuery($q, [':e' => $this->email, ':p' => $this->password]);
    }

    public static function deleteAll(){
        $q="delete from usuario";
        self::executeQuery($q);
    }

    public static function crearUsuarios(int $cant)
    {
        $faker = \Faker\Factory::create('es_ES');
        for ($i = 0; $i < $cant; $i++) {
            $email = $faker->unique()->freeEmail();
            $password = "secret0";
            (new Usuario)
                ->setEmail($email)
                ->setPassword($password)
                ->create();
        }
    }
    public static function devolverIds(?string $email=null): array{
        $q=($email==null) ? "select id from Usuario" : "select id from Usuario where email=:e";
        $opciones=($email==null) ? [] : [':e'=>$email]; 
        $stmt=self::executeQuery($q, $opciones, true);
        $filas=$stmt->fetchAll(PDO::FETCH_OBJ);
        $ids=[];
        foreach($filas as $item){
            $ids[]=$item->id;
        }
        return $ids; //[1,2,3,4,5,6...], [3];   
    }

    public static function validarUsuario(string $email, string $password): bool{
        $q="select password from usuario where email=:e";
        $stmt=self::executeQuery($q, [':e'=>$email], true);
        $aux=$stmt->fetch(PDO::FETCH_OBJ);
        //var_dump($aux->password);
        //die();
        //$aux vale false si no existe ese email
        //o un objeto con unico atributo password, $aux->password
        // Normalmente el fetc se usa como está en la linea de abajo
        //while($fila=$stmt->fetch(PDO::FETCH_OBJ)){}
        return ($aux && password_verify($password, $aux->password));


    }



    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }
}
