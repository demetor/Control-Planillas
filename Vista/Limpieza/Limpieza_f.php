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

	<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>

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
							<span class="btn btn-primary" data-toggle="modal" data-target="#Escanear-QR-Modal">
								registrar Aseo <span class="fas fa-plus-circle"></span>
							</span>

							<hr>
							<div id="tabla_Datatable">

							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal para escanear el código QR -->
			<div class="modal fade" id="Escanear-QR-Modal" tabindex="-1" aria-labelledby="escanearQRLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="escanearQRLabel">Escanear código QR</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<!-- Contenedor para la cámara -->
							<video id="preview" width="100%" style="margin-top: 10px;"></video>
							<!-- Canvas para procesar los frames (oculto) -->
							<canvas id="canvas" style="display: none;"></canvas>
							<!-- Mensaje de error -->
							<div id="camera-error" class="alert alert-danger" style="display: none;"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal de agregar datos -->
			<div class="modal fade" id="Agregar-Datos-Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-scrollable"> <!-- Modal grande y desplazable -->
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Registrar Aseo</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form id="form-nuevo-Usuario" enctype="multipart/form-data">
								<!-- Campo oculto para el id del punto -->
								<input type="text" hidden="" id="id_usuario" name="id_usuario" value="<?php echo $id_usu; ?>">
								<input type="text" hidden="" id="id_punto" name="id_punto">

								<!-- Campo para el nombre del punto -->
								<label>Nombre Punto</label>
								<input type="text" class="form-control input-sm" id="nombre" name="nombre" title="Este campo es obligatorio" readonly>

								<!-- Otros campos del formulario -->
								<label>Comentarios</label>
								<input type="text" class="form-control input-sm" id="Comentario" name="Comentario" title="Este campo es obligatorio" required="">

								<label>Estado</label>
								<select id="estado_aseo" name="estado_aseo" class="form-control" title="Solo se permite escribir numeros" required="">
									<option value="Completo">Completo</option>
									<option value="No se pudo realizar">No se pudo realizar</option>
								</select>

								<fieldset class="mt-4">
									<legend class="fw-bold mb-3">Actividades realizadas</legend>
									<div class="mb-3">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="actividades[]" value="1" id="lavado-general">
											<label class="form-check-label" for="lavado-general">
												LAVADO GENERAL
											</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="actividades[]" value="2" id="repaso">
											<label class="form-check-label" for="repaso">
												REPASO
											</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="actividades[]" value="3" id="surtido">
											<label class="form-check-label" for="surtido">
												SURTIDO
											</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="actividades[]" value="4" id="despapelado">
											<label class="form-check-label" for="despapelado">
												DESPAPELADO
											</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="actividades[]" value="5" id="desinfeccion">
											<label class="form-check-label" for="desinfeccion">
												DESINFECCIÓN
											</label>
										</div>
									</div>
								</fieldset>

								<!-- Habilita campo de foto -->
								<div class="form-check mt-4">
									<input class="form-check-input" type="radio" id="option1" name="option" value="opcion1" onclick="toggleFields()">
									<label class="form-check-label" for="exampleRadios1">
										Tomar Foto
									</label>
								</div>

								<div class="form-check">
									<input class="form-check-input" type="radio" id="option2" name="option" value="opcion2" onclick="toggleFields()">
									<label class="form-check-label" for="exampleRadios2">
										Cargar Foto
									</label>
								</div>

								<!-- Subir Foto -->
								<div class="mt-4 w-100" id="option2Field" style="display: none;">
									<label class="form-label" for="photo">Foto:</label>
									<input class="form-control" type="file" id="photo" name="photo" accept="image/*" capture="camera">
								</div>

								<!-- Tomar Foto -->
								<div class="mt-4" id="option1Field" style="display: none;">
									<div class="d-flex flex-column align-items-center">
										<video id="video" width="320" height="240" autoplay></video>
										<canvas id="canvas" style="display: none;"></canvas>
										<button class="btn btn-outline-success mt-3" type="button" onclick="capturePhoto()">Tomar Foto</button>
									</div>
								</div>
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
							<form id="form-actualizar_Usuario">
								<input type="text" hidden="" id="id_usuario" name="id_usuario" value="">
								<label>Nombre Rol</label>
								<input type="text" class="form-control input-sm" id="nombre_usuario" name="nombre_usuario" required="">
								<label>Correo:</label>
								<input type="email" class="form-control input-sm" id="Correo_usuario" name="Correo_usuario" title="Este campo es obligatorio" required="">
								<label>Cedula:</label>
								<input type="text" class="form-control input-sm" id="Cedula_usuario" name="Cedula_usuario" title="Este campo es obligatorio" required="">
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

<!------------------------------- AJAX OBTENER DATOS ACTUALIZAR-------------------------------------------------------------->
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
</script>

<script>
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

<script type="text/javascript">
	$(document).ready(function() {
		let stream;
		let scannerActive = false;

		// Abrir el modal de escaneo de QR al hacer clic en "Registrar Aseo"
		$('span.btn-primary').click(function() {
			$('#Escanear-QR-Modal').modal('show');
		});

		// Inicializar el escáner cuando se abre el modal de escaneo
		$('#Escanear-QR-Modal').on('shown.bs.modal', function() {
			iniciarCamara();
		});

		// Detener el escáner cuando se cierra el modal de escaneo
		$('#Escanear-QR-Modal').on('hidden.bs.modal', function() {
			detenerCamara();
		});

		// Función para iniciar la cámara
		async function iniciarCamara() {
			const video = document.getElementById('preview');
			const canvas = document.getElementById('canvas');
			const contexto = canvas.getContext('2d');
			const errorDiv = document.getElementById('camera-error');

			try {
				// Solicitar acceso a la cámara
				stream = await navigator.mediaDevices.getUserMedia({
					video: {
						facingMode: 'environment' // Usar la cámara trasera
					}
				});

				// Asignar el stream de la cámara al elemento <video>
				video.srcObject = stream;
				video.play();

				// Iniciar el escaneo
				scannerActive = true;
				escanearQR();
			} catch (error) {
				console.error('Error al acceder a la cámara:', error);
				errorDiv.textContent = 'No se pudo acceder a la cámara. Asegúrate de permitir el acceso.';
				errorDiv.style.display = 'block';
			}
		}

		// Función para escanear el código QR
		function escanearQR() {
			if (!scannerActive) return;

			const video = document.getElementById('preview');
			const canvas = document.getElementById('canvas');
			const contexto = canvas.getContext('2d');

			if (video.readyState === video.HAVE_ENOUGH_DATA) {
				canvas.width = video.videoWidth;
				canvas.height = video.videoHeight;
				contexto.drawImage(video, 0, 0, canvas.width, canvas.height);

				// Obtener los datos de la imagen del canvas
				const imageData = contexto.getImageData(0, 0, canvas.width, canvas.height);

				// Decodificar el código QR
				const codigoQR = jsQR(imageData.data, imageData.width, imageData.height, {
					inversionAttempts: 'dontInvert',
				});

				// Si se detecta un código QR
				if (codigoQR) {
					scannerActive = false;
					detenerCamara();
					$('#Escanear-QR-Modal').modal('hide');

					// Enviar el código QR al servidor para obtener los datos del punto
					obtenerDatosPunto(codigoQR.data);
				} else {
					requestAnimationFrame(escanearQR); // Continuar escaneando
				}
			} else {
				requestAnimationFrame(escanearQR); // Continuar escaneando
			}
		}

		// Función para obtener los datos del punto desde el servidor
		function obtenerDatosPunto(codigoQR) {
			$.ajax({
				type: "POST",
				url: "../../procesos/Limpieza/obtenDatosQR.php",
				data: {
					codigoQR: codigoQR
				}, // Asegúrate de que el nombre del campo sea correcto
				success: function(response) {
					console.log("Respuesta del servidor:", response); // Verifica la respuesta del servidor

					try {
						const datos = JSON.parse(response);

						if (datos.id && datos.nombre) {
							alertify.success("Punto encontrado");

							// Cargar los datos en el formulario de registro
							$('#id_punto').val(datos.id); // Asegúrate de que coincida con el campo devuelto por el servidor
							$('#nombre').val(datos.nombre);

							// Mostrar el modal de agregar datos
							console.log("Abriendo modal..."); // Depuración
							$('#Agregar-Datos-Modal').modal('show');
						} else {
							alertify.error('No se encontraron datos válidos para el código QR escaneado.');
						}
					} catch (e) {
						console.error("Error al parsear la respuesta:", e);
						alertify.error("Error al procesar la respuesta del servidor.");
					}
				},
				error: function(xhr, status, error) {
					alertify.error('Error al obtener datos: ' + error);
				}
			});
		}

		// Función para detener la cámara
		function detenerCamara() {
			if (stream) {
				stream.getTracks().forEach(track => track.stop());
			}
			scannerActive = false;
		}
	});
</script>

<script>
	// Variables globales
	let imagenDataUrl = ''; // Almacena la URL de la imagen capturada

	// Acceder a la cámara
	function iniciarCamara() {
		navigator.mediaDevices.getUserMedia({
				video: true
			})
			.then((stream) => {
				const video = document.getElementById('video');
				video.srcObject = stream;
			})
			.catch((error) => {
				alertify.error('Error al acceder a la cámara:', error);
			});
	}

	// Capturar la foto
	function capturePhoto() {
		const video = document.getElementById('video');
		const canvas = document.getElementById('canvas');
		const context = canvas.getContext('2d');

		// Dibujar el fotograma actual en el canvas
		context.drawImage(video, 0, 0, canvas.width, canvas.height);

		// Convertir la imagen a Data URL
		imagenDataUrl = canvas.toDataURL('image/jpeg');
		alertify.success('Foto capturada correctamente.');
	}

	// Alternar entre tomar foto y subir imagen
	function toggleFields() {
		const option1Field = document.getElementById('option1Field');
		const option2Field = document.getElementById('option2Field');
		const option1 = document.getElementById('option1');
		const option2 = document.getElementById('option2');

		if (option1.checked) {
			option1Field.style.display = 'block';
			option2Field.style.display = 'none';
			iniciarCamara(); // Iniciar la cámara si se selecciona "Tomar Foto"
		} else if (option2.checked) {
			option1Field.style.display = 'none';
			option2Field.style.display = 'block';
		}
	}

	// Enviar el formulario mediante AJAX
	$(document).ready(function() {
		$('#btn-guardar-rol').click(function() {
			const formData = new FormData($('#form-nuevo-Usuario')[0]);

			// Si se capturó una foto, agregarla al FormData
			if (imagenDataUrl) {
				const blob = dataURLtoBlob(imagenDataUrl);
				formData.append('foto', blob, 'foto.jpg');
			}

			// Enviar los datos al servidor
			$.ajax({

				type: "POST",
				url: "../../procesos/Limpieza/agregar.php",
				data: formData,
				processData: false,
				contentType: false,
				success: function(r) {
					if (r.trim() === "success") {
						$('#form-nuevo-Usuario')[0].reset(); // Limpiar el formulario
						$('#tabla_Datatable').load('tabla.php'); // Recargar la tabla
						alertify.success('Agregado con éxito');
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else {
						alertify.error("Hubo un error: " + r);
					}
				}
			});
		});
	});

	// Función para convertir Data URL a Blob
	function dataURLtoBlob(dataUrl) {
		const arr = dataUrl.split(',');
		const mime = arr[0].match(/:(.*?);/)[1];
		const bstr = atob(arr[1]);
		let n = bstr.length;
		const u8arr = new Uint8Array(n);
		while (n--) {
			u8arr[n] = bstr.charCodeAt(n);
		}
		return new Blob([u8arr], {
			type: mime
		});
	}
</script>