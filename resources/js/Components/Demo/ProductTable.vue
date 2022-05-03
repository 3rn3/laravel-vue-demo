<script setup>
import BreezeNavLink from '@/Components/NavLink.vue';
import {computed} from 'vue';

const properties = defineProps({
    products: Object,
})

const productList = computed(() => {
    return properties.products;
});

</script>

<template>
    <table class="border-collapse border border-slate-400 w-full">
        <thead>
        <tr>
            <th class="border border-slate-300">Id</th>
            <th class="border border-slate-300">Name</th>
            <th class="border border-slate-300">Status</th>
            <th class="border border-slate-300">Price</th>
        </tr>
        </thead>

        <tbody>
        <tr v-for="(product, key) in productList" :key="key">
            <td class="border border-slate-300">{{ product.id }}</td>
            <td class="border border-slate-300">{{ product.name }}</td>
            <td class="border border-slate-300">{{ product.status_name }}</td>
            <td class="border border-slate-300">$ {{ parseFloat(product.price).toFixed(2) }}</td>
        </tr>
        </tbody>


    </table>
</template>

<style scoped>

</style>
