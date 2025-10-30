<?php

use App\Bbdd\Producto;
use App\Bbdd\Usuario;
use App\Utils\{Codigo, Validacion};
//use App\Utils\Validacion;

session_start();
require __DIR__ . "/../vendor/autoload.php";
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
    die();
}
$email = $_SESSION['email'];
if (isset($_POST['nombre'])) {
    //1.- Recogemos y limpiamos los campos del form
    $nombre = Validacion::sanearCampos($_POST['nombre']);
    $descripcion = Validacion::sanearCampos($_POST['descripcion']);
    $precio = Validacion::sanearCampos($_POST['precio']);
    $precio = (float) $precio;
    $disponible = $_POST['disponible'] ?? "Error";
    $disponible = Validacion::sanearCampos($disponible);
    //2.- Validamos los campos
    $errores = false;
    if (!Validacion::longitudCampoValida($nombre, "nombre", 3, 100)) {
        $errores = true;
    }else{
        //La longitud del nombre es correcta, comprobaremos que NO esté duplicado
        if(Validacion::existeNombreProducto($nombre)){
            $errores=true;
        }
    }
    if (!Validacion::longitudCampoValida($descripcion, 'descripcion', 5, 500)) {
        $errores = true;
    }
    if (!Validacion::rangoNumericoValido($precio, 'precio', 10, 9999.99)) {
        $errores = true;
    }
    if (!Validacion::disponibleValido($disponible)) {
        $errores = true;
    }
    if ($errores) {
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }
    //NO hay errores, guardamos elproducto
    $id_usuario = Usuario::devolverIds($email); //le asignamos el producto al usuario logeado

    (new Producto)
        ->setNombre($nombre)
        ->setDescripcion($descripcion)
        ->setDisponible($disponible)
        ->setPrecio($precio)
        ->setUsuarioId($id_usuario[0])
        ->create();
    $_SESSION['mensaje']="Producto Guardado.";
    header("Location:productos.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CDN Tailwindcss -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- CDN FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CDn SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>

<body class="bg-blue-200">
    <?php
    Codigo::pintarNav("Crear Producto");
    ?>
    <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md mt-8">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method='POST'>
            <!-- Campo Nombre -->
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tag mr-2 text-blue-500"></i>Nombre del Producto
                </label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Ingresa el nombre del producto">
                <?php
                Validacion::pintarError('err_nombre');
                ?>
            </div>

            <!-- Campo Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-align-left mr-2 text-blue-500"></i>Descripción
                </label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Describe el producto..."></textarea>
                <?php
                Validacion::pintarError('err_descripcion');
                ?>
            </div>

            <!-- Campo Precio -->
            <div class="mb-4">
                <label for="precio" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-dollar-sign mr-2 text-blue-500"></i>Precio
                </label>
                <input
                    type="number"
                    id="precio"
                    name="precio"
                    step="0.01"
                    min="0"
                    max="9999.99"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="0.00">
                <?php
                Validacion::pintarError('err_precio');
                ?>
            </div>

            <!-- Radio Buttons Disponible -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-box mr-2 text-blue-500"></i>Disponible
                </label>
                <div class="flex space-x-6">
                    <label class="inline-flex items-center">
                        <input
                            type="radio"
                            name="disponible"
                            value="SI"
                            class="text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-gray-700">Sí</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input
                            type="radio"
                            name="disponible"
                            value="NO"
                            class="text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-gray-700">No</span>
                    </label>
                </div>
                <?php
                Validacion::pintarError('err_disponible');
                ?>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4">
                <a
                    href="productos.php"
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition duration-200">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </a>
                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                    <i class="fas fa-save mr-2"></i>Guardar
                </button>
            </div>
        </form>
    </div>

</body>

</html>