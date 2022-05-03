<script setup>
import {computed} from 'vue';

const properties = defineProps({
    successProp: Object,
})

let isSuccess = computed(() => {
    return properties.successProp.isSuccess;
});

let successText = computed(() => {
    return properties.successProp.successText;
});

</script>

<template>
    <div v-if="isSuccess">
        <div class="font-medium text-green-600">{{ successText }}</div>
    </div>
</template>

<style scoped>

</style>
