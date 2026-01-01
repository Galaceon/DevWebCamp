(function() {
    const horas = document.querySelector("#horas");

    if(horas) {

        const categoria = document.querySelector('[name="categoria_id"]'); // Workshop o Conferencia
        const dias = document.querySelectorAll('[name="dia"]'); // Dias disponibles (viernes, sabado, domingo)
        const inputHiddenDia = document.querySelector('[name="dia_id"]'); // Input oculto para enviar el dia seleccionado al backend
        const inputHiddenHora = document.querySelector('[name="hora_id"]'); // Input oculto para enviar la hora seleccionada al backend

        categoria.addEventListener('change', terminoBusqueda); // Escuchar el cambio del input categoria
        dias.forEach( dia => dia.addEventListener('change', terminoBusqueda)); // Escuchar el cambio del input dia

        // Objeto de busqueda para la consulta a la API
        let busqueda = {
            categoria_id: +categoria.value || '',
            dia: inputHiddenDia.value || ''
        }

        // Si ambos campos ya estan llenos al cargar la pagina, realizar la busqueda
        if(!Object.values(busqueda).includes('')) {
            (async () => {
                await buscarEventos();

                // El input hidden ya tiene la hora seleccionada por el backend
                const id = inputHiddenHora.value;

                // Resaltar la Hora actual
                const horaSeleccionada = document.querySelector(`[data-hora-id="${id}"]`);

                horaSeleccionada.classList.remove('horas__hora--deshabilitada');
                horaSeleccionada.classList.add('horas__hora--seleccionada');

                // Agregar el evento de seleccionar hora a la hora seleccionada
                horaSeleccionada.onclick = seleccionarHora;
            })();

        }

        // Buscar eventos en base a la busqueda del usuario
        function terminoBusqueda(e) {
            // Llenar el objeto de busqueda (categoria_id y dia) para la consulta
            busqueda[e.target.name] = e.target.value;

            // Reiniciar los campos ocultos y el selector de horas
            inputHiddenHora.value = '';
            inputHiddenDia.value = '';
            
            // Deshabilitar la hora previa si hay un nuevo click
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if(horaPrevia) {
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }

            // Si hay algun campo vacio, no realizar la busqueda
            if(Object.values(busqueda).includes('')) {
                return;
            }

            // Campos llenos, realizar la busqueda
            buscarEventos()
        }

        async function buscarEventos() {
            // Buscar los eventos en la API en base a la busqueda del usuario
            const { dia, categoria_id } = busqueda;

            const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`;

            const resultado = await fetch(url);
            const eventos = await resultado.json();

            // Obtener las horas disponibles y deshabilitar las que ya esten tomadas
            obtenerHorasDisponibles(eventos);
        }

        function obtenerHorasDisponibles(eventos) {
            // Reiniciar las horas
            const listadoHoras = document.querySelectorAll('#horas li');
            listadoHoras.forEach(li => li.classList.add('horas__hora--deshabilitada'))

            // Comprobar eventos ya tomados y quitar la variable de deshabilitado
            const horasTomadas = eventos.map(evento => evento.hora_id);

            //  Convertir el NodeList a un Array para poder usar .filter
            const listadoHorasArray = Array.from(listadoHoras);

            // Filtrar las horas que no esten en el arreglo de horas tomadas
            const resultado = listadoHorasArray.filter( li => !horasTomadas.includes(li.dataset.horaId));

            // Recorrer el resultado y habilitar las horas disponibles
            resultado.forEach( li => li.classList.remove('horas__hora--deshabilitada'));

            // Agregar el evento de seleccionar hora a las horas disponibles
            const horasDisponibles = document.querySelectorAll("#horas li:not(.horas__hora--deshabilitada)");
            horasDisponibles.forEach( hora => hora.addEventListener('click', seleccionarHora))
        }

        // Seleccionar una hora y agregarla al campo oculto para enviarla al backend
        function seleccionarHora(e) {

            // Deshabilitar la hora previa si hay un nuevo click
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if(horaPrevia) {
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }

            // Agregar clase de seleccionado
            e.target.classList.add('horas__hora--seleccionada');
            inputHiddenHora.value = e.target.dataset.horaId;

            // Llenar el campo oculto de dia
            inputHiddenDia.value = document.querySelector('[name="dia"]:checked').value
        }
    }
})();