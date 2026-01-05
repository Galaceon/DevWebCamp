import Swal from "sweetalert2";

(function() {

    const resumen = document.querySelector('#registro-resumen'); // Div para insertar los eventos registrados

    if(resumen) {

        let eventos = []; // Array de objetos con los eventos seleccionados
    
        const eventosBoton = document.querySelectorAll('.evento__agregar'); // Boton para agregar evento al div de registro
        eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento));

        const formularioRegistro = document.querySelector('#registro'); // Boton para enviar la info a traves de la API
        formularioRegistro.addEventListener('submit', submitFormulario);

        function seleccionarEvento(e) {

            if(eventos.length < 5) {
                // Deshabilitar el Evento presionado( para evitar evento duplicados )
                e.target.disabled = true;

                // Añadir el Evento presionado al array de eventos
                eventos = [...eventos, {
                    id: e.target.dataset.id,
                    titulo: e.target.parentElement.querySelector('.evento__nombre').textContent.trim()
                }]

                // Mostrar los Eventos presionados en el div de eventos registrados
                mostrarEventos();
            } else {
                Swal.fire({
                    title: 'Limite Alcanzado',
                    text: 'Maximo 5 eventos por registro',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'swal-grande',
                        confirmButton: 'btn-grande',
                    }
                })
            }
        }

        // Muestra los eventos que estan dentro del array de eventos
        function mostrarEventos() {
            // Limpiar el HTML para evitar eventos repetidos
            limpiarEventos();

            // Creamos el HTML de cada evento y lo imprimimos en el DOM
            if(eventos.length > 0) {
                eventos.forEach( evento => {
                    const eventoDOM = document.createElement('DIV');
                    eventoDOM.classList.add('registro__evento');

                    const titulo = document.createElement('H3');
                    titulo.classList.add('registro__nombre');
                    titulo.textContent = evento.titulo;

                    const botonEliminar = document.createElement('BUTTON');
                    botonEliminar.classList.add('registro__eliminar');
                    botonEliminar.innerHTML = `<i class="fa-solid fa-trash"></i>`;
                    botonEliminar.onclick = function() {
                        eliminarEvento(evento.id);
                    }

                    // Renderizar en el HTML
                    eventoDOM.appendChild(titulo);
                    eventoDOM.appendChild(botonEliminar);
                    resumen.appendChild(eventoDOM);
                })
            }
        }

        function eliminarEvento(id) {
            // Filtramos para que filtre todos los eventos menos el que queremos eliminar
            eventos = eventos.filter(evento => evento.id !== id);

            // Habilitar el boton de agregar del evento eliminado
            const botonAgregar = document.querySelector(`[data-id="${id}"]`);
            botonAgregar.disabled = false;

            // Volver a mostrar los eventos
            mostrarEventos();
        }

        // Limpia el HTML del div de resumen para evitar duplicados
        function limpiarEventos() {
            while(resumen.firstChild) {
                resumen.removeChild(resumen.firstChild);
            }
        }

        // Enviar la informacion del formulario a traves de la API
        function submitFormulario(e) {
            // Prevenir el comportamiento por defecto del formulario, que es recargar la pagina
            e.preventDefault();

            // Obtener el regalo, value del select
            const regaloId = document.querySelector('#regalo').value;

            // Sacar los id de cada evento presionado del array de objetos 'eventos'
            const eventosId = eventos.map(evento => evento.id);

            // Si no hay eventos seleccionados o no hay regalo seleccionado, mostrar error y return
            if(eventosId.length === 0 || regaloId === '') {
                Swal.fire({
                    title: 'Error',
                    text: 'Debes elegir al menos un Evento y un Regalo',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'swal-grande',
                        confirmButton: 'btn-grande',
                    }
                })
                return;
            }
            console.log('registrando...')
        }
    }

})();