(function() {
    const ponentesInput = document.querySelector('#ponentes');

    if(ponentesInput) {
        let ponentes = []; // Array para almacenar los ponentes obtenidos de la API
        let ponentesFiltrados = []; // Array para almacenar los ponentes filtrados en la busqueda

        const listadoPonentes = document.querySelector("#listado-ponentes"); // Contenedor para que aparezcan los ponentes escritos
        const ponenteHidden = document.querySelector('[name="ponente_id"]'); // id del ponente seleccionado, usado para el backend

        // Obtener los ponentes de la API al cargar la pagina
        obtenerPonentes();

        // Evento para buscar ponentes mientras se escribe, se activa al escribir 4 o mas caracteres
        ponentesInput.addEventListener('input', buscarPonentes);

        // Si hay un ponente ya seleccionado (edicion de evento), obtener su informacion y mostrarla
        if(ponenteHidden.value) {
            (async() => {
                const ponente = await obtenerPonente(ponenteHidden.value);
                const {nombre, apellido} = ponente;

                // Insertar en el HTML
                const ponenteDOM = document.createElement('LI');
                ponenteDOM.classList.add('listado-ponentes__ponente', 'listado-ponentes__ponente--seleccionado');
                ponenteDOM.textContent = `${nombre} ${apellido}`;

                listadoPonentes.appendChild(ponenteDOM);
            })();
        }

        // Sirve para obtener los ponentes desde la API
        async function obtenerPonentes() {
            const url = `/api/ponentes`;

            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            formatearPonentes(resultado);
        }

        // Sirve para obtener un ponente en especifico desde la API
        async function obtenerPonente(id) {
            const url = `/api/ponente?id=${id}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            return resultado;
        }

        // Despues de obtener los ponentes, formatearlos para solo obtener lo necesario
        function formatearPonentes(arrayPonentes = []) {
            ponentes = arrayPonentes.map( ponente => {
                return {
                    nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                    id: `${ponente.id}`
                }
            })
        }

        // Filtrar los ponentes en base a la busqueda del usuario
        function buscarPonentes(e) {
            const busqueda = e.target.value;

            // Si la busqueda es mayor a 3 caracteres, filtrar
            if(busqueda.length > 3) {
                 const expresion = new RegExp(busqueda, 'i');
                 // Devuelve los ponentes que coincidan con la busqueda
                 ponentesFiltrados = ponentes.filter(ponente => {
                    if(ponente.nombre.toLowerCase().search(expresion) != -1) {
                        return ponente;
                    }
                 })

                 mostrarPonentes();
            } else {
                ponentesFiltrados = [];
            }
        }

        // Mostrar los ponentes filtrados en el HTML
        function mostrarPonentes() {

            // Limpiar el HTML previo cada vez que se realiza una busqueda (al pulsar una tecla)
            while(listadoPonentes.firstChild) {
                listadoPonentes.removeChild(listadoPonentes.firstChild);
            }

            // Si hay ponentes que mostrar, mostrarlos, si no, mostrar un mensaje de no resultados
            if(ponentesFiltrados.length > 0) {
                ponentesFiltrados.forEach(ponente => {
                    const ponenteHTML = document.createElement('LI');
                    ponenteHTML.classList.add('listado-ponentes__ponente');
                    ponenteHTML.textContent = ponente.nombre;
                    ponenteHTML.dataset.ponenteId = ponente.id;
                    ponenteHTML.onclick = seleccionarPonente;

                    // Añadir al DOM
                    listadoPonentes.appendChild(ponenteHTML);
                })
            } else {
                const noResultados = document.createElement('P');
                noResultados.classList.add('listado-ponentes__no-resultado');
                noResultados.textContent = 'No hay Resultados para tu Busqueda';

                listadoPonentes.appendChild(noResultados);
            }
        }

        // Seleccionar un ponente de la lista y agregar su ID al campo oculto para enviarlo al backend
        function seleccionarPonente(e) {
            const ponente = e.target;

            // Remover la clase Previa si la hay
            const ponenteAnterior = document.querySelector('.listado-ponentes__ponente--seleccionado');
            if(ponenteAnterior) {
                ponenteAnterior.classList.remove('listado-ponentes__ponente--seleccionado');
            }
            
            // Añadir clase Actual
            ponente.classList.add('listado-ponentes__ponente--seleccionado')

            // Asignar el ID del ponente seleccionado al input hidden para enviarlo al backend al presionar en submit
            ponenteHidden.value = ponente.dataset.ponenteId;
        }
    }
})();