(function() {
    const boletos = document.querySelectorAll('.boleto');

    if(boletos) {

        boletos.forEach(boleto => {
            boleto.addEventListener('mousemove', (e) => {
                const rect = boleto.getBoundingClientRect();
                const x = e.clientX - rect.left; // posición X dentro del boleto
                const y = e.clientY - rect.top;  // posición Y dentro del boleto

                const centerX = rect.width / 3;
                const centerY = rect.height / 3;

                // Ajusta la intensidad del efecto
                const rotateX = ((y - centerY) / centerY) * -10; // -10 a 10 grados
                const rotateY = ((x - centerX) / centerX) * 10;

                boleto.style.setProperty('--rotateX', `${rotateX}deg`);
                boleto.style.setProperty('--rotateY', `${rotateY}deg`);
                boleto.classList.add('is-active');
            });

            boleto.addEventListener('mouseleave', () => {
                boleto.classList.remove('is-active');
                boleto.style.setProperty('--rotateX', '0deg');
                boleto.style.setProperty('--rotateY', '0deg');
            });

            boleto.addEventListener('mousemove', (e) => {
            // ... (rotación)
            const rect = boleto.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;

            boleto.style.setProperty('--shineX', `${x}%`);
            boleto.style.setProperty('--shineY', `${y}%`);
            });
        });
    }
})();