<main class="registro">
    <h2 class="registro__heading"><?php echo $titulo; ?></h2>
    <p class="registro__descripcion">Elige tu plan</p>

    <div class="paquetes__grid">
        <div data-aos="fade-down" data-aos-delay="100" class="paquete">
            <h3 class="paquete__nombre">Pase Gratis</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
            </ul>
            <ul class="paquete__precio">0€</ul>

            <form method="POST" action="/finalizar-registro/gratis">
                <input class="paquetes__submit" type="submit" value="Inscripción Gratis">
            </form>
        </div>

        <div data-aos="fade-down" data-aos-delay="350" class="paquetes__especial">
            <div class="paquetes__header">
                <p>Más Vendido</p>
            </div>
            <div class="paquete">
                <h3 class="paquete__nombre">Pase Presencial</h3>
                <ul class="paquete__lista">
                    <li class="paquete__elemento">Acceso Presencial a DevWebCamp</li>
                    <li class="paquete__elemento">Pase por 2 días</li>
                    <li class="paquete__elemento">Acceso a Tayeres y Conferencias</li>
                    <li class="paquete__elemento">Acceso a grabaciones </li>
                    <li class="paquete__elemento">Camisa del evento</li>
                    <li class="paquete__elemento">Comida y Bebida</li>
                </ul>
                <ul class="paquete__precio">199€</ul>
            </div>
        </div>

        <div data-aos="fade-down" data-aos-delay="200" class="paquete">
            <h3 class="paquete__nombre">Pase Virtual</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
                <li class="paquete__elemento">Pase por 2 días</li>
                <li class="paquete__elemento">Enlace a Talleres y Conferencias</li>
                <li class="paquete__elemento">Acceso a grabaciones</li>

            </ul>
            <ul class="paquete__precio">49€</ul>
        </div>
    </div>
</main>