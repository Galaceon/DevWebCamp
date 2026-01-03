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

                
              <div id="smart-button-container">
                  <div style="text-align: center;">
                      <div id="paypal-button-container"></div>
                  </div>
              </div>

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


<!-- Codigo funcionamiento de Paypal -->
<script src="https://www.paypal.com/sdk/js?client-id=AST0ZWaso5LaV3Giu08paS4jWECoVVbHsVhhjzwrDhVVZDy1Nh-rg5BA4CGz5M2LsYA1MHG9iu2cZ4Fz&enable-funding=venmo&currency=EUR" data-sdk-integration-source="button-factory"></script>

<script>
    function initPayPalButton() {
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'blue',
                layout: 'vertical',
                label: 'pay',
            },
    
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{"description":"1","amount":{"currency_code":"EUR","value":199}}]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
        
                    const datos = new FormData();
                    datos.append('paquete_id', orderData.purchase_units[0].description);
                    datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id);

                    fetch('/finalizar-registro/pagar', {
                        method: 'POST',
                        body: datos
                    })
                    .then(respuesta => respuesta.json())
                    .then(resultado => {
                        if(resultado.resultado) {
                            actions.redirect('http://localhost:3000/finalizar-registro/conferencias');
                        }
                    })
                    
                });
            },
    
            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container');
    }
    
    initPayPalButton();
</script>