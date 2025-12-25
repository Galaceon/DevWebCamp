<main class="agenda">
    <h2 class="agenda__heading">Workshops & Conferencias</h2>
    <p class="agenda__descripcion">Talleres y Conferencias dictados por expertos en desarrollo web</p>

    <!-- CONFERENCIAS -->
    <div class="eventos">
        <h3 class="eventos__heading">&lt;Conferencias /></h3>

        <p class="eventos__fecha">Viernes 26 de Diciembre</p>
        <div class="eventos__listado">
            <?php foreach($eventos['conferencias_v'] as $evento) { ?>
                <div class="evento">

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
            <?php } ?>
        </div>

        <p class="eventos__fecha">Sabado 27 de Diciembre</p>
        <div class="eventos__listado">
            
        </div>

        <p class="eventos__fecha">Domingo 28 de Diciembre</p>
        <div class="eventos__listado">
            
        </div>
    </div>

    <!-- WORKSHOPS -->
    <div class="eventos eventos--workshops">
        <h3 class="eventos__heading">&lt;Workshops /></h3>
        
        <p class="eventos__fecha">Viernes 26 de Diciembre</p>
        <div class="eventos__listado">

        </div>

        <p class="eventos__fecha">Sabado 27 de Diciembre</p>
        <div class="eventos__listado">
            
        </div>

        <p class="eventos__fecha">Domingo 28 de Diciembre</p>
        <div class="eventos__listado">
            
        </div>
    </div>
</main>