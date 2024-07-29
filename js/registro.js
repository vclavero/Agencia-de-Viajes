// Función para mostrar el modal de hoteles
function mostrarModalHotel() {
    var modal = document.getElementById("hotelModal");
    modal.style.display = "block"; // Muestro el modal cambiando su estilo de display a "block"
}

// Función para cerrar el modal
function cerrarModal() {
    var modal = document.getElementById("hotelModal");
    modal.style.display = "none"; // Cierro el modal cambiando su estilo de display a "none"
}

// Cierro el modal cuando el usuario haga clic fuera de él
window.onclick = function(event) {
    var modal = document.getElementById("hotelModal");
    if (event.target == modal) {
        modal.style.display = "none"; // Cierro el modal si se hace clic fuera de él
    }
}

// Variables para almacenar el vuelo seleccionado y su fecha
let vueloSeleccionado = null;
let fechaVueloSeleccionada = null;

// Función para seleccionar un vuelo y mostrar el modal de hoteles
function seleccionarVuelo(idVuelo, fechaVuelo) {
    vueloSeleccionado = idVuelo; // Guardo el ID del vuelo seleccionado
    fechaVueloSeleccionada = fechaVuelo; // Guardo la fecha del vuelo seleccionado
    mostrarModalHotel(); // Llamo a la función para mostrar el modal de hoteles
}

// Función para reservar un hotel
function reservarHotel(idHotel) {
    document.getElementById('id_vuelo').value = vueloSeleccionado; // Asigno el ID del vuelo al campo oculto del formulario
    document.getElementById('fecha_vuelo').value = fechaVueloSeleccionada; // Asigno la fecha del vuelo al campo oculto del formulario
    document.getElementById('id_hotel').value = idHotel; // Asigno el ID del hotel al campo oculto del formulario
    document.getElementById('reservaForm').submit(); // Envío el formulario de reserva
}

// Función para abrir el modal de reservas
function abrirReservaModal() {
    var modal = document.getElementById("reservaModal");
    modal.style.display = "block"; // Muestro el modal de reservas
    cargarReservas(); // Llamo a la función para cargar las reservas
}

// Función para cerrar el modal de reservas
function cerrarReservaModal() {
    var modal = document.getElementById("reservaModal");
    modal.style.display = "none"; // Cierro el modal de reservas
}

// Función para cargar las reservas desde el servidor
function cargarReservas() {
    // Realizo una solicitud AJAX para obtener los datos de la tabla RESERVA
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "obtener_reservas.php", true); // Configuro la solicitud AJAX
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var reservas = JSON.parse(xhr.responseText); // Parseo la respuesta JSON
            var tbody = document.getElementById("reservaTable").getElementsByTagName("tbody")[0];
            tbody.innerHTML = ""; // Limpio el contenido actual del tbody

            // Itero sobre las reservas y las agrego a la tabla
            reservas.forEach(function(reserva) {
                var row = tbody.insertRow();
                row.insertCell(0).innerText = reserva.id_reserva;
                row.insertCell(1).innerText = reserva.id_cliente;
                row.insertCell(2).innerText = reserva.fecha_reserva;
                row.insertCell(3).innerText = reserva.id_vuelo;
                row.insertCell(4).innerText = reserva.id_hotel;
            });
        }
    };
    xhr.send(); // Envío la solicitud AJAX
}

// Función para abrir el modal de hoteles (duplicada)
function abrirHotelModal() {
    var modal = document.getElementById("hotelModal");
    modal.style.display = "block"; // Muestro el modal de hoteles
}

// Función para cerrar el modal de hoteles (duplicada)
function cerrarHotelModal() {
    var modal = document.getElementById("hotelModal");
    modal.style.display = "none"; // Cierro el modal de hoteles
}

// Cerrar el modal de hoteles cuando el usuario haga clic fuera de él (duplicada)
window.onclick = function(event) {
    var modal = document.getElementById("hotelModal");
    if (event.target == modal) {
        modal.style.display = "none"; // Cierro el modal si se hace clic fuera de él
    }
}

// Función para seleccionar un vuelo y abrir el modal de hoteles (duplicada)
function seleccionarVuelo(idVuelo, fechaVuelo) {
    document.getElementById("id_vuelo").value = idVuelo; // Asigno el ID del vuelo al campo oculto del formulario
    document.getElementById("fecha_vuelo").value = fechaVuelo; // Asigno la fecha del vuelo al campo oculto del formulario
    abrirHotelModal(); // Llamo a la función para abrir el modal de hoteles
}

// Función para reservar un hotel (duplicada)
function reservarHotel(idHotel) {
    document.getElementById("id_hotel").value = idHotel; // Asigno el ID del hotel al campo oculto del formulario
    document.getElementById("reservaForm").submit(); // Envío el formulario de reserva
}
