setTimeout(function() {
    var mensajeExito = document.getElementById('mensaje-exito');
    if (mensajeExito) {
        mensajeExito.style.display = 'none';
    }
}, 5000); // 5000 milisegundos = 5 segundos


function limpiarCampoBusqueda() {
    document.getElementById('search').value = ''; // Establecer el valor del campo de búsqueda como una cadena vacía
    document.getElementById('searchForm').submit(); // Enviar el formulario después de limpiar el campo de búsqueda
}
