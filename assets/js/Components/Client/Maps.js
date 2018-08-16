'use strict';

class Maps {

    constructor($wrapper) {
        this.wrapper = $wrapper;
        this.address = $wrapper.find('[data-address]').text();
    }

    initMap() {
        let map = new google.maps.Map(document.getElementById('company_map'), {
            zoom: 8,
            center: {lat: -34.397, lng: 150.644}
        });
        let geocoder = new google.maps.Geocoder();
        this.codeAddress(geocoder, map);
    }

    codeAddress(geocoder, map) {
        geocoder.geocode({'address': this.address}, function(results, status) {
            if (status === 'OK') {
                map.setCenter(results[0].geometry.location);
                let marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            } else {
                alert('Запрос не был успешным по следующей причине: ' + status);
            }
        });
    }
}

export default Maps;