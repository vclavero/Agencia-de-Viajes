// logout.js
// Selecciono el botón de cierre de sesión y agrego un evento de clic
document.querySelector('.logout-button').addEventListener('click', function() {
    // Realizo la solicitud de cierre de sesión al servidor
    fetch('logout.php', {
        method: 'POST' // Utilizo el método POST para la solicitud
    })
    .then(response => {
        // Verifico si la respuesta del servidor es correcta
        if (response.ok) {
            window.location.href = 'login.php'; // Redirijo a login.php
        }
    })
    .catch(error => {
        // Manejo cualquier error que ocurra durante la solicitud
        console.error('Error al cerrar sesión:', error);
    });
});
