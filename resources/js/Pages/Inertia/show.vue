<script setup>
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
// import route from 'vendor/tightenco/ziggy/src/js';

// const props = defineProps({
//     id: [Number, String]
// })
const props = defineProps({
    id: [Number, String],
    auth: Object,
    post: Object
})

const formatDate = (dateString) => {
    const dt = new Date(dateString);
    const y = dt.getFullYear();
    const m = ('00' + (dt.getMonth() + 1)).slice(-2);
    const d = ('00' + dt.getDate()).slice(-2);
    return `${y}-${m}-${d}`;
}

const goBack = () => {
    history.back();
}

const deletePosts = (postId) => {
    Inertia.delete(route('inertia.destroy', postId), {
        onBefore: () => confirm("本当に削除しますか？"),
        onSuccess: (page) => {
            console.log('onSuccess', page);
        }
    })
}

</script>

<template>
    <!-- ユーザーID:{{ props.id }}<br>
    ユーザー情報:{{ props.auth.user.name }}<br>
    メールアドレス:{{ props.auth.user.email }}<br>
    登録日:{{ formatDate(props.auth.user.created_at) }}<br>
    更新日:{{ formatDate(props.auth.user.updated_at) }}<br> -->
    <p>{{ formatDate(props.auth.user.created_at) }}</p>
    <p>件名：{{ props.post.title }}</p>
    <p>{{ props.post.content }}</p>
    <Link @click.prevent="goBack" class="posts">戻る</Link>
    <Link @click="deletePosts(props.post.id)" class="posts">削除</Link>
</template>