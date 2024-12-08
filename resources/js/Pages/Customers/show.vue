<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
// import { Link } from '@inertiajs/inertia-vue3';
// import ValidationErrors from '@/Components/ValidationErrors.vue';
import { computed, onMounted, reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BackToPreviousPageButton from '@/Components/BackToPreviousPageButton.vue';
import { Link } from '@inertiajs/inertia-vue3';
import configPref from '@/pref';

const props = defineProps({
    customer: Object
})

// const form = reactive({
//     name: null,
//     memo: null,
//     price: null
// })

// const editItem = (itemId) => {
//     Inertia.get(`/items/${itemId}/edit`)
// }

const formattedCustomers = computed(() => {
    // 例: "東京都新宿区西新宿2-8-1" の場合
    const match = props.customer.address.match(/^(.*?[都道府県])(.+?[市区町村])(.*)$/);
    return {
        prefecture: match ? match[1] : null, // 東京都
        city: match ? match[2] : null,      // 新宿区
        detail: match ? match[3] : null     // 西新宿2-8-1
    };
})

onMounted(() => {
    console.log(formattedCustomers);
})  

</script>

<template>

    <Head title="顧客詳細" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">顧客詳細</h2>
        </template>
        <!-- <ValidationErrors :errors="props.errors" /> -->
        <section class="text-gray-600 body-font relative">
            <BackToPreviousPageButton />
            <div class="container px-5 py-12 mx-auto">
                <div class="flex flex-col text-center w-full mb-12">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">顧客詳細</h1>
                </div>
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <!-- <form @submit.prevent="editItem(props.item.id)"> -->
                    <div class="flex flex-wrap justify-center  -m-2">
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="name" class="leading-7 text-sm text-gray-600">名前</label>
                                <input disabled type="text" name="name"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                    :value="props.customer.name">
                            </div>
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="" class="leading-7 text-sm text-gray-600">カナ</label>
                            <input disabled type="text" id="kana" name="kana"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                :value="props.customer.kana">
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                            <input disabled type="tel" id="tel" name="tel"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                :value="props.customer.tel">
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                            <input disabled type="email" id="email" name="email"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                :value="props.customer.email">
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="postcode" class="leading-7 text-sm text-gray-600">郵便番号</label>
                            <input disabled type="number" @input="fetchAddress(form.postcode)" id="postcode"
                                name="postcode"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                :value="props.customer.postcode">
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="postcode" class="leading-7 text-sm text-gray-600">都道府県</label>
                            <input disabled type="text" id="prefecture" name="prefecture"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                :value="formattedCustomers.prefecture">
                            <!-- <label for="prefecture" class="leading-7 text-sm text-gray-600">都道府県</label>
                                    <input type="text" v-model="form.prefecture" id="prefecture" name="prefecture"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"> -->
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="city" class="leading-7 text-sm text-gray-600">市町村</label>
                            <input disabled type="text" id="city" name="city"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                :value="formattedCustomers.city">
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="address" class="leading-7 text-sm text-gray-600">市町村以降の住所</label>
                            <input disabled type="text" id="address" name="address"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                :value="formattedCustomers.detail">
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="birthdy" class="leading-7 text-sm text-gray-600">生年月日</label>
                            <input disabled type="date" id="birthday" name="birthday"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                :value="props.customer.birthday">
                        </div>
                    </div>
                    <!-- <div class="flex flex-wrap justify-center -m-2"> -->
                    <div class="p-2 w-full">
                        <div class="relative w-[300px]">
                            <input disabled type="radio" id="men" name="men" :checked="props.customer.gender === 0"
                                :value=props.customer.gender>
                            <label for="men" class="leading-7 text-sm text-gray-600">男</label>

                            <input disabled type="radio" id="women" name="women" :checked="props.customer.gender === 1"
                                :value=props.customer.gender>
                            <label for="women" class="leading-7 text-sm text-gray-600">女</label>
                            <input disabled type="radio" id="others" name="others" :checked="props.customer.gender === 2"
                                :value=props.customer.gender>
                            <label for="others" class="leading-7 text-sm text-gray-600">その他</label>
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <div class="relative w-full">
                            <label for="memo" class="leading-7 text-sm text-gray-600">Memo</label>
                            <textarea disabled id="memo" name="memo"
                                class="w-full h-[100px] bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-6 transition-colors duration-200 ease-in-out"
                                :value="props.customer.memo"></textarea>
                        </div>
                    </div>
                </div>
                <div class="p-2 w-full">
                    <Link as="button" :href="route('customers.edit', props.customer.id)"
                        class="flex mx-auto mt-[10px] ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                    編集
                    </Link>
                </div>
                <!-- </form> -->
            </div>
        </section>

    </AuthenticatedLayout>
</template>
