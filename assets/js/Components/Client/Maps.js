'use strict';

import $ from 'jquery';

class Maps {

    constructor() {
        let $target     = $('#company-address-coordinate');
        this.address    = $target.data('address');
        this.coordinate = $target.data('coordinate');
    }

    initMap() {
        let lat = 0;
        let lng = 0;
        let companyMap = document.getElementById('company-map');

        if (!companyMap) {
            return;
        }

        if (this.coordinate) {
            this.coordinate = this.coordinate.slice(1).slice(0, -1).split(',');
            lat = parseFloat(this.coordinate[0]);
            lng = parseFloat(this.coordinate[1]);
        }

        let map = new google.maps.Map(companyMap, {
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
                alert('Может быть ошибка в навигации причина: ' + status);
            }
        });
    }
}

export default Maps;