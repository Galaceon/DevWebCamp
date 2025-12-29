if(document.querySelector('#mapa')) {
    const lat = 51.758940;
    const lng = -1.213139;
    const zoom = 16;

    const map = L.map('mapa').setView([lat, lng], zoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup(`
            <h2 class="mapa__heading">DevWebCamp</h2>
            <p class="mapa__texto">Centro de Convenciones de Madrid</p>
            `)
        .openPopup();
}