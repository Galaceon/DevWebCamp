(function() {
    const tagsInput = document.querySelector('#tags_input');

    if(tagsInput) {

        const tagsDiv = document.querySelector('#tags');
        const tagsInputHidden = document.querySelector('[name="tags"]');

        let tags = [];

        // Escuchar los cambios en el input
        tagsInput.addEventListener('keypress', guardarTag);

        function guardarTag(e) {
            if(e.keyCode === 44) {

                // Si hay escritos espacios el codigo no se ejecuta
                if(e.target.value.trim() === '' || e.target.value < 1) {
                    return;
                }

                // Cancelamos que el usuario escriba "," (esta seria la opcion default al ejecutarse este if)
                e.preventDefault()

                // Nuevo array tags para no mutar el anterior y añadimos el contenido nuevo
                tags = [...tags, e.target.value.trim()];

                // vaciamos el input type="text" para que este vacio en su uso posterior
                tagsInput.value = '';

                mostrarTags();
            }    
        }

        function mostrarTags() {
            tagsDiv.textContent = '';
            tags.forEach(tag => {
                const etiqueta = document.createElement('LI');
                etiqueta.classList.add('formulario__tag');
                etiqueta.textContent = tag;
                etiqueta.onclick = eliminarTag;

                tagsDiv.appendChild(etiqueta);
            })

            actualizarInputHidden();
        }

        function eliminarTag(e) {
            e.target.remove();
            tags = tags.filter(tag => tag !== e.target.textContent);
            actualizarInputHidden();
        }

        function actualizarInputHidden() {
            tagsInputHidden.value = tags.toString();
        }
    }
})()