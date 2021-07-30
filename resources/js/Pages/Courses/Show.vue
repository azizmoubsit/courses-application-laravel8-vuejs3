<template>
    <app-layout>
        <template #header>{{course.title}}</template>
        <div class="py-4">
            <div class="mx-2 bg-white rounded shadow p-4">
                <div class="flex justify-between">
                    <strong>Title : {{course.title}}</strong>
                    <div class="text-sm text-gray-300">
                        By <strong>{{course.user.name}}</strong>
                    </div>
                </div>
                <p><u>Description</u> : {{course.description}}</p>
                <hr class="mt-4 mb-4">

                <p class="mt-4 mb-4">Episode {{(episodeIndex+1) + ' : ' + course.episodes[this.episodeIndex].title}}</p>
                <iframe class="w-full h-screen" :src="course.episodes[this.episodeIndex].video_url" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        <div class="bg-white rounded p-4 mx-2">
            <h1 class="mx-2 text-2xl text-center">Episodes</h1>
            <hr>
            <progress-bar v-bind:watched-episodes="this.watchedEpisodes" :episodes="course.episodes"/>
            <div class="mx-2">
                <ul v-for="(episode, index) in course.episodes" :key="episode.id">
                    <li class="mt-6 flex justify-between items-center">
                        <div>
                            <div>Episode {{index + 1 + ' : ' + episode.title}}</div>
                        <button class="text-gray-500 focus:text-indigo-500" @click="switchEpisode(index)">Show episode</button>
                        </div>
                        <progress-button @change-progress="changed($event)" :episode-id="episode.id" :watched-episodes="this.watchedEpisodes"/>
                    </li>
                </ul>
                
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from './../../Layouts/AppLayout.vue';
import ProgressButton from './ProgressButton.vue';
import ProgressBar from './ProgressBar.vue';

export default {
    props: ['course', 'watched'],
    components: {
        AppLayout,
        ProgressButton,
        ProgressBar,
    },
    data() {
        return{
            episodeIndex: 0,
            watchedEpisodes: this.watched
        }
    },
    methods: {
        switchEpisode(index) {
            this.episodeIndex = index;
            window.scroll({
                top: 0,
                left: 0,
                behavior: 'smooth'
            });
        },
        changed(data) {
            this.watchedEpisodes = data;
        },
    },
    mounted() {
        
    }
    
}
</script>
