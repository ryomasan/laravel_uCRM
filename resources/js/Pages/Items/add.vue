<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
// import { Link } from '@inertiajs/inertia-vue3';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import { computed, reactive, ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BackToPreviousPageButton from '@/Components/BackToPreviousPageButton.vue';

const props = defineProps({
    errors: Object,
    item: Object
})

const form = reactive({
    id: props.item.id,
    add_order_num: null
})

const addItem = (itemId) => {
    Inertia.patch(`/items/${itemId}/add`, form)
}

</script>

<template>

    <Head title="追加発注" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">追加発注</h2>
        </template>
        <ValidationErrors :errors="props.errors" />
        <section class="text-gray-600 body-font relative">
            <BackToPreviousPageButton />
            <div class="container px-5 mx-auto">
                <div class="flex flex-col text-center w-full mb-12">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">追加発注画面</h1>
                    <!-- <p class="lg:w-2/3 mx-auto leading-relaxed text-base">商品情報を入力してください</p> -->
                </div>
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <form @submit.prevent="addItem(props.item.id)">
                        <div class="flex flex-wrap justify-center  -m-2">
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">商品名(選択してください)</label>
                                    <input disabled type="text" name="name"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                        :value="props.item.name"
                                        >                                    
                                </div>
                            </div>                           
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="add_order_num" class="leading-7 text-sm text-gray-600">追加発注数</label>
                                    <input type="number" v-model="form.add_order_num" id="add_order_num"
                                        name="add_order_num"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <button type="submit"
                                    class="flex mx-auto ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                    追加発注
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </AuthenticatedLayout>
</template>
