<script setup>
import { computed, onMounted } from 'vue';
// import { usePage } from '@inertiajs/inertia-vue3';

const props = defineProps({
    errors: Object,
})

// const errors = computed(() => usePage().props.value.errors);

const hasErrors = computed(() => Object.keys(props.errors).length > 0);


</script>

<template>
    <div v-if="hasErrors">
        <div class="font-medium text-red-600">問題が発生しました。</div>
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            <!-- {{ props.errors }} -->
            <li v-for="(error, key) in props.errors" :key="key">{{ error }}</li>
        </ul>
    </div>
</template>