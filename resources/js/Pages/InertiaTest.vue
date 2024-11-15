<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { reactive, ref } from 'vue' // リアクティブ
const newTitle = ref('');
const newContent = ref('');
const testData = reactive({
    title: newTitle,
    content: newContent
})

</script>
<template>
    <input type="text" name="newTitle" v-model="newTitle">{{ newTitle }}<br>
    <input type="text" name="newContent" v-model="newContent">{{ newContent }}
    <br>
    <Link as="button" method="post" :href="route('inertia.store')" :data="testData">保存テスト</Link>
</template>