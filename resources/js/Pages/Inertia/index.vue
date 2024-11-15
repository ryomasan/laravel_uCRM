<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue';
// import route from 'vendor/tightenco/ziggy/src/js';
const userId = reactive({
    id: 1
})

const props = defineProps({
    posts: Array
})

</script>

<template>
    <div v-if="$page.props.flash.message">{{ $page.props.flash.message }}</div>
    <Link :href="route('inertia.create')">新規投稿</Link>
    <div>
        <Link v-for="post in props.posts" :href="route('inertia.show', post.id)" class="posts">
        <div style="border: solid 1px; margin: 10px;">
            <p>件名：{{ post.title }}</p>
            <p>投稿内容：{{ post.content }}</p>
        </div>
        </Link>
    </div>
    <!-- <a href="/">aタグでWelcomeに移動</a><br> -->
    <!-- <Link :href="route('inertia.index')">LinkでWelcomeに移動</Link> <br>
    <Link :href="route('inertia.show', userId)">LinkでInertia/showページに移動</Link><br> -->

</template>