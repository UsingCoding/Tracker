<template>
  <div>
      <app-header></app-header>
      <project-info v-bind:factory="factory"></project-info>
  </div>
</template>

<script>
import header from "../components/Header";
import projectInfo from "../components/ProjectInfo";

export default {
    props: ['factory'],
    data(){
        return {}
    },
    components: {
        'app-header': header,
        'project-info': projectInfo
    },
    methods: {

    }

}
</script>

<style>

</style>