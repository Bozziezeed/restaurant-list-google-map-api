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
            // Fetch restaurant data from the API
            axios
                .get("/api/restaurants", {
                    params: {
                        keyword: this.searchKeyword,
                    },
                })
                .then((response) => {
                    // Parse API response and populate the restaurants array
                    this.restaurants = response.data.restaurants; // Use "response.data.restaurants"
                    // to access the "restaurants" array
                    this.initMap(); // Initialize the map after data is loaded
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        async initMap() {
            const { Map } = await google.maps.importLibrary("maps");

            map = new Map(document.getElementById("map"), {
                center: { lat: -34.397, lng: 150.644 },
                zoom: 8,
            });
        },
    },
};
</script>

<style scoped>
/* Add your custom styles here */
#map {
    height: 600px;
}
</style>
