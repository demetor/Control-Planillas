<?php
require_once "../../Conexion/conexion2/conexion.php";
$conexion = conexion();

// Captura de datos del formulario
$id_usuario = $_POST['id_usuario'];
$nombre = $_POST['nombre_usuario'];
$Correo = $_POST['Correo_usuario'];
$Cedula = $_POST['Cedula_usuario'];
$rol = $_POST['rol_usuario'];
$contraseña = $_POST['Contraseña'];

// Validar que el rol existe en la tabla roles
$query = "SELECT id FROM roles WHERE id = ?";
$stmt_check_rol = $conexion->prepare($query);
$stmt_check_rol->bind_param("i", $rol);
$stmt_check_rol->execute();
$stmt_check_rol->store_result();

if ($stmt_check_rol->num_rows > 0) {
    // El rol existe, entonces insertamos el usuario

    if($contraseña === ""){
        $query2 = "SELECT contrasena FROM usuarios WHERE id = ?";
        $stmt2 = $conexion->prepare($query2);
        $stmt2->bind_param("i", $id_usuario); // Cambia $id_usuario por el ID del usuario
        $stmt2->execute();
        $stmt2->store_result();
    
        // Vincular el resultado
        $stmt2->bind_result($contrasena);
        $stmt2->fetch();
        $password = $contrasena;
    } else {
        $password = password_hash($contraseña, PASSWORD_DEFAULT);
    }

    // Llamar al procedimiento almacenado para insertar los datos
    $sql = "CALL actualizar_usuario(?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isssis", $id_usuario, $nombre, $Correo, $Cedula, $rol, $password);

    // Ejecutar la consulta y manejar el resultado
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: No se pudo actualizar el usuario.";  // En caso de error
    }

    // Cerrar la conexión del procedimiento
    $stmt->close();
} else {
    // El rol no existe
    echo "error: El rol no existe.";
}

// Cerrar la conexión
$stmt_check_rol->close();
$conexion->close();
