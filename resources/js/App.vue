<template>
    <div class="container mt-3 overflow-auto googlemap">
        <show-map />
    </div>
</template>

<script>
import ShowMap from "./components/ShowMap.vue";
// import GoogleMap from "./components/GoogleMap.vue";

export default {
    name: "App",
    components: {
        ShowMap,
    },
};
</script>

<style>
/* Your styles here */
.googlemap {
    height: 1000px;
}
</style>
