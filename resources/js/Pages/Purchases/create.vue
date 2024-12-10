<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import { computed, onMounted, reactive, ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BackToPreviousPageButton from '@/Components/BackToPreviousPageButton.vue';
import Pagination from '@/Components/Pagination.vue';
import { getToday } from '@/common';
import MicroModal from '@/Components/MicroModal.vue';
import { isEmpty } from 'lodash';

const props = defineProps({
    errors: Object,
    customers: Object,
    items: Object
})

const form = reactive({
    date: null,
    status: true,
    customer_id: null,
    items: props.items.data.map(item => ({
        id: item.id,
        quantity: 0
    }))
})

const isShow = ref(false);

// const openModal = () => {
//     isShow.value = true
// }

const selectedCustomer = reactive({
    name: ''
})

// const setCustomerId = (selectedCustomerId) => {
//     form.customer_id = selectedCustomerId
//     selectedCustomer.value = props.customers.find(customer => customer.id === selectedCustomerId) || {};;
// }

const matchedCustomers = computed(() => {
    if (!selectedCustomer || !selectedCustomer.name) {
        return [];
    }
    return props.customers.filter(customer => customer.name.includes(selectedCustomer.name))
})

const openSearchBox = ref(false);

const closeModal = () => {
    openSearchBox.value = false
}
// const onClickOutside = () => {
//     openSearchBox.value = false
// }

const setCustomer = (customerId, customerName) => {
    form.customer_id = customerId;
    selectedCustomer.name = customerName;
    openSearchBox.value = false;
}

watch(matchedCustomers, (newVal) => {
    openSearchBox.value = newVal.length > 0;
})

let search = ref('')

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

const storePurchase = () => {
    Inertia.post('/purchases', form);
};



const purchase_num_arr = computed(() => {
    return props.items.data.map(item => Array.from({ length: item.stocks + 1 }, (_, i) => i));
});

const total_price_per_product = computed(() => {
    return props.items.data.map((item, index) => {
        const quantity = form.items[index].quantity || 0;
        return item.price * quantity;
    });
});

const total_price_all_products = computed(() => {
    return props.items.data.reduce((sum, item, index) => {
        const quantity = form.items[index].quantity || 0;
        return sum + item.price * quantity;
    }, 0);
});

watch(form.items, (newVal) => {
    newVal.forEach((item, index) => {
        if (form.items[index].quantity !== null) {
            form.items[index].quantity = item.quantity; // 変更があれば代入
        }
    })
    console.log(form.items);
}
);

onMounted(() => {
    form.date = getToday()
    console.log(props.items)
})


</script>

<template>

    <Head title="顧客登録" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">購入画面</h2>
        </template>
        <ValidationErrors :errors="props.errors" />
        <section class="text-gray-600 body-font relative h-full">
            <BackToPreviousPageButton />
            <div class="container px-5 mx-auto">
                <div class="flex flex-col text-center w-full mb-12">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">商品購入画面</h1>
                    <p class="lg:w-2/3 mx-auto leading-relaxed text-base">購入する商品の情報を入力してください</p>
                </div>
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <form @submit.prevent="storePurchase">
                        <div class="flex flex-wrap justify-center  -m-2">
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                                    <input type="date" v-model="form.date" id="date" name="date"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">顧客名</label>
                                    <input id="prefecture" name="prefecture"
                                        class="w-full h-[42px] bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                        v-model="selectedCustomer.name">
                                    <div v-if="openSearchBox" v-click-outside="closeModal"
                                        class="absolute z-30 w-[150px] h-[250px] overflow-y-scroll bg-white border border-gray-300 rounded shadow-md">
                                        <div v-for="customer in matchedCustomers" :key="customer.id"
                                            class="p-2 hover:bg-gray-200 cursor-pointe"
                                            @click.stop="setCustomer(customer.id, customer.name)">
                                            {{ customer.name }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="p-2 w-full z-20">
                                <div class="relative">
                                    <input type="text" name="search" v-model="search">
                                    <button class="bg-blue-300 text-white py-2 px-2 mx-4"
                                        @click="searchItems">検索</button>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
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
                                </div>
                                <div class="overflow-y-scroll h-[350px]">
                                    <table class="w-full text-left whitespace-no-wrap border-collapse table-fixed">
                                        <tbody>
                                            <tr v-for="(item, index) in searchedItems" :key="item.id">
                                                <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                    item.id
                                                    }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                    item.name }}
                                                </td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                    item.price }}
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
                                                    <!-- {{ form.items[index].quantity != null ? item.price * form.items[index].quantity : 0 }} -->
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <!-- <div class="relative"> -->
                                <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                                    <Pagination :links=props.items.links></Pagination>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    合計金額 {{ total_price_all_products }}
                                </div>
                            </div>
                            <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                                <button type="submit"
                                    class="flex mx-auto ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                    登録する</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </section>

    </AuthenticatedLayout>
</template>
