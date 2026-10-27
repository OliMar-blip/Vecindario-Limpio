function handleLogin(event) {
    if (event) event.preventDefault();
    
    // Aquí puedes capturar los datos si los necesitas
    const email = document.getElementById('login-email')?.value;
    const password = document.getElementById('login-password')?.value;

    // Simulación de validación exitosa: Redirigimos a la ruta de Laravel
    window.location.href = "/dashboard";
}

function loginAdminConCodigo() {
    const codigo = prompt("🔒 Acceso Restringido para Administradores.\nIngrese el código de seguridad (Ej: 2026):");
    
    if (codigo === "2026") {
        alert("✅ Código correcto. Bienvenido Administrador.");
        window.location.href = "/dashboard"; 
    } else if (codigo !== null) {
        alert("❌ Código incorrecto. Acceso denegado.");
    }
}