<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { usePermission } from '@/composables/permissions';
import { ref } from 'vue';
import Table from '@/Components/Table.vue';
import TableRow from '@/Components/TableRow.vue';
import TableHeaderCell from '@/Components/TableHeaderCell.vue';
import TableDataCell from '@/Components/TableDataCell.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps(['posts'])
const { hasPermission } = usePermission();
const form = useForm({})
const showConfirmDeleteModal = ref(false)
const confirmDelete = () => {
    showConfirmDeleteModal.value = true;
};
const closeModal = () => {
    showConfirmDeleteModal.value = false;
};
const deletePost = (id) => {
    form.delete(route('posts.destroy', id), {
        onSuccess: () => closeModal()
    });
}
</script>

<template>

    <Head title="Dashboard" />

    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-between">
                <h1>Posts Index Page</h1>
                <template v-if="hasPermission('create post')">
                    <Link class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700"
                        :href="route('posts.create')">
                    New Post
                    </Link>
                </template>
            </div>
            <div class="mt-6">
                <Table>
                    <template #header>
                        <TableRow>
                            <TableHeaderCell>ID</TableHeaderCell>
                            <TableHeaderCell>img</TableHeaderCell>
                            <TableHeaderCell>Title</TableHeaderCell>
                            <TableHeaderCell>Author</TableHeaderCell>
                            <TableHeaderCell>Published at</TableHeaderCell>
                            <TableHeaderCell>Featured</TableHeaderCell>
                            <TableHeaderCell v-if="hasPermission('edit post')">
                                Action
                            </TableHeaderCell>

                        </TableRow>
                    </template>

                    <template #default>
                        <TableRow v-for="post in posts" :key="post.id">
                            <TableDataCell>{{ post.id }}</TableDataCell>
                            <TableDataCell>
                                <img :src="post.thumbnail_url" class="w-8 h-8 mx-auto" />
                            </TableDataCell>
                            <TableDataCell>{{ post.title }}</TableDataCell>
                            <TableDataCell>{{ post.author.name }}</TableDataCell>
                            <TableDataCell>{{ post.published_at }}</TableDataCell>
                            <TableDataCell>{{ post.featured }}</TableDataCell>
                            <TableDataCell class="space-x-4">
                                <template v-if="hasPermission('edit post')">
                                    <Link :href="route('posts.edit', post.id)"
                                        class="text-green-400 hover:text-green-600">
                                    Edit
                                    </Link>
                                </template>

                                <template v-if="hasPermission('delete post')">
                                    <button @click="confirmDelete"
                                        class="text-red-400 hover:text-red-600">delete</button>
                                    <Modal :show="showConfirmDeleteModal" @close="closeModal">
                                        <div class="p-6">
                                            <h2 class="text-lg font-semibold text-slate-800">
                                                Are you sure to delete this?
                                            </h2>
                                            <div class="flex mt-6 space-x-4">
                                                <DangerButton @click="$event => deletePost(post.id)">Delete
                                                </DangerButton>
                                                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                            </div>
                                        </div>
                                    </Modal>
                                </template>
                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
            </div>
        </div>
    </AdminLayout>
</template>
