<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    category: { type: Object, required: true }
});

const form = useForm({
    title: props.category?.title,
});

</script>

<template>

    <Head title="Edit Category" />

    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-between">
                <Link class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700"
                    :href="route('categories.index')">
                back
                </Link>
            </div>
            <div class="max-w-md p-6 mx-auto mt-6 rounded-lg shadow-lg bg-slate-100">
                <h1>Update Category</h1>
                <form @submit.prevent="form.put(route('categories.update', category.id))">
                    <div>
                        <InputLabel for="title" value="Title" />

                        <TextInput id="title" type="text" class="block w-full mt-1" v-model="form.title" autofocus />

                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>
                    <div class="flex items-center mt-4">
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Update
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
