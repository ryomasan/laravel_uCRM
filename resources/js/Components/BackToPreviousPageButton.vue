<script setup>
const historyBack = () => {
    window.history.back();
}
</script>

<template>
    <button @click="historyBack" class="flex justify-start ml-[30px] mt-[30px] bg-white text-indigo-500">
        戻る
    </button>
</template>