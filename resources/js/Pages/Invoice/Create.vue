<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SuccessButton from "@/Components/SuccessButton.vue";
import TextInput from '@/Components/TextInput.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import {ref} from "vue";
import axios from "axios";

const form = useForm({
    invoice_no: usePage().props.invoice_no,
    customer_email: '',
    date: '',
    due_date: '',
    product_id: [],
    price: [],
    quantity: [],
    rowTotal: [],
    comment: '',
    subtotal: 0,
    discount: 0,
    tax: 0,
    total: 0,
});

const row = ref(['']);

const submit = () => {
    form.post(route('invoice.store'), {
        onSuccess: () => form.reset(),
    });
};

function addNewRow() {
    row.value.push('');
}

function deleteRow(index) {
    this.row.splice(index, 1);
    form.product_id.splice(index, 1);
    form.price.splice(index, 1);
    form.quantity.splice(index, 1);
    form.rowTotal.splice(index, 1);
    form.subtotal = 0
    form.total = 0
    form.rowTotal.forEach(item => {
        form.subtotal = form.subtotal + item;
        form.total = form.total + item;
    });

}


function getProductInfo(index) {


    if (form.product_id[index]) {

        axios.get(route('invoice.product', form.product_id[index])).then((response) => {
            form.price[index] = response.data.price;
            form.quantity[index] = (form.quantity[index] != null ? form.quantity[index] : 1);
            form.rowTotal[index] = response.data.price * form.quantity[index];
            form.subtotal = 0
            form.total = 0
            form.rowTotal.forEach(item => {
                form.subtotal = form.subtotal + item;
                form.total = form.total + item;
            });
        })
    }

}

function getProductPrice(index) {
    form.rowTotal[index] = form.price[index] * (form.quantity[index] != null ? form.quantity[index] : 1)
    form.subtotal = 0
    form.total = 0
    form.rowTotal.forEach(item => {
        form.subtotal = form.subtotal + item;
        form.total = form.total + item;
    });
}

function getProductQuantity(index) {
    form.rowTotal[index] = form.price[index] * (form.quantity[index] != null ? form.quantity[index] : 1)
    form.subtotal = 0
    form.total = 0
    form.rowTotal.forEach(item => {
        form.subtotal = form.subtotal + item;
        form.total = form.total + item;
    });
}


</script>

<template>
    <Head title="Invoice Create"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoice Create</h2>
        </template>
        <!-- flash message start -->
        <div
            v-if="$page.props.flash.message"
            class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
            role="alert"
        >
                    <span class="font-medium">
                        {{ $page.props.flash.message }}
                    </span>
        </div>
        <!-- flash message end -->

        <div class="container mx-auto p-12">
            <form @submit.prevent="submit">
                <div class="flex flex-row my-6">
                    <div class="basis-1/2 text-xl font-bold">LOGO</div>
                    <div class="basis-1/2 text-right text-xl font-bold">INVOICE #{{$page.props.invoice_no}}</div>
                </div>
                <div class="flex flex-row my-6">
                    <div class="basis-1/4 text-xl font-bold">
                        <div>
                            <InputLabel for="customer_email" value="Customer Email"/>

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.customer_email"
                                required
                                autofocus
                                autocomplete="email"
                            />

                            <InputError class="mt-2" :message="form.errors.customer_email"/>
                        </div>
                    </div>
                    <div class="basis-1/2 text-xl font-bold"></div>
                    <div class="basis-1/4 text-center text-xl font-bold">
                        <div>
                            <InputLabel for="date" value="Date"/>

                            <TextInput
                                id="date"
                                type="date"
                                class="mt-1 block w-full"
                                v-model="form.date"
                                required
                                autofocus
                                autocomplete="date"
                            />

                            <InputError class="mt-2" :message="form.errors.date"/>
                        </div>
                        <div>
                            <InputLabel for="due_date" value="Due Date"/>

                            <TextInput
                                id="due_date"
                                type="date"
                                class="mt-1 block w-full"
                                v-model="form.due_date"
                                required
                                autofocus
                                autocomplete="due_date"
                            />

                            <InputError class="mt-2" :message="form.errors.due_date"/>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row">
                    <div class="basis-1/2">
                        <h1 class="text-lg font-black font-bold text-green-800">Billed From</h1>
                        <h2 class="text-sm">Hridoy Roy</h2>
                        <address class="text-sm">Dhaka, Bangladesh</address>
                        <p class="text-sm">hridoy@mail.com</p>
                        <p class="text-sm">PHONE:01888555666</p>
                    </div>
                    <div class="basis-1/2 text-right text-xl font-bold ">
                        <h1 class="text-lg font-black font-bold text-red-800">Billed To</h1>
                        <h2 class="text-sm">Hridoy Roy</h2>
                        <address class="text-sm">Dhaka, Bangladesh</address>
                        <p class="text-sm">hridoy@mail.com</p>
                        <p class="text-sm">PHONE:01888555666</p>
                    </div>
                </div>
                <div class="grid grid-cols-5 gap-4 mt-6">
                    <div class="col-span-2 text-xl font-bold">Product Name</div>
                    <div class=" text-center text-xl font-bold">Price</div>
                    <div class=" text-center text-xl font-bold">Quantity</div>
                    <div class=" text-center text-xl font-bold">Total</div>
                </div>
                <div class="grid grid-cols-5 gap-4 mt-6" v-for="(item, index) in row">
                    <div class="col-span-2">
                        <select v-model="form.product_id[index]" @change="getProductInfo(index)"
                                class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected>Choose a Product</option>
                            <option v-for="item in $page.props.allProducts" :value="item.id">{{ item.title }}</option>
                        </select>
                    </div>
                    <div class="">
                        <TextInput
                            :id="'price'+index"
                            @change="getProductPrice(index)"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.price[index]"
                            :key="index"
                            required
                            autofocus
                            autocomplete="price"
                        />
                    </div>
                    <div class="">
                        <TextInput
                            id="quantity"
                            @change="getProductQuantity(index)"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.quantity[index]"
                            :key="index"
                            required
                            autofocus
                            autocomplete="quantity"
                        />
                    </div>
                    <div class="text-right">
                        {{ form.rowTotal[index] }}TK

                        <span @click="deleteRow(index)"
                                class="inline-flex items-center px-1 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            X
                        </span>
                    </div>
                </div>
                <span @click="addNewRow()"
                        class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                    Add New
                </span>
                <div class="grid grid-cols-4 gap-4 mt-6">
                    <div class="col-span-2 text-xl font-bold">
                    <textarea v-model="form.comment" id="comment" rows="4"
                              class="w-full px-0 text-sm text-gray-900 bg-white border-0  focus:ring-0 border-gray-300 dark:placeholder-gray-400"
                              placeholder="Write a comment..."></textarea>
                    </div>

                    <div class="  text-right">
                        <h3 class=" text-lg font-bold">Subtotal :</h3>
                        <h3 class=" text-lg font-bold">Discount :</h3>
                        <h3 class=" text-lg font-bold">Tax :</h3>
                        <h3 class=" text-lg font-bold">Total :</h3>
                    </div>
                    <div class=" text-xl font-bold">
                        <h3 class=" text-lg font-bold">{{ form.subtotal }}TK</h3>
                        <h3 class=" text-lg font-bold">{{ form.discount }}TK</h3>
                        <h3 class=" text-lg font-bold">{{ form.tax }}TK</h3>
                        <h3 class=" text-lg font-bold">{{ form.total }}TK</h3>
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <SuccessButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                   :disabled="form.processing">
                        Create
                    </SuccessButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
