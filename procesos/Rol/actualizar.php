<?php
require_once "../../Conexion/conexion2/conexion.php";
$conexion = conexion();

// Capturar datos del formulario
$id_rol = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];

// Verificar si el rol ya existe en la base de datos (excepto el rol que estamos actualizando)
$sqlCheck = "SELECT COUNT(*) AS count FROM roles WHERE nombre_rol = ? AND id != ?";
$stmt = $conexion->prepare($sqlCheck);
$stmt->bind_param("si", $nombre, $id_rol);  // 's' para string, 'i' para integer
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Si el rol ya existe, no ejecutamos el procedimiento
if ($row['count'] > 0) {
    echo "error: El rol ya existe."; // Mensaje para indicar que el rol ya existe
} else {
    // Si el rol no existe, ejecutar la actualización
    $sql = "CALL actualizar_rol(?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iss", $id_rol, $nombre, $descripcion);  // 'i' para integer, 's' para string

    // Ejecutar la consulta y manejar el resultado
    if ($stmt->execute()) {
        echo "success"; // Enviado a AJAX para manejar con Alertify
    } else {
        echo "error: " . $stmt->error;
    }
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>

