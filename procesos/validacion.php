<?php
// Sanear y validar las entradas
$cedula = $_REQUEST['cedula'];
$contrasena = $_REQUEST['contrasena'];

// conexión a la base de datos
try {
    require('../Conexion/conexion.php');
    $obj = new conectar();
    $conexion = $obj->conexion();

    // Preparamos la consulta para evitar inyecciones SQL
    $sql = "SELECT id, nombre, correo, cedula, contrasena, id_rol FROM usuarios WHERE cedula = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $cedula); // 's' indica que es un string
    $stmt->execute();

    // Obtener el resultado de la consulta
    $resultado = $stmt->get_result();

    // Verificar si se encontró un usuario
    if ($resultado->num_rows > 0) {
        // Obtener los datos del usuario
        $row = $resultado->fetch_assoc();

        // Verificar la contraseña utilizando password_verify
        if (password_verify($contrasena, $row['contrasena'])) {
            // La contraseña es correcta, iniciar la sesión
            session_start(['cookie_lifetime' => 86400]); // Duración de la sesión 1 día
            $_SESSION['datos_instructor'] = $row; // Guardar los datos del usuario en la sesión

            // Redirigir al menú
            header("Location: ../Vista/elementos-menu/Inicio_menu.php");
            exit();
        } else {
            // Contraseña incorrecta, redirigir a la página de inicio
            header("Location: ../index.php?error=incorrect_password");
            exit();
        }
    } else {
        // Usuario no encontrado, redirigir a la página de inicio
        header("Location: ../index.php?error=user_not_found");
        exit();
    }
    $conexion->close();
} catch (Exception $e) {
    // Manejo centralizado de errores
    error_log($e->getMessage(), 3, "errores_control_db.log");
    die("Ocurrió un error al procesar su solicitud.");
}
