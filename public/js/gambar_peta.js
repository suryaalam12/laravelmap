// define toolbar options
var options = {
    position: "topleft", // toolbar position, options are 'topleft', 'topright', 'bottomleft', 'bottomright'
    drawMarker: true, // adds button to draw markers
    drawPolyline: true, // adds button to draw a polyline
    drawRectangle: true, // adds button to draw a rectangle
    drawPolygon: true, // adds button to draw a polygon
    drawCircle: true, // adds button to draw a cricle
    cutPolygon: true, // adds button to cut a hole in a polygon
    editMode: true,
    removalMode: true,
};

var polygon;

map.pm.addControls(options);

map.on("pm:create", function (e) {
    if (e.shape === "Polygon") {
        const polygonLayer = e.layer;
        const geoJson = polygonLayer.toGeoJSON();
        polygon = JSON.stringify(geoJson);
        sendPolygon();
    }
});

function sendPolygon() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: "/peta?action=join", // POST route
            data: polygon, // GeoJSON string
            type: "POST",
            contentType: "application/json", // Specify JSON content type
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // Include CSRF token
            },
            success: function (response) {
                console.log(response); // Handle success
                resolve(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                reject(error);
            },
        });
    });
}
