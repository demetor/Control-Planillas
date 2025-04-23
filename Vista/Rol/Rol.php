<?php
session_start(); // Iniciar la sesión
if (isset($_SESSION['datos_instructor'])) {
	$datos_instructor = $_SESSION['datos_instructor'];
	$id_usu = $datos_instructor['id'];
} else {
	$datos_instructor = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../../assets/img/Mini_logo.png" shortcut icon>

	<title>Tec control</title>

	<!-- Custom fonts for this template-->
	<link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="https://cdn.datatables.net/2.2.1/css/dataTables.bootstrap5.css" rel="stylesheet" type="text/css">
	<link href="https://cdn.datatables.net/searchpanes/2.3.3/css/searchPanes.bootstrap5.css" rel="stylesheet" type="text/css">
	<link href="https://cdn.datatables.net/select/3.0.0/css/select.bootstrap5.css" rel="stylesheet" type="text/css">
	<link href="https://cdn.datatables.net/select/3.0.0/css/select.bootstrap5.css" rel="stylesheet" type="text/css">

	<?php require_once "scripts.php" ?>
</head>


<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<?php
		include '../elementos-menu/menu.php';
		?>

		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="card text-left">
						<div class="card-header" style="text-align: center;">
							Roles
						</div>
						<div class="card-body">
							<span class="btn btn-primary" data-toggle="modal" data-target="#Agregar-Datos-Modal">
								Agregar nuevo <span class="fas fa-plus-circle"></span>
							</span>

							<hr>
							<div id="tabla_Datatable">

							</div>
						</div>
					</div>
				</div>
			</div>

			<!----------------------------------------------Modal Agregar------------------------------------------------------------------->
			<div class="modal fade" id="Agregar-Datos-Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Agregar Rol</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form id="form-nuevo-rol">
								<label>Nombre Rol</label>
								<input type="text" class="form-control input-sm" id="nombre_rol" name="nombre_rol" title="Este campo es obligatorio" pattern="[0-9]+" required="">
								<label>Descripcion</label>
								<input type="text" class="form-control input-sm" id="Descipcion_rol" name="Descipcion_rol" title="Este campo es obligatorio" required="">
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							<button type="button" id="btn-guardar-rol" class="btn btn-primary">Guardar</button>
						</div>
					</div>
				</div>
			</div>


			<!-------------------------------------------Modal Actualizar------------------------------------------------------------------->
			<div class="modal fade" id="Modal-editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form id="form-actualizar_rol">
								<input type="text" hidden="" id="id" name="id">
								<label>Nombre Rol</label>
								<input type="text" class="form-control input-sm" id="nombre" name="nombre" required="">
								<label>Descripcion</label>
								<input type="text" class="form-control input-sm" id="descripcion" name="descripcion" required="">
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							<button type="button" class="btn btn-info" id="btn-actualizar">Actualizar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

<!------------------------------------------ AJAX BOTON AGREGAR --------------------------------------------------->
<script type="text/javascript">
	$(document).ready(function() {
		$('#btn-guardar-rol').click(function() {
			datos = $('#form-nuevo-rol').serialize();

			$.ajax({
				type: "POST",
				data: datos,
				url: "../../procesos/Rol/agregar.php",
				success: function(r) {
					if (r.trim() === "success") {
						$('#form-nuevo-rol')[0].reset(); // Limpia el formulario
						$('#tabla_Datatable').load('tabla.php'); // Recarga la tabla
						alertify.success('Agregado con éxito');
					} else {
						alertify.error("Hubo un error:" + r);
					}
				}
			});
		});
	});
</script>

<!------------------------------ AJAX BOTON ACTUALIZAR ------------------------------------------------------------>
<script type="text/javascript">
	$(document).ready(function() {
		$('#btn-actualizar').click(function() {
			datos = $('#form-actualizar_rol').serialize();

			$.ajax({
				type: "POST",
				data: datos,
				url: "../../procesos/Rol/actualizar.php",
				success: function(r) {
					if (r.trim() === "success") {
						$('#form-actualizar_rol')[0].reset(); // Limpia el formulario
						$('#tabla_Datatable').load('tabla.php'); // Recarga la tabla
						alertify.success('Actualizado con éxito');
					} else {
						alertify.error("Hubo un error:" + r);
					}
				}
			});
		});
	});
</script>

<!------------------------------ FORMATO DATATABLE ---------------------------------------------------------------->
<script type="text/javascript">
	$(document).ready(function() { //Codigo para abir un documento jQuery
		$('#tabla_Datatable').load('tabla.php')
	});
</script>

<!------------------------------- AJAX OBTENER DATOS -------------------------------------------------------------->
<script type="text/javascript">
	function obtenDatos(id) {
		$.ajax({
			type: "POST",
			data: "id=" + id,
			url: "../../procesos/Rol/obtenDatos.php",
			success: function(r) {
				datos = jQuery.parseJSON(r);
				$('#id').val(datos['id']);
				$('#nombre').val(datos['nombre_rol']);
				$('#descripcion').val(datos['descripcion']);
			}
		});
	}

	//------------------------------- AJAX ELIMINAR ------------------------------------------------------------------->
	function eliminar(id) {
		alertify.confirm('Eliminar un registro', '¿Está seguro que desea eliminar este registro?',
			function() {
				// Realizar la solicitud AJAX para eliminar el rol
				$.ajax({
					type: "POST",
					data: {
						id: id
					}, // Utilizando un objeto para enviar el parámetro
					url: "../../procesos/Rol/eliminar.php",
					success: function(r) {
						if (r == "success") { // Asegurarse de que el servidor responda con 'success' en vez de solo 1
							$('#tabla_Datatable').load('tabla.php'); // Recargar la tabla
							alertify.success("El registro fue eliminado con éxito.");
						} else {
							// Mostrar un mensaje de error detallado si la eliminación falla
							alertify.error("Hubo un error al eliminar el registro. " + r);
						}
					},
					error: function(xhr, status, error) {
						// En caso de error en la solicitud AJAX
						alertify.error("Error al conectar con el servidor. Intente nuevamente.");
					}
				});
			},
			function() {
				// Acción en caso de que el usuario cancele la operación
				alertify.error("Eliminación cancelada.");
			});
	}
</script>