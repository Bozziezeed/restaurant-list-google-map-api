const test = {
    html_attributions: [],
    results: [
        {
            formatted_address: "Bang Sue, Bangkok, Thailand",
            geometry: {
                location: { lat: 13.828253, lng: 100.5284507 },
                viewport: {
                    northeast: { lat: 13.8496853, lng: 100.5449568 },
                    southwest: { lat: 13.7972891, lng: 100.5063032 },
                },
            },
            icon: "https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/geocode-71.png",
            icon_background_color: "#7B9EB0",
            icon_mask_base_uri:
                "https://maps.gstatic.com/mapfiles/place_api/icons/v2/generic_pinlet",
            name: "Bang Sue",
            photos: [
                {
                    height: 4624,
                    html_attributions: [
                        '<a href="https://maps.google.com/maps/contrib/115105451359637844345">Desirezoflife CNK</a>',
                    ],
                    photo_reference:
                        "AUacShjXHvRpoNa-octZZjtXrWcP77YjyDh4jDt0gL9Ofxbiajhgn6oBWu7xQH3-tQp_4Cm667MflR_2Bg-WWWPa0MEXh8xH-uCy_RAvQ6P3TiPAD0iSRK-MchcSZ8WiBS6-pMW2J3s2_aHetcg7kQvPTVwEY2VeHIh7yquKOdLQbkEdX8j-",
                    width: 3468,
                },
            ],
            place_id: "ChIJX5dpCoGb4jARUE_iXbIAAQM",
            reference: "ChIJX5dpCoGb4jARUE_iXbIAAQM",
            types: ["sublocality_level_1", "sublocality", "political"],
        },
    ],
    status: "OK",
};

const url =
    "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?fields=formatted_address%2Cname%2Crating%2Copening_hours%2Cgeometry&input=Bang+sue&inputtype=textquery&key=AIzaSyAZsiycY06HRsuyHpAkMnZxFzTk3lk-X0c";

const cam =
    "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?fields=formatted_address%252Cname%252Crating%252Copening_hours%252Cgeometry&input=Bang+sue&inputtype=textquery&key=AIzaSyAZsiycY06HRsuyHpAkMnZxFzTk3lk-X0c";
