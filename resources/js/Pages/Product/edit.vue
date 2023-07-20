<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SuccessButton from "@/Components/SuccessButton.vue";
import TextInput from '@/Components/TextInput.vue';
import {Head, useForm,usePage} from '@inertiajs/vue3';

const page = usePage()

const form = useForm({
    title: page.props.product.title,
    price: page.props.product.price,
});

const submit = () => {
    form.put(route('products.update',{product: page.props.product.id}), {
        onFinish: () => form.reset('title', 'price'),
    });
};

</script>

<template>
    <Head title="Product Edit"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product Edit</h2>
        </template>

        <div class=" flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">

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

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">


                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="title" value="Title"/>

                        <TextInput
                            id="title"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.title"
                            required
                            autofocus
                            autocomplete="title"
                        />

                        <InputError class="mt-2" :message="form.errors.title"/>
                    </div>

                    <div class="mt-4">
                        <InputLabel for="price" value="Price"/>

                        <TextInput
                            id="price"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.price"
                            required
                            autocomplete="price"
                        />

                        <InputError class="mt-2" :message="form.errors.price"/>
                    </div>


                    <div class="flex items-center justify-end mt-4">
                        <SuccessButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                       :disabled="form.processing">
                            Update
                        </SuccessButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
