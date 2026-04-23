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
const error = ref('');

async function fetchUnits() {
	try {
		const response = await getUnits(props.type, page.value, searchTerm.value);
		units.value = response.data.data;
		lastPage.value = response.data.last_page;
		error.value = '';
	} catch (err) {
		error.value = 'Failed to fetch transport units.';
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
        <TransportUnitForm :type="props.type" @created="fetchUnits" />
        <input v-model="searchTerm" type="text" placeholder="Search by name..." />
		<p v-if="error">{{ error }}</p>

        <ul>
            <li v-for="unit in units" :key="unit.id">
                {{ unit.name }}
            </li>
        </ul>

        <div class="pagination">
            <button :disabled="page === 1" @click="page--; fetchUnits()">Previous</button>
            <span>Page {{ page }}</span>
            <button :disabled="page === lastPage" @click="page++; fetchUnits()">Next</button>
        </div>
    </div>
</template>

<style scoped>

input {
    padding: 8px;
    width: 100%;
    margin-bottom: 16px;
    box-sizing: border-box;
}

ul {
    list-style: none;
    padding: 0;
}

li {
    padding: 8px;
    border-bottom: 1px solid #eee;
}

.pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-top: 16px;
}

.pagination button {
    padding: 6px 12px;
    cursor: pointer;
}

.pagination button:disabled {
    opacity: 0.4;
    cursor: default;
}

</style>