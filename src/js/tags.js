(function() {
    const tagsInput = document.querySelector('#tags_input'); // Input donde se escriben los tags

    if(tagsInput) {

        const tagsDiv = document.querySelector('#tags'); // Div donde se muestran los tags añadidos
        const tagsInputHidden = document.querySelector('[name="tags"]'); // Input oculto para enviar los tags al backend

        let tags = []; // Array para almacenar los tags añadidos

        // Recuperar el input oculto si ya hay tags añadidos (edicion de evento)
        if(tagsInputHidden.value !== '') {
            tags = tagsInputHidden.value.split(',');
            mostrarTags();
        }

        // Escuchar los cambios en el input
        tagsInput.addEventListener('keypress', guardarTag);

        function guardarTag(e) {
            // Si el usuario presiona la coma (,) se guarda el tag
            if(e.keyCode === 44) {

                // Si hay escritos espacios el codigo no se ejecuta
                if(e.target.value.trim() === '' || e.target.value < 1) {
                    return;
                }

                // Cancelamos que el usuario escriba "," (esta seria la opcion default al ejecutarse este if)
                e.preventDefault()

                // Nuevo array tags para no mutar el anterior y añadimos el contenido nuevo
                tags = [...tags, e.target.value.trim()];

                // Vaciamos el input type="text" para que este vacio en su uso posterior
                tagsInput.value = '';

                // Al añadir un nuevo tag al array de tags, mostrar los tags actualizados
                mostrarTags();
            }
        }

        // Mostrar los tags en el HTML
        function mostrarTags() {
            tagsDiv.textContent = ''; // Limpiar el HTML previo si hay tags

            // Recorrer el array de tags y mostrarlos en el HTML
            tags.forEach(tag => {
                const etiqueta = document.createElement('LI');
                etiqueta.classList.add('formulario__tag');
                etiqueta.textContent = tag;
                etiqueta.onclick = eliminarTag;

                tagsDiv.appendChild(etiqueta);
            })

            // Actualizar el input hidden con los tags actuales
            actualizarInputHidden();
        }

        // Eliminar un tag al hacer click en el mismo
        function eliminarTag(e) {
            e.target.remove();
            // Filtrar el array de tags para eliminar el tag clickeado (filtar por el tag que no tenga el mismo texto)
            tags = tags.filter(tag => tag !== e.target.textContent);
            actualizarInputHidden();
        }

        function actualizarInputHidden() {
            // Convertir el array de tags a string separado por comas y asignarlo al input hidden para enviarlo al backend
            tagsInputHidden.value = tags.toString();
        }
    }
})();