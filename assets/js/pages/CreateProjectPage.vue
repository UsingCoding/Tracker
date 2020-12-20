<template>
  <div>
      <app-header></app-header>
      <create-project v-bind:factory="factory"></create-project>
  </div>
</template>

<script>
import header from "../components/Header";
import create_project from "../components/CreateProject";

export default {
    props: ['factory'],
    data(){
        return {}
    },
    components: {
        'app-header': header,
        'create-project': create_project
    },
    methods: {

    }
}
</script>

<style>

</style>