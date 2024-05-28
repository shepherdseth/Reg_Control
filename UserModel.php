<?php

/* Modelo se comunica con la base de datos a petición de Control. */


$conexion = new mysqli("localhost", "root", "", "registro_control"); /* Establecemos la conexión a la base de datos */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Aquí definimos la clase UserModel que se encargará de llevar a cabo la conexión con la BD */

class UserModel
{
    public function agregarNuevoUsuario($nombre_usuario, $numero_identificacion)
    {

        /* Aquí no usamos msqli_query(),sino que usamos consultas preparadas que en teoría son más seguras que la inyección directa  */
        /* Aquí creamos diferentes métodos para la clase UserModel, los cuales realizan tareas específicas. Para este ejercicio inicialmente cree todo el formato precedural antes de tratar de entender cómo aplicar MVC y clases y métodos y objetos */


        /* Si bien recuerdo estaríamos siguiendo CRUD al crear (Create), leer (Read), actualizar (Update) y poder borrar (Delete) información de la base de datos */


        global $conexion;
        $stmt = $conexion->prepare("INSERT INTO usuarios(nombre_usuario, numero_identificacion) VALUES (?, ?)");
        $stmt->bind_param("si", $nombre_usuario, $numero_identificacion); /* INSERT permite ingresar datos en una tabla: usuarios con dos campos (nombre usuario y numero identificación). */
        $stmt->execute();                                               /* YA previamente establecimos conexion a base de datos */
        $stmt->close();
    }
    public function buscarUsuario($buscar_identificacion)
    {
        global $conexion;
        $stmt = $conexion->prepare("SELECT usuarios.nombre_usuario, usuarios.numero_identificacion, 
                                           registros.fecha_entrada, registros.fecha_salida 
                                    FROM   usuarios 
                                    JOIN registros ON usuarios.numero_identificacion = registros.numero_identificacion 
                                    WHERE usuarios.numero_identificacion = ? ORDER BY registros.fecha_entrada DESC");
        $stmt->bind_param("i", $buscar_identificacion);
        $stmt->execute();                   /* Al crear la base hicimos que se conectara usuarios y registros mediante un número de identificación */
        $result = $stmt->get_result();       /* Por ello aquí, para leer la base debimos unir usuarios y registros de modo que se puediera tener acceso y mostrar todos los datos necesario, pues registros no tiene nombre de usuario, sino n° de identificación */
        return $result;
    }
    public function modificarUsuario($nombre_mod, $numero_identificacion_mod)
    {
        global $conexion;
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre_usuario = ? WHERE numero_identificacion = ?");
        $stmt->bind_param("si", $nombre_mod, $numero_identificacion_mod);
        $stmt->execute();    /* El código usa UPDATE par modificar un usuario existente. */
        $stmt->close();
    }

    public function eliminarUsuario($delete_usuario)
    {
        global $conexion;
        $stmt = $conexion->prepare("DELETE FROM usuarios WHERE numero_identificacion = ?");
        $stmt->bind_param("i", $delete_usuario);
        $stmt->execute();
        $stmt->close();     /* DELTE, borra un usuario y sus registros. */
    }



    public function registrarEntrada($numero_identificacion)
    {
        global $conexion;
        $fecha_entrada = date("Y-m-d H:i:s");
        $stmt = $conexion->prepare("INSERT INTO registros (numero_identificacion, fecha_entrada) VALUES (?, ?)");
        $stmt->bind_param("is", $numero_identificacion, $fecha_entrada);
        $stmt->execute();
        $stmt->close();
    }

    public function registrarSalida($numero_identificacion)
    {
        global $conexion;
        $fecha_salida = date("Y-m-d H:i:s");
        $stmt = $conexion->prepare("UPDATE registros SET fecha_salida = ? WHERE numero_identificacion = ? AND fecha_salida IS NULL ORDER BY fecha_entrada DESC LIMIT 1");
        $stmt->bind_param("si", $fecha_salida, $numero_identificacion);
        $stmt->execute();
        $stmt->close();
    }
}
