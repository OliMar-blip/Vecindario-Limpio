function loginDemo(rol) {
    if (rol === 'admin') {
        localStorage.setItem('ecobarrio_lo_user', JSON.stringify({
            id: 0,
            name: 'Administrador Municipal',
            role: 'Admin General',
            email: 'admin@losolivos.gob.pe'
        }));
    } else if (rol === 'brigadista') {
        localStorage.setItem('ecobarrio_lo_user', JSON.stringify({
            id: 2,
            name: 'Jorge Quispe',
            role: 'Brigadista VIP',
            email: 'jorge.quispe@losolivos.gob.pe'
        }));
    } else {
        localStorage.setItem('ecobarrio_lo_user', JSON.stringify({
            id: 1,
            name: 'María Gutiérrez',
            role: 'EcoVecino Líder',
            email: 'maria.gutierrez@gmail.com'
        }));
    }
    
    window.location.href = "/dashboard";
}

function handleLogin(event) {
    event.preventDefault();
    // Simulación de login general por formulario
    localStorage.setItem('ecobarrio_lo_user', JSON.stringify({
        id: 1,
        name: 'Usuario General',
        role: 'EcoVecino',
        email: 'usuario@losolivos.gob.pe'
    }));
    window.location.href = "/dashboard";
}