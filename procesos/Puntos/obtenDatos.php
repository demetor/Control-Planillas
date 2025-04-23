<?php

require_once "../../Conexion/conexion2/conexion.php";
$conexion = conexion();

// Validar que el id sea un número
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
    
    // Usar una consulta preparada para evitar inyección SQL
    $sql = "CALL ObtenerRegistrosPunto(?)";

    // Preparar la consulta
    if ($stmt = mysqli_prepare($conexion, $sql)) {
        // Enlazar el parámetro
        mysqli_stmt_bind_param($stmt, 'i', $id); // 'i' indica que el parámetro es un entero
        
        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);

        // Obtener el resultado
        $result = mysqli_stmt_get_result($stmt);
        
        if ($mostrar = mysqli_fetch_row($result)) {
            // Crear un array con los resultados
            $datos = array(
                'id' => $mostrar[0],
                'nombre_punto' => $mostrar[1],
                'Descipcion_punto' => $mostrar[2],
                'Ubicacion_punto' => $mostrar[3],
                'Estado' => $mostrar[4],
            );

            // Devolver los datos como JSON
            echo json_encode($datos);
        } else {
            // Si no se encuentran resultados
            echo json_encode(array("error" => "No se encontraron registros."));
        }

        // Cerrar la declaración
        mysqli_stmt_close($stmt);
    } else {
        // Manejo de error si la consulta no se puede preparar
        echo json_encode(array("error" => "Error al preparar la consulta."));
    }
} else {
    // Si no se recibe un id válido
    echo json_encode(array("error" => "ID inválido o no proporcionado."));
}

// Cerrar la conexión
mysqli_close($conexion);
?>
