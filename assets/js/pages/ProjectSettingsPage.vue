<template>
  <div>
      <app-header></app-header>
      <project-settings v-bind:factory="factory"></project-settings>
  </div>
</template>

<script>
import header from "../components/Header";
import projectSettings from "../components/ProjectSettings";

export default {
    props: ['factory'],
    data(){
        return {}
    },
    components: {
        'app-header': header,
        'project-settings': projectSettings
    },
    methods: {

    }
}
</script>

<style>

</style>