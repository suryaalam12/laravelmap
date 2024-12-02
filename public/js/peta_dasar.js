map = L.map("map").setView([51.505, -0.09], 13);
L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution:
        '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);
function fetchData(action) {
    window.location.href = `/peta?action=${action}`;
}

refreshLayerTampilan();
function refreshLayerTampilan() {
    return new Promise((resolve, reject) => {
        try {
            if (lyrZnt) {
                ctlLayers.removeLayer(lyrZnt);
                lyrZnt.remove();
            }
            lyrZnt = L.geoJSON(dataPeta).addTo(map);
            map.fitBounds(lyrZnt.getBounds(1).pad(0.01));
            resolve();
        } catch (error) {
            reject(error);
        }
    });
}
