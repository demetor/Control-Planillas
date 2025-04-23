<?php

require_once "../../Conexion/conexion2/conexion.php";
$conexion = conexion();

// Verificar que se haya recibido un ID válido
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id_rol = $_POST['id'];

    // Preparar la consulta para eliminar el rol utilizando un procedimiento almacenado
    $sql = "CALL eliminar_rol(?)";
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular el parámetro
        $stmt->bind_param("i", $id_rol);  // 'i' indica que el parámetro es un entero

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "success";  // La eliminación fue exitosa
        } else {
            echo "error: " . $stmt->error;  // Si ocurre un error durante la ejecución
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "error: No se pudo preparar la consulta.";  // Si no se puede preparar la consulta
    }
} else {
    echo "error: ID de rol inválido.";  // Si no se recibe un ID válido
}

// Cerrar la conexión
$conexion->close();

?>
