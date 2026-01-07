<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="bloques">
    <div class="bloques__grid">
        <div class="bloque">
            <h3 class="bloque__heading">Último Registros</h3>

            <?php foreach($registros as $registro) { ?>
                <div class="bloque__contenido">
                    <p class="bloque__texto">
                        <?php echo $registro->usuario->nombre . " " . $registro->usuario->apellido; ?>
                    </p>
                </div>
            <?php } ?>
        </div>

        <div class="bloque">
            <h3 class="bloque__heading">Ingresos</h3>

            <p class="bloque__texto--cantidad">
                <?php echo $ingresos; ?>€
            </p>
        </div>

        <div class="bloque">
            <h3 class="bloque__heading">Eventos con Menos Lugares Disponibles</h3>

            <?php foreach($menos_disponibles as $evento) { ?>
                <p><?php echo $evento->nombre . " - "?><span class="bloque__texto--disponibles"><?php echo $evento->disponibles . " Disponibles"; ?></span></p>
            <?php } ?>
        </div>
        <div class="bloque">
            <h3 class="bloque__heading">Eventos con Mas Lugares Disponibles</h3>

            <?php foreach($mas_disponibles as $evento) { ?>
                <p><?php echo $evento->nombre . " - "?><span class="bloque__texto--disponibles"><?php echo $evento->disponibles . " Disponibles"; ?></span></p>
            <?php } ?>
        </div>
    </div>
</div>