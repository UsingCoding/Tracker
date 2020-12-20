<template>
  <div>
      <app-header></app-header>
      <project-fields v-bind:factory="factory"></project-fields>
  </div>
</template>

<script>
import header from "../components/Header";
import projectFields from "../components/ProjectFields";

export default {
    props: ['factory'],
    data(){
        return {}
    },
    components: {
        'app-header': header,
        'project-fields': projectFields
    },
    methods: {

    }
}
</script>

<style>

</style>