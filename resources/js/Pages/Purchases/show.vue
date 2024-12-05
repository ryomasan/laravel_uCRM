<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
// import { Link } from '@inertiajs/inertia-vue3';
// import ValidationErrors from '@/Components/ValidationErrors.vue';
import { onMounted, reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BackToPreviousPageButton from '@/Components/BackToPreviousPageButton.vue';
import { getDate } from '@/common';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    items: Object,
    order: Object
})

// const editHistory = (orderId) => {
//     Inertia.get(`/purchases/${orderId}/edit`)
// }

onMounted(() => {
    console.log(props.items);
    console.log(props.order[0]);
})

</script>

<template>

    <Head title="商品詳細" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">購入履歴</h2>
        </template>
        <!-- <ValidationErrors :errors="props.errors" /> -->
        <section class="text-gray-600 body-font relative">
            <BackToPreviousPageButton />
            <div class="container px-5 py-12 mx-auto">
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <div class="flex flex-wrap justify-center  -m-2">
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="price" class="leading-7 text-sm text-gray-600">購入日</label>
                                <input id="price" name="price"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                    :value="getDate(props.order[0].created_at)">
                            </div>
                        </div>
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="name" class="leading-7 text-sm text-gray-600">顧客名</label>
                                <div name="name"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.order[0].customer_name }}</div>
                            </div>
                        </div>
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="name" class="leading-7 text-sm text-gray-600">購入商品</label>
                                <!-- Fixed Header -->
                                <table class="w-full text-left whitespace-no-wrap border-collapse table-fixed">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                                id</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                商品名</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                金額</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                数量</th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                小計
                                            </th>
                                        </tr>
                                    </thead>
                                </table>

                                <!-- Scrollable Body -->
                                <div class="overflow-y-scroll max-h-[350px]">
                                    <table class="w-full text-left whitespace-no-wrap border-collapse table-fixed">
                                        <tbody>
                                            <tr v-for="item in props.items">
                                                <!-- {{ item }}                               -->
                                                <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                    item.pivot_id }}
                                                </td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                    item.item_name
                                                    }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                    item.item_price }}
                                                </td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                    item.quantity
                                                    }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                    item.subtotal }}
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="price" class="leading-7 text-sm text-gray-600">合計金額</label>
                                <input disabledid="price" name="price"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                    :value="props.order[0].total">
                            </div>
                        </div>
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="price" class="leading-7 text-sm text-gray-600">ステータス</label>
                                <input disabled id="price" name="price"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                    :value="props.items[0].status === 0 ? 'キャンセル済み' : '未キャンセル'">
                            </div>
                        </div>
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="price" class="leading-7 text-sm text-gray-600">キャンセル日</label>
                                <input disabled id="price" name="price"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                    :value="props.items[0].status === 0 ? getDate(props.order[0].updated_at) : ''">
                            </div>
                        </div>
                    </div>
                    <div v-if="props.items[0].status === 1" class="p-2 w-full">
                        <Link as="button" :href="route('purchases.edit', props.order[0].id)"
                            class="flex mx-auto mt-[10px] ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                        編集
                        </Link>
                    </div>
                </div>

            </div>
        </section>
    </AuthenticatedLayout>
</template>
