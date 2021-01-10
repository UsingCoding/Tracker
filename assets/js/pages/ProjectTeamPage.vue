<template>
  <div>
      <app-header></app-header>
      <loader v-if="loading"></loader>
      <project-team v-bind:loading="loading" v-bind:factory="factory"></project-team>
  </div>
</template>

<script>
import header from "../components/Header";
import projectTeam from "../components/ProjectTeam";
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
        'project-team': projectTeam,
        'loader': loader
    },
    methods: {

    }
}
</script>

<style>

</style>