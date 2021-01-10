<template>
    <div>
        <app-header></app-header>
        <loader v-if="loading"></loader>
        <project-settings v-bind:loading="loading" v-bind:factory="factory"></project-settings>
    </div>
</template>

<script>
import header from "../components/Header";
import projectSettings from "../components/ProjectSettings";
import loader from "../components/Loader";

export default {
    props: ['factory'],
    data(){
        return {
            loading: true
        }
    },
    components: {
        'app-header': header,
        'project-settings': projectSettings,
        'loader': loader
    },
    methods: {

    }
}
</script>

<style>

</style>