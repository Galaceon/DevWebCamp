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

                    <p class="evento__hora"><?php echo $evento->hora->hora; ?></p> <!-- Hora -->

                    <div class="evento__informacion">
                        <h4 class="evento__nombre"><?php echo $evento->nombre; ?></h4> <!-- Nombre del Evento -->

                        <div>
                            <p class="evento__informacion"><?php echo $evento->descripcion; ?></p>
                        </div>

                        <div class="evento__autor-info">
                            <picture>
                                <source srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.webp" type="image/webp">
                                <source srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.png" type="image/png">
                                <img src="img/speakers/<?php echo $evento->ponente->imagen; ?>.png" alt="Imagen evento">
                            </picture>

                            <p class="evento__autor--nombre">
                                <?php echo $evento->ponente->nombre . " ". $evento->ponente->apellido; ?>
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