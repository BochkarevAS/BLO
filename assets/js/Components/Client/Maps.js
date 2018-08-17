'use strict';

import $ from 'jquery';

class Maps {

    constructor() {
        let $target     = $('#company_address_coordinate');
        this.coordinate = $target.data('coordinate').slice(1).slice(0, -1).split(',');
        this.address    = $target.data('address');
    }

    initMap() {
        let lat = 0;
        let lng = 0;

        if (this.coordinate) {
            lat = parseFloat(this.coordinate[0]);
            lng = parseFloat(this.coordinate[1]);
        }

        let map = new google.maps.Map(document.getElementById('company_map'), {
            zoom: 17,
            center: {lat: lat, lng: lng}
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