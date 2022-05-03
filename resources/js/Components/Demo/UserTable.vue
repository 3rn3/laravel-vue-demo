<script setup>
import BreezeNavLink from '@/Components/NavLink.vue';
import {computed} from 'vue';

const properties = defineProps({
    users: Object,
})

const userList = computed(() => {
    return properties.users;
});

</script>

<template>
    <table class="border-collapse border border-slate-400 w-full">
        <thead>
          <tr>
            <th class="border border-slate-300">Id</th>
            <th class="border border-slate-300">Name</th>
            <th class="border border-slate-300">Email</th>
            <th class="border border-slate-300">Actions</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(user, key) in userList" :key="key">
            <td class="border border-slate-300">{{ user.id }}</td>
            <td class="border border-slate-300">{{ user.name }}</td>
            <td class="border border-slate-300">{{ user.email }}</td>
            <td class="border border-slate-300">
                <BreezeNavLink :href="route('user.edit', user.id)">
                    Edit
                </BreezeNavLink>
            </td>
          </tr>
        </tbody>


    </table>
</template>

<style scoped>

</style>
