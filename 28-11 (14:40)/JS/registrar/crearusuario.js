// Esta función cambia la visibilidad de dos elementos en la página web dependiendo del tipo de usuario proporcionado como parámetro.
function mostrarDiv(tipoUsuario) {
    // Si el tipo de usuario es 'empresa'
    if (tipoUsuario === 'empresa') {
        // Mostrar el elemento con id 'empresa'
        document.getElementById('empresa').style.display = 'block';
        // Ocultar el elemento con id 'alumno'
        document.getElementById('alumno').style.display = 'none';
    } 
    // Si el tipo de usuario es 'alumno'
    else if (tipoUsuario === 'alumno') {
        // Ocultar el elemento con id 'empresa'
        document.getElementById('empresa').style.display = 'none';
        // Mostrar el elemento con id 'alumno'
        document.getElementById('alumno').style.display = 'block';
    }
}

