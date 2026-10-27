// ESTADO GLOBAL
let currentUser = JSON.parse(localStorage.getItem('ecobarrio_lo_user')) || null;

let acopioList = JSON.parse(localStorage.getItem('ecobarrio_lo_acopio')) || [
    { id: 1, name: 'Punto Limpio Covida', sector: 'Covida - Av. Antúnez de Mayolo', type: 'Plásticos y PET', level: 85, status: 'Crítico' },
    { id: 2, name: 'EcoPunto Sol de Oro', sector: 'Sol de Oro - Ca. Los Alisos', type: 'Cartón y Papel', level: 45, status: 'Normal' },
    { id: 3, name: 'Contenedor Mercado Pro', sector: 'Pro - Av. Alfredo Mendiola', type: 'Vidrio y Orgánicos', level: 20, status: 'Óptimo' },
    { id: 4, name: 'Módulo Mercurio', sector: 'Mercurio - Av. Las Palmeras', type: 'Multiresiduos / RAEE', level: 90, status: 'Crítico' },
    { id: 5, name: 'Punto Verde Villa Sol', sector: 'Villa Sol - Av. Universitaria', type: 'Plásticos y PET', level: 35, status: 'Óptimo' }
];

let vecinosList = JSON.parse(localStorage.getItem('ecobarrio_lo_vecinos')) || [
    { id: 1, name: 'María Elena Gutiérrez', dni: '45123987', sector: 'Sol de Oro', badge: 'Líder Verde', points: 1250, avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100' },
    { id: 2, name: 'Jorge Carlos Quispe', dni: '10982345', sector: 'Covida', badge: 'Brigadista VIP', points: 1100, avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100' },
    { id: 3, name: 'Lucía Mendoza', dni: '72341098', sector: 'Mercurio', badge: 'EcoVecino', points: 980, avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100' },
    { id: 4, name: 'Carlos Ramos', dni: '09812344', sector: 'Pro', badge: 'EcoVecino', points: 870, avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100' },
    { id: 5, name: 'Beatriz Salazar', dni: '41209873', sector: 'Villa Sol', badge: 'EcoVecino', points: 740, avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100' },
    { id: 6, name: 'Gonzalo Fernández', dni: '43981276', sector: 'Covida', badge: 'EcoVecino', points: 620, avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100' }
];

function saveAcopioData() {
    localStorage.setItem('ecobarrio_lo_acopio', JSON.stringify(acopioList));
}

function saveVecinosData() {
    localStorage.setItem('ecobarrio_lo_vecinos', JSON.stringify(vecinosList));
}
