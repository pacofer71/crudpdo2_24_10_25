<?php

use App\Bbdd\Producto;
use App\Bbdd\Usuario;

require __DIR__."/../vendor/autoload.php";
Usuario::deleteAll();
Producto::deleteAll();
Usuario::crearUsuarios(10);
Producto::crearProductos(50);
echo "\nDatos creados......";