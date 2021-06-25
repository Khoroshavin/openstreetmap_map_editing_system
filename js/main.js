// Where you want to render the map.
var element = document.getElementById('mapid');

// Create Leaflet map on map element.
var map = L.map(element);

// Add OSM tile leayer to the Leaflet map.
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Target's GPS coordinates.
var target = L.latLng('49.2698', '15.4784');

// Set map's center to target with zoom 14.
map.setView(target, 16);

/** Class representing a geoJSON feature */
class geoJSONFeature {
    /**
     * Create a new geoJSON feature
     * @param {String} type Feature type(Point, Polygon)
     * @param {Array} latlng Feature lattitude and longitude
     * @param {String} title Feature HTML title
     * @param {String} description Feature HTML description
     * @param {String} html Feature raw HTML
     * @param {Number} id Feature id
     */
    constructor(type, latlng, title, description, html, id) {
        // Capitalize first letter
        this.type = type[0].toUpperCase() + type.slice(1).toLowerCase();

        return {
            type: 'Feature',
            properties: {
                popupContent: title,
                description: description,
                html: html,
                id: id
            },
            geometry: {
                type: this.type,
                coordinates: latlng
            }
        };
    }
}

// Create empty features layer to save data
const features = L.geoJSON(null, {
    onEachFeature: onEachFeature, // method for looping through all objects in layer
    weight: 1 
}).addTo(map);

/**
 * Separate title from content
 * @param {String} html html column from db
 * @returns {Object} title, description
 */
function getContent(html) {
    let content = {
        title: 'Žádný název',
        description: 'Nebyl uveden žádný popis'
    };

    try {
        // Check if title exists
        const markerContent = html
            .split(new RegExp('<h[1-6]+>'))[1]
            .split(new RegExp('</h[1-6]+>'));

        // Title exists so we save it
        content.title = markerContent[0];

        // Check if body exists
        if (markerContent[1].length > 0) {
            let markerDescription = markerContent[1];

            // Edit img src
            if (markerDescription.includes('<img src="')) {
                // Check if image exists
                const descBeforeImg = markerDescription.split('<img src="')[0];
                const imgPath = markerDescription.split('<img src="')[1].split(/"(.+)/);
                const descAfterImg = imgPath[1];
                const newImgPath = imgPath[0].split('../')[2];
                markerDescription =
                    descBeforeImg + '<img src="../' + newImgPath + '"' + descAfterImg;
                    markerDescription = markerDescription.replaceAll('../vendor/tiny/images/', 'vendor/tiny/images/'); 
            }

            content.description = markerDescription;
        } else {
            content.description = 'Nebyl uveden žádný popis';
        }
    } catch (error) {
        // Title doesn't exists
        content.title = 'Žádný název';

        // Now let's check if body exists
        if (html) {
            if (html.length <= 0) {
                content.description = 'Nebyl uveden žádný popis';
            } else {
                // Edit img src
                if (html.includes('<img src="')) {
                    // Check if image exists
                    const descBeforeImg = html.split('<img src="')[0];
                    const imgPath = html.split('<img src="')[1].split(/"(.+)/);
                    const descAfterImg = imgPath[1];
                    const newImgPath = imgPath[0].split('../')[2];
                    content.description =
                        descBeforeImg + '<img src="../' + newImgPath + '"' + descAfterImg;
                }
            }
        }
        
    }

    return content;
}

/**
 * Get different latlng depending on marker type
 * @param {String} markerType Marker type
 * @param {JSON} rawLatlng Marker raw latlng
 * @returns {Array} latlng
 */
function getLatlng(markerType, rawLatlng) {
    switch (markerType) {
        case 'Point':
            return [rawLatlng.lng, rawLatlng.lat];
        case 'Polygon':
            const newLatlng = rawLatlng[0].map(latlng => {
                return [latlng.lng, latlng.lat];
            });
            return [newLatlng];
    }
}

// Loop through features layer
function onEachFeature(feature, layer) {
    if (feature.properties.popupContent.length > 0) {
        layer.bindPopup(feature.properties.popupContent);
    }

    layer.on('mouseover', e => {
        e.target.openPopup();
    });

    layer.on('click', e => {
        $('#modalBody').html(feature.properties.html);
        $('#markerInfoModal').modal('toggle');
    });
}

// Get all markers, save them to features layer and display them on a map
$(document).ready(() => {
    $.get('redaktor/getAllMarkers.php', (data, status) => {
        const markers = JSON.parse(data);

        markers.forEach(marker => {
            // creating variables
            const rawLatlng = JSON.parse(marker.latlng);
            const type = marker.type;
            const latlng = getLatlng(type, rawLatlng);
            const markerTitle = getContent(marker.html).title;
            let markerDescription = getContent(marker.html).description;
            // recycling html and adding to geoJSONFeature 
            if (marker.html) {
                let html = marker.html.replaceAll('../vendor/tiny/images/', 'vendor/tiny/images/');
                const newMarker = new geoJSONFeature(
                    type,
                    latlng,
                    markerTitle,
                    markerDescription,
                    html,
                    marker.id
                );
    
                // Add new marker to geoJSON features layer
                features.addData(newMarker);
            }
            
        });
    });
});
