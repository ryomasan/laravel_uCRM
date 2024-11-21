<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/inertia-vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';



const props = defineProps({
    items: Object
})

const getItemStatus = (isSelling) => {
    return computed(() => {
        return isSelling === 0 ? '販売中' : '在庫切れ';
    });
}

// const getItemStatus = computed((isSelling) => {
//     return isSelling == 0 ? '在庫切れ' : '販売中'
// }



const showItem = (itemId) => {
    Inertia.get(`/items/${itemId}`);
}

const deleteItem = (itemId) => {
    Inertia.delete(`/items/${itemId}`, {
        onBefore: () => confirm("本当に削除しますか？"),
    });
}

</script>

<template>

    <Head title="商品管理" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between gap-96">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品管理</h2>
                <FlashMessage />
            </div>
        </template>
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-24 mx-auto">
                <div class="lg:w-3/4 mx-auto overflow-auto">
                    <div class="relative">
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
                                        備考</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                        価格</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                        在庫</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                        在庫</th>
                                </tr>
                            </thead>
                        </table>

                        <!-- Scrollable Body -->
                        <div class="overflow-y-scroll h-[350px]">
                            <table class="w-full text-left whitespace-no-wrap border-collapse table-fixed">
                                <tbody>
                                    <tr v-for="item in props.items" :key="item.id" @click="showItem(item.id)">
                                        <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ item.id }}</td>
                                        <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ item.name }}</td>
                                        <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ item.memo }}</td>
                                        <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{ item.price }}</td>
                                        <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                            getItemStatus(item.is_selling) }}</td>
                                        <!-- <td v-if="item.is_selling === 0"
                                            class="border-b-2 border-gray-200 px-4 py-3 truncate">
                                            販売中</td>
                                        <td v-if="item.is_selling === 1"
                                            class="border-b-2 border-gray-200 px-4 py-3 truncate">
                                            在庫切れ</td> -->
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
                    </div>
                </div>
                <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                    <a class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">Learn More
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <Link as="button"
                        class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                        :href="route('items.create')">
                    商品登録</Link>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
