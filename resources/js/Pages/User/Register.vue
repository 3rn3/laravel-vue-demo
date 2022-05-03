<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import {computed, ref} from "vue";
import FormErrors from '@/Components/Demo/FormErrors.vue'
import FormSuccess from '@/Components/Demo/FormSuccess.vue';

const properties = defineProps({
    permissions: Object,
})

const permissions = computed(() => {
    return properties.permissions.data
})

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    permissions: []
});


let checkedPermissions = ref([]);
let errors = ref({});

let userRegisterSuccessfully = ref({
    isSuccess : false,
    successText: 'User Registered Successfully'
});

const submit = async () => {
    try
    {
        errors.value = {};
        userRegisterSuccessfully.value.isSuccess = false;

        form.permissions = checkedPermissions.value;

        let response = await axios.post(route('user.store'), form.data());

        userRegisterSuccessfully.value.isSuccess = true;
    }catch (error)
    {
        errors.value = error.response.data.errors;
    }

    checkedPermissions.value = [];

    form.reset('name', 'email', 'password', 'password_confirmation', 'permissions')
};

const permissionUniqueName = (permission) => {
  return permission.unique_name;
}

const permissionId = (permission) => {
    return permission.id;
}

const permissionDisplayName = (permission) => {
    return permission.display_name;
};


</script>

<template>
    <Head title="User Register" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Register User
            </h2>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <FormErrors :error-prop="errors" class="mb-4"></FormErrors>
                        <FormSuccess :success-prop="userRegisterSuccessfully"></FormSuccess>
                        <form @submit.prevent="submit">
                            <div>
                                <BreezeLabel for="name" value="Name" />
                                <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="email" value="Email" />
                                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="password" value="Password" />
                                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="password_confirmation" value="Confirm Password" />
                                <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                            </div>

                            <div class="mt-4"><strong> Check Permissions:</strong></div>

                            <div class="mt-4">
                                <template v-for="(permission, key) in permissions" :key="key">
                                    <input type="checkbox" :id="permissionUniqueName(permission)" :value="permissionId(permission)" v-model="checkedPermissions"
                                           class="ml-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <label class="ml-1" :for="permissionUniqueName(permission)"><strong>{{permissionDisplayName(permission)}}</strong></label>
                                </template>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Register
                                </BreezeButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </BreezeAuthenticatedLayout>
</template>
