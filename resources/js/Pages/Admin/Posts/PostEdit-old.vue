<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    post: { type: Object, required: true }
});

const form = useForm({
    title: props.post?.title,
});
</script>

<template>

    <Head title="Edit Post" />

    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-between">
                <Link class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700"
                    :href="route('posts.index')">
                back
                </Link>
            </div>
            <div class="max-w-6xl p-6 mx-auto mt-6 rounded-lg shadow-lg bg-slate-100">
                <h1 class="text-2xl font-semibold text-indigo-700">Edit Post</h1>
                <form @submit.prevent="form.put(route('posts.update', post.id))">
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
