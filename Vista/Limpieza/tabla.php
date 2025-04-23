<?php

require_once "../../Conexion/conexion.php";
$obj = new conectar();
$conexion = $obj->conexion();

$sql = "SELECT * FROM vista_aseo;";
$result = mysqli_query($conexion, $sql);

?>

<div class="container-fluid">
    <table class="table table-hover table-condensed table-bordered" id="id_datatable">
        <thead style="background-color: #005f60; color: white;">
            <tr>
                <td>#</td>
                <td>Punto</td>
                <td>Hora</td>
                <td>Estado</td>
                <td>Foto</td>
                <td>Actividades Realizadas</td>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($mostrar = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $mostrar['id']; ?></td>
                    <td><?php echo $mostrar['nombre_puntos']; ?></td>
                    <td><?php echo $mostrar['hora']; ?></td>
                    <td><?php echo $mostrar['estado_aseo']; ?></td>
                    <td>
                        <!-- Imagen clickeable -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $mostrar['id']; ?>">
                            <img src="<?php echo $mostrar['foto']; ?>" alt="Imagen" width="100" height="100">
                        </a>
                    </td>
                    <td>
                        <?php
                        $id_consulta = $mostrar['id'];
                        $sql2 = "SELECT actividad_nombre FROM vista_detallada_actividad_control WHERE id_control_aseo = $id_consulta;";
                        $result2 = mysqli_query($conexion, $sql2);

                        if ($result2) {
                            while ($actividades = mysqli_fetch_assoc($result2)) {
                                echo "-" . $actividades['actividad_nombre'] . "<br>";
                            }
                        } else {
                            echo "Error al cargar las actividades: " . mysqli_error($conexion);
                        }
                        ?>
                    </td>
                </tr>

                <!-- Modal para la imagen -->
                <div class="modal fade" id="imageModal<?php echo $mostrar['id']; ?>" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">Imagen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="<?php echo $mostrar['foto']; ?>" alt="Imagen" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#id_datatable').DataTable({
            //$('#id_datatable').css( 'display', 'block' );
            autoWidth: false,

            //scrollY:        "300px",
            scrollX: true,
            //scrollCollapse: true,
            //paging:         false,
            columnDefs: [{
                width: '20%',
                targets: 0
            }],
            //fixedColumns: true

            //CODIGO PARA BOTONES DE EXPORTAR EN: PDF, CSV Y EXCEL

            /*dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],*/

            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de TOTAL registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de MAX registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
            }
        });
    });
</script>