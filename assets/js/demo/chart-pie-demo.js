// Configuración global de Chart.js
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Obtener el contexto del canvas
var ctx = document.getElementById("myPieChart");

// Función para cargar los datos y actualizar el gráfico
function cargarDatosYActualizarGrafico() {
    fetch('../../procesos/Graficos/pie_obtener_datos.php') // Solicitud al archivo PHP
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => {
            // Actualizar el gráfico con los datos obtenidos
            actualizarGrafico(data.ayer, data.hoy);
        })
        .catch(error => {
            console.error("Error al obtener los datos: ", error);
        });
}

// Función para actualizar el gráfico
function actualizarGrafico(conteoAyer, conteoHoy) {
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Ayer", "Hoy"],
            datasets: [{
                data: [conteoAyer, conteoHoy], // Datos dinámicos
                backgroundColor: ['#4e73df', '#1cc88a'],
                hoverBackgroundColor: ['#2e59d9', '#17a673'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: true,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
}

// Cargar los datos y actualizar el gráfico al cargar la página
document.addEventListener("DOMContentLoaded", function () {
    cargarDatosYActualizarGrafico();
});