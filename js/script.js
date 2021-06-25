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

//set geoman controls
map.pm.addControls({
    position: 'topleft',
    drawCircleMarker: false,
    drawPolyline: false,
    drawRectangle: false,
    drawCircle: false,
    cutPolygon: false,
    rotateMode: false,
});

//set geoman language
map.pm.setLang('cz');  

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
                    descBeforeImg + '<img src="../' + '"' + descAfterImg;
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
                        descBeforeImg + '<img src="../' + '"' + descAfterImg;
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
        tinymce.activeEditor.setContent(feature.properties.html);
        $('#markerId').val(feature.properties.id);
        $('#editMarkerModal').modal('toggle');
    });

    layer.on('pm:edit', function (e) {
        let latlng = layer._latlng || layer._latlngs;
        let str = '';

        if (latlng[0]) {
            latlng[0].forEach((item, i) => {
                str += `,${JSON.stringify(item)}`;
                latlng = layer._latlngs;
            });
            str = '[[' + str.slice(1, str.length) + ']]';
        } else {
            str += `,${JSON.stringify(latlng)}`;
            str = str.slice(1, str.length);
        }

        const data = {
            html: feature.properties.html,
            latlng: str,
            markerId: feature.properties.id
        };

        $.ajax({
            type: 'POST',
            url: 'updateMarker.php',
            data: data,
            dataType: 'json'
        })
    });

}

$('#tiny-form').on('submit', function (e) {
    e.preventDefault();

    const data = {
        html: tinyMCE.activeEditor.getContent(),
        markerId: $('#markerId').val()
    }

    $.ajax({
        type: 'POST',
        url: 'updateMarker.php',
        data: data,
        dataType: 'json'
    })

    $.ajax({
        type: 'GET',
        url: 'getAllMarkers.php',
        success: function (response) {
            const markers = JSON.parse(response);
            render(markers);
            $('#editUserAlertSuccessRedaktor').html('Úspěšně upraveno');
            $('#editUserAlertSuccessRedaktor').show('500').delay(5000).hide('500');
        }
    })
})

function render (markers) {
    features.clearLayers();
    markers.forEach(marker => {
        const rawLatlng = JSON.parse(marker.latlng);
        const type = marker.type;
        const latlng = getLatlng(type, rawLatlng);
        const markerTitle = getContent(marker.html).title;
        const markerDescription = getContent(marker.html).description;
        const newMarker = new geoJSONFeature(
            type,
            latlng,
            markerTitle,
            markerDescription,
            marker.html,
            marker.id
        );
        features.addData(newMarker);
    });
}

// Get all markers, save them to features layer and display them on a map
$(document).ready(() => {
    $.get('getAllMarkers.php', (data, status) => {
        const markers = JSON.parse(data);
        markers.forEach(marker => {
            const rawLatlng = JSON.parse(marker.latlng);
            const type = marker.type;
            const latlng = getLatlng(type, rawLatlng);
            const markerTitle = getContent(marker.html).title;
            const markerDescription = getContent(marker.html).description;

            const newMarker = new geoJSONFeature(
                type,
                latlng,
                markerTitle,
                markerDescription,
                marker.html,
                marker.id
            );
            // Add new marker to geoJSON features layer
            features.addData(newMarker);
        });
    });
});

map.on('pm:create', e => {
    // Save new object type and if it is 'Marker' then change it to 'Point'
    // GeoJSON requires 'Point' instead of 'Marker'
    const type = e.shape === 'Marker' ? 'Point' : e.shape;
    const latlng = e.layer._latlng || e.layer._latlngs;

    $.post(
        'saveMarker.php',
        {latlng: JSON.stringify(latlng), type},
        (data, status) => {
            const marker = JSON.parse(data);
            const rawLatlng = JSON.parse(marker.latlng);
            const type = marker.type;
            const latlng = getLatlng(type, rawLatlng);
            const markerTitle = getContent(marker.html).title;
            const markerDescription = getContent(marker.html).description;

            const newMarker = new geoJSONFeature(
                type,
                latlng,
                markerTitle,
                markerDescription,
                '',
                marker.id
            );

            // Add new marker to geoJSON features layer
            features.addData(newMarker);
        	let lmpi = [];
        	$('.leaflet-marker-pane img').each(function() {
        		lmpi[lmpi.length] = $(this);
        	});
        	//console.log(lmpi);
        	for(let i = lmpi.length - 1; i > 0; i -= 2) {
        		if(lmpi[i].attr('style') == lmpi[i - 1].attr('style')) {
        			lmpi[i - 1].remove();
        		}
        	}
        	let lopgp = [];
        	$('.leaflet-overlay-pane g path').each(function() {
        		lopgp[lopgp.length] = $(this);
        	});
			for(let i = lopgp.length - 1; i > 0; i -= 2) {
        		if(lopgp[i].attr('d') == lopgp[i - 1].attr('d')) {
        			lopgp[i - 1].remove();
        		}
        	}
        }
    );
});

map.on('pm:remove', e => {
    $('#editMarkerModal').modal('hide');
    console.log(e.layer.feature.properties.id);
    $.ajax({
        type: 'POST',
        url: 'removeMarker.php',
        data: 'id=' + e.layer.feature.properties.id
    });
});

/* --------------------------------- modals --------------------------------- */

// page admin add new user show modal addNewUserModal
$('#addNewUserModal').on('shown.bs.modal', function () {
    $('#addNewUserModal').trigger('focus')
})

// page editor edit marker
// $('#editMarkerModal').modal('show')

// page editor log out modal
$('#logoutModal').on('shown.bs.modal', function () {
    $('#logoutModal').trigger('focus')
})

/* ------------------------------- / modals --------------------------------- */

/* --------------------------------- tinymce -------------------------------- */
// init
tinymce.init({
    selector: '#mytextarea',
    plugins: 'advlist paste link autolink image hr lists charmap print preview autoresize',
    branding: false,
    paste_data_images: true,
    images_upload_credentials: true, //xz
    images_upload_base_path: '../vendor/tiny/',
    images_upload_url: '../vendor/tiny/upload.php',
    language: 'cs', // ceska lokalizace (cs)
    // включаем поле заголовка в диалоговом окне изображения
    image_title: true,
    // включаем автоматическую загрузку изображений, представленных BLOB-объектами или URI данных
    automatic_uploads: true,
    file_picker_types: 'image',
    // реализация выбора и вывода изображений
    file_picker_callback: function (cb, value, meta) {
        // создание input-а
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'images/*');

        // вешаем обработчик события
        input.onchange = function () {
        var file = this.files[0];
        // через FileReader отображаем наши изображения
        var reader = new FileReader();
        reader.onload = function () {
            var id = 'blobid' + (new Date()).getTime();
            var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
            var base64 = reader.result.split(',')[1];
            var blobInfo = blobCache.create(id, file, base64);
            blobCache.add(blobInfo);

            cb(blobInfo.blobUri(), { title: file.name });
        };
        reader.readAsDataURL(file);
        };

        input.click();
    },
});

/* ------------------------------- / tinymce -------------------------------- */