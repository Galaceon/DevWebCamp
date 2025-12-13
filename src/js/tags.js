(function() {
    const tagsInput = document.querySelector('#tags_input');

    if(tagsInput) {

        const tagsDiv = document.querySelector('#tags');

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
                
        }
    }
})()

