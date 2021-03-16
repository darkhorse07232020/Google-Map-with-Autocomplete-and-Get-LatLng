let placeSearch;
let autocomplete;

const componentForm = {
    street_number: "short_name",
    route: "long_name",
    locality: "long_name",
    administrative_area_level_1: "short_name",
    country: "long_name",
    postal_code: "short_name",
};

let position_val = {
    street_number: "",
    route: "",
    locality: "",
    administrative_area_level_1: "",
    country: "",
    postal_code: "",
}

function initAutocomplete() {
    // Create the autocomplete object, restricting the search predictions to
    // geographical location types.
    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById("autocomplete")
    );
    autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    const place = autocomplete.getPlace();
    console.log(place);

    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    for (const component of place.address_components) {
        const addressType = component.types[0];
        
        if (componentForm[addressType]) {
            const val = component[componentForm[addressType]];
            position_val[addressType] = val;
        }
    }

    position_val['route']=position_val['street_number'] + ' ' + position_val['route'];
    for (const component in componentForm) {
        $('#' + component).val(position_val[component]);
    }

}

function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
        const geolocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
        };
        const circle = new google.maps.Circle({
            center: geolocation,
            radius: position.coords.accuracy,
        });
        autocomplete.setBounds(circle.getBounds());
        });
    }
}

function getLatLng() {
    const location=autocomplete.getPlace().geometry.location;
    console.log(autocomplete.getPlace().geometry);
    $('#lat').val(location.lat());
    $('#lng').val(location.lng());
}
