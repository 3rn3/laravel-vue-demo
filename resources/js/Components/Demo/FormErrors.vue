<script setup>
import {computed} from 'vue';

const properties = defineProps({
    errorProp: Object,
})

let errorList = computed( () => {
    let errors = [];
    const keys = Object.keys(properties.errorProp);

    keys.forEach(function (element, index) {
        properties.errorProp[element].forEach(function (errorMessage) {
            errors.push(errorMessage);
        })
    })

    return errors;
});

let hasError = computed( () => {
    return errorList.value.length;
});

</script>

<template>
    <div v-if="hasError">
        <div class="font-medium text-red-600">Whoops! Something went wrong.</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            <li v-for="(error, key) in errorList" :key="key">{{ error }}</li>
        </ul>
    </div>
</template>

<style scoped>

</style>
