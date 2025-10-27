<?php
namespace App\Utils;

use App\Bbdd\Usuario;

class Validacion
{
    public static function sanearCampos(string $valor): string
    {
        return htmlspecialchars(trim($valor));
    }

    public static function longitudCampoValida(string $valor, string $nombreCampo, int $min, int $max): bool
    {
        if (strlen($valor) < $min || strlen($valor) > $max) {
            $_SESSION["err_$nombreCampo"] = "*** Error el campo $nombreCampo esperaba entre $min y $max caracteres.";
            return false;
        }
        return true;
    }
    public static function emailValido(string $email): bool{
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        $_SESSION['err_email']="*** Error, se esperabe un email válido.";
        return false;
    }
    public static function isLoginValido(string $email, string $pass): bool{
        if(!Usuario::validarUsuario($email, $pass)){
            $_SESSION['err_validacion']="***Error, email o password incorrectos.";
            return false;
        }
        return true;
    }

    public static function pintarError(string $nombre): void{
        if(isset($_SESSION[$nombre])){
            echo "<p class='text-red-500 mt-1 italic text-sm'>{$_SESSION[$nombre]}</p>";
            unset($_SESSION[$nombre]);
        }
    }
}
