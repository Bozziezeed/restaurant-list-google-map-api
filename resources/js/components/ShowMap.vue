<template>
    <div class="row align-items-start">
        <div
            class="col-md-4 overflow-auto"
            :class="{ googlemap: restaurants.length > 0 }"
        >
            <form class="mb-2" @submit.prevent="searchRestaurants">
                <div class="mb-2">
                    <div>
                        <label for="Restaurant Finder" class="form-label"
                            ><h4>Restaurant Finder</h4>
                        </label>
                    </div>

                    <input
                        v-model="searchKeyword"
                        placeholder="Enter a keyword"
                    />
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <div v-for="(restaurant, index) in restaurants" :key="index">
                <div class="card mb-4" style="width: 18rem">
                    <div class="card-body">
                        <h5 class="card-title">{{ restaurant.name }}</h5>
                        <p class="card-text">
                            {{ restaurant.address }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map container -->
        <div id="map" class="col-md-8">
            <GoogleMap
                :api-key="apikey"
                style="width: 100%; height: 700px"
                :center="center"
                :zoom="15"
            >
                <Marker
                    v-for="(markerOption, index) in markerOptions"
                    :key="index"
                    :options="markerOption"
                />
            </GoogleMap>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { defineComponent } from "vue";
import { GoogleMap, Marker } from "vue3-google-map";

export default defineComponent({
    components: { GoogleMap, Marker },
    data() {
        return {
            apikey: import.meta.env.VITE_GOOGLE_MAPS_API_KEY,
            searchKeyword: "Bang sue", // Set the default keyword here
            restaurants: [],
            center: { lat: 13.828253, lng: 100.5284507 }, // Initialize with a placeholder value
            markerOptions: [],
        };
    },
    //   setup() {
    //     //const center = { lat: 13.828253, lng: 100.5284507 };
    //     const markerOptions = [];

    //     return { markerOptions };
    //   },
    methods: {
        searchRestaurants() {
            axios
                .get("http://127.0.0.1:8000/api/restaurants", {
                    params: {
                        keyword: this.searchKeyword,
                    },
                })
                .then((response) => {
                    this.restaurants = response.data;

                    if (this.restaurants.length > 0) {
                        // Update center with the average coordinates of all restaurants
                        const sumLat = this.restaurants.reduce(
                            (sum, restaurant) => sum + restaurant.latitude,
                            0
                        );
                        const sumLng = this.restaurants.reduce(
                            (sum, restaurant) => sum + restaurant.longitude,
                            0
                        );
                        this.center = {
                            lat: sumLat / this.restaurants.length,
                            lng: sumLng / this.restaurants.length,
                        };

                        //Create marker options
                        this.markerOptions = this.restaurants.map(
                            (restaurant) => {
                                return {
                                    position: {
                                        lat: restaurant.latitude,
                                        lng: restaurant.longitude,
                                    },
                                    title: restaurant.name,
                                };
                            }
                        );

                        // CalculmarkerOptionsounds for the map to fit all markers
                        const bounds = new google.maps.LatLngBounds();
                        this.markerOptions.forEach((markerOption) => {
                            bounds.extend(markerOption.position);
                        });
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
});
</script>
<style>
/* Your styles here */
.googlemap {
    height: 700px;
}
</style>
