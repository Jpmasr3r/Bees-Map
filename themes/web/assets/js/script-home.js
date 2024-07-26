const map = L.map('interativeMap');
let currentLocate = [0,0];

function setCurrentLocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(getCurrentPosition);
    } else {
        alert("Geolocalização não é suportada pelo seu navegador.");
        currentLocate = [0,0];
    }
}

function getCurrentPosition(position) {
    const latitude = position.coords.latitude;
    const longitude = position.coords.longitude;
    currentLocate = [latitude,longitude];
    map.setView(currentLocate, 13)
}

setCurrentLocate();

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
}).addTo(map);

let AllBees = [
    {
        name: "boxArea1 exemple",
        x: 0,
        y: 0 
    }
];
