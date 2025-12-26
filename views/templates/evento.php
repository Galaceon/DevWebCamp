<div class="evento swiper-slide">

    <p class="evento__hora"><?php echo $evento->hora->hora; ?></p> <!-- Hora del Evento -->

    <div class="evento__informacion">
        <h4 class="evento__nombre"><?php echo $evento->nombre; ?></h4> <!-- Nombre del Evento -->

        <p class="evento__introduccion"><?php echo $evento->descripcion; ?></p> <!-- Descripción del Evento -->

        <div class="evento__autor-info">
            <picture>
                <source srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.webp" type="image/webp"> <!-- Imagenes del Ponente -->
                <source srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.png" type="image/png">
                <img  class="evento__autor-imagen" loading="lazy" width="200" height="300" src="img/speakers/<?php echo $evento->ponente->imagen; ?>.png" alt="Imagen evento">
            </picture>

            <p class="evento__autor-nombre">
                <?php echo $evento->ponente->nombre . " ". $evento->ponente->apellido; ?> <!-- Nombre del Ponente -->
            </p>
        </div>
    </div>
</div>