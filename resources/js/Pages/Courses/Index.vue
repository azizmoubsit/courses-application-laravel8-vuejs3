<template>
    <app-layout>
        <template #header>
            <div class="flex justify-between">
                <p>Courses list</p>
                <Link href="/course/create" class="bg-green-400 text-white p-1 rounded hover:bg-green-600" >Add new course</Link>
            </div>
        </template>
        <div class="py-3" v-for="course in courses.data" v-bind:key="course.id">
            <div class="mx-8 bg-white rounded shadow p-4">
                <div class="flex justify-between items-center">
                    <div class="text-lg">{{course.title}}</div>
                    <div class="text-sm text-gray">{{course.episodes_count}} episodes</div>
                </div>
                <div class="text-sm text-gray-500">{{course.description}}</div>
                <div class="flex justify-between items-center">
                    <div>
                        <Link :href="'course/'+course.id" class="bg-indigo-500 text-white mr-1 px-2 py-1 text-sm mt-3 rounded hover:bg-indigo-700 inline-block">Show Course</Link>
                        <Link v-if="course.update" :href="'course/edit/'+course.id" class="bg-blue-500 text-white px-2 py-1 text-sm mt-3 rounded hover:bg-blue-700 inline-block"><font-awesome-icon icon="edit"/></Link>
                    </div>
                    <div class="text-gray-400 text-sm">By <strong>{{course.user.name}}</strong> - <span class="text-sm text-gray-400">{{course.participants}} Participant<span v-if="course.participants>1">s</span></span></div>  
                </div>
            </div>    
        </div>
        <div class="mx-8 bg-white rounded shadow p-4 text-center text-blue-600">
            <Link :class="['border rounded mx-1 py-1 px-2', link.url ? 'bg-white' : 'bg-gray-200 text-white cursor-not-allowed', page == parseInt(link.label) ? 'bg-blue-600 text-white': '']" v-for="link in courseList.links" :href="link.url ? link.url : ''" v-bind:key="link.label">{{link.label}}</Link>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout.vue';
    import {Link} from '@inertiajs/inertia-vue3'
    
    export default {
        components: {
            AppLayout,
            Link,
        },
        props: ['courses', 'user'],
        data() {
            return {
                courseList: this.courses,
                page: null
            }
        },
        methods: {
            /* getVideoDurationFromUrl(url) {
                axios.get('https://www.googleapis.com/youtube/v3/videos?key=AIzaSyBGGIoR8wpNzECNNrw5qOKR_Ir9fpxsEwA&id=hccLteUCwT0&part=contentDetails')
                .then(response => { console.log(response.data.items[0].contentDetails.duration) })
                .catch(error => { console.log(error) });
                return 
            } */
        },
        mounted() {
            this.page = new URL(location.href).searchParams.get('page');
            console.log(this.page);
        }
    }
</script>

<style scoped>
    td {
        border: 1px solid;
    }
</style>