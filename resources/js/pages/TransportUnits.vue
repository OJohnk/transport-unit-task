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
    margin-bottom: 24px;
}

.tabs button {
    padding: 12px 24px;
    border: none;
    background: none;
    cursor: pointer;
    font-size: 15px;
    color: #888;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    transition: color 0.2s, border-color 0.2s;
}

.tabs button:hover {
    color: #333;
}

.tabs button.active {
    color: #2563eb;
    border-bottom: 3px solid #2563eb;
    font-weight: 600;
}

</style>
