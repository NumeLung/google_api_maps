// This example requires the Visualization library. Include the libraries=visualization
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=visualization">
let map, heatmap;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 8,
        center: { lat: 42.64974350797618, lng: 25.27445741273419},
        mapTypeId: "satellite",
    });

    // Fetch JSON data from script.php using AJAX
    fetch('script.php')
        .then(function(response) {
            return response.json()
        })
        .then(data => {
            // Process the JSON data and add LatLng objects to the heatmap

            const heatmapData = [];
            Object.keys(data).forEach(key => {
                heatmapData.push(new google.maps.LatLng(parseFloat(data[key].crash_lat), parseFloat(data[key].crash_lng)));
            })

            /*const heatmapData = data.map(item => {
                return new google.maps.LatLng(parseFloat(item.crash_lat), parseFloat(item.crash_lng));
            });*/

            heatmap = new google.maps.visualization.HeatmapLayer({
                data: heatmapData,
                map: map,
            });
        })
        .catch(error => {
            console.error('Error fetching JSON data:', error);
        });


    // Add event listeners for heatmap controls (toggle, change gradient, etc.)
    document
        .getElementById("toggle-heatmap")
        .addEventListener("click", toggleHeatmap);
    document
        .getElementById("change-gradient")
        .addEventListener("click", changeGradient);
    document
        .getElementById("change-opacity")
        .addEventListener("click", changeOpacity);
    document
        .getElementById("change-radius")
        .addEventListener("click", changeRadius);

}

function toggleHeatmap() {
    heatmap.setMap(heatmap.getMap() ? null : map);
}

function changeGradient() {
    const gradient = [
        "rgba(0, 255, 255, 0)",
        "rgba(0, 255, 255, 1)",
        "rgba(0, 191, 255, 1)",
        "rgba(0, 127, 255, 1)",
        "rgba(0, 63, 255, 1)",
        "rgba(0, 0, 255, 1)",
        "rgba(0, 0, 223, 1)",
        "rgba(0, 0, 191, 1)",
        "rgba(0, 0, 159, 1)",
        "rgba(0, 0, 127, 1)",
        "rgba(63, 0, 91, 1)",
        "rgba(127, 0, 63, 1)",
        "rgba(191, 0, 31, 1)",
        "rgba(255, 0, 0, 1)",
    ];

    heatmap.set("gradient", heatmap.get("gradient") ? null : gradient);
}

function changeRadius() {
    heatmap.set("radius", heatmap.get("radius") ? null : 20);
}

function changeOpacity() {
    heatmap.set("opacity", heatmap.get("opacity") ? null : 0.2);
}

window.initMap = initMap;