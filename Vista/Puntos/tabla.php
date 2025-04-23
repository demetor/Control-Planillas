<?php

require_once "../../Conexion/conexion.php";
$obj = new conectar();
$conexion = $obj->conexion();

$sql = "SELECT * FROM vista_puntos;";
$result = mysqli_query($conexion, $sql);

?>

<div>
    <table class="table table-hover table-condensed table-bordered" id="id_datatable">
        <thead style="background-color: #005f60; color: white;">
            <tr>
                <td>#</td>
                <td>Nombre del punto</td>
                <td>Descripción</td>
                <td>Ubicación</td>
                <td>codigo-QR</td>
                <td>Estado</td>
                <td>Editar</td>
                <td>Eliminar</td>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($mostrar = mysqli_fetch_row($result)) {
            ?>
                <tr>
                    <td><?php echo $mostrar[0] ?></td>
                    <td><?php echo $mostrar[1] ?></td>
                    <td><?php echo $mostrar[2] ?></td>
                    <td><?php echo $mostrar[3] ?></td>
                    <td>
                        <!-- Imagen clickeable -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $mostrar[0]; ?>">
                            <img src="<?php echo $mostrar[5]; ?>" alt="Imagen" width="100" height="100">
                        </a>
                    </td>
                    <td><?php echo $mostrar[4] ?></td>

                    <td style="text-align: center;">
                        <span class="btn btn-warning btn-sm" data-toggle="modal" data-target="#Modal-editar" onclick="obtenDatos('<?php echo $mostrar[0]; ?>')">
                            <span class="fas fa-edit"></span>
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <span class="btn btn-danger btn-sm" onclick="eliminar('<?php echo $mostrar[0]; ?>')">
                            <span class="fas fa-trash-alt"></span>
                        </span>
                    </td>
                </tr>

                <!-- Modal para mostrar la imagen -->
                <div class="modal fade" id="imageModal<?php echo $mostrar[0]; ?>" tabindex="-1" aria-labelledby="imageModalLabel<?php echo $mostrar[0]; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel<?php echo $mostrar[0]; ?>">Vista Previa de la Imagen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Imagen grande dentro del modal -->
                                <img src="<?php echo $mostrar[5]; ?>" alt="Imagen" class="img-fluid">
                            </div>
                            <div class="modal-footer">
                                <!-- Opciones de impresión y descarga -->
                                <a href="<?php echo $mostrar[5]; ?>" download class="btn btn-primary">Descargar Imagen</a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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

<!-- Modal para mostrar la imagen -->
<div class="modal fade" id="imageModal<?php echo $mostrar[0]; ?>" tabindex="-1" aria-labelledby="imageModalLabel<?php echo $mostrar[0]; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel<?php echo $mostrar[0]; ?>">Vista Previa de la Imagen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body d-flex justify-content-center" style="display: flex; justify-content: center; align-items: center;">
                <!-- Imagen centrada y más grande dentro del modal -->
                <img src="<?php echo $mostrar[5]; ?>" alt="Imagen" class="img-fluid" style="max-width: 90%; max-height: 80vh;">
            </div>
            <div class="modal-footer">
                <!-- Opciones de impresión y descarga -->
                <a href="<?php echo $mostrar[5]; ?>" download class="btn btn-primary">Descargar Imagen</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" onclick="window.print()">Imprimir Imagen</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#id_datatable').DataTable({
            //$('#id_datatable').css( 'display', 'block' );
            //"autoWidth": false

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