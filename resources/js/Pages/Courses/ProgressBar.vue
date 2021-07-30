<template>
    <div class="relative pt-1 mx-2">
        <div class="flex mb-2 items-center justify-between">
            <div>
            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 bg-green-200">
                {{percentage<100 ? 'Task in progress' : 'Task Completed' }}
            </span>
            </div>
            <div class="text-right">
            <span class="text-xs font-semibold inline-block text-green-600">
                {{percentage}}%
            </span>
            </div>
        </div>
        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-green-100">
            <div v-bind:style="'width:'+percentage+'%'" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500 transition-width duration-500 rounded"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['watchedEpisodes', 'episodes'],
    data() {
        return {
            watchedEpisodesData: this.watchedEpisodes
        }
    },
    computed: {
        percentage() {
            let filteredEpisodes = this.episodes.filter(courseEp => {
                return this.watchedEpisodesData.find(watchedEp => {
                    return watchedEp.id === courseEp.id;
                });
            });
            return Math.ceil(filteredEpisodes.length / this.episodes.length * 100);
        }
    },
    methods: {
        
    },
    mounted() {
        this.watchedEpisodesData = this.watchedEpisodes;
        eventBus.on('change-progress', data => {
            this.watchedEpisodesData = data;
        })
    }
}
</script>