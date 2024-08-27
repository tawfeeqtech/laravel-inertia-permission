<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Table from '@/Components/Table.vue';
import TableRow from '@/Components/TableRow.vue';
import TableHeaderCell from '@/Components/TableHeaderCell.vue';
import TableDataCell from '@/Components/TableDataCell.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';


defineProps(['permissions'])
const form = useForm({})
const showConfirmDeleteModal = ref(false)
const confirmDelete = () => {
    showConfirmDeleteModal.value = true;
};
const closeModal = () => {
    showConfirmDeleteModal.value = false;
};
const deletePermission = (id) => {
    form.delete(route('permissions.destroy', id), {
        onSuccess: () => closeModal()
    });
}
</script>

<template>

    <Head title="Permissions" />

    <AdminLayout>

        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-between">
                <h1>Permissions Index Page</h1>
                <Link class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700"
                    :href="route('permissions.create')">
                New Permission
                </Link>
            </div>

            <div class="mt-6">
                <Table>
                    <template #header>
                        <TableRow>
                            <TableHeaderCell>ID</TableHeaderCell>
                            <TableHeaderCell>Name</TableHeaderCell>
                            <TableHeaderCell>Action</TableHeaderCell>
                        </TableRow>
                    </template>

                    <template #default>
                        <TableRow v-for="permission in permissions" :key="permission.id">
                            <TableDataCell>{{ permission.id }}</TableDataCell>
                            <TableDataCell>{{ permission.name }}</TableDataCell>
                            <TableDataCell class="space-x-4">
                                <Link :href="route('permissions.edit', permission.id)"
                                    class="text-green-400 hover:text-green-600">
                                Edit
                                </Link>
                                <button @click="confirmDelete" class="text-red-400 hover:text-red-600">delete</button>
                                <Modal :show="showConfirmDeleteModal" @close="closeModal">
                                    <div class="p-6">
                                        <h2 class="text-lg font-semibold text-slate-800">
                                            Are you sure to delete this?
                                        </h2>
                                        <div class="flex mt-6 space-x-4">
                                            <DangerButton @click="$event => deletePermission(permission.id)">Delete
                                            </DangerButton>
                                            <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                        </div>
                                    </div>
                                </Modal>

                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
            </div>
        </div>
    </AdminLayout>
</template>
