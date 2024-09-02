<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from "vue";
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { onMounted, watch } from 'vue';

import VueMultiselect from 'vue-multiselect';

const props = defineProps({
    post: { type: Object, required: true },
    categories: Array,
});

const form = useForm({
    title: props.post?.title || '',
    image: null,
    body: props.post?.body || '',
    categories: props.post?.categories || [],
    featured: props.post?.featured || false,
    _method: 'PUT'
});


const imagePreviewUrl = ref(props.post?.thumbnail_url || ''); // Assuming `image` is the URL of the existing image


function submit() {
    form.post(route('posts.update', props.post))
}

function handleFileChange(event) {
    form.image = event.target.files[0];

    if (form.image) {
        imagePreviewUrl.value = URL.createObjectURL(form.image);
    }
}



</script>

<template>

    <Head title="Create New Post" />

    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-between">
                <Link class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700"
                    :href="route('posts.index')">
                back
                </Link>
            </div>
            <div class="max-w-6xl p-6 mx-auto mt-6 rounded-lg shadow-lg bg-slate-100">
                <h1 class="text-2xl font-semibold text-indigo-700">Update Post {{ post.id }}</h1>
                <form @submit.prevent="submit">

                    <div>
                        <InputLabel for="title" value="Title" />

                        <TextInput id="title" type="text" class="block w-full mt-1" v-model="form.title" autofocus />

                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>

                    <div class="mt-4">
                        <label for="body">Body</label>

                        <textarea id="body" v-model="form.body" name="body"
                            class="w-full px-3 py-2 border border-gray-300 border-solid rounded-md resize-none dark:bg-gray-900 dark:border-none focus:outline-none "
                            placeholder="Type Body...*" rows="5" required></textarea>
                        <!-- <Editor id="body" v-model="form.body" style="height: 320px" /> -->
                    </div>

                    <div class="mt-4">
                        <div class="inline-flex items-center">
                            <label class="relative flex items-center p-3 rounded-full cursor-pointer" for="ripple-on"
                                data-ripple-dark="true">
                                <input id="ripple-on" type="checkbox" v-model="form.featured"
                                    class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-md border border-blue-gray-200 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-pink-500 checked:bg-pink-500 checked:before:bg-pink-500 hover:before:opacity-10" />
                                <div
                                    class="absolute text-white transition-opacity opacity-0 pointer-events-none top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 peer-checked:opacity-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                        fill="currentColor" stroke="currentColor" stroke-width="1">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </label>
                            <label class="mt-px font-light text-gray-700 cursor-pointer select-none" for="ripple-on">
                                Is Featured
                            </label>
                        </div>

                    </div>

                    <div class="mt-4">
                        <InputLabel for="categories" value="Categories" />

                        <VueMultiselect :id="categories" v-model="form.categories" :options="categories"
                            :multiple="true" :close-on-select="true" :invalid="form.errors.categories"
                            placeholder="pick some" label="title" track-by="id" />


                    </div>

                    <div class="mt-4">
                        <img v-if="imagePreviewUrl" :src="imagePreviewUrl" class="max-w-xs mt-4 max-h-xs"
                            alt="Image preview" />

                        <input type="file" @change="handleFileChange" />
                    </div>

                    <div class="flex items-center mt-4">
                        <PrimaryButton class="ms-4" :disabled="form.processing">
                            Update
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
