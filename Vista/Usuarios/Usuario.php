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
							Usuarios
						</div>
						<div class="card-body">
							<!-- Botón para agregar nuevo -->
							<span class="btn btn-primary" data-toggle="modal" data-target="#Agregar-Datos-Modal">
								Agregar nuevo <span class="fas fa-plus-circle"></span>
							</span>

							<!-- Botón para carga masiva -->
							<span class="btn btn-success ml-2" data-toggle="modal" data-target="#Modal-subir">
								Carga Masiva <span class="fas fa-upload"></span>
							</span>

							<hr>
							<div id="tabla_Datatable"></div>
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
							<form id="form-nuevo-Usuario">
								<label>Nombre Usuario</label>
								<input type="text" class="form-control input-sm" id="nombre" name="nombre" title="Este campo es obligatorio" pattern="[0-9]+" required="">
								<label>Correo Usuario</label>
								<input type="email" class="form-control input-sm" id="Correo" name="Correo" title="Este campo es obligatorio" required="">
								<label>Cedula</label>
								<input type="text" class="form-control input-sm" id="Cedula" name="Cedula" title="Este campo es obligatorio" required="">
								<label>Rol</label>
								<select id="rol" name="rol" class="form-control" title="Solo se permite escribir numeros" required="">
									<?php

									require_once "../../Conexion/conexion.php";
									$obj = new conectar();
									$conexion = $obj->conexion();

									$sql = "SELECT * FROM roles";
									$result = mysqli_query($conexion, $sql);

									?>

									<?php foreach ($result as $opciones): ?>

										<option value="<?php echo $opciones['id'] ?>"><?php echo $opciones['nombre_rol'] ?></option>

									<?php endforeach ?>

								</select>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							<button type="button" id="btn-guardar-rol" class="btn btn-primary">Guardar</button>
						</div>
					</div>
				</div>
			</div>
<!-----------------------------------Modal Subir Carga Masiva --------------------------------------------------------->
			<div class="modal fade" id="Modal-subir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Cargar</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">

							<form action="" method="post" enctype="multipart/form-data" id="filesForm">

								<input class="form-control" type="file" name="fileContacts" id="carga">
								<br>
								<button type="button" onclick="uploadContacts()" class="btn btn-info form-control">Cargar</button>
							</form>

						</div>
						<div class="modal-footer">
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
							<form id="form-actualizar_Usuario">
								<input type="text" hidden="" id="id_usuario" name="id_usuario">
								<label>Nombre Rol</label>
								<input type="text" class="form-control input-sm" id="nombre_usuario" name="nombre_usuario" required="">
								<label>Correo:</label>
								<input type="email" class="form-control input-sm" id="Correo_usuario" name="Correo_usuario" title="Este campo es obligatorio" required="">
								<label>Cedula:</label>
								<input type="text" class="form-control input-sm" id="Cedula_usuario" name="Cedula_usuario" title="Este campo es obligatorio" required="">
								<div>
									<label>¿Desea cambiar la contraseña?</label>
									<div>
										<input type="radio" id="cambiarContraseñaSi" name="cambiarContraseña" value="si">
										<label for="cambiarContraseñaSi">Sí</label>
									</div>
									<div>
										<input type="radio" id="cambiarContraseñaNo" name="cambiarContraseña" value="no" checked>
										<label for="cambiarContraseñaNo">No</label>
									</div>
								</div>

								<!-- Div que contiene el campo de contraseña (inicialmente oculto) -->
								<div id="contenedorContraseña" style="display: none;">
									<label>Contraseña:</label>
									<input type="text" class="form-control input-sm" id="Contraseña" name="Contraseña" title="Este campo es obligatorio" required="">
								</div>
								<label>Rol:</label>
								<select id="rol_usuario" name="rol_usuario" class="form-control" title="Solo se permite escribir numeros" required="">
									<?php

									require_once "../../Conexion/conexion.php";
									$obj = new conectar();
									$conexion = $obj->conexion();

									$sql = "SELECT * FROM roles";
									$result = mysqli_query($conexion, $sql);

									?>

									<?php foreach ($result as $opciones): ?>

										<option value="<?php echo $opciones['id'] ?>"><?php echo $opciones['nombre_rol'] ?></option>

									<?php endforeach ?>

								</select>

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
			datos = $('#form-nuevo-Usuario').serialize();

			$.ajax({
				type: "POST",
				data: datos,
				url: "../../procesos/Usuarios/agregar.php",
				success: function(r) {
					if (r.trim() === "success") {
						$('#form-nuevo-Usuario')[0].reset(); // Limpia el formulario
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
			datos = $('#form-actualizar_Usuario').serialize();

			$.ajax({
				type: "POST",
				data: datos,
				url: "../../procesos/Usuarios/actualizar.php",
				success: function(r) {
					if (r.trim() === "success") {
						$('#form-actualizar_Usuario')[0].reset(); // Limpia el formulario
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
			url: "../../procesos/Usuarios/obtenDatos.php",
			success: function(r) {
				datos = jQuery.parseJSON(r);
				$('#id_usuario').val(datos['id']);
				$('#nombre_usuario').val(datos['nombre']);
				$('#Correo_usuario').val(datos['Correo']);
				$('#Cedula_usuario').val(datos['Cedula']);
				$('#Passwor_usuario').val(datos['Password']);
				$('#rol_usuario').val(datos['rol']);
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
					url: "../../procesos/Usuarios/eliminar.php",
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

<script>
	// Obtener los radio buttons
	const radioSi = document.getElementById('cambiarContraseñaSi');
	const radioNo = document.getElementById('cambiarContraseñaNo');

	// Obtener el contenedor de la contraseña
	const contenedorContraseña = document.getElementById('contenedorContraseña');

	// Función para mostrar/ocultar el campo de contraseña
	function toggleContraseña() {
		if (radioSi.checked) {
			contenedorContraseña.style.display = 'block'; // Mostrar
		} else {
			contenedorContraseña.style.display = 'none'; // Ocultar
		}
	}

	// Escuchar cambios en los radio buttons
	radioSi.addEventListener('change', toggleContraseña);
	radioNo.addEventListener('change', toggleContraseña);

	// Ejecutar la función al cargar la página (por si "Sí" está seleccionado por defecto)
	toggleContraseña();
</script>

<script type="text/javascript">
	function uploadContacts() {

		var Form = new FormData($('#filesForm')[0]);
		$.ajax({

			url: "../../procesos/Usuarios/Cargamasiva.php",
			type: "post",
			data: Form,
			processData: false,
			contentType: false,
			success: function(r) {
					if (r.trim() === "success") {
						$('#form-actualizar_Usuario')[0].reset(); // Limpia el formulario
						$('#tabla_Datatable').load('tabla.php'); // Recarga la tabla
						alertify.success('Actualizado con éxito');
					} else {
						alertify.error("Hubo un error:" + r);
					}
				}
		});
	}
</script>