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
    } catch {
        error.value = 'Failed to create transport unit.';
    }
}

</script>

<template>
    <form @submit.prevent="handleSubmit">
        <input v-model="name" type="text" placeholder="Enter unit name..." maxlength="100" />
        <button type="submit">Create</button>
    </form>
    <p v-if="error">{{ error }}</p>
</template>

<style scoped>

form {
    position: relative;
    display: flex;
    align-items: center;
}

input {
    padding: 10px 90px 10px 14px;
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s;
    box-sizing: border-box;
}

input:focus {
    border-color: #2563eb;
}

button {
    position: absolute;
    right: 6px;
    padding: 6px 14px;
    cursor: pointer;
    background: #2563eb;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 13px;
    transition: background 0.2s;
}

button:hover {
    background: #1d4ed8;
}

p {
    color: #dc2626;
    font-size: 13px;
    margin-top: 6px;
}

</style>