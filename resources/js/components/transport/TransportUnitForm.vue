<script setup lang="ts">
import { ref } from 'vue';
import { createUnit } from '../../services/api';
import { Type } from '../../types/TransportUnit';

const props = defineProps<{
    type: Type;
}>();

const emit = defineEmits<{
    created: [];
}>();

const name = ref('');
const error = ref('');

async function handleSubmit() {
    if (!name.value.trim()) return;
	try {
		await createUnit(name.value, props.type);
    	name.value = '';
		error.value = '';
    	emit('created');
	} catch (err) {
		error.value = 'Failed to create transport unit.';
	}
}

</script>

<template>
    <form @submit.prevent="handleSubmit">
        <input v-model="name" type="text" placeholder="Enter name..." maxlength="100" />
        <button type="submit">Create</button>
    </form>
	<p v-if="error">{{ error }}</p>
</template>

<style scoped>

form {
    display: flex;
    gap: 8px;
    margin-bottom: 16px;
}

input {
    padding: 8px;
    flex: 1;
}

button {
    padding: 8px 16px;
    cursor: pointer;
}

</style>