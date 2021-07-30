<template>
    <div>
        <button class="rounded p-1 text-white" :class="this.isWatched ? 'bg-red-200' : 'bg-green-500'" @click="toggleProgress()">
            <font-awesome-icon :icon="this.isWatched ? 'times-circle' : 'check'" />
        </button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['episodeId', 'watchedEpisodes'],
    data() {
        return{
            watchedEp: this.watchedEpisodes,
            isWatched: null,
        }
    },
    methods: {
        toggleProgress() {
            axios.post('/toggle-progress', {
                episodeId: this.episodeId,
            })
            .then(response => {
                if(response.status===200){
                    this.isWatched = !this.isWatched;
                    eventBus.emit('change-progress', response.data);
                }
            })
            .catch(error => console.log(error));
        },
        isWatchedEpisode() {
            return this.watchedEp.find(episode => episode.id === this.episodeId) ? true : false
        }
    },
    mounted() {
        this.isWatched = this.isWatchedEpisode();
    }
}
</script>
