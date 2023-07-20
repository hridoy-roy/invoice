<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head,Link, useForm} from '@inertiajs/vue3';



</script>

<template>
    <Head title="Product List"/>

    <AuthenticatedLayout>
        <template #header class="">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product List</h2>
        </template>

        <div class=" flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <Link :href="route('products.create')"
                  class="underline text-xl text-green-600 hover:text-green-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
            >
                Create Product
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
                        <h3 class="text-xl px-4 font-semibold leading-6 text-gray-900">Title</h3>
                    </div>
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <h3 class="text-xl px-4 font-semibold leading-6 text-gray-900">Price</h3>
                    </div>
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <h3 class="text-xl px-4 font-semibold leading-6 text-gray-900">Action</h3>
                    </div>
                </li>
                <li class="flex justify-between gap-x-6 py-5 bg-red-50 p-2 m-2" v-for="product in $page.props.allProducts">
                    <div class="flex gap-x-4">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{{product.title}}</p>
                    </div>
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">{{product.price}}</p>
                    </div>
                    <div class="flex flex-col sm:items-end">
                        <Link :href="route('products.edit',{product:product.id})"
                            class="underline text-sm text-blue-600 hover:text-blue-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Edit
                        </Link>
                        <Link :href="route('products.destroy',{product:product.id})"
                              class="underline text-sm text-red-600 hover:text-red-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Delete
                        </Link>
                    </div>
                </li>
            </ul>

        </div>
    </AuthenticatedLayout>
</template>
