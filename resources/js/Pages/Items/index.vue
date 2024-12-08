<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/inertia-vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { computed, onMounted, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { isEmpty } from 'lodash';
import Pagination from '@/Components/Pagination.vue';


const props = defineProps({
    items: Object
})

// const getItemStatus = computed(() => {
//     return props.items.forEach(item => {
//         item.stocks > 0 ? item.isSelling == 0 : item.isSelling == 1;
//         return item.isSelling === 0 ? '在庫切れ' : '販売中';
//     });
//     // return props.items.forEach(item => {
//     //     console.log(item)
//     //     return item.stocks > 0 ? "販売中" : "在庫切れ";
//     // });
// });

let search = ref('')

const searchItems = () => {
    Inertia.get(route('items.index', { search: search.value }))
}

const searchedItems = computed(() => {
    if (isEmpty(search.value)) {
        return props.items.data
    } else {
        const result = props.items.data.filter(item =>
            item.name.includes(search.value)
        )
        return result
    }
}
)

const getItemStatus = (isSelling) => {
    props.items.data.forEach(item => {
        item.stocks > 0 ? item.isSelling = 0 : item.isSelling = 1;
    });
    return isSelling == 0 ? '販売中' : '在庫切れ';
}


const showItem = (itemId) => {
    Inertia.get(`/items/${itemId}`, itemId);
}

const deleteItem = (itemId) => {
    Inertia.delete(`/items/${itemId}`, {
        onBefore: () => confirm("本当に削除しますか？"),
    });
}

onMounted(() => {
    console.log(props.items.links);
})

</script>

<template>

    <Head title="商品一覧" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between gap-96">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品一覧</h2>
                <!-- <FlashMessage /> -->
            </div>
        </template>
        <section class="text-gray-600 body-font">
            <div class="container px-5 mx-auto">
                <div class="container lg:w-3/4 mx-auto  my-10">
                    <input type="text" name="search" v-model="search">
                    <button class="bg-blue-300 text-white py-2 px-2 mx-4" @click="searchItems">検索</button>
                </div>
                <div class="lg:w-3/4 mx-auto overflow-auto">
                    <!-- <div class="relative"> -->
                    <!-- Fixed Header -->
                    <table class="w-full text-left whitespace-no-wrap border-collapse table-fixed">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                    商品No</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    商品名</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    価格</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    在庫数</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    備考</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    備考</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                    在庫状況</th>
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
                                <tr v-for="item in searchedItems" :key="item.id" @click="showItem(item.id)">
                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ item.id }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ item.name }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ item.price }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ item.stocks }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ item.memo }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                        getItemStatus(item.isSelling) }}
                                    </td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">
                                        <!-- 　tr内の@clickへのpropagationの阻止　 -->
                                        <button @click.stop="deleteItem(item.id)"
                                            class="flex text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded">
                                            削除</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                        <Pagination :links=props.items></Pagination>
                    </div>
                    <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                        <Link as="button"
                            class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                            :href="route('items.create')">
                        商品登録</Link>
                    </div>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
