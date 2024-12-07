<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
// import { Link } from '@inertiajs/inertia-vue3';
// import ValidationErrors from '@/Components/ValidationErrors.vue';
import { computed, onMounted, reactive, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BackToPreviousPageButton from '@/Components/BackToPreviousPageButton.vue';
import { getDate } from '@/common';

const props = defineProps({
    items: Object,
    order: Object
})

const form = reactive({
    id: props.order[0].id,
    date: getDate(props.order[0].created_at),
    customer_id: props.order[0].customer_id,
    status: props.order[0].status,
    items: props.items.map(item => ({
        id: item.item_id,
        quantity: item.quantity
    }))
})

const purchase_num_arr = computed(() => {
    return props.items.map(item => Array.from({ length: item.item_stocks + 1 }, (_, i) => i));
});

const updateHistory = (orderId) => {
    Inertia.put(`/purchases/${orderId}`, form)
}

const total_price_per_product = computed(() => {
    return props.items.map((item, index) => {
        const quantity = form.items[index].quantity || 0;
        return item.item_price * quantity;
    });
});

const total_price_all_products = computed(() => {
    return props.items.reduce((sum, item, index) => {
        const quantity = form.items[index].quantity || 0;
        return sum + item.item_price * quantity;
    }, 0);
});

onMounted(() => {
    console.log(form.items);
    console.log(props.order);
    console.log(total_price_per_product);
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
                    <form @submit.prevent="updateHistory(form.id)">
                        <div class="flex flex-wrap justify-center  -m-2">
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="price" class="leading-7 text-sm text-gray-600">購入日</label>
                                    <input disabled id="price" name="price"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                        :value="form.date">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">顧客名</label>
                                    <input disabled name="name"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                        :value="props.order[0].customer_name">
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
                                                <tr v-for="(item, index) in props.items" :key="index">
                                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                        item.pivot_id }}
                                                    </td>
                                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                        item.item_name
                                                        }}</td>
                                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                        item.item_price }}
                                                    </td>
                                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">
                                                        <select v-model="form.items[index].quantity" id="prefecture"
                                                            name="prefecture"
                                                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                            <option v-for="purchase_num in purchase_num_arr[index]"
                                                                :key="purchase_num">
                                                                {{ purchase_num }}
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">
                                                        {{ total_price_per_product[index] }}
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
                                    <input disabled id="price" name="price"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                        :value="total_price_all_products">

                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="price" class="leading-7 text-sm text-gray-600">ステータス</label><br>
                                    <input type="radio" id="status" v-model="form.status" :value="1">未キャンセル
                                    <input type="radio" id="status" v-model="form.status" :value="0">キャンセルする
                                </div>
                            </div>
                        </div>
                        <div class="p-2 w-full">
                            <button type="submit"
                                class="flex mx-auto mt-[10px] ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                更新
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </section>
    </AuthenticatedLayout>
</template>
