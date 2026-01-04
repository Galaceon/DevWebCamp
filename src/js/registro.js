(function() {

    let eventos = [];
    const eventosBoton = document.querySelectorAll('.evento__agregar');
    eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento));

    function seleccionarEvento(e) {
        eventos = [...eventos, {
            id: e.target.dataset.id,
            titulo: e.target.parentElement.querySelector('.evento__nombre').textContent.trim()
        }]
        console.log(eventos);

        // Deshabilitar el Evento
        e.target.disabled = true;
    }

})();