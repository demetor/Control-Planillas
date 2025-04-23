<?php
require_once "../../Conexion/conexion2/conexion.php";
$conexion = conexion();

// Captura de datos del formulario
$nombre = $_POST['nombre'];
$Correo = $_POST['Correo']; 
$Cedula = $_POST['Cedula'];
$rol = $_POST['rol'];
$cotrasena = $_POST['Cedula'];

// Validar que el rol existe en la tabla roles
$query = "SELECT id FROM roles WHERE id = ?";
$stmt_check_rol = $conexion->prepare($query);
$stmt_check_rol->bind_param("i", $rol);
$stmt_check_rol->execute();
$stmt_check_rol->store_result();

if ($stmt_check_rol->num_rows > 0) {
    // El rol existe, entonces insertamos el usuario

    // Encriptar la contraseña
    $password = password_hash($cotrasena, PASSWORD_DEFAULT);

    // Llamar al procedimiento almacenado para insertar los datos
    $sql = "CALL insertar_usuario(?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssii", $nombre, $Correo, $password, $Cedula, $rol);

    // Ejecutar la consulta y manejar el resultado
    if ($stmt->execute()) {
        echo "success";  
    } else {
        echo "error: No se pudo insertar el usuario.";  // En caso de error
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
?>