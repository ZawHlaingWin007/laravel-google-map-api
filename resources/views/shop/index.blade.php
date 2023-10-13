@extends('layout.app')

@section('content')
    <h3 class="text-center my-4 text-decoration-underline">ပြည်တွင်းဖြစ် Map Testing</h3>
    <div
        class="nearby-shops w-50 mx-auto my-4 p-5 cursor-pointer border text-center"
        id="nearby-shops"
        data-bs-toggle="modal"
        data-bs-target="#nearbyShops"
    >
        <span class="bg-secondary text-white p-2 rounded-1">Nearby Shops</span>
    </div>
    <div class="container">
        <div class="row">
            @foreach ($shops as $shop)
                <div class="col-md-4 my-3">
                    <div class="card shop-card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $shop->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">
                                <span id="user-shop-distance-{{ $shop->id }}"></span> away
                            </h6>
                            <p class="card-text">
                                {{ $shop->description }}
                            </p>
                            <a
                                href="{{ route('shops.getShopBySlug', $shop) }}"
                                class="btn btn-sm btn-primary"
                            >Detail <i class="fa-solid fa-eye"></i></a>
                            <button
                                class="btn btn-sm btn-warning"
                                id="view-shop-on-map"
                                data-shop="{{ $shop }}"
                            >
                                View on map <i class="fa-solid fa-map"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let DEFAULT_DISTANCE = 3;
        // Get Distance Between Current User & Shop in km
        getCurrentLocation(function(currentLat, currentLng) {
            let currentLatLng = new google.maps.LatLng(currentLat, currentLng);
            console.log("Current Location", currentLat, currentLng)
            document.querySelectorAll('#view-shop-on-map').forEach(element => {
                // Shop Location Coordinates
                let shopAttribute = element.getAttribute('data-shop');
                let shop = JSON.parse(shopAttribute)
                var shopLatLng = new google.maps.LatLng(shop.latitude, shop.longitude);

                var distance = getDistanceBetweenTwoPlaces(currentLatLng, shopLatLng, true);
                document.getElementById(`user-shop-distance-${shop.id}`).innerHTML = distance.toFixed(2) +
                    ' km';
            })
        })

        // Click Nearby Shops Button
        function getNearbyShops(DISTANCE = DEFAULT_DISTANCE) {
            getCurrentLocation((currentLat, currentLng) => {
                let currentLatLng = new google.maps.LatLng(currentLat, currentLng);
                let mapContainer = document.getElementById('map_canvas');
                let mapOptions = {
                    zoom: 13,
                    center: currentLatLng
                }

                let map = new google.maps.Map(mapContainer, mapOptions);
                let currentMarker = addMapMarker({
                    coords: currentLatLng,
                    map: map,
                    icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
                })

                const contentString = `
                    <p class="m-0"><strong>This is your current location :-)</strong></p>
                `;

                let currentInfoWindow = showMapInfoWindow(contentString, currentLatLng);
                currentInfoWindow.open(map, currentMarker);

                currentMarker.addListener('click', function() {
                    currentInfoWindow.open(map, currentMarker)
                })

                let shops = [];
                $.ajax({
                    type: "GET",
                    url: "/api/shops",
                    success: function(response) {
                        shops = response.shops;


                        shops.forEach(shop => {
                            let shopLatLng = new google.maps.LatLng(shop.latitude, shop
                                .longitude);
                            let distance = getDistanceBetweenTwoPlaces(currentLatLng,
                                shopLatLng, true);
                            shop.distance = distance
                        });

                        let filteredShops = shops.filter(shop => {
                            return Math.ceil(shop.distance) <= DISTANCE;
                        })

                        console.log("Filtered Shops", filteredShops)

                        let openedInfoWindow = null;
                        filteredShops.forEach(shop => {
                            let shopLatLng = new google.maps.LatLng(shop.latitude, shop
                                .longitude);
                            let shopMarker = addMapMarker({
                                coords: shopLatLng,
                                map: map,
                                label: shop.name.charAt(0)
                            })

                            const contentString = `
                                <p class="m-0"><strong>${shop.name}</strong></p>
                                <p><small>${shop.distance.toFixed(2)} km away</small></p>
                                <a href="/shops/${shop.slug}">View Detail</a>
                            `;

                            shopMarker.addListener("click", () => {
                                let shopInfoWindow = showMapInfoWindow(contentString,
                                    shopLatLng);
                                if (shopMarker.infoWindow && shopMarker.infoWindow
                                    .getMap()) {
                                    shopMarker.infoWindow.close();
                                } else {
                                    if (openedInfoWindow) {
                                        openedInfoWindow.close()
                                    }
                                    shopMarker.infoWindow = shopInfoWindow
                                    shopMarker.infoWindow.open(map, shopMarker);
                                    openedInfoWindow = shopMarker.infoWindow;
                                }
                            });
                        })
                    }
                });

                // Disable click on map
                map.addListener('click', function(event) {
                    // Prevent the default click event for the map
                    event.stop();
                });
            })
        }

        document.getElementById('nearby-shops').addEventListener('click', function() {
            getNearbyShops()
        })

        // Filter Shops by km
        document.getElementById('select-distance').addEventListener('change', function() {
            getNearbyShops(this.value)
        })

        // View Shop on Map
        document.querySelectorAll('#view-shop-on-map').forEach(element => {
            element.addEventListener('click', function() {
                let mapContainer = document.getElementById('shop-map-canvas')
                let shopAttribute = element.getAttribute('data-shop');
                let shop = JSON.parse(shopAttribute)

                // Set Shop name for modal title
                document.getElementById('shop-map-name').innerHTML = shop.name;

                // Open Map Modal
                $('#shopMapModal').modal("show");

                // Initialize google map
                var Latlng = new google.maps.LatLng(shop.latitude, shop.longitude);
                var mapOptions = {
                    zoom: 13,
                    center: Latlng
                }
                var map = new google.maps.Map(mapContainer, mapOptions);
                var marker = addMapMarker({
                    coords: Latlng,
                    map: map,
                })

                const contentString = `
                    <p class="m-0"><strong>${shop.name}</strong></p>
                    <a href="/shops/${shop.slug}">View Detail</a>
                `;
                let infoWindow = showMapInfoWindow(contentString, Latlng)
                infoWindow.open(map, marker);
            })
        });
    </script>
@endpush
