<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head,Link} from '@inertiajs/vue3';


</script>

<template>
    <Head title="Invoice List"/>

    <AuthenticatedLayout>
        <template #header class="">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoice List</h2>
        </template>

        <div class=" flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <Link :href="route('invoice.create')"
                  class="underline text-xl text-green-600 hover:text-green-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
            >
                Create Invoice
            </Link>

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
            <ul role="list" class="divide-y divide-gray-100">
                <li class="flex justify-between  py-1">
                    <div class="flex gap-x-4">
                        <h3 class="text-xl px-4 font-semibold leading-6 text-gray-900">Invoice No</h3>
                    </div>
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <h3 class="text-xl px-4 font-semibold leading-6 text-gray-900">Date</h3>
                    </div>
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <h3 class="text-xl px-4 font-semibold leading-6 text-gray-900">Total</h3>
                    </div>
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <h3 class="text-xl px-4 font-semibold leading-6 text-gray-900">Product Name </h3>
                    </div>
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <h3 class="text-xl px-4 font-semibold leading-6 text-gray-900">Print</h3>
                    </div>
                </li>
                <li class="flex justify-between gap-x-6 py-5 bg-red-50 p-2 m-2" v-for="invoice in $page.props.allInvoice">
                    <div class="flex gap-x-4">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{{invoice.invoice_no}}</p>
                    </div>
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">{{invoice.date}}</p>
                    </div>
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">{{invoice.total}}</p>
                    </div>
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900" v-for="invoice_details in invoice.invoice_details">{{invoice_details.product.title}}</p>
                    </div>
                    <Link :href="route('invoice.print',{invoice:invoice.id})" target="_blank"
                          class="underline text-xl text-red-600 hover:text-red-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                    >
                        Print Invoice
                    </Link>
                </li>
            </ul>

        </div>
    </AuthenticatedLayout>
</template>
