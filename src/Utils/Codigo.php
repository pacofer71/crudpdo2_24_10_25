<?php
namespace App\Utils;
class Codigo{
    public static function pintarNav(string $titulo): void{
        echo <<< TXT
         <nav class="bg-gray-800 text-white px-6 py-3 flex items-center justify-between shadow-lg">
        <!-- Logo o título -->
        <div class="flex items-center space-x-2">
            <i class="fas fa-user-shield text-blue-400 text-xl"></i>
            <span class="font-semibold text-lg">$titulo</span>
        </div>

        <!-- Sección derecha: email y logout -->
        <div class="flex items-center space-x-3">
            <!-- Campo de email solo lectura -->
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fas fa-envelope"></i>
                </span>
                <input
                    type="text"
                    readonly
                    value="{$_SESSION['email']}"
                    class="bg-gray-700 text-gray-200 pl-10 pr-3 py-2 rounded-lg text-sm border border-gray-600 focus:outline-none cursor-default w-56" />
            </div>

            <!-- Botón Logout -->
            <a href="cerrar.php"
                class="flex items-center space-x-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-300">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
        </nav>
        TXT;
    }
}