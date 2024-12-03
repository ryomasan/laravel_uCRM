<script setup>
import axios from 'axios';
import { isEmpty } from 'lodash';
import { computed, onMounted, reactive, ref } from 'vue'
import Pagination from './Pagination.vue';

const isShow = ref(false)
const toggleStatus = () => { isShow.value = !isShow.value }


let search = ref('')
let customers = reactive({})

const props = defineProps({
    customers: Object
})

const emits = defineEmits(['update:customerId'])

const searchedCustomers = computed(() => {
    if (isEmpty(search.value)) {
        return props.customers
    } else {
        const result = props.customers.filter(customer =>
            customer.name.includes(search.value) ||
            customer.kana.includes(search.value) ||
            customer.tel.includes(search.value)
        )
        return result
    }
}
)

const searchCustomers = () => {
    const customers = axios.get(`/api/searchCustomers?search=${search}`)
        .then(res => {
            console.log(res);
            // res.data.forEach(element => {
            //     element.push(customers);
            // })
        });
    console.log(customers);
}

const selectCustomer = (selectedCustomerId) => {
    emits("update:customerId", selectedCustomerId)
    isShow.value = false
}

onMounted(() => {
    console.log(props.customers)
    //     const customers = axios.get(`/api/searchCustomers?search=${search}`)
    //         .then(res => {
    //             console.log(res);
    //             // res.data.forEach(element => {
    //             //     element.push(customers);
    //             // })
    //         });
    //     console.log(customers);
})

</script>

<template>
    <div v-if="isShow" class="modal" id="modal-1" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container w-2/3" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-1-title">
                        Micromodal
                    </h2>
                    <button @click="toggleStatus" class="modal__close" aria-label="Close modal"
                        data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-1-content">
                    <!-- Scrollable Body -->
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 mx-auto">
                            <div class="lg:w-3/4 mx-auto overflow-auto">
                                <!-- <div class="relative"> -->
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
                                                <tr v-for="customer in searchedCustomers" :key="customer.id">
                                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                        customer.id }}</td>
                                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                        customer.name }}
                                                    </td>
                                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                        customer.kana }}
                                                    </td>
                                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">{{
                                                        customer.tel }}
                                                    </td>
                                                    <td class="border-b-2 border-gray-200 px-4 py-3 truncate">
                                                        <!-- 　tr内の@clickへのpropagationの阻止　 -->
                                                        <button @click.prevent="selectCustomer(customer.id)"
                                                            class="flex text-white bg-blue-500 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 rounded">
                                                            選択</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                <!-- </div> -->
                            </div>
                        </div>
                    </section>
                </main>
                <footer class="modal__footer">
                    <button @click="toggleStatus" type="button" class="modal__btn modal__btn-primary">Continue</button>
                    <button @click="toggleStatus" type="button" class="modal__btn" data-micromodal-close
                        aria-label="Close this dialog window">Close</button>
                </footer>
            </div>
        </div>
    </div>
</template>