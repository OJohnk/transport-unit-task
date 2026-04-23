<script setup lang="ts">
import { ref } from 'vue';
import { Type } from '../types/TransportUnit';
import TransportUnitList from '../components/transport/TransportUnitList.vue';

const activeTab = ref<Type>(Type.Truck);


</script>

<template>
    <div class="container">
        <div class="tabs">
            <button :class="{ active: activeTab === Type.Truck }" @click="activeTab = Type.Truck">Trucks</button>
            <button :class="{ active: activeTab === Type.Trailer }" @click="activeTab = Type.Trailer">Trailers</button>
        </div>

        <div class="tab-content">
            <TransportUnitList :type="activeTab" />
        </div>
    </div>
</template>

<style scoped>

.container {
    max-width: 400px;
    margin: 40px auto;
    padding: 0 16px;
}

.tabs {
    display: flex;
	justify-content: center;
    gap: 8px;
    margin-bottom: 16px;
}

.tabs button {
    padding: 8px 16px;
    cursor: pointer;
}

.tabs button.active {
    font-weight: bold;
    border-bottom: 2px solid black;
}

</style>
