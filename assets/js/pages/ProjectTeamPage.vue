<template>
  <div>
      <app-header></app-header>
      <project-team v-bind:factory="factory"></project-team>
  </div>
</template>

<script>
import header from "../components/Header";
import projectTeam from "../components/ProjectTeam";

export default {
    props: ['factory'],
    data(){
        return {}
    },
    components: {
        'app-header': header,
        'project-team': projectTeam
    },
    methods: {

    }
}
</script>

<style>

</style>