/*setTimeout(function() {
    window.location.href = base_url + "Rutas/salir"; // Cambia esto a la ruta correcta
}, 600000);*/

var tiempoInactividad = 5 * 60 * 1000; // 10 minutos en milisegundos
var timeout;

/* function cerrarSesion() {
    // Coloca aquí el código para redirigir o cerrar la sesión
    window.location.href = base_url + "Rutas/salir"; // Cambia esto a la ruta correcta
}

function iniciarTemporizador() {
    timeout = setTimeout(cerrarSesion, tiempoInactividad);
}

function reiniciarTemporizador() {
    clearTimeout(timeout);
    iniciarTemporizador();
}

document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        // La aplicación se minimizó, inicia el temporizador
        iniciarTemporizador();
    } else {
        // La aplicación volvió a estar visible, reinicia el temporizador
        reiniciarTemporizador();
    }
});

// Inicia el temporizador al cargar la página
iniciarTemporizador();*/
