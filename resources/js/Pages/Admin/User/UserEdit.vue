<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import VueMultiselect from 'vue-multiselect'

import Table from '@/Components/Table.vue';
import TableRow from '@/Components/TableRow.vue';
import TableHeaderCell from '@/Components/TableHeaderCell.vue';
import TableDataCell from '@/Components/TableDataCell.vue';
import { onMounted, watch } from 'vue';


const props = defineProps({
    user: { type: Object, required: true },
    roles: Array,
    permissions: Array,
});

const form = useForm({
    name: props.user?.name,
    email: props.user?.email,
    roles: [],
    permissions: []
});
const submit = () => {
    form.put(route('users.update', props.user?.id));
};
onMounted(() => {
    form.permissions = props.user?.permissions;
    form.roles = props.user?.roles;
});
watch(
    () => props.user,
    () => {
        form.permissions = props.user?.permissions,
            form.roles = props.user?.roles
    }
);

</script>

<template>

    <Head title="Create User" />

    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-between">
                <Link class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700"
                    :href="route('users.index')">
                back
                </Link>
            </div>
            <div class="max-w-6xl p-6 mx-auto mt-6 rounded-lg shadow-lg bg-slate-100">
                <h1 class="text-2xl font-semibold text-indigo-700 ">Update User</h1>
                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <InputLabel for="name" value="Name" />

                        <TextInput id="name" type="text" class="block w-full mt-1" v-model="form.name" required
                            autofocus autocomplete="name" />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="email" value="Email" />

                        <TextInput id="email" type="email" class="block w-full mt-1" v-model="form.email" required
                            autocomplete="username" />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="roles" value="Roles" />

                        <VueMultiselect v-model="form.roles" :options="roles" :multiple="true" :close-on-select="true"
                            placeholder="pick some" label="name" track-by="id" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="permissions" value="Permissions" />

                        <VueMultiselect v-model="form.permissions" :options="permissions" :multiple="true"
                            :close-on-select="true" placeholder="pick some" label="name" track-by="id" />
                    </div>


                    <div class="flex items-center justify-end mt-4">

                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Update
                        </PrimaryButton>
                    </div>
                </form>
            </div>
            <div class="max-w-6xl p-6 mx-auto mt-6 rounded-lg shadow-lg bg-slate-100">
                <h1 class="text-2xl font-semibold text-indigo-700 ">Roles</h1>

                <div class="mt-4 bg-white">
                    <Table>
                        <template #header>
                            <TableRow>
                                <TableHeaderCell>ID</TableHeaderCell>
                                <TableHeaderCell>Name</TableHeaderCell>
                                <TableHeaderCell>Action</TableHeaderCell>
                            </TableRow>
                        </template>

                        <template #default>
                            <TableRow v-for="UserRole in user.roles" :key="UserRole.id">
                                <TableDataCell>{{ UserRole.id }}</TableDataCell>
                                <TableDataCell>{{ UserRole.name }}</TableDataCell>
                                <TableDataCell class="space-x-4">
                                    <Link :href="route('users.roles.destroy', [user.id, UserRole.id])" method="DELETE"
                                        as="button" class="text-red-400 hover:text-red-600" preserve-scroll>
                                    Remove
                                    </Link>

                                </TableDataCell>
                            </TableRow>
                        </template>
                    </Table>
                </div>
            </div>
            <div class="max-w-6xl p-6 mx-auto mt-6 rounded-lg shadow-lg bg-slate-100">
                <h1 class="text-2xl font-semibold text-indigo-700 ">Permissions</h1>

                <div class="mt-4 bg-white">
                    <Table>
                        <template #header>
                            <TableRow>
                                <TableHeaderCell>ID</TableHeaderCell>
                                <TableHeaderCell>Name</TableHeaderCell>
                                <TableHeaderCell>Action</TableHeaderCell>
                            </TableRow>
                        </template>

                        <template #default>
                            <TableRow v-for="UserPermission in user.permissions" :key="UserPermission.id">
                                <TableDataCell>{{ UserPermission.id }}</TableDataCell>
                                <TableDataCell>{{ UserPermission.name }}</TableDataCell>
                                <TableDataCell class="space-x-4">
                                    <Link :href="route('users.permissions.destroy', [user.id, UserPermission.id])"
                                        method="DELETE" as="button" class="text-red-400 hover:text-red-600"
                                        preserve-scroll>
                                    Revoke
                                    </Link>

                                </TableDataCell>
                            </TableRow>
                        </template>
                    </Table>
                </div>
            </div>
        </div>


    </AdminLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
