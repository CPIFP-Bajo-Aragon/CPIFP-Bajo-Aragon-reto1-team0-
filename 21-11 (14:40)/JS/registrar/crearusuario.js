function mostrarDiv(tipoUsuario) {
    if (tipoUsuario === 'empresa') {
        document.getElementById('empresa').style.display = 'block';
        document.getElementById('alumno').style.display = 'none';
    } else if (tipoUsuario === 'alumno') {
        document.getElementById('empresa').style.display = 'none';
        document.getElementById('alumno').style.display = 'block';
    }
}