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
        const coordinates = geoJson.geometry.coordinates; // Extract coordinates directly
        const polygonData = {
            coordinates: coordinates,
            type: "Polygon",
        };
        sendPolygon(polygonData); // Pass the correctly structured data
    }
});

function sendPolygon(polygonData) {
    return new Promise(function (resolve, reject) {
        console.log("Sending polygon data:", polygonData); // Log the structured polygon data

        $.ajax({
            url: "/peta?action=join", // POST route
            data: JSON.stringify(polygonData), // Convert structured data to JSON string
            type: "POST",
            contentType: "application/json", // Specify JSON content type
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // Include CSRF token
            },
            success: function (response) {
                var hasilJoin = JSON.parse(response); // Log successful response
                console.log(hasilJoin);
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
