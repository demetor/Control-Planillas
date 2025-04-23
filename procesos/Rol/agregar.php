<?php
require_once "../../Conexion/conexion2/conexion.php";
$conexion = conexion();

$nombre = $_POST['nombre_rol'];
$descripcion = $_POST['Descipcion_rol'];

// Verifica si el rol ya existe en la base de datos
$sqlCheck = "SELECT COUNT(*) AS count FROM roles WHERE nombre_rol = ?";
$stmt = $conexion->prepare($sqlCheck);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    echo "error: El rol ya existe.";
} else {
    // Llamar al procedimiento almacenado para insertar el rol
    $sql = "CALL insertar_rol(?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $nombre, $descripcion);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: No se pudo insertar el rol.";
    }
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>
