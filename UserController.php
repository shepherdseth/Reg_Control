<?php

/* El Controlador se comunica con VISTA y MODELO según se requiera para obtener datos desde el MODELO y mostralos a VISTA, o recibir un POST de VISTA para solicitar al MODELO que recoja o inyecte datos desde la VISTA */

/* Solicitamos  el UserModel para conectaros al modelo y tener acceso a los datos y lógica de negocio. */
session_start();
require_once("Vista.php");
require_once("UserModel.php");

$result = null;

/* Agregué este bloque de código para verificar qué errores me impedían conectarme a la base */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/* Creamos un nueva nueva instancia (objeto) de la clase UserModel para interactuar con la BD. */

$userModel = new UserModel();

/* por medio de este código se interactúa con Vista al recibir la información de los
botones en el formulario*/

if ($_SERVER["REQUEST_METHOD"] == "POST") { /* Verifica que se hayan enviado datos por medio de POST */
    if (isset($_POST['entrada'])) { /* Datos que provengan del botón entrada, o el que corresponda en cada caso. */

        $numero_identificacion = trim($_POST['numero_identificacion']); /* Recoge los datos ingresados por POST y se asignan variable a $numero_identificacion */
        $userModel->registrarEntrada($numero_identificacion); /* Se llama al método registraEntrada dentro del objeto $userModel y la variable $numero_identificacion se pasa como argumento */
    } elseif (isset($_POST['salida'])) { /* Continua el ciclo si no se cumple la condición de entrada */

        $numero_identificacion = trim($_POST['numero_identificacion']);
        $userModel->registrarSalida($numero_identificacion);
    } elseif (isset($_POST['añadir_nuevo'])) {

        $nombre_usuario = trim($_POST['nombre_usuario']);
        $numero_identificacion = trim($_POST['identificacion']);
        $userModel->agregarNuevoUsuario($nombre_usuario, $numero_identificacion);
    } elseif (isset($_POST['buscar_control'])) {

        $buscar_identificacion = trim($_POST['buscar']);
        $result = $userModel->buscarUsuario($buscar_identificacion);
        require_once("Vista.php");
    } elseif (isset($_POST['mod_nombre'])) {

        $numero_identificacion_mod = trim($_POST['numero_identificacion_mod']);
        $nombre_mod = trim($_POST['nombre_mod']);
        $userModel->modificarUsuario($nombre_mod, $numero_identificacion_mod);
    } elseif (isset($_POST['eliminar'])) {

        $delete_usuario = trim($_POST['eliminar_usuario']);
        $userModel->eliminarUsuario(
            $delete_usuario
        );
    }




    $_SESSION['success_message'] = "Operación realizada con éxito"; /* Almacena mensaje de éxito que se mostrará en Vista */
}
