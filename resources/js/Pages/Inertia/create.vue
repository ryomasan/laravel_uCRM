<script setup>
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  errors: Object,
})

const form = reactive({
  title: null,
  content: null,
})

function submit() {
  Inertia.post('/inertia', form)
}
</script>

<template>
  <form @submit.prevent="submit">
    <label for="title">タイトル:</label>
    <input id="title" v-model="form.title" /><br>
    <div v-if="errors.title">{{ props.errors.title }}</div>
    <label for="content">内容:</label>
    <input id="content" v-model="form.content" /><br>
    <div v-if="errors.content">{{ props.errors.content }}</div>
    <button type="submit">Submit</button>
  </form>
</template>