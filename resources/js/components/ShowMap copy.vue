<template>
    <div>
        <h1>Restaurant Finder</h1>
        <input
            v-model="searchKeyword"
            @input="searchRestaurants"
            placeholder="Enter a keyword"
        />

        <div class="restaurant-list">
            <div
                v-for="(restaurant, index) in restaurants"
                :key="index"
                class="restaurant-card"
            >
                <h3>{{ restaurant.name }}</h3>
                <p>{{ restaurant.address }}</p>
            </div>
        </div>

        <!-- Map container -->
        <div id="map"></div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            searchKeyword: "Bang sue", // Set the default keyword here
            restaurants: [],
            map: null,
        };
    },
    created() {
        this.searchRestaurants(); // Call the method when the component is created
    },
    methods: {
        searchRestaurants() {
            axios
                .get("/api/restaurants", {
                    params: {
                        keyword: this.searchKeyword,
                    },
                })
                .then((response) => {
                    this.restaurants = response.data.restaurants;
                    this.initMap(); // Initialize the map after data is loaded
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        initMap() {
            this.loadGoogleMaps(() => {
                const defaultLocation = { lat: 13.8204, lng: 100.5152 };

                this.map = new google.maps.Map(document.getElementById("map"), {
                    center: defaultLocation,
                    zoom: 14,
                });

                this.restaurants.forEach((restaurant) => {
                    const marker = new google.maps.Marker({
                        position: { lat: restaurant.lat, lng: restaurant.lng },
                        map: this.map,
                        title: restaurant.name,
                    });
                });
            });
        },
        loadGoogleMaps(callback) {
            const script = document.createElement("script");
            const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
            script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places`;
            script.onload = callback; // Ensure the callback is called after the script loads
            document.head.appendChild(script);
        },
    },
    mounted() {
        // Load Google Maps API with the initMap function as the callback
        this.loadGoogleMaps(this.initMap);
    },
};
</script>

<style scoped>
/* Add your custom styles here */
#map {
    height: 600px;
}
</style>
