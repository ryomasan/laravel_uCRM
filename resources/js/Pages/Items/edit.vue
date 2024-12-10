<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
// import { Link } from '@inertiajs/inertia-vue3';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BackToPreviousPageButton from '@/Components/BackToPreviousPageButton.vue';

const props = defineProps({
    errors: Object,
    item: Object
})

const form = reactive({
    id: props.item.id,
    name: props.item.name,
    memo: props.item.memo,
    stocks: props.item.stocks,
    price: props.item.price,
    // is_selling: props.item.is_selling
})

// const updateItem = (itemId) => {
//     Inertia.put(`/items/${itemId}`, form, {
//         onError: (errors) => console.error(errors)
//     })
// }
const updateItem = (itemId) => {
    Inertia.put(route('items.update', itemId), form, {
        onError: (errors) => console.error(errors)
    })
}

</script>

<template>

    <Head title="商品編集" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品編集</h2>
        </template>
        <ValidationErrors :errors="props.errors" />
        <section class="text-gray-600 body-font relative">
            <BackToPreviousPageButton />
            <div class="container px-5 mx-auto">
                <div class="flex flex-col text-center w-full mb-12">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">商品編集画面</h1>
                    <p class="lg:w-2/3 mx-auto leading-relaxed text-base">商品情報を編集してください</p>
                </div>
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <form @submit.prevent=updateItem(props.item.id)>
                        <div class="flex flex-wrap justify-center  -m-2">
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">商品名</label>
                                    <input type="text" v-model="form.name" name="name"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="price" class="leading-7 text-sm text-gray-600">価格</label>
                                    <input type="number" v-model="form.price" id="price" name="price"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="stocks" class="leading-7 text-sm text-gray-600">在庫数</label>
                                    <input type="number" v-model="form.stocks" id="stocks" name="stocks"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="memo" class="leading-7 text-sm text-gray-600">備考</label>
                                    <textarea id="memo" v-model="form.memo" name="memo"
                                        class="w-full h-[100px] bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                </div>
                            </div>
                            <!-- <div class="p-2 w-full">
                                <input type="radio" id="is_selling" v-model="form.is_selling" name="is_selling"
                                    :value=0>
                                <label for="is_selling" class="leading-7 text-sm text-gray-600"
                                    :checked="form.is_selling === 0">販売中</label>
                                <input type="radio" id="sold_out" v-model="form.is_selling"
                                    :checked="form.is_selling === 1" name="is_selling" :value=1>
                                <label for="sold_out" class="leading-7 text-sm text-gray-600">在庫切れ</label>
                            </div> -->
                        </div>
                        <!-- </div> -->
                        <div class="p-2 w-full">
                            <button type="submit"
                                class="flex mx-auto ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                更新
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
