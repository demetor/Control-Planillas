document.querySelectorAll('.eliminar').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        if (!id) {
            alert('No se pudo obtener el ID del rol.');
            return;
        }

        if (confirm('¿Estás seguro de que deseas eliminar este rol?')) {
            // Hacer la solicitud fetch
            fetch('/Control_de_planilla/public/index.php?controller=rol&action=eliminar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json(); // Convertir la respuesta a JSON
                })
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        // Elimina la fila del rol de la tabla
                        const row = this.closest('tr');
                        if (row) {
                            row.remove();
                        }
                    } else {
                        alert(data.message || 'No se pudo eliminar el rol.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al intentar eliminar el rol.');
                });
        }
    });
});
