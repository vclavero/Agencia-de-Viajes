document.addEventListener('DOMContentLoaded', () => {
    // Selecciono el contenedor deslizante
    const contenedorDeslizante = document.querySelector('.slide-out-container');
    // Selecciono el área de activación
    const areaActivacion = document.querySelector('.trigger-area');
    // Selecciono todos los botones que abren el contenedor deslizante
    const openSlideOutButtons = document.querySelectorAll('.open-slide-out');

    // Aseguro de que los elementos existen antes de añadir event listeners
    if (contenedorDeslizante && areaActivacion) {
        // Añado un event listener al área de activación para mostrar el contenedor deslizante
        areaActivacion.addEventListener('click', () => {
            contenedorDeslizante.classList.add('active');
        });

        // Añado event listeners a los botones para mostrar el contenedor deslizante
        openSlideOutButtons.forEach(button => {
            button.addEventListener('click', () => {
                contenedorDeslizante.classList.add('active');
            });
        });

        // Añado un event listener para ocultar el contenedor deslizante al hacer clic fuera de él
        document.addEventListener('click', (event) => {
            if (!contenedorDeslizante.contains(event.target) && !areaActivacion.contains(event.target) && !event.target.classList.contains('open-slide-out')) {
                contenedorDeslizante.classList.remove('active');
            }
        });
    }
});

// Creo un array para almacenar los items del carrito
let carrito = [];

// Función para agregar un item al carrito
function agregarAlCarrito(button) {
    // Obtengo el contenedor del item
    const container = button.parentElement;
    // Obtengo los detalles del item
    const destino = container.getAttribute('data-destino');
    const precio = container.getAttribute('data-precio');
    const fechaViaje = container.querySelector('input[type="date"]').value;
    const adultos = container.querySelector('select[id^="adultos"]').value;
    const menores = container.querySelector('select[id^="menores"]').value;
    const hotel = container.querySelector('select[id^="hoteles"]').value;
    
    // Creo un objeto con los detalles del item
    const item = { destino, precio, fechaViaje, adultos, menores, hotel };
    // Añado el item al carrito
    carrito.push(item);
    // Actualizo la visualización del carrito
    actualizarCarrito();
}

// Función para actualizar la visualización del carrito
function actualizarCarrito() {
    // Selecciono el contenedor del carrito
    const carritoContainer = document.getElementById('carrito');
    
    // Si el carrito está vacío, muestro un mensaje
    if (carrito.length === 0) {
        carritoContainer.innerHTML = '<p style="color: white;">Tu carrito está vacío.</p>';
        return;
    }
    
    // Limpio el contenido del contenedor del carrito
    carritoContainer.innerHTML = '';
    // Recorro los items del carrito y los muestro
    carrito.forEach((item, index) => {
        const itemElement = document.createElement('div');
        itemElement.style.color = 'white';
        itemElement.innerHTML = `
            <p><strong>Destino:</strong> ${item.destino}</p>
            <p><strong>Precio:</strong> $${item.precio}</p>
            <p><strong>Fecha de viaje:</strong> ${item.fechaViaje}</p>
            <p><strong>Adultos:</strong> ${item.adultos}</p>
            <p><strong>Menores:</strong> ${item.menores}</p>
            <p><strong>Hotel:</strong> ${item.hotel}</p>
            <button class="button_eliminar_compra" onclick="eliminarDelCarrito(${index})">Eliminar</button>
        `;
        carritoContainer.appendChild(itemElement);
    });
}

// Función para eliminar un item del carrito
function eliminarDelCarrito(index) {
    // Elimino el item del carrito
    carrito.splice(index, 1);
    // Actualizo la visualización del carrito
    actualizarCarrito();
}

// Función para finalizar la compra
function finalizarCompra() {
    // Si el carrito está vacío, muestro un mensaje y retorno
    if (carrito.length === 0) {
        alert('Tu carrito está vacío.');
        return;
    }
    
    // Creo un resumen de la compra
    let resumen = 'Resumen de tu compra:\n\n';
    carrito.forEach(item => {
        resumen += `Destino: ${item.destino}\nPrecio: $${item.precio}\nFecha de viaje: ${item.fechaViaje}\nAdultos: ${item.adultos}\nMenores: ${item.menores}\nHotel: ${item.hotel}\n\n`;
    });
    
    // Muestro el resumen en una alerta
    alert(resumen);
}

// Función para cerrar el carrito
function cerrarCarrito() {
    // Selecciono el contenedor deslizante y lo oculto
    const contenedorDeslizante = document.querySelector('.slide-out-container');
    contenedorDeslizante.classList.remove('active');
}
