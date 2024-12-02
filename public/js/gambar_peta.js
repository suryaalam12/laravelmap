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
        console.log("Sending polygon data:", polygon); // Log the polygon data being sent

        $.ajax({
            url: "/peta?action=join", // POST route
            data: JSON.stringify(polygon), // GeoJSON string, ensure it's properly serialized
            type: "POST",
            contentType: "application/json", // Specify JSON content type
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // Include CSRF token
            },
            success: function (response) {
                console.log("Success response:", response); // Log successful response
                resolve(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                console.log("XHR Status:", xhr.status); // Check the HTTP status code
                console.log("Response Text:", xhr.responseText); // Check the response text from the server
                console.log("XHR Object:", xhr); // View the entire XHR object
                reject(error);
            },
        });
    });
}
