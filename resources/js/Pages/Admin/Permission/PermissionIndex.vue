<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';

import Table from '@/Components/Table.vue';
import TableRow from '@/Components/TableRow.vue';
import TableHeaderCell from '@/Components/TableHeaderCell.vue';
import TableDataCell from '@/Components/TableDataCell.vue';

defineProps(['permissions'])
</script>

<template>

    <Head title="Dashboard" />

    <AdminLayout>

        <div class="py-4 mx-auto max-w-7xl">
            <h1>Permissions Index Page</h1>
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
                            <TableDataCell>edit/delete</TableDataCell>
                        </TableRow>
                    </template>
                </Table>
            </div>
        </div>
    </AdminLayout>
</template>
