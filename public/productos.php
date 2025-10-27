<?php

use App\Bbdd\Producto;
use App\Utils\Codigo;

session_start();
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
    die();
}
require __DIR__ . "/../vendor/autoload.php";
$email = $_SESSION['email'];
$productos = Producto::read();
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
    <title>productos</title>
</head>

<body class="bg-blue-200">
    <?php
    Codigo::pintarNav("Listado de Productos");
    ?>
    <div class="p-8">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nombre (id)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Descripcion
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Precio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Disponible
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Usuario
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $item):
                    $color=($item->disponible=='SI') ? "bg-green-500" : "bg-red-500";
                    $colorFilaUsuario=($item->email==$email) ? "bg-red-100" : "bg-white"; 
                ?>
                    <tr class="<?= $colorFilaUsuario; ?> border-b dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <?= $item->nombre ?>
                        </th>
                        <td class="px-6 py-4">
                            <?= $item->descripcion ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= $item->precio ?> €
                        </td>
                        <td class="px-6 py-4">
                            <p class="<?=$color;?> p-2 rounded-xl font-bold text-white text-center">
                            <?= $item->disponible ?>
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            <?= $item->email ?>
                        </td>
                        <td class="px-6 py-4">
                            BOTONES
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>