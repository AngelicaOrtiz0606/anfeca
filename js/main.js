/**
 * SIDEANFECA - JavaScript Principal
 * Sistema Integral de Directorios ANFECA
 */

// ============================================================
// TOGGLE SIDEBAR EN MÓVIL
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');

    if (menuToggle) {
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('open');
        });
    }

    // Cerrar sidebar al hacer clic fuera en móvil
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
});

// ============================================================
// RELOJ EN TIEMPO REAL (ESPAÑOL)
// ============================================================
function actualizarReloj() {
    const ahora = new Date();
    
    const opcionesFecha = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        timeZone: 'America/Mexico_City'
    };
    
    const opcionesHora = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true,
        timeZone: 'America/Mexico_City'
    };
    
    const fecha = ahora.toLocaleDateString('es-MX', opcionesFecha);
    const hora = ahora.toLocaleTimeString('es-MX', opcionesHora);
    
    const fechaCapitalizada = fecha.replace(/^\w/, (c) => c.toUpperCase());
    
    const relojElement = document.getElementById('fecha_hora');
    if (relojElement) {
        relojElement.textContent = fechaCapitalizada + ' - ' + hora + ' hrs (CDMX)';
    }
}

// Actualizar cada segundo
actualizarReloj();
setInterval(actualizarReloj, 1000);

// ============================================================
// LOGOUT - Confirmación
// ============================================================
function confirmarLogout() {
    if (confirm('¿Desea cerrar sesión?')) {
        alert('Sesión cerrada');
        // window.location.href = 'login.php';
    }
}