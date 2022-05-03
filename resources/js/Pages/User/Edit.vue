<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import {computed, ref, onMounted} from "vue";
import FormErrors from '@/Components/Demo/FormErrors.vue'
import FormSuccess from '@/Components/Demo/FormSuccess.vue';

const properties = defineProps({
    user: Object,
    user_permissions: Object,
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

const checkedPermissions = ref([]);

let updateNameErrors = ref({});
let updateEmailErrors = ref({});
let updatePasswordErrors = ref({});
let updatePermissionsErrors = ref({});

let nameUpdatedSuccessfully = ref({
    isSuccess : false,
    successText: 'User Name Updated Successfully'
});

let emailUpdatedSuccessfully = ref({
    isSuccess : false,
    successText: 'User Email Updated Successfully'
});

let passwordUpdatedSuccessfully = ref({
    isSuccess : false,
    successText: 'User Password Updated Successfully'
});

let permissionsUpdatedSuccessfully = ref({
    isSuccess : false,
    successText: 'User Permissions Updated Successfully'
});

const defaultUserPermissionsChecked = computed(() => {
    let checked = [];

    properties.user_permissions.data.forEach(function (permission) {
        checked.push(permission.id);
    });

    return checked;
})

const userId = computed(() => {
    return properties.user.data.id;
});

onMounted(() => {
    checkedPermissions.value = defaultUserPermissionsChecked.value
    form.name = properties.user.data.name;
    form.email = properties.user.data.email;
});

const submit = () => {
    updateName();
    updateEmail();
    updatePassword();
    updatePermissions();
};

const updateName = async () => {
    try
    {
        updateNameErrors.value = {};
        nameUpdatedSuccessfully.value.isSuccess = false;

        let response = await axios.put(route('user.update.name', userId.value), form.data());

        nameUpdatedSuccessfully.value.isSuccess = true;
    }catch (error)
    {
        updateNameErrors.value = error.response.data.errors;
    }
};

const updateEmail = async () => {
    try
    {
        updateEmailErrors.value = {};
        emailUpdatedSuccessfully.value.isSuccess = false;

        let response = await axios.put(route('user.update.email', userId.value), form.data());

        emailUpdatedSuccessfully.value.isSuccess = true;
    }catch (error)
    {
        updateEmailErrors.value = error.response.data.errors;
    }
};

const updatePassword = async () => {
    if (form.password !== '') {
        try
        {
            updatePasswordErrors.value = {};
            passwordUpdatedSuccessfully.value.isSuccess = false;

            let response = await axios.put(route('user.update.password', userId.value), form.data());

            passwordUpdatedSuccessfully.value.isSuccess = true;
        }catch (error)
        {
            updatePasswordErrors.value = error.response.data.errors;
        }
    }
};

const updatePermissions = async () => {
    try
    {
        updatePermissionsErrors.value = {};
        permissionsUpdatedSuccessfully.value.isSuccess = false;

        form.permissions = checkedPermissions.value;

        let response = await axios.put(route('user.update.permission', userId.value), form.data());

        permissionsUpdatedSuccessfully.value.isSuccess = true;
    }catch (error)
    {
        updatePermissionsErrors.value = error.response.data.errors;
    }
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
                User Edit
            </h2>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <FormErrors :error-prop="updateNameErrors" class="mb-4"></FormErrors>
                        <FormErrors :error-prop="updateEmailErrors" class="mb-4"></FormErrors>
                        <FormErrors :error-prop="updatePasswordErrors" class="mb-4"></FormErrors>
                        <FormErrors :error-prop="updatePermissionsErrors" class="mb-4"></FormErrors>

                        <FormSuccess :success-prop="nameUpdatedSuccessfully"></FormSuccess>
                        <FormSuccess :success-prop="emailUpdatedSuccessfully"></FormSuccess>
                        <FormSuccess :success-prop="passwordUpdatedSuccessfully"></FormSuccess>
                        <FormSuccess :success-prop="permissionsUpdatedSuccessfully"></FormSuccess>

                        <form @submit.prevent="submit">
                            <div>
                                <BreezeLabel for="name" value="Name" />
                                <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus autocomplete="name" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="email" value="Email" />
                                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" autocomplete="username" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="password" value="Password" />
                                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" autocomplete="new-password" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="password_confirmation" value="Confirm Password" />
                                <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" />
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
                                    Update
                                </BreezeButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </BreezeAuthenticatedLayout>
</template>
