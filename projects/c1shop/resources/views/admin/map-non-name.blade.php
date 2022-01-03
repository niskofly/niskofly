@php
    $this_coordinates = $model->coordinates ? $model->coordinates : '55.73367, 37.587874';
@endphp

<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
<script src="/js/libs/jquery/dist/jquery.min.js"></script>

<div id="map" style="height: 500px;"></div>
<script>
    $(document).ready(function () {
        admin_point_name = 'Офис';
        ymaps.ready(init);

        var myMap;

        function init() {
            myMap = new ymaps.Map(
                'map',
                {
                    center: [{{$this_coordinates}}],
                    zoom: 15,
                    controls: []
                }),
                mySearchControl = new ymaps.control.SearchControl({}),

            myMap.controls.add(mySearchControl);
            mySearchControl.events.add('resultselect', function (e) {

                var index = e.get('index'),
                    arr;
                mySearchControl.getResult(index).then(function (res) {
                    arr = res._geoObjectComponent._context.geometry._bounds[0];
                    $('.js-input-coordinates').val(arr[0] + ' , ' + arr[1]);
                    FindCityToCoords(arr);
                    myMap.geoObjects.removeAll();
                    myGeoObject = new ymaps.GeoObject({
                        geometry: {
                            type: "Point",
                            coordinates: arr
                        },
                        properties: {
                            iconContent: admin_point_name
                        }
                    }, {
                        preset: 'islands#blackStretchyIcon',
                        draggable: true
                    });
                    myGeoObject.events.add("dragend", function (event) {
                        $('.js-input-coordinates').val(event.originalEvent.target.geometry._bounds[0][0] + ' , ' + event.originalEvent.target.geometry._bounds[0][1]);
                        FindCityToCoords(event.originalEvent.target.geometry._bounds[0]);
                    });
                    myMap.geoObjects
                        .add(myGeoObject);
                    mySearchControl.clear();
                });
            });

            @if($model->address)
                myGeoObject = new ymaps.GeoObject({
                geometry: {
                    type: "Point",
                    coordinates: [{{$model->coordinates}}]
                },
                properties: {
                    iconContent: admin_point_name
                }
                }, {
                    preset: 'islands#blackStretchyIcon',
                    draggable: true
                });

                myGeoObject.events.add("dragend", function (event) {
                    $('.js-input-coordinates').val(event.originalEvent.target.geometry._bounds[0][0] + ' , ' + event.originalEvent.target.geometry._bounds[0][1]);
                    FindCityToCoords(event.originalEvent.target.geometry._bounds[0])
                });

                myMap.geoObjects
                    .add(myGeoObject);
            @endif

        }

        // определение адресса по координатам
        function FindCityToCoords(coords) {
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0),
                    fullAddress = firstGeoObject.getAddressLine(),
                    location = firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                    city = location[0];
                $('.js-input-city').val(city);
                $('.js-input-address').val(fullAddress);
            });
        }

        function geoCoord(findValue) {
            $('.ymaps-2-1-53-searchbox-input__input').val(findValue);
            $('.ymaps-2-1-53-searchbox-button-text').trigger('click');
        }
    });
</script>