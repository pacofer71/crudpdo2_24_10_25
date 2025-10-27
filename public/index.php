<?php

use App\Utils\Validacion;

session_start();
require __DIR__ . "/../vendor/autoload.php";
if (isset($_POST['email'])) {
    // Procesamos el formulario.
    //1.- Recojemos y saneamos los campos
    $email = Validacion::sanearCampos($_POST['email']);
    $password = Validacion::sanearCampos($_POST['password']);
    //2.- Validamos
    $errores = false;
    if (!Validacion::longitudCampoValida($password, 'password', 5, 12)) {
        $errores = true;
    }
    if (!Validacion::emailValido($email)) {
        $errores = true;
    }
    if(!Validacion::isLoginValido($email, $password)){
        $errores=true;
    }
    //3.1 Si hay errores los mostramos
    if ($errores) {
        header("Location:index.php");
        die();
    }
    //3.2 Si estoy aqui todo ha ido bien, el login ha sido un exito
    $_SESSION['email']=$email;
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
    <title>Login</title>
</head>

<body class="p-8 bg-blue-200">
    <h3 class="text-center text-xl font-bold mb-2">Login</h3>
    <div class="max-w-sm mx-auto mt-10 bg-white shadow-lg rounded-2xl p-6 space-y-6">
        <form method="POST" action="index.php">
            <h2 class="text-2xl font-semibold text-gray-800 text-center">Iniciar sesión</h2>

            <!-- Campo Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input
                        type="text"
                        id="email"
                        name="email"
                        placeholder=""
                        required
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" />

                </div>
                <?php
                Validacion::pintarError('err_email');
                ?>
            </div>

            <!-- Campo Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" />

                </div>
                <?php
                Validacion::pintarError('err_password');
                ?>
            </div>

            <!-- Botón -->
            <button
                type="submit"
                class="w-full bg-blue-600 text-white font-medium py-2 rounded-xl hover:bg-blue-700 transition-colors duration-300">
                <i class="fas fa-sign-in-alt mr-2"></i> Iniciar sesión
            </button>

            <!-- Enlace de registro -->
            <p class="text-center text-sm text-gray-600 mt-3">
                ¿No tienes cuenta?
                <a href="#" class="text-blue-600 hover:underline">Regístrate aquí</a>
            </p>
            <?php
                Validacion::pintarError('err_validacion');
            ?>
        </form>
    </div>




</body>

</html>