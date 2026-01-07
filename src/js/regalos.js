(function() {
    
    const grafica = document.querySelector('#regalos-grafica');
    
    if(grafica) {
        obtenerDatos();
        async function obtenerDatos() {
            // Llamamos a la API para que nos de los datos necesarios sobre regalos
            const url = '/api/regalos';

            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            // Aplicamos los datos de nuestra API en la grafica de chartJS
            const ctx = document.getElementById('regalos-grafica');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: resultado.map(regalo => regalo.nombre),
                    datasets: [{
                        data: resultado.map(regalo => regalo.total),
                        backgroundColor: [
                            'rgba(234, 88, 12, .7)',
                            'rgba(132, 204, 22, .7)',
                            'rgba(34, 211, 238, .7)',
                            'rgba(168, 85, 247, .7)',
                            'rgba(239, 68, 68, .7)',
                            'rgba(20, 184, 166, .7)',
                            'rgba(219, 39, 119, .7)',
                            'rgba(225, 29, 72, .7)',
                            'rgba(126, 34, 206, .7)'
                        ]
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                    
                }
            });
        }
    }
})();