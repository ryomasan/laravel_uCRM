<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
// import { Link } from '@inertiajs/inertia-vue3';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import { computed, onMounted, reactive, watch } from 'vue'
import jsonpAdapter from 'axios-jsonp'
import { Inertia } from '@inertiajs/inertia'
import BackToPreviousPageButton from '@/Components/BackToPreviousPageButton.vue';
import configPref from '@/pref';

const props = defineProps({
    errors: Object,
    customer: Object
})

const formattedCustomers = computed(() => {
    // 例: "東京都新宿区西新宿2-8-1" の場合
    const match = props.customer.address.match(/^(.*?[都道府県])(.+?[市区町村])(.*)$/);
    return {
        prefecture: match ? match[1] : null, // 東京都
        city: match ? match[2] : null,      // 新宿区
        detail: match ? match[3] : null     // 西新宿2-8-1
    };
})

const form = reactive({
    name: props.customer.name,
    kana: props.customer.kana,
    tel: props.customer.tel,
    email: props.customer.email,
    postcode: props.customer.postcode,
    birthday: props.customer.birthday,
    prefecture: formattedCustomers.value.prefecture,
    city: formattedCustomers.value.city,
    address: formattedCustomers.value.detail,
    gender: props.customer.gender,
    memo: props.customer.memo
})

const fetchAddress = async (inputZipCode) => {
    if (inputZipCode.toString().length === 7) {
        console.log(inputZipCode.toString().length)
        await axios.get(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${inputZipCode}`, {
            adapter: jsonpAdapter
        }).then((response) => {
            const { address1, address2, address3 } = response.data.results[0];
            form.prefecture = address1
            form.city = address2
            form.address = address3
        }).catch((err) => {
            console.log('error', err)
        });
    }
}

watch(form, (newVal)=>{
    console.log(newVal);
})

const updateCustomer = (customerId) => {
    Inertia.put(route('customers.update', customerId), form, {
        onError: (errors) => console.error(errors)
    })
}

onMounted(() => {
    console.log(formattedCustomers)
})


</script>

<template>

    <Head title="顧客編集" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">顧客編集</h2>
        </template>
        <ValidationErrors :errors="props.errors" />
        <section class="text-gray-600 body-font relative">
            <BackToPreviousPageButton />
            <div class="container px-5 mx-auto">
                <div class="flex flex-col text-center w-full mb-12">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">顧客編集画面</h1>
                    <p class="lg:w-2/3 mx-auto leading-relaxed text-base">顧客情報を編集してください</p>
                </div>
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <form @submit.prevent=updateCustomer(props.customer.id)>
                        <div class="flex flex-wrap justify-center  -m-2">
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600"></label>
                                    <input type="text" v-model="form.name" name="name"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="kana" class="leading-7 text-sm text-gray-600">カナ</label>                                
                                    <input type="text" v-model="form.kana"  id="kana" name="kana"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">                                
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                                    <input type="tel" v-model="form.tel" id="tel" name="tel"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                                    <input type="email" v-model="form.email" id="email" name="email"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="postcode" class="leading-7 text-sm text-gray-600">郵便番号</label>
                                    <input type="number" v-model="form.postcode" @input="fetchAddress(form.postcode)"
                                        id="postcode" name="postcode"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="postcode" class="leading-7 text-sm text-gray-600">都道府県</label>
                                    <select v-model="form.prefecture" id="prefecture" name="prefecture" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <option disabled value="">都道府県</option>
                                        <option v-for="pref in configPref.display" :key="pref.id" :value="pref.text">
                                            {{ pref.text }}</option>
                                    </select>
                                    <!-- <label for="prefecture" class="leading-7 text-sm text-gray-600">都道府県</label>
                                    <input type="text" v-model="form.prefecture" id="prefecture" name="prefecture"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"> -->
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="city" class="leading-7 text-sm text-gray-600">市町村</label>
                                    <input type="text" v-model="form.city" id="city" name="city"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="address" class="leading-7 text-sm text-gray-600">市町村以降の住所</label>
                                    <input type="text" v-model="form.address" id="address" name="address"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="birthdy" class="leading-7 text-sm text-gray-600">生年月日</label>
                                    <input type="date" v-model="form.birthday" id="birthday" name="birthday"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <!-- <div class="flex flex-wrap justify-center -m-2"> -->
                            <div class="p-2 w-full">
                                <div class="relative w-[300px]">
                                    <input type="radio" id="men" v-model="form.gender" name="men" :value=0>
                                    <label for="men" class="leading-7 text-sm text-gray-600"
                                        :checked="form.gender === 0">男</label>
                                    <input type="radio" id="women" v-model="form.gender" :checked="form.gender === 1"
                                        name="women" :value=1>
                                    <label for="women" class="leading-7 text-sm text-gray-600">女</label>
                                    <input type="radio" id="others" v-model="form.gender" :checked="form.gender === 2"
                                        name="others" :value=2>
                                    <label for="others" class="leading-7 text-sm text-gray-600">その他</label>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative w-full">
                                    <label for="memo" class="leading-7 text-sm text-gray-600">Memo</label>
                                    <textarea id="memo" v-model="form.memo" name="memo"
                                        class="w-full h-[100px] bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- </div> -->
                        <div class="p-2 w-full">
                            <button type="submit"
                                class="flex mx-auto ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                更新
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </AuthenticatedLayout>
</template>
