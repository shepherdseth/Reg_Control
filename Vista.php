<!-- EN términos generales en vista recibimos la información del UserCOntroller, que a su vez la recibe de UserModel
y la mandamos para desplegada en la página web -->

<!-- Vista de encarga de mostrar los datos obtenidos desde el controlador -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Control de Empleados</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- LLamamos al CSS -->
</head>

<body>

    <div class="head-container">
        <h1> REGISTRO DE CONTROL DE EMPLEADOS </h1>
    </div>

    <div class="message-section"> <!-- Verifica si hay una variable en $_SESSION y con base en ello envía mensajes de éxito  -->
        <?php if (isset($_SESSION['success_message'])) : ?>
            <div class="success-message">
                <?php echo $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
    </div>

    <?php require_once("UserController.php"); ?> <!-- Solicitamos con el UserController.php para conectarnos a él-->

    <div class="form-section">
        <h2>Control de Entradas y Salidas</h2>
        <form method="post">
            <label class="titulo_campo" for="numero_identificacion">Identificador</label>
            <input class="form-input" type="text" id="numero_identificacion" name="numero_identificacion" placeholder="Ingrese n° de identificacion" pattern='[0-9]+' required> <br>
            <input type="submit" name="entrada" value="ENTRADA">
            <input type="submit" name="salida" value="SALIDA">
        </form>
    </div>

    <div class="form-section">
        <h2>Administrador de Base de Datos</h2>

        <form method="post">
            <label class="titulo_campo" for="nombre_usuario_reg">Nombre</label>
            <input class="form-input" type="text" id="nombre_usuario_reg" name="nombre_usuario" placeholder="Ingrese nombre del empleado." required> <br>
            <label class="titulo_campo" for="numero_identificacion_reg">N° de identificación</label>
            <input class="form-input" type="text" id="numero_identificacion_reg" name="identificacion" placeholder="Ingrese n° de identificacion" pattern='[0-9]+' required> <br>
            <input type="submit" name="añadir_nuevo" value="AÑADIR NUEVO"> <br>
        </form>
    </div>

    <div class="form-section">
        <h2>Administrar Usuarios</h2>
        <form method="post">
            <label class="titulo_campo" for="buscar">Buscar registro de empleado</label>
            <input class="form-input" type="text" id="buscar" name="buscar" placeholder="Ingrese de n° de identificacion" pattern='[0-9]+' required> <br>
            <input type="submit" name="buscar_control" value="BUSCAR"> <br>
        </form>
    </div>
    <div class="result-section">


        <?php
        if (isset($result)) {
            if ($result && $result->num_rows > 0) {
                echo "<table class='search-table'>";
                echo "<tr>";
                echo "<th>Nombre de usuario</th>";
                echo "<th>Fecha de entrada</th>";
                echo "<th>Fecha de salida</th>";
                echo "</tr>";

                $nombre_desplegado = false; // Variable para rastrear si ya se mostró el nombre de usuario
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    // Mostrar el nombre de usuario solo si aún no se ha mostrado
                    if (!$nombre_desplegado) {
                        echo "<td rowspan='" . $result->num_rows . "'>" . $row["nombre_usuario"] . "</td>";
                        $nombre_desplegado = true; // Actualizar la bandera después de mostrar el nombre de usuario
                    }
                    echo "<td>" . $row["fecha_entrada"] . "</td>";
                    echo "<td>" . $row["fecha_salida"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<div class='no-result'>No se encontró ningún usuario con el n° de identificación proporcionado.</div>";
            }
        }
        ?>
    </div>



    <div class="form-section">
        <h2>Modificar Usuario</h2>
        <form method="post">
            <label class="titulo_campo" for="numero_identificacion_mod">Modificar datos de empleado</label>
            <input class="form-input" type="text" id="numero_identificacion_mod" name="numero_identificacion_mod" placeholder="Ingrese n° de identificacion" pattern='[0-9]+' required> <br>
            <input class="form-input" type="text" id="nombre_mod" name="nombre_mod" placeholder="Ingrese nuevo nombre" required> <br>
            <input type="submit" name="mod_nombre" value="MODIFICAR"><br>
        </form>
    </div>



    <div class="form-section">
        <h2>Eliminar Usuario</h2>
        <form method="post">
            <label class="titulo_campo" for="eliminar">Eliminar empleado</label>
            <input class="form-input" type="text" id="eliminar" name="eliminar_usuario" placeholder="Ingrese n° de identificacion" pattern='[0-9]+' required> <br>
            <input type="submit" name="eliminar" value="ELIMINAR">
        </form>
    </div>

    <!-- Aquí traté de que el mensaje de éxito se mostrara arriba -->

    <div class="message-section">
        <?php if (isset($_SESSION['success_message'])) : ?>
            <div class="success-message">
                <?php echo $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
    </div>

</body>

</html>