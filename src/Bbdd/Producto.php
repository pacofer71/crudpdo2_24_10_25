<?php

namespace App\Bbdd;

use \PDOException;
use \PDO;
use stdClass;

class Producto extends Conexion
{
    private int $id;
    private string $nombre;
    private string $descripcion;
    private float $precio;
    private int $usuario_id;
    private string $disponible;

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
        $q = "insert into producto(nombre, descripcion, precio, disponible, usuario_id) values(:n, :d, :p, :di, :ui)";
        self::executeQuery($q, [
            ':n' => $this->nombre,
            ':d' => $this->descripcion,
            ':p' => $this->precio,
            ':ui' => $this->usuario_id,
            ':di' => $this->disponible,
        ]);
    }
    public function update(int $id){
        $q="update producto set nombre=:n, precio=:p, disponible=:di, descripcion=:d where id=:i";
        self::executeQuery($q, [
            ':n' => $this->nombre,
            ':d' => $this->descripcion,
            ':p' => $this->precio,
            ':di' => $this->disponible,
            ':i'=>$id
        ]);
    }

    public static function read(): array{
        $q="select producto.*, email from producto, usuario where usuario_id=usuario.id order by producto.id desc";
        $stmt=self::executeQuery($q, [], true);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public static function getProductoById(int $id): \stdClass{
        $q="select * from producto where id=:i";
        $stmt=self::executeQuery($q,[':i'=>$id], true);
        return ($stmt->fetchAll(PDO::FETCH_OBJ))[0];
    }

     public static function deleteAll(?int $id=null){
        $q=($id==null) ? "delete from producto" : "delete from producto where id=$id";
        self::executeQuery($q);
    }

    public static function existeNombre(string $nombre, ?int $id_producto=null): bool{
        $q=($id_producto==null) ? "select id from producto where nombre=:n"
            :"select id from producto where nombre=:n AND id != :i";
        $opciones=($id_producto==null) ? [':n'=>$nombre] : [':n'=>$nombre, ':i'=>$id_producto]; 
        $stmt=self::executeQuery($q, $opciones, true);
        $datos=$stmt->fetchAll(PDO::FETCH_OBJ);
        return count($datos);
    }

    public static function productoPerteneceUsuario(int $idP, int $idU): bool{
        $q="select id from producto where id=:ip AND usuario_id=:iu";
        $stmt=self::executeQuery($q, [':ip'=>$idP, ':iu'=>$idU], true);
        $datos=$stmt->fetchAll(PDO::FETCH_OBJ);
        return count($datos);
    }

    public static function crearProductos(int $cant)
    {
        $faker = \Faker\Factory::create('es_ES');
        $idUsuarios = Usuario::devolverIds();

        for ($i = 0; $i < $cant; $i++) {
            $nombre = ucfirst($faker->unique()->words(mt_rand(1, 3), true)); // 1-3 palabras
            $descripcion = $faker->sentence(mt_rand(8, 15)); // frase de 8 a 15 palabras
            $precio = $faker->randomFloat(2, 10, 9999); //DECIMAL(6,2)
            $disponible = $faker->randomElement(['SI', 'NO']);
            $usuario_id = $faker->randomElement($idUsuarios);
            (new Producto)
                ->setNombre($nombre)
                ->setDescripcion($descripcion)
                ->setDisponible($disponible)
                ->setPrecio($precio)
                ->setUsuarioId($usuario_id)
                ->create();
        }
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
     * Get the value of nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     */
    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio(): float
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     */
    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of usuario_id
     */
    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }

    /**
     * Set the value of usuario_id
     */
    public function setUsuarioId(int $usuario_id): self
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }

    /**
     * Get the value of disponible
     */
    public function getDisponible(): string
    {
        return $this->disponible;
    }

    /**
     * Set the value of disponible
     */
    public function setDisponible(string $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }
}
