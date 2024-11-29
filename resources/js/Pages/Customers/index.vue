<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import InfiniteLoading from "v3-infinite-loading";
import { computed, onMounted, reactive, ref, watch } from 'vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue';
import { isEmpty } from 'lodash';

const props = defineProps({
    customers: Object,
});

let search = ref('')

const searchCustomers = () => {
    Inertia.get(route('customers.index', { search: search.value }))
}

const searchedCustomers = computed(() => {
    if (isEmpty(search.value)) {
        return props.customers.data
    } else {
        const result = props.customers.data.filter(customer =>
            customer.name.includes(search.value) ||
            customer.kana.includes(search.value) ||
            customer.tel.includes(search.value)
        )
        return result
    }
}
)

onMounted(() => {
  console.log(props.customers.data)  
})

// const state = reactive({
//     customers: [...props.customers.data], // 初期データを設定
//     currentPage: props.customers.current_page, // 現在のページ番号
//     hasMore: props.customers.next_page_url !== null, // 次のページが存在するか
//     isLoading: false // ローディング中か
// });

// // データをロードする関数
// const loadData = async ($state) => {
//     // ローディング中でない、かつ次のページがある場合のみリクエストを送信
//     if (state.isLoading || !state.hasMore) {
//         $state.complete();
//         return;
//     }

//     state.isLoading = true;

//     try {
//         // 次のページのデータを取得
//         const response = await Inertia.get('/customers', {
//             page: state.currentPage + 1
//         }, {
//             only: ['customers'], // customersデータのみ取得
//             preserveState: true
//         });

//         // 取得したデータをリストに追加
//         const newCustomers = response.props.customers.data;
//         if (newCustomers.length > 0) {
//             state.customers.push(...newCustomers);
//             state.currentPage++;
//             state.hasMore = response.props.customers.next_page_url !== null; // 次ページがあるか
//             $state.loaded();
//         } else {
//             state.hasMore = false;
//             $state.complete(); // もうデータがない場合
//         }
//     } catch (error) {
//         console.error(error);
//         $state.error(); // エラーが発生した場合
//     } finally {
//         state.isLoading = false;
//     }
// };

</script>



<template>

    <Head title="顧客管理" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between gap-96">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">顧客管理</h2>
                <FlashMessage />
            </div>
        </template>
        <section class="text-gray-600 body-font">
            <div class="container px-5 mx-auto">
                <input type="text" name="search" v-model="search">
                <button class="bg-blue-300 text-white py-2 px-2" @click="searchCustomers">検索</button>
            </div>
            <div class="container px-5 mx-auto">
                <div class="lg:w-3/4 mx-auto overflow-auto">
                    <div class="relative">
                        <!-- Fixed Header -->
                        <table class="w-full text-left whitespace-no-wrap border-collapse table-fixed">
                            <thead>
                                <tr>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                        顧客No</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                        顧客名</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                        カナ</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                        電話番号</th>
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
                                    <!-- <tr v-for="customer in state.customers" :key="customer.id" @click="showCustomer(customer.id)"> -->
                                    <tr v-for="customer in searchedCustomers" :key="customer.id"
                                        @click="showCustomer(customer.id)">
                                        <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ customer.id }}</td>
                                        <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ customer.name }}
                                        </td>
                                        <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ customer.kana }}
                                        </td>
                                        <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ customer.tel }}
                                        </td>
                                        <td class="border-b-2 border-gray-200 px-4 py-3 truncate">
                                            <!-- 　tr内の@clickへのpropagationの阻止　 -->
                                            <button @click.stop="deleteCustomer(customer.id)"
                                                class="flex text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded">
                                                削除</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div>
                </div>
                <!-- <InfiniteLoading @infinite="loadData">
                    全件取得済み
                </InfiniteLoading> -->

                <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                    <Pagination :links=props.customers.links></Pagination>
                </div>
                <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">

                    <a class="text-indigo-500 inline-flex customers-center md:mb-2 lg:mb-0">Learn More
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <Link as="button"
                        class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                        :href="route('customers.create')">
                    顧客登録</Link>
                </div>
            </div>

        </section>
    </AuthenticatedLayout>
</template>
