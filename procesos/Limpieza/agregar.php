<?php

require_once "../../Conexion/conexion2/conexion.php";
$conexion = conexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id_usuario = $_POST['id_usuario'];
    $id_punto = $_POST['id_punto'];
    $comentario = $_POST['Comentario'];
    $estado_aseo = $_POST['estado_aseo'];
    $actividades = isset($_POST['actividades']) ? $_POST['actividades'] : []; // Actividades seleccionadas

    // Procesar la imagen
    if (isset($_FILES['foto'])) {
        $imagen = $_FILES['foto'];
        $nombreUnico = uniqid('foto_', true) . '.jpg'; // Generar un nombre único
        $rutaImagen = '../../assets/Limpiezas_img/' . $nombreUnico;

        // Mover la imagen a la carpeta
        if (move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {

            // Llamar al procedimiento almacenado para insertar los datos en control_aseo
            $sql = "CALL insertar_control_aseo(?, ?, ?, ?, ?, @last_inserted_id)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("iisss", $id_usuario, $id_punto, $comentario, $estado_aseo, $rutaImagen);

            // Ejecutar la consulta y manejar el resultado
            if ($stmt->execute()) {
                // Obtener el ID del control_aseo recién insertado
                $result = $conexion->query("SELECT @last_inserted_id AS last_id");
                $row = $result->fetch_assoc();
                $control_aseo_id = $row['last_id'];

                // Insertar las actividades realizadas en la tabla actividad_control_aseo
                if (!empty($actividades)) {
                    foreach ($actividades as $actividad_id) {
                        // Llamar al procedimiento almacenado insertar_actividad_control
                        $sql_actividad = "CALL insertar_actividad_control(?, ?)";
                        $stmt_actividad = $conexion->prepare($sql_actividad);
                        $stmt_actividad->bind_param("ii", $actividad_id, $control_aseo_id);

                        if (!$stmt_actividad->execute()) {
                            echo "Error al insertar la actividad: " . $stmt_actividad->error;
                        }

                        // Cerrar la consulta de actividad
                        $stmt_actividad->close();
                    }
                }

                echo "success"; // Éxito
            } else {
                echo "error: No se pudo insertar el control de aseo.";  // En caso de error
            }

            // Cerrar la consulta del procedimiento almacenado
            $stmt->close();
        } else {
            echo "Error al guardar la imagen.";
        }
    } else {
        echo "No se recibió ninguna imagen.";
    }
} else {
    // El rol no existe
    echo "error: Datos no Recibidos";
}

// Cerrar la conexión
$conexion->close();
