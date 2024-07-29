document.addEventListener("DOMContentLoaded", function() {
    // Accedo al formulario por su ID para gestionar la validación
    const formulario = document.getElementById('formularioHotel');

    // Agrego un evento a la entrada de 'nombre' para convertirlo a mayúsculas automáticamente
    document.getElementById('nombre').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Hago lo mismo para el campo de 'ubicacion'
    document.getElementById('ubicacion').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Agrego un manejador de eventos al enviar el formulario para validar los datos numéricos
    formulario.addEventListener('submit', function(evento) {
        // Obtengo el valor de 'habitaciones_disponibles' y lo convierto a entero
        let habitaciones = parseInt(document.getElementById('habitaciones_disponibles').value);
        // Obtengo el valor de 'tarifa_noche' y lo convierto a flotante
        let tarifa = parseFloat(document.getElementById('tarifa_noche').value);

        // Verifico que el número de habitaciones esté dentro del rango permitido
        if (habitaciones < 1 || habitaciones > 100) {
            alert('El número de habitaciones disponibles debe estar entre 1 y 100.');
            evento.preventDefault(); // Evito que se envíe el formulario si no cumple la condición
        }

        // Verifico que la tarifa por noche esté dentro del rango permitido
        if (tarifa < 10000 || tarifa > 100000) {
            alert('La tarifa por noche debe estar entre $10,000 y $100,000.');
            evento.preventDefault(); // Evito que se envíe el formulario si no cumple la condición
        }
    });
});
