<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
// import { Link } from '@inertiajs/inertia-vue3';
// import ValidationErrors from '@/Components/ValidationErrors.vue';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BackToPreviousPageButton from '@/Components/BackToPreviousPageButton.vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    item: Object
})

// const form = reactive({
//     name: null,
//     memo: null,
//     price: null
// })

// const editItem = (itemId) => {
//     Inertia.get(`/items/${itemId}/edit`)
// }

</script>

<template>

    <Head title="商品詳細" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品詳細</h2>
        </template>
        <!-- <ValidationErrors :errors="props.errors" /> -->
        <section class="text-gray-600 body-font relative">
            <BackToPreviousPageButton />
            <div class="container px-5 py-12 mx-auto">
                <div class="flex flex-col text-center w-full mb-12">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">商品詳細</h1>
                    <p class="lg:w-2/3 mx-auto leading-relaxed text-base">購入する商品の情報を入力してください</p>
                </div>
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <!-- <form @submit.prevent="editItem(props.item.id)"> -->
                    <div class="flex flex-wrap justify-center  -m-2">
                        <div class="p-2 w-full">
                            <div class="relative">
                                <div>
                                    <label for="name" class="leading-7 text-sm text-gray-600">商品名</label>
                                    <div name="name"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        {{ props.item.name }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="price" class="leading-7 text-sm text-gray-600">価格</label>
                                <input disabled id="price" name="price"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                    :value="props.item.price">
                            </div>
                        </div>
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="memo" class="leading-7 text-sm text-gray-600">備考</label>
                                <textarea disabled id="memo" name="memo"
                                    class="w-full h-[100px] bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-6 transition-colors duration-200 ease-in-out whitespace-pre-wrap"                                
                                    >
                                    {{ props.item.memo }}
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <Link as="button" :href="route('items.edit', props.item.id)"
                            class="flex mx-auto mt-[10px] ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                        編集
                        </Link>
                    </div>
                    <!-- </form> -->

                </div>

            </div>
        </section>

    </AuthenticatedLayout>
</template>
