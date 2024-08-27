<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import VueMultiselect from 'vue-multiselect'

import Table from '@/Components/Table.vue';
import TableRow from '@/Components/TableRow.vue';
import TableHeaderCell from '@/Components/TableHeaderCell.vue';
import TableDataCell from '@/Components/TableDataCell.vue';


import TextInput from '@/Components/TextInput.vue';
import { onMounted, watch } from 'vue';

const props = defineProps({
    role: { type: Object, required: true },
    permissions: Array
});

const form = useForm({
    name: props.role.name,
    permissions: []
});

onMounted(() => {
    form.permissions = props.role?.permissions;
});
watch(
    () => props.role,
    () => (form.permissions = props.role?.permissions)
);

</script>

<template>

    <Head title="Edit Role" />

    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-between">
                <Link class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700"
                    :href="route('roles.index')">
                back
                </Link>
            </div>
            <div class="max-w-6xl p-6 mx-auto mt-6 rounded-lg shadow-lg bg-slate-100">
                <h1 class="text-2xl font-semibold text-indigo-700 ">Update Role</h1>
                <form @submit.prevent="form.put(route('roles.update', role.id))">
                    <div class="mt-4">
                        <InputLabel for="name" value="Name" />

                        <TextInput id="name" type="text" class="block w-full mt-1" v-model="form.name" autofocus />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="permissions" value="Permissions" />

                        <VueMultiselect v-model="form.permissions" :options="permissions" :multiple="true"
                            :close-on-select="true" placeholder="pick some" label="name" track-by="id" />
                    </div>
                    <div class="flex items-center mt-4">
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Update
                        </PrimaryButton>
                    </div>
                </form>
            </div>
            <div class="max-w-6xl p-6 mx-auto mt-6 rounded-lg shadow-lg bg-slate-100">
                <h1 class="text-2xl font-semibold text-indigo-700 ">Permission</h1>

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
                            <TableRow v-for="rolePermisson in role.permissions" :key="rolePermisson.id">
                                <TableDataCell>{{ rolePermisson.id }}</TableDataCell>
                                <TableDataCell>{{ rolePermisson.name }}</TableDataCell>
                                <TableDataCell class="space-x-4">
                                    <Link :href="route('roles.permissions.destroy', [role.id, rolePermisson.id])"
                                        method="DELETE" as="button" class="text-red-400 hover:text-red-600">
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
