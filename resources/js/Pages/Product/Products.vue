<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import ProductTable from '@/Components/Demo/ProductTable.vue';

const properties = defineProps({
    products: Object,
});

</script>

<template>
    <Head title="Products" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <ProductTable :products="properties.products.data"></ProductTable>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
