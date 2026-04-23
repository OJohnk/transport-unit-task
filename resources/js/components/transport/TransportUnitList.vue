<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import { getUnits } from '../../services/api';
import { Type, TransportUnit } from '../../types/TransportUnit';
import TransportUnitForm from './TransportUnitForm.vue';

const props = defineProps<{
	type: Type;
}>();

const searchTerm = ref('');
const units = ref<TransportUnit[]>([]);
const page = ref(1);
const lastPage = ref(1);
const loading = ref(false);
const error = ref('');

async function fetchUnits() {
    loading.value = true;
    try {
        const response = await getUnits(props.type, page.value, searchTerm.value);
        units.value = response.data.data;
        lastPage.value = response.data.last_page;
        error.value = '';
    } catch {
        error.value = 'Failed to load units.';
    } finally {
        loading.value = false;
    }
}

let searchTimeout: ReturnType<typeof setTimeout>;

onMounted(fetchUnits);
// Avoids firing a request on every key press.
watch(searchTerm, () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        page.value = 1;
        fetchUnits();
    }, 300);
});
// Clear search when type changes
watch(() => props.type, () => {
    searchTerm.value = '';
    page.value = 1;
    fetchUnits();
});

</script>

<template>
    <div>
        <div class="fields-container">
            <TransportUnitForm :type="props.type" @created="fetchUnits" />
            <input v-model="searchTerm" type="text" placeholder="Search by name..." />
        </div>
        <p v-if="error" class="error">{{ error }}</p>

        <div class="list-container">
            <div v-if="loading" class="spinner-overlay">
                <div class="spinner"></div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="unit in units" :key="unit.id">
                        <td>{{ unit.name }}</td>
                    </tr>
                    <tr v-if="!loading && units.length === 0">
                        <td class="empty">No units found.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <button :disabled="page === 1" @click="page--; fetchUnits()">&#8592;</button>
            <span>Page {{ page }}</span>
            <button :disabled="page === lastPage" @click="page++; fetchUnits()">&#8594;</button>
        </div>
    </div>
</template>

<style scoped>

.error {
    color: #dc2626;
    font-size: 13px;
    margin-bottom: 8px;
}

.fields-container {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 12px;
}

.fields-container :deep(form) {
    border-bottom: 1px solid #ddd;
}

.fields-container :deep(form input) {
    border: none;
    border-radius: 0;
    width: 100%;
    padding: 10px 90px 10px 14px;
    font-size: 14px;
    outline: none;
    box-sizing: border-box;
}

.fields-container :deep(form button) {
    border-radius: 6px;
}

.fields-container > input {
    display: block;
    width: 100%;
    padding: 10px 14px;
    border: none;
    border-radius: 0;
    font-size: 14px;
    outline: none;
    box-sizing: border-box;
}

table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #eee;
    border-radius: 8px;
    overflow: hidden;
}

th {
    text-align: left;
    padding: 10px 16px;
    background: #f9f9f9;
    font-size: 13px;
    color: #888;
    border-bottom: 1px solid #eee;
}

td {
    padding: 12px 16px;
    font-size: 14px;
    border-bottom: 1px solid #eee;
}

.empty {
    color: #aaa;
    font-style: italic;
    text-align: center;
}

tr:last-child td {
    border-bottom: none;
}

.pagination {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 16px;
}

.pagination button {
    padding: 6px 14px;
    cursor: pointer;
    border: 1px solid #ddd;
    border-radius: 6px;
    background: #fff;
    font-size: 14px;
    transition: background 0.2s;
}

.pagination button:hover:not(:disabled) {
    background: #f0f0f0;
}

.pagination button:disabled {
    opacity: 0.4;
    cursor: default;
}

.list-container {
    position: relative;
    min-height: 500px;
}

.spinner-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.4);
}

.spinner {
    width: 28px;
    height: 28px;
    border: 3px solid #e0e0e0;
    border-top-color: #2563eb;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

</style>