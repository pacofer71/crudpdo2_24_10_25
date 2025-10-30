<?php

use App\Bbdd\Producto;
use App\Bbdd\Usuario;
function salir(){
     header("Location:productos.php");
    die();
}
session_start();
if(!isset($_SESSION['email'])){
   salir();
}
require __DIR__."/../vendor/autoload.php";

$email=$_SESSION['email'];

$id_producto=filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

//$id sera el id del producto a borrar o false si no hemos venido esde el dormde borrar
if($id_producto){
    //me traigo el id del usuario del que ahora mismo
    //solo tengo el email
    $id=Usuario::devolverIds($email);
    $id_usuario=$id[0];
    if(!Producto::productoPerteneceUsuario($id_producto, $id_usuario)){
        $_SESSION['mensaje']="Acción prohibida!!!";
       salir();
    }
    //El producto pertenece al usuario Puedo Borrarlo
    Producto::deleteAll($id_producto);
    $_SESSION['mensaje']="Producto Borrado";
    salir();
}
salir();