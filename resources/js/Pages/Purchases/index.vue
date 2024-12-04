<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/inertia-vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { computed, onMounted, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { getDate } from '@/common';
import Pagination from '@/Components/Pagination.vue';
import { isEmpty } from 'lodash';

const props = defineProps({
    orders: Object
})

let search = ref('')

const searchOrders = () => {
    Inertia.get(route('purchases.index', { search: search.value }))
}

const searchedOrders = computed(() => {
    if (isEmpty(search.value)) {
        return props.orders.data
    } else {
        const result = props.orders.data.filter(order =>
            order.name.includes(search.value) ||
            order.kana.includes(search.value) ||
            order.tel.includes(search.value)
        )
        return result
    }
}
)

const deleteHistory = (orderId) => {
    Inertia.delete(`/purchases/${orderId}`, {
        onBefore: () => confirm("本当に削除しますか？"),
    });
}

// onMounted(() => {
//   console.log(getItemStatus());  
// })

</script>

<template>

    <Head title="購入履歴" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between gap-96">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">購入履歴</h2>
                <FlashMessage />
            </div>
        </template>
        <section class="text-gray-600 body-font">
            <div class="container px-5 mx-auto my-10">
                <div class="container lg:w-3/4 mx-auto  my-10">
                    <input type="text" name="search" v-model="search">
                    <button class="bg-blue-300 text-white py-2 px-2 mx-4" @click="searchOrders">検索</button>
                </div>
                <div class="lg:w-3/4 mx-auto overflow-auto">
                    <!-- Fixed Header -->
                    <table class="w-full text-left whitespace-no-wrap border-collapse table-fixed">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                    購買id</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    顧客名</th>
                                <!-- <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    商品名</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    数量</th> -->

                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    合計金額</th>
                                <!-- <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    ステータス</th> -->
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    購入日</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                </th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                </th>
                            </tr>
                        </thead>
                    </table>

                    <!-- Scrollable Body -->
                    <div class="overflow-y-scroll h-[350px]">
                        <table class="w-full text-left whitespace-no-wrap border-collapse table-fixed">
                            <tbody>
                                <tr v-for="order in searchedOrders">
                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ order.id }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ order.customer_name
                                        }}</td>
                                    <!-- <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ order.item_name }}
                                    </td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ order.quantity }}
                                    </td> -->
                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ order.total }}
                                    </td>
                                    <!-- <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ order.status }}</td> -->
                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                        getDate(order.created_at) }}
                                    </td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">
                                        <!-- 　tr内の@clickへのpropagationの阻止　 -->
                                        <button @click.stop="editHistory(order.id)"
                                            class="flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                            編集</button>
                                    </td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">
                                        <!-- 　tr内の@clickへのpropagationの阻止　 -->
                                        <button @click.stop="deleteHistory(order.id)"
                                            class="flex text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded">
                                            削除</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- </div> -->
                </div>
                <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                    <Pagination :links=props.orders.links></Pagination>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
