<script setup>
</script>

<template>
    <div v-if="$page.props.flash.message === 'success'"
        class=" text-white w-[200px] bg-indigo-500 border-0 py-2 text-center animate-fadeInOut  rounded">
        {{ $page.props.flash.message }}
    </div>
</template>
