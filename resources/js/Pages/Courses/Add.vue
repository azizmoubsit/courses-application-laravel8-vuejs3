<template>
    <app-layout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add course
        </h2>
    </template>
    <div v-if="$page.props.flash.message" class="bg-green-200 text-green-700 py-3 px-5 rounded">
            {{ $page.props.flash.message }}
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full m-auto ">
                    <form class="bg-white shadow-md rounded p-6" @submit.prevent="submit">
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Course Title</label>
                            <input v-model="form.title" type="text" id="title" class="shadow apparence-none border rounded w-full py-2 px-3 text-gray-700 leading-light focus:outline-none focus:shadow-outline" placeholder="Title">
                            <p class="text-red-500 text-sm mt-1" v-if="$page.props.errors.title">{{ $page.props.errors.title }}</p>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Course Description</label>
                            <textarea v-model="form.description" id="description" class="shadow apparence-none border rounded w-full py-2 px-3 text-gray-700 leading-light focus:outline-none focus:shadow-outline" placeholder="Description"></textarea>
                            <p class="text-red-500 text-sm mt-1" v-if="$page.props.errors.description">{{ $page.props.errors.description }}</p>
                        </div>
                        <h1 class="text-2xl">Episodes</h1>
                        <div v-for="(episode, index) in form.episodes" v-bind:key="index">
                        <hr class="mb-4">
                            <div class="mb-4">
                                <label :for="'epTitle'+index" class="block text-gray-700 text-sm font-bold mb-2">Episode title N°{{index+1}}</label>
                                <input v-model="form.episodes[index].title" type="text" :id="'epTitle'+index" class="shadow apparence-none border rounded w-full py-2 px-3 text-gray-700 leading-light focus:outline-none focus:shadow-outline" placeholder="Title">
                                <p class="text-red-500 text-sm mt-1" v-if="$page.props.errors['episodes.'+index+'.title']">{{ $page.props.errors['episodes.'+index+'.title'] }}</p>
                            </div>
                            <div class="mb-4">
                                <label :for="'epDescriptoin'+index" class="block text-gray-700 text-sm font-bold mb-2">Episode description N°{{index+1}}</label>
                                <textarea v-model="form.episodes[index].description" :id="'epDescriptoin'+index" class="shadow apparence-none border rounded w-full py-2 px-3 text-gray-700 leading-light focus:outline-none focus:shadow-outline" placeholder="Description"></textarea>
                                <p class="text-red-500 text-sm mt-1" v-if="$page.props.errors['episodes.'+index+'.description']">{{ $page.props.errors['episodes.'+index+'.description'] }}</p>
                            </div>
                            <div class="mb-4">
                                <label :for="'video_url'+index" class="block text-gray-700 text-sm font-bold mb-2">Video url N°{{index+1}}</label>
                                <input v-model="form.episodes[index].video_url" type="text" :id="'video_url'+index" class="shadow apparence-none border rounded w-full py-2 px-3 text-gray-700 leading-light focus:outline-none focus:shadow-outline" placeholder="Video url">
                                <p class="text-red-500 text-sm mt-1" v-if="$page.props.errors['episodes.'+index+'.video_url']">{{ $page.props.errors['episodes.'+index+'.video_url'] }}</p>
                            </div>
                            <div v-if="form.episodes.length > 1" class="mb-4">
                                <button @click="remove(index)" class="bg-red-400 text-white p-2 rounded">
                                    Remove <font-awesome-icon icon="trash" />
                                </button>
                            </div>
                        </div>
                        <div class="mb-4">
                            <button class="bg-green-400 text-white hover:bg-green-500 block rounded p-2" @click.prevent="add">
                                Add an other episode <font-awesome-icon icon="plus" />
                            </button>
                        </div>
                        <div>
                            <button :disabled="form.processing" class="w-full bg-blue-500 rounded p-2 text-white hover:bg-blue-600">Create course</button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout.vue'
    import { Inertia } from '@inertiajs/inertia'


    export default {
        data() {
            return{
                form: {
                    title: null,
                    description: null,
                    episodes: [{
                        title: null,
                        description: null,
                        video_url: null,
                    }]
                }
            }
        },
        components: {
            AppLayout,
        },
        methods :{
            submit() {
                Inertia.post('/course/create', this.form);
            },
            add() {
                this.form.episodes.push({
                        title: null,
                        description: null,
                        video_url: null,
                    });
            },
            remove(index) {
                this.form.episodes.splice(index, 1);
            }
        },
        mounted() {
        }
    }
</script>